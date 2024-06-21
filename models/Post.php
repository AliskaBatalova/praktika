<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "post".
 *
 * @property int $id
 * @property string $title
 * @property string $body
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int $theme_id
 *
 * @property Theme $theme
 */
class Post extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'post';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'body', 'theme_id'], 'required'],
            [['body'], 'string'],
            [['theme_id'], 'integer'],
            [['title'], 'string', 'max' => 25],
            [['image'], 'string', 'max' => 256],
            [['theme_id'], 'exist', 'skipOnError' => true, 'targetClass' => Theme::class, 'targetAttribute' => ['theme_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Преподаватель',
            'body' => 'Описание',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'theme_id' => 'Theme ID',
        ];
    }

    /**
     * Gets query for [[Theme]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTheme()
    {
        return $this->hasOne(Theme::class, ['id' => 'theme_id']);
    }
}
