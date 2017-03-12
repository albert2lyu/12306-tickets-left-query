<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "fromto".
 *
 * @property integer $Id
 * @property integer $from_station_id
 * @property integer $to_station_id
 * @property string $create_time
 */
class Fromto extends \yii\db\ActiveRecord
{
    public $from_station_name;
    public $to_station_name;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'fromto';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['from_station_id', 'to_station_id', 'from_station_name', 'to_station_name'], 'required'],
            [['from_station_name'], 'exist', 'targetClass'=> Station::className(), 'targetAttribute'=> ['from_station_name'=> 'name']],
            [['to_station_name'], 'exist', 'targetClass'=> Station::className(), 'targetAttribute'=>['to_station_name'=>'name']],
            [['from_station_id'], 'unique', 'targetAttribute' => ['from_station_id', 'to_station_id']],
            [['from_station_id'], 'exist', 'targetClass'=> Station::className(), 'targetAttribute'=>['from_station_id'=>'Id']],
            [['to_station_id'], 'exist', 'targetClass'=> Station::className(), 'targetAttribute'=>['to_station_id'=>'Id']],
            [['from_station_id', 'to_station_id'], 'integer'],
            [['create_time'], 'safe']
        ];
    }

    public static function findOne($id){
        $fromto = parent::findOne($id);

        if($fromto){
            $fromto->from_station_name = $fromto->getFrom()->one()->name;
            $fromto->to_station_name = $fromto->getTo()->one()->name;
        }

        return $fromto;
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

    public function getFromByName(){
        return $this->hasOne(Station::className(), ['name' => 'from_station_name'])->from(['from' => Station::tableName()]);
    }

    public function getToByName(){
        return $this->hasOne(Station::className(), ['name' => 'to_station_name'])->from(['from' => Station::tableName()]);
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
            'from_station_id' => 'From Station ID',
            'to_station_id' => 'To Station ID',
            'create_time' => 'Create Time',
        ];
    }

    public function beforeSave($insert)
    {
        if(parent::beforeSave($insert)){
            $this->create_time = date('y-m-d H:m:s');
            return true;
        }else{
            return false;
        }
    }
}
