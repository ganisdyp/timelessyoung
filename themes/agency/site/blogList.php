<?php
/**
 * Created by PhpStorm.
 * User: clbs
 * Date: 5/10/2018
 * Time: 2:12 PM
 */
use yii\helpers\Html;
use app\models\DC;
use app\models\BlogSearch;
use app\models\BlogtypeSearch;

$this->title = Yii::t('app', 'Blog');
$searchModel = new BlogtypeSearch();
$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
$blog_category = $dataProvider->query->where(['id' => $_GET['id']])->one();

$searchModel = new BlogSearch();
$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
define('PAGE_NAME', 'blog');
?>
<div id="fieldtrip-page" class="container">
    <nav class="mt-2 fadeIn animated d07s">
        <ol class="breadcrumb smaller-90 mb-0">
            <li class="breadcrumb-item"><a href="/site/index"><?= Yii::t('app', 'Home'); ?></a></li>
            <li class="breadcrumb-item"><a href="/site/blog-category"><?= Yii::t('app', 'Blog'); ?></a>
            </li>
            <li class="breadcrumb-item active"><?= $blog_category->name; ?></li>
        </ol>
    </nav>
    <div class="row mb-4">
        <div class="col-12 mb-2 viewpoint-animate d03s" data-animation="fadeInDown">
            <p class="bigger-160 font-weight-normal text-purple mb-0"><?= $blog_category->name; ?></p>
        </div>
        <?php $activities_per_category = $dataProvider->query->where(['blog_type_id' => $_GET['id']])->orderBy(['date_visited' => SORT_DESC])->all(); ?>
        <?php 
        foreach ($activities_per_category as $i => $blog)
            if ($i == 0) { ?>
            <div class="col-12 my-2">
                <div class="row">
                    <div class="col-lg-6 col-md-4 col-12 viewpoint-animate d03s" data-animation="fadeInLeft">
                        <a href="/site/blog-view?id=<?php echo $blog->id; ?>" class="block"
                            target="_blank">
                            <div class="media-wrapper">
                                <?php if ($blog->media_type == 1) { ?>
                                    <iframe width="100%" height="320" src="<?= $blog->main_photo; ?>"
                                            allowfullscreen></iframe>
                                <?php } else { ?>
                                    <div class="img-16by9 holder">
                                        <img class="card-img-top img-responsive corner-0"
                                                src="/uploads/blog/<?= $blog->main_photo; ?>">
                                    </div>
                                <?php } ?>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-6 col-md-8 col-12 viewpoint-animate d05s" data-animation="fadeIn">
                        <?php $date_visited = date_create($blog->date_visited); ?>
                        <a href="/site/blog-view?id=<?php echo $blog->id; ?>"
                            class="bigger-110 card-title mb-0 bold block mt-lg-0 mt-2"><?= date_format($date_visited, "j F Y")." – ".$blog->headline; ?></a>
                        <div class="row my-lg-1 my-0">
                            <?php /*
                            <div class="col-lg-6 col-12">
                                <p class="text-muted smaller-90 my-1">
                                    <i class="fa fa-clock-o mr-2"></i>
                                    <?php $date_publish = date_create($blog->date_published); ?>
                                    <?= date_format($date_publish, "D, j M Y"); ?>
                                </p>
                            </div>
                            */ ?>
                            <div class="col-lg-6 col-12">
                                <p class="text-muted single-line smaller-90 my-1">
                                    <i class="fa fa-map mr-2"></i>
                                    <?= $blog->location; ?>
                                </p>
                            </div>
                            <div class="col-lg-6 col-12">
                                <p class="text-muted smaller-90 my-1">
                                    <i class="fa fa-group mr-2"></i>
                                    <?= $blog->participant." ".Yii::t('app','people joined this blog'); ?>
                                </p>
                            </div>
                        </div>
                        <p class="card-text smaller-90 mt-lg-0 mt-2">
                        <?php 
                        $string = strip_tags($blog->description);
                        if (strlen($string) > 570) {
                            // truncate string
                            $stringCut = substr($string, 0, 570);
                            $endPoint = strrpos($stringCut, ' ');

                            //if the string doesn't contain any space then it will cut without word basis.
                            $string = $endPoint? substr($stringCut, 0, $endPoint):substr($stringCut, 0);
                            $string .= '...';
                        }
                        echo $string;
                        ?>
                        </p>
                        <a class="smaller-90" href="/site/blog-view?id=<?php echo $blog->id; ?>"><?php echo Yii::t('app', 'read_more');?> <i class="fa fa-angle-right ml-1"></i></a>
                    </div>
                </div>
            </div>
            <?php
            } else { ?>
            <div class="col-12 fadeIn animated d07s">
                <div class="row">
                    <div class="col-12">
                        <hr>
                        <div class="row">
                            <div class="col-md-4 col-12">
                                <a href="/site/blog-view?id=<?php echo $blog->id; ?>" class="hover-box"
                                   >
                                    <div class="media-wrapper">
                                        <?php if ($blog->media_type == 1) { ?>
                                            <iframe width="100%" height="220" src="<?= $blog->main_photo; ?>"
                                                    allowfullscreen></iframe>
                                        <?php } else { ?>
                                            <div class="img-16by9 holder">
                                                <img class="card-img-top img-responsive corner-0"
                                                        src="/uploads/blog/<?= $blog->main_photo; ?>">
                                            </div>
                                        <?php } ?>

                                    </div>
                                </a>
                            </div>
                            <div class="col-md-8 col-12">
                                <?php $date_published = date_create($blog->date_published); ?>
                                <a href="/site/blog-view?id=<?php echo $blog->id; ?>"
                                    class="bigger-110 card-title mb-0 bold block mt-lg-0 mt-2"><?= date_format($date_published, "j F Y")." – ".$blog->headline; ?></a>
                                <div class="row my-lg-1 my-0">
                                    <?php /*
                                    <div class="col-md-4 col-12">
                                        <p class="text-muted smaller-90 my-1">
                                            <i class="fa fa-clock-o mr-2"></i>
                                            <?php $date_publish = date_create($blog->date_published); ?>
                                            <?= date_format($date_publish, "D, j M Y h:i A"); ?>
                                        </p>
                                    </div>
                                    */ ?>
                                    <div class="col-md-4 col-12">
                                        <p class="text-muted single-line smaller-90 my-1">
                                            <i class="fa fa-map mr-2"></i>
                                            <?= $blog->location; ?>
                                        </p>
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <p class="text-muted smaller-90 my-1">
                                            <i class="fa fa-group mr-2"></i>
                                            <?= $blog->participant." ".Yii::t('app','people joined this blog'); ?>
                                        </p>
                                    </div>
                                </div>
                                <p class="card-text smaller-90 mt-lg-0 mt-2">
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
                                </p>
                                <a class="smaller-90" href="/site/blog-view?id=<?php echo $blog->id; ?>"><?php echo Yii::t('app', 'read_more');?> <i class="fa fa-angle-right ml-1"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>
    </div>
</div>
