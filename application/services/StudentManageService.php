<?php

namespace application\services;

use application\forms\student\UpdateForm;
use application\entities\Student\Student;
use application\entities\User\User;
use application\repositories\UserRepository;
use application\repositories\StudentRepository;
use yii\mail\MailerInterface;

class StudentManageService
{

    private $users;
    private $students;

    public function __construct(UserRepository $users, StudentRepository $students)
    {
        $this->students = $students;
        $this->users = $users;
    }


    public function update(UpdateForm $form,Student $student):bool
    {
        $student->firstname    = ucfirst($form->firstname);
        $student->lastname     = ucfirst($form->lastname);
        $student->gender       = $form->gender;
        $student->birthdate    = (!is_numeric($form->birthdate)) ? strtotime($form->birthdate) : $form->birthdate;
        $student->residence    = $form->residence;
        $student->group_number = $form->group_number;
        $student->rates        = $form->rates;

        $user = $student->user;
        $user->email = $form->email;


        return $this->users->save($user) && $this->students->save($student);

    }/**/

    public function add(User $user,Student $student){

        if($this->users->save($user)){
            $student->user_id = $user->id;
            return  $this->students->save($student);
        }

        return false;

    }/**/


}