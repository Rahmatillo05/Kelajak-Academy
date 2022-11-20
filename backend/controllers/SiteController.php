<?php

namespace backend\controllers;

use backend\models\UserForm;
use common\models\Contact;
use common\models\Member;
use common\models\User;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;


/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index', 'users', 'setting', 'help','delete','update'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => \yii\web\ErrorAction::class,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
    public function actionSetting()
    {
        return $this->render('setting');
    }
    public function actionUsers()
    {
        $teacher = new ActiveDataProvider([
            'query'=> Member::find()->where(['status'=>10, 'type'=>10]),
            'pagination'=>[
                'pageSize'=>4
            ]
        ]);
        $parents = new ActiveDataProvider([
            'query'=> Member::find()->where(['status'=>10, 'type'=>0]),
        ]);
        $child = new ActiveDataProvider([
            'query'=> Member::find()->where(['status'=>10, 'type'=>5]),
            'pagination'=>[
                'pageSize'=>4
            ]
        ]);
        return $this->render('users', compact('teacher','parents','child'));
    }
    public function actionHelp()
    {
        $inactive = new ActiveDataProvider([
            'query' => Contact::find()->where(['status'=> 0]),
            'pagination'=>[
                'pageSize'=>4
            ]
        ]);
        $active = new ActiveDataProvider([
            'query' => Contact::find()->where(['status'=> 1]),
            'pagination'=>[
                'pageSize'=>4
            ]
        ]);
        return $this->render('help', ['help'=>$inactive, 'active'=>$active]);
    }
    public function actionUpdate($id){
        $model = Contact::findOne($id);

        if ($this->request->isPost && $model->load($this->request->post())) {
                if ($model->save()) {
                    return $this->redirect(['help']);
                }
        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }
    public function actionDelete($id)
    {
        Contact::findOne($id)->delete();

        return $this->redirect(['help']);
    }
    /**
     * Login action.
     *
     * @return string|Response
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $this->layout = 'main-login';

        $model = new UserForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
