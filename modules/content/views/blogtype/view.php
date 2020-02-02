<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Blogtype */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Blog Types'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="blog-type-view">

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <div class="text-center">
        <?= Html::img(Yii::$app->getHomeUrl().'uploads/blog_type/' . $model->main_photo,
            ['class'=>'thumbnail','width'=>'250']); ?>
    </div>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute' => 'blogType.name_en',
                'value' => function ($model) {
                    return $model->name;
                },
                'label' => 'Name (EN)',
            ],
            [
                'attribute' => 'blogType.name_th',
                'value' => function ($model) {
                    return $model->name_th;
                },
                'label' => 'Name (TH)',
            ],
        ],
    ]) ?>

</div>
