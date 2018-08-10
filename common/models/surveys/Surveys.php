<?php

namespace common\models\surveys;

use Yii;
use common\validators\EmbedDocValidator;
use yii\mongodb\ActiveRecord;
class Surveys extends ActiveRecord{

	const STATUS_ACTIVE = 1;
	const STATUS_DELETED = 0;

	public static function collectionName(){
		return 'surveys';
	}

	public function attributes(){
		return [
			'_id',
			'qKey',
			'qId',
			'fulcrumId',
			'country',
			'language',
			'created_at',
			'updated_at',
			'options',
			'status',
			'qText'
		];
	}

	public function rules(){
		return [
			['qId','qKey','fulcrumId','country','language','options','common\validators\EmbedDocValidator','scenario' => ['create']
			]
		];
	}

	public function scenarios(){
		 $scenarios = parent::scenarios();
		 $scenarios['create'] = ['create'];
	}
	public function createSurveys(){
		$this->created_at = new \MongoDate();
		$this->updated_at = new \MongoDate();
		$this->save();
	}

	public function updateSurveys($postdata){
        
        $this->updated_at = new \MongoDate();
        $this->save();
    }

    public function deleteSurveys(){
        $this->status = self::STATUS_DELETED;
        $this->updated_at = new \MongoDate();
        $this->save();
    }

    public function getResponse(){
        return [
        	'id'=>isset($this->qId)?$this->qId:null,
        	'key'=>isset($this->qKey)?$this->qKey:null,
        	'fulcrumId'=>isset($this->fulcrumId)?$this->fulcrumId:null,
        	'country'=>isset($this->country)?$this->country:null,
        	'language'=>isset($this->language)?$this->language:null,
        	'created_at'=>isset($this->created_at)?$this->created_at:null,
        	'updated_at'=>isset($this->updated_at)?$this->updated_at:null,
        	'options'=>isset($this->options)?$this->options:null,
        	'qText'=>isset($this->qText)?$this->qText:null
        ];
    }

    public function setAttr($post){

    	if(isset($post['qId']) && !empty($post['qId'])){
    		$this->qId = $post['qId'];
    	}
    	if(isset($post['qKey']) && !empty($post['qKey'])){
    		$this->qKey = $post['qKey'];
    	}
    	if(isset($post['fulcrumId']) && !empty($post['fulcrumId'])){
    		$this->fulcrumId = $post['fulcrumId'];
    	}
    	if(isset($post['country']) && !empty($post['country'])){
    		$this->country = $post['country'];
    	}
    	if(isset($post['qText']) && !empty($post['qText'])){
    		$this->qText = $post['qText'];
    	}
    }
}