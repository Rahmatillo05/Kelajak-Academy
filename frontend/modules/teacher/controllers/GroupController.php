<?php

namespace frontend\modules\teacher\controllers;

use app\models\Coursegroupdate;
use common\models\Group;
use common\models\GroupPupilList;
use common\models\search\GroupQuery;
use frontend\modules\control\controllers\BaseController;
use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\VarDumper;
use yii\web\NotFoundHttpException;
use common\models\UseMember;


/**
 * GroupController implements the CRUD actions for Group model.
 */
class GroupController extends BaseController
{

    /**
     * Lists all Group models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new GroupQuery();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Group model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = new ActiveDataProvider([
            'query' => GroupPupilList::find()->where(['group_id' => $id])
        ]);

        $pupils = new GroupPupilList();

        return $this->render('view', [
            'model' => $model,
            'pupils' => $pupils
        ]);
    }

    /**
     * Creates a new Group model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Group();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['index']);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionDate()
    {
        $model = new Coursegroupdate();

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->group_id = $_GET['group_id'];
                $model->course_id = $_GET['course_id'];
                if ($model->save()) {
                    return $this->redirect(['index']);
                }
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('date', [
            'model' => $model,
        ]);
    }
    /**
     * Updates an existing Group model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Group model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * It takes the id of a group and adds a pupil to that group.
     * 
     * @param id the id of the group
     * 
     * @return The return value of the action is the response object.
     */
    public function actionAddPupil($id)
    {
        $model = new GroupPupilList();
        if (Yii::$app->request->isPost) {
            $pupil_id = Yii::$app->request->post('pupil');
            if ($model->add($id, $pupil_id)) {
                return $this->redirect(Yii::$app->request->referrer);
            } else {
                VarDumper::dump($model->errors);
                return false;
            }
        }
        return $this->render('add-pupil', compact('model'));
    }

    public function actionNewPupil($id)
    {
        $model = new UseMember();
        $group = new GroupPupilList();
        if (Yii::$app->request->isPost && $model->load(Yii::$app->request->post())) {
            $model->type = $model::PUPIL;
            $model->status = $model::STATUS_ACTIVE;
            if ($model->signUp() && $group->add($id, $model->id)) {
                return $this->redirect(['view', 'id' => $id]);
            } else {
                $model->loadDefaultValues();
            }
        }

        return $this->render('_pupil-form', [
            'model' => $model
        ]);
    }

    /**
     * Finds the Group model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Group the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Group::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
