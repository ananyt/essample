<?php

namespace api\modules\v1\controllers;
use common\models\Countries;

use yii\rest\ActiveController;

/**
 * Country Controller API
 *
 * @author Budi Irawan <deerawan@gmail.com>
 */
class CountryController extends ActiveController
{
    public $modelClass = 'common\models\Countries';

     public function actions(){
        $actions = parent::actions();
        unset($actions['index']);
        return $actions;
    }

    /**
     * Alloting method type to actions.
     * Actions can only be access with method defined.
     *
     */
    protected function verbs(){
        return [
            'index' => ['GET']
        ];
    }

    /**
     * 
     * API : http://localhost/panels/api/web/v1/countries
     * Method : GET
     * @return array all countries
     */
    public function actionIndex(){
            $countries = Countries::find()->all();
            if(!empty($countries)){
                $allCountries = array();
                foreach ($countries as $key => $value) {
                        $allCountries[] = ['country'=>$value->_id,'short_code'=>$value->ShortCode];
                }
                return $allCountries;
            }
            else
                Yii::$app->response->statusCode = 404; // Status 404 is for Not Found
        }

    /**
     * 
     * API : http://localhost/panels/api/web/v1/countries/{country_name}/states
     * Method : GET
     * @return array all states
     */
    public function actionGetstates($country){
            $country = ucwords($country);
            $countries = Countries::find()->where(['_id'=>$country])->One();
            if(!empty($countries)){
                return $countries->states;
            }
            else
                Yii::$app->response->statusCode = 404; // Status 404 is for Not Found
        }
}
