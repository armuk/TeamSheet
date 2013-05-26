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
    <link href="../css/bootstrap.css" rel="stylesheet">
    <style type="text/css">
      body {
        padding-top: 60px;
        padding-bottom: 40px;
      }
      .sidebar-nav {
        padding: 9px 0;
      }
    </style>
    <link href="../css/bootstrap-responsive.css" rel="stylesheet">

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
          <a class="brand"><img src="../img/smalllogo.png"></img></a>
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
	<li><a href="../timekeeping">Team Timekeeping</a></li>
              <li class="nav-header">Account</li>
              <li><a href="#">Sign Out</a></li>
            </ul>
          </div><!--/.well -->
        </div><!--/span-->
        <div class="span9">
<div class="container-fluid">
<div class="well">


<?php

  if (!empty($_GET['addstaff'])) {
echo "true";
$staffnumbers++;

  } else {
$ch = curl_init("http://clockinoutapp.appspot.com/_je/8c79bd00-ad17-40ed-b836-c26db874806f");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HEADER, 0);
$data = curl_exec($ch);
$jsondata = json_decode($data);
$name = array();
$datetime = array();
$image = array();
$index = 0;
foreach ($jsondata as $parseddata){
$signedin = 'Signed-in';
$shouldvesignedin = 'Today\'s shift';
$datetime[] = $parseddata->$signedin;
$name[] = $parseddata->Name;
$image[] = $parseddata->Image;
$index++;
}
;
curl_close($ch);
echo '
<table class="table">
<form class="form" name="form1" method="get" action="index.php"> 
<thead>
<tr>
<td>Staff ID</td>
<td>Name</td>
<td>
  <button class="btn btn-mini"><input type="hidden" name="addstaff" value="run">+</button>
</td>
</tr>
</thead>
<tbody>
<tr>
<td>
<input type="text" class="input" id="staffid" name="staffid"> 
</input>
</td>
<td>
<input type="text" class="input" id="name" name="name"> 
</input>
</td>
</tr>
<tr>
<td>
<button type="submit" class="btn btn-primary" name="Submit">Save Changes</button>
</td>
<td>
<button class="btn">Cancel</button>
</td>
</tr>
</tbody>
</table>
</form>';
}
?>
		</div> 
</div>       
        </div><!--/span-->
      </div><!--/row-->

      <hr>

      <footer>
        <p>&copy; Hey Jimmy Ltd. 2013 - Registered in Scotland, 

SC435825</p>
      </footer>
    </div><!--/.fluid-container-->

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
<script src="../js/jquery.js"></script>
    <script src="../js/bootstrap-transition.js"></script>
    <script src="../js/bootstrap-alert.js"></script>
    <script src="../js/bootstrap-modal.js"></script>
    <script src="../js/bootstrap-dropdown.js"></script>
    <script src="../js/bootstrap-scrollspy.js"></script>
    <script src="../js/bootstrap-tab.js"></script>
    <script src="../js/bootstrap-tooltip.js"></script>
    <script src="../js/bootstrap-popover.js"></script>
    <script src="../js/bootstrap-button.js"></script>
    <script src="../js/bootstrap-collapse.js"></script>
    <script src="../js/bootstrap-carousel.js"></script>
    <script src="../js/bootstrap-typeahead.js"></script>

  </body>
  </html>
