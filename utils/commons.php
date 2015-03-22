<?php
$root = $_SERVER['DOCUMENT_ROOT'];
// CUSTOM MINIFIER SCRIPT (REPLACES ALL LINE BREAKS AND EXTRA WHITE SPACES)
function mini($string)
{
    $string = str_replace(array("\r\n", "\r"), "\n", $string);
    $lines = explode("\n", $string);
    $new_lines = array();

    foreach ($lines as $i => $line) {
        if(!empty($line))
            $new_lines[] = trim($line);
    }
    $string = implode($new_lines);
    //return preg_replace('/<!--.*?-->/s', '',preg_replace('/[ \t]+/', ' ', preg_replace('/\s*$^\s*/m', "\n", $string)));
    return preg_replace('/[ \t]+/', ' ', preg_replace('/\s*$^\s*/m', "\n", $string));
}
function minis($s){
    return $s;
}
function requestGET($url)
{
    $ch = curl_init();

    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,TRUE);
    curl_setopt($ch,CURLOPT_FOLLOWLOCATION,TRUE);

    $output=curl_exec($ch);

    curl_close($ch);
    return $output;
}
function generateAnokhaID(){
    $lastID = DB::queryFirstField("SELECT `registration_id` FROM `registrations` ORDER BY registration_id DESC LIMIT 1");
    $number = str_pad((9999-intval($lastID)), 4, '0', STR_PAD_LEFT);
    return "AO15".$number;
}
function generateDeskAnokhaID(){
    $lastID = DB::queryFirstField("SELECT dvalue FROM datastore WHERE dkey = 'desk_anokha_id_count' LIMIT 1");
    $number = str_pad((9999-intval($lastID)), 4, '0', STR_PAD_LEFT);
    DB::query("UPDATE datastore SET dvalue = %s WHERE dkey = 'desk_anokha_id_count'",intval($lastID)+1);
    return "AD15".$number;
}
// ARRAY HELPER FUNCTIONS
function toArray($string,$delimiter=","){
    if($string==""||$string==" "||$string==null){
        return array(null,null,null,null);
    }
    return explode($delimiter, $string);
}
function toString($array,$delimiter=","){
    if($array==null||sizeof($array)==0){
        return "";
    }
    return implode($delimiter, $array);
}
function removeFromArray($what,$array){
    if(($key = array_search($what, $array)) !== false) {
        unset($array[$key]);
    }
    return $array;
}
function toPermalink ($text)
{
    $text = preg_replace('~[^\\pL\d]+~u', '-', $text);
    $text = trim($text, '-');
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
    $text = strtolower($text);
    $text = preg_replace('~[^-\w]+~', '', $text);
    if (empty($text))
    {
        return 'n-a';
    }
    return $text;
}
function cleanUpForAndroid($str){
    /*$str = str_ireplace("<strong>","",$str);
    $str = str_ireplace("</strong>","",$str);
    $str = str_ireplace("<p></p>","\n\n",$str);
    $str = str_ireplace("</p>","\n\n",$str);
    $str = strip_tags($str);*/
    $str = preg_replace('/<!--\[if[^\]]*]>.*?<!\[endif\]-->/i', '', $str);
    $str = preg_replace('/<!--\[if[^\]]*]>.*?-->/i', '', $str);
    $str = strip_tags($str,"<b><p><strong><em><i><br><font>");
    return $str;
}
function hashPassword($salt,$password){
    return hash("sha256",$salt.$password);
}
function getLogger(){
    return new Katzgrau\KLogger\Logger($_SERVER['DOCUMENT_ROOT']."/logs");
}
function getCronLogger(){
    return new Katzgrau\KLogger\Logger("/data/anokha/logs/cron");
}
function floatToRupee($num){
    $isNegative = false;
    if(intval($num)<0){
        $isNegative = true;
        $num = intval($num)*(-1);
    }
    $num = floatval($num);
    $explrestunits = "" ;
    if(strlen($num)>3){
        $lastthree = substr($num, strlen($num)-3, strlen($num));
        $restunits = substr($num, 0, strlen($num)-3); // extracts the last three digits
        $restunits = (strlen($restunits)%2 == 1)?"0".$restunits:$restunits; // explodes the remaining digits in 2's formats, adds a zero in the beginning to maintain the 2's grouping.
        $expunit = str_split($restunits, 2);
        for($i=0; $i<sizeof($expunit); $i++){
            // creates each of the 2's group and adds a comma to the end
            if($i==0)
            {
                $explrestunits .= (int)$expunit[$i].","; // if is first value , convert into integer
            }else{
                $explrestunits .= $expunit[$i].",";
            }
        }
        $thecash = $explrestunits.$lastthree;
    } else {
        $thecash = $num;
    }
    if($isNegative){
        return "(-) Rs. ".$thecash; // writes the final format where $currency is the currency symbol.

    } else {
        return "Rs. ".$thecash; // writes the final format where $currency is the currency symbol.
    }
}
function rupeeToFloat($val){
    $val = str_ireplace("Rs.","",$val);
    $val = str_ireplace(",","",$val);
    $val = trim($val);
    return floatval($val);
}
function getDateTime(){
    return \Carbon\Carbon::now('Asia/Kolkata');
}
function getDateTimeString(){
    return \Carbon\Carbon::now('Asia/Kolkata')->toDateTimeString();
}
function stringHas($needle,$haystack){
    if (strpos($haystack,$needle) !== false) {
        return true;
    } else {
        return false;
    }
}
function hasAccess($user,$for){
    $accessLevels = $user['user_access_levels'];

    if(stringHas("full",$accessLevels) || stringHas("superman",$accessLevels)){
        if($for=="open_close"){
            if($user['user_id']==1504||$user['user_id']==1507){
                return true;
            }
            if(stringHas("open_close",$accessLevels)){
                return true;
            } else {
                return false;
            }
        } else {
            return true;
        }
    }
    switch($for){
        case "desk":
            if(stringHas("open_close",$accessLevels)||stringHas("finance_team",$accessLevels)||stringHas("finance_head",$accessLevels)){
                return true;
            } else {
                return stringHas($for,$accessLevels);
            }
        case "open_close":
            return stringHas($for,$accessLevels);
        case "finance_team":
            if(stringHas("finance_head",$accessLevels)){
                return true;
            } else {
                return stringHas($for,$accessLevels);
            }
        case "finance_head":
            return stringHas($for,$accessLevels);
        case "hospitality_desk":
            return stringHas($for,$accessLevels);
        case "hospitality_hostels":
            return stringHas($for,$accessLevels);
        case "hospitality_finances":
            return stringHas($for,$accessLevels);
        case "statistics":
            return true;
        default:
            return false;
    }
}
function hasFullAccess($user){
    $accessLevels = $user['user_access_levels'];
    if(stringHas("full",$accessLevels) || stringHas("superman",$accessLevels)){
        return true;
    } else {
        return false;
    }
}
function arrayFilter($key,$value,$array,$inverse = false){
    $output = array();
    foreach($array as $row){
        if($inverse){
            if(trim($row[$key])!=$value){
                array_push($output,$row);
            }
        } else {
            if(trim($row[$key])==$value){
                array_push($output,$row);
            }
        }
    }
    return $output;
}

function truncate($string, $length, $dots = "...") {
    return (strlen($string) > $length) ? substr($string, 0, $length - strlen($dots)) . $dots : $string;
}

function getOS() {

    $user_agent = $_SERVER['HTTP_USER_AGENT'];

    $os_platform    =   "Unknown OS Platform";

    $os_array       =   array(
        '/windows nt 6.3/i'     =>  'Windows 8.1',
        '/windows nt 6.2/i'     =>  'Windows 8',
        '/windows nt 6.1/i'     =>  'Windows 7',
        '/windows nt 6.0/i'     =>  'Windows Vista',
        '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
        '/windows nt 5.1/i'     =>  'Windows XP',
        '/windows xp/i'         =>  'Windows XP',
        '/windows nt 5.0/i'     =>  'Windows 2000',
        '/windows me/i'         =>  'Windows ME',
        '/win98/i'              =>  'Windows 98',
        '/win95/i'              =>  'Windows 95',
        '/win16/i'              =>  'Windows 3.11',
        '/macintosh|mac os x/i' =>  'Mac OS X',
        '/mac_powerpc/i'        =>  'Mac OS 9',
        '/linux/i'              =>  'Linux',
        '/ubuntu/i'             =>  'Ubuntu',
        '/iphone/i'             =>  'iPhone',
        '/ipod/i'               =>  'iPod',
        '/ipad/i'               =>  'iPad',
        '/android/i'            =>  'Android',
        '/blackberry/i'         =>  'BlackBerry',
        '/webos/i'              =>  'Mobile'
    );

    foreach ($os_array as $regex => $value) {

        if (preg_match($regex, $user_agent)) {
            $os_platform    =   $value;
        }

    }
    return $os_platform;
}

function getUserIP() {
    // check for shared internet/ISP IP
    if (!empty($_SERVER['HTTP_CLIENT_IP']) && validate_ip($_SERVER['HTTP_CLIENT_IP'])) {
        return $_SERVER['HTTP_CLIENT_IP'];
    }

    // check for IPs passing through proxies
    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        // check if multiple ips exist in var
        if (strpos($_SERVER['HTTP_X_FORWARDED_FOR'], ',') !== false) {
            $iplist = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            foreach ($iplist as $ip) {
                if (validate_ip($ip))
                    return $ip;
            }
        } else {
            if (validate_ip($_SERVER['HTTP_X_FORWARDED_FOR']))
                return $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
    }
    if (!empty($_SERVER['HTTP_X_FORWARDED']) && validate_ip($_SERVER['HTTP_X_FORWARDED']))
        return $_SERVER['HTTP_X_FORWARDED'];
    if (!empty($_SERVER['HTTP_X_CLUSTER_CLIENT_IP']) && validate_ip($_SERVER['HTTP_X_CLUSTER_CLIENT_IP']))
        return $_SERVER['HTTP_X_CLUSTER_CLIENT_IP'];
    if (!empty($_SERVER['HTTP_FORWARDED_FOR']) && validate_ip($_SERVER['HTTP_FORWARDED_FOR']))
        return $_SERVER['HTTP_FORWARDED_FOR'];
    if (!empty($_SERVER['HTTP_FORWARDED']) && validate_ip($_SERVER['HTTP_FORWARDED']))
        return $_SERVER['HTTP_FORWARDED'];

    // return unreliable ip since all else failed
    return $_SERVER['REMOTE_ADDR'];
}

/**
 * Ensures an ip address is both a valid IP and does not fall within
 * a private network range.
 */
function validate_ip($ip) {
    if (strtolower($ip) === 'unknown')
        return false;
    // generate ipv4 network address
    $ip = ip2long($ip);
    // if the ip is set and not equivalent to 255.255.255.255
    if ($ip !== false && $ip !== -1) {
        // make sure to get unsigned long representation of ip
        // due to discrepancies between 32 and 64 bit OSes and
        // signed numbers (ints default to signed in PHP)
        $ip = sprintf('%u', $ip);
        // do private network range checking
        if ($ip >= 0 && $ip <= 50331647) return false;
        if ($ip >= 167772160 && $ip <= 184549375) return false;
        if ($ip >= 2130706432 && $ip <= 2147483647) return false;
        if ($ip >= 2851995648 && $ip <= 2852061183) return false;
        if ($ip >= 2886729728 && $ip <= 2887778303) return false;
        if ($ip >= 3221225984 && $ip <= 3221226239) return false;
        if ($ip >= 3232235520 && $ip <= 3232301055) return false;
        if ($ip >= 4294967040) return false;
    }
    return true;
}
function generateEncryptedURI($anokhaID,$eventID,$teamID="none"){
    $dataBundleString = json_encode(array(
        "anokha_id" => $anokhaID,
        "event_id" => $eventID,
        "team_id" => $teamID
    ));
    return Security::encryptQueryParam($dataBundleString);
}
function generateFromPHTML($filename){
    if(is_file($filename)){
        ob_start();
        include $filename;
        $contents = ob_get_contents();
        ob_end_clean();
        return $contents;
    }
    return false;
}
function getDocumentRoot(){
    return $_SERVER['DOCUMENT_ROOT'];
}
function cleanString($text) {
    $text = preg_replace("/[áàâãªä]/u","a",$text);
    $text = preg_replace("/[ÁÀÂÃÄ]/u","A",$text);
    $text = preg_replace("/[ÍÌÎÏ]/u","I",$text);
    $text = preg_replace("/[íìîï]/u","i",$text);
    $text = preg_replace("/[éèêë]/u","e",$text);
    $text = preg_replace("/[ÉÈÊË]/u","E",$text);
    $text = preg_replace("/[óòôõºö]/u","o",$text);
    $text = preg_replace("/[ÓÒÔÕÖ]/u","O",$text);
    $text = preg_replace("/[úùûü]/u","u",$text);
    $text = preg_replace("/[ÚÙÛÜ]/u","U",$text);
    $text = preg_replace("/[’‘‹›‚]/u","'",$text);
    $text = preg_replace("/[“”«»„]/u",'"',$text);
    $text = str_replace("–","-",$text);
    $text = str_replace(" "," ",$text);
    $text = str_replace("ç","c",$text);
    $text = str_replace("Ç","C",$text);
    $text = str_replace("ñ","n",$text);
    $text = str_replace("Ñ","N",$text);

    $trans = get_html_translation_table(HTML_ENTITIES);
    $trans[chr(130)] = '&sbquo;';    // Single Low-9 Quotation Mark
    $trans[chr(131)] = '&fnof;';    // Latin Small Letter F With Hook
    $trans[chr(132)] = '&bdquo;';    // Double Low-9 Quotation Mark
    $trans[chr(133)] = '&hellip;';    // Horizontal Ellipsis
    $trans[chr(134)] = '&dagger;';    // Dagger
    $trans[chr(135)] = '&Dagger;';    // Double Dagger
    $trans[chr(136)] = '&circ;';    // Modifier Letter Circumflex Accent
    $trans[chr(137)] = '&permil;';    // Per Mille Sign
    $trans[chr(138)] = '&Scaron;';    // Latin Capital Letter S With Caron
    $trans[chr(139)] = '&lsaquo;';    // Single Left-Pointing Angle Quotation Mark
    $trans[chr(140)] = '&OElig;';    // Latin Capital Ligature OE
    $trans[chr(145)] = '&lsquo;';    // Left Single Quotation Mark
    $trans[chr(146)] = '&rsquo;';    // Right Single Quotation Mark
    $trans[chr(147)] = '&ldquo;';    // Left Double Quotation Mark
    $trans[chr(148)] = '&rdquo;';    // Right Double Quotation Mark
    $trans[chr(149)] = '&bull;';    // Bullet
    $trans[chr(150)] = '&ndash;';    // En Dash
    $trans[chr(151)] = '&mdash;';    // Em Dash
    $trans[chr(152)] = '&tilde;';    // Small Tilde
    $trans[chr(153)] = '&trade;';    // Trade Mark Sign
    $trans[chr(154)] = '&scaron;';    // Latin Small Letter S With Caron
    $trans[chr(155)] = '&rsaquo;';    // Single Right-Pointing Angle Quotation Mark
    $trans[chr(156)] = '&oelig;';    // Latin Small Ligature OE
    $trans[chr(159)] = '&Yuml;';    // Latin Capital Letter Y With Diaeresis
    $trans['euro'] = '&euro;';    // euro currency symbol
    ksort($trans);
    foreach ($trans as $k => $v) {
        $text = str_replace($v, $k, $text);
    }
    $text = strip_tags($text);
    $text = html_entity_decode($text);
    $text = preg_replace('/[^(\x20-\x7F)]*/','', $text);
    $targets=array('\r\n','\n','\r','\t');
    $results=array(" "," "," ","");
    $text = str_replace($targets,$results,$text);
    return ($text);
}
function startsWith($haystack, $needle) {
    // search backwards starting from haystack length characters from the end
    return $needle === "" || strrpos($haystack, $needle, -strlen($haystack)) !== FALSE;
}
function endsWith($haystack, $needle) {
    // search forward starting from end minus needle length characters
    return $needle === "" || strpos($haystack, $needle, strlen($haystack) - strlen($needle)) !== FALSE;
}


function hex2rgb($hex) {
    $hex = str_replace("#", "", $hex);

    if(strlen($hex) == 3) {
        $r = hexdec(substr($hex,0,1).substr($hex,0,1));
        $g = hexdec(substr($hex,1,1).substr($hex,1,1));
        $b = hexdec(substr($hex,2,1).substr($hex,2,1));
    } else {
        $r = hexdec(substr($hex,0,2));
        $g = hexdec(substr($hex,2,2));
        $b = hexdec(substr($hex,4,2));
    }
    $rgb = array($r, $g, $b);
    //return implode(",", $rgb); // returns the rgb values separated by commas
    return $rgb; // returns an array with the rgb values
}

function rgb2hex($rgb) {
    $hex = "#";
    $hex .= str_pad(dechex($rgb[0]), 2, "0", STR_PAD_LEFT);
    $hex .= str_pad(dechex($rgb[1]), 2, "0", STR_PAD_LEFT);
    $hex .= str_pad(dechex($rgb[2]), 2, "0", STR_PAD_LEFT);

    return $hex; // returns the hex value including the number sign (#)
}