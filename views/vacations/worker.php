<?php ?>
<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
?>

<?php
$this->title = 'Панель сотрудника';
?>

<?php if(!empty($vacations)):?>


<div class="container">


    <div class="panel panel-primary panel-add" id="panel-user">
        <div class="panel-body">
                <div class="row">
                    <div class="col-md-4 col-md-offset-8 text-right">
                        <h4><?= Yii::$app->user->identity->surname ?>
                            <?= Yii::$app->user->identity->name ?>
                            <?= Yii::$app->user->identity->patronymic ?>
                        </h4>
                    </div>
                </div>
                    <?php $form = ActiveForm::begin(['id' => 'addDateForm', 'action' => '#'])?>
                <div class="row">
                    <div class="col-md-4">
                        <?= $form->field($vacationForm, 'start_d')->input("date")?>
                    </div>
                    <div class="col-md-4">
                         <?= $form->field($vacationForm, 'end_d')->input("date")?>
                    </div>
                    <div class="col-md-4 text-center" style="padding-top: 14px   ">
                        <?= HTML::submitButton('Отправить', ['class' => 'btn btn-success', 'id' => 'addDatedBtn']) ?>
                    </div>
                </div>
                    <?php ActiveForm::end()?>
        </div>


        <div class="panel-footer">
            <div class="row" id="insertDate">
                <table class="table table-striped table-bordered table-hover" id="confirmedVacTable">
                    <thead>
                    <tr>
                        <th>Начало отпуска</th>
                        <th>Окончание отпуска</th>
                        <th>Подтверждение</th>
                    </tr>
                    </thead>
                    <tbody >
                    <?php foreach ($vacations as $id => $item):?>
                        <?php if ($item->user_id == Yii::$app->user->identity->getId()):?>
                            <tr>
                                <td class="text-center"><?=$item->start_date ?></td>
                                <td class="text-center"><?=$item->end_date ?></td>
                                <td class="text-center"><?=$item->confirmation?
                                        ('<span class="glyphicon glyphicon-ok text-success"></span>') :
                                        ('<a class="btn btn-info edit-date-a" data-id="'.$item->id.'" href="'.\yii\helpers\URL::to(['vacations/edit-date', 'id' => $item->id]).'">
                                            Редактировать
                                        </a>')
                                    ?>
                                </td>
                            </tr>
                        <?php endif?>
                    <?php endforeach?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>





    <div class="table-responsive ">
        <table class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th>ФИО</th>
                    <th>Начало отпуска</th>
                    <th>Окончание отпуска</th>
                    <th>Подтверждение</th>
                </tr>
            </thead>
            <tbody>
                 <?php foreach ($vacations as $id => $item):?>
                 <?php if ($item->user_id != Yii::$app->user->identity->getId()):?>
                     <tr>
                        <td><?=$item->user->surname.' '.
                                   $item->user->name.' '.
                                   $item->user->patronymic
                             ?></td>
                         <td class="text-center"><?=$item->start_date ?></td>
                         <td class="text-center"><?=$item->end_date ?></td>
                         <td class="text-center"><?=$item->confirmation?
                                 ('<span class="glyphicon glyphicon-ok text-success"></span>') :
                                 ('<span class="glyphicon glyphicon-minus text-warning"></span>')
                              ?>
                         </td>
                     </tr>
                 <?php endif?>
                 <?php endforeach?>
            </tbody>
        </table>
    </div>

    <?php endif;?>
</div>
