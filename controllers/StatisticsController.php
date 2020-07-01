<?php


namespace app\controllers;

use app\models\Vacation;
use app\models\User;
use yii\base\Request;
use yii\web\Controller;
use Yii;

class StatisticsController extends AppController
{

    public function actionIndex()
    {
        $thisYear = date("Y");  // текущий год
        $vacations = Vacation::find()->select(['start_date', 'end_date'])->asArray()->where(['confirmation' => 1])->all();



        debug($vacations);
        var_dump($thisYear);
        return $this->render('information' , compact(['vacations']));
    }

}