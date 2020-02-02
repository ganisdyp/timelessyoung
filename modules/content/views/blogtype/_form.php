<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\tinymce\TinyMce;
use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $model app\models\Blogtype */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="blog-type-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">

        <div class="col-md-9">
            <?= $form->errorSummary($model); ?>
            <?php
            if ($model->isNewRecord) {
                echo $form->field($model, 'main_photo_file')->widget(FileInput::classname(), [
                    'options' => ['accept' => 'image/*'], 'pluginOptions' => [
                        'showUpload' => false,
                        'maxFileSize' => 100000
                    ],
                ]);
            } else {
                /* echo Html::img(Yii::$app->getHomeUrl() . 'uploads/blog_type/' . $model->main_photo,
                     ['id' => 'current_img', 'class' => 'thumbnail', 'width' => '150']);
                 $form->field($model, 'main_photo')->hiddenInput(['value' => $model->main_photo])->label(false);*/
                echo $form->field($model, 'main_photo_file')->widget(FileInput::classname(), [
                    'options' => ['accept' => 'image/*'], 'pluginOptions' => [
                        'showUpload' => false,
                        'initialPreview' => [
                            [Yii::$app->request->BaseUrl."/uploads/blog_type/$model->main_photo"]
                        ],
                        'initialPreviewAsData' => true,
                        'initialCaption' => "$model->main_photo",
                        'initialPreviewConfig' => [
                            ['caption' => $model->main_photo]
                        ],
                        'overwriteInitial' => false,
                        'maxFileSize' => 100000
                    ],
                ]);
            }
            ?>

        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#english">English</a></li>
                <li><a data-toggle="tab" href="#thai">Thai</a></li>

            </ul>
        </div>
        <div class="col-md-12">
            <!-- Tab content -->
            <div class="tab-content">
                <div id="english" class="tab-pane fade in active">
                    <br>
                    <div class="col-md-6">
                        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
                    </div>
                    <div class="col-md-6">
                    </div>
                    <div class="col-md-12">
                        <?= $form->field($model, 'description')->widget(TinyMce::className(), [
                            'options' => ['rows' => 6],
                            'language' => 'en',
                            'clientOptions' => [
                                'plugins' => [
                                    "advlist autolink lists link charmap print preview anchor",
                                    "searchreplace visualblocks code fullscreen textcolor",
                                    "insertdatetime media table contextmenu paste"
                                ],
                                'toolbar' => "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | forecolor backcolor",
                                'textcolor_map' => [
                                    "000000", "Black",
                                    /*  "993300", "Burnt orange",
                                      "333300", "Dark olive",
                                      "003300", "Dark green",
                                      "003366", "Dark azure",
                                      "000080", "Navy Blue",
                                      "333399", "Indigo",
                                      "333333", "Very dark gray",
                                      "800000", "Maroon",
                                      "FF6600", "Orange",
                                      "808000", "Olive",
                                      "008000", "Green",
                                      "008080", "Teal",
                                      "0000FF", "Blue",
                                      "666699", "Grayish blue",
                                      "808080", "Gray",
                                      "FF0000", "Red",
                                      "FF9900", "Amber",
                                      "99CC00", "Yellow green",
                                      "339966", "Sea green",
                                      "33CCCC", "Turquoise",
                                      "3366FF", "Royal blue",
                                      "800080", "Purple",
                                      "999999", "Medium gray",
                                      "FF00FF", "Magenta",
                                      "FFCC00", "Gold",
                                      "FFFF00", "Yellow",
                                      "00FF00", "Lime",
                                      "00FFFF", "Aqua",
                                      "00CCFF", "Sky blue",
                                      "993366", "Red violet",
                                      "FFFFFF", "White",
                                      "FF99CC", "Pink",
                                      "FFCC99", "Peach",
                                      "FFFF99", "Light yellow",
                                      "CCFFCC", "Pale green",
                                      "CCFFFF", "Pale cyan",
                                      "99CCFF", "Light sky blue",
                                      "CC99FF", "Plum",*/
                                    "5734ba", "DC purple",
                                ]
                            ]
                        ]); ?>
                    </div>
                </div>
                <div id="thai" class="tab-pane fade">
                    <br>
                    <div class="col-md-6">
                        <?= $form->field($model, 'name_th')->textInput(['maxlength' => true]) ?>
                    </div>
                    <div class="col-md-6">
                    </div>
                    <div class="col-md-12">


                        <?= $form->field($model, 'description_th')->widget(TinyMce::className(), [
                            'options' => ['rows' => 6],
                            'language' => 'en',
                            'clientOptions' => [
                                'plugins' => [
                                    "advlist autolink lists link charmap print preview anchor",
                                    "searchreplace visualblocks code fullscreen textcolor",
                                    "insertdatetime media table contextmenu paste"
                                ],
                                'toolbar' => "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | forecolor backcolor",
                                'textcolor_map' => [
                                    "000000", "Black",
                                    /*   "993300", "Burnt orange",
                                       "333300", "Dark olive",
                                       "003300", "Dark green",
                                       "003366", "Dark azure",
                                       "000080", "Navy Blue",
                                       "333399", "Indigo",
                                       "333333", "Very dark gray",
                                       "800000", "Maroon",
                                       "FF6600", "Orange",
                                       "808000", "Olive",
                                       "008000", "Green",
                                       "008080", "Teal",
                                       "0000FF", "Blue",
                                       "666699", "Grayish blue",
                                       "808080", "Gray",
                                       "FF0000", "Red",
                                       "FF9900", "Amber",
                                       "99CC00", "Yellow green",
                                       "339966", "Sea green",
                                       "33CCCC", "Turquoise",
                                       "3366FF", "Royal blue",
                                       "800080", "Purple",
                                       "999999", "Medium gray",
                                       "FF00FF", "Magenta",
                                       "FFCC00", "Gold",
                                       "FFFF00", "Yellow",
                                       "00FF00", "Lime",
                                       "00FFFF", "Aqua",
                                       "00CCFF", "Sky blue",
                                       "993366", "Red violet",
                                       "FFFFFF", "White",
                                       "FF99CC", "Pink",
                                       "FFCC99", "Peach",
                                       "FFFF99", "Light yellow",
                                       "CCFFCC", "Pale green",
                                       "CCFFFF", "Pale cyan",
                                       "99CCFF", "Light sky blue",
                                       "CC99FF", "Plum",*/
                                    "5734ba", "DC purple",
                                ]
                            ]
                        ]); ?>
                    </div>
                </div>
                <div class="col-md-12">
                    <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
                </div>
            </div>
        </div>
    </div>


    <?php ActiveForm::end();

    $this->registerJs(' 

    $(document).ready(function(){
    $(\':file\').change(function(){
var file = this.files[0];
var fileType = file["type"];
var ValidImageTypes = ["image/gif", "image/jpeg", "image/png"];
if ($.inArray(fileType, ValidImageTypes) < 0) {
    alert("INVALID FILE TYPE!");
   $(\'#current_img\').show();
   $(\'#blogtype-main_photo\').val(\'\');
}else{
$(\'#current_img\').hide();
}

      

    });
    });', \yii\web\View::POS_READY);

    ?>

</div>
