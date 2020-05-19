

<?php use yii\helpers\Html;
use yii\widgets\ActiveForm;

if(!empty($vac)):?>


    <div class="row">
        <div class="col-md-6">
            <label for="start_date">Начало отпуска</label><Br>
            <input type="date" id="start_date" name="start_date"
                  value="" class="form-control" aria-required="true">
        </div>
        <div class="col-md-6">
            <label for="end_date">Конец отпуска</label><Br>
            <input type="date" id="end_date" name="start_date" class="form-control" aria-required="true">
        </div>
    </div>

    <input type="hidden" id="idVac" data-id="<?=$vac->id ?>">
    </div>

<?php endif;?>



