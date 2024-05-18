<?php
/**
 * Two - Handler
 *
 * @author  Nicolas Devoy
 * @email   nicolas@nicodev.fr 
 * @version 1.0.0
 * @date    15 Fevrier 2023
 */
namespace App\Platform\Exceptions;

use Exception;

use Two\Http\Request;
use Two\Support\Facades\View;
use Two\Support\Facades\Config;
use Two\Support\Facades\Redirect;
use Two\Support\Facades\Response;
use Two\Exceptions\TwoHandlerExecption;
use Two\Session\Execption\TokenMismatchException;
use Two\Exceptions\Exception\FlattenException;
use Two\Auth\Exception\AuthenticationException;

use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

use Whoops\Run as WhoopsRun;
use Whoops\Handler\PrettyPageHandler as WhoopsPrettyPageHandler;
use Whoops\Handler\JsonResponseHandler as WhoopsJsonResponseHandler;


class AppHandler extends TwoHandlerExecption
{
    /**
     * Une liste des types d'exception qui ne doivent pas être signalés.
     *
     * @var array
     */
    protected $dontReport = array(
        'Two\Auth\Exception\AuthenticationException',
        'Two\Database\ORM\ModelNotFoundException',
        'Two\Session\TokenMismatchException',
        'Two\Validation\ValidationException',
        'Symfony\Component\HttpKernel\Exception\HttpException',
    );

    /**
     * Une liste des entrées qui ne sont jamais flashées pour les exceptions de validation.
     *
     * @var array
     */
    protected $dontFlash = array(
        'password',
        'password_confirmation',
    );


    /**
     * Signaler ou consigner une exception.
     *
     * @param  \Exception  $e
     * @return void
     */
    public function report(Exception $e)
    {
        return parent::report($e);
    }

    /**
     * Rendre une exception dans une réponse HTTP.
     *
     * @param  \Two\Http\Request  $request
     * @param  \Exception  $e
     * @return \Two\Http\Response
     */
    public function render(Request $request, Exception $e)
    {
        if ($e instanceof TokenMismatchException) {
            return Redirect::back()
                ->withInput($request->except($this->dontFlash))
                ->with('danger', __('Validation Token has expired. Please try again!'));
        }

        return parent::render($request, $e);
    }

    /**
     * Restituez l'exception HttpException donnée.
     *
     * @param  \Symfony\Component\HttpKernel\Exception\HttpException  $e
     * @param  \Two\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function renderHttpException(HttpException $e, Request $request)
    {
        if (! is_null($response = $this->createErrorResponse($e, $request))) {
            return $response;
        }

        return parent::renderHttpException($e, $request);
    }

    /**
     * Convertissez l'exception donnée en une instance Response qui contient une page d'erreur.
     *
     * @param  \Symfony\Component\HttpKernel\Exception\HttpException  $e
     * @param  \Two\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function createErrorResponse(HttpException $e, Request $request)
    {
        $e = FlattenException::create($e, $status = $e->getStatusCode());

        if ($this->isAjaxRequest($request)) {
            return Response::json($e->toArray(), $status, $e->getHeaders());
        }

        //
        else if (! View::exists("Errors/{$status}")) {
            return;
        }

        $view = View::make('Layouts/Default')
            ->shares('title', "Error {$status}")
            ->nest('content', "Errors/{$status}", array('exception' => $e));

        return Response::make($view->render(), $status, $e->getHeaders());
    }

    /**
     * Renvoie true si l'instance Request donnée est AJAX.
     *
     * @param  \Two\Http\Request  $request
     * @return bool
     */
    protected function isAjaxRequest(Request $request)
    {
        return ($request->ajax() || $request->wantsJson());
    }

    /**
     * Convertissez l'exception donnée en une instance Response.
     *
     * @param  \Exception  $e
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function convertExceptionToResponse(Exception $e, Request $request)
    {
        if (! Config::get('app.debug', false)) {
            $exception = new HttpException(500, 'Internal Server Error');

            return $this->createErrorResponse($exception, $request);
        }

        if (Config::get('app.exception_render') == 'php') {
            return parent::convertExceptionToResponse($e, $request);
        }
        else if (Config::get('app.exception_render') == 'whoops') {
            return $this->renderExceptionWithWhoops($e, $request);
        }
    }

    /**
     * Restituez une exception à une chaîne en utilisant "Whoops".
     *
     * @param  \Exception  $e
     * @param  \Two\Http\Request  $request
     * @return string
     */
    protected function renderExceptionWithWhoops(Exception $e, Request $request)
    {
        $whoops = new WhoopsRun();

        // Nous demanderons à Whoops de ne pas quitter après avoir affiché l'exception telle qu'elle
        // s'épuisera autrement avant que nous puissions faire quoi que ce soit d'autre. Nous voulons 
        // juste laissez le framework aller de l'avant et terminez une requête à cette fin à la place.
        $whoops->allowQuit(false);
        $whoops->writeToOutput(false);

        if ($this->isAjaxRequest($request)) {
            $handler = new WhoopsJsonResponseHandler();
        } else {
            $handler = new WhoopsPrettyPageHandler();

            $handler->setEditor('sublime');
        }

        $whoops->pushHandler($handler);

        if ($e instanceof HttpExceptionInterface) {
            $status  = $e->getStatusCode();
            $headers = $e->getHeaders();
        } else {
            $status  = 500;
            $headers = array();
        }

        return Response::make($whoops->handleException($e), $status, $headers);
    }

    /**
     * Convertir une exception d'authentification en une réponse non authentifiée.
     *
     * @param  \Two\Http\Request  $request
     * @param  \Two\Auth\Exception\AuthenticationException  $exception
     * @return \Two\Http\Response
     */
    protected function unauthenticated(Request $request, AuthenticationException $exception)
    {
        if ($this->isAjaxRequest($request) || $request->is('api/*')) {
            return Response::json(array('error' => 'Unauthenticated.'), 401);
        }

        $guards = $exception->guards();

        // Nous allons utiliser la première garde.
        $guard = array_shift($guards);

        $uri = Config::get("auth.guards.{$guard}.paths.authorize", 'login');

        return Redirect::guest($uri);
    }
}

