<?php
namespace console\controllers;

use application\entities\Student\Student;
use application\repositories\UserRepository;
use application\services\StudentManageService;
use application\entities\User\User;
use yii\console\Controller;
use Yii;

class SeederController extends Controller
{
    protected  $service;
    protected $faker;
    public function __construct($id, $module,
                                StudentManageService $studentManageService,
                                $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $studentManageService;
        $this->faker = \Faker\Factory::create();
    }

    public function actionSeed($q = 1){

        for($i = 1;$i<=$q;$i++) {
            $user = $this->addUser();
            $student = $this->addStudent();
            $this->service->add($user,$student);

            $this->stdout($student->getFullname() . ' created!'.PHP_EOL);
        }
    }/**/

    protected function addUser(){
        $user = User::create($this->faker->email,'secret');
        return $user;
    }/**/

    protected function addStudent(){

        $rand = rand(1,2);
        $firstname = $rand == 1 ? $this->faker->firstNameMale :$this->faker->firstNameFemale;
        $lastname = $this->faker->lastName;
        $birthdate= $this->faker->dateTimeBetween('-40 years', '-18 years');

        $gender =  $rand == 1 ? "M" : "F";
        $residence =  $rand == 1 ?  "local" : "foreign";

        $group_number =  $this->randomString(5);

        $rates = rand(0,200);


        $student = Student::create($firstname,$lastname,$gender,$birthdate->format("Y-m-d"),$residence,
            $group_number,$rates);

        return $student;
    }/**/

    protected function randomString($length = 5) {
        $str = "";
        $characters = array_merge(range('A','Z'), range('a','z'), range('0','9'));
        $max = count($characters) - 1;
        for ($i = 0; $i < $length; $i++) {
            $rand = mt_rand(0, $max);
            $str .= $characters[$rand];
        }
        return $str;
    }

}