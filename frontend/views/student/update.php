<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = $model->firstname . ' ' . $model->lastname;
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="site-signup">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please fill out the following fields to signup:</p>
    <?=\common\widgets\Alert::widget();?>
    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

                <?= $form->field($model, 'firstname') ?>

                <?= $form->field($model, 'lastname') ?>

                <?= $form->field($model, 'birthdate')->input('date') ?>

                <?= $form->field($model, 'gender')
                    ->dropdownList($model->getGenders(),['prompt'=>'Select your gender']) ?>

                <?= $form->field($model, 'residence')
                ->dropdownList($model->getResidenceStates(),['prompt'=>'Select your residance']) ?>

                <?= $form->field($model, 'group_number') ?>

                <?= $form->field($model, 'rates') ?>

                <?= $form->field($model, 'email') ?>



                <div class="form-group">
                    <?= Html::submitButton('Update', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
