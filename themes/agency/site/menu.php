<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
$this->title = 'About';
$this->params['breadcrumbs'][] = $this->title;
Yii::$app->layout='page_header';
$directoryAsset = Yii::$app->assetManager->getPublishedUrl('@dixonsatit/agencyTheme/dist');
$this->registerJsFile($directoryAsset.'/js/cbpAnimatedHeader.min.js');
?>
<header style="background-image:url(<?=$directoryAsset.'/img/header-bg2.jpg'?>);">
    <div class="container">
        <div class="intro-text">
            <div class="intro-heading">Menu</div>
<div class="row">
    <div class="col-md-3"></div>
    <div class="col-md-3">
            <div class="intro-heading"><a href="../content/blogtype/index"><span class="btn btn-primary"><i class="fa fa-plus-circle fa-2x"></i> Blog Category</span></a></div>
    </div>
    <div class="col-md-3">
        <div class="intro-heading"><a href="../content/blog/index"><span class="btn btn-primary"><i class="fa fa-pencil fa-2x"></i> Blog</span></a></div>
    </div>
    <div class="col-md-3"></div>
</div>
        </div>
    </div>
</header>

