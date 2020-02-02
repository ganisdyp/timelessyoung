<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    /*public $css = [
        'css/site.css',
    ];
    public $js = [
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];*/
    public $css = [
        // 'css/site.css',
        'css/bootstrap4.min.css',
        //  'css/font-awesome.min.css',
        'lib/animate.css/animate.min.css',
        'lib/sweetalert2/sweetalert2.css',
        'lib/toastr/toastr.min.css',
        'lib/typeahead/typeahead.css',
        'lib/datatables/css/datatables.min.css',
        'lib/owl.carousel/css/owl.carousel.min.css',
        'lib/owl.carousel/css/owl.theme.default.css',
        'lib/lightbox2/lightbox.min.css',
        'lib/select2/select2.css',
        'lib/select2/select2-bootstrap.css',
        'css/helper.css',
        'lib/fonts/font.css',
        //'System::FONTS[System::get_font_config()]',
        'lib/fonts/font-chatthai.css',
        'lib/fonts/font-prompt.css',
        'css/style.css',
        'css/custom.css',


    ];
    public $js = [
        'js/polyfill.js',
        'js/bootstrap4.bundle.min.js',
        'lib/SmoothScroll/SmoothScroll.js',
        'lib/sweetalert2/sweetalert2.min.js',
        'js/promise.min.js',
        'lib/toastr/toastr.min.js',
        'lib/datatables/js/datatables.min.js',
        'lib/moment/moment.js',
        'lib/owl.carousel/owl.carousel.min.js',
        'lib/lightbox2/lightbox.min.js',
        'lib/validator/validator.js',
        'lib/typeahead/typeahead.jquery.js',
        'lib/jquery.Thailand.js/dependencies/JQL.min.js',
        'lib/jquery.Thailand.js/dist/jquery.Thailand.min.js',
        'lib/zDatepicker/zDatepicker.js',
        'js/owl-custom.js',
        'lib/jquery.mask/jquery.mask.min.js',
        'lib/select2/select2.min.js',
        //  'js/jquery-3.2.1.min.js',
        'js/system.js',
        'js/main.js',

    ];
    public $depends = [
        'yii\web\YiiAsset',
        'frontend\assets\FontAwesomeAsset',
        //  'yii\bootstrap\BootstrapAsset',
    ];
}
