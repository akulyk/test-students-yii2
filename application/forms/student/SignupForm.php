<?php
namespace application\forms\auth;

use yii\base\Model;
use application\entities\User\User;
use application\forms\auth\StudentForm;

/**
 * Signup form
 */
class SignupForm extends Model
{

    public $email;
    public $password;
    public $password_repeat;

    private $_student;

    public function __construct($config = [])
    {
        $this->_student = new StudentForm();
        parent::__construct($config);
    }/**/

    public function load($data, $formName = null)
    {
        $loadSelf = parent::load($data, $formName);
        $loadStudent = $this->_student->load($data, $formName === null ? null : 'student');


        return $loadSelf && $loadStudent;
    }

    public function validate($attributeNames = null, $clearErrors = true)
    {
        $validateSelf = parent::validate($attributeNames, $clearErrors);
        $validStudent = $this->_student->validate(null, $clearErrors);

        return $validateSelf && $validStudent;
    }/**/

    public function getStudent(){

        return $this->_student;

    }/**/

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [


            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => User::class, 'message' => 'This email address has already been taken.'],

            [['password','password_repeat'], 'required'],
            [['password','password_repeat'], 'string', 'min' => 6],
            ['password_repeat', 'compare', 'compareAttribute' => 'password'],
        ];
    }/**/




}/**/
