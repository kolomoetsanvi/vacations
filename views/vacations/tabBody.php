<?php ?>
<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
?>
<?php if(!empty($vacations)):?>

    <table class="table table-striped table-bordered table-hover" id="confirmedVacTable">
        <thead>
        <tr>
            <th>ФИО</th>
            <th>Начало отпуска</th>
            <th>Окончание отпуска</th>
            <th>Подтверждение</th>
        </tr>
        </thead>
        <tbody >
        <?php foreach ($vacations as $id => $item):?>
            <tr>
            <td><?=$item->user->surname.' '.
                $item->user->name.' '.
                $item->user->patronymic
                ?></td>
            <td class="text-center"><?=$item->start_date ?></td>
            <td class="text-center"><?=$item->end_date ?></td>
            <td class="text-center"><?=$item->confirmation?
                    ('<span class="glyphicon glyphicon-ok text-success"></span>') :
                    ('<input type="checkbox" name="confirmedVac[]"  value="'.$item->id.'"')
                ?>
            </td>
            </tr>
        <?php endforeach?>
        </tbody>
    </table>

<?php endif;?>

