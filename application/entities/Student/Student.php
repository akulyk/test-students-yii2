<?php

namespace application\entities\Student;

use Yii;
use application\entities\User\User;

/**
 * This is the model class for table "{{%student}}".
 *
 * @property integer $id
 * @property string $firstname
 * @property string $lastname
 * @property integer $birthdate
 * @property string $gender
 * @property string $group_number
 * @property string $residence
 * @property integer $rates
 * @property integer $user_id
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property User $user
 */
class Student extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%student}}';
    }

    /**
     * @inheritdoc
     */

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'firstname' => 'Firstname',
            'lastname' => 'Lastname',
            'birthdate' => 'Birthdate',
            'gender' => 'Gender',
            'group_number' => 'Group Number',
            'residence' => 'Residence',
            'rates' => 'Rates',
            'user_id' => 'User ID',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }/**/

    public static function create(string $firstname,
                                  string $lastname,
                                  string $gender,
                                  string $birthdate,
                                  string $residence,
                                  string $group_number,
                                  int $rates,
                                  int $user_id = 0): self
    {
        $student = new Student();
        $student->firstname    = ucfirst($firstname);
        $student->lastname     = ucfirst($lastname);
        $student->gender       = $gender;
        $student->birthdate    = (!is_numeric($birthdate)) ? strtotime($birthdate) : $birthdate;
        $student->residence    = $residence;
        $student->group_number = $group_number;
        $student->rates        = $rates;
        $student->user_id      = $user_id;
        $student->created_at   = time();
        $student->updated_at   = time();

        return $student;
    }/**/





    public function getFullname(){
        return $this->firstname . ' ' . $this->lastname;
    }

    public function getResidence(){
        $residences = static::getResidenceStates();
        if(array_key_exists($this->residence,$residences)) {
            return $residences[$this->residence];
        }
    }/**/

    public function getGender(){
        $genders = static::getGenders();
        if(array_key_exists($this->gender,$genders)) {
            return $genders[$this->gender];
        }
    }/**/

    public function getBirthdate(){
        return date("Y-m-d",$this->birthdate);
    }

    public function getEmail(){
        return $this->user->email;
    }

    public static function getGenders(){

        return ['M'=>'Male','F'=>'Female'];

    }/**/

    public static function getResidenceStates(){

        return ['local'=>'Local','foreign'=>'Foreign'];

    }/**/




}/* end of Entity */
