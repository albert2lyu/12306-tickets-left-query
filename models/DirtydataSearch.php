<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Dirtydata;

/**
 * DirtydataSearch represents the model behind the search form about `app\models\Dirtydata`.
 */
class DirtydataSearch extends Dirtydata
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Id', 'hardbed', 'hardseat'], 'integer'],
            [['from_station_id', 'to_station_id'], 'string'],
            [['create_time', 'author','date', 'train_number'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
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
        $query = Dirtydata::find()->joinWith('from')->joinWith('to')->groupBy('{{dirtydata}}.Id');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'Id' => $this->Id,
            'train_number'=> $this->train_number,
            '{{from}}.name' => $this->from_station_id,
            '{{to}}.name' => $this->to_station_id,
            'hardbed' => $this->hardbed,
            'hardseat' => $this->hardseat,
            'create_time' => $this->create_time,
        ]);

        $query->andFilterWhere(['like', 'author', $this->author])
            ->andFilterWhere(['like', 'date', $this->date]);

        return $dataProvider;
    }
}
