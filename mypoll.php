<html>
<head><meta charset = "UTF-8"></head>
<body>
<?php
$action = $_SERVER['PHP_SELF'];

$showPolling = "<h3>آیا از این وبسایت رضایت دارید؟</h3>
<form action = '$action' method = 'post'>
YES : <input type = 'radio' name = 'vote' value = '0'>
NO : <input type = 'radio' name = 'vote' value = '1'>
<input type = 'submit'>
</form>";
?>

<div id = "showPlace">
<?php
if($_SERVER['REQUEST_METHOD'] == "POST"){
	if(isset($_POST['vote'])){
		$vote = $_POST['vote'];
	}
	else{
		$vote = "";
	}
	if(!isset($_COOKIE['mypoll'])){
		setcookie('mypoll','1',time()+24*60*60);
		
		$myfile = fopen("poll.txt", "r") or die("Unable to open file!");
		$content = fread($myfile,filesize("poll.txt"));
		$arr = explode("/",$content);
		$yes = $arr[0];
		$no = $arr[1];
		if($vote == 0){
			$yes++;
		}
		elseif($vote == 1){
			$no++;
		}
		fclose($myfile);
		$myfile = fopen("poll.txt", "w") or die("Unable to open file!");
		fwrite($myfile,"$yes/$no");
		fclose($myfile);
		showResult();
		showResult();
	}
}
function showResult(){
	$myfile = fopen("poll.txt", "r") or die("Unable to open file!");
	$content = fread($myfile,filesize("poll.txt"));
	$arr = explode("/",$content);
	$yes = $arr[0];
	$no = $arr[1];
	fclose($myfile);
	$yespercent = round($yes/($yes+$no)*100);
	$nopercent = round($no/($yes+$no)*100);
	$result = "YES: <img src = 'poll.png' width=$yespercent height='10px'>$yespercent%";
	$result .= "<br>NO :  <img src = 'poll.png' width=$nopercent height='10px'>$nopercent%";
	return $result;
}

if(isset($_COOKIE['mypoll'])){
	echo showResult();
}
else{
	echo $showPolling;
}	

?>
</div>

</body>
</html>