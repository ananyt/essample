<?php
namespace common\models\surveys;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\surveys\Surveys;


class SurveySearch extends Surveys{

	public $qId;
	public $qKey;
	public $fulcrumId;
	public $country;
	public $language;
	public $created_at;
	public $updated_at;
	public $options;

	/*public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }*/
	public function search($params){
        $query = Surveys::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pagesize' => 10,
            ],
            'sort' => [
                'defaultOrder' => [
                    '_id' => SORT_DESC
                ]
            ],
        ]);
        $this->setSearchingCriteria($params);
        if((isset($this->qId)) && !empty($this->qId)){
        	$query->andFilterWhere([
        			'qId' => $this->qId
        		]);
        }
        return $dataProvider;
    }

    public function setSearchingCriteria($params){
    	if(isset($params['id'])){
    		$this->qId = $params['id'];
    	}
    }
}