<?php
/**
 * Two - Pages
 *
 * @author  Nicolas Devoy
 * @email   nicolas@nicodev.fr 
 * @version 1.0.0
 * @date    15 Fevrier 2023
 */
namespace App\Controllers;

use App\Controllers\BaseController;

use Two\Support\Facades\View;
use Two\Support\Str;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class Pages extends BaseController
{
    /**
     * Le thème actuellement utilisé.
     *
     * @var string
     */
    protected $theme = false; // Désactivez la prise en charge des thèmes.

    /**
     * La mise en page actuellement utilisée.
     *
     * @var string
     */
    protected $layout = 'Static';


    public function show($slug = null)
    {
        $segments = array();

        if (! empty($slug)) {
            $segments = explode('/', $slug, 2);
        }

        // Calculez la page et la sous-page.
        list ($page, $subPage) = array_pad($segments, 2, null);

        // Calculez le nom complet de la vue, i.n. 'à propos de nous' -> 'Pages/À propos de nous'
        array_unshift($segments, 'pages');

        $view = implode('/', array_map(function ($value)
        {
            return Str::studly($value);

        }, $segments));

        if (View::exists($view)) {
            // Nous avons trouvé une vue appropriée pour l'URI donné.
        }

        // Nous chercherons une vue d'accueil avant d'aller Exception.
        else if (! View::exists($view = $view .'/Home')) {
            throw new NotFoundHttpException($view);
        }

        $title = Str::title(
            str_replace(array('-', '_'), ' ', $subPage ?: ($page ?: 'Home'))
        );

        //toto();
        
        return View::make($view)->shares('title', $title);
    }
}
