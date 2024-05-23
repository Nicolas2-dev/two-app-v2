<?php
/**
 * Console
 * @author  Nicolas Devoy
 * @email   nicolas@nicodev.fr 
 * @version 1.0.0
 * @date    15 Fevrier 2023
 */
namespace Shared\Forensics;


class Console
{
    /*
     * Contient tous les journaux collectés.
     */
    private static $logs = array(
        'console'     => array(),
        'logCount'    => 0,
        'memoryCount' => 0,
        'errorCount'  => 0,
        'speedCount'  => 0,
    );

    /*
     * Enregistrez une variable sur la console.
     */
    public static function log($data)
    {
        $logItem = array(
            "data" => $data,
            "type" => 'log'
        );

        self::$logs['console'][] = $logItem;

        self::$logs['logCount'] += 1;
    }

    /*
     * Enregistrez l’utilisation de la mémoire d’une variable ou d’un script entier.
     */
    public static function logMemory($object = false, $name = 'PHP')
    {
        $memory = memory_get_usage();

        if($object) $memory = strlen(serialize($object));

        $logItem = array(
            "data" => $memory,
            "type" => 'memory',
            "name" => $name,
            "dataType" => gettype($object)
        );

        self::$logs['console'][] = $logItem;

        self::$logs['memoryCount'] += 1;
    }

    /*
     * Enregistrez un objet d'exception php.
     */
    public static function logError($exception, $message)
    {
        $logItem = array(
            "data" => $message,
            "type" => 'error',
            "file" => $exception->getFile(),
            "line" => $exception->getLine()
        );

        self::$logs['console'][] = $logItem;

        self::$logs['errorCount'] += 1;
    }

    /*
     * Instantané de vitesse à un moment donné.
     */
    public static function logSpeed($name = 'Point in Time')
    {
        $logItem = array(
            "data" => microtime(true),
            "type" => 'speed',
            "name" => $name
        );

        self::$logs['console'][] = $logItem;

        self::$logs['speedCount'] += 1;
    }

    /*
     * Renvoyez les journaux.
     */
    public static function getLogs()
    {
        return self::$logs;
    }

}
