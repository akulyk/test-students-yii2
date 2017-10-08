<?php

use yii\grid\GridView;
use \application\entities\Student\Student;
use application\grids\columns\HighlightedColumn;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */

$this->title = 'Students Managment System';
?>

<div class="search-form">
    <?php $form = ActiveForm::begin(['options'=>['class'=>'form-inline'],
    'method'=>'get']);?>

        <?php echo $form->field($searchForm,'query')
        ->input('text',['class'=>'form-control'])->label(false);
            ?>


        <?php   echo Html::submitButton('Search', ['class' => 'btn btn-primary', 'name' => 'search-button']);?>
            &nbsp;
        <?php   echo Html::a('Reset',[''], ['class' => 'btn btn-danger',
                'name' => 'reset-button',
           //     'onclick'=>"return resetForm(this.form);"
            ]) ?>

    <?php ActiveForm::end();?>
</div>

<div class="site-index">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [

            'id',
            ['attribute' => 'firstname',
                'value' => function($model)use ($searchForm){
                return HighlightedColumn::highlight($model->firstname,$searchForm->query);
                },
                'format'=>'raw'
            ],
            ['attribute' => 'lastname',
                'value' => function($model)use ($searchForm){
                    return HighlightedColumn::highlight($model->lastname,$searchForm->query);
                },
                'format'=>'raw'
            ],
            ['attribute'=>'birthdate',
             'value'=>function($model){
               return $model->getBirthdate();
                }
            ],
            ['attribute'=>'gender',
            'value'=>function($model){
                return $model->getGender();
            },
                'filter'=>Student::getGenders()
            ],
            ['attribute'=>'residence',
                'value'=>function($model){
                    return $model->getResidence();
                },
                'filter'=>Student::getResidenceStates()
            ],
            ['attribute' => 'group_number',
                'value' => function($model)use ($searchForm){
                    return HighlightedColumn::highlight($model->group_number,$searchForm->query);
                },
                'format'=>'raw'
            ],
            ['attribute' => 'rates',
                'value' => function($model)use ($searchForm){
                    return HighlightedColumn::highlight($model->rates,$searchForm->query);
                },
                'format'=>'raw'
            ],

           


        ],
    ]); ?>

</div>
