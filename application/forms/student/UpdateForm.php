<?php
namespace application\forms\student;

use application\entities\Student\Student;
use application\entities\User\User;
use yii\base\Model;
use application\forms\auth\StudentForm;
use application\forms\auth\SignupForm;
use yii\helpers\ArrayHelper;
/**
 * Signup form
 */
class UpdateForm extends StudentForm
{
    public $email;





    /**
     * @inheritdoc
     */
    public function rules()
    {
        return ArrayHelper::merge(parent::rules(),SignupForm::EmailRules(),
            [
                [['email'], 'unique', 'on'=>'update', 'when' => function($model,$attribute){
                    $user = User::findByEmail($this->$attribute);
                    return ($user !== null && $user->id !== \Yii::$app->user->id);


                },
                    'targetClass' => User::class,
                    'message' => 'This email address has already been taken.'],
            ]);
    }/**/

    public function fillFromModel(Student $student){

        $properties = (new \ReflectionClass($this))->getProperties(\ReflectionProperty::IS_PUBLIC);
        foreach ($properties as $property) {
            $this->{$property->getName()} = $student->{$property->getName()};
        }

        $this->prepareBirthdate();


    }/**/



    protected function prepareBirthdate(){
        $this->birthdate = date("Y-m-d",$this->birthdate);
    }



}
