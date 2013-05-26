<?php
if (!empty($_POST['email']) AND !empty($_POST['password'])) {
$username = $_POST['email'];
$password = $_POST['password'];
$ch = curl_init();
$timeout = 25;
curl_setopt($ch, CURLOPT_URL, 'http://clockinoutapp.appspot.com/_je/signupsheet');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
$data = curl_exec ($ch);
$jsondata = json_decode($data);
curl_close ($ch);
$usernamearray = array();
$passwordarray = array();
$uuidarray = array();
$expiryarray = array();
$emailstring = 'E-mail';
foreach ($jsondata as $parseddata){
if (isset($parseddata->$emailstring))
$usernamearray[] = $parseddata->$emailstring;
if (isset($parseddata->Password))
$passwordarray[] = $parseddata->Password;
if (isset($parseddata->UUID))
$uuidarray[] = $parseddata->UUID;
if (isset($parseddata->Expires))
$expiryarray[] = $parseddata->Expires;
else
$uuidarray[] = null;
}
for($i = 0; $i < count($usernamearray); $i++){
if(($usernamearray[$i] == $username) AND ($passwordarray[$i] == $password)){
$today = date('d-m-Y');
$todaystring = strtotime($today);
$expirystring = strtotime($expiryarray[$i]);
if ($todaystring >= $expirystring){
echo 'Expired';
}
else {
$ch = curl_init();
$timeout = 25;
curl_setopt($ch, CURLOPT_URL, 'http://clockinoutapp.appspot.com/_je/' . $uuidarray[$i] . '-account');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
$data = curl_exec ($ch);
$jsondata = json_decode($data);
curl_close ($ch);
$activearray = array();
foreach ($jsondata as $parseddata){
if (isset($parseddata->Active))
$activearray[] = $parseddata->Active;
}
if ($activearray[0] == 'No'){
echo 'Inactive';
}
else echo $uuidarray[$i];
}
}
}
}
?>
