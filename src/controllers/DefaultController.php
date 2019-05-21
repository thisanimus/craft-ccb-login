<?php
/**
 * craft-ccb-login plugin for Craft CMS 3.x
 *
 * Log in via the CCB API, and log user info in session.
 *
 * @link      thisanimus.com
 * @copyright Copyright (c) 2019 Andrew Hale
 */

namespace countrysidebible\craftccblogin\controllers;

use countrysidebible\craftccblogin\Craftccblogin;

use Craft;
use countrysidebible\craftccblogin\services\API;
use craft\web\Controller;
use yii\web\Response;

/**
 *
 * https://craftcms.com/docs/plugins/controllers
 *
 * @author    Andrew Hale
 * @package   Craftccblogin
 * @since     1.0.5
 */
class DefaultController extends Controller
{

    /**
     * @var    bool|array Allows anonymous access to this controller's actions.
     *         The actions must be in 'kebab-case'
     * @access protected
     */
    //protected $allowAnonymous = ['index', 'do-something'];

    /**
     *
     * @return mixed
     */
    public function actionIndex()
    {   
        $ccb = new API;
        $this->requirePostRequest();
        $request = Craft::$app->getRequest();

        if($request->getBodyParam('formLogout') == 'true'){
            $ccb->logout();
        }else{
            $ccb->getUser($request->getBodyParam('formLogin'),$request->getBodyParam('formPassword'));
        }  
    }

}
