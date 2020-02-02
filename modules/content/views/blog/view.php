<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Blog */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Activities'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="acvity-view">

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
        <?php

        $media_type = $model->media_type;
        if ($media_type == 1) {
            ?>
            <iframe width="480" height="320" src="<?= $model->main_photo; ?>"
                    allowfullscreen></iframe>
        <?php } else {
            echo Html::img(Yii::$app->getHomeUrl() . 'uploads/blog/' . $model->main_photo,
                ['class' => 'thumbnail', 'width' => '250']);
        }

        ?>
    </div>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [

            //  'id',
            'headline',

            [
                'attribute' => 'blogType.name',
                'value' => function ($model) {
                    $name_en = $model->blogType->getBlogTypeLangs()->where(['blog_type_lang.blog_type_id' => $model->blog_type_id, 'blog_type_lang.language' => 'en'])->one();
                    $name_th = $model->blogType->getBlogTypeLangs()->where(['blog_type_lang.blog_type_id' => $model->blog_type_id, 'blog_type_lang.language' => 'th'])->one();
                    return $name_en->name . " (" . $name_th->name . ")";

                },
                'label' => 'Category',
            ],

            'date_published',

        ],
    ]) ?>

    <?php


    $related_photos = $model->getBlogPhotos()->where(['blog_id' => $model->id])->all();

    foreach ($related_photos as $photo) {

        echo Html::img(Yii::$app->getHomeUrl() . 'uploads/blog/related_photo/' . $photo->photo_url,
                ['class' => 'thumbnail inline', 'width' => '100']) . " ";
    }


    $this->registerJs(' 
//checkFile("' . $model->main_photo . '");
    
function checkFile(file) {
  var extension = file.substr((file.lastIndexOf(' . ') +1));
  if (!/(mp4)$/ig.test(extension)) {
     //alert("Image!");
     $(\'#video-box\').hide();
     $(\'#image-box\').show();
  }else{
     //alert("Video!");
     $(\'#image-box\').hide();
     $(\'#video-box\').show();
  }
}
    ', \yii\web\View::POS_READY);

    ?>

</div>
