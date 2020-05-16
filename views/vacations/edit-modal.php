

<?php use yii\helpers\Html;
use yii\widgets\ActiveForm;

if(!empty($vac)):?>


<!--    <table class="table table-striped table-bordered table-hover" id="confirmedVacTable">-->
<!--        <thead>-->
<!--        <tr>-->
<!--            <th>Начало отпуска</th>-->
<!--            <th>Окончание отпуска</th>-->
<!--            <th>Подтверждение</th>-->
<!--        </tr>-->
<!--        </thead>-->
<!--        <tbody >-->
<!--            <tr>-->
<!--                <td class="text-center">--><?//=$vac->start_date ?><!--</td>-->
<!--                <td class="text-center">--><?//=$vac->end_date ?><!--</td>-->
<!--                <td class="text-center">--><?//=$vac->confirmation?
//                        ('<span class="glyphicon glyphicon-ok text-success"></span>') :
//                        ('<span class="glyphicon glyphicon-minus text-warning"></span>')
//                    ?>
<!--                </td>-->
<!--            </tr>-->
<!--        </tbody>-->
<!--    </table>-->


    <div class="row">
        <div class="col-md-6">
            <label for="start_date">Начало отпуска</label><Br>
            <input type="date" id="start_date" name="start_date" class="form-control" aria-required="true">
        </div>
        <div class="col-md-6">
            <label for="end_date">Конец отпуска</label><Br>
            <input type="date" id="end_date" name="start_date" class="form-control" aria-required="true">
        </div>
    </div>

    <input type="hidden" id="idVac" data-id="<?=$vac->id ?>">
    </div>

<?php endif;?>
