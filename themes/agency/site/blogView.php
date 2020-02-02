<?php
/**
 * Created by PhpStorm.
 * User: clbs
 * Date: 5/4/2018
 * Time: 1:25 AM
 */
use app\models\BlogSearch;
use yii\helpers\Html;

$this->title = Yii::t('app', 'Blog');
Yii::$app->layout='page_header';
$directoryAsset = Yii::$app->assetManager->getPublishedUrl('@dixonsatit/agencyTheme/dist');
$searchModel = new BlogSearch();
$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
$blog = $dataProvider->query->where(['id' => $_GET['id']])->one();
define('PAGE_NAME', 'blog');
?><header style="background-image:url(<?=$directoryAsset.'/img/header-bg2.jpg'?>);">
    <div class="container">
        <div class="intro-text">

            <div class="intro-heading">Personal Blog</div>
            <div class="intro-lead-in">Punnicha Harnsirikamon</div>
        </div>
    </div>
</header>
<section class="page" id="blog-view">
<div id="blog-page" class="container">
    <nav class="mt-2">
        <ol class="breadcrumb smaller-90 mb-2">
            <li class="breadcrumb-item"><a
                        href="<?php echo Yii::$app->request->BaseUrl ?>/site/index"><?php echo Yii::t('app', 'Home'); ?></a>
            </li>
            <li class="breadcrumb-item bold"><a
                        href="<?php echo Yii::$app->request->BaseUrl ?>/site/blog-category"><?= $blog->blogType->name; ?></a>
            </li>
            <li class="breadcrumb-item active"><?= $blog->headline; ?></li>
        </ol>
    </nav>
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-12">
            <?php $date_publish = date_create($blog->date_published); ?>
            <p class="bigger-160 mb-1 text-purple font-weight-normal"><?= strtoupper(date_format($date_publish, "j F Y") . " - " . $blog->headline); ?></p>
        </div>
        <div class="col-md-6 col-12">

        </div>
    </div>
    <div class="row mt-3 mb-5">
        <div class="col-lg-5 col-12">
            <?php $media_type = $blog->media_type;
            if ($media_type == 1) { ?>
                <iframe width="100%" height="280" src="<?= $blog->main_photo; ?>" allowfullscreen></iframe>
            <?php } else { ?>
                <a href="<?php echo Yii::$app->request->BaseUrl ?>/uploads/blog/<?= $blog->main_photo; ?>"
                   data-lightbox="trip">
                    <div class="">
                        <img class="card-img-top img-responsive corner-0"
                             src="<?php echo Yii::$app->request->BaseUrl ?>/uploads/blog/<?= $blog->main_photo; ?>">
                    </div>
                </a>
            <?php } ?>

            <div class="row no-gutters mt-3">
                <?php
                $related_photos = $blog->getBlogPhotos()->where(['blog_id' => $blog->id])->all();

                foreach ($related_photos as $photo) { ?>
                    <div class="col-2 pr-2 mb-2">
                        <a href="<?= Yii::$app->getHomeUrl() . 'uploads/blog/related_photo/' . $photo->photo_url; ?>"
                           data-lightbox="trip">
                            <div class="img-1by1 holder">
                                <?= Html::img(Yii::$app->getHomeUrl() . 'uploads/blog/related_photo/' . $photo->photo_url,
                                    ['class' => 'thumbnail inline', 'width' => '100']) . " "; ?>
                            </div>
                        </a>
                    </div>
                <?php } ?>
            </div>
        </div>
        <div class="col-lg-7 col-12">
            <hr class="my-2">
            <div class=""> <?= $blog->description; ?></div>
            <hr class="my-2">
            <?php if ($blog->keyword) {
                $keywords = explode(",", $blog->keyword);
                foreach ($keywords as $keyword) {
                    ?>
                    <span title="Keyword" class="badge badge-info"
                          style="font-size:11pt; font-weight:normal;background-color:#0085BA;"> <b> <?php echo ltrim(rtrim($keyword)); ?>
                        </b></span>
                <?php }
            } ?>
        </div>
    </div>
</div>
</div>
</section>
