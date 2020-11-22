<?php
session_start();
if(isset($_POST['reset'])){
	$_SESSION['chats'] = array();
	header("Location:index.php");
	return;
}
if (isset($_POST['msg'])) {
	if (!isset($_SESSION['chats'])) {
		$_SESSION['chats']=array();
	}
	$_SESSION['chats'][] = array($_POST['msg'], date(DATE_RFC2822)); 
	header("Location:index.php");
	return;
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>chat</title>
</head>
<body>
<form method="post" action="index.php">
<p>
	<input type="text" name="msg" size="60">
	<input type="submit" value="chat">
	<input type="submit" name="reset" value="reset">
</p>
</form>
<div id="chatmsg">
	
</div>
<script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
<script type="text/javascript">
	function updateMsg(){
		window.console && console.log('requesting');
		$.getJSON('chats.php', function(row){
			window.console && console.log('recieved');
			window.console && console.log(row);
			$('#chatmsg').empty();
			for(var i=0;i < row.length; i++){
				entry=row[i];
				$('#chatmsg').append('<p>'+entry[0]+'<br/>&nbsp;&nbsp;'+entry[1]+"</p>\n");
			}
			setTimeout('updateMsg()',4000);
		});
	}

	$(document).ready(function(){
		$.ajaxSetup({cache:false});
		updateMsg();
	});
</script>
</body>
</html>