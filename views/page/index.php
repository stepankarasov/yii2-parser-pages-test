<?php

/** @var $searchModel app\models\page\PageSearch */
/** @var $dataProvider yii\data\ActiveDataProvider */
/** @var $model app\models\page\Page */
/** @var $this yii\web\View */

$this->title = 'Список спарсенных страниц';
$this->params['breadcrumbs'][] = $this->title;

use yii\helpers\Html;
use yii\helpers\Url; ?>

<div class="page-header row no-gutters py-4">
    <div class="panel panel-default">
        <div class="panel-heading">
            <?= Html::a('Спарсить новую страницу', Url::to(['page/create']), ['class' => 'btn btn-primary']) ?>
        </div>
        <div class="panel-body">
            <?= $this->render('_grid', [
                'dataProvider' => $dataProvider,
                'searchModel'  => $searchModel
            ]); ?>
        </div>
    </div>
</div>
