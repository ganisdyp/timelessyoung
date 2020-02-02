<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use fedemotta\datatables\DataTables;
/* @var $this yii\web\View */
/* @var $searchModel backend\modules\content\models\BlogtypeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Blog Categories');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="blog-type-index">

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Add Blog Category'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= DataTables::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            ['attribute' => 'main_photo',
                'format' => 'html',
                'value' => function ($dataProvider) {
                    return Html::img(Yii::$app->getHomeUrl().'uploads/blog_type/' . $dataProvider->main_photo,
                        ['class'=>'thumbnail','width'=>'80']);
                }
            ],
            [
                'attribute' => 'blogType.name_en',
                'value' => function ($dataProvider) {
                    return $dataProvider->name;
                },
                'label' => 'Name (EN)',
            ],
            [
                'attribute' => 'blogType.name_th',
                'value' => function ($dataProvider) {
                    $name_th = $dataProvider->getBlogTypeLangs()->where(['blog_type_lang.blog_type_id' => $dataProvider->id, 'blog_type_lang.language' => 'th'])->one();
                    return $name_th->name;
                },
                'label' => 'Name (TH)',
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
