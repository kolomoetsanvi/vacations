<?php ?>

<?php
$this->title = 'Статистика SQL запрос';
?>

<?php
$months = array('1' => 'Январь', 'Февраль' , 'Март', 'Апрель', 'Май', 'Июнь',
    'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь')
?>

<div class="container">

    <table class="table table-striped table-bordered table-hover" id="confirmedVacTable">
        <thead>
        <tr>
            <th>Месяц</th>
            <th>Дней отпусков, суммарно</th>
            <th>Из них рабочих дней</th>
        </tr>
        </thead>
        <tbody >

        <?php if(!empty($result)):?>
            <?php foreach ($result as $key => $item):?>
                <tr>
                    <td class="text-center"><?=$months[$key] ?></td>
                    <td class="text-center"><?=$item['vacationDays'] ?></td>
                    <td class="text-center"><?=$item['workerDays'] ?></td>
                </tr>
            <?php endforeach?>
        <?php endif;?>
        </tbody>
    </table>

</div>