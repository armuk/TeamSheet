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
              <li><a href="../team/">Team Members</a></li>
	<li><a href="../timekeeping/">Team Timekeeping</a></li>
	<li><a href="../noticeboard/">Team Noticeboard</a></li>
              <li class="nav-header">Account</li>
	<li class="active"><b>Account Settings</b></li>
              <li><a href="../signout/">Sign Out</a></li>
</ul>
          </div><!--/.well -->
        </div><!--/span-->
        <div class="span9">
<div class="container-fluid">
<div class="well">
<?php
if (isset($_POST['savechanges'])){
//deletedata();
savedata();
}
$namestring = 'Name';
$companystring = 'Company';
$addressstring = 'Address';
$emailstring = 'E-mail';
$passwordstring = 'Password';
$uuidstring = 'UUID';
$greetingstring = 'Greeting';
$docidstring = '_docId';
$_SESSION['name'] = array();
$_SESSION['company'] = array();
$_SESSION['address'] = array();
$_SESSION['email'] = array();
$_SESSION['passwordfromaccountsettings'] = array();
$_SESSION['uuid'] = array();
$_SESSION['greeting'] = array();
$_SESSION['docid'] = array();
$ch = curl_init();
$timeout = 25;
$ch = curl_init('https://clockinoutapp.appspot.com/_je/'.$_SESSION['accountid'].'-account');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
$data = curl_exec($ch);
curl_close($ch);
$jsondata = json_decode($data);
foreach ($jsondata as $parseddata){
if (isset($parseddata->$namestring))
$_SESSION['name'] = $parseddata->$namestring;
if (isset($parseddata->$companystring))
$_SESSION['company'] = $parseddata->$companystring;
if (isset($parseddata->$addressstring))
$_SESSION['address'] = $parseddata->$addressstring;
if (isset($parseddata->$emailstring))
$_SESSION['email'] = $parseddata->$emailstring;
if (isset($parseddata->$passwordstring))
$_SESSION['passwordfromaccountsettings'] = $parseddata->$passwordstring;
if (isset($parseddata->$uuidstring))
$_SESSION['uuid'] = $parseddata->$uuidstring;
if (isset($parseddata->$greetingstring))
$_SESSION['greeting'] = $parseddata->$greetingstring;
if (isset($parseddata->$docidstring))
$_SESSION['docid'] = $parseddata->$docidstring;
}
function deletedata(){
$chdelete = curl_init();
curl_setopt($chdelete, CURLOPT_URL, 'http://clockinoutapp.appspot.com/_je/'.$_SESSION['accountid'].'-account');
curl_setopt($chdelete, CURLOPT_CUSTOMREQUEST, 'DELETE');
curl_exec($chdelete);
curl_close($chdelete);
sleep(2);
}

function savedata(){
$_SESSION['name'] = $_POST['name'];
$_SESSION['company'] = $_POST['company'];
$_SESSION['address'] = $_POST['address'];
$_SESSION['greeting'] = $_POST['greeting'];
$namestring = 'Name';
$companystring = 'Company';
$addressstring = 'Address';
$emailstring = 'E-mail';
$passwordstring = 'Password';
$uuidstring = 'UUID';
$greetingstring = 'Greeting';
$jsonstring = array($namestring => $_POST['name'], $companystring => $_POST['company'], $addressstring => $_POST['address'], $greetingstring => $_POST['greeting']); 
$chsavenew = curl_init();
curl_setopt($chsavenew, CURLOPT_URL, 'http://clockinoutapp.appspot.com/_je/' . $_SESSION['accountid'] . '-account/' . $_SESSION['docid'] . '?_doc=' . urlencode(json_encode($jsonstring)));
curl_setopt($chsavenew, CURLOPT_HTTPHEADER, array('Accept: application/json', 'Content type: application/json; charset=UTF-8'));
curl_setopt($chsavenew, CURLOPT_HEADER, 1);
curl_setopt($chsavenew, CURLOPT_POST, 1);
curl_setopt($chsavenew, CURLOPT_POSTFIELDS, 1);
curl_setopt($chsavenew, CURLOPT_RETURNTRANSFER, 1);
curl_exec($chsavenew);
curl_close($chsavenew);
sleep(2);
}
function checkdata(){
$timeout = 25;
$chcheck = curl_init('http://clockinoutapp.appspot.com/_je/'.$_SESSION['accountid'].'-account');
curl_setopt($chcheck, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($chcheck, CURLOPT_CONNECTTIMEOUT, $timeout);
$datacheck = curl_exec($chcheck);
curl_close($chcheck);
}
echo '<table class="table table-condensed">
<tbody>
<form class="form" name="team" method="post" action=".">
<fieldset>';
function drawtable(){
$namestring = 'Name';
$companystring = 'Company';
$addressstring = 'Address';
$greetingstring = 'Greeting';
echo '<tr>
<td><b>'.$namestring.'</b></td>
<td><input type="text" class="input-xlarge" id="name" name="name" value="'.$_SESSION['name'].'"></td>
</tr>
<tr>
<td><b>'.$companystring.'</b></td>
<td><input type="text" class="input-xlarge" id="company" name="company" value="'.$_SESSION['company'].'"></td>
</tr>
<tr>
<td><b>'.$addressstring.'</b></td>
<td><textarea class="input-xlarge" id="address" name="address" rows="3">'.$_SESSION['address'].'</textarea></td>
</tr>
<tr>
<td><b>'.$greetingstring.'</b></td>
<td><input type="text" class="input-xlarge" id="greeting" name="greeting" value="'.$_SESSION['greeting'].'"></td>
</tr>
</tr>';
echo '</fieldset>
</tbody>
</table>
<table class="table">
<thead>
<tr>
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
