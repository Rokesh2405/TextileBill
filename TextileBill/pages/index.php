<?php
// echo "Due to payment overdue site has been suspended. Please contact provide for the payment process";
// exit;
include '../config/config.inc.php';
if($_SESSION['UID'] != '') {
    header("location:" . $sitename);
    exit;
}
if (isset($_REQUEST['logsubmit']))
{
    @extract($_REQUEST);
    /* $captcha = $_POST['g-recaptcha-response'];
      $ip = $_SERVER['REMOTE_ADDR'];
      $rsp = "https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$captcha&remoteip=$ip";
      $jsondate = file_get_contents($rsp);
      $arr = json_decode($jsondate, true);
      if ($arr['success'] == '1') { */
    $msg = LoginCheck($uname, $pwd, $ip, $rememberme, $_REQUEST['login']);
    // echo $msg;
    if ($msg == "Admin" || $msg == "User" || $msg == "agent" || $msg == "Hurray! You will redirect into dashboard soon")
    {
        header("location:" . $sitename);
        exit;
    } else {
        echo '<script>window.onload = function(){ $("#login-box").addClass("animated shake" ); };</script>';
    }
    /* } else {
      $msg = $arr.'<span style="color:#FF0000; font-weight:bold;">Captcha Code Invalid</span>';
      } */
}
?>
<!DOCTYPE html>
<html lang="en-IN">
    <head>
        <meta charset="UTF-8">
        <title>TT Billing | Login</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.4 -->
        <link href="<?php echo $sitename; ?>bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- Font Awesome Icons -->
        <link href="<?php echo $sitename; ?>font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="<?php echo $sitename; ?>dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
        <!-- iCheck -->
        <link href="<?php echo $sitename; ?>plugins/iCheck/square/blue.css" rel="stylesheet" type="text/css" />

        <script src='https://www.google.com/recaptcha/api.js'></script>
        <link rel="icon" href="<?php echo $sitename; ?>images/5aab.png" type="image/png" />
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

        <style type="text/css">
            .login-page
            {
                overflow-y:hidden;
            }
            .rc-anchor-normal { width:317px !important; }
            iframe { min-width:320px !important; }

            .animated {
                -webkit-animation-duration: 1s; 
                animation-duration: 1s; 
                -webkit-animation-fill-mode: both; 
                animation-fill-mode: both;
            }

            @-webkit-keyframes shake {
                0%, 100% {-webkit-transform: translateX(0);} 
                10%, 30%, 50%, 70%, 90% {-webkit-transform: translateX(-10px);} 
                20%, 40%, 60%, 80% {-webkit-transform: translateX(10px);} 
            }

            @keyframes shake { 
                0%, 100% {transform: translateX(0);} 
                10%, 30%, 50%, 70%, 90% {transform: translateX(-10px);} 
                20%, 40%, 60%, 80% {transform: translateX(10px);} 
            }

            .shake { 
                -webkit-animation-name: shake; 
                animation-name: shake; 
            }
        </style>
    </head>
    <body class="login-page  ">
        <div class="login-box ">
            <div class="login-logo">
                <img src="https://thanvitechnologies.com/images/site_logo/header.png" style="height:80px;"/>
                <a href="#"><h3>TT Billing<!-- <img src="<?php echo $sitename; ?>pages/profile/image/1532344513.png" /> --></h3></a>
            </div><!-- /.login-logo -->
            <div class="login-box-body">
                <p class="login-box-msg"><?php
                    if ($msg != '') {
                        echo $msg;
                    } else {
                        ?>Sign in to start your session
                    <?php } ?>
                </p>
                <form action="" method="post" autocomplete="off" id="login-box">
                    <div class="form-group has-feedback">
                        <input type="text" class="form-control" required="required" name="uname" id="uname" value="<?php echo $_COOKIE['lemail']; ?>" placeholder="Username" pattern="[a-zA-Z0-9.@-]{0,55}" title="Username" maxlength="55" />
                        <span class="glyphicon glyphicon-user form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <input type="password" class="form-control" placeholder="Password" value="<?php echo $_COOKIE['lpass']; ?>" name="pwd" minlength='6' maxlength="55" id="pwd" title="Password" required="required"  />
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="social-auth-links text-center">
                                <script src='https://www.google.com/recaptcha/api.js'></script>                       
                                <?php //echo $sitekey;  ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6" style="float-right:35px;">
                            <div class="checkbox icheck">
                                <!--                                <label>
                                                                    <input type="checkbox" name="remember" id="remember" value="1"> Remember Me
                                                                </label>-->
                            </div>
                        </div>
                        <div class="col-md-6">
                            <button type="submit" class="btn btn-success btn-block btn-flat" name="logsubmit" id="logsubmit">Sign In</button>
                        </div>
                    </div>
                </form>
            </div><!-- /.login-box-body -->
			<br>
			<p align="center"><a href="https://thanvitechnologies.com/" target="_blank" style="color:blue;font-weight:bold;font-size:13px;">www.thanvitechnologies.com</a></p>
			<p align="center"  style="color:#008d4;font-weight:bold;font-size:13px;">For Support : +91 8438164916</p>
        </div><!-- /.login-box -->
		
        <!-- jQuery 2.1.4 -->
        <script src="<?php echo $sitename; ?>plugins/jQuery/jQuery-2.1.4.min.js" type="text/javascript"></script>
        <!-- Bootstrap 3.3.2 JS -->
        <script src="<?php echo $sitename; ?>bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <!-- iCheck -->
        <script src="<?php echo $sitename; ?>plugins/iCheck/icheck.min.js" type="text/javascript"></script>
        <script>
            $(function () {
                $('input').iCheck({
                    checkboxClass: 'icheckbox_square-blue',
                    radioClass: 'iradio_square-blue',
                    increaseArea: '20%' // optional
                });
            });
        </script>
    </body>
</html>