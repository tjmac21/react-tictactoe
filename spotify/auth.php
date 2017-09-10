<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
</head>
<body>
<?php
$CLIENT_ID = 'dda21b3d6d08465dbb011c0611086681';
$CLIENT_SECRET = 'dae6392f4f7a4707b7450156dfbf317c';
$REDIRECT_URI = 'http://www.tjmacu.com/working/spotify/auth.php';
$ACCESS_TOKEN = '';
$REFRESH_TOKEN = '';
echo '<a href="https://accounts.spotify.com/authorize/?client_id='.$CLIENT_ID.'&response_type=code&redirect_uri='.$REDIRECT_URI.'&scope=user-read-private+user-read-email+user-read-currently-playing+user-read-playback-state&state=34fFs29kd09">Press Here for New Token</a>';

if (isset($_GET["code"])){ //only executes if code parameter exists
	$params = ['client_id'=>$CLIENT_ID,
				'client_secret'=>$CLIENT_SECRET,
				'redirect_uri'=>$REDIRECT_URI,
				'grant_type'=>'authorization_code',
	'code'=>$_GET['code']];

	$url='https://accounts.spotify.com/api/token';
	$ch = curl_init();

	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($params));

	$response  = curl_exec($ch);
	$auth_data = json_decode($response,true);
	curl_close($ch);
	
	if(!array_key_exists('error', $auth_data)) {
		//key !exists, do stuff
		//echo '<br><br><br>'.$response;
		//echo '<br><br><br>Access Token: '.$auth_data['access_token'];
		$ACCESS_TOKEN = $auth_data['access_token'];
		//echo '<br>';
		//echo '<br>Refresh Token: '.$auth_data['refresh_token'];
		$REFRESH_TOKEN = $auth_data['refresh_token'];
		//echo '<br>';
		echo '<br>Expires In: <span id="expireTime">' . ($auth_data['expires_in'])/60 . ':00</span>minutes<br>';
	} else {
		echo '<br><br>Errror in retrieving code: '.$auth_data['error_description'];
	}
} 

// Get current playing song
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, "https://api.spotify.com/v1/me/player/currently-playing");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");


$headers = array();
$headers[] = "Authorization: Bearer ".$ACCESS_TOKEN;
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$result = curl_exec($ch);
$result_json = json_decode($result,true);
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
}
curl_close ($ch);

if(!array_key_exists('error', $result_json)) {
	echo $result;
} else {
	echo '<br><br>Spotify API error code: <span id="errorCode"></span>';
	echo '<br>Spotify API error message: <spna id="errorMessage"></span>';
}
?>
<script>
function startTimer(duration, display) {
	var interval = 1000;
	
    var timer = duration, minutes, seconds;
    var timing = setInterval(function () {
        minutes = parseInt(timer / 60, 10)
        seconds = parseInt(timer % 60, 10);

        minutes = minutes < 10 ? "0" + minutes : minutes;
        seconds = seconds < 10 ? "0" + seconds : seconds;

        if (--timer < 0) {
            display.innerHTML = '[EXPIRED]';
        } else {
			display.innerHTML=minutes + ":" + seconds;
		}
    }, interval);
	
	<?php 
	if(array_key_exists('error', $result_json)) {
	?>clearInterval(timing);
	<?php
	}
	?>
}
    var expireMinutes = 60 * <?php 
	if(!array_key_exists('error', $result_json)) {
		echo ($auth_data['expires_in'])/60; 
	} else {
		echo '0;';
		?>
		$('#errorCode').html(<?php echo $result ?>.error.status);
		$('#errorMessage').html(<?php echo $result ?>.error.message);
		<?php
	}
	?>;
    var display = document.getElementById('expireTime');
    startTimer(expireMinutes, display);
	console.log(<?php echo $result; ?>)
</script>
</body>
</html>