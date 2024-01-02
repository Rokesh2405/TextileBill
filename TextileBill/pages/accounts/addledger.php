<?php
$menu = "3,2,2,37";
$thispageid = 37;
$ze = 37;
include ('../../config/config.inc.php');
$dynamic = '1';
$datepicker = 1;
include ('../../require/header.php');

if (isset($_REQUEST['submit'])) {
    @extract($_REQUEST);
    $ip = $_SERVER['REMOTE_ADDR'];
    $msg = addledger($name,$printname,$under,$undersub,$ip,$_REQUEST['lid']);
}
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Ledger
           <!--  <small>
            <?php
            if ($_REQUEST['lid'] != '') {
                echo 'Edit';
            } else {
                echo 'Add New';
            }
            ?>
                 Item Type</small>-->
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $sitename; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#"><i class="fa fa-file-o"></i>Accounts</a></li>
            <li><a href="<?php echo $sitename; ?>accounts/ledger.htm"> Ledger </a></li>
            <li class="active"><?php
                if ($_REQUEST['lid'] != '') {
                    echo 'Edit';
                } else {
                    echo 'Add New';
                }
                ?> Ledger</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <form name="department" id="department" action="" method="post" enctype="multipart/form-data">
            <div class="box box-info">
                <div class="box-header with-border">
                    <!-- <h3 class="box-title"><?php
                    if ($_REQUEST['lid'] != '') {
                        echo 'Edit';
                    } else {
                        echo 'Add New';
                    }
                    ?> &nbsp;Item Type</h3>-->
                    <span style="float:right; font-size:13px; color: #333333; text-align: right;"><span style="color:#FF0000;">*</span> Marked Fields are Mandatory</span>
                </div>
                <div class="box-body">
                    <?php echo $msgs;
                    ?>
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <div class="panel-title">Ledger</div>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <label>Name <span style="color:#FF0000;">*</span></label>
                                    <input type="text" class="form-control" placeholder="Name" name="name" id="itemtype" value="<?php echo stripslashes(getledger('Name', $_REQUEST['lid'])); ?>" required="required"  title="Allowed Attributes [0-9 A-Z a-z.,'()]{3,50}" onkeypress="setprintname(this.value)" autocomplete="off"  onkeydown="setprintname(this.value)"  onkeyup="setprintname(this.value)"  />
                                </div>
                                <div class="col-md-4">
                                    <label>Print Name<span style="color:#FF0000;">*</span></label>
                                    <input type="text" class="form-control" placeholder="Print Name" name="printname" id="printname"   value="<?php echo stripslashes(getledger('printname', $_REQUEST['lid'])); ?>" required="required"  />
                                </div>
                                <div class="col-md-4">
                                    <label>Ledger Group<span style="color:#FF0000;">*</span></label>
                                    <select name="under" id="under" required="required" class="form-control">
                                        <option value="">Please Select</option>
                                          <?php
                                        $getmanuf = $db->prepare("SELECT * FROM `ledger_group`");
                                        $getmanuf->execute();
                                        while ($fdepart = $getmanuf->fetch(PDO::FETCH_ASSOC)) {
                                            ?>
                                            <option value="<?php echo $fdepart['ledgergroupid']; ?>"
                                            <?php
                                            if ($fdepart['ledgergroupid'] == getledger('under', $_REQUEST['brid'])) {
                                                echo 'selected="selected"';
                                            }
                                            ?>
                                                    ><?php echo $fdepart['ledgergroupname']; ?></option>
                                                <?php } ?>

                                        
                                    </select>
                                </div>
                            </div>
                            <br />
                            <div class="row">



                                <div class="col-md-4">
                                    <label>Sub ledger Group <span style="color:#FF0000;"></span></label>
                                    <select name="undersub" id="undersub" class="form-control">
                                        <option value="">Please Select</option>
                                        <?php
                                        $getmanuf = $db->prepare("SELECT * FROM `subledgergroup`");
                                        $getmanuf->execute();
                                        while ($fdepart = $getmanuf->fetch(PDO::FETCH_ASSOC)) {
                                            ?>
                                            <option value="<?php echo $fdepart['slid']; ?>"
                                            <?php
                                            if ($fdepart['slid'] == getledger('subledger', $_REQUEST['brid'])) {
                                                echo 'selected="selected"';
                                            }
                                            ?>
                                                    ><?php echo $fdepart['sname']; ?></option>
                                                <?php } ?>

                                    </select>
                                </div>
                            </div>
                            <br />

                        </div>

                        <div class="box-footer">
                            <div class="row">
                                <div class="col-md-6">
                                    <a href="<?php echo $sitename; ?>accounts/ledger">Back to Listings page</a>
                                </div>
                                <div class="col-md-6">
                                    <button type="submit" name="submit" id="submit" class="btn btn-success" style="float:right;"><?php
                                        if ($_REQUEST['lid'] != '') {
                                            echo 'UPDATE';
                                        } else {
                                            echo 'SAVE';
                                        }
                                        ?>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div><!-- /.box -->
                    </form>
                    </section><!-- /.content -->
                </div><!-- /.content-wrapper -->


                <?php include ('../../require/footer.php'); ?>