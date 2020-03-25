<?php

use app\models\page\Page;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\page\Page */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="transaction-form">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, Page::ATTR_URL)->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Спарсить',
            [
                'class' => 'btn btn-primary'
            ]) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
