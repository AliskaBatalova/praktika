<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "prepod".
 *
 * @property int $id
 * @property string $name
 * @property string $surname
 * @property string $patronymic
 * @property string $image
 * @property int $section_id
 *
 * @property Section $section
 */
class Prepod extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'prepod';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'surname', 'patronymic', 'image', 'section_id'], 'required'],
            [['section_id'], 'integer'],
            [['name', 'surname'], 'string', 'max' => 35],
            [['patronymic'], 'string', 'max' => 25],
            [['image'], 'string', 'max' => 256],
            [['section_id'], 'exist', 'skipOnError' => true, 'targetClass' => Section::class, 'targetAttribute' => ['section_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'surname' => 'Surname',
            'patronymic' => 'Patronymic',
            'image' => 'Image',
            'section_id' => 'Section ID',
        ];
    }

    /**
     * Gets query for [[Section]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSection()
    {
        return $this->hasOne(Section::class, ['id' => 'section_id']);
    }
}
