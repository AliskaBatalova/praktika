<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "section".
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $image
 * @property int $category_id
 *
 * @property Category $category
 * @property Prepod[] $prepods
 */
class Section extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'section';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'description', 'image', 'category_id'], 'required'],
            [['description'], 'string'],
            [['category_id'], 'integer'],
            [['name'], 'string', 'max' => 45],
            [['image'], 'string', 'max' => 256],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::class, 'targetAttribute' => ['category_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'description' => 'Описание',
            'image' => 'Фото',
            'Save' => 'Сохранить',
            'Delete' => 'Удалить',
            'category_id' => 'Category ID',
        ];
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }

    /**
     * Gets query for [[Prepods]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPrepods()
    {
        return $this->hasMany(Prepod::class, ['section_id' => 'id']);
    }
}
