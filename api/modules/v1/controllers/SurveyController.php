<?php
namespace api\modules\v1\controllers;
use common\models\surveys\Surveys;
use common\models\surveys\SurveySearch;

use yii\rest\ActiveController;
use Yii;
use yii\mongodb\ActiveRecord;


class SurveyController extends ActiveController{

	public $modelClass = 'common\models\surveys\Surveys';

	public function actions(){
        $actions = parent::actions();
        unset($actions['create']);
        unset($actions['update']);
        unset($actions['delete']);
        unset($actions['view']);
        unset($actions['index']);
        return $actions;
    }

    public function verbs(){
    	return [
            'create' => ['POST'],
            'update' => ['PUT', 'PATCH','POST'],
            'delete' => ['DELETE'],
            'view' => ['GET'],
            'index'=>['GET'],
        ];
    }



    public function actionCreate(){
    	$model = new Surveys();
    	$post = Yii::$app->request->post();
    	$model->setAttr($post);
    	$model->scenario = 'create';
    	if($model->validate()){
    		echo "de";die;
    		if($model = $model->createSurveys()){
    			Yii::$app->response->statuscode = 201;
    			return ['survey'=>$model->response];
    		}
    		else{
    			return $model;
    		}
    	}
    	else{
    		return $model;
    	}
    }

    public function actionUpdate($id,$cnt,$lang){

    	$qId = $id;
    	$country = $cnt;
    	$language = $lang;
    	$model = Survey::findOne(['qId'=>(int)$qId,'country'=>$country,'language'=>$language,'status'=>['$ne'=>Survey::STATUS_DELETED]]);
    	if(!empty($model)){
    		$post = Yii::$app->request->post();
    		if($model->validate() && $model->updateSurveys($post)){
    			return ['surveys'=>$model->response]; 
    		}
    		else{
    			return $model;
    		}
    	}
    	else{
    		return $model;
    	}
    }

    public function actionDelete($id){
    	$qId = $id;
    	$model = Surveys::findOne(['qId'=>(int)$qId,'status'=>['$ne'=>Surveys::STATUS_DELETED]]);
    	if(!empty($model)){
    		$model->deleteSurveys();
    		Yii:$app->response->statuscode =204;
    	}
    	else{
    		Yii::$app->response->statuscode = 404;
    	}
    }

    public function actionView(){
    	$params = Yii::$app->request->get();
    	$model = new SurveySearch();
    	$result = $model->search($params);
    	$surveys = $result->getModels();
    	if(!empty($surveys)){
    		Yii::$app->response->statuscode = 200;
    		return [
    			'survey'=>$surveys->response
    		];
    	}
    	else{
    		return [
    			'Not Found'
    		];
    	}
    }

    public function actionIndex(){
    	$data = Surveys::find()->all();
    	if(!empty($data)){
    		foreach ($data as $key => $value) {
                $response[] = $value->response;
            }
            Yii::$app->response->statusCode = 200;
            return [
                'surveys' => $response
            ]; 
        }else{
            Yii::$app->response->statusCode = 404;
            return[
                'Not Found'
            ];
        }
    }

    public function actionGetSurveys(){

    }
}