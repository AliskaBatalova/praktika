<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "mashini".
 *
 * @property int $id
 * @property string $name
 * @property int $cena
 */
class Mashini extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mashini';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'cena'], 'required'],
            [['cena'], 'integer'],
            [['name'], 'string', 'max' => 20],
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
            'cena' => 'Cena',
        ];
    }
}
