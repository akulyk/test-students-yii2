<?php
namespace frontend\controllers;

use application\entities\Student\StudentSearch;
use application\forms\student\SearchForm;
use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use application\forms\auth\LoginForm;
use application\forms\auth\PasswordResetRequestForm;
use application\forms\auth\ResetPasswordForm;
use application\forms\auth\SignupForm;
use yii\helpers\ArrayHelper;
use application\services\Auth\AuthService;
use application\services\Auth\SignupService;

/**
 * Site controller
 */
class SiteController extends DefaultController
{
    private $authService;
    private $signupService;

    public function __construct($id, $module,
                                AuthService $service,
                                SignupService $snService,
                                $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->authService = $service;
        $this->signupService = $snService;
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
       return ArrayHelper::merge(parent::behaviors(),[]);
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new StudentSearch();
        $form = new SearchForm();
        $form->load(Yii::$app->request->queryParams);
      //  var_dump(Yii::$app->request->queryParams,$form->load(Yii::$app->request->queryParams),$form);die;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$form);


        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'searchForm' =>$form
        ]);

    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {

        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }



        $form = new LoginForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $user = $this->authService->auth($form);
                Yii::$app->user->login($user, $form->rememberMe ? 3600 * 24 * 30 : 0);
                Yii::$app->session->setFlash('success', "You successfully logged in!");

                return $this->goBack();
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }

        }


        return $this->render('login', [
            'model' => $form,
        ]);
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }


    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $form = new SignupForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            $user = $this->signupService->signup($form);
            Yii::$app->user->login($user);
            Yii::$app->session->setFlash('success', "You successfully signed in!");
            return $this->goHome();
        }

        return $this->render('signup', [
            'model' => $form,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }
}
