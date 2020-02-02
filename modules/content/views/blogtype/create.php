<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Blogtype */

$this->title = Yii::t('app', 'Create Blog Category');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Blog Types'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="blog-type-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
