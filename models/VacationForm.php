<?php


namespace app\models;
use yii\base\Model;
use yii\widgets\ActiveField;


class VacationForm extends Model
{
    public $start_d;
    public $end_d;

    public function attributeLabels()
    {
        return [
            'start_d' => 'Начало отпуска',
            'end_d' => 'Окончание отпуска',
        ];
    }

    public function rules()
    {
        return [
            // start_d, end_d атрибуты обязательны
            [['start_d', 'end_d'], 'required'],
            //собственный валидатор
            [ 'end_d', 'validateEnd'],

        ];
    }

//    public function validateEnd($attribute)
//    {
//        if(strtotime($attribute->end_d) < strtotime($attribute->start_d)){
//            $this->addError($attribute, 'Дата окончания не может быть раньше даты начала отпуска');
//        }
//    }

    public function validateEnd($attribute)
    {
        if(strtotime($this->end_d) < strtotime($this->start_d)){
            $this->addError($attribute, 'Дата окончания не может быть раньше даты начала отпуска');
        }
    }


}