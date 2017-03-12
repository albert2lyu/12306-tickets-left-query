<?php
namespace app\models;

class LoadData{
    public static function loadDirtyData($from, $to, $datetime){
        //获取API传过来的信息 queryDate 时间 from_station 始发站编号 to_station 到达站编号
        $url = "https://kyfw.12306.cn/otn/leftTicket/queryA?leftTicketDTO.train_date={$datetime}&leftTicketDTO.from_station={$from}&leftTicketDTO.to_station={$to}&purpose_codes=ADULT";
        // $url = "https://kyfw.12306.cn/otn/lcxxcx/query?purpose_codes=ADULT&queryDate={$datetime}&from_station={$from}&to_station={$to}";
        //获取内容 内容是json格式
        $data = LoadData::getContent($url);
        //转码
        $data = json_decode($data);
        //得到数组数据
        $res = [];
        foreach($data->data as $key=>$value){
            $value = $value->queryLeftNewDTO;

        }
        return false;
        $data2 = LoadData::object_array($data);
        return $data2['data']['datas'];
        //稍稍美化一下
        /*echo '<table border="1">';
        echo '<tr><td>车次</td><td>始发站/到达站/终点站</td><td>出发时间/到达时间</td><td>历时</td><td>商务座</td><td>特等座</td>
                <td>一等座</td><td>二等座</td><td>高级软卧</td><td>软卧</td><td>硬卧</td><td>软座</td><td>硬座</td>
                <td>无座</td><td>其他</td><td>备注</td></tr>';
        //循环
        foreach($data2['data']['datas'] as $k=>$v){
            echo '<tr><td>'.$v['station_train_code'].'</td><td>'.$v['start_station_name'].'->'.$v['to_station_name'].'->'.$v['end_station_name'].'</td><td>'.$v['start_time'].'  /  '.$v['arrive_time'].'</td><td>'.$v['lishi'].'</td><td>'.$v['swz_num'].'</td><td>'.$v['tz_num'].'</td><td>'.$v['zy_num'].'</td><td>'.$v['ze_num'].'</td><td>'.$v['gr_num'].'</td><td>'.$v['rw_num'].'</td><td>'.$v['yw_num'].'</td><td>'.$v['rz_num'].'</td><td>'.$v['yz_num'].'</td><td>'.$v['wz_num'].'</td><td>'.$v['qt_num'].'</td><td>'.$v['note'].'</td></tr>';
        }
        echo '</table>';*/
        /*
         *   ["gr_num"]=>高级软卧
         *   ["qt_num"]=>其他
         *   ["rw_num"]=> 软卧
         *   ["rz_num"]=>软座
         *   ["tz_num"]=>特等座
         *   ["wz_num"]=>无座
         *   ["yw_num"]=>硬卧
         *   ["yz_num"]=>硬座
         *   ["ze_num"]=>二等座
         *   ["zy_num"]=> 一等座
         *   ["swz_num"]=> 商务座
         */
    }
    public static function loadStationStartTime(){
        $url = "https://kyfw.12306.cn/otn/resources/js/query/qss.js?station_version=1.8987";
        $data = LoadData::getContent($url);
        $data = substr($data, 15);
        return LoadData::object_array(json_decode($data));
    }
    public static function loadStationCode(){
        $url = "https://kyfw.12306.cn/otn/resources/js/framework/station_name.js?station_version=1.8987";
        $data = LoadData::getContent($url);
        $string = substr($data, 20);
        $arr1 =  explode('@', $string);
        $result = [];
        if($arr1){
            foreach($arr1 as $key=>$value){
                $arr2 = explode('|', $value);
                if(isset($arr2[1]) && isset($arr2[2])){
                    $result[$arr2[1]] = $arr2[2];
                }
            }
        }
        return $result;
    }
    public static function getContent($url){//获取网页中输出部分，并返回字符串
        $ch = curl_init();
        $timeout = 5;
        curl_setopt ($ch, CURLOPT_URL, $url);
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,FALSE);
        curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        $dxycontent = curl_exec($ch);
        curl_close($ch);
        return $dxycontent;
    }
    //json转码之后是对象, 需要将对象转数组 不然无法进行循环
    public static function object_array($array){
        if(is_object($array)){
            $array = (array)$array;
        }
        if(is_array($array)){
            foreach($array as $key=>$value){
                $array[$key] = self::object_array($value);
            }
        }
        return $array;
    }
}
