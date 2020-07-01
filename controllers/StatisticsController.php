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
        $result = array(); // результаты вычислений

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

                    $days = $dEnd - $dStart + 1; // т.к. день окончания отпуска тоже является отпускным
                    $result[$i]['vacationDays'] += $days;
                }// if ($mStart == $i && $mEnd == $i )


                //####################################################
                //Если отпуск начинается в текущем месяце
                // а заканчивается в другом
                //$i - порядквый номер текущего месяца
                if ($mStart == $i && $mEnd != $i ){
                    $days = $number - $dStart + 1; // т.к. день окончания отпуска тоже является отпускным
                    $result[$i]['vacationDays'] += $days;
                }// if ($mStart == $i && $mEnd != $i )


                //####################################################
                //Если отпуск начинается в другом месяце
                // а заканчивается в текущем
                //$i - порядквый номер текущего месяца
                if ($mStart != $i && $mEnd == $i ){
                    $result[$i]['vacationDays'] += $dEnd;
                }// if ($mStart != $i && $mEnd == $i )


                //####################################################
                //Если отпуск начинается в одном из предыдущих месяцев
                // а заканчивается в одном из следующих
                //$i - порядквый номер текущего месяца
                if ($mStart < $i && $mEnd > $i ){
                    $result[$i]['vacationDays'] += $number;
                }// if ($mStart < $i && $mEnd > $i )

            }// foreach ($vacations as $key => $item)



        }//for ($i = 0; $i < 12; $i++)




        debug($vacations);
        debug($result);

        return $this->render('information' , compact(['result']));
    }

}