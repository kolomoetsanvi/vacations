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
        // текущий год
        $thisYear = date("Y");
        // выыбираем из базы данных все записи об отпусках
        //!!! Подтвержденных отпусках !!!
        $vacations = Vacation::find()->select(['start_date', 'end_date'])->asArray()->where(['confirmation' => 1])->all();
        // результаты вычислений
        $result = array();

        //Для каждого месяца вычесляем суммарное количество отпускных дней.
        // Сколько из них было рабочих
        for ($i = 1; $i < 13; $i++){

            //Заполнение первоначальными данными. Для каждого месяца
            $result[$i] = array('vacationDays' => 0, 'workerDays' => 0);

            //Количество дней в месяце
            $number = cal_days_in_month(CAL_GREGORIAN, $i, $thisYear);

            //проходимся по всем записям об отпусках
            foreach ($vacations as $key => $item)
            {
                //Порядковый номер месяца (от 1 до 12 ) в котором отпуск сотрудника начинается
                // и заканчивается
                $mStart = date('n', strtotime($item['start_date']));
                $mEnd = date('n', strtotime($item['end_date']));

                //День месяца начала и окончания отпуска
                $dStart = date('j', strtotime($item['start_date']));
                $dEnd= date('j', strtotime($item['end_date']));


                //####################################################
                //Если отпуск начинается и заканчивается в одном месяце
                //$i - порядквый номер текущего месяца
                if ($mStart == $i && $mEnd == $i ){

                    //Количество отпускных дней
                    $days = $dEnd - $dStart + 1; // т.к. день окончания отпуска тоже является отпускным
                    $result[$i]['vacationDays'] += $days;

                    //Сколько из них рабочих
                    $d = date('w', strtotime($item['start_date']));//получаем порядковый номер дня недели первого дня отпуска (0 - воскресенье)
                    for ($j = 0; $j < $days; $j++){
                        if ($d > 0 && $d < 6)  $result[$i]['workerDays']++;
                        $d++;
                        if ($d > 6) $d = 0;
                    }//for ($j = 0; $j < $days; $j++)


                }// if ($mStart == $i && $mEnd == $i )
                //-----------------------------------------------------

                //####################################################
                //Если отпуск начинается в текущем месяце
                // а заканчивается в другом
                //$i - порядквый номер текущего месяца
                if ($mStart == $i && $mEnd != $i ){
                    //Количество отпускных дней
                    $days = $number - $dStart + 1; // т.к. день окончания отпуска тоже является отпускным
                    $result[$i]['vacationDays'] += $days;

                    //Сколько из них рабочих
                    $d = date('w', strtotime($item['start_date']));//получаем порядковый номер дня недели первого дня отпуска (0 - воскресенье)
                    for ($j = 0; $j < $days; $j++){
                        if ($d > 0 && $d < 6)  $result[$i]['workerDays']++;
                        $d++;
                        if ($d > 6) $d = 0;
                    }//for ($j = 0; $j < $days; $j++)

                }// if ($mStart == $i && $mEnd != $i )
                //-----------------------------------------------------

                //####################################################
                //Если отпуск начинается в другом месяце
                // а заканчивается в текущем
                //$i - порядквый номер текущего месяца
                if ($mStart != $i && $mEnd == $i ){
                    //Количество отпускных дней
                    $result[$i]['vacationDays'] += $dEnd;

                    //Сколько из них рабочих
                    $d = date('w', strtotime("$thisYear-"."$i-"."1"));//получаем порядковый номер дня недели первого дня отпуска (0 - воскресенье)
                    for ($j = 0; $j < $dEnd; $j++){
                        if ($d > 0 && $d < 6)  $result[$i]['workerDays']++;
                        $d++;
                        if ($d > 6) $d = 0;
                    }//for ($j = 0; $j < $days; $j++)

                }// if ($mStart != $i && $mEnd == $i )
                //-----------------------------------------------------

                //####################################################
                //Если отпуск начинается в одном из предыдущих месяцев
                // а заканчивается в одном из следующих
                //$i - порядквый номер текущего месяца
                if ($mStart < $i && $mEnd > $i ){
                    //Количество отпускных дней
                    $result[$i]['vacationDays'] += $number;

                    //Сколько из них рабочих
                    $d = date('w', strtotime("$thisYear-"."$i-"."1"));//получаем порядковый номер дня недели первого дня отпуска (0 - воскресенье)
                    for ($j = 0; $j < $number; $j++){
                        if ($d > 0 && $d < 6)  $result[$i]['workerDays']++;
                        $d++;
                        if ($d > 6) $d = 0;
                    }//for ($j = 0; $j < $days; $j++)

                }// if ($mStart < $i && $mEnd > $i )
                //-----------------------------------------------------

            }// foreach ($vacations as $key => $item)
        }//for ($i = 0; $i < 12; $i++)

        return $this->render('information' , compact(['result']));
    }// public function actionIndex()



}