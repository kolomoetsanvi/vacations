<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => 'Главная',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [

            Yii::$app->user->isGuest ? (
                ['label' => 'Вход', 'url' => ['/site/login']]
            ) : (
                '<li><a href="/statistics/index">Статистика</a></li>'
                .'<li><a href="/statistics/query">Статистика SQL запрос</a></li>'
                .'<li>'
                . Html::beginForm(['/site/logout'], 'post')
                . Html::submitButton(
                    'Выход (' . Yii::$app->user->identity->username . ')',
                    ['class' => 'btn btn-link logout']
                )
                . Html::endForm()
                . '</li>'
            )
        ],
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; Андрей Коломоец <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>


<?php
\yii\bootstrap\Modal::begin([
        'header' => '<h2>Редактирование отпуска</h2>',
        'id' => 'modalW',
        'footer' => '<button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                     <button type="button" class="btn btn-primary" id="btnSave">Сохранить</button>'
    ]);
\yii\bootstrap\Modal::end();
?>

<?php $this->endBody() ?>
</body>
</html>

<?php
$js = <<<JS
//// Обработка кнопки на странице board
//////////////////////////////////////////////////////////////////////////////
        function setTab(res){
            $('#tabBody').html(res);    
        }

        //Руководитель подтверждает отпуска
        $('#confirmedBtn').on('click', function(event) {
            event.preventDefault();
            //подтвержденные отпуска
            var confirmedVacMas = $("#confirmedVacTable :checked").map(function(i, el){
                                    return $(el).val();
                                 }).get();
            if (confirmedVacMas.length != 0){
               $.ajax({
               url: '/vacations/confirmed',
               data: {'confirmedVacMas': confirmedVacMas},
               type: 'POST',
               success: function (res) {
                   if(!res) alert('Ошибка!');
                   setTab(res);
               },
               error: function () {
                   alert('Ошибка!');
               }
             })
            }//if
          

        });


//Обработка кнопки на странице worker
//////////////////////////////////////////////////////////////////////////////

        function setDate(res){
            $('#vacationform-start_d').val('');
            $('#vacationform-end_d').val('');
            $('#insertDate').html(res);
        }
 
        $('#addDateForm').on('beforeSubmit  ', function (e) {
            e.preventDefault();
            var data=$(this).serialize();
     
            $.ajax({
                type: "POST",
                url: '/vacations/add-date',
                data: data,
                success: function (res) {
                           if(!res) alert('Ошибка!');
                           setDate(res); 
                       },
                       error: function (res) {
                           alert('Ошибка!');
                       }
            });
            return false;
        });
       
 //Запуск модального окна для редактирование дат сортудником
//////////////////////////////////////////////////////////////////////////////       
         function showEditForm(res){
            $('#modalW .modal-body').html(res);
            $('#modalW').modal('show');    
        }
       
        $('#insertDate').on('click', '.edit-date-a', function(e){
            e.preventDefault();
            var id = $(this).data('id');
             $.ajax({
                type: "POST",
                url: '/vacations/edit-date',
                data: {'id': id},
                success: function (res) {
                           if(!res) alert('Ошибка!');
                          showEditForm(res); 
                       },
                       error: function () {
                           alert('Ошибка');
                       }
            });
        })
       
       
 //Сохранение новых дат отпуска сортудником
//////////////////////////////////////////////////////////////////////////////       
     function saveEdit(res){
            $('#insertDate').html(res); 
             $('#modalW').modal('hide');
     }
 
     
         $('#btnSave').on('click', function(e){
            e.preventDefault();
            var id = $('#idVac').data('id');
            var start_date = $('#start_date').val();
            var end_date = $('#end_date').val();
             $.ajax({
                type: "POST",
                url: '/vacations/save-edit-date',
                data: {'id': id, 'start_date': start_date, 'end_date': end_date},
                success: function (res) {
                           if(!res){
                             alert('Ошибка1!');  
                          }
                          saveEdit(res); 

                           
                       },
                       error: function () {
                           alert('Ошибка');
                       }
            });
        })       
       
JS;

$this->registerJs($js);
?>

<?php $this->registerJsFile('@web/js/scripts.js', ['depends' => 'yii\web\YiiAsset'])?>

<?php $this->endPage() ?>

