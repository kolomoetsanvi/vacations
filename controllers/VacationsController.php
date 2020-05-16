<?php


namespace app\controllers;

use app\models\ModalWind;
use app\models\Vacation;
use app\models\User;
use app\models\VacationForm;
use yii\base\Request;
use yii\data\Pagination;
use yii\web\Controller;
use Yii;

class VacationsController extends AppController
{

    public function actionIndex()
    {

        $idUser = Yii::$app->user->identity->getId();
        $user = User::findOne(['id' => $idUser]);



        // В зависимости от роли сотрудника направляем на нужный вид
        if ($user->role->role == 'board'){
            $query = Vacation::find()->with('user')->orderBy('user_id');
            $pages = new Pagination(['totalCount' => $query->count(), 'pageSize' => 10,
                'forcePageParam' => false, 'pageSizeParam' => false]);
            $vacations = $query->offset($pages->offset)->limit($pages->limit)->all();
            return $this->render('board', compact(['vacations', 'pages']));

            } else if ($user->role->role == 'worker') {
                $vacationForm = new VacationForm();
                $vacations = Vacation::find()->with('user')->orderBy('user_id')->all();
                return $this->render('worker', compact(['vacations', 'idUser', 'vacationForm']));
            }
            else{
                TODO;
            };
    }




    // Подтверждение отпусков руководителем Ajax
    public function actionConfirmed(){

        if(Yii::$app->request->isAjax){
             $confirmedVacMas = Yii::$app->request->post('confirmedVacMas');
             foreach ($confirmedVacMas as $id => $item){
                 $vac = Vacation::findOne(['id' => $item]);
                 $vac->confirmation = 1;
                 $vac->update_user_id = Yii::$app->user->identity->getId();
                 $vac->save();
            }//foreach
        }//if

        $query = Vacation::find()->with('user')->orderBy('user_id');
        $pages = new Pagination(['totalCount' => $query->count(), 'pageSize' => 10,
            'forcePageParam' => false, 'pageSizeParam' => false]);
        $vacations = $query->offset($pages->offset)->limit($pages->limit)->all();
        return $this->renderPartial('tabBody', compact(['vacations', 'pages']));
    }




    // добавление дат отпуска сотрудником Ajax
    public function actionAddDate(){
        $userId = Yii::$app->user->identity->getId();

        $form = new VacationForm();
        $vac = new Vacation();
        if(Yii::$app->request->isAjax){
           if($form->load(Yii::$app->request->post())){
              if($form->validate()){
                  $vac->user_id = $userId;
                  $vac->update_user_id = $userId;
                  $vac->start_date = $form->start_d;
                  $vac->end_date = $form->end_d;
                  $vac->save();
              }

             $userVacations = Vacation::find()->where(['user_id' => $userId])->all();
               return $this->renderPartial('vacTab', compact(['userVacations']));
           }
        }//if
    }

    // открытие модального окна для редактироания отпуска сотрудником Ajax
    public function actionEditDate(){
        $id = Yii::$app->request->post('id');
        $vac = Vacation::findOne($id);
        if(empty($vac)) return false;

        $vacationForm = new VacationForm();
        $this->layout = false;
        return $this->render('edit-modal', compact(['vac', 'vacationForm']));
    }

    //сохранени еизменений отпуска сотрудником Ajax
    public function actionSaveEditDate(){
        if(Yii::$app->request->isAjax){
            $id = Yii::$app->request->post('id');
            $startDate = Yii::$app->request->post('start_date');
            $endDate = Yii::$app->request->post('end_date');

            $vac = Vacation::findOne(['id' => $id]);
            $vac->update_user_id = $id;
            $vac->start_date = $startDate;
            $vac->end_date = $endDate;
            $vac->save();

            $userId = Yii::$app->user->identity->getId();
            $userVacations = Vacation::find()->where(['user_Id' => $userId])->all();
            return $this->renderPartial('vacTab', compact(['userVacations']));
        }


//

    }





}