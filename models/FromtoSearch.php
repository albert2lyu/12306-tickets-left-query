<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Fromto;

/**
 * FromtoSearch represents the model behind the search form about `app\models\Fromto`.
 */
class FromtoSearch extends Fromto
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Id'], 'integer'],
            [['from_station_name', 'to_station_name'], 'string'],
            [['create_time'], 'safe'],
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
        $query = Fromto::find()->joinWith('from')->joinWith('to')->groupBy('{{fromto}}.Id');

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
            '{{from}}.name' => $this->from_station_name,
            '{{to}}.name' => $this->to_station_name,
            'create_time' => $this->create_time,
        ]);

        return $dataProvider;
    }
}
