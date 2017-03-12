<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Createtime;

/**
 * CreatetimeSearch represents the model behind the search form about `app\models\Createtime`.
 */
class CreatetimeSearch extends Createtime
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Id', 'openbuy_id', 'increased'], 'integer'],
            [['create_time', 'author'], 'safe'],
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
        $query = Createtime::find();

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
            'openbuy_id' => $this->openbuy_id,
            'increased'=> $this->increased,
            'create_time' => $this->create_time,
        ]);

        $query->andFilterWhere(['like', 'author', $this->author]);

        return $dataProvider;
    }
}
