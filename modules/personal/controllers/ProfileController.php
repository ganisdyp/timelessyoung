<?php

namespace app\modules\personal\controllers;

use Yii;
use app\models\Profile;
use app\modules\personal\models\ProfileSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\components\TimelessyoungRule;
use app\models\User;
use yii\web\UploadedFile;

/**
 * ProfileController implements the CRUD actions for Profile model.
 */
class ProfileController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['GET'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                // We will override the default rule config with the new AccessRule class
                'ruleConfig' => [
                    'class' => TimelessyoungRule::className(),
                ],
                'only' => ['index', 'create', 'update', 'delete'],
                'rules' => [
                    [
                        'actions' => ['index', 'create', 'update', 'delete'],
                        'allow' => true,
                        // Allow plant admin, moderators and admins to create
                        'roles' => [
                            User::ROLE_ADMIN
                        ],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Profile models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProfileSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Profile model.
     * @param integer $id
     * @param integer $user_id
     * @return mixed
     */
    public function actionView($id, $user_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id, $user_id),
        ]);
    }

    /**
     * Creates a new Profile model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Profile();
        $user = new User();

        if ($model->load(Yii::$app->request->post()) && $user->load(Yii::$app->request->post())) {
            $user->password_hash = Yii::$app->security->generatePasswordHash($user->password_hash);
            $user->auth_key = Yii::$app->security->generateRandomString();

            if ($user->save()) {
                $file = UploadedFile::getInstance($model, 'profile_img');
                if (isset($file->size) && $file->size != 0) {
                    $model->profile_photo = $user->id . '.' . $file->extension;
                    $file->saveAs('uploads/profile/' . $user->id . '.' . $file->extension);
                }

                $model->user_id = $user->id;
                $model->save();
            }
            //  var_dump($model);
            //  var_dump($user);
            return $this->redirect(['view', 'id' => $model->user_id, 'user_id' => $user->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'user' => $user,
            ]);
        }
    }

    /**
     * Updates an existing Profile model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @param integer $user_id
     * @return mixed
     */
    public function actionUpdate($id, $user_id)
    {
        $model = $this->findModel($id, $user_id);
        $user = $model->user;
        $oldPass = $user->password_hash;
        if ($model->load(Yii::$app->request->post()) && $user->load(Yii::$app->request->post())) {
            if ($oldPass != $user->password_hash) {
                $user->password_hash = Yii::$app->security->generatePasswordHash($user->password_hash);
            }
            if ($user->save()) {
                $file = UploadedFile::getInstance($model, 'profile_img');

                if (isset($file->size) && $file->size !== 0) {
                    $file->saveAs('uploads/profile/' . $user->id . '.' . $file->extension);
                }
                $model->save();
            }

            return $this->redirect(['view', 'id' => $model->id, 'user_id' => $model->user_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'user' => $user,
            ]);
        }
    }

    /**
     * Deletes an existing Profile model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @param integer $user_id
     * @return mixed
     */
    public function actionDelete($id, $user_id)
    {
        $this->findModel($id, $user_id)->delete();
        unlink('uploads/profile/'.$this->findModel($id)->profile_photo);
        return $this->redirect(['index']);
    }

    /**
     * Finds the Profile model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @param integer $user_id
     * @return Profile the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id, $user_id)
    {
        if (($model = Profile::findOne(['id' => $id, 'user_id' => $user_id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
