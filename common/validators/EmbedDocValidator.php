<?php

namespace common\validators;
 
use yii\validators\Validator;
 
class EmbedDocValidator extends Validator
{
    public $scenario;
    public $model;
 
    /**
     * Validates a single attribute.
     * Child classes must implement this method to provide the actual validation logic.
     *
     * @param \yii\mongodb\ActiveRecord $object the data object to be validated
     * @param string $attribute the name of the attribute to be validated.
     */
    public function validateAttribute($object, $attribute)
    {
        
        $attr = $object->{$attribute};
        if (is_array($attr)) {
            $model = new $this->model;

            if($this->scenario){
                /** 
                 * If Multiple scenario passed in validator
                 * then assigin only that scenario in model which is set in controller.
                 */
                if(is_array($this->scenario)){
                    foreach ($this->scenario as $scenariovalue) {
                        if($object->scenario==$scenariovalue){
                            $model->scenario = $scenariovalue;
                        }
                    }
                }
                else{
                    $model->scenario = $this->scenario;
                }
            }
            $model->attributes = $attr;
            if (!$model->validate()) {
                foreach ($model->getErrors() as $keyAttr=>$errorAttr) {
                    foreach ($errorAttr as $value) {
                        
                        if(isset($object->$keyAttr)){
                            $this->addError($object, $keyAttr, $value);
                        }
                        else if(!empty($model->errors)){
                            // Nested validators
                            $object->addError($keyAttr,$value);
                        }
                    }
                }
            }
            else if(isset($object->innerModelData)){
                $object->innerModelData = $model->attributes;
            }
            
        } else {
            $this->addError($object, $attribute, 'should be an array');
        }
    }
 
}