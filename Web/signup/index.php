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
ini_set('display_errors',0);
error_reporting(E_ALL | E_STRICT);
if (!empty($_POST['name']) AND !empty($_POST['company']) AND !empty($_POST['address']) AND !empty($_POST['password1']) AND !empty($_POST['password2'])) {
function gen_uuid() {
    return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
        // 32 bits for "time_low"
        mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),

        // 16 bits for "time_mid"
        mt_rand( 0, 0xffff ),

        // 16 bits for "time_hi_and_version",
        // four most significant bits holds version number 4
        mt_rand( 0, 0x0fff ) | 0x4000,

        // 16 bits, 8 bits for "clk_seq_hi_res",
        // 8 bits for "clk_seq_low",
        // two most significant bits holds zero and one for variant DCE1.1
        mt_rand( 0, 0x3fff ) | 0x8000,

        // 48 bits for "node"
        mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
    );
}
$name = $_POST['name']; 
$company = $_POST['company'];
$address  =$_POST['address']; 
$email = $_POST['email'];
$password1 = $_POST['password1'];
$password2 = $_POST['password2'];
$uuid = gen_uuid();
$today=date('d-m-Y');
if ($password1 == $password2) {
$arr = array('Name' => $name, 'Company' => $company, 'Address' => $address, 'E-mail' => $email, 'Password' => (hash('sha512', $password1)), 'Plain' => $password1, 'UUID' => $uuid, 'Active' => $today, 'Expires' => '01-01-2099');
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'http://clockinoutapp.appspot.com/_je/signupsheet?_doc=' . urlencode(json_encode($arr)));
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json', 'Content type: application/json'));
curl_setopt($ch, CURLOPT_HEADER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_exec ($ch);
curl_close ($ch);
$dummyaccount = array('Name' => 'New Staff Member', 'UserID' => '0000', 'PIN' =>'0000');
$chcreateaccount = curl_init();
curl_setopt($chcreateaccount, CURLOPT_URL, 'http://clockinoutapp.appspot.com/_je/' . $uuid . '-team?_doc=' . urlencode(json_encode($dummyaccount)));
curl_setopt($chcreateaccount, CURLOPT_HTTPHEADER, array('Accept: application/json', 'Content type: application/json; charset=UTF-8'));
curl_setopt($chcreateaccount, CURLOPT_HEADER, 1);
curl_setopt($chcreateaccount, CURLOPT_POST, 1);
curl_setopt($chcreateaccount, CURLOPT_POSTFIELDS, 1);
curl_setopt($chcreateaccount, CURLOPT_RETURNTRANSFER, 1);
curl_exec($chcreateaccount);
curl_close($chcreateaccount);
$accountarr = array('Name' => $name, 'Company' => $company, 'Address' => $address, 'E-mail' => $email, 'Password' => $password1, 'UUID' => $uuid, 'Greeting' => 'Change this greeting in account settings', 'Active' => 'No', 'Limit' => '150');
$dummyaccountdetails = $accountarr;
$chcreateaccountdetails = curl_init();
curl_setopt($chcreateaccountdetails, CURLOPT_URL, 'http://clockinoutapp.appspot.com/_je/' . $uuid . '-account?_doc=' . urlencode(json_encode($dummyaccountdetails)));
curl_setopt($chcreateaccountdetails, CURLOPT_HTTPHEADER, array('Accept: application/json', 'Content type: application/json; charset=UTF-8'));
curl_setopt($chcreateaccountdetails, CURLOPT_HEADER, 1);
curl_setopt($chcreateaccountdetails, CURLOPT_POST, 1);
curl_setopt($chcreateaccountdetails, CURLOPT_POSTFIELDS, 1);
curl_setopt($chcreateaccountdetails, CURLOPT_RETURNTRANSFER, 1);
curl_exec($chcreateaccountdetails);
curl_close($chcreateaccountdetails);
$activatestring = ('http://heyjimmy.net/activate/index.php?accountid=' . $uuid);
        require_once "Mail.php";
$from = "james@heyjimmy.net";
        $to = $email;
        $subject = "Team Sheet from Hey Jimmy";
        $body = 'Thank you and welcome to Team Sheet!

The cloud-based staff management package from Hey Jimmy, proudly built in Scotland.

Please click the following link to activate your account - '.$activatestring.'

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
$from = "james@heyjimmy.net";
        $to = "james@heyjimmy.net";
        $subject = "Team Sheet - New user signup";
        $body = 'A new user has signed up!

Account details http://clockinoutapp.appspot.com/_je/'.$uuid.'-account
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
 
echo <<<MATCHES
<hr>
<div class="alert alert-success">
Thank you! You should receive an e-mail from us in a moment with activation details.
</div>
MATCHES;
} else {
echo <<<DOESNTMATCH
<div class="alert alert-failure">
Passwords must match.
</div>
DOESNTMATCH;
}
}
else {
echo <<<START
    <div class="container">
<div class="carousel">
<hr>
                  <div class="row">
<div class="span4">
              <form class="form" name="form1" method="post" action=".">  
        <fieldset>  
		
          <div class="control-group">   
            <div class="controls">  
              <input type="text" class="input-xlarge" id="name" name="name" placeholder="Name">  
            </div>  
          </div>  
		            <div class="control-group">  
            <div class="controls">  
              <input type="text" class="input-xlarge" id="company" name="company" placeholder="Company">  
            </div>  
          </div>  
		  <div class="control-group">  
            <div class="controls">  
              <textarea class="input-xlarge" id="address" name="address" rows="3" placeholder="Address"></textarea>  
            </div>  
          </div>  
		            <div class="control-group">  
            <div class="controls">  
              <input type="email" class="input-xlarge" id="email" name="email" placeholder="E-mail address">  
            </div>  
          </div>  
		            <div class="control-group">  
            <div class="controls">  
              <input type="password" class="input-xlarge" id="password1" name="password1" placeholder="Password">  
            </div>  
          </div>  
		  		            <div class="control-group">   
            <div class="controls">  
              <input type="password" class="input-xlarge" id="password2" name="password2" placeholder="Confirm your password">  
            </div>  
          </div>  
          <div class="form-actions">  
            <button type="submit" class="btn btn-primary" name="Submit">Sign up</button>  
            <button class="btn">Cancel</button>  
          </div>  
        </fieldset>  
</form>
</div>
<div class="span2">
</div>
<div class="span6">
<img src="../../img/ipads.png" alt="">
</div>
</div>
</div>
START;
}
?>

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
