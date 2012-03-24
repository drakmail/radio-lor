<?php
function get_song() {
/**
* ICECAST - A Joomla internet radio module
* @version 1.0.4
* @package mod_icecast.zip
* @copyright (C)2009 by Gronpipmaster
*/
// Защита от прямой записи

// Настройки модуля
$servername = "127.0.0.1";
$serverhost = "127.0.0.1";
$serverport = "8000";
$serverpoint = "mpd.mp3";
$serverpointtip = "m3u";
$bitrate = "128";
$fake = "fake";
$nowork = "nowork";

$ip = "$serverhost";
$port = "$serverport";
$ice2_station = "$servername";
if (ini_get('display_errors') == 1) ini_set('display_errors', 0);

$fp = fsockopen("$ip", $port, $errno, $errstr, 30); //открываем подключение
if(!$fp) {
        $success=2;  //Значение если нету подключения
        echo 'err';
}

if($success!=2){ //if connection
 fputs($fp,"GET /status2.xsl?mount=/$serverpoint HTTP/1.0\r\nUser-Agent: Icecast2 XSL Parser (Mozilla Compatible)\r\n\r\n"); //get status2.xsl
 while(!feof($fp)) {
  $page .= fgets($fp, 1000);
 }
 fclose($fp); //close connection
 $page = ereg_replace(".*<pre>", "", $page); //extract data
 $page = ereg_replace("</pre>.*", ",", $page); //extract data
 $numbers = explode(",",$page); //начала проверки пунктов
 $mount = $numbers[0];
 $connections = $numbers[1];
 $stream_n = $numbers[2];
 $listeners = $numbers[3];
 $desc = $numbers[4];
 $cur_song = $numbers[5];
 $str_url = $numbers[6];
 $client_info = $numbers[7];
 $test1 = $numbers[8];   //Не понял что это
 $mount = $numbers[11];
 $connections = $numbers[12];
 $station =$numbers[13];
 $listeners = $numbers[14];
 $description = $numbers[15];
 $cur_song = $numbers[16];
 $www_url  = $numbers[17];
 $listfake = $listeners + $fake;
 $base_url = JPATH_SITE;
 if (strlen($mount)<2) echo 'error icecast'; // не работает, но сервер запущен
    else echo "Играет: <strong>$cur_song</strong>";
} //сервер запущен и радио работает
}
?>

