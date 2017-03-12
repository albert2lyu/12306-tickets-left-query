<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "dirtydata".
 *
 * @property integer $Id
 * @property integer $from_station_id
 * @property integer $to_station_id
 * @property integer $hardbed
 * @property integer $hardseat
 * @property string $create_time
 * @property string $author
 */
class Dirtydata extends \yii\db\ActiveRecord
{
    public $from_station_name;
    public $to_station_name;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dirtydata';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['from_station_name'], 'exist', 'targetClass'=> Station::className(), 'targetAttribute'=>['from_station_name'=>'name']],
            [['to_station_name'], 'exist', 'targetClass'=> Station::className(), 'targetAttribute'=>['to_station_name'=>'name']],
            [['from_station_id', 'to_station_id', 'hardbed', 'hardseat','train_number','date'], 'required', 'on'=>['create', 'update']],
            [['from_station_id'], 'exist', 'targetClass'=> Station::className(),'targetAttribute'=>['from_station_id'=>'Id']],
            [['to_station_id'], 'exist', 'targetClass'=> Station::className(),'targetAttribute'=>['to_station_id'=>'Id']],
            [['date'], 'date', 'format'=>'php: Y-m-d'],
            [['from_station_id', 'to_station_id', 'hardbed', 'hardseat'], 'integer', 'min'=>0],
            [['create_time'], 'safe'],
            [['author'], 'string', 'max' => 20]
        ];
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
            'hardbed' => 'Hardbed',
            'hardseat' => 'Hardseat',
            'create_time' => 'Create Time',
            'author' => 'Author',
        ];
    }
    public static function loadDirtyData($from, $to, $queryDate){
        if($from && $to){
            $arr = LoadData::loadDirtyData($from->code, $to->code, $queryDate);
            if(!is_array($arr))return false;
            foreach($arr as $key=>$data){
                $dirty = DirtyData::find()->where([
                    'from_station_id'=>$from->Id,
                    'to_station_id'=>$to->Id,
                    'date'=> $queryDate,
                    'train_number'=>$data['station_train_code']
                ])->orderBy('Id desc')->one();
                if(!$dirty){
                    $dirty = new DirtyData();
                }else{//当天重复进行的
                    if( is_numeric($data['yz_num']) && $dirty->hardseat < $data['yz_num']){
                        $openbuy = Openbuy::find()->where($arr =[
                            'from_station_id'=>$from->Id,
                            'to_station_id'=>$to->Id,
                            'delay_day'=> ceil((strtotime($queryDate) - time()) / 86400),
                            'train_number'=> $data['station_train_code'],
                            'type'=>'硬座'
                        ])->one();
                        if(!$openbuy){
                            $openbuy = new Openbuy();
                            $openbuy->from_station_id = $from->Id;
                            $openbuy->to_station_id = $to->Id;
                            $openbuy->type = '硬座';
                            $openbuy->train_number = $data['station_train_code'];
                            $openbuy->delay_day =  ceil((strtotime($queryDate) - time()) / 86400);
                        }
                        if(! $openbuy->save())return $openbuy->getFirstErrors();
                        $createtime = new Createtime();
                        $createtime->openbuy_id = $openbuy->Id;
                        $createtime->increased = $data['yz_num'] - $dirty->hardseat;
                        if(!$createtime->save())return $createtime->getFirstErrors();

                    }
                    if(is_numeric($data['yw_num']) && $dirty->hardbed < $data['yw_num']){
                        $openbuy = Openbuy::find()->where($arr = [
                            'from_station_id'=>$from->Id,
                            'to_station_id'=>$to->Id,
                            'delay_day'=> ceil((strtotime($queryDate) - time()) / 86400),
                            'train_number'=> $data['station_train_code'],
                            'type'=>'硬卧'
                        ])->one();
                        if(!$openbuy){
                            $openbuy = new Openbuy();
                            $openbuy->from_station_id = $from->Id;
                            $openbuy->to_station_id = $to->Id;
                            $openbuy->type = '硬卧';
                            $openbuy->train_number = $data['station_train_code'];
                            $openbuy->delay_day =  ceil((strtotime($queryDate) - time()) / 86400);
                        }
                        if(! $openbuy->save())return $openbuy->getFirstErrors();
                        $createtime = new Createtime();
                        $createtime->openbuy_id = $openbuy->Id;
                        $createtime->increased = $data['yw_num'] - $dirty->hardbed;
                        if(!$createtime->save())return $createtime->getFirstErrors();
                    }
                }

                $dirty->from_station_id = $from->Id;
                $dirty->to_station_id = $to->Id;
                $dirty->date = $queryDate;
                $dirty->train_number = $data['station_train_code'];
                $dirty->hardbed = is_numeric($data['yw_num']) ? $data['yw_num'] : 0;
                $dirty->hardseat = is_numeric($data['yz_num']) ? $data['yz_num'] : 0;
                if( !$dirty->save()){
                    return $dirty->getFirstErrors();
                }
            }
        }
        return $dirty;
    }
    public function loadAll(){
        $fromto = Fromto::find()->all();
        $queryDate = [];
        for($i=1;$i<30;$i++){
            $queryDate[$i] = date("Y-m-d", time() + $i * 86400);
        }
        if(is_array($fromto)){

            foreach($fromto as $key=>$value){
                $from = Station::findOne($value->from_station_id);
                $to = Station::findOne($value->to_station_id);
                foreach($queryDate as $datekey=>$dateValue){
                    self::loadDirtyData($from, $to, $dateValue);
                }
            }
        }else{
            echo "nothing";
        }
    }
    public function beforeSave($insert)
    {
        if(parent::beforeSave($insert)){
            $this->create_time = date('Y-m-d H:i:s');
            $this->author = 'admin';
            return true;
        }else{
            return false;
        }
    }
}
