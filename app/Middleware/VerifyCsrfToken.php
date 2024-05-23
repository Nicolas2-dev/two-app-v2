<?php
/**
 * Two - VerifyCsrfToken
 *
 * @author  Nicolas Devoy
 * @email   nicolas@nicodev.fr 
 * @version 1.0.0
 * @date    15 Fevrier 2023
 */
namespace App\Middleware;

use Two\Application\Middleware\Http\VerifyCsrfToken as BaseVerifier;


class VerifyCsrfToken extends BaseVerifier
{
    /**
     * Les URI qui doivent être exclus de la vérification CSRF.
     *
     * @var array
     */
    protected $except = array(
        'admin/files/connector',
    );
}
