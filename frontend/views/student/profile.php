<?php

use yii\widgets\DetailView;
use yii\helpers\Html;
/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>

<div class="student-profile">
    <h1>Student <strong><?=Html::encode($student->fullname);?></strong></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $student->id], ['class' => 'btn btn-primary']) ?>

    </p>
   <?=\common\widgets\Alert::widget();?>
   <?php

    echo DetailView::widget([
    'model' => $student,
    'attributes' => [
    'firstname',
    'lastname',
    ['attribute'=>'gender', 'value'=>$student->getGender()],
    ['attribute'=>'birthdate',
        'value'=> $student->getBirthdate()],
    ['attribute'=>'residence', 'value'=>$student->getResidence()],
    'group_number',
    'rates',

    [
    'label' => 'Email',
    'value' => $student->user->email,
    'contentOptions' => ['class' => 'bg-red'],
    'captionOptions' => ['tooltip' => 'Tooltip'],
    ],
    'created_at:datetime',
    'updated_at:datetime',
    ],
    ]);
    ?>
</div>


