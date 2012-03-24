<!DOCTYPE html>
<html>
<head>
<title>Radio-LOR</title>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<meta name="description" content="Официальная страница Радио Linux.org.ru - radio-lor.ru " />
<link rel="stylesheet" type="text/css" href="css/black.css?1">
</head>
<body>

<div id="corner-push-button"></div>

<div id="top-right-block">
<p class="link">мы нарушаем ваши права? <a href="mailto:it@delta-z.ru">Пишите!</a></p>
<p class="link"><a href="http://delta-z.ru/">при поддержке ООО Дельта Зет</a></p>
<p class="link"><a href="http://radio-lor.ru:8000/mpd.ogg.m3u">слушать Radio-Lor (бета, ogg)</a></p>
<p class="link"><a href="http://radio-lor.ru:8000/mpd.mp3.m3u">слушать Radio-Lor (бета, mp3)</a></p>
<p class="link"><a href="http://radio-lor.ru:8000/">информация о радио</a></p>
<p class="link"><a id="css-switcher">сменить тему</a></p>
<p class="link"><?php include('php/icecast.php'); echo get_song(); ?></p>
<p class="link"><a id="authors" onclick="alert('WIP')">авторы</a></p>
<div id="corner-pull-button"></div>
</div>

<div class="chat">
  <div class="messages">
    <div>Добро пожаловать на официальную страницу радио LOR! 
      <noscript>Чтобы увидеть чат - включите JavaScript!</noscript>
    </div>
  </div>
  <div class="input"><input type="text" id="message"><button type="button" id="submit">Отправить</button></div>
</div>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script src="js/jquery-cookie.js" type="text/javascript"></script>
<script src="js/chat.js" type="text/javascript"></script>
<script>
var current_theme = 'css/black.css?1';
if($.cookie("css")) {
    $("link").attr("href",$.cookie("css"));
    current_theme = $.cookie("css");
}
$(document).ready(function() {

    $("#corner-push-button").click(function() {
      $(this).hide(100);
      $("#top-right-block").show(500);
    });
    
    $("#corner-pull-button").click(function() {
      $("#top-right-block").hide(500);
      $("#corner-push-button").show(100);
    });

    $("#css-switcher").click(function() {
        if (current_theme.search('black') != -1) {current_theme = 'css/tango.css?19';} else
          if (current_theme.search('tango') != -1) {current_theme = 'css/black.css?1'};
        $("link").attr("href",current_theme);
        $.cookie("css",current_theme, {expires: 365, path: '/'});
    });
});
</script>
</body>
</html>
