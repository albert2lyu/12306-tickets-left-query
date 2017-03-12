<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "station".
 *
 * @property integer $Id

 * @property string $name
 * @property string $code
 * @property string $start_time
 * @property string $update_time
 * @property string $add_time
 * @property string $author
 */
class Station extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'station';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'unique'],
            [['start_time', 'update_time', 'add_time'], 'safe'],
            [['name', 'author'], 'string', 'max' => 20],
            [['code'], 'string', 'max' => 10]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'Id' => 'ID',
            'name' => 'Name',
            'code' => 'Code',
            'start_time' => 'Start Time',
            'update_time' => 'Update Time',
            'add_time' => 'Add Time',
            'author' => 'Author',
        ];
    }
    public static function loadStationStartTime(){
        $arr = LoadData::loadStationStartTime();
        if(is_array($arr)){
            foreach($arr as $key=>$value){
                $key = trim($key);
                $station = Station::find()->where(['name'=>$key])->one();
                if(!$station){
                    $station = new Station();
                    $station->name = $key;

                }

                $station->start_time = $value;
                if(!$station->save()){
                    return false;
                }

            }
        }
        return true;
    }
    public static function loadStationCode(){
        $arr = LoadData::loadStationCode();
        if(is_array($arr)){
            foreach($arr as $key=>$value){
                $key = trim($key);
                if(empty($value))continue;
                $station = Station::find()->where(['name'=>$key])->one();
                if($station){

                    $station->code = $value;
                    if(!$station->save()){
                        return false;
                    }

                }

            }
        }
        return $arr;
    }

    public function beforeSave($insert)
    {
        if(parent::beforeSave($insert)){
            if($this->isNewRecord){
                $this->add_time = date('Y-m-d H:i:s');
                $this->author = 'admin';
            }else{
                $this->update_time = date('Y-m-d H:i:s');
                $this->author = 'admin';
            }
            return true;
        }else{
            return false;
        }
    }
}
