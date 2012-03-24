var message_input = $('#message');
var latest_time = 0;
var messages_count = 0;

// add lead zero
function format_time(time) {
  time = time + "";
  if (time.length == 1) {time = "0" + time;}
  return time;
}

// clear oldest message
function clear_message() {
  $(".messages").children("div:first").remove();
}

// add message to chat
function add_message(text,date,identicon) {
  messages_count += 1;
  if (messages_count > 10) clear_message();
  var date = new Date(date*1000);
  $('.messages').append('<div><b>['+format_time(date.getHours())+':'+format_time(date.getMinutes())+']</b> <img src="/avatar/15/'+identicon+'/" width="15px" height="15px"> '+text+'</div>');
}
  
// send message to server
function send_message() {
    $.post('chat.php?action=push', {msg: message_input.val()}, function(data) {
      if (data == "ERR:0") alert("Слишком быстро");
      if (data == "ERR:1") alert("Слишком короткий текст сообщения");
      if (data == "ERR:2") alert("Слишком Длинный текст сообщения");
      if (data == "ERR:3") alert("ERR");
      if (data == "OK") message_input.val("");
    });
}
  
// get new messages
function poll(timeout) {
  $.ajax({ url: "chat.php?action=pull&date="+latest_time, success: function(data){
    for (var i =0; i<data.length; i++) {
      add_message(data[i].msg,data[i].date,data[i].hash);
      latest_time = data[i].date;
    }
    $(".messages").scrollTop($(".messages")[0].scrollHeight);
    if (timeout === true) setTimeout(function() {poll(true)},500);
  }, dataType: "json" });
}


$(document).ready(function() {
  $(".messages").html('');
  poll(true);
  $("#submit").click(function() { send_message(); });
  $("#message").keydown(function(e){
	  if (e.keyCode == 13) {
		  send_message();
	  }
  });
  
});
