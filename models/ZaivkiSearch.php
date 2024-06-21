<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Zaivki;

/**
 * ZaivkiSearch represents the model behind the search form of `app\models\Zaivki`.
 */
class ZaivkiSearch extends Zaivki
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'category_id', 'section_id', 'user_id', 'status'], 'integer'],
            [['name', 'surname', 'patronymic', 'number', 'named', 'surnamed', 'patronymicd'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Zaivki::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'category_id' => $this->category_id,
            'section_id' => $this->section_id,
            'user_id' => $this->user_id,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'surname', $this->surname])
            ->andFilterWhere(['like', 'patronymic', $this->patronymic])
            ->andFilterWhere(['like', 'number', $this->number])
            ->andFilterWhere(['like', 'named', $this->named])
            ->andFilterWhere(['like', 'surnamed', $this->surnamed])
            ->andFilterWhere(['like', 'patronymicd', $this->patronymicd]);

        return $dataProvider;
    }
}
