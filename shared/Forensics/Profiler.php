<?php
/**
 * Profiler
 * @author  Nicolas Devoy
 * @email   nicolas@nicodev.fr 
 * @version 1.0.0
 * @date    15 Fevrier 2023
 */
namespace Shared\Forensics;

use PDO;
use Exception;

use Two\Support\Facades\DB;
use Two\Database\Connection;
use Two\Support\Facades\Config;
use Two\Support\Facades\Request;

use Shared\Forensics\Console;
use Shared\Forensics\PdoDebugger;


class Profiler
{
    /**
     * [$connection description]
     *
     * @var [type]
     */
    protected $connection;

    /**
     * [$viewPath description]
     *
     * @var [type]
     */
    protected $viewPath;
    
    /**
     * [$startTime description]
     *
     * @var [type]
     */
    protected $startTime;

    /**
     * [$output description]
     *
     * @var [type]
     */
    public $output = array();


    /**
     * [__construct description]
     *
     * @param   [type]  $connection  [$connection description]
     *
     * @return  [type]               [return description]
     */
    public function __construct($connection = null)
    {
        $config = Config::get('profiler');

        if ($config['useForensics'] != true) {
            return;
        }

        if($connection instanceof Connection) {
            $this->connection = $connection;
        } else if($config['withDatabase'] == true) {
            $this->connection = DB::connection();
        }

        // Configurez le chemin d'accès à la vue.
        $this->viewPath = realpath(__DIR__) .DS .'Views' .DS .'Profiler.php';

        // Configurez l'heure de début.
        $this->startTime = Request::server('REQUEST_TIME_FLOAT');
    }

    public static function process($fetch = false)
    {
        $config = Config::get('profiler');

        if ($config['useForensics'] != true) {
            return null;
        }

        // Le QuickProfiller a été activé dans la configuration.
        $profiler = new static();

        return $profiler->display($fetch);
    }

    /*
     * Formatez les différents types de journaux.
     */
    public function gatherConsoleData()
    {
        $logs = Console::getLogs();

        if(isset($logs['console'])) {
            foreach($logs['console'] as $key => $log) {
                if($log['type'] == 'log') {
                    $logs['console'][$key]['data'] = print_r($log['data'], true);
                }
                else if($log['type'] == 'memory') {
                    $logs['console'][$key]['data'] = $this->getReadableFileSize($log['data']);
                }
                else if($log['type'] == 'speed') {
                    $logs['console'][$key]['data'] = $this->getReadableTime(($log['data'] - $this->startTime) * 1000);
                }
            }
        }

        $this->output['logs'] = $logs;
    }

    /*
     * Données agrégées sur les fichiers inclus.
     */
    public function gatherFileData()
    {
        $files = get_included_files();

        $fileList = array();

        $fileTotals = array(
            "count" => count($files),
            "size" => 0,
            "largest" => 0,
        );

        foreach($files as $key => $file) {
            $size = filesize($file);

            $fileList[] = array(
                'name' => str_replace(BASEPATH, '/', $file),
                'size' => $this->getReadableFileSize($size)
            );

            $fileTotals['size'] += $size;

            if($size > $fileTotals['largest']) $fileTotals['largest'] = $size;
        }

        $fileTotals['size'] = $this->getReadableFileSize($fileTotals['size']);
        $fileTotals['largest'] = $this->getReadableFileSize($fileTotals['largest']);

        $this->output['files'] = $fileList;
        $this->output['fileTotals'] = $fileTotals;
    }

    /*
     * Utilisation de la mémoire et mémoire disponible.
     */
    public function gatherMemoryData()
    {
        $memoryTotals = array();

        $memoryTotals['used'] = $this->getReadableFileSize(memory_get_peak_usage());

        $memoryTotals['total'] = ini_get("memory_limit");

        $this->output['memoryTotals'] = $memoryTotals;
    }

    /*
     * QUERY DATA – Objet de base de données avec journalisation requise
     */
    public function gatherSQLQueryData()
    {
        $queryTotals = array();

        $queryTotals['count'] = 0;
        $queryTotals['time'] = 0;

        $queries = array();

        if(isset($this->connection)) {
            $queryLog = $this->connection->getQueryLog();

            $queryTotals['count'] += count($queryLog);

            foreach($queryLog as $query) {
                if(isset($query['bindings']) && ! empty($query['bindings'])) {
                    $query['sql'] = PdoDebugger::show($query['query'], $query['bindings']);
                } else {
                    $query['sql'] = $query['query'];
                }

                $query = $this->attemptToExplainQuery($query);

                $queryTotals['time'] += $query['time'];

                $query['time'] = $this->getReadableTime($query['time']);

                //
                $queries[] = $query;
            }
        }

        $queryTotals['time'] = $this->getReadableTime($queryTotals['time']);

        $this->output['queries'] = $queries;
        $this->output['queryTotals'] = $queryTotals;
    }

    /*
     * Appelez SQL EXPLAIN sur la requête pour trouver plus d'informations.
     */
    function attemptToExplainQuery($query)
    {
        try {
            $statement = $this->connection->getPdo()->prepare('EXPLAIN ' .$query['query']);

            if($statement !== false) {
                $statement->execute();

                $query['explain'] = $statement->fetch(PDO::FETCH_ASSOC);
            }
        }
        catch(Exception $e) {
            // Ne fais rien.
        }

        return $query;
    }

    /*
     * Accélérez les données pour le chargement complet de la page.
     */
    public function gatherSpeedData()
    {
        $speedTotals = array();

        $speedTotals['total'] = $this->getReadableTime((microtime(true) - $this->startTime) * 1000);
        $speedTotals['allowed'] = ini_get("max_execution_time");

        $this->output['speedTotals'] = $speedTotals;
    }

    /*
     * Variables du serveur et configuration.
     */
    public function gatherFrameworkData()
    {
        $output = array();

        // OBTENIR des variables
        if (count($_GET) == 0) {
            $output['get'] = __d('shared', 'No GET data exists');
        } else {
            $output['get'] = array();

            foreach ($_GET as $key => $value) {
                if (! is_numeric($key)) {
                    $key = "'".$key."'";
                }

                if (is_array($value)) {
                    $output['get']['&#36;_GET['. $key .']'] = '<pre>'. htmlspecialchars(stripslashes(print_r($value, TRUE))) .'</pre>';
                } else {
                    $output['get']['&#36;_GET['. $key .']'] = htmlspecialchars(stripslashes($value));
                }
            }
        }

        // Variables POST
        if (count($_POST) == 0) {
            $output['post'] = __d('shared', 'No POST data exists');
        } else {
            $output['post'] = array();

            foreach ($_POST as $key => $value) {
                if (! is_numeric($key)) {
                    $key = "'".$key."'";
                }

                if (is_array($value)) {
                    $output['post']['&#36;_POST['. $key .']'] = '<pre>'. htmlspecialchars(stripslashes(print_r($value, TRUE))) .'</pre>';
                } else {
                    $output['post']['&#36;_POST['. $key .']'] = htmlspecialchars(stripslashes($value));
                }
            }
        }

        // En-têtes de serveur
        $output['headers'] = array();

        $headers = array(
            'HTTP_ACCEPT',
            'HTTP_USER_AGENT',
            'HTTP_CONNECTION',
            'SERVER_PORT',
            'SERVER_NAME',
            'REMOTE_ADDR',
            'SERVER_SOFTWARE',
            'HTTP_ACCEPT_LANGUAGE',
            'SCRIPT_NAME',
            'REQUEST_METHOD',
            ' HTTP_HOST',
            'REMOTE_HOST',
            'CONTENT_TYPE',
            'SERVER_PROTOCOL',
            'QUERY_STRING',
            'HTTP_ACCEPT_ENCODING',
            'HTTP_X_FORWARDED_FOR'
        );

        foreach ($headers as $header) {
            $value = (isset($_SERVER[$header])) ? $_SERVER[$header] : '';

            $output['headers'][$header] = $value;
        }

        // Stockez les informations.
        $this->output['variables'] = $output;
    }

    /*
     * Fonctions d'assistance pour formater les données.
     */
    public function getReadableFileSize($size, $result = null)
    {
        // Adapté du code de http://aidanlister.com/repos/v/function.size_readable.php
        $sizes = array('bytes', 'kB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');

        if ($result === null) $result = '%01.2f %s';

        $lastSizeStr = end($sizes);

        foreach ($sizes as $sizeStr) {
            if ($size < 1024) break;

            if ($sizeStr != $lastSizeStr) $size /= 1024;
        }

        // Les octets ne sont normalement pas fractionnaires
        if ($sizeStr == $sizes[0]) $result = '%01d %s';  

        return sprintf($result, $size, $sizeStr);
    }

    /**
     * [getReadableTime description]
     *
     * @param   [type]  $time  [$time description]
     *
     * @return  [type]         [return description]
     */
    public function getReadableTime($time)
    {
        $ret = $time;
        $formatter = 0;

        $formats = array('ms', 's', 'm');

        if(($time >= 1000) && ($time < 60000)) {
            $formatter = 1;

            $ret = ($time / 1000);
        }

        if($time >= 60000) {
            $formatter = 2;

            $ret = ($time / 1000) / 60;
        }

        return number_format($ret, 3, '.', '') .' ' .$formats[$formatter];
    }

    /*
     * Afficher à l'écran (ou renvoyer) la sortie de rendu.
     */
    public function display($fetch = false)
    {
        Console::log(__d('shared', 'Forensics - Profiler start gathering the information'));

        // Rassemblez les informations.
        $this->gatherFileData();
        $this->gatherMemoryData();
        $this->gatherSQLQueryData();
        $this->gatherFrameworkData();

        Console::logSpeed(__d('shared', 'Forensics - Profiler start displaying the information'));

        $this->gatherConsoleData();
        $this->gatherSpeedData();

        // Afficher le widget du Profiler.
        return $this->render($this->output, $fetch);
    }

    /*
     * Sortie HTML pour PHP Quick Profiler
     */
    function render($output, $fetch)
    {
        // Préparez les informations.
        $logCount = count($output['logs']['console']);
        $fileCount = count($output['files']);

        $memoryUsed = $output['memoryTotals']['used'];
        $queryCount = $output['queryTotals']['count'];
        $speedTotal = $output['speedTotals']['total'];

        // Rendre le fragment de vue associé (et renvoyer la sortie, si c'est le cas).
        if($fetch) {
            ob_start();
        }

        require $this->viewPath;

        if($fetch) {
            return ob_get_clean();
        }

        return true;
    }
}
