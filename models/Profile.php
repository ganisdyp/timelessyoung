<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "profile".
 *
 * @property integer $id
 * @property string $profile_photo
 * @property string $first_name
 * @property string $last_name
 * @property integer $user_id
 *
 * @property User $user
 */
class Profile extends \yii\db\ActiveRecord
{
    public $profile_img;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'profile';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['first_name', 'last_name', 'user_id'], 'required'],
            [['user_id'], 'integer'],
            [['profile_photo', 'first_name', 'last_name'], 'string', 'max' => 100],
            [['profile_img'],'file','skipOnEmpty' => true, 'on' => 'update', 'extensions' => 'jpg,png,gif']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user.username' => 'Username',
            'user.email' => 'Email',
            'id' => 'ID',
            'profile_photo' => 'Profile Photo',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'user_id' => 'User ID',
            'profile_img' => 'Profile Photo',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }


    public static function findByUserId($user_id)
    {
        return static::findOne(['user_id' => $user_id]);
    }

}
