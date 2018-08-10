<?php
namespace frontend\models;

use yii\base\Model;
use common\models\surveys\surveys;
use Yii;
use linslin\yii2\curl;

class GetSurveys extends Model{

	public $country;
	public $sup_id;

	public function getLocationInfoByIp(){
        $client  = @$_SERVER['HTTP_CLIENT_IP'];
        $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
        $remote  = @$_SERVER['REMOTE_ADDR'];
        $result  = array('country'=>'', 'city'=>'');
        if(filter_var($client, FILTER_VALIDATE_IP)){
            $ip = $client;
        }elseif(filter_var($forward, FILTER_VALIDATE_IP)){
            $ip = $forward;
        }else{
            $ip = $remote;
        }
        $ip_data = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=".'175.111.131.252'));
        if($ip_data && $ip_data->geoplugin_countryName != null){
            $result['country'] = $ip_data->geoplugin_countryCode;
            $result['city'] = $ip_data->geoplugin_city;
        }
    	return $result;
    }

    public function getSurveyQuestions(){
    	if(!empty($this->country)){
    		$url = Yii::$app->params['url'].'surveys?country='.$this->country;
    	}
    	else{
    		$url = Yii::$app->params['url'].'surveys?country=ALL';
    	}
		$curl = new curl\Curl();
		$curl->setOption(CURLOPT_RETURNTRANSFER,true);
        $response = $curl->get($url);
        print_r($url);die;
       	$statuscode = $curl->responseCode;
    }
}