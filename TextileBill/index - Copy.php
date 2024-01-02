<?php
$dynamic = '';
$menu = '1,0,0,0';
$index = '1';
include ('require/header.php');
print_r($_SESSION);
?>
<!-- Left side column. contains the logo and sidebar -->
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <?php
    print_r($_SESSION);
    if ($_SESSION['type'] == 'admin') {
        ?>
        <section class="content-header">
            <h1>Sales Endorsment Software<small>Control panel</small></h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Sales Endorsment Software</li>
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
                            $stmt = $db->prepare("SELECT * FROM  `customer` WHERE `status`!='2'");
                            $stmt->execute();
                            $sel = $stmt->rowCount();
                            // $fsel=mysql_query(mysql_fetch_array($sel));
                            echo $sel;
                            ?></h3>
                        <p style="color:white;">Customers</p>
                    </div>
                    <div class="icon">
                        <i class="ion-person-add"></i>
                    </div>
                    <a href="<?php echo $sitename; ?>master/customer.htm" class="small-box-footer">Launch Page<i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div><!-- ./col -->
                      
        </div><!-- /.row -->
        </section><!-- /.content -->
    <?php } else { ?>
        <section class="content-header">
            <h1>
                Welcome to Salesendorsement Software
            </h1>
        </section>

    <?php } ?>
</div><!-- /.content-wrapper -->
<?php include 'require/footer.php'; ?>      
