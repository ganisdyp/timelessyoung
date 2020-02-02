<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $model app\models\Profile */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="profile-form">

    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data']
    ]); ?>
    <?= $form->field($user, 'role')->dropDownList([ '1' => 'CUSTOMER', '9' => 'ADMIN'], ['prompt' => '- Select Role -']) ?>

    <?= $form->field($user, 'username')->textInput() ?>

    <?= $form->field($user, 'password_hash')->textInput() ?>

    <?= $form->field($user, 'email')->textInput() ?>

    <?= $form->field($model, 'first_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'last_name')->textInput(['maxlength' => true]) ?>


    <?php if ($model->isNewRecord) {
        echo $form->field($model, 'profile_img')->widget(FileInput::classname(), [
            'options' => ['accept' => 'image/*'], 'pluginOptions' => [
                'showUpload' => false,
                'maxFileSize' => 100000
            ],
        ]);
    } else {
        echo $form->field($model, 'profile_img')->widget(FileInput::classname(), [
            'options' => ['accept' => 'image/*'], 'pluginOptions' => [
                'showUpload' => false,
                'initialPreview' => [
                    [Yii::$app->request->BaseUrl."/uploads/profile/$model->profile_photo"]
                ],
                'initialPreviewAsData' => true,
                'initialCaption' => "$model->profile_photo",
                'initialPreviewConfig' => [
                    ['caption' => $model->profile_photo]
                ],
                'overwriteInitial' => false,
                'maxFileSize' => 100000
            ],
        ]);
    } ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
