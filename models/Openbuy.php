<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "openbuy".
 *
 * @property integer $station_id
 * @property integer $delay_day
 * @property string $update_time
 * @property string $add_time
 * @property string $author
 */
class Openbuy extends \yii\db\ActiveRecord
{
    public $from_station_name;
    public $to_station_name;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'openbuy';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Id', 'delay_day','from_station_id', 'to_station_id', 'train_number', 'type'], 'required'],
            [['from_station_name'], 'exist', 'targetClass'=> Station::className(), 'targetAttribute'=> ['from_station_name' => 'name']],
            [['to_station_name'], 'exist', 'targetClass'=> Station::className(), 'targetAttribute'=> ['to_station_name' => 'name']],
            [['from_station_id'], 'exist', 'targetClass'=> Station::className(), 'targetAttribute'=>['from_station_id'=>'Id']],
            [['to_station_id'], 'exist', 'targetClass'=> Station::className(), 'targetAttribute'=>['to_station_id'=>'Id']],
            [['from_station_id','to_station_id', 'delay_day', 'count'], 'integer', 'min'=>0],
            [['to_station_id', 'from_station_id', 'delay_day', 'train_number', 'type'], 'unique', 'targetAttribute' => [ 'delay_day','from_station_id', 'to_station_id', 'train_number', 'type']],
            [['update_time', 'add_time'], 'safe'],
            [['type'], 'in', 'range'=>['硬座', '硬卧']],
            [['author', 'train_number','type'], 'string', 'max' => 20]
        ];
    }
    public function load($post){
        $r = parent::load($post);
        if($this->from_station_name && $this->to_station_name){
            $from_station = $this->getFromByName()->one();
            $to_station = $this->getToByName()->one();
            if($from_station && $to_station){
                $this->from_station_id = $from_station->Id;
                $this->to_station_id = $to_station->Id;
            }
        }
        return $r;
    }
    public static function findOne($id){
        $openbuy = parent::findOne($id);
        $from_station = $openbuy->getFrom()->one();
        $to_station = $openbuy->getTo()->one();
        if($from_station && $to_station){
            $openbuy->from_station_name = $from_station->name;
            $openbuy->to_station_name = $to_station->name;
        }
        return $openbuy;
    }
    public function getFromByName(){
        return $this->hasOne(Station::className(), ['name' => 'from_station_name'])->from(['from'=> Station::tableName()]);
    }

    public function getToByName(){
        return $this->hasOne(Station::className(), ['name' => 'to_station_name'])->from(['to'=> Station::tableName()]);
    }

    public function getFrom()
    {
        return $this->hasOne(Station::className(), ['Id' => 'from_station_id'])->from(['from' => Station::tableName()]);
    }

    public function getTo(){
        return $this->hasOne(Station::className(), ['Id' => 'to_station_id'])->from(['to' => Station::tableName()]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'Id' => 'ID',
            'from_station_id'=> 'From station Id',
            'to_station_id'=> 'To station Id',
            'station_id' => 'Station ID',
            'delay_day' => 'Delay Day',
            'train_number'=> 'Train number',
            'count' => 'count',
            'update_time' => 'Update Time',
            'add_time' => 'Add Time',
            'author' => 'Author',
        ];
    }

    public function beforeSave($insert)
    {
        if(parent::beforeSave($insert)){
            if($this->isNewRecord){
                $this->count = 0;
                $this->add_time = date('y-m-d H:i:s');
                $this->author = 'admin';
            }else{
                $this->count = $this->count + 1;
                $this->update_time = date('y-m-d H:i:s');
                $this->author = 'admin';
            }
            return true;
        }else{
            return false;
        }
    }
}
