<?php
if (!empty($_GET['accountid'])) {
ini_set('display_errors',0);
error_reporting(E_ALL | E_STRICT);
$accountid = $_GET['accountid'];
$ch = curl_init();
$timeout = 25;
curl_setopt($ch, CURLOPT_URL, 'http://clockinoutapp.appspot.com/_je/' . $accountid . '-account');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
$data = curl_exec ($ch);
$jsondata = json_decode($data);
curl_close ($ch);
$docid = array();
$checkexpired = array();
$docidstring = '_docId';
$activestring = 'Active';
$emailstring = 'E-mail';
$emailarray = array();
foreach ($jsondata as $parseddata){
if (isset($parseddata->$activestring))
$checkexpired[] = $parseddata->$activestring;
if (isset($parseddata->$docidstring))
$docid[] = $parseddata->$docidstring;
if (isset($parseddata->$emailstring))
$emailarray[] = $parseddata->$emailstring;
}
$email = $emailarray[0];
if ($checkexpired[0] == 'Expired'){
echo 'Your account has expired';
}
else {
$accountarr = array('Active' => 'Yes');
$chcreateaccountdetails = curl_init();
curl_setopt($chcreateaccountdetails, CURLOPT_URL, 'http://clockinoutapp.appspot.com/_je/' . $accountid . '-account/' . $docid[0] . '?_doc=' . urlencode(json_encode($accountarr)));
curl_setopt($chcreateaccountdetails, CURLOPT_HTTPHEADER, array('Accept: application/json', 'Content type: application/json; charset=UTF-8'));
curl_setopt($chcreateaccountdetails, CURLOPT_HEADER, 1);
curl_setopt($chcreateaccountdetails, CURLOPT_POST, 1);
curl_setopt($chcreateaccountdetails, CURLOPT_POSTFIELDS, 1);
curl_setopt($chcreateaccountdetails, CURLOPT_RETURNTRANSFER, 1);
curl_exec($chcreateaccountdetails);
curl_close($chcreateaccountdetails);
echo 'Thank you, your account is now active. Please check your e-mails';
require_once "Mail.php";
$from = "james@heyjimmy.net";
        $to = $email;
        $subject = "Team Sheet from Hey Jimmy";
        $body = 'Thank you for activating Team Sheet!

The following link will let you sign in with your username and password - http://heyjimmy.net/signin

If you have any questions or feedback then please e-mail me and I\'ll be happy to help.

-- 
Thanks
James Guthrie
Founder - Hey Jimmy Ltd.

Web - heyjimmy.net
Twitter - @HeyJimmyUK
Skype - jamesjguthrie

Registered in Scotland - SC435825';

        $host = "ssl://smtp.gmail.com";
        $port = "465";
        $username = "YOUREMAIL";  //<> give errors
        $password = "YOURPASSWORD";
	$headers = array ('From' => $from,
          'To' => $to,
          'Subject' => $subject);
        $smtp = Mail::factory('smtp',
          array ('host' => $host,
            'port' => $port,
            'auth' => true,
            'username' => $username,
            'password' => $password));

        $mail = $smtp->send($to, $headers, $body);

        if (PEAR::isError($mail)) {
          echo("<p>" . $mail->getMessage() . "</p>");
}
}
}
?>
