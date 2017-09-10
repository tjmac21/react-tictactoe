<?php
$params = ['client_id'=>'dda21b3d6d08465dbb011c0611086681',
			'client_secret'=>'dae6392f4f7a4707b7450156dfbf317c',
			'redirect_uri'=>'http://www.tjmacu.com/working/spotify/',
			'grant_type'=>'authorization_code',
'code'=>'AQCC_QJ7r6oItbp2H8Xfg0qvcb-6WBUeyj1JLmPKyApzS_22XuLXsLothOOUVNroneE91JP32CRt_BtpyHcqIq_QampHlkBx5POOOAhGgM1-jlHcL29W0kXdq06KgiJXCBF45w3gSWHa9gPZJBvHFeoJrjjriSMG-7vucZfkwrnLuCc4sXRyjKldpiaiaY8Q4V-7gZib_x7wPrISDMuu9NJT-HCXp_GAgrCbHWkU7DE1vgfzyHMbuqiIlCnHeKqZ'];

$url='https://accounts.spotify.com/api/token';
$headers = array(
	'Accept: applicaton/json',
	'Content-Type: application/json',);
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($params));
//curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
//curl_setopt($ch,CURLOPT_HEADER,0);
//curl_setopt($ch, CURLOPT_POST, 1);

$response  = curl_exec($ch);
curl_close($ch);
echo $response;


?>

