<?php

namespace common\models;

use Yii;

/**
 * This is the model class for collection "countries".
 *
 * @property \MongoId|string $_id
 */
class Countries extends \yii\mongodb\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function collectionName()
    {
        return 'countries';
    }

    /**
     * @inheritdoc
     */
    public function attributes()
    {
        return [
            '_id',
            'ShortCode',
            'states'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            '_id' => 'ID',
            'ShortCode' => 'Short Code',
            'states'=>'States'
        ];
    }
}
