<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Signup';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please fill out the following fields to signup:</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

                <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>
				
				<?= $form->field($model, 'mobile_number') ?>
				
				<?= $form->field($model, 'otp') ?>

                <?= $form->field($model, 'email') ?>

                <?= $form->field($model, 'password')->passwordInput() ?>
				
				<?= $form->field($model, 'company_name')->textInput() ?>
				
				<?= $form->field($model, 'company_type') ?>
				
				<?= $form->field($model, 'address_line1')->textInput() ?>
				
				<?= $form->field($model, 'address_line2')->textInput() ?>
				
				<?= $form->field($model, 'address_line3')->textInput() ?>
				
				<?= $form->field($model, 'pincode') ?>
				
				<?= $form->field($model, 'street') ?>
				
				<?= $form->field($model, 'city') ?>
				
				

                <div class="form-group">
                    <?= Html::submitButton('Signup', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
