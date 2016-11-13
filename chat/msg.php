<?php
session_start();
header("Content-type: application/javascript");
?>

var msginput = document.getElementById("msginput");
var msgarea = document.getElementById("msg-area");

function chooseusername() {
var user = document.getElementById("cusername").value;
document.cookie="messengerUname=" + user
checkcookie()
}

function showlogin() {
document.getElementById("whitebg").style.display = "inline-block";
document.getElementById("loginbox").style.display = "inline-block";
}

function hideLogin() {
document.getElementById("whitebg").style.display = "none";
document.getElementById("loginbox").style.display = "none";
}

function checkcookie() {
if (document.cookie.indexOf("messengerUname") == -1) {
showlogin();
} else {
hideLogin();
}
}

function getcookie(cname) {
var name = cname + "=";
var ca = document.cookie.split(';');
for(var i=0; i<ca.length; i++) {
var c = ca[i];
while (c.charAt(0)==' ') c = c.substring(1);
if (c.indexOf(name) == 0) return c.substring(name.length,c.length);
}
return "";
}

function escapehtml(text) {
return text.replace(/&/g, "&amp;")
.replace(/</g, "&lt;")
.replace(/>/g, "&gt;")
.replace(/"/g, "&quot;")
.replace(/'/g, "&#039;");
}

function update() {
var xmlhttp=new XMLHttpRequest();
var username = <?php echo '"'.$_SESSION["username"].'"'?>//getcookie("messengerUname");
var output = '';
xmlhttp.onreadystatechange=function() {
if (xmlhttp.readyState==4 && xmlhttp.status==200) {
var response = xmlhttp.responseText.split("\n")
var rl = response.length
var item = "";
for (var i = 0; i < rl; i++) {
item = response[i].split("\\")
if (item[1] != undefined) {
if (item[0] == username) {
output += "<div class=\"msgc\" style=\"margin-bottom: 30px;\"> <div class=\"msg msgfrom\">" + item[1] + "</div> <div class=\"msgarr msgarrfrom\"></div> <div class=\"msgsentby msgsentbyfrom\">Sent by " + item[0] + "</div> </div>";
} else {
output += "<div class=\"msgc\"> <div class=\"msg\">" + item[1] + "</div> <div class=\"msgarr\"></div> <div class=\"msgsentby\">Sent by " + item[0] + "</div> </div>";
}
}
}

msgarea.innerHTML = output;
msgarea.scrollTop = msgarea.scrollHeight;

}
}
xmlhttp.open("GET","get-messages.php?username=" + username,true);
xmlhttp.send();
}

function sendmsg() {

var message = msginput.value;
if (message != "") {
// alert(msgarea.innerHTML)
// alert(getcookie("messengerUname"))

var username = <?php echo '"'.$_SESSION["username"].'"'?>//getcookie("messengerUname");

var xmlhttp=new XMLHttpRequest();

xmlhttp.onreadystatechange=function() {
if (xmlhttp.readyState==4 && xmlhttp.status==200) {
message = escapehtml(message)
msgarea.innerHTML += "<div class=\"msgc\" style=\"margin-bottom: 30px;\"> <div class=\"msg msgfrom\">" + message + "</div> <div class=\"msgarr msgarrfrom\"></div> <div class=\"msgsentby msgsentbyfrom\">Sent by " + username + "</div> </div>";
msginput.value = "";
}
}
xmlhttp.open("GET","update-messages.php?username=" + username + "&message=" + message,true);
xmlhttp.send();
}

}

setInterval(function(){ update() }, 2500);