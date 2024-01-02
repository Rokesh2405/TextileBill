<?php
$menu = "3,2,2,36";
$thispageid =61;
$ze =60;
include ('../../config/config.inc.php');
$dynamic = '1';
$datepicker = 1;
include ('../../require/header.php');

if (isset($_REQUEST['submit'])) {
    @extract($_REQUEST);
    $ip = $_SERVER['REMOTE_ADDR'];
    $msg = addsubledger($name, $ledgergroup, $ip, $_REQUEST['slid']);
}
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Sub Ledger
           <!--  <small>
            <?php
            if ($_REQUEST['slid'] != '') {
                echo 'Edit';
            } else {
                echo 'Add New';
            }
            ?>
                 Item Type</small>-->
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $sitename; ?>" ><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#"><i class="fa fa-file-o"></i>Accounts</a></li>
            <li><a href="<?php echo $sitename; ?>accounts/subledger.htm"> Sub Ledger </a></li>
            <li class="active"><?php
                if ($_REQUEST['slid'] != '') {
                    echo 'Edit';
                } else {
                    echo 'Add New';
                }
                ?> Sub Ledger</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <form name="department" id="department" action="" method="post" enctype="multipart/form-data">
            <div class="box box-info">
                <div class="box-header with-border">
                    <!-- <h3 class="box-title"><?php
                    if ($_REQUEST['slid'] != '') {
                        echo 'Edit';
                    } else {
                        echo 'Add New';
                    }
                    ?> &nbsp;Item Type</h3>-->
                    <span style="float:right; font-size:13px; color: #333333; text-align: right;"><span style="color:#FF0000;">*</span> Marked Fields are Mandatory</span>
                </div>
                <div class="box-body">
                    <?php echo $msg; ?>
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <div class="panel-title">Ledger</div>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <label>Sub Ledger Name <span style="color:#FF0000;">*</span></label>
                                    <input type="text" class="form-control" placeholder="Name" name="name" id="itemtype" value="<?php  echo getsubledger('sname', $_REQUEST['slid']);  ?>" required="required"  title="Allowed Attributes [0-9 A-Z a-z.,'()]{3,50}" />
                                </div>

                                <div class="col-md-4">
                                    <label>Ledger Group<span style="color:#FF0000;">*</span></label>
                                    <select name="ledgergroup" id="under" class="form-control">
                                        <option value="">Please Select</option>
                                        <?php
                                        $getmanuf = $db->prepare("SELECT * FROM `ledger_group`");
                                        $getmanuf->execute();   
                                        while ($fdepart = $getmanuf->fetch(PDO::FETCH_ASSOC)) {
                                            ?>
                                            <option value="<?php echo $fdepart['ledgergroupid']; ?>"
                                            <?php
                                            if ($fdepart['ledgergroupid'] == getsubledger('ledgergroup', $_REQUEST['slid'])) {
                                                echo 'selected="selected"';
                                            }
                                            ?>><?php echo $fdepart['ledgergroupname']; ?></option>
                                                <?php } ?>
                                    </select>

                                </div>
                            </div>
                            <br/>
                        </div>

                        <div class="box-footer">
                            <div class="row">
                                <div class="col-md-6">
                                    <a href="<?php echo $sitename; ?>accounts/subledger.htm">Back to Listings page</a>
                                </div>
                                <div class="col-md-6">
                                    <button type="submit" name="submit" id="submit" class="btn btn-success" style="float:right;"><?php
                                        if ($_REQUEST['slid'] != '') {
                                            echo 'UPDATE';
                                        } else {
                                            echo 'SAVE';
                                        }
                                        ?>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div><!-- /.box --></div></div>
                    </form>
                    </section><!-- /.content -->
                </div><!-- /.content-wrapper -->


<?php include ('../../require/footer.php'); ?>