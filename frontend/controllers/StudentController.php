<?php
namespace frontend\controllers;

use application\forms\student\UpdateForm;
use application\repositories\StudentRepository;
use application\services\StudentManageService;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\helpers\ArrayHelper;


/**
 * Site controller
 */
class StudentController extends DefaultController
{
   protected $studentRepository;
    protected $service;

    public function __construct($id, $module,
                                StudentRepository $studentRepository,
                                StudentManageService $studentManageService,
                                $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->studentRepository = $studentRepository;
        $this->service = $studentManageService;
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
    public function actionProfile()
    {
        $student = $this->studentRepository->getByUserID(Yii::$app->user->id);

        return $this->render('profile',['student'=>$student]);
    }/**/


    public function actionUpdate($id){
        $this->guardSelf($id);
        $form = new UpdateForm();
        $form->scenario = 'update';
        $student = $this->findStudent($id);

        if(!Yii::$app->request->isPost) {
            $form->fillFromModel($student);
        }

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->update($form, $student);
                Yii::$app->session->setFlash('success', "Your profile has been updated!");
                return $this->redirect(['profile']);
            } catch (\Exception $e){
                Yii::$app->session->setFlash('danger', $e->getMessage());
            }
        }


        return $this->render('update',['model'=>$form]);

    }/**/

    protected function guardSelf($id){
        $student = $this->findStudent($id);
        if ($student->user_id !== Yii::$app->user->id){
          throw new \RuntimeException('Access to another students profile restricted!');
        }
    }/**/

    protected function findStudent($id){

        if (($student = $this->studentRepository->get($id)) !== null) {
            return $student;
        } else {
            throw new NotFoundHttpException('The requested student does not exist.');
        }
    }/**/



}/* end of Controller */
