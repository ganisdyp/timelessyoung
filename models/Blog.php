<?php

namespace app\models;

use Yii;
use omgdef\multilingual\MultilingualBehavior;
use omgdef\multilingual\MultilingualQuery;
/**
 * This is the model class for table "blog".
 *
 * @property int $id
 * @property int $blog_type_id
 * @property string $date_published
 * @property string $main_photo
 *
 * @property Blogtype $blogType
 * @property BlogLang[] $blogLangs
 * @property BlogPhoto[] $blogPhotos
 */
class Blog extends \yii\db\ActiveRecord
{
    public $main_photo_file;
    public function behaviors()
    {
        return [
            'ml' => [
                'class' => MultilingualBehavior::className(),
                'languages' => [
                    'th' => 'Thai',
                    'en' => 'English',
                ],
                'requireTranslations' => true,
                'langClassName' => BlogLang::className(),
                'defaultLanguage' => 'en',
                'langForeignKey' => 'blog_id',
                'tableName' => "{{%blog_lang}}",
                'attributes' => ['headline', 'description']

            ],
            //  TimestampBehavior::className(),
            //  BlameableBehavior::className(),
        ];
    }
    public static function find()
    {
        return new MultilingualQuery(get_called_class());
    }
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'blog';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['blog_type_id','headline','description'], 'required'],
            [['blog_type_id','media_type'], 'integer'],
            [['date_published'], 'safe'],
            [['main_photo','keyword'], 'string', 'max' => 100],
            [['main_photo_file'],'file','skipOnEmpty' => true, 'on' => 'update', 'extensions' => 'jpg,png,gif'],
            [['blog_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => Blogtype::className(), 'targetAttribute' => ['blog_type_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'blog_type_id' => Yii::t('app', 'Blog Type ID'),
            'date_published' => Yii::t('app', 'Date Published'),
            'main_photo' => Yii::t('app', 'Main Photo'),
            'keyword' => Yii::t('app', 'Keyword'),
          //  'brand_id' =>  Yii::t('app', 'Brand ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBlogType()
    {
        return $this->hasOne(Blogtype::className(), ['id' => 'blog_type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBlogLangs()
    {
        return $this->hasMany(BlogLang::className(), ['blog_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBlogPhotos()
    {
        return $this->hasMany(BlogPhoto::className(), ['blog_id' => 'id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */

}
