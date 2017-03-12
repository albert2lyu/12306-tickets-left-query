<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Openbuy;

/**
 * OpenbuySearch represents the model behind the search form about `app\models\Openbuy`.
 */
class OpenbuySearch extends Openbuy
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[ 'delay_day'], 'integer'],
            [[ 'count', 'Id'], 'integer'],
            [['from_station_id', 'to_station_id'], 'string'],
            [['update_time', 'add_time', 'author', 'train_number', 'type'], 'safe'],
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
        $query = Openbuy::find()->joinWith('from')->joinWith('to')->groupBy('{{openbuy}}.id');


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
            '{{openbuy}}.Id' => $this->Id,
            '{{from}}.name' => $this->from_station_id,
            '{{to}}.name'=> $this->to_station_id,
            'delay_day' => $this->delay_day,
            'type'=> $this->type,
            'train_number'=> $this->train_number,
            'update_time' => $this->update_time,
            'add_time' => $this->add_time,
        ]);

        $query->andFilterWhere(['like', 'author', $this->author]);

        return $dataProvider;
    }
}
