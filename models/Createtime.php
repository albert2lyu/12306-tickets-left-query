<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "create_time".
 *
 * @property integer $Id
 * @property integer $openbuy_id
 * @property string $create_time
 * @property string $author
 */
class Createtime extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'create_time';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['openbuy_id'], 'required'],
            [['openbuy_id'], 'exist', 'targetClass'=> Openbuy::className(), 'targetAttribute'=>['openbuy_id'=>'Id']],
            [['openbuy_id', 'increased'], 'integer', 'min'=>0],
            [['create_time'], 'safe'],
            [['author'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'Id' => 'ID',
            'increased'=> 'Increased',
            'openbuy_id' => 'Openbuy ID',
            'create_time' => 'Create Time',
            'author' => 'Author',
        ];
    }

    public function beforeSave($insert)
    {
        if(parent::beforeSave($insert)){
            if($this->isNewRecord){
                $this->create_time = date('Y-m-d H:i:s');
                $this->author = 'admin';
            }else{
                $this->create_time = date('Y-m-d H:i:s');
                $this->author = 'admin';
            }
            return true;
        }else{
            return false;
        }
    }
}
