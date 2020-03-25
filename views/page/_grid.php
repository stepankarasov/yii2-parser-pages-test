<?php

use app\models\page\Page;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
?>

<?php Pjax::begin() ?>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'pager'        => [
        'linkContainerOptions'          => ['class' => 'page-item'],
        'linkOptions'                   => ['class' => 'page-link'],
        'disabledListItemSubTagOptions' => ['tag' => 'a', 'class' => 'page-link']
    ],
    'options'      => [
        'class' => 'table-responsive table-responsive-sm',
    ],
    'rowOptions'   => function ($model, $key, $index, $grid)
    {
        $class = $index % 2 ? 'odd' : 'even';

        return [
            'key'   => $key,
            'index' => $index,
            'class' => $class,
        ];
    },
    'tableOptions' => [
        'align' => 'center',
        'class' => 'table table-striped table-bordered table-hover text-center'
    ],
    'columns'      => [
        ['class' => 'yii\grid\SerialColumn'],
        [
            'attribute' => Page::ATTR_TITLE,
            'format'    => 'raw',
            'value'     => function ($data)
            {
                return Html::a($data->title, ['page/view', 'id' => $data->id]);
            },
        ],
        Page::ATTR_URL.':url',
        'createdAtFormatAdmin',
        'parsedAtFormatAdmin',
    ],
]);
?>

<?php Pjax::end() ?>
