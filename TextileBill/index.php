<?php
$dynamic = '';
$menu = '1,0,0,0';
$index='1';
include ('require/header.php');
//print_r($_SESSION);
?>
<style>
    /*.content-wrapper{*/
    /*    background-image : url("img/coins1.jpg");*/
    /*    height: 480px;*/
    /*}*/
</style>
<!-- Left side column. contains the logo and sidebar -->
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <?php
    if ($_SESSION['type'] == 'admin') {
        ?>
        <section class="content-header">

            <h2>
                <b> TT Billing </b>
                <small>Control panel</small>
            </h2>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">TT Billing</li>
            </ol>
        </section>
<section class="content">
<?php if($_SESSION['usertype']!='salesman')  {?>
            <!-- Small boxes (Stat box) -->
            <div class="row">
            <div class="col-md-3">
                <!-- small box -->
                <a href="<?php echo $sitename; ?>pages/process/sales_report.php">
                <div class="small-box"style="background-color:#00c0ef;">
                    <div class="inner">
                        <h3 style="color:white;">
                           <?php
						    $link1 = FETCH_all("SELECT count(*) AS `totsale` FROM online_order WHERE `date`='".date('d-m-Y')."' AND `id`!=?", '0');
 echo $link1['totsale'];
                           ?></h3>
                        <p style="color:white;">TODAY SALES<br> click here to details</p>
                    </div>
                    <div class="icon">
                        <i class="ion-person-add"></i>
                    </div>
                   
                </div>
                
                </a>
            </div>
            <div class="col-md-3">
                <!-- small box -->
                 <a href="<?php echo $sitename; ?>pages/process/purchase_report.php">
                <div class="small-box"style="background-color:#00c0ef;">
                <div class="inner">
                        <h3 style="color:white;">
                           <?php
						    $link1 = FETCH_all("SELECT count(*) AS `totsale` FROM purchase WHERE `date`='".date('d-m-Y')."' AND `id`!=?", '0');
 echo $link1['totsale'];
                          
                           ?></h3>
                        <p style="color:white;">TODAY PURCHASE</p><br>
                    </div>
                    <div class="icon">
                        <i class="ion-person-add"></i>
                    </div>
                   
                </div>
               </a>
            </div>
            <div class="col-md-3">
                <!-- small box -->
               
                <a href="<?php echo $sitename; ?>pages/process/expense_report.php">
                <div class="small-box"style="background-color:#00c0ef;">
                   <div class="inner">
                        <h3 style="color:white;">
                           <?php
						    $link1 = FETCH_all("SELECT count(*) AS `totsale` FROM daily_expense WHERE `date`='".date('Y-m-d')."' AND `id`!=?", '0');
 echo $link1['totsale'];
 
                           ?></h3>
                        <p style="color:white;">TODAY EXPENSE</p><br>
                    </div>
                    <div class="icon">
                        <i class="ion-person-add"></i>
                    </div>
                   
                </div>
               
            </div>
            </div><!-- /.row -->

        </section>
        
<?php } else { ?>
		  <div class="row">
            <div class="col-md-3">
                <!-- small box -->
                <a href="<?php echo $sitename; ?>pages/process/onlineorder.php">
                <div class="small-box"style="background-color:#00c0ef;">
                    <div class="inner">
                        <h3 style="color:white;">
                           <?php
						   $adid=$_SESSION['UID'];
						    $link1 = FETCH_all("SELECT count(*) AS `totsale` FROM online_order WHERE `date`='".date('d-m-Y')."' AND `created_id`=? AND `createdby`=?", $adid,'subuser');
 echo $link1['totsale'];
                           ?></h3>
                        <p style="color:white;">TODAY SALES<br> click here to details</p>
                    </div>
                    <div class="icon">
                        <i class="ion-person-add"></i>
                    </div>
                   
                </div>
                
                </a>
            </div>
           </div>
		   <?php 
} ?>
		   
		   </div>
        <!-- Main content -->
        <section class="content">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <!--<img src="img/index.PNG" style="margin-left:123px;"/>-->
            </div><!-- /.row -->

        </section><!-- /.content -->
    <?php } else { ?>
        <section class="content-header">
            <h1>
                Welcome to HOTEL
            </h1>
        </section>

<?php } ?>
</div><!-- /.content-wrapper -->
<?php include 'require/footer.php'; ?>      
