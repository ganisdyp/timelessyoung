<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "blog_lang".
 *
 * @property int $id
 * @property int $blog_id
 * @property string $headline
 * @property string $description
 * @property string $language
 *
 * @property Blog $blog
 */
class BlogLang extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'blog_lang';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['blog_id', 'headline', 'description', 'language'], 'required'],
            [['blog_id'], 'integer'],
            [['description'], 'string'],
            [['headline'], 'string', 'max' => 100],
            [['language'], 'string', 'max' => 10],
            [['blog_id'], 'exist', 'skipOnError' => true, 'targetClass' => Blog::className(), 'targetAttribute' => ['blog_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'blog_id' => Yii::t('app', 'Blog ID'),
            'headline' => Yii::t('app', 'Headline'),
            'description' => Yii::t('app', 'Description'),
            'language' => Yii::t('app', 'Language'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBlog()
    {
        return $this->hasOne(Blog::className(), ['id' => 'blog_id']);
    }
}
