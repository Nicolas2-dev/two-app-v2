<?php

namespace Modules\TwoCore\Core;


use Modules\TwoCore\Core\BaseController;


abstract class FrontController extends BaseController
{
    /**
     * Le thème actuellement utilisé.
     *
     * @var string
     */
    protected $theme = 'TwoBoost';

    /**
     * La mise en page actuellement utilisée.
     *
     * @var string
     */
    protected $layout = 'Default';


    /**
     * Method executed before any action.
     */
    protected function initialize()
    {
        parent::initialize();
    }  

}
