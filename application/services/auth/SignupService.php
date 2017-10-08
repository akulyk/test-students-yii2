<?php

namespace application\services\auth;

use application\entities\User\User;
use application\entities\Student\Student;
use application\forms\auth\SignupForm;
use application\repositories\UserRepository;
use application\repositories\StudentRepository;
use yii\mail\MailerInterface;

class SignupService
{

    private $users;
    private $students;

    public function __construct(UserRepository $users, StudentRepository $students)
    {
        $this->students = $students;
        $this->users = $users;
    }

    public function signup(SignupForm $form):?User
    {
        $user = User::create(
            $form->email,
            $form->password
        );
      if($this->users->save($user)){
          $student = Student::create(
              $form->student->firstname,
              $form->student->lastname,
              $form->student->gender,
              $form->student->birthdate,
              $form->student->residence,
              $form->student->group_number,
              $form->student->rates,
              $user->id
          );
         if($this->students->save($student)){
             return $user;
         };
      }

    }/**/


}