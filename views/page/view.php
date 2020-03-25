<?php

use app\models\file\File;
use app\models\page\Page;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\page\Page */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Страницы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$script = <<< JS
$(document).ready(function () {
    //при нажатии на ссылку, содержащую Thumbnail
    $('a.thumbnail').click(function(e) {
      //отменить стандартное действие браузера
      e.preventDefault();
      //присвоить атрибуту scr элемента img модального окна
      //значение атрибута scr изображения, которое обёрнуто
      //вокруг элемента a, на который нажал пользователь
      $('#image-modal .modal-body img').attr('src', $(this).find('img').attr('src'));
      //открыть модальное окно
      $("#image-modal").modal('show');
    });
    //при нажатию на изображение внутри модального окна
    //закрыть его (модальное окно)
    $('#image-modal .modal-body img').on('click', function() {
      $("#image-modal").modal('hide')
    });
});
JS;

$this->registerJs($script);
?>
<div class="page-view">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Удалить', ['delete', 'id' => (string)$model->id], [
            'class' => 'btn btn-danger',
            'data'  => [
                'confirm' => 'Вы уверены?',
                'method'  => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model'      => $model,
        'attributes' => [
            Page::ATTR_MONGO_ID,
            Page::ATTR_TITLE,
            Page::ATTR_URL.':url',
            Page::ATTR_CONTENT . ':html',
            [
                'attribute' => Page::ATTR_FILES,
                'format'    => 'raw',
                'value'     => function ($data)
                {
                    $images = '';
                    if ($data->files) {
                        $images .= '<div class="row">';
                        /** @var File $file */
                        foreach ($data->files as $file) {
                            $images .= "<div class='col-sm-6 col-md-4 col-lg-3'>
                                <a href='#' class='thumbnail'>
                                    <img src='{$file->getUrl()}' alt=''>
                                </a>
                            </div>";
                        }
                        $images .= '</div>';
                    }

                    return $images;
                },
            ],
            Page::ATTR_STATUS,
            'createdAtFormatAdmin',
            'parsedAtFormatAdmin',
        ],
    ]) ?>

    <?php if ($model->files): ?>
        <div class="modal fade" id="image-modal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">×</span></button>
                        <div class="modal-title">Просмотр изображения</div>
                    </div>
                    <div class="modal-body">
                        <img class="img-responsive center-block" src="" alt="">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>
