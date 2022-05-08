<?php

namespace thisanimus\CCBLogin\controllers;

use thisanimus\CCBLogin\Plugin;

use Craft;
use thisanimus\CCBLogin\services\CCBService;
use craft\web\Controller;
use yii\web\Response;

class DefaultController extends Controller{
    protected int|bool|array $allowAnonymous = true;

	public function actionIndex()
    {
        $ccb = new CCBService;
        $this->requirePostRequest();
        $request = Craft::$app->getRequest();

        if($request->getBodyParam('formLogout') == 'true'){
            $ccb->logout();
        }else{
            $ccb->getUser($request->getBodyParam('formLogin'),$request->getBodyParam('formPassword'));
        }
    }
}