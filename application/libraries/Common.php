<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

class Common {

	function current_full_url() {
	   $ci=& get_instance();
	   $return = $ci->config->site_url().'/'.$ci->uri->uri_string();
	   if(count($_GET) > 0)
	   {
	      $get =  array();
	      foreach($_GET as $key => $val)
	      {
	         $get[] = $key.'='.$val;
	      }
	      $return .= '?'.implode('&',$get);
	   }
	   return $return;
	} 
	
	function check_thai_id($personal) { 
		if(strlen($personal) != 13) return false; 
		$sum = 0;

		for($i=0; $i<12;$i++) {
			$sum += intval(($personal{$i})*(13-$i)); 
		}
		if((11-($sum%11))%10 == intval(($personal{12}))) return true; 
		return false; 
	} 
	
	function pre_print($arr=array()) {
		echo "<pre>";
		print_r($arr);
		echo "</pre>";
	}
	
	/**
	 * Show numberic number
	 * @param double $number
	 * @param integer $decimals 
	 * @return string numberic
	*/
	function show_number($number, $decimals=0){
		return number_format($number, $decimals,'.', ',');
	}
	
	/**
	 * Random string 
	 * @param integer $length  string length
	 * @param string $chars    character to random
	 * @return string $string  random string
	 */
	function strrand($length,$chars='abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789') {
		$string = '';
		for($i = 0; $i <= $length-1; $i++) {
			$string .= $chars[rand(0,strlen($chars)-1)];
		}
		return $string;
	}
	
	function datethai($strDate)
	{
		$strYear = date("Y",strtotime($strDate))+543;
		$strMonth= date("n",strtotime($strDate));
		$strDay= date("j",strtotime($strDate));
		$strHour= date("H",strtotime($strDate));
		$strMinute= date("i",strtotime($strDate));
		$strSeconds= date("s",strtotime($strDate));
		$strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
		$strMonthThai=$strMonthCut[$strMonth];
		$str = $strDay.' '.$strMonthThai.' '.$strYear;
		return $str;
	}
	function array_sort($merge_arrays, $sort_field, $sort_desc = false, $limit = 0) {
		$array_count = count ( $merge_arrays );
		
		// fast special cases...
		switch ($array_count) {
			case 0 :
				return array ();
			case 1 :
				return $limit ? array_slice ( reset ( $merge_arrays ), 0, $limit ) : reset ( $merge_arrays );
		}
		
		if ($limit === 0)
			$limit = PHP_INT_MAX;
			
			// rekey merge_arrays array 0->N
		$merge_arrays = array_values ( $merge_arrays );
		
		$best_array = false;
		$best_value = false;
		
		$results = array ();
		
		// move sort order logic outside the inner loop to speed things up
		if ($sort_desc) {
			for($i = 0; $i < $limit; ++ $i) {
				for($j = 0; $j < $array_count; ++ $j) {
					// if the array $merge_arrays[$j] is empty, skip to next
					if (false === ($current_value = current ( $merge_arrays [$j] )))
						continue;
						
						// if we don't have a value for this round, or if the
					// current value is bigger...
					if ($best_value === false || $current_value [$sort_field] > $best_value [$sort_field]) {
						$best_array = $j;
						$best_value = $current_value;
					}
				}
				
				// all arrays empty?
				if ($best_value === false)
					break;
				
				$results [] = $best_value;
				$best_value = false;
				next ( $merge_arrays [$best_array] );
			}
		} else {
			for($i = 0; $i < $limit; ++ $i) {
				for($j = 0; $j < $array_count; ++ $j) {
					if (false === ($current_value = current ( $merge_arrays [$j] )))
						continue;
						
						// if we don't have a value for this round, or if the
					// current value is smaller...
					if ($best_value === false || $current_value [$sort_field] < $best_value [$sort_field]) {
						$best_array = $j;
						$best_value = $current_value;
					}
				}
				
				// all arrays empty?
				if ($best_value === false)
					break;
				
				$results [] = $best_value;
				$best_value = false;
				next ( $merge_arrays [$best_array] );
			}
		}
		
		return $results;
	} 
	
	function add_date($givendate,$day=0,$mth=0,$yr=0) {
    	$cd = strtotime($givendate);
       	$newdate = date('Y-m-d h:i:s', mktime(date('h',$cd),
     		date('i',$cd), date('s',$cd), date('m',$cd)+$mth,
     		date('d',$cd)+$day, date('Y',$cd)+$yr));
       	return $newdate;
    }
   
	/**
	 * Display post time ago as "1 year, 1 week ago" or "5 minutes, 7 seconds ago", etc...
	 * @param datetime $date
	 * @param integer $granularity number of return sentence
	 * @return string time ago
	*/
	function time_ago($date, $granularity = 2) {
		$retval = '';
		$date = strtotime($date);
		$difference = time() - $date;
		$periods = array('ทศวรรษ' => 315360000, 'ปี' => 31536000, 'เดือน' => 2628000, 'สัปดาห์' => 604800, 'วัน' => 86400, 'ชั่วโมง' => 3600, 'นาที' => 60, 'วินาที' => 1 );
		/*$periods = array('decade' => 315360000,
	        'year' => 31536000,
	        'month' => 2628000,
	        'week' => 604800, 
	        'day' => 86400,
	        'hour' => 3600,
	        'minute' => 60,
	        'second' => 1);*/
		if ($difference < 5) { // less than 5 seconds ago, let's say "just now"
			$retval = "ในตอนนี้";
			return $retval;
		} else {
			if ($difference > $periods['วัน']) {
				$postfix = 'ที่ผ่านมา';
			} else {
				$postfix = 'ที่แล้ว';
			}
			foreach($periods as $key => $value) {
				if ($difference >= $value) {
					$time = floor($difference / $value);
					$difference %= $value;
					$retval .= ($retval ? ' ' : '').$time .' ';
					//$retval .= (($time > 1) ? $key.'s' : $key); // use for english.
					$retval .= $key;
					$granularity--;
				}
				if ($granularity == '0') {
					break;
				}
			}
			return ' เมื่อ '.$retval.$postfix;
		}
	}
	
	/**
	 * make a URL small with bitly API
	 * @param string $url
	 * @param string $login user login in bitly API 
	 * @param string $appkey application key in bitly API
	 * $param string $format return format of bitly API
	 * @return string url
	*/
	function make_bitly_url($url, $login = 'o_6gnt8r997t', $appkey = 'R_cd68af474dfb6f0f6acb4a64774d743c', $format = 'xml') {
		//create the URL
		$bitly = 'http://api.bitly.com/v3/shorten?login='.$login.'&apiKey='.$appkey.'&longUrl='.urlencode($url).'&format='.$format;
		//get the url
		//could also use cURL here
		$context = stream_context_create(array('http' => array ('ignore_errors' => true )));
		$response = file_get_contents($bitly, FALSE, $context);
		//$response = file_get_contents($bitly);
		
		//parse depending on desired format
		if (strtolower($format) == 'json') {
			$json = @json_decode($response, true);
			return $json['results'][$url]['shortUrl'];
		} else { //xml	
			$xml = simplexml_load_string($response);
			//return 'http://bit.ly/'.$xml->results->nodeKeyVal->hash;
			// man edit for Bitly new version(2011-10)
			return $xml->data->url;
		}
	}
	
	/**
	 * clean string to seo url
	 * @param string $str
	 * @return string seo url
	*/
	function text_seo_url($str)	{
		$entities_match 	= array(' ','--','&quot;','!','@','#','%','^','&','*','_','(',')','+','{','}','|',':','"','<','>','?','[',']','\\',';',"'",',','.','/','*','+','~','`','=');
		$entities_replace 	= array('-','-','','','','','','','','','','','','','','','','','','','','','','','','');
		$seo_clean		= str_replace($entities_match, $entities_replace, trim($str));
		return $seo_clean;
	}
	
	function clean_html($html, $disallow) {
		return preg_replace("#<\s*\/?(".$disallow.")\s*[^>]*?>#im", '', $html);
	}
	/**
	 * calculate difference date
	 * @param string $interval retun type [s, n, h, d, ww, m, yyyy]
	 * @param date $dateTimeBegin 
	 * @param string $dateTimeEnd
	 * @return string date difference
	*/
	function date_diff($interval, $dateTimeBegin, $dateTimeEnd) {
         //Parse about any English textual datetime
         //$dateTimeBegin, $dateTimeEnd
         $dateTimeBegin = strtotime($dateTimeBegin);

         if($dateTimeBegin === -1) {
         	return("..begin date Invalid");
         }

         $dateTimeEnd = strtotime($dateTimeEnd);

         if($dateTimeEnd === -1) {
         	return("..end date Invalid");
         }

         $dif = $dateTimeEnd - $dateTimeBegin;

         switch($interval) {
         	case "s"://seconds
            	return($dif);

           	case "n"://minutes
               	return(floor($dif/60)); //60s=1m

           	case "h"://hours
               	return(floor($dif/3600)); //3600s=1h

           	case "d"://days
               	return(floor($dif/86400)); //86400s=1d

           	case "ww"://Week
               	return(floor($dif/604800)); //604800s=1week=1semana
               
           	case "m": //similar result "m" dateDiff Microsoft
               	$monthBegin = (date("Y",$dateTimeBegin)*12) + date("n",$dateTimeBegin);
               	$monthEnd = (date("Y",$dateTimeEnd)*12) + date("n",$dateTimeEnd);
              	$monthDiff = $monthEnd - $monthBegin;
               	return($monthDiff);

           	case "yyyy": //similar result "yyyy" dateDiff Microsoft
               	return(date("Y",$dateTimeEnd) - date("Y",$dateTimeBegin));

           	default:
               	return(floor($dif/86400)); //86400s=1d
         }
	} 
	
	/**
	 * Get apache version
	*/
	function apache_version() {
		if (function_exists ( 'apache_get_version' )) {
			if (preg_match ( '|Apache\/(\d+)\.(\d+)\.(\d+)|', apache_get_version (), $version )) {
				return $version [1] . '.' . $version [2] . '.' . $version [3];
			}
		} elseif (isset ( $_SERVER ['SERVER_SOFTWARE'] )) {
			if (preg_match ( '|Apache\/(\d+)\.(\d+)\.(\d+)|', $_SERVER ['SERVER_SOFTWARE'], $version )) {
				return $version [1] . '.' . $version [2] . '.' . $version [3];
			}
		}
		return '(unknown)';
	} 
	
	/**
	 * Get js source name in js html script  
	 * @return false when can not find source
	*/
	function get_js_source($jstags) {
		$count = preg_match('/src=(["\'])(.*?)\1/', $jstags, $match);
		if ($count !== FALSE) 
    		return $match[2];
    		
    	return false;
	}
	
	/**
	 * Get css source name in css html tag  
	 * @return false when can not find source
	*/
	function get_css_source($csstags) {
		$count = preg_match('/href=(["\'])(.*?)\1/', $csstags, $match);
		if ($count !== FALSE) 
    		return $match[2];
    		
    	return false;
	}
	
	
	function bbcode_to_html($bbtext){
		$bbtags = array(
				'[heading1]' => '<h1>','[/heading1]' => '</h1>',
				'[heading2]' => '<h2>','[/heading2]' => '</h2>',
				'[heading3]' => '<h3>','[/heading3]' => '</h3>',
				'[h1]' => '<h1>','[/h1]' => '</h1>',
				'[h2]' => '<h2>','[/h2]' => '</h2>',
				'[h3]' => '<h3>','[/h3]' => '</h3>',
	
				'[paragraph]' => '<p>','[/paragraph]' => '</p>',
				'[para]' => '<p>','[/para]' => '</p>',
				'[p]' => '<p>','[/p]' => '</p>',
				'[left]' => '<p style="text-align:left;">','[/left]' => '</p>',
				'[right]' => '<p style="text-align:right;">','[/right]' => '</p>',
				'[center]' => '<p style="text-align:center;">','[/center]' => '</p>',
				'[justify]' => '<p style="text-align:justify;">','[/justify]' => '</p>',
	
				'[bold]' => '<span style="font-weight:bold;">','[/bold]' => '</span>',
				'[italic]' => '<span style="font-weight:bold;">','[/italic]' => '</span>',
				'[underline]' => '<span style="text-decoration:underline;">','[/underline]' => '</span>',
				'[b]' => '<span style="font-weight:bold;">','[/b]' => '</span>',
				'[i]' => '<span style="font-weight:bold;">','[/i]' => '</span>',
				'[u]' => '<span style="text-decoration:underline;">','[/u]' => '</span>',
				'[break]' => '<br>',
				'[br]' => '<br>',
				'[newline]' => '<br>',
				'[nl]' => '<br>',
	
				'[unordered_list]' => '<ul>','[/unordered_list]' => '</ul>',
				'[list]' => '<ul>','[/list]' => '</ul>',
				'[ul]' => '<ul>','[/ul]' => '</ul>',
	
				'[ordered_list]' => '<ol>','[/ordered_list]' => '</ol>',
				'[ol]' => '<ol>','[/ol]' => '</ol>',
				'[list_item]' => '<li>','[/list_item]' => '</li>',
				'[li]' => '<li>','[/li]' => '</li>',
	
				'[*]' => '<li>','[/*]' => '</li>',
				'[code]' => '<code>','[/code]' => '</code>',
				'[preformatted]' => '<pre>','[/preformatted]' => '</pre>',
				'[pre]' => '<pre>','[/pre]' => '</pre>',
		);
	
		$bbtext = str_ireplace(array_keys($bbtags), array_values($bbtags), $bbtext);
	
		$bbextended = array(
				"/\[url](.*?)\[\/url]/i" => "<a href=\"http://$1\" title=\"$1\">$1</a>",
				"/\[url=(.*?)\](.*?)\[\/url\]/i" => "<a href=\"$1\" title=\"$1\">$2</a>",
				"/\[email=(.*?)\](.*?)\[\/email\]/i" => "<a href=\"mailto:$1\">$2</a>",
				"/\[mail=(.*?)\](.*?)\[\/mail\]/i" => "<a href=\"mailto:$1\">$2</a>",
				"/\[img\]([^[]*)\[\/img\]/i" => "<img src=\"$1\" alt=\" \" />",
				"/\[image\]([^[]*)\[\/image\]/i" => "<img src=\"$1\" alt=\" \" />",
				"/\[image_left\]([^[]*)\[\/image_left\]/i" => "<img src=\"$1\" alt=\" \" class=\"img_left\" />",
				"/\[image_right\]([^[]*)\[\/image_right\]/i" => "<img src=\"$1\" alt=\" \" class=\"img_right\" />",
		);
	
		foreach($bbextended as $match=>$replacement){
			$bbtext = preg_replace($match, $replacement, $bbtext);
		}
		return $bbtext;
	}
	
	
	
	function bbcode_format ($str) {
		// $str = htmlentities($str);  ภาษาไทยจะเพี้ยน
		$str = htmlspecialchars($str);
	
		$simple_search = array(
				//added line break
				'/\[br\]/is',
				'/\[b\](.*?)\[\/b\]/is',
				'/\[i\](.*?)\[\/i\]/is',
				'/\[u\](.*?)\[\/u\]/is',
				'/\[url\=(.*?)\](.*?)\[\/url\]/is',
				'/\[url\](.*?)\[\/url\]/is',
				'/\[align\=(left|center|right)\](.*?)\[\/align\]/is',
				'/\[img\](.*?)\[\/img\]/is',
				'/\[mail\=(.*?)\](.*?)\[\/mail\]/is',
				'/\[mail\](.*?)\[\/mail\]/is',
				'/\[font=(.*?)\](.*?)\[\/font\]/is',
				'/\[size\=(.*?)\](.*?)\[\/size\]/is',
				'/\[color\=(.*?)\](.*?)\[\/color\]/is',
				//added textarea for code presentation
				'/\[codearea\](.*?)\[\/codearea\]/is',
				//added pre class for code presentation
				'/\[code\](.*?)\[\/code\]/is',
				//added paragraph
				'/\[p\](.*?)\[\/p\]/is',
				'/\[center\](.*?)\[\/center\]/is',
				'/\[size\=(.*?)\](.*?)\[\/size\]/is',
				'/\[left\](.*?)\[\/left\]/is',
				'/\[right\](.*?)\[\/right\]/is',
				'/\[ul\](.*?)\[\/ul\]/is',
				'/\[youtube\](.*?)\[\/youtube\]/is',
				
				
		);
	
		$simple_replace = array(
				//added line break
				'<br />',
				'<strong>$1</strong>',
				'<em>$1</em>',
				'<u>$1</u>',
				// added nofollow to prevent spam
				'<a href="$1" rel="nofollow" title="$2 - $1"  target="_blank">$2</a>',
				'<a href="$1" rel="nofollow" title="$1"  target="_blank">$1</a>',
				'<div style="text-align: $1;">$2</div>',
				//added alt attribute for validation
				'<img src="$1" alt="" />',
				'<a href="mailto:$1"  target="_blank">$2</a>',
				'<a href="mailto:$1"  target="_blank">$1</a>',
				'<span style="font-family: $1;">$2</span>',
				'<span style="font-size: $1;">$2</span>',
				'<span style="color: $1;">$2</span>',
				//added textarea for code presentation
				'<textarea class="code_container" rows="30" cols="70">$1</textarea>',
				//added pre class for code presentation
				'<pre class="code">$1</pre>',
				//added paragraph
				'<p>$1</p>',
				'<p style="text-align:center">$1</p>',
				'<p style="font-size: $1">$2</p>',
				'<p style="text-align:left">$1</p>',
				'<p style="text-align:right">$1</p>',
				'<ul>$1</ul>',
				'<iframe width="560" height="315" src="http://www.youtube.com/embed/$1?wmode=opaque" data-youtube-id="$1" frameborder="0" 
				allowfullscreen=""></iframe><span id="sceditor-end-marker" class="sceditor-selection sceditor-ignore" style="line-height: 0; display: none;"> </span><span id="sceditor-start-marker" class="sceditor-selection 
				sceditor-ignore" style="line-height: 0; display: none;"> </span>'
				
		);
	
		// Do simple BBCode's
		$str = preg_replace ($simple_search, $simple_replace, $str);
	
		// Do <blockquote> BBCode
		$str = bbcode_quote($str);
	
		return $str;
	}

	function cut_bbcode ($str) {
		// $str = htmlentities($str);  ภาษาไทยจะเพี้ยน
		$str = htmlspecialchars($str);
	
		$simple_search = array(
				//added line break
				'/\[br\]/is',
				'/\[b\](.*?)\[\/b\]/is',
				'/\[i\](.*?)\[\/i\]/is',
				'/\[u\](.*?)\[\/u\]/is',
				'/\[url\=(.*?)\](.*?)\[\/url\]/is',
				'/\[url\](.*?)\[\/url\]/is',
				'/\[align\=(left|center|right)\](.*?)\[\/align\]/is',
				'/\[img\](.*?)\[\/img\]/is',
				'/\[mail\=(.*?)\](.*?)\[\/mail\]/is',
				'/\[mail\](.*?)\[\/mail\]/is',
				'/\[font=(.*?)\](.*?)\[\/font\]/is',
				'/\[size\=(.*?)\](.*?)\[\/size\]/is',
				'/\[color\=(.*?)\](.*?)\[\/color\]/is',
				//added textarea for code presentation
				'/\[codearea\](.*?)\[\/codearea\]/is',
				//added pre class for code presentation
				'/\[code\](.*?)\[\/code\]/is',
				//added paragraph
				'/\[p\](.*?)\[\/p\]/is',
				'/\[center\](.*?)\[\/center\]/is',
				'/\[size\=(.*?)\](.*?)\[\/size\]/is',
				'/\[left\](.*?)\[\/left\]/is',
				'/\[right\](.*?)\[\/right\]/is',
				'/\[ul\](.*?)\[\/ul\]/is',
				'/\[youtube\](.*?)\[\/youtube\]/is',
	
	
		);
	
		$simple_replace = array(
				//added line break
				'',
				'$1',
				'$1',
				'$1',
				// added nofollow to prevent spam
				'<a href="$1" rel="nofollow" title="$2 - $1"  target="_blank">$2</a>',
				'<a href="$1" rel="nofollow" title="$1"  target="_blank">$1</a>',
				'<div style="text-align: $1;">$2</div>',
				//added alt attribute for validation
				'<img src="$1" alt="" />',
				'<a href="mailto:$1"  target="_blank">$2</a>',
				'<a href="mailto:$1"  target="_blank">$1</a>',
				'<span style="font-family: $1;">$2</span>',
				'<span style="font-size: $1;">$2</span>',
				'<span style="color: $1;">$2</span>',
				//added textarea for code presentation
				'<textarea class="code_container" rows="30" cols="70">$1</textarea>',
				//added pre class for code presentation
				'<pre class="code">$1</pre>',
				//added paragraph
				'$1',
				'$1',
				'$1',
				'$1',
				'$1',
				'$1',
				'<a href="https://www.youtube.com/watch?v=$1">https://www.youtube.com/watch?v=$1</a>'
	
		);
	
		// Do simple BBCode's
		$str = preg_replace ($simple_search, $simple_replace, $str);
	
		// Do <blockquote> BBCode
		$str = bbcode_quote($str);
	
		return $str;
	}
	
	
	

// 	function bbcode_quote ($str) {
// 		//added div and class for quotes
// 		$open = '<blockquote><div class="quote">';
// 		$close = '</div></blockquote>';
	
// 		// How often is the open tag?
// 		preg_match_all ('/\[quote\]/i', $str, $matches);
// 		$opentags = count($matches['0']);
	
// 		// How often is the close tag?
// 		preg_match_all ('/\[\/quote\]/i', $str, $matches);
// 				$closetags = count($matches['0']);
	
// 				// Check how many tags have been unclosed
// 				// And add the unclosing tag at the end of the message
// 				$unclosed = $opentags - $closetags;
// 				for ($i = 0; $i < $unclosed; $i++) {
// 				$str .= '</div></blockquote>';
// 	}
	
// 				// Do replacement
//     $str = str_replace ('[' . 'quote]', $open, $str);
// 	$str = str_replace ('[/' . 'quote]', $close, $str);
	
// 	return $str;
// 	}
	
	
	

}


/* End of file Utilitiesphp */
/* Location: ./application/libraries/Utilities.php */

