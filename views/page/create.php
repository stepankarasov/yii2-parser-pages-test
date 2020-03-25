<?php

/* @var $this yii\web\View */
/* @var $model app\models\page\Page */

$this->title = 'Спарсить новую страницу';
$this->params['breadcrumbs'][] = ['label' => 'Список спарсенных страниц', 'url' => ['/pages']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="page-header row no-gutters py-4">
    <div class="col-12  text-sm-left mb-0">
        <h3 class="page-title"><?= $this->title ?></h3>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>
</div>