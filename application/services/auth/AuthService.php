<?php

namespace application\services\auth;

use Yii;
use application\entities\User\User;
use application\forms\auth\LoginForm;
use application\repositories\UserRepository;

class AuthService
{

    private $users;

    public function __construct(UserRepository $users)
    {
        $this->users = $users;

    }/**/

    public function auth(LoginForm $form): ?User
    {

        $user = $this->getUser($form);

        if (!$user || !$user->isActive() || !$user->validatePassword($form->password)) {

            $message = 'Undefined user or password.'.PHP_EOL;

            throw new \DomainException(nl2br($message));
        }

        return $user;
    }/**/


    /*
     * get user
     * @return User
     */
    public function getUser(LoginForm $form): ?User
    {
        $user = $this->users->findByEmail($form->email);

        return $user;
    }/**/

}/* end of Service */