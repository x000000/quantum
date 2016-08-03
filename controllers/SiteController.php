<?php

namespace app\controllers;

use app\models\User;
use app\models\Country;
use yii\web\Response;

class SiteController extends \yii\web\Controller
{
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * @return string
     */
    public function actionIndex()
    {
	    $searchModel  = new User(['scenario' => 'search']);
	    $dataProvider = $searchModel->search(\Yii::$app->request->get());
	    $countries    = \yii\helpers\ArrayHelper::map(Country::find()->all(), 'id', 'name');

        return $this->render('index', compact('dataProvider', 'searchModel', 'countries'));
    }

	public function actionUserUpdate($id)
	{
		\Yii::$app->response->format = Response::FORMAT_JSON;
		$response = ['error' => false];

		if ($model = User::findOne($id)) {
			if (!$model->load(\Yii::$app->request->post()) || !$model->validate()) {
				$response['error'] = $model->errors;
			} else {
				if (!$model->save()) {
					$response['error'] = $model->errors;
				}
			}
		} else {
			$response['error'] = 'User not found';
		}

		return $response;
	}

}
