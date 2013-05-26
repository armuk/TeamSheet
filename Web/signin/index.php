<?php session_start();
if (isset($_SESSION['accountid']))
unset($_SESSION['accountid']);
?>
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
        <link href="../../css/bootstrap-responsive.css" rel="stylesheet">
    <style type="text/css">
      body {
        padding-top: 20px;
        padding-bottom: 10px;
      }          

	  /* Featurettes
    ------------------------- */

    .featurette-divider {
      margin: 40px 0; /* Space out the Bootstrap <hr> more */
    }
    .featurette {
      padding-top: 50px; /* Vertically center images part 1: add padding above and below text. */
      overflow: hidden; /* Vertically center images part 2: clear their floats. */
    }
    .featurette-image {
      margin-top: -120px; /* Vertically center images part 3: negative margin up the image the same amount of the padding to center it. */
    }

    /* Give some space on the sides of the floated elements so text doesn't run right into it. */
    .featurette-image.pull-left {
      margin-right: 40px;
    }
    .featurette-image.pull-right {
      margin-left: 40px;
	  max-height:200px;
    }

    /* Thin out the marketing headings */
    .featurette-heading {
      font-size: 50px;
      font-weight: 300;
      line-height: 1;
      letter-spacing: -1px;
    }    /* Carousel base class */
    .carousel {
      margin-bottom: 10px;
	  
    }

    .carousel .container {
      position: relative;
      z-index: 10;
    }

    .carousel-control {
      height: 80px;
      margin-top: 0;
      font-size: 120px;
      text-shadow: 0 1px 1px rgba(0,0,0,.4);
      background-color: transparent;
      border: 0;
    }

    .carousel .item {
      max-height: 200px;
    }
    .carousel img {
      position: static;
      max-height: 400px;
margin-top: 10px;
    }

    .carousel-caption {
      background-color: transparent;
      position: inherit;
      max-width: 500px;
      float: left;
      margin-top: 10px;
    }
    .carousel-caption h1,
    .carousel-caption .lead {
      margin-left: 10px;
	  	font-size: 40px;
      line-height: 1.25;
      color: #000;
    }
    .carousel-caption .btn {
      
	  margin-top: auto;
    }
    </style>

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Fav and touch icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="../img/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="../img/apple-touch-icon-114-precomposed.png">
      <link rel="apple-touch-icon-precomposed" sizes="72x72" href="../img/apple-touch-icon-72-precomposed.png">
                    <link rel="apple-touch-icon-precomposed" href="../img/apple-touch-icon-57-precomposed.png">
                                   <link rel="shortcut icon" href="../favicon.png">
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
              <li><a href="http://heyjimmy.net">Home</a></li>
              <li><a href="http://www.crunchbase.com/company/hey-jimmy" target="_blank">About</a></li>
              <li><a href="https://twitter.com/HeyJimmyUK" target="_blank">Twitter</a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>
<?php
echo <<<START
    <div class="container">
<div class="carousel"><hr>
                  <div class="row">
<div class="span6">
<img src="../../img/ipads.png" alt="">
</div>
<div class="span2">
</div>
<div class="span4">
<div class="carousel-caption">
              <form class="form" name="form1" method="post" action="../team/">  
        <fieldset>  
		
<div class="control-group">    
            <div class="controls">  
              <input type="email" class="input-xlarge" id="email" name="email" placeholder="E-mail address">  
            </div>  
          </div>  
		            <div class="control-group">  
            <div class="controls">  
              <input type="password" class="input-xlarge" id="password" name="password" placeholder="Password">  
            </div>  
          </div>  
          <div class="form-actions">  
            <button type="submit" class="btn btn-primary" name="Submit">Sign in</button>  
            <button class="btn">Cancel</button>  
          </div>  
        </fieldset>  
</form>
START;

?>
            </div>
</div>
</div>
<hr class="featurette-divider">
      <!-- Example row of columns -->
      <div class="row">       
<div class="span3">
          <h2>Why you need Team Sheet</h2>
          <p>The app records staff sign in and out times along with a photograph of the employee using the app.</p>
          <p>No more in-accurate sign-in sheets!</p>
        </div>
        <div class="span3">
          <h2>Bye bye paper</h2>
          <p>Do you still use sign-in sheets at work? Get rid of them now. All you need for Team Sheet is an iPad or an Android tablet.</p>
       </div>
        <div class="span3">
          <h2>Cloud-based admin</h2>
          <p>Online setup and administration of the entire service. Check staff sign-in times and photos from any web browser. All backed up by the power of Google App Engine.</p>
        </div>
 <div class="span3">
          <h2>Completely free!</h2>
        </div>
      </div>
      <hr class="featurette-divider">

      <footer>
        <p>&copy; Hey Jimmy Ltd. 2013 - Registered in Scotland, SC435825</p>
      </footer>

    </div> <!-- /container -->

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
