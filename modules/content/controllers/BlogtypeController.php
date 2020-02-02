<?php

namespace app\modules\content\controllers;

use Yii;
use app\models\Blogtype;
use app\modules\content\models\BlogtypeSearch;
use app\models\User;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\components\TimelessyoungRule;
use yii\web\UploadedFile;


/**
 * BlogTypeController implements the CRUD actions for Blogtype model.
 */
class BlogtypeController extends Controller
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
     * Lists all Blogtype models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BlogtypeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Blogtype model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Blogtype model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Blogtype();

        if ($model->load(Yii::$app->request->post())) {
            $file = UploadedFile::getInstance($model, 'main_photo_file');
            if (isset($file->size) && $file->size !== 0) {
                $unique_name = "blog-type_" . date("Y-m-d_H-i-s") . "_" . uniqid();
                $path = $unique_name . ".{$file->extension}";
                $model->main_photo = $path;
                $file->saveAs('uploads/blog_type/' . $path);
            }
            $model->save();
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Blogtype model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $file = UploadedFile::getInstance($model, 'main_photo_file');

            if (isset($file->size) && $file->size !== 0) {

                $old_name = $model->main_photo;
                $unique_name = "blog-type_" . date("Y-m-d_H-i-s") . "_" . uniqid();
                $path = $unique_name . ".{$file->extension}";
                $model->main_photo = $path;
                $file->saveAs('uploads/blog_type/' . $path);
                if (isset($old_name)) {
                    unlink('uploads/blog_type/' . $old_name);
                } else {
                    // Do nothing
                }
            }
            $model->save();
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }


    /**
     * Deletes an existing Blogtype model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $blogtype_langs = $this->findModel($id)->getBlogTypeLangs()->where(['blog_type_id' => $id])->all();
        foreach ($blogtype_langs as $blogtype_lang) {
            $blogtype_lang->delete();
        }
        if (isset($this->findModel($id)->main_photo)) {
            unlink('uploads/blog_type/' . $this->findModel($id)->main_photo);
        } else {

        }
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Blogtype model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Blogtype the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Blogtype::find()->multilingual()->where(['blog_type.id' => $id])->one()) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
