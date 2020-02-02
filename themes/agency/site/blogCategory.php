<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use app\models\DC;
use app\models\BlogtypeSearch;
use app\models\BlogSearch;

define('PAGE_NAME', 'blog');
$this->title = Yii::t('app', 'Blog');
$this->params['breadcrumbs'][] = $this->title;
Yii::$app->layout='page_header';

$directoryAsset = Yii::$app->assetManager->getPublishedUrl('@dixonsatit/agencyTheme/dist');
$this->registerJsFile($directoryAsset.'/js/cbpAnimatedHeader.min.js');
//$category_list = DC::get_menu_brands();
$searchModel = new BlogtypeSearch();
$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
$blog_categories = $dataProvider->getModels();

$searchModel_blog = new BlogSearch();
$dataProvider_blog = $searchModel_blog->search(Yii::$app->request->queryParams);

$blog_list = $dataProvider_blog->query->orderBy(['date_published'=>SORT_DESC])->all();


?><header style="background-image:url(<?=$directoryAsset.'/img/header-bg2.jpg'?>);">
    <div class="container">
        <div class="intro-text">

            <div class="intro-heading">Personal Blog</div>
            <div class="intro-lead-in">Punnicha Harnsirikamon</div>
        </div>
    </div>
</header>
<section class="page" id="blog-category">
<div id="blog-page" class="container">
    <nav class="mt-2 fadeIn animated d07s">
      <ol class="breadcrumb smaller-90">
        <li class="breadcrumb-item"><a href="<?php echo Yii::$app->request->BaseUrl.'/site/index'; ?>"><?= Yii::t('app', 'Home'); ?></a></li>
        <li class="breadcrumb-item active"><?= Yii::t('app', 'Blog'); ?></li>
      </ol>
    </nav>
    <div class="row fadeIn animated d03s mt-3 mb-4">
      <?php /* foreach ($blog_categories as $blog_category) { ?>
      <div class="col-lg-4 col-md-6 col-12">
        <div class="card dc-card mb-4 corner-0 z-shadow fadeIn animated d03s">
          <a href="blog-list?id=<?= $blog_category->id; ?>&c=all" class="hover-box">
            <div class="img-16by9 holder">
              <img class="card-img-top img-responsive corner-0"
                src="/uploads/blog_type/<?= $blog_category->main_photo; ?>">
            </div>
          </a>
          <div class="card-body text-center">
            <a href="blog-list?id=<?= $blog_category->id; ?>&c=all"
              class="card-title font-weight-normal bigger-110 my-0 block"><?= $blog_category->name; ?></a>
          </div>
        </div>
      </div>
      <?php } */ ?>
      <?php foreach ($blog_list as $blog) { ?>
      <div class="col-md-6 mb-lg-0 mb-4 viewpoint-animate d03s" data-animation="fadeIn">

          <div class="card card-event">
            <div class="card-image pos-rel">
              <div class="media-wrapper">
                <?php if ($blog->media_type == 1) { ?>
                <iframe width="100%" height="360" src="<?= $blog->main_photo; ?>"
                  allowfullscreen></iframe>
                <?php } else { ?>
                  <div class="img-3by2 holder">
                    <img class="card-img-top img-fluid"
                      src="../uploads/blog/<?= $blog->main_photo; ?>" width="100%" height="360">
                  </div>
                <?php } ?>
              </div>
            </div>
            <div class="card-body">
              <?php $date_published = date_create($blog->date_published); ?>
              <div class="card-datetime smaller-90" ><?php echo date_format($date_published, "j M Y"); ?></div>
              <div class="card-title" style="margin-top:0.75rem;margin-bottom:0.75rem;font-weight:bold;color: #0085BA!important;"><b><?php echo $blog->headline; ?></b></div>
              <div class="card-detail" style="margin-bottom:0.75rem;">
                <?php
                  $string = strip_tags($blog->description);
                  if (strlen($string) > 450) {
                    // truncate string
                    $stringCut = substr($string, 0, 450);
                    $endPoint = strrpos($stringCut, ' ');

                    //if the string doesn't contain any space then it will cut without word basis.
                    $string = $endPoint? substr($stringCut, 0, $endPoint):substr($stringCut, 0);
                    $string .= '...';
                  }
                  echo $string;
                ?>
              </div>
                <a href="<?php echo Yii::$app->request->BaseUrl.'/site/blog-view?id='.$blog->id; ?>">
              <div class="text-center mt-4">
                <div class="btn btn-primary btn-block px-5"><?php echo Yii::t('app', 'Read more'); ?></div>
              </div>
                </a>
            </div>
          </div>

      </div>
      <?php } ?>
      <div class="clearfix"></div>
    </div>
</div>
</section>