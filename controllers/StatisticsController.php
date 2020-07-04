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

    //////////////////////////////////////////////////////////////////////////
    //######################################################################//
    //////////////////////////////////////////////////////////////////////////
    public function actionQuery()
    {
        $result = Yii::$app->db->createCommand(
           'SELECT 
                MONTH(start_date) as Month,
               
               SUM( CASE
                -- кол-во дней отпуска если отпуск внутри одного месяца
                    WHEN MONTH(start_date) = MONTH(end_date) 
                        THEN (DAYOFMONTH(end_date) - DAYOFMONTH(start_date) + 1)
                -- количество дней отпуска от начала до конца текущего месяца    
                   WHEN MONTH(start_date) != MONTH(end_date) 
                        THEN (DAYOFMONTH(LAST_DAY(start_date)) - DAYOFMONTH(start_date) + 1)
                   ELSE 0
                END) AS vacationDays,
                
                SUM( CASE
                -- кол-во рабочих дней отпуска если отпуск внутри одного месяца
                    WHEN MONTH(start_date) = MONTH(end_date) 
                        THEN ( (CEILING((DAYOFMONTH(end_date) - DAYOFMONTH(start_date)+1) / 7)-1)*5
                         + MOD((DAYOFMONTH(end_date) - DAYOFMONTH(start_date)+1), 7)
                         - if((DAYOFWEEK(start_date) = 1 ), 1, 0)
                         - if((DAYOFWEEK(start_date) <= DAYOFWEEK(end_date)) AND (DAYOFWEEK(end_date) = 7), 1, 0)
                        - if((DAYOFWEEK(start_date) > DAYOFWEEK(end_date) ), 2, 0)                                                  
                        )
                -- количество рабочих дней отпуска от начала до конца текущего месяца    
                   WHEN MONTH(start_date) != MONTH(end_date) 
                        THEN  ( (CEILING((DAYOFMONTH(LAST_DAY(start_date)) - DAYOFMONTH(start_date)+1) / 7)-1)*5
                         + MOD((DAYOFMONTH(LAST_DAY(start_date)) - DAYOFMONTH(start_date)+1), 7)
                         - if((DAYOFWEEK(start_date) = 1 ), 1, 0)
                         - if((DAYOFWEEK(start_date) <= DAYOFWEEK(LAST_DAY(start_date))) AND (DAYOFWEEK(LAST_DAY(start_date)) = 7), 1, 0)
                         - if((DAYOFWEEK(start_date) > DAYOFWEEK(LAST_DAY(start_date)) ), 2, 0)                                                  
                        )
                   ELSE 0
                END) AS workerDays
           FROM vacations
           WHERE confirmation = 1
           GROUP BY Month
 
           
           UNION 
           SELECT 
                MONTH(end_date) as Month,
                SUM(DAYOFMONTH(end_date)) AS vacationDays,
                SUM( 
                    (CEILING(DAYOFMONTH(end_date) / 7)-1)*5
                        + MOD((DAYOFMONTH(end_date)), 7)
                         - if((DAYOFWEEK(DATE_SUB(end_date, INTERVAL (DAYOFMONTH(end_date)-1) DAY)) = 1 ), 1, 0)
                          - if((DAYOFWEEK(DATE_SUB(end_date, INTERVAL (DAYOFMONTH(end_date)-1) DAY)) <= DAYOFWEEK(end_date)) AND (DAYOFWEEK(end_date) = 7), 1, 0)
                       - if((DAYOFWEEK(DATE_SUB(end_date, INTERVAL (DAYOFMONTH(end_date)-1) DAY)) > DAYOFWEEK(end_date) ), 2, 0)                                                  
                 ) AS workerDays
           FROM vacations
           WHERE confirmation = 1 AND MONTH(start_date) != MONTH(end_date)
           GROUP BY Month
           
           
           UNION 
           SELECT 
                MONTH(start_date)+1 as Month,
               SUM( DAYOFMONTH(LAST_DAY(DATE_ADD(LAST_DAY(start_date), INTERVAL 1 DAY))) ) AS vacationDays,
               SUM( 
                    (CEILING(DAYOFMONTH(LAST_DAY(DATE_ADD(LAST_DAY(start_date), INTERVAL 1 DAY))) / 7)-1)*5
                        + MOD((DAYOFMONTH(LAST_DAY(DATE_ADD(LAST_DAY(start_date), INTERVAL 1 DAY)))), 7)
                         - if((DAYOFWEEK(DATE_SUB((LAST_DAY(DATE_ADD(LAST_DAY(start_date), INTERVAL 1 DAY))), INTERVAL (DAYOFMONTH((LAST_DAY(DATE_ADD(LAST_DAY(start_date), INTERVAL 1 DAY))))-1) DAY)) = 1 ), 1, 0)
                          - if((DAYOFWEEK(DATE_SUB((LAST_DAY(DATE_ADD(LAST_DAY(start_date), INTERVAL 1 DAY))), INTERVAL (DAYOFMONTH((LAST_DAY(DATE_ADD(LAST_DAY(start_date), INTERVAL 1 DAY))))-1) DAY)) <= DAYOFWEEK((LAST_DAY(DATE_ADD(LAST_DAY(start_date), INTERVAL 1 DAY))))) AND (DAYOFWEEK((LAST_DAY(DATE_ADD(LAST_DAY(start_date), INTERVAL 1 DAY)))) = 7), 1, 0)
                       - if((DAYOFWEEK(DATE_SUB((LAST_DAY(DATE_ADD(LAST_DAY(start_date), INTERVAL 1 DAY))), INTERVAL (DAYOFMONTH((LAST_DAY(DATE_ADD(LAST_DAY(start_date), INTERVAL 1 DAY))))-1) DAY)) > DAYOFWEEK((LAST_DAY(DATE_ADD(LAST_DAY(start_date), INTERVAL 1 DAY)))) ), 2, 0)                                                  
                 ) AS workerDays
           FROM vacations
           WHERE confirmation = 1 AND  MONTH(end_date) > MONTH(start_date)+1
           GROUP BY Month
           ORDER BY Month
           
           '
        )->queryAll();


        return $this->render('informationQuery' , compact(['result']));

    }


}