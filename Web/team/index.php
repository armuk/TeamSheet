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
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
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
              <li class="active"><b>Team Members</b></li>
	<li><a href="../timekeeping/">Team Timekeeping</a></li>
		<li><a href="../noticeboard/">Team Noticeboard</a></li>
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
if (!empty($_POST['email']) AND !empty($_POST['password'])) {
$username = $_POST['email'];
$password = hash('sha512', $_POST['password']);
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
$emailstring = 'E-mail';
foreach ($jsondata as $parseddata){
if (isset($parseddata->$emailstring))
$usernamearray[] = $parseddata->$emailstring;
if (isset($parseddata->Password))
$passwordarray[] = $parseddata->Password;
if (isset($parseddata->UUID))
$uuidarray[] = $parseddata->UUID;
else
$uuidarray[] = null;
}
$isitset = false;
for($i = 0; $i < count($usernamearray); $i++){
if(($usernamearray[$i] == $username) && ($passwordarray[$i] == $password)){
if (!isset($_SESSION['accountid']))
$_SESSION['accountid'] = $uuidarray[$i];
$isitset = true;
}
}
if (!$isitset) header("Location: ../signin/");
}
$timeout = 25;
$ch2 = curl_init('http://clockinoutapp.appspot.com/_je/'.$_SESSION['accountid'].'-team?sort=Name.asc');
curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch2, CURLOPT_CONNECTTIMEOUT, $timeout);
$signedin2 = 'Signed-in';
$data2 = curl_exec($ch2);
curl_close($ch2);
$jsondata2 = json_decode($data2);
$staffname = array();
$staffuserid = array();
$staffpin = array();
$namestring = 'Name';
$idstring = 'UserID';
$pinstring = 'PIN';
foreach ($jsondata2 as $parseddata2){
if (isset($parseddata2->$namestring))
$staffname[] = $parseddata2->$namestring;
if (isset($parseddata2->$idstring))
$staffuserid[] = $parseddata2->$idstring;
if (isset($parseddata2->$pinstring))
$staffpin[] = $parseddata2->$pinstring;
}
if (!isset($_SESSION['teamcountinsession'])){
$teamcount = count($staffname);
$_SESSION['teamcountinsession'] = $teamcount;
$_SESSION['staffnamesinsession'] = $staffname;
$_SESSION['staffuseridsinsession'] = $staffuserid;
$_SESSION['staffpinsinsession'] = $staffpin;
}
else
{
$teamcount = $_SESSION['teamcountinsession'];
foreach($_SESSION['staffnamesinsession'] as $key=>$value){
$staffname[$key] = $value;
}
foreach($_SESSION['staffuseridsinsession'] as $key=>$value){
$staffuserid[$key] = $value;
}
foreach($_SESSION['staffpinsinsession'] as $key=>$value){
$staffpin[$key] = $value;
}
}
if (isset($_POST['addstaff'])){
$teamcount++;
$_SESSION['teamcountinsession'] = $teamcount;
$staffname[] = 'New Staff Member';
$staffuserid[] = '0000';
$staffpin[] = '0000';
$_SESSION['staffnamesinsession'] = $staffname;
$_SESSION['staffuseridsinsession'] = $staffuserid;
$_SESSION['staffpinsinsession'] = $staffpin;
}
for ($i = 0; $i < count($staffname); $i++)
{
if (isset($_POST['removestaff'.$i.''])){
$teamcount--;
$_SESSION['teamcountinsession'] = $teamcount;
unset($staffname[$i]);
$staffname = array_values($staffname);
$_SESSION['staffnamesinsession'] = $staffname;
unset($staffuserid[$i]);
$staffuserid = array_values($staffuserid);
$_SESSION['staffuseridsinsession'] = $staffuserid;
unset($staffpin[$i]);
$staffpin = array_values($staffpin);
$_SESSION['staffpinsinsession'] = $staffpin;
}
}
if (isset($_POST['savechanges'])){
function deletedata(){
$chdelete = curl_init();
curl_setopt($chdelete, CURLOPT_URL, 'http://clockinoutapp.appspot.com/_je/'.$_SESSION['accountid'].'-team');
curl_setopt($chdelete, CURLOPT_CUSTOMREQUEST, 'DELETE');
curl_exec($chdelete);
curl_close($chdelete);
sleep(2);
}
function savedata(){
unset($GLOBALS['staffname']);
unset($GLOBALS['staffuserid']);
unset($GLOBALS['staffpin']);
unset($_SESSION['staffnamesinsession']);
unset($_SESSION['staffuseridsinsession']);
unset($_SESSION['staffpinsinsession']);
for ($i = 0; $i < $GLOBALS['teamcount']; $i++){
$GLOBALS['staffname'][$i] = $_POST['staffname'.$i.''];
$GLOBALS['staffuserid'][$i] = $_POST['staffuserid'.$i.''];
$GLOBALS['staffpin'][$i] = $_POST['staffpin'.$i.''];
$_SESSION['staffnamesinsession'][$i] = $GLOBALS['staffname'][$i];
$_SESSION['staffuseridsinsession'][$i] = $GLOBALS['staffuserid'][$i];
$_SESSION['staffpinsinsession'][$i] = $GLOBALS['staffpin'][$i];
$jsonstring = array('Name' => $_POST['staffname'.$i.''], 'UserID' => $_POST['staffuserid'.$i.''], 'PIN' => $_POST['staffpin'.$i.'']); 
$chsavenew = curl_init();
curl_setopt($chsavenew, CURLOPT_URL, 'http://clockinoutapp.appspot.com/_je/' . $_SESSION['accountid'] . '-team?_doc=' . urlencode(json_encode($jsonstring)));
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
$chcheck = curl_init('http://clockinoutapp.appspot.com/_je/'.$_SESSION['accountid'].'-team');
curl_setopt($chcheck, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($chcheck, CURLOPT_CONNECTTIMEOUT, $timeout);
$datacheck = curl_exec($chcheck);
curl_close($chcheck);
$jsondatacheck = json_decode($datacheck);
$staffnamecheck = array();
$namestring = 'Name';
foreach ($jsondatacheck as $parseddatacheck){
if (isset($parseddatacheck->$namestring))
$staffnamecheck[] = $parseddatacheck->$namestring;
}
if (count($staffnamecheck) != $_SESSION['teamcountinsession'])
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
echo '<table class="table table-condensed">
<thead>
<tr>
<td><b>'.$namestring.'</b></td>
<td><b>'.$idstring.'</b></td>
<td><b>'.$pinstring.'</b></td>
</tr>
</thead>
<tbody>
<form class="form" name="team" method="post" action=".">
<fieldset>';
function drawtable(){
for($i = 0; $i < $GLOBALS['teamcount']; $i++){
echo '<tr>
<td><input type="text" class="input-large" id="staffname'.$i.'" name="staffname'.$i.'" value="'.$_SESSION['staffnamesinsession'][$i].'"></td>
<td><input type="text" class="input-small" id="staffuserid'.$i.'" name="staffuserid'.$i.'" value="'.$_SESSION['staffuseridsinsession'][$i].'"></td>
<td><input type="text" class="input-small" id="staffpin'.$i.'" name="staffpin'.$i.'" value="'.$_SESSION['staffpinsinsession'][$i].'"></td>
<td>
<button type="submit" class="btn btn-inverse" name="removestaff'.$i.'" value="removestaff'.$i.'">Remove</button>
</td>
</tr>';
}
echo 'Change from 0000 to the digits of your choice';
echo '</fieldset>
</tbody>
</table>
<table class="table">
<thead>
<tr>
<td>
<button type="submit" class="btn btn-primary" name="addstaff" value="addstaff">Add new team member</button>
</td>
<td>
<button type="submit" class="btn btn" name="savechanges" value="savechanges">Save changes</button>
</td>
</tr>
</thead>
</table>
</form>';
}
drawtable();
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
