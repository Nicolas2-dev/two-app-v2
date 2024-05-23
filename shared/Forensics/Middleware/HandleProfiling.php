<?php
/**
 * @author  Nicolas Devoy
 * @email   nicolas@nicodev.fr 
 * @version 1.0.0
 * @date    15 Fevrier 2023
 */
namespace Shared\Forensics\Middleware;

use Closure;
use PDOException;

use Two\Application\Two;
use Two\Http\Response;
use Two\Support\Str;

use Shared\Forensics\Profiler;

use Symfony\Component\HttpFoundation\Request as SymfonyRequest;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;



class HandleProfiling
{
    /**
     * La mise en œuvre de l'application.
     *
     * @var \Two\Application\Two
     */
    protected $app;


    /**
     * Créez une nouvelle instance de middleware.
     *
     * @param  \Two\Application\Two  $app
     * @return void
     */
    public function __construct(Two $app)
    {
        $this->app = $app;
    }

    /**
     * Traitez la demande donnée et obtenez la réponse.
     *
     * @param  $request
     * @param  $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request, $next);

        // Ajoutez les profileurs au contenu de l'instance de réponse.
        $config = $this->app['config'];

        // Obtenez l'indicateur de débogage de la configuration.
        $debug = $config->get('app.debug', false);

        if ($debug && $this->canPatchContent($response)) {
            $withDatabase = $config->get('profiler.withDatabase', false);

            $content = str_replace(
                array(
                    '<!-- DO NOT DELETE! - Profiler -->',
                    '<!-- DO NOT DELETE! - Statistics -->',
                ),
                array(
                    Profiler::process(true),
                    $this->getStatistics($request, $withDatabase),
                ),
                $response->getContent()
            );

            //
            $response->setContent($content);
        }

        return $response;
    }

    /**
     * [canPatchContent description]
     *
     * @param   SymfonyResponse  $response  [$response description]
     *
     * @return  [type]                      [return description]
     */
    protected function canPatchContent(SymfonyResponse $response)
    {
        if ((! $response instanceof Response) && is_subclass_of($response, 'Symfony\Component\Http\Foundation\Response')) {
            return false;
        }

        $contentType = $response->headers->get('Content-Type');

        return Str::is('text/html*', $contentType);
    }

    /**
     * [getStatistics description]
     *
     * @param   SymfonyRequest  $request       [$request description]
     * @param   [type]          $withDatabase  [$withDatabase description]
     *
     * @return  [type]                         [return description]
     */
    protected function getStatistics(SymfonyRequest $request, $withDatabase)
    {
        $requestTime = $request->server('REQUEST_TIME_FLOAT');

        $elapsedTime = sprintf("%01.4f", (microtime(true) - $requestTime));

        //
        $memoryUsage = static::formatSize(memory_get_usage());

        //
        $umax = sprintf("%0d", intval(25 / $elapsedTime));

        if (! $withDatabase) {
            return __d('shared', 'Elapsed Time: <b>{0}</b> sec | Memory Usage: <b>{1}</b> | UMAX: <b>{2}</b>', $elapsedTime, $memoryUsage, $umax);
        }

        $queryLog = $this->getQueryLog();

        $queries = count($queryLog);

        return __d('shared', 'Elapsed Time: <b>{0}</b> sec | Memory Usage: <b>{1}</b> | SQL: <b>{2}</b> {3, plural, one{query} other{queries}} | UMAX: <b>{4}</b>', $elapsedTime, $memoryUsage, $queries, $queries, $umax);
    }

    /**
     * [getQueryLog description]
     *
     * @return  [type]  [return description]
     */
    protected function getQueryLog()
    {
        try {
            $connection = $this->app['db']->connection();

            return $connection->getQueryLog();
        }
        catch (PDOException $e) {
            return array();
        }
    }

    /**
     * [formatSize description]
     *
     * @param   [type]  $bytes     [$bytes description]
     * @param   [type]  $decimals  [$decimals description]
     *
     * @return  [type]             [return description]
     */
    protected static function formatSize($bytes, $decimals = 2)
    {
        $size = array('B','kB','MB','GB','TB','PB','EB','ZB','YB');

        $factor = floor((strlen($bytes) - 1) / 3);

        return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) .@$size[$factor];
    }
}
