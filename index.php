<?php
/*  GOOGLE LOGIN BASIC - Tutorial
 *  file            - index.php
 *  Developer       - Krishna Teja G S
 *  Website         - http://packetcode.com/apps/google-login/
 *  Date            - 28th Aug 2015
 *  license         - GNU General Public License version 2 or later
*/

// REQUIREMENTS - PHP v5.3 or later
// Note: The PHP client library requires that PHP has curl extensions configured.
/*
 * DEFINITIONS
 *
 * load the autoload file
 * define the constants client id,secret and redirect url
 * start the session
 */
require_once __DIR__.'/gplus-quickstart-php-master/vendor/autoload.php';
const CLIENT_ID = '510385604994-uepqv6svouk6oo31fd27bhogh1tt38ps.apps.googleusercontent.com';
const CLIENT_SECRET = '5w5F0cvHQQFlgr-qNT2sL18G';
//const REDIRECT_URI = 'http://localhost/mundiasis/';
const REDIRECT_URI = 'http://localhost/mundiasis/';

require_once 'functions.php';
require_once 'conn.php';


/*
 * INITIALIZATION
 *
 * Create a google client object
 * set the id,secret and redirect uri
 * set the scope variables if required
 * create google plus object
 */
$client = new Google_Client();
$client->setClientId(CLIENT_ID);
$client->setClientSecret(CLIENT_SECRET);
$client->setRedirectUri(REDIRECT_URI);
$client->setScopes('email');

$plus = new Google_Service_Plus($client);

/*
 * PROCESS
 *
 * A. Pre-check for logout
 * B. Authentication and Access token
 * C. Retrive Data
 */

/*
 * A. PRE-CHECK FOR LOGOUT
 *
 * Unset the session variable in order to logout if already logged in
 */
if (isset($_REQUEST['logout'])) {
    session_unset();
    session_destroy();
}

/*
 * B. AUTHORIZATION AND ACCESS TOKEN
 *
 * If the request is a return url from the google server then
 *  1. authenticate code
 *  2. get the access token and store in session
 *  3. redirect to same url to eleminate the url varaibles sent by google
 */
if (isset($_GET['code'])) {
    $client->authenticate($_GET['code']);
    $_SESSION['access_token'] = $client->getAccessToken();
    $redirect = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
    header('Location: ' . filter_var($redirect, FILTER_SANITIZE_URL));
}

/*
 * C. RETRIVE DATA
 *
 * If access token if available in session
 * load it to the client object and access the required profile data
 */
if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
    $client->setAccessToken($_SESSION['access_token']);
    $me = $plus->people->get('me');

    // Get User data
    $id = $me['id'];
    $name =  $me['displayName'];
    $email =  $me['emails'][0]['value'];
//$email='a.kahlaoui@mundiapolis.ma';
    $profile_image_url = $me['image']['url'];
    $cover_image_url = $me['cover']['coverPhoto']['url'];
    $profile_url = $me['url'];

    $_SESSION['profile_image']= $profile_image_url;

} else {
    // get the login url
    $authUrl = $client->createAuthUrl();
}


?>
<html>
<head>
    <style type="text/css">



        body {
            background-color: #444;
            background: url(http://s18.postimg.org/l7yq0ir3t/pick8_1.jpg);

        }
        .form-signin input[type="text"] {
            margin-bottom: 5px;
            border-bottom-left-radius: 0;
            border-bottom-right-radius: 0;
        }
        .form-signin input[type="password"] {
            margin-bottom: 10px;
            border-top-left-radius: 0;
            border-top-right-radius: 0;
        }
        .form-signin .form-control {
            position: relative;
            font-size: 16px;
            font-family: 'Open Sans', Arial, Helvetica, sans-serif;
            height: auto;
            padding: 10px;
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
        }
        .vertical-offset-100 {
            padding-top: 100px;
        }
        .img-responsive {
            display: block;
            max-width: 100%;
            height: auto;
            margin: auto;
        }
        .panel {
            margin-bottom: 20px;
            background-color: rgba(255, 255, 255, 0.75);
            border: 1px solid transparent;
            border-radius: 4px;
            -webkit-box-shadow: 0 1px 1px rgba(0, 0, 0, .05);
            box-shadow: 0 1px 1px rgba(0, 0, 0, .05);
        }

    </style>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Connexion à MundiaSis</title>

    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugins/font-awesome/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/AdminLTE.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="hold-transition login-page">
        <!-- HTML CODE with Embeded PHP-->


        <script src="http://mymaplist.com/js/vendor/TweenLite.min.js"></script>









        <?php
    /*
     * If login url is there then display login button
     * else print the retieved data
    */



    if (isset($authUrl)) {

        echo '            
        <div class="container">
            <div class="row vertical-offset-100">
                <div class="col-md-8 col-md-offset-2">
                    <div class="panel panel-default">
                        <div class="panel-heading">                                
                            <div class="row-fluid user-row">
                                <img src="dist/img/logo.png" class="img-responsive" alt="mundiasis"/>
                            </div>
                        </div>
                        <div class="panel-body">';
                            echo "<p class='login-box-msg'>";
                            if(isset($_GET["unauth"])){ echo "<br /> <x class='text-danger'>Vous devez vous connecter d'abord</x>"; }
                            echo "<br><center><h3>Cliquez sur le bouton ci-dessous pour vous connecter !</h3></center><br></p>";
                            echo '
                            <form accept-charset="UTF-8" role="form" class="form-signin">
                                <fieldset>
                                    <a href="' . $authUrl . '" style="align: center;" ><center><img src="dist/img/signin_button.png" height="50px"/></center></a>
                                </fieldset>
                            </form>
                        </div>
                        <div class="panel-footer">2017 Copyright © - <a href="http://www.mundiapolis.ma">www.mundiapolis.ma</a></div>
                    </div>
                </div>
            </div>
        </div>';

    } else {
     /* print "ID: {$id} <br>";
     print "Name: {$name} <br>";
     print "Email: {$email } <br>";
     print "Image : {$profile_image_url} <br>";
     print "Cover  :{$cover_image_url} <br>";
     print "Url: {$profile_url} <br><br>";*/

     $allowed = ['mundiapolis.ma'];

// Make sure the address is valid
     if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $explodedEmail = explode('@', $email);
        $domain = array_pop($explodedEmail);

        if (!in_array($domain, $allowed)) {
               // echo "not allowed";
            header("Location:notAllowed.php");

        } else {
            print "this is your email : {$email} <br>";


            $query = $conn->query("select * from `professeur` where `email_prof` = '$email' ");
            $fetch = $query->fetch_array();

            $query_etudiant = $conn->query("select `email_etudiant` from `etudiant` where `email_etudiant` = '$email' ");
            $fetch_etudiant = $query_etudiant->fetch_array();

            if ($fetch['email_prof']) {
                $_SESSION['email_prof'] = $email;
                $_SESSION['code_prof'] = $fetch['code_prof'];
                $_SESSION['type_user'] = "prof";
                $_SESSION['semestre'] = 'S2';
                $_SESSION['annee'] = '2016';
                header("Location:indexx.php?page=p_notes");

            } else {
                if ($fetch_etudiant['email_etudiant']) {
                    $_SESSION['email_etudiant'] = $email;
                    $_SESSION['type_user'] = "stud";

                    header("Location:indexx.php?page=e_notes");
                } else {
                    header("Location:notInDb.php");
                }
            }
        }
    }}







    ?>


    <script type="text/javascript">

        $(document).ready(function() {
            $(document).mousemove(function(event) {
                TweenLite.to($("body"), 
                    .5, {
                        css: {
                            backgroundPosition: "" + parseInt(event.pageX / 8) + "px " + parseInt(event.pageY / '12') + "px, " + parseInt(event.pageX / '15') + "px " + parseInt(event.pageY / '15') + "px, " + parseInt(event.pageX / '30') + "px " + parseInt(event.pageY / '30') + "px",
                            "background-position": parseInt(event.pageX / 8) + "px " + parseInt(event.pageY / 12) + "px, " + parseInt(event.pageX / 15) + "px " + parseInt(event.pageY / 15) + "px, " + parseInt(event.pageX / 30) + "px " + parseInt(event.pageY / 30) + "px"
                        }
                    })
            })
        })



    </script>
