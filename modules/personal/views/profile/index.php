<?php

use yii\helpers\Html;
//use yii\grid\GridView;
use fedemotta\datatables\DataTables;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\personal\ProfileSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'User Profiles';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="profile-index table-responsive">


    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Add New User', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= DataTables::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            ['attribute' => 'profile_photo',
                'format' => 'html',
                'value' => function ($model) {
                    return Html::img('../../web/uploads/profile/' . $model->profile_photo,
                        ['class'=>'thumbnail','width'=>'100']);
                }
            ],
            'user.username',
            'user.email:email',
            'first_name',
            'last_name',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
