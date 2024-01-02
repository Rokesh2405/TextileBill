<?php

if (isset($_REQUEST['id'])) {
    $thispageeditid = 10;
} else {
    $thispageaddid = 10;
}
$menu = "4,4,228";
include ('../../config/config.inc.php');
$dynamic = '1';
include ('../../require/header.php');
if (isset($_REQUEST['submit'])) {
    @extract($_REQUEST);
    $getid = $_REQUEST['id'];
    $ip = $_SERVER['REMOTE_ADDR'];
  
$msg = adddailyexpense($date,$type,$amount,$billno,$comment,$getid);
}

?>

<style>
       .form-control{
           font-size:19px;
       }
       label{
           font-size:19px;
       }
   </style>
    
    
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Expenses
            <small><?php
                if ($_REQUEST['cid'] != '') {
                    echo 'Edit';
                } else {
                    echo 'Add New';
                }
                ?> Daily Expense</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $sitename; ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="#"><i class="fa fa-asterisk"></i>Expense(s)</a></li>            
            <li><a href="#"><i class="fa fa-circle-o"></i> Daily Expense</a></li>
            <li class="active"><?php
                if ($_REQUEST['id'] != '') {
                    echo 'Edit';
                } else {
                    echo 'Add New';
                }
                ?> Daily Expense</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <form name="department" id="department"  method="post" enctype="multipart/form-data">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php
                        if ($_REQUEST['id'] != '') {
                            echo 'Edit';
                        } else {
                            echo 'Add New';
                        }
                        ?> Expense Type</h3>
                    <span style="float:right; font-size:13px; color: #333333; text-align: right;"><span style="color:#FF0000;">*</span> Marked Fields are Mandatory</span>
                </div>
                <div class="box-body">
                    <?php echo $msg; ?>
                    <div class="row">
                        
                        
                        <div class="col-md-4">
                            <label>Date <span style="color:#FF0000;">*</span></label>
							 <input type="date"  required="required" name="date"autocomplete="off" class="form-control" value="<?php echo getdailyexpense('date',$_REQUEST['id']); ?>" />
                        </div>
						 
                        <div class="col-md-4">
                            <label>Expense Type <span style="color:#FF0000;">*</span></label>
							<select name="type" required="required" class="form-control">
							<option value="">Select</option>
							<?php
						 $sel = pFETCH("SELECT * FROM `expense_type` WHERE `status`=?", 1);

					while ($fdepart = $sel->fetch(PDO::FETCH_ASSOC)) {
					
                       ?>
					   <option value="<?php echo $fdepart['id']; ?>" <?php if(getdailyexpense('date',$_REQUEST['id'])==$fdepart['id']) { ?> selected="selected" <?php } ?>><?php echo $fdepart['type']; ?></option>
					<?php } ?>
							</select>
							
						
                        </div>
						
						 
                        <div class="col-md-4">
                            <label>Rate <span style="color:#FF0000;">*</span></label>
							 <input type="text"  required="required" name="amount"autocomplete="off" placeholder="Enter the Expense Amount" class="form-control" value="<?php echo getdailyexpense('amount',$_REQUEST['id']); ?>" />
                        </div>
						</div>
						<br>
						<div class="row">
						
						<div class="col-md-4">
                            <label>Billno </label>
							 <input type="text" name="billno" autocomplete="off" placeholder="Enter the Bill No" class="form-control" value="<?php echo getdailyexpense('billno',$_REQUEST['id']); ?>" />
                        </div>
						
                          <div class="col-md-8">
						    <label>Comment</label>
							<textarea name="comment" class="form-control"><?php echo getdailyexpense('comment',$_REQUEST['id']); ?></textarea>
							
							
                      </div>
                        
                        
                    </div>
                    
                     <div class="clearfix"><br /></div>
                    
                    
                     <br>
                    
                   
                </div><!-- /.box-body -->
                <div class="box-footer">
                    <div class="row">
                        <div class="col-md-6">
                          <!--  <a href="<?php echo $sitename; ?>master/da.htm">Back to Listings page</a>-->
                        </div>
                        <div class="col-md-6">
                            <button type="submit" name="submit" id="submit" class="btn btn-success" style="float:right;"><?php
                                if ($_REQUEST['id'] != '') {
                                    echo 'UPDATE';
                                } else {
                                    echo 'SUBMIT';
                                }
                                ?></button>
                        </div>
                    </div>
                </div>
            </div><!-- /.box -->
        </form>
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
<?php include ('../../require/footer.php'); ?>