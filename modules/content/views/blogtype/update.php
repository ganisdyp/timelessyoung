<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Blogtype */

$this->title = Yii::t('app', 'Update Blog Category: {nameAttribute}', [
    'nameAttribute' => $model->id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Blog Types'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="blog-type-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
