<?php
$menu='1,1';
include ('require/header.php');
//print_r($_SESSION);
?>

<!-- Left side column. contains the logo and sidebar -->
<!-- Content Wrapper. Contains page content -->

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
     <?php  if ($_SESSION['type'] == 'admin')
         
        {
        ?>
    <section class="content-header">
    
        <h1>
          Click2buy
            <small>Control panel</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Click2buy</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-md-3">
                <!-- small box -->
                <div class="small-box"style="background-color:#F2B305;">
                    <div class="inner">
                        
                        <h3 style="color:white;">
                            <?php 
                           
                       $user=pFETCH("SELECT `uid` FROM `usermaster` where `status`!=? and `uid`=?",2,$_SESSION['UID']);
                       //echo "SELECT `uid` FROM `usermaster`";
                       $suser=$user->fetch(PDO::FETCH_ASSOC);
                     
                       if($suser['uid'] == $_SESSION['UID'])
                       {
                        $sel = pFETCH("SELECT  DISTINCT `aid` FROM `agent` where `status`!=? and `updated_by`=?",2,$_SESSION['UID']);
                         $sel = $stmt->rowCount();
                        //$fsel=mysql_query(mysql_fetch_array($sel));
                        echo $sel;
                       }
 else {
     $stmt = $db->prepare("SELECT  DISTINCT `aid` FROM `agent`");
                                     $stmt->execute();
                                     $sel = $stmt->rowCount();
                                        echo $sel;
 }
                        ?>
                            
                            
                            <?php  /*$sel = DB_NUM("SELECT  DISTINCT `aid` FROM `agent`");
                        $fsel=mysql_query(mysql_fetch_array($sel));
                        echo $sel;*/
                        ?></h3>
                        <p style="color:white;">No of Agents</p>
                    </div>
                    <div class="icon">
                        <i class="ion-person-add"></i>
                    </div>
                    <a href="<?php echo $sitename ;?>master/agents.htm" class="small-box-footer">Launch Page<i class="fa fa-arrow-circle-right"></i></a>
        </div>
            </div><!-- ./col -->
            <div class="col-md-3">
                <!-- small box -->
                       <div class="small-box " style="background-color:#BF00FF;">                    
                        <div class="inner">
                        <h3 style="color:white;"><?php 
                       $user=mysql_query("SELECT `uid` FROM `usermaster` where `status`!='2' and `uid`='".$_SESSION['UID']."'");
                       //echo "SELECT `uid` FROM `usermaster`";
                       $suser=mysql_fetch_array($user);
                     
                       if($suser['uid'] == $_SESSION['UID'])
                       {
                        $sel = DB_NUM("SELECT  DISTINCT `cusid` FROM `customer` where `status`!='2' and `updatedid`='".$_SESSION['UID']."'");
                        $fsel=mysql_query(mysql_fetch_array($sel));
                        echo $sel;
                       }
 else {
      $sel = DB_NUM("SELECT  DISTINCT `cusid` FROM `customer`");
                       // $fsel=mysql_query(mysql_fetch_array($sel));
                        echo $sel;
 }
                        ?>
                            
                        </h3>
                        <p style="color:white;">No of Customers</p>
                    </div>
                    <div class="icon">
                        <i class="ion-ios-people"></i>
                    </div>
                    <a href="<?php echo $sitename; ?>master/customers.htm" class="small-box-footer">Launch Page<i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div><!-- ./col -->
            <div class="col-md-3">
                <!-- small box -->
                <div class="small-box " style="background-color:#8258FA;">
                    <div class="inner">
                        <h3 style="color:white;"><?php  $sel = DB_NUM("SELECT * FROM `create_ads`");
                        $fsel=mysql_query(mysql_fetch_array($sel));
                        echo $sel;
                        ?></h3>
                        
                        <p style="color:white;">No of Advertisements</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-user-times"></i>
                    </div>
                    <a href="<?php echo $sitename; ?>master/advertising.htm" class="small-box-footer">Launch Page<i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div><!-- ./col -->
                <div class="col-md-3">
                <!-- small box -->
                <div class="small-box " style="background-color:green;">
                    <div class="inner">
                        <h3 style="color:white;"><?php  $sel = DB_NUM("SELECT * FROM `create_ads` WHERE `admin_status`='2' ");
                        $fsel=mysql_query(mysql_fetch_array($sel));
                        echo $sel;
                        ?></h3>
                        <p style="color:white;">Un Approved Advertisements</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-user-times"></i>
                    </div>
                    <a href="<?php echo $sitename; ?>master/unapprovedads.htm" class="small-box-footer">Launch Page<i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
             <div class="col-md-3">
                <!-- small box -->
                <div class="small-box " style="background-color: crimson;">
                    <div class="inner">
                        <h3 style="color:white;"><?php  $sel = DB_NUM("SELECT * FROM `create_ads` WHERE `admin_status`='0' ");
                        $fsel=mysql_query(mysql_fetch_array($sel));
                        echo $sel;
                        ?></h3>
                        <p style="color:white;">Waiting for approval Advertisements</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-user-times"></i>
                    </div>
                    <a href="<?php echo $sitename; ?>master/waitingads.htm" class="small-box-footer">Launch Page<i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-md-3">
                <!-- small box -->
                <div class="small-box " style="background-color: deeppink;">
                    <div class="inner">
                        <h3 style="color:white;"><?php  $sel = DB_NUM("SELECT * FROM `create_ads` WHERE `admin_status`='1' ");
                        $fsel=mysql_query(mysql_fetch_array($sel));
                        echo $sel;
                        ?></h3>
                        <p style="color:white;"> Approved Advertisements</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-user-times"></i>
                    </div>
                    <a href="<?php echo $sitename; ?>master/approvedads.htm" class="small-box-footer">Launch Page<i class="fa fa-arrow-circle-right"></i></a>
                </div>
                
            </div>
             <div class="col-md-3">
                <!-- small box -->
                <div class="small-box " style="background-color: cadetblue;">
                    <div class="inner">
                        <h3 style="color:white;"><?php  $sel = DB_NUM("SELECT * FROM `create_ads` WHERE `adtype`='1' ");
                        $fsel=mysql_query(mysql_fetch_array($sel));
                        echo $sel;
                        ?></h3>
                        <p style="color:white;"> Paid Advertisements</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-user-times"></i>
                    </div>
                    <a href="<?php echo $sitename; ?>master/paidads.htm" class="small-box-footer">Launch Page<i class="fa fa-arrow-circle-right"></i></a>
                </div>
                
            </div>
            <div class="col-md-3">
                <!-- small box -->
                <div class="small-box " style="background-color:blue">
                    <div class="inner">
                        <h3 style="color:white;"><?php  $sel = DB_NUM("SELECT * FROM `create_ads` WHERE `adtype`='2' ");
                        $fsel=mysql_query(mysql_fetch_array($sel));
                        echo $sel;
                        ?></h3>
                        <p style="color:white;"> Free  Advertisements</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-user-times"></i>
                    </div>
                    <a href="<?php echo $sitename; ?>master/freeads.htm" class="small-box-footer">Launch Page<i class="fa fa-arrow-circle-right"></i></a>
                </div>
                
            </div><!-- ./col -->
<!--            <div class="col-md-3">
                 small box 
                <div class="small-box" style="background-color:#D94E18;">
                    <div class="inner">
                        <h3 style="color:white;"><?php  $sel = DB_NUM("SELECT  DISTINCT `chqno` FROM `cheque` WHERE `cancelled`!=1");
                        $fsel=mysql_query(mysql_fetch_array($sel));
                        echo $sel;
                        ?></h3>
                        <p>&nbsp;</p>
                        <p style="color:white;">No.of.Tele Callers</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-phone"></i>
                    </div>
                    <a href="<?php echo $sitename; ?>cheque/print.htm" class="small-box-footer">Launch Page<i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div> ./col -->
        </div><!-- /.row -->

    </section><!-- /.content -->
     <?php } else if($_SESSION['type'] == 'agent')
         
       { ?>
     <section class="content-header">
        
       
        
        <h1>
          Nbaysmart
            <small>Control panel</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Nbaysmart</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-md-3">
                <!-- small box -->
                <div class="small-box"style="background-color:#F2B305;">
                    <div class="inner">
                        
                        <h3 style="color:white;">
                           <?php $sel = DB_NUM("SELECT * FROM `create_ads` where `agent_id`='" . $_SESSION['UIDD'] . "' AND `status`='1'");
                        $fsel=mysql_query(mysql_fetch_array($sel));
                        $sel1=$sel*20;
                        echo $sel1;
                            ?>
                            
                            <?php  /*$sel = DB_NUM("SELECT  DISTINCT `aid` FROM `agent`");
                        $fsel=mysql_query(mysql_fetch_array($sel));
                        echo $sel;*/
                        ?></h3>
                        <p style="color:white;">Amount</p>
                    </div>
                    <div class="icon">
                        <i class="ion-person-add"></i>
                    </div>
                    <a href="<?php echo $sitename ;?>master/agents.htm" class="small-box-footer">Launch Page<i class="fa fa-arrow-circle-right"></i></a>
        </div>
            </div><!-- ./col -->
            <div class="col-md-3">
                <!-- small box -->
                       <div class="small-box " style="background-color:#BF00FF;">                    
                        <div class="inner">
                        <h3 style="color:white;"><?php 
                       $user=mysql_query("SELECT `uid` FROM `usermaster` where `status`!='2' and `uid`='".$_SESSION['UID']."'");
                       //echo "SELECT `uid` FROM `usermaster`";
                       $suser=mysql_fetch_array($user);
                     
                       if($suser['uid'] == $_SESSION['UID'])
                       {
                        $sel = DB_NUM("SELECT  DISTINCT `cusid` FROM `customer` where `status`!='2' and `updatedid`='".$_SESSION['UID']."'");
                        $fsel=mysql_query(mysql_fetch_array($sel));
                        echo $sel;
                       }
 else {
      $sel = DB_NUM("SELECT  DISTINCT `cusid` FROM `customer`");
                       // $fsel=mysql_query(mysql_fetch_array($sel));
                        echo $sel;
 }
                        ?>
                            
                        </h3>
                        <p style="color:white;">No of Customers</p>
                    </div>
                    <div class="icon">
                        <i class="ion-ios-people"></i>
                    </div>
                    <a href="<?php echo $sitename; ?>master/customers.htm" class="small-box-footer">Launch Page<i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div><!-- ./col -->
            <div class="col-md-3">
                <!-- small box -->
                <div class="small-box " style="background-color:#8258FA;">
                    <div class="inner">
                        <h3 style="color:white;"><?php  $sel = DB_NUM("SELECT * FROM `create_ads` where `agent_id`='" . $_SESSION['UIDD'] . "'");
                        $fsel=mysql_query(mysql_fetch_array($sel));
                        echo $sel;
                        
                        ?></h3>
                        
                        <p style="color:white;">No of Advertisements</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-user-times"></i>
                    </div>
                    <a href="<?php echo $sitename; ?>master/advertising.htm" class="small-box-footer">Launch Page<i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div><!-- ./col -->
                <div class="col-md-3">
                <!-- small box -->
                <div class="small-box " style="background-color:green;">
                    <div class="inner">
                        <h3 style="color:white;"><?php  $sel = DB_NUM("SELECT * FROM `create_ads` WHERE `admin_status`='2' AND `agent_id`='".$_SESSION['UIDD']."'");
                        $fsel=mysql_query(mysql_fetch_array($sel));
                      echo $sel;
                        ?></h3>
                        <p style="color:white;">Un Approved Advertisements</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-user-times"></i>
                    </div>
                    <a href="<?php echo $sitename; ?>master/unapprovedads.htm" class="small-box-footer">Launch Page<i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
             <div class="col-md-3">
                <!-- small box -->
                <div class="small-box " style="background-color: darkcyan;">
                    <div class="inner">
                        <h3 style="color:white;"><?php  $sel = DB_NUM("SELECT * FROM `create_ads` WHERE `admin_status`='0' AND `agent_id`='".$_SESSION['UIDD']."'");
                      //  echo "SELECT * FROM `create_ads` WHERE `admin_status`='0' AND `agent_id`='".$_SESSION['UIDD']."'";
                        $fsel=mysql_query(mysql_fetch_array($sel));
                        echo $sel;
                        ?></h3>
                        <p style="color:white;">Waiting for Approval Advertisements</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-user-times"></i>
                    </div>
                    <a href="<?php echo $sitename; ?>master/waitingads.htm" class="small-box-footer">Launch Page<i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
             <div class="col-md-3">
                <!-- small box -->
                <div class="small-box " style="background-color: darkslateblue ;">
                    <div class="inner">
                        <h3 style="color:white;"><?php  $sel = DB_NUM("SELECT * FROM `create_ads` WHERE `admin_status`='1' AND `agent_id`='".$_SESSION['UIDD']."'");
                        $fsel=mysql_query(mysql_fetch_array($sel));
                        echo $sel;
                        ?></h3>
                        <p style="color:white;">Approved Advertisements</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-user-times"></i>
                    </div>
                    <a href="<?php echo $sitename; ?>master/approvedads.htm" class="small-box-footer">Launch Page<i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-md-3">
                <!-- small box -->
                <div class="small-box " style="background-color:blue;">
                    <div class="inner">
                        <h3 style="color:white;"><?php  $sel = DB_NUM("SELECT * FROM `create_ads` WHERE `adtype`='1' AND `agent_id`='".$_SESSION['UIDD']."'");
                        $fsel=mysql_query(mysql_fetch_array($sel));
                        echo $sel;
                        ?></h3>
                        <p style="color:white;">Paid Advertisements</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-user-times"></i>
                    </div>
                    <a href="<?php echo $sitename; ?>master/paidads.htm" class="small-box-footer">Launch Page<i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-md-3">
                <!-- small box -->
                <div class="small-box " style="background-color: deeppink;">
                    <div class="inner">
                        <h3 style="color:white;"><?php  $sel = DB_NUM("SELECT * FROM `create_ads` WHERE `adtype`='2' AND `agent_id`='".$_SESSION['UIDD']."'");
                        $fsel=mysql_query(mysql_fetch_array($sel));
                        echo $sel;
                        ?></h3>
                        <p style="color:white;">Free Advertisements</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-user-times"></i>
                    </div>
                    <a href="<?php echo $sitename; ?>master/freeads.htm" class="small-box-footer">Launch Page<i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-md-3">
                <!-- small box -->
                <div class="small-box " style="background-color: darksalmon;">
                    <div class="inner">
                        <h3 style="color:white;"><?php  $sel = DB_NUM("SELECT * FROM `create_ads` WHERE `adtype`='2' AND `agent_id`='".$_SESSION['UIDD']."'");
                        $fsel=mysql_query(mysql_fetch_array($sel));
                        echo $sel;
                        ?></h3>
                        <p style="color:white;">Earnings</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-user-times"></i>
                    </div>
                    <a href="<?php echo $sitename; ?>master/approvedads.htm" class="small-box-footer">Launch Page<i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-md-3">
                <!-- small box -->
                <div class="small-box " style="background-color: dimgrey;">
                    <div class="inner">
                        <h3 style="color:white;"><?php  $sel = DB_NUM("SELECT * FROM `create_ads` WHERE `adtype`='2' AND `agent_id`='".$_SESSION['UIDD']."'");
                        $fsel=mysql_query(mysql_fetch_array($sel));
                        echo $sel;
                        ?></h3>
                        <p style="color:white;">Paynow</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-user-times"></i>
                    </div>
                    <a href="<?php echo $sitename; ?>master/approvedads.htm" class="small-box-footer">Launch Page<i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div><!-- ./col -->
<!--            <div class="col-md-3">
                 small box 
                <div class="small-box" style="background-color:#D94E18;">
                    <div class="inner">
                        <h3 style="color:white;"><?php  $sel = DB_NUM("SELECT  DISTINCT `chqno` FROM `cheque` WHERE `cancelled`!=1");
                        $fsel=mysql_query(mysql_fetch_array($sel));
                        echo $sel;
                        ?></h3>
                        <p>&nbsp;</p>
                        <p style="color:white;">No.of.Tele Callers</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-phone"></i>
                    </div>
                    <a href="<?php echo $sitename; ?>cheque/print.htm" class="small-box-footer">Launch Page<i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div> ./col -->
        </div><!-- /.row -->

    </section><!-- /.content -->
     <?php }elseif($_SESSION['type'] == 'employee'){?>
    
     <?php }else{?>
     <section class="content-header">
      <h1>
          Welcome to Nbaysmart
        </h1>
     </section>
    
     <?php } ?>
</div><!-- /.content-wrapper -->
<?php include 'require/footer.php'; ?>      
