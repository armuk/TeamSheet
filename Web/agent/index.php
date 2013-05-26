<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Hey Jimmy Ltd.</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

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
<?php include_once("../analyticstracking.php");
ini_set('display_errors',0);
error_reporting(E_ALL | E_STRICT);
if (!empty($_POST['email']) AND !empty($_POST['optionsRadios']) AND !empty($_POST['months'])) {
if ($_POST['optionsRadios'] == 1)
$fee = 10;
if ($_POST['optionsRadios'] == 2)
$fee = 25;
if ($_POST['optionsRadios'] == 3)
$fee = 50;
if ($_POST['optionsRadios'] == 4)
$fee = 75;
$months = $_POST['months'];
$feemultiplied = $fee * $months;
$email = $_POST['email'];
$button = '<form action="https://checkout.google.com/api/checkout/v2/checkoutForm/Merchant/466268360827724" id="BB_BuyButtonForm" method="post" name="BB_BuyButtonForm" target="_top">
    <input name="item_name_1" type="hidden" value="Team Sheet"/>
    <input name="item_description_1" type="hidden" value="Subscription fee for Team Sheet - Staff management software"/>
    <input name="item_quantity_1" type="hidden" value="1"/>
    <input name="item_price_1" type="hidden" value="'.$feemultiplied.'"/>
    <input name="item_currency_1" type="hidden" value="GBP"/>
    <input name="_charset_" type="hidden" value="utf-8"/>
    <input alt="" src="https://checkout.google.com/buttons/buy.gif?merchant_id=466268360827724&amp;w=117&amp;h=48&amp;style=white&amp;variant=text&amp;loc=en_US" type="image"/>
</form>';
require_once "Mail.php";
$from = "james@heyjimmy.net";        
$to = $email;
        $subject = "Team Sheet from Hey Jimmy";
        $body = '<html><body>Thank you and welcome to Team Sheet!<br>
<br>The cloud-based staff management package from Hey Jimmy, proudly built in Scotland.<br>
<br>
Please click the following link to complete payment for your account via Google Wallet '.$button.'<br>
You can sign up for your 7 day free trial at <a href="https://heyjimmy.net/signup/">HeyJimmy.net</a> - please note, if you don\'t complete payment before the 7 days expires then your account will become inactive.<br>
<br>
If you have any questions or feedback then please e-mail me and I\'ll be happy to help.<br>
<br>
-- <br>
Thanks<br>
James Guthrie<br>
Founder - Hey Jimmy Ltd.<br>
<br>
Web - heyjimmy.net<br>
Twitter - @HeyJimmyUK<br>
Skype - jamesjguthrie<br>
<br>
Registered in Scotland - SC435825</body></html>';

        $host = "ssl://smtp.gmail.com";
        $port = "465";
        $username = "YOUREMAIL";  //<> give errors
        $password = "YOURPASSWORD";
	$headers = array ('From' => $from,
          'To' => $to,
          'Subject' => $subject, 'MIME-Version' => '1.0', 'Content-type' => 'text/html; charset=iso-8859-1');
;
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
else {
echo <<<START
    <div class="container">

<div class="carousel-caption">
              <form class="form" name="form1" method="post" action=".">  
        <fieldset>  
		
           <div class="control-group">    
            <div class="controls">  
              <input type="email" class="input-xxlarge" id="email" name="email" placeholder="Client's e-mail address">
<input type="number" min="1" max="12" class="input-xxlarge" id="months" name="months" placeholder="How many months are they paying?">  
            </div>  
          </div> 
<label class="radio">
  <input type="radio" name="optionsRadios" id="optionsRadios1" value="1" checked>1-5 staff, £10 per month
</label>
<label class="radio">
  <input type="radio" name="optionsRadios" id="optionsRadios2" value="2">
6-25 staff, £25 per month
</label>
<label class="radio">
  <input type="radio" name="optionsRadios" id="optionsRadios3" value="3">
26-75 staff, £50 per month</label>  
<label class="radio">
  <input type="radio" name="optionsRadios" id="optionsRadios4" value="4">
76-150 staff, £75 per month</label> 
		            <div class="form-actions">  
            <button type="submit" class="btn btn-primary" name="Submit">E-mail client with invoice</button>  
            <button class="btn">Cancel</button>  
          </div>  
        </fieldset>  
</form>
</div>
START;
}
?>


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
