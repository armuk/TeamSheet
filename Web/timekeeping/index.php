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
	<li class="active"><b>Team Timekeeping</b></li>
		<li><a href="../noticeboard/">Team Noticeboard</li>
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
$timeout = 30;
$ch2 = curl_init('http://clockinoutapp.appspot.com/_je/'.$_SESSION['accountid'].'-times?sort=Signed-in.desc');
curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch2, CURLOPT_CONNECTTIMEOUT, $timeout);
$signedin2 = 'Signed-in';
$data2 = curl_exec($ch2);
$jsondata2 = json_decode($data2);
$name2 = array();
$datetime2 = array();
$image2 = array();
foreach ($jsondata2 as $parseddata2){
$shouldvesignedin = 'Today\'s shift';
if (isset($parseddata2->$signedin2))
$datetime2[] = $parseddata2->$signedin2;
$name2[] = $parseddata2->Name;
if (isset($parseddata2->Image))
$image2[] = $parseddata2->Image;
}
curl_close($ch2);
for($i = 0; $i < count($image2); $i++){
if (($datetime2[$i] != '') && ($image2[$i] != '')) {
echo '<table class="table"><thead><tr><td>Name</td><td>'.$name2[$i].'</td></tr></thead><tr><td>Signed</td><td>'.$datetime2[$i].'</td></tr><tr><td>Picture</td><td><img src="http://heyjimmy.net/uploader/uploaded_files/'.$image2[$i].'" width="256" height="144"></img></td></tr></table>';
}
}
echo 'Account ID: '.$_SESSION['accountid']; 
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
