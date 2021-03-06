<!-- Navigation -->
<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"
      integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">


<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\ArrayHelper;

$class = !isset($class) ? '' : $class;
if (Yii::$app->user->isGuest) {

} else {
    $user_role = Yii::$app->user->identity->getRole();
}
if (!Yii::$app->user->isGuest && $user_role == 1) {
    if (Yii::$app->layout == 'homepage') {
        $menus = [
            ['label' => 'หน้าหลัก', 'url' => ['/site/index']],
            ['label' => 'คอร์ส', 'url' => '#services', 'linkOptions' => ['class' => 'page-scroll']],
            ['label' => 'เกี่ยวกับผู้สอน', 'url' => '#about', 'linkOptions' => ['class' => 'page-scroll']],
            ['label' => 'ผลงาน', 'url' => '#portfolio', 'linkOptions' => ['class' => 'page-scroll']],
            //    ['label' => 'ทีมของเรา', 'url' =>'#team','linkOptions'=>['class'=>'page-scroll']],
            //  ['label' => 'ติดต่อเรา', 'url' =>'#contact','linkOptions'=>['class'=>'page-scroll']],
        ];
    } else {
        $menus = [
            ['label' => 'หน้าหลัก', 'url' => ['/site/index']],
            ['label' => 'คอร์ส', 'url' => ['index', '#' => 'services'], 'linkOptions' => ['class' => 'page-scroll']],
            ['label' => 'เกี่ยวกับผู้สอน', 'url' => ['index', '#' => 'about'], 'linkOptions' => ['class' => 'page-scroll']],
            ['label' => 'ผลงาน', 'url' => ['index', '#' => 'portfolio'], 'linkOptions' => ['class' => 'page-scroll']],
            //   ['label' => 'ทีมของเรา', 'url' =>['index','#'=>'team'],'linkOptions'=>['class'=>'page-scroll']],
            // ['label' => 'ติดต่อเรา', 'url' =>['index','#'=>'contact'],'linkOptions'=>['class'=>'page-scroll']],
        ];
    }
}else if(!Yii::$app->user->isGuest && $user_role == 9){
    $menus = [
        ['label' => 'ดูตัวอย่าง', 'url' => ['/site/blog-category']],

    ];
}else{
    if (Yii::$app->layout == 'homepage') {
        $menus = [
            ['label' => 'หน้าหลัก', 'url' => ['/site/index']],
            ['label' => 'คอร์ส', 'url' => '#services', 'linkOptions' => ['class' => 'page-scroll']],
            ['label' => 'เกี่ยวกับผู้สอน', 'url' => '#about', 'linkOptions' => ['class' => 'page-scroll']],
            ['label' => 'ผลงาน', 'url' => '#portfolio', 'linkOptions' => ['class' => 'page-scroll']],
            //    ['label' => 'ทีมของเรา', 'url' =>'#team','linkOptions'=>['class'=>'page-scroll']],
            //  ['label' => 'ติดต่อเรา', 'url' =>'#contact','linkOptions'=>['class'=>'page-scroll']],
        ];
    } else {
        $menus = [
            ['label' => 'หน้าหลัก', 'url' => ['/site/index']],
            ['label' => 'คอร์ส', 'url' => ['index', '#' => 'services'], 'linkOptions' => ['class' => 'page-scroll']],
            ['label' => 'เกี่ยวกับผู้สอน', 'url' => ['index', '#' => 'about'], 'linkOptions' => ['class' => 'page-scroll']],
            ['label' => 'ผลงาน', 'url' => ['index', '#' => 'portfolio'], 'linkOptions' => ['class' => 'page-scroll']],
            //   ['label' => 'ทีมของเรา', 'url' =>['index','#'=>'team'],'linkOptions'=>['class'=>'page-scroll']],
            // ['label' => 'ติดต่อเรา', 'url' =>['index','#'=>'contact'],'linkOptions'=>['class'=>'page-scroll']],
        ];
    }
}
?>

<?php
$options = ['navbar', 'navbar-default', 'navbar-fixed-top'];
NavBar::begin([
    'brandLabel' => 'Timeless Young',
    'brandUrl' => Yii::$app->homeUrl,
    'brandOptions' => [
        'class' => 'navbar-header page-scroll'
    ],
    'options' => [
        'class' => 'navbar navbar-default navbar-fixed-top ' . $class,
    ],
]);

$items = [];

if (Yii::$app->user->isGuest) {

$items[] = ['label' => 'บล็อกส่วนตัว', 'url' => ['/site/blog-category'],'linkOptions' => ['style' => 'color:#ff0000']];
  
    $items[] = ['label' => 'ลงชื่อเข้าใช้', 'url' => ['/site/login']];


} else {
    if ($user_role == 9) {
        $items[] = ['label' => 'จัดการคอนเทนท์', 'url' => ['/site/menu']];
        $items[] = ['label' => 'จัดการแอคเค้าท์', 'url' => ['/personal/profile/index']];
        $items[] =
            ['label' => 'ออกจากระบบ (' . Yii::$app->user->identity->username . ')',
                'url' => ['/site/logout'],
                'linkOptions' => ['data-method' => 'post']];

    } else {
    /*    $items[] = ['label' => 'บล็อกส่วนตัว', 'url' => ['/site/blog-category'],'linkOptions' => ['style' => 'color:#ff0000']];
       */ $items[] =
            ['label' => 'ออกจากระบบ (' . Yii::$app->user->identity->username . ')',
                'url' => ['/site/logout'],
                'linkOptions' => ['data-method' => 'post']];
    }
}

echo Nav::widget([
    'options' => ['class' => 'navbar-nav navbar-right'],
    'items' => ArrayHelper::merge($menus,
        $items),
]);
NavBar::end();
?>
