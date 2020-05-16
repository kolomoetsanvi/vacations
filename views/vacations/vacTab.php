<?php ?>
<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
?>
<?php if(!empty($userVacations)):?>

    <table class="table table-striped table-bordered table-hover" id="confirmedVacTable">
        <thead>
        <tr>
            <th>Начало отпуска</th>
            <th>Окончание отпуска</th>
            <th>Подтверждение</th>
        </tr>
        </thead>
        <tbody >
        <?php foreach ($userVacations as $id => $item):?>
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
        <?php endforeach?>
        </tbody>
    </table>

    </div>

<?php endif;?>
