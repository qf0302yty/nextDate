<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
	    // $ch = curl_init();
	    // $url = 'http://apis.baidu.com/netpopo/calendar/query?date=2017-04-03';
	    // $header = array(
	    //     'apikey: 您自己的apikey',
	    // );
	    // // 添加apikey到header
	    // curl_setopt($ch, CURLOPT_HTTPHEADER  , $header);
	    // curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	    // // 执行HTTP请求
	    // curl_setopt($ch , CURLOPT_URL , $url);
	    // $res = curl_exec($ch);

	    // $date = json_decode($res);

	    // $this->assign('lunarMonth',$date->lunarmonth);
	    // $this->assign('lunarDay',$date->lunarday);

	    // $this->display();
    }

    //测试接口方法
    public function test($year=2017, $month=04, $day=03){
    	$nextDate = $this->nextDay($year, $month, $day);
    	echo $nextDate['year']."/".$nextDate['month']."/".$nextDate['day']."<br>";
    	$weekday = $this->getWeekday($nextDate['year'],$nextDate['month'],$nextDate['day']);
    	echo $weekday."<br>";

        $lunar = $this->getLunar($nextDate['year'],$nextDate['month'],$nextDate['day']);
        echo $lunar;
    }

    public function showDate($year=2017, $month=04, $day=03){
        $year = $_POST['year'];
        $month = $_POST['month'];
        $day = $_POST['day'];

        $monArray = array("一","二","三","四","五","六","七","八","九","十","十一","十二");
        $weekArray = array("一","二","三","四","五","六","日");

        $nextDate = $this->nextDay($year, $month, $day);
        $weekday = $this->getWeekday($nextDate['year'],$nextDate['month'],$nextDate['day']);
        $lunar = $this->getLunar($nextDate['year'],$nextDate['month'],$nextDate['day']);
        $array = array($nextDate['year'],$monArray[$nextDate['month']-1],$nextDate['day'],$weekArray[$weekday-1],$lunar);

            // $array = array($nextDate['year'],$monArray[$nextDate['month']-1],$nextDate['day'],$weekArray[$weekday-1]);

        echo json_encode($array);
    }

    //计算输入日期下一天的日期
    protected function nextDay($year=2017, $month=04, $day=03){
	    //判断是否是闰年
    	if($this->isLeap($year)){
    		$num = array(31, 29, 31, 30, 31, 30, 31, 31, 30 ,31, 30, 31);
    		$nextDay = ($day + 1)%($num[$month-1]+1);
    		$nextMonth = ($month + ($day+1)/($num[$month-1]+1))%13;
    		$nextYear = $year + (int)(($month + ($day+1)/($num[$month-1]+1))/13);
    		if($nextDay == 0){
    			$nextDay = 1;
    		}
    		if($nextMonth == 0){
    			$nextMonth = 1;
    		}
    	}else{
    		$num = array(31, 28, 31, 30, 31, 30, 31, 31, 30 ,31, 30, 31);
    		$nextDay = ($day + 1)%($num[$month-1]+1);
    		$nextMonth = ($month + ($day+1)/($num[$month-1]+1))%13;
    		$nextYear = $year + (int)(($month + ($day+1)/($num[$month-1]+1))/13);
    		if($nextDay == 0){
    			$nextDay = 1;
    		}
    		if($nextMonth == 0){
    			$nextMonth = 1;
    		}
    	}
    		
    	return array("year"=>$nextYear, "month"=>$nextMonth, "day"=>$nextDay);
    }

    // 获取输入日期的星期信息
    protected function getWeekday($year=2017, $month=04, $day=03){
    	if($month == 1){
    		$month = 13;
    		$year = $year - 1;
    	}else if($month == 2){
    		$month = 14;
    		$year = $year - 1;
    	}

    	$c = (int)($year/100);
    	$y = (int)($year%100);

    	// echo $c." ".$y."<br>";

    	$weekday = ((int)($c/4) - 2*$c + $y + (int)($y/4) + (int)((13*($month+1))/5) + $day - 1)%7;

    	if($weekday <= 0){
    		$weekday = 7 + $weekday;
    	}

    	return $weekday;
    }

    // 获取输入日期的农历信息
    protected function getLunar($year=2017, $month=04, $day=03){
        $appkey = "2d90b2febb37d4d0c30f8aa6ecde97d5";

        $url = "http://v.juhe.cn/calendar/day";
        $params = array(
            "key" => $appkey,
            "date" => $year."-".$month."-".$day,
        );
        $paramstring = http_build_query($params);
        $content = $this->juhecurl($url,$paramstring);
        $result = json_decode($content,true);
        if($result){
            if($result['error_code']=='0'){
                // print_r($result);
                return $result['result']['data']['lunarYear']." ".$result['result']['data']['lunar'];
            }else{
                echo $result['error_code'].":".$result['reason'];
            }
        }else{
            echo "请求失败";
        }
    }

    protected function juhecurl($url,$params=false,$ispost=0){
        $httpInfo = array();
        $ch = curl_init();
     
        curl_setopt( $ch, CURLOPT_HTTP_VERSION , CURL_HTTP_VERSION_1_1 );
        curl_setopt( $ch, CURLOPT_USERAGENT , 'JuheData' );
        curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT , 60 );
        curl_setopt( $ch, CURLOPT_TIMEOUT , 60);
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER , true );
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        if( $ispost )
        {
            curl_setopt( $ch , CURLOPT_POST , true );
            curl_setopt( $ch , CURLOPT_POSTFIELDS , $params );
            curl_setopt( $ch , CURLOPT_URL , $url );
        }
        else
        {
            if($params){
                curl_setopt( $ch , CURLOPT_URL , $url.'?'.$params );
            }else{
                curl_setopt( $ch , CURLOPT_URL , $url);
            }
        }
        $response = curl_exec( $ch );
        if ($response === FALSE) {
            //echo "cURL Error: " . curl_error($ch);
            return false;
        }
        $httpCode = curl_getinfo( $ch , CURLINFO_HTTP_CODE );
        $httpInfo = array_merge( $httpInfo , curl_getinfo( $ch ) );
        curl_close( $ch );
        return $response;
    }

    protected function isLeap($year=2017){
    	if($year%400 == 0) {
    		return true;
    	}else if($year%4 == 0 && $year%100 != 0) {
    		return true;
    	}else {
    		return false;
    	}
    }
}