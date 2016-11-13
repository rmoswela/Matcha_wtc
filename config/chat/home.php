
<?php

session_start();


if( !isset($_SESSION['user_id']) ){
	header("Location: index.php");
}

require ('get-messages.php');

?>

<html>
<head>
	<title>Messenger</title>
	<style type="text/css">
		html {
			height: 100%;
		}
		body {
			margin: 0px;
			padding: 0px;
			height: 100%;
			font-family: Helvetica, Arial, Sans-serif;
			font-size: 14px;
		}
		.msg-container {
			width: 100%;
			height: 100%;
		}
		.header {
			width: 100%;
			height: 30px;
			border-bottom: 1px solid #CCC;
			text-align: center;
			padding: 15px 0px 5px;
			font-size: 20px;
			font-weight: normal;
		}
		.msg-area {
			height: calc(100% - 102px);
			width: 100%;
			background-color:#FFF;
			overflow-y: scroll;
		}
		.msginput {
			padding: 5px;
			margin: 10px;
			font-size: 14px;
			width: calc(100% - 20px);
			outline: none;
		}
		.bottom {
			width: 100%;
			height: 50px;
			position: fixed;
			bottom: 0px;
			border-top: 1px solid #CCC;
			background-color: #EBEBEB;
		}
		#whitebg {
			width: 100%;
			height: 100%;
			background-color: #FFF;
			overflow-y: scroll;
			opacity: 0.6;
			display: none;
			position: absolute;
			top: 0px;
			z-index: 1000;
		}
		#loginbox {
			width: 600px;
			height: 350px;
			border: 1px solid #CCC;
			background-color: #FFF;
			position: fixed;
			top: 50%;
			left: 50%;
			transform: translate(-50%, -50%);
			z-index: 1001;
			display: none;
		}
		h1 {
			padding: 0px;
			margin: 20px 0px 0px 0px;
			text-align: center;
			font-weight: normal;
		}
		button {
			background-color: #43ACEC;
			border: none;
			color: #FFF;
			font-size: 16px;
			margin: 0px auto;
			width: 150px;
		}
		.buttonp {
			width: 150px;
			margin: 0px auto;
		}

		.msg {
			margin: 10px 10px;
			background-color: #f1f0f0;
			max-width: calc(45% - 20px);
			color: #000;
			padding: 10px;
			font-size: 14px;
		}
		.msgfrom {
			background-color: #0084ff;
			color: #FFF;
			margin: 10px 10px 10px 55%;
		}
		.msgarr {
			width: 0;
			height: 0;
			border-left: 8px solid transparent;
			border-right: 8px solid transparent;
			border-bottom: 8px solid #f1f0f0;
			transform: rotate(315deg);
			margin: -12px 0px 0px 45px;
		}
		.msgarrfrom {
			border-bottom: 8px solid #0084ff;
			float: right;
			margin-right: 45px;
		}
		.msgsentby {
			color: #8C8C8C;
			font-size: 12px;
			margin: 4px 0px 0px 10px;
		}
		.msgsentbyfrom {
			float: right;
			margin-right: 12px;
		}
	</style>
</head>
<body>
<div id="whitebg"></div>
<div class="msg-container">
	<div class="header">Chat</div>
	<?php



		 $html = "";

			  foreach ($array as $key)
   		 {

   		 	   	$sql_username = $conn->query("
				SELECT username, id FROM users_tbl WHERE '$key' = id");
    					$user_name = $sql_username->fetch();

   		 		$friend = $user_name["username"];

			  $html .= "<input id='friend' name='friend' type=\"radio\" value=\"$friend\">$friend</input>";
			}
			echo $html;
	?>
	<div class="msg-area" id="msg-area"></div>
	<div class="bottom"><input type="text" name="msginput" class="msginput" id="msginput" onkeydown="if (event.keyCode == 13) sendmsg()" value="" placeholder="Enter your message here ... (Press enter to send message)"></div>
</div>
</body>
<script type="text/javascript" src="msg.php"></script>