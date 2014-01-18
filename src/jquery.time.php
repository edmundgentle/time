<?php
/**
 * Formats a date in a relative manner for the user
 *
 * @param integer $timestamp A standard UNIX timestamp
 * @return string HTML code to be inserted into the page
 *
 * @author Edmund Gentle (https://github.com/edmundgentle)
 */
function jquery_time($timestamp) {
	global $jq_time_cache;
	if(!defined('JQ_TIME_LOCALE')) {
		define('JQ_TIME_LOCALE','EN');
	}
	if(!defined('JQ_TIME_DIR')) {
		define('JQ_TIME_DIR','/langs/');
	}
	if(!defined('JQ_TIME_TAG')) {
		define('JQ_TIME_TAG','abbr');
	}
	if(!isset($jq_time_cache)) {
		if(file_exists(__DIR__.JQ_TIME_DIR.strtolower(JQ_TIME_LOCALE).'.json')) {
			$jq_time_cache=@json_decode(@file_get_contents(__DIR__.JQ_TIME_DIR.strtolower(JQ_TIME_LOCALE).'.json'),true);
		}
	}
	if(!isset($jq_time_cache) or !$jq_time_cache) {
		if(file_exists(__DIR__.JQ_TIME_DIR.'en.json')) {
			$jq_time_cache=@json_decode(@file_get_contents(__DIR__.JQ_TIME_DIR.'en.json'),true);
		}
	}
	if($jq_time_cache) {
		$time_string=jquery_time_parse_string($jq_time_cache['format'],$timestamp);
		
		$relative_time=$time_string;
		$now=time();
		$diff=$now-$timestamp;
		if($diff<60) {
			$relative_time=$jq_time_cache['relative'][0];
		}elseif($diff<3600) {
			if(floor($diff/60)==1) {
				$relative_time= $jq_time_cache['relative'][1];
			}else{
				$relative_time= $jq_time_cache['relative'][2];
				$relative_time=str_replace('[MIN]',floor($diff/60),$relative_time);
			}
		}elseif($diff<86400) {
			if(floor($diff/3600)==1) {
				$relative_time= $jq_time_cache['relative'][3];
			}else{
				if(date('d/m/Y',$timestamp)!=date('d/m/Y',$now)) {
					$relative_time= jquery_time_parse_string($jq_time_cache['relative'][4],$timestamp);
				}else{
					$relative_time=$jq_time_cache['relative'][5];
					$relative_time=str_replace('[HOUR]',floor($diff/3600),$relative_time);
				}
			}
		}elseif($diff<604800) {
			if(date('d/m/Y',$timestamp)==date('d/m/Y',strtotime("-1 day",$now))) {
				$relative_time=jquery_time_parse_string($jq_time_cache['relative'][4],$timestamp);
			}else{
				$relative_time= jquery_time_parse_string($jq_time_cache['relative'][6],$timestamp);
			}
		}else{
			if(date('Y',$timestamp)!=date('Y',$now)) {
				$relative_time= jquery_time_parse_string($jq_time_cache['relative'][7],$timestamp);
			}else{
				$relative_time= jquery_time_parse_string($jq_time_cache['relative'][8],$timestamp);
			}
		}
		
		return '<'.JQ_TIME_TAG.' title="'.$time_string.'" data-time="'.$timestamp.'" class="jq_time_live">'.$relative_time.'</'.JQ_TIME_TAG.'>';
	}
}
/**
 * Returns a string containing a parsed date string. Used by the jquery_time function.
 *
 * @param string $time_string The string to format
 * @return integer A UNIX timestamp
 *
 * @author Edmund Gentle (https://github.com/edmundgentle)
 */
function jquery_time_parse_string($time_string,$timestamp) {
	global $jq_time_cache;
	if($jq_time_cache) {
		$time_string=str_replace('[DAY]',$jq_time_cache['day'][date('w',$timestamp)],$time_string);
		$time_string=str_replace('[FDAY]',$jq_time_cache['fullday'][date('w',$timestamp)],$time_string);
		$time_string=str_replace('[DATE]',date('j',$timestamp),$time_string);
		$time_string=str_replace('[MONTH]',$jq_time_cache['month'][date('n',$timestamp)-1],$time_string);
		$time_string=str_replace('[FMONTH]',$jq_time_cache['fullmonth'][date('n',$timestamp)-1],$time_string);
		$time_string=str_replace('[YEAR]',date('y',$timestamp),$time_string);
		$time_string=str_replace('[FYEAR]',date('Y',$timestamp),$time_string);
		$time_string=str_replace('[HOUR]',date('g',$timestamp),$time_string);
		$time_string=str_replace('[FHOUR]',date('H',$timestamp),$time_string);
		$time_string=str_replace('[MIN]',date('i',$timestamp),$time_string);
		$time_string=str_replace('[AMPM]',$jq_time_cache[date('a',$timestamp)],$time_string);
		return $time_string;
	}
}
?>