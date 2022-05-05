<?php
/**
 * craft-ccb-login plugin for Craft CMS 3.x
 *
 * des
 *
 * @link      thisanimus.com
 * @copyright Copyright (c) 2019 Andrew Hale
 */

namespace thisanimus\craftccblogin\controllers;

use thisanimus\craftccblogin\Craftccblogin;

use Craft;
use thisanimus\craftccblogin\services\API;
use craft\web\Controller;
use yii\web\Response;

/**
 * Default Controller
 *
 * Generally speaking, controllers are the middlemen between the front end of
 * the CP/website and your plugin’s services. They contain action methods which
 * handle individual tasks.
 *
 * A common pattern used throughout Craft involves a controller action gathering
 * post data, saving it on a model, passing the model off to a service, and then
 * responding to the request appropriately depending on the service method’s response.
 *
 * Action methods begin with the prefix “action”, followed by a description of what
 * the method does (for example, actionSaveIngredient()).
 *
 * https://craftcms.com/docs/plugins/controllers
 *
 * @author    Andrew Hale
 * @package   Craftccblogin
 * @since     1.0.0
 */
class DefaultController extends Controller
{

    // Protected Properties
    // =========================================================================

    /**
     * @var    bool|array Allows anonymous access to this controller's actions.
     *         The actions must be in 'kebab-case'
     * @access protected
     */
    protected int|bool|array $allowAnonymous = ['index', 'do-something'];

    // Public Methods
    // =========================================================================

    /**
     * Handle a request going to our plugin's index action URL,
     * e.g.: actions/craft-ccb-login/default
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

    /**
     * Handle a request going to our plugin's actionDoSomething URL,
     * e.g.: actions/craft-ccb-login/default/do-something
     *
     * @return mixed
     */
    public function actionDoSomething()
    {
        $result = 'Welcome to the DefaultController actionDoSomething() method';

        return $result;
    }
}
