<?php ?>
<?php

use yii\web\View;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
?>

<?php
$this->title = 'Панель руководителя';
?>

<?php if(!empty($vacations)):?>


<div class="container">

    <div class="table-responsive" id="tabBody" style="padding-left: 20px; padding-right: 20px">
        <?php include(Yii::getAlias('@app/views/vacations/tabBody.php')) ?>
    </div>

    <div class="row">
        <?php
        echo \yii\widgets\LinkPager::widget([
            'pagination' => $pages,
        ])
        ?>
    </div>

    <div class="row" id="subRow">
        <?= Html::submitButton('Подтвердить',
            ['class' => 'btn btn-success', 'id' => 'confirmedBtn'])?>
    </div>

</div>

<?php endif;?>




