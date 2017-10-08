<?php
namespace application\forms\auth;

use yii\base\Model;
use application\entities\Student\Student;

/**
 * Signup form
 */
class StudentForm extends Model
{
    public $firstname;
    public $lastname;
    public $birthdate;
    public $gender;
    public $residence;
    public $group_number;
    public $rates;



    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['firstname', 'trim'],
            ['firstname', 'required'],
            ['firstname', 'string', 'min' => 2, 'max' => 100],

            ['lastname', 'trim'],
            ['lastname', 'required'],
            ['lastname', 'string', 'min' => 2, 'max' => 100],

            ['birthdate', 'trim'],
            ['birthdate', 'required'],
            ['birthdate', 'date', 'format' => 'php:Y-m-d'],
            ['birthdate', 'validateAge' ],

            ['gender', 'required'],
            ['gender', 'validateGender'],

            ['residence', 'required'],
            ['residence', 'validateResidence'],

            ['group_number', 'trim'],
            ['group_number', 'required'],
            ['group_number', 'string', 'min' => 1, 'max' => 5],

            ['rates', 'trim'],
            ['rates', 'required'],
            ['rates', 'integer', 'min' => 1, 'max' => 200],


        ];
    }/**/


    public function validateGender($attribute,$params){
        if (!array_key_exists($this->$attribute,$this->getGenders())) {
            $this->addError($attribute, 'The gender could be either "Male" or "Female".');
        }
    }/**/

    public function validateResidence($attribute,$params){
        if (!array_key_exists($this->$attribute,$this->getResidenceStates())) {
            $this->addError($attribute, 'The residence could be either "Local" or "Foreign".');
        }
    }/**/

    public function validateAge($attribute,$params){
      $birthday = strtotime($this->$attribute);
      $sixteen  = mktime( date("H"),  date("i"),  date("s"), date("m"),   date("d"),   date("Y")-16);
      $ninety  = mktime( date("H"),  date("i"),  date("s"), date("m"),   date("d"),   date("Y")-90);
       if($birthday > $sixteen){
           $this->addError($attribute, 'You must be a 16 years old.');
       }

        if($birthday < $ninety){
            $this->addError($attribute, 'The max age cannot be more than 90 years.');
        }


    }


    public function getGenders(){

     return Student::getGenders();

    }/**/

    public function getResidenceStates(){

        return Student::getResidenceStates();

    }/**/

}
