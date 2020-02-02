<?php

namespace app\modules\content\controllers;

use Yii;
use yii\base\Model;
use app\models\Blog;
use app\models\BlogPhoto;
use app\modules\content\models\BlogSearch;
use app\models\User;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\components\TimelessyoungRule;
use yii\web\UploadedFile;

/**
 * BlogController implements the CRUD actions for Blog model.
 */
class BlogController extends Controller
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
                    'delete' => ['POST'],
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
     * Lists all Blog models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BlogSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Blog model.
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
     * Creates a new Blog model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    /*    public function actionCreate()
        {
            $model = new Blog();

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }

            return $this->render('create', [
                'model' => $model,
            ]);
        }*/
    public function actionCreate()
    {
        $model = new Blog();
        $modelDetails = [];

        $formDetails = Yii::$app->request->post('BlogPhoto', []);

        //   print_r($formDetails);
        foreach ($formDetails as $i => $formDetail) {
            $modelDetail = new BlogPhoto(['scenario' => BlogPhoto::SCENARIO_BATCH_UPDATE]);
            $modelDetail->setAttributes($formDetail);
            $modelDetails[] = $modelDetail;
        }

        //handling if the addRow button has been pressed
        if (Yii::$app->request->post('addRowPhoto') == 'true') {
            $model->load(Yii::$app->request->post());
            $modelDetails[] = new BlogPhoto(['scenario' => BlogPhoto::SCENARIO_BATCH_UPDATE]);
            return $this->render('create', [
                'model' => $model,
                'modelDetails' => $modelDetails,

            ]);
        }

        if ($model->load(Yii::$app->request->post())) {


            if ($model->validate()) {

                //print_r($model);
                $file = UploadedFile::getInstance($model, 'main_photo_file');
                if (isset($file->size) && $file->size != 0) {
                    $unique_name = "blog_" . date("Y-m-d_H-i-s") . "_" . uniqid();
                    $path = $unique_name . ".{$file->extension}";
                    $model->main_photo = $path;
                    $file->saveAs('uploads/blog/' . $path);

                    /* $model->main_photo = $file->baseName . '.' . $file->extension;
                     $file->saveAs('uploads/blog/' . $file->baseName . '.' . $file->extension);*/
                }
                $model->save();
                //  print_r($model);
                if (Model::validateMultiple($modelDetails)) {


                    foreach ($modelDetails as $c => $modelDetail) {

                        ${'profile_file' . $c} = UploadedFile::getInstance($modelDetail, '[' . $c . ']' . 'blog_photo');
                        if (isset(${'profile_file' . $c}->size) && ${'profile_file' . $c}->size != 0) {

                            $unique_name = "blog_" . date("Y-m-d_H-i-s"). "_".uniqid();
                            $path = $unique_name . ".{${'profile_file' . $c}->extension}";
                            $modelDetail->photo_url = $path;
                            //     $modelDetail->photo_url = ${'profile_file' . $c}->baseName . '.' . ${'profile_file' . $c}->extension;
                            ${'profile_file' . $c}->saveAs('uploads/blog/related_photo/' . $path);
                        }
                        $modelDetail->blog_id = $model->id;
                        $modelDetail->save();
                    }

                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }
            //return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'modelDetails' => $modelDetails,
        ]);
    }
    /**
     * Updates an existing Blog model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    /*  public function actionUpdate($id)
      {
          $model = $this->findModel($id);

          if ($model->load(Yii::$app->request->post()) && $model->save()) {
              return $this->redirect(['view', 'id' => $model->id]);
          }

          return $this->render('update', [
              'model' => $model,
          ]);
      }*/
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $modelDetails = $model->blogPhotos;
        $formDetails = Yii::$app->request->post('BlogPhoto', []);

        foreach ($formDetails as $i => $formDetail) {
            //loading the models if they are not new
            if (isset($formDetail['id']) && isset($formDetail['updateType']) && $formDetail['updateType'] != BlogPhoto::UPDATE_TYPE_CREATE) {
                //making sure that it is actually a child of the main model
                $modelDetail = BlogPhoto::findOne(['id' => $formDetail['id'], 'blog_id' => $model->id]);
                $modelDetail->setScenario(BlogPhoto::SCENARIO_BATCH_UPDATE);
                $modelDetail->setAttributes($formDetail);
                $modelDetails[$i] = $modelDetail;
                //validate here if the modelDetail loaded is valid, and if it can be updated or deleted
            } else {
                $modelDetail = new BlogPhoto(['scenario' => BlogPhoto::SCENARIO_BATCH_UPDATE]);
                $modelDetail->setAttributes($formDetail);
                $modelDetails[] = $modelDetail;
            }

        }


        //handling if the addRow button has been pressed
        if (Yii::$app->request->post('addRowPhoto') == 'true') {
            $modelDetails[] = new BlogPhoto(['scenario' => BlogPhoto::SCENARIO_BATCH_UPDATE]);
            return $this->render('update', [
                'model' => $model,
                'modelDetails' => $modelDetails,
            ]);
        }


        if ($model->load(Yii::$app->request->post())) {


            if (Model::validateMultiple($modelDetails) && $model->validate()) {
                $file = UploadedFile::getInstance($model, 'main_photo_file');
                //print_r($file);
                if (isset($file->size) && $file->size !== 0) {
                    $old_name = $model->main_photo;
                    $unique_name = "blog_" . date("Y-m-d_H-i-s") . "_" . uniqid();
                    $path = $unique_name . ".{$file->extension}";
                    $model->main_photo = $path;
                    $file->saveAs('uploads/blog/' . $path);
                    if (isset($old_name)) {
                        if($model->media_type==1){
                        unlink('uploads/blog/' . $old_name);
                        }
                    } else {
                        // Do nothing
                    }
                    /*  $model->main_photo = $file->baseName . '.' . $file->extension;
                      $file->saveAs('uploads/blog/' . $file->baseName . '.' . $file->extension);*/
                }
                $model->save();
                foreach ($modelDetails as $c => $modelDetail) {
                    //details that has been flagged for deletion will be deleted
                    if ($modelDetail->updateType == BlogPhoto::UPDATE_TYPE_DELETE) {
                        $modelDetail->delete();
                    } else {
                        //new or updated records go here
                        ${'profile_file' . $c} = UploadedFile::getInstance($modelDetail, '[' . $c . ']' . 'blog_photo');
                        if (isset(${'profile_file' . $c}->size) && ${'profile_file' . $c}->size != 0) {
                            $old_name = $modelDetail->photo_url;
                            $unique_name = "blog_" . date("Y-m-d_H-i-s") . "_" . uniqid();
                            $path = $unique_name . ".{${'profile_file' . $c}->extension}";
                            $modelDetail->photo_url = $path;
                            ${'profile_file' . $c}->saveAs('uploads/blog/related_photo/' . $path);
                            if (isset($old_name)) {
                                unlink('uploads/blog/related_photo/' . $old_name);
                            } else {
                                // Do nothing
                            }


                            //    $modelDetail->photo_url = ${'profile_file' . $c}->baseName . '.' . ${'profile_file' . $c}->extension;
                            //   ${'profile_file' . $c}->saveAs('uploads/blog/related_photo/' . ${'profile_file' . $c}->baseName . '.' . ${'profile_file' . $c}->extension);
                        }
                        $modelDetail->blog_id = $model->id;
                        $modelDetail->save();
                    }
                }

                return $this->redirect(['view', 'id' => $model->id]);
            }
        }


        return $this->render('update', [
            'model' => $model,
            'modelDetails' => $modelDetails,

        ]);

    }

    /**
     * Deletes an existing Blog model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {

        $blog_langs = $this->findModel($id)->getBlogLangs()->where(['blog_id' => $id])->all();
        foreach ($blog_langs as $blog_lang) {
            $blog_lang->delete();
        }
        $blog_photos = $this->findModel($id)->getBlogPhotos()->where(['blog_id' => $id])->all();
        foreach ($blog_photos as $blog_photo) {
            unlink('uploads/blog/related_photo/' . $blog_photo->photo_url);
            $blog_photo->delete();
        }
        if (isset($this->findModel($id)->main_photo)) {
            unlink('uploads/blog/' . $this->findModel($id)->main_photo);
        } else {

        }
        $this->findModel($id)->delete();

        return $this->redirect(['index']);

    }

    /**
     * Finds the Blog model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Blog the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Blog::find()->multilingual()->where(['blog.id' => $id])->one()) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
