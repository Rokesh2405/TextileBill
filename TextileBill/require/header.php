<?php
if ($dynamic == '') {
    include ('config/config.inc.php');
}
if ($_SESSION['UID'] == '') {
    header("Location:" . $sitename . "pages/");
}
$actual_link = "https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>TT Billing</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.4 -->
        <link href="<?php echo $sitename; ?>bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- FontAwesome 4.3.0 -->
        <link href="<?php echo $sitename; ?>font-awesome/css/font-awesome.css" rel="stylesheet" type="text/css" />
        <!-- Ionicons 2.0.0 -->
        <link href="<?php echo $sitename; ?>ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="<?php echo $sitename; ?>dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
        <!-- AdminLTE Skins. Choose a skin from the css/skins folder instead of downloading all of them to reduce the load. -->
        <link href="<?php echo $sitename; ?>plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo $sitename; ?>dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />
        <!-- iCheck -->
        <link href="<?php echo $sitename; ?>plugins/iCheck/flat/blue.css" rel="stylesheet" type="text/css" />
        <!-- Morris chart -->
        <link href="<?php echo $sitename; ?>plugins/morris/morris.css" rel="stylesheet" type="text/css" />
        <!-- jvectormap -->
        <link href="<?php echo $sitename; ?>plugins/jvectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css" />
        <!-- Date Picker -->
        <link href="<?php echo $sitename; ?>plugins/datepicker/datepicker3.css" rel="stylesheet" type="text/css" />
        <!-- Daterange picker -->
        <link href="<?php echo $sitename; ?>plugins/daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" />
        <!-- Bootstrap time Picker -->
        <link rel="stylesheet" href="<?php echo $sitename; ?>plugins/timepicker/bootstrap-timepicker.min.css">
        <!-- Select2 -->
        <link rel="stylesheet" href="<?php echo $sitename; ?>plugins/select2/select2.min.css">
        <!-- AdminLTE Skins. Choose a skin from the css/skins-->
        <link rel="icon" href="<?php echo $sitename; ?>images/5aab.png" type="image/png" />
        <!-- bootstrap wysihtml5 - text editor -->
        <link href="<?php echo $sitename; ?>plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo $sitename; ?>dhtmlgoodies_calendar/dhtmlgoodies_calendar.css" rel="stylesheet" type="text/css" />
        
        
        
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        <script>
            function startTime() {
                var today = new Date();
                var h = today.getHours();
                var m = today.getMinutes();
                var s = today.getSeconds();
                m = checkTime(m);
                s = checkTime(s);
                var ampm = h >= 12 ? 'PM' : 'AM';
                h = h % 12;
                h = h ? h : 12; // the hour '0' should be '12'
                //m = m < 10 ? '0'+m : m;
                m = m < 10 ? m : m;
                var dd = today.getDate();
                //var mm = today.getMonth()+1; //January is 0!
                var mm = today.getMonth();
                var yyyy = today.getFullYear();
                if (dd < 10) {
                    dd = '0' + dd
                }
                if (mm < 10) {
                    //mm='0'+mm
                }
                var monthNames = [
                    "Jan", "Feb", "Mar",
                    "Apr", "May", "June", "Jul",
                    "Aug", "Sep", "Oct",
                    "Nov", "Dec"
                ];
                document.getElementById('txt').innerHTML = h + ":" + m + ":" + s + ' ' + ampm + ' | ' + dd + ' - ' + monthNames[mm] + ' - ' + yyyy;
                var t = setTimeout(startTime, 500);
            }
            function checkTime(i) {
                if (i < 10) {
                    i = "0" + i
                }
                return i;
            }
        </script>
    </head>
    <?php
    if ($collapse == '1') {
        $collapse = 'sidebar-collapse';
    } else {
        $collapse = '';
    }
    ?>
	<script>
        var mini = true;
function toggleSidebar() {
 const element = document.getElementById("sidebar_id");
  if (element.className == "skin-blue sidebar-mini skin-blue sidebar-mini") {
    element.className = "skin-blue sidebar-mini skin-blue sidebar-mini sidebar-collapse";
  } else {
    element.className = "skin-blue sidebar-mini skin-blue sidebar-mini";
  }


}

    </script>
	<!--<body class="skin-blue sidebar-mini skin-blue sidebar-mini" onload="startTime();">-->
    <body  class="skin-blue sidebar-mini skin-blue sidebar-mini sidebar-collapse" onload="startTime();" id="sidebar_id">
        <div class="wrapper">
            <header class="main-header">
                <!-- Logo -->
                <a href="<?php echo $sitename; ?>" class="logo" style="background-color: #00cc36;">
                    <!-- mini logo for sidebar mini 50x50 pixels -->
                    <span class="logo-mini"><b>TTB</b></span>
                    <!-- logo for regular state and mobile devices -->
                    <span class="logo-lg"><b>TT BIlling</b></span>
                </a>
                <!-- Header Navbar: style can be found in header.less -->
                <nav class="navbar navbar-static-top" role="navigation" style="background-color: #00cc36;">
                    <!-- Sidebar toggle button-->
                    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                        <span class="sr-only">Toggle navigation</span>
                    </a>
                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">
                            <li>
                                <a id="txt"></a>
                            </li>
                            <li class="list-inline-item dropdown notification-list">
                            <!-- <a class="nav-link  dropdown-toggle right-bar-toggle waves-light waves-effect" data-toggle="dropdown" aria-haspopup="false" aria-expanded="false" role="button" href="#">
                                <i class="fa fa-bell"><span class="badge" style="background-color: red "><?php
                                $date = date("d-m-Y");
$stmt1=$db->prepare("UPDATE `bankstatus` SET `currentdate`=?");
 $stmt1->execute(array(date('Y-m-d', strtotime($date))));

$stmt=$db->prepare("SELECT * FROM bankstatus WHERE DATEDIFF(`currentdate`,`dateofpawn`) >85 and `status`=1");
 $stmt->execute();
 $cnt=$stmt->rowCount();
 echo $cnt;
 
 ///
 $stmt1=$db->prepare("UPDATE `loan` SET `currentdate`=?");
 $stmt1->execute(array(date('Y-m-d', strtotime($date))));
//dateofpawn

?></span></i>
                            </a> -->
<div class="dropdown-menu dropdown-menu-right profile-dropdown " aria-labelledby="Preview" style="width:350px">
                                
<a href="#" class="dropdown-item notify-item">
  <span>     

<?php 
$stmt=$db->prepare("SELECT * FROM bankstatus WHERE DATEDIFF(`currentdate`,`dateofpawn`) >85 and `status`=1");
$stmt->execute();
while($row=$stmt->fetch(PDO::FETCH_ASSOC))
{
$sdate=$row['dateofpawn'];
 $days=$row['no_of_days'];
$bank = $row['bankname'];
$id = $row['id'];

// if($days > 6)
// {
$bankid=$row['bankid'];

// echo '<a href="'.$fsitename.'master/'.$row['id'].'/editbankstatus.htm">click here to view details</a>';
// echo "pawn days "." ".$days." "."on"." ".$sdate."bank name is "." ".$bank." "." <br>";
//master/2/editbankstatus.htm

//}
}
echo '<a href="'.$fsitename.'master/viewpawn.htm">click here to view details</a>';
?>
</span></a>
                                
                            </div>
                        </li> 
                            <li class="dropdown user user-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <?php if (getprofile('image', $_SESSION['UID']) != '') { ?>
                                        <img src="<?php echo $sitename . 'pages/profile/image/' . getprofile('image', $_SESSION['UID']); ?>"  class="user-image" />
                                    <?php } else { ?>
                                       Profile
                                    <?php } ?>
                                    <span class="hidden-xs">&nbsp;</span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="user-header">
                                        <?php if (getprofile('image', $_SESSION['UID']) != '') { ?>
                                            <img src="<?php echo $sitename . 'pages/profile/image/' . getprofile('image', $_SESSION['UID']); ?>" class="img-circle" />
                                        <?php } else { ?>
                                            Profile
                                        <?php } ?>
                                        <span class="hidden-xs">&nbsp;  </span>
                                        <p style="margin-top:24px;">
                                            <?php
                                                $sel1 = pFETCH("SELECT * FROM `admin_history` WHERE `admin_uid`=?", $_SESSION['UIDD']);
                                                $fsel = $sel1->fetch(PDO::FETCH_ASSOC);
                                                $_SESSION['type'] = 'admin';
                                                echo 'Welcome ' . getprofile('title', $_SESSION['UID']) . '.' . getprofile('firstname', $_SESSION['UID']);
                                            ?>
                                        </p>
                                    </li>
                                    <!-- Menu Body -->
                                    <li class="user-footer">
                                        <?php if ($_SESSION['type'] == 'admin') { if (!$_SESSION['permissionid']) { ?>
                                        <?php if($_SESSION['UID']=='1') { ?>
                                            <div class="col-xs-12 text-center">
                                                <a href="<?php echo $sitename; ?>profile/viewprofile.htm">Edit Profile</a>
                                            </div>
                                            <div class="clearfix"><br /><br /></div>
                                             <div class="pull-left">
                                                <a href="<?php echo $sitename; ?>profile/changepassword.htm" class="btn btn-default btn-flat">Change Password</a>
                                            </div>
                                            <?php } ?>
                                           
                                            <?php
                                        } } ?>
                                        <div class="pull-right">
                                            <a href="<?php echo $sitename; ?>logout.php" class="btn btn-default btn-flat">Sign out</a>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                            <!-- Control Sidebar Toggle Button -->
                           <!-- <li>
                                <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                            </li>-->
                        </ul>
                    </div>
                </nav>
            </header>
            <?php
            include 'sidebar.php';

            if ($_SESSION['permissionid']) {
                if ($thispageid != '') {
                    $per = FETCH_all("SELECT * FROM `permission_details` WHERE `perm_id`=? AND `page_id`=?", $_SESSION['permissionid'], $thispageid);
                    if ($per['pview'] == '1') {
                        
                    } else {
                        ?>
                        <div class="content-wrapper">
                            <!-- Content Header (Page header) -->
                            <section class="content-header">  
                                <h1>
                                    Access Denied
                                </h1>
                                <ol class="breadcrumb">
                                    <li><a href="<?php echo $sitename; ?>"><i class="fa fa-dashboard"></i> Home</a></li>

                                    <li class="active">Access Denied</li>
                                </ol>
                            </section>

                            <!-- Main content -->
                            <section class="content">
                                
                                <div class="error-page">
                                    <h3 class="text-red">Oops! You don't have permission to access this page.</h3>

                                    <div class="error-content">
                                      <!--<h3><i class="fa fa-warning text-red"></i> You don't have permission to access this page.</h3>-->


                                    </div>
                                </div>
                                <!-- /.error-page -->

                            </section>
                            <!-- /.content -->
                        </div>
                        <?php
                        include('footer.php');
                        exit;
                    }
                } elseif ($thispageaddid != '') {
                    $per = FETCH_all("SELECT * FROM `permission_details` WHERE `perm_id`=? AND `page_id`=?", $_SESSION['permissionid'], $thispageaddid);
                    if ($per['paddnew'] == '1') {
                        
                    } else {
                        ?>
                        <div class="content-wrapper">
                            <!-- Content Header (Page header) -->
                            <section class="content-header">
                                <h1>
                                    Access Denied
                                </h1>
                                <ol class="breadcrumb">
                                    <li><a href="<?php echo $sitename; ?>"><i class="fa fa-dashboard"></i> Home</a></li>

                                    <li class="active">Access Denied</li>
                                </ol>
                            </section>

                            <!-- Main content -->
                            <section class="content">

                                <div class="error-page">
                                    <h3 class="text-red">Oops! You don't have permission to access this page.</h3>

                                    <div class="error-content">
                                      <!--<h3><i class="fa fa-warning text-red"></i> You don't have permission to access this page.</h3>-->


                                    </div>
                                </div>
                                <!-- /.error-page -->

                            </section>
                            <!-- /.content -->
                        </div>
                        <?php
                        include('footer.php');
                        exit;
                    }
                } elseif ($thispageeditid != '') {
                    $per = FETCH_all("SELECT * FROM `permission_details` WHERE `perm_id`=? AND `page_id`=?", $_SESSION['permissionid'], $thispageeditid);
                    if ($per['pedit'] == '1') {
                        
                    } else {
                        ?>
                        <div class="content-wrapper">
                            <!-- Content Header (Page header) -->
                            <section class="content-header">
                                <h1>
                                    Access Denied
                                </h1>
                                <ol class="breadcrumb">
                                    <li><a href="<?php echo $sitename; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
                                    <li class="active">Access Denied</li>
                                </ol>
                            </section>

                            <!-- Main content -->
                            <section class="content">
                                <div class="error-page">
                                    <h3 class="text-red">Oops! You don't have permission to access this page.</h3>
                                    <div class="error-content">
                                      <!--<h3><i class="fa fa-warning text-red"></i> You don't have permission to access this page.</h3>-->
                                    </div>
                                </div>
                                <!-- /.error-page -->

                            </section>
                            <!-- /.content -->
                        </div>
                        <?php
                        include('footer.php');
                        exit;
                    }
                }
            }
            ?>
            
            <script type="text/javascript">
                var Settings = {
                    base_url: '<?php echo $sitename; ?>'
                }
            </script>
            
