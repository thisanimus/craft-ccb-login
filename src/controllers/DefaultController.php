<?php

namespace thisanimus\CCBLogin\controllers;

use Craft;
use yii\web\Response;
use thisanimus\CCBLogin\services\CCBService;
use craft\web\Controller;

class DefaultController extends Controller {
	protected int|bool|array $allowAnonymous = true;

	public function actionIndex(): Response {
		$ccb = new CCBService;
		$this->requirePostRequest();
		$request = Craft::$app->getRequest();

		if ($request->getBodyParam('formLogout') == 'true') {
			$ccb->logout();
		} else {
			$ccb->getUser($request->getBodyParam('formLogin'), $request->getBodyParam('formPassword'));
		}
		// Redirect the request based on a 'redirect' param
		return $this->redirectToPostedUrl();
	}
}
