<?php session_start();
$inactive = 600;
// check to see if $_SESSION['timeout'] is set
if(isset($_SESSION['timeout']) ) {
	$session_life = time() - $_SESSION['timeout'];
	if($session_life > $inactive)
        { session_destroy(); header("Location: ../signin/"); }
}
$_SESSION['timeout'] = time(); ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Hey Jimmy Ltd.</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Easy to use Employee Scheduling Software & Staff Management Software with integrated Time Clocking, Reporting, & Communication" />
		<meta name="keywords" content="employee scheduling software, staff management software, Online Employee Scheduling application, time clocking, online punch clock, online payroll, human resource, hr resources, payroll software, employee schedule management, employee scheduling software, hr software" />
		<meta name="author" content="Hey Jimmy Ltd." />

    <!-- Le styles -->
    <link href="../../css/bootstrap.css" rel="stylesheet">
    <style type="text/css">
      body {
        padding-top: 60px;
        padding-bottom: 40px;
      }
      .sidebar-nav {
        padding: 9px 0;
      }
    </style>
    <link href="../../css/bootstrap-responsive.css" rel="stylesheet">

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script 

src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Fav and touch icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" 

href="../img/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" 

href="../img/apple-touch-icon-114-precomposed.png">
      <link rel="apple-touch-icon-precomposed" sizes="72x72" 

href="../img/apple-touch-icon-72-precomposed.png">
                    <link rel="apple-touch-icon-precomposed" 

href="../img/apple-touch-icon-57-precomposed.png">
                                   <link rel="shortcut icon" 

href="../favicon.png">
  </head>

  <body>
<?php include_once("../analyticstracking.php") ?>

    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <a class="btn btn-navbar" data-toggle="collapse" data-

target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <a class="brand"><img src="../../img/smalllogo.png"></img></a>
          <div class="nav-collapse collapse">
            <ul class="nav">
              <li class="active"><a>Home</a></li>
              <li><a href="http://www.crunchbase.com/company/hey-jimmy" 

target="_blank">About</a></li>
              <li><a href="https://twitter.com/HeyJimmyUK" 

target="_blank">Twitter</a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>

    <div class="container-fluid">
      <div class="row-fluid">
        <div class="span3">
          <div class="well sidebar-nav">
            <ul class="nav nav-list">
              <li class="nav-header">Team Sheet</li>
              <li><a href="../team/">Team Members</a></li>
	<li><a href="../timekeeping/">Team Timekeeping</a></li>
<li class="active"><b>Team Noticeboard</b></li>
              <li class="nav-header">Account</li>
		<li><a href="../account/">Account Settings</a></li>
              <li><a href="../signout/">Sign Out</a></li>
            </ul>
          </div><!--/.well -->
        </div><!--/span-->
        <div class="span9">
<div class="container-fluid">
<div class="well">
<?php
if (isset($_POST['savechanges'])){
function deletedata(){
$chdelete = curl_init();
curl_setopt($chdelete, CURLOPT_URL, 'http://clockinoutapp.appspot.com/_je/'.$_SESSION['accountid'].'-messages');
curl_setopt($chdelete, CURLOPT_CUSTOMREQUEST, 'DELETE');
curl_exec($chdelete);
curl_close($chdelete);
sleep(2);
}
function savedata(){
$count = count($_SESSION['messagesinsession']);
unset($_SESSION['messagesinsession']);
unset($_SESSION['dates']);
for ($i = 0; $i < $count; $i++){
$_SESSION['messagesinsession'][$i] = $_POST['messages'.$i.''];
$_SESSION['dates'][$i] = $_POST['date'.$i.''];
$jsonstring = array('Message' => $_POST['messages'.$i.''], 'Date' => $_POST['date'.$i.'']); 
$chsavenew = curl_init();
curl_setopt($chsavenew, CURLOPT_URL, 'http://clockinoutapp.appspot.com/_je/' . $_SESSION['accountid'] . '-messages?_doc=' . urlencode(json_encode($jsonstring)));
curl_setopt($chsavenew, CURLOPT_HTTPHEADER, array('Accept: application/json', 'Content type: application/json; charset=UTF-8'));
curl_setopt($chsavenew, CURLOPT_HEADER, 1);
curl_setopt($chsavenew, CURLOPT_POST, 1);
curl_setopt($chsavenew, CURLOPT_POSTFIELDS, 1);
curl_setopt($chsavenew, CURLOPT_RETURNTRANSFER, 1);
curl_exec($chsavenew);
curl_close($chsavenew);
sleep(2);
}
}
function checkdata(){
$timeout = 25;
$chcheck = curl_init('http://clockinoutapp.appspot.com/_je/'.$_SESSION['accountid'].'-messages');
curl_setopt($chcheck, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($chcheck, CURLOPT_CONNECTTIMEOUT, $timeout);
$datacheck = curl_exec($chcheck);
curl_close($chcheck);
$jsondatacheck = json_decode($datacheck);
$messagecheck = array();
$messagestring = 'Message';
foreach ($jsondatacheck as $parseddatacheck){
if (isset($parseddatacheck->$messagestring))
$messagecheck[] = $parseddatacheck->$messagestring;
}
if (count($messagecheck) != count($_SESSION['messagesinsession']))
{
deletedata();
savedata();
checkdata();
}
}
deletedata();
savedata();
checkdata();
}
if (!isset($_SESSION['messagesinsession'])){
$timeout = 30;
$ch2 = curl_init('http://clockinoutapp.appspot.com/_je/'  .$_SESSION['accountid'].'-messages?sort=Message.asc');
curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch2, CURLOPT_CONNECTTIMEOUT, $timeout);
$messages = 'Message';
$datestring = 'Date';
$data2 = curl_exec($ch2);
$jsondata2 = json_decode($data2);
curl_close($ch2);
$messagearray = array();
$datearray = array();
foreach ($jsondata2 as $parseddata2){
if (isset($parseddata2->$messages))
$messagearray[] = $parseddata2->$messages;
if (isset($parseddata2->$datestring))
$datearray[] = $parseddata2->$datestring;
}
$_SESSION['messagesinsession'] = $messagearray;
$_SESSION['dates'] = $datearray;
}
else {
foreach($_SESSION['messagesinsession'] as $key=>$value){
$messagearray[$key] = $value;
}
foreach($_SESSION['dates'] as $key=>$value){
$datearray[$key] = $value;
}
}
if (isset($_POST['addnotice'])){
$messagearray[] = 'New notice';
$_SESSION['messagesinsession'] = $messagearray;
$datearray[] = date('d/m/y');
$_SESSION['dates'] = $datearray;
}
for ($i = 0; $i < count($messagearray); $i++){
if (isset($_POST['removenotice'.$i.''])){
unset($messagearray[$i]);
$messagearray = array_values($messagearray);
$_SESSION['messagesinsession'] = $messagearray;
unset($datearray[$i]);
$datearray = array_values($datearray);
$_SESSION['dates'] = $datearray;
}
}
echo '<table class="table"><thead><tr><td>Team Noticeboard</td></tr></thead><tbody>
<form class="form" name="notices" method="post" action=".">
<fieldset>';
for($i = 0; $i < count($_SESSION['messagesinsession']); $i++){
if ($messagearray[$i] != '') {
echo '<tr><td>Notice</td><td><input type="text" class="input-xlarge" id="messages'.$i.'" name="messages'.$i.'" value="' . $_SESSION['messagesinsession'][$i] . '"><input type="hidden" id="date'.$i.'" name="date'.$i.'" value="' . $_SESSION['dates'][$i] . '"></td><td>'.$_SESSION['dates'][$i].'</td>
<td><button type="submit" class="btn btn-inverse" name="removenotice'.$i.'" value="removenotice'.$i.'">Remove</button></tr>';
}
}
echo '</body></table>
<table class="table">
<thead>
<tr><td><button type="submit" class="btn btn" name="savechanges" value="savechanges">Save changes</button>
</td><td>
<button type="submit" class="btn btn" name="addnotice" value="addnotice">Add notice</button>
</td></tr>
</thead>
</table>
</form>
Account ID: ' .$_SESSION['accountid']; 
?>
		</div> 
</div>       
        </div><!--/span-->
      </div><!--/row-->

      <hr>

      <footer>
        <p>&copy; Hey Jimmy Ltd. 2013 - Registered in Scotland, SC435825</p>
      </footer>
    </div><!--/.fluid-container-->

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
<script src="../../js/jquery.js"></script>
    <script src="../../js/bootstrap-transition.js"></script>
    <script src="../../js/bootstrap-alert.js"></script>
    <script src="../../js/bootstrap-modal.js"></script>
    <script src="../../js/bootstrap-dropdown.js"></script>
    <script src="../../js/bootstrap-scrollspy.js"></script>
    <script src="../../js/bootstrap-tab.js"></script>
    <script src="../../js/bootstrap-tooltip.js"></script>
    <script src="../../js/bootstrap-popover.js"></script>
    <script src="../../js/bootstrap-button.js"></script>
    <script src="../../js/bootstrap-collapse.js"></script>
    <script src="../../js/bootstrap-carousel.js"></script>
    <script src="../../js/bootstrap-typeahead.js"></script>

  </body>
</html>
