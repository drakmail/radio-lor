<?php

require_once("php/rb.php"); // RedBean ORM
R::setup("mysql:host=localhost;dbname=DATABASE_NAME","USERNAME","PASSWORD");

function str_word_count_utf8($str) {
  return count(preg_split('~[^\p{L}\p{N}\']+~u',$str));
}

// check message and ip for spam/etc
function check_message($msg,$ip) {
  if (strlen($msg) < 1) return "ERR:1";
  if (strlen($msg) > 70) return "ERR:2";
  if (strpos($msg,"http://") !== false) return "ERR:3";
  
  $last_msg = R::findOne("messages"," ip = ? ORDER BY id DESC ", array($_SERVER["REMOTE_ADDR"]));
  if ( (time()-$last_msg->date) < 5 ) return "ERR:0";
  
  return "OK";
}

if ($_GET["action"] == "push") { // new message
  $message = $_POST["msg"];
  $ip = $_SERVER["REMOTE_ADDR"];
  $status = check_message($message,$ip);
  if ($status == "OK") {
        $msg = R::dispense("messages");
        $msg->ip = $ip;
        $msg->message = htmlspecialchars($message);
        $msg->date = time();
        R::store($msg);
  }
  echo $status;
}

if ($_GET["action"] == "pull") { // get history and/or new messages
  $date = $_GET['date'];
  $result = array();
  $messages = R::find('messages',' date > ? ORDER BY date DESC LIMIT 10', array($date));
  foreach ($messages as $message) {
    $result[] = array("date"=>$message->date,"msg"=>stripslashes($message->message),"hash"=>md5($message->ip));
  }
  sort($result);
  echo json_encode($result);
}

?>
