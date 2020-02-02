<?php

namespace app\models;

use Yii;
use omgdef\multilingual\MultilingualBehavior;
use omgdef\multilingual\MultilingualQuery;

/**
 * This is the model class for table "home_content".
 *
 * @property int $id
 * @property string $date_published
 *
 * @property HomeContentLang[] $homeContentLangs
 */
class HomeContent extends \yii\db\ActiveRecord
{
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
                'langClassName' => HomeContentLang::className(),
                'defaultLanguage' => 'en',
                'langForeignKey' => 'home_content_id',
                'tableName' => "{{%home_content_lang}}",
                'attributes' => ['headline', 'content']

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
        return 'home_content';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['headline','content'], 'required'],
            [['headline','content'], 'string'],
            [['date_published'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'date_published' => Yii::t('app', 'Date Published'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHomeContentLangs()
    {
        return $this->hasMany(HomeContentLang::className(), ['home_content_id' => 'id']);
    }
}
