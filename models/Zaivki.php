<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "zaivki".
 *
 * @property int $id
 * @property string $name
 * @property string $surname
 * @property string $patronymic
 * @property string $number
 * @property string $named
 * @property string $surnamed
 * @property string $patronymicd
 * @property int $category_id
 * @property int $section_id
 *
 * @property Category $category
 * @property Section $section
 */
class Zaivki extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'zaivki';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'surname', 'patronymic', 'number', 'named', 'surnamed', 'patronymicd', 'category_id', 'section_id'], 'required'],
            [['category_id', 'section_id'], 'integer'],
            [['name', 'surname', 'named', 'surnamed'], 'string', 'max' => 20],
            [['patronymic', 'patronymicd'], 'string', 'max' => 50],
            [['number'], 'string', 'max' => 11],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::class, 'targetAttribute' => ['category_id' => 'id']],
            [['section_id'], 'exist', 'skipOnError' => true, 'targetClass' => Section::class, 'targetAttribute' => ['section_id' => 'id']],
            ['user_id','default','value'=>Yii::$app->user->getId()]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Имя',
            'surname' => 'Фамилия',
            'patronymic' => 'Отчество',
            'number' => 'Номер телефона',
            'named' => 'Имя родителя',
            'surnamed' => 'Фамилия родителя',
            'patronymicd' => 'Отчество родителя',
            'category_id' => 'Возростная группа',
            'section_id' => 'Кружок',
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
     * Gets query for [[Section]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSection()
    {
        return $this->hasOne(Section::class, ['id' => 'section_id']);
    }
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
    public function getStatus()
    {
        switch ($this->status){
            case 0:return'Ожидание';
            case 1:return'Отклонено';
            case 2:return'Принято';
        }
    }
    public function good()
    {
       $this->status=2;
       return $this->save(false);
    }
    public function verybad()
    {
        $this->status=1;
        return $this->save(false);
    }
}
