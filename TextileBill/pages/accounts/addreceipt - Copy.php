<?php
$menu = "3,2,2,43";
$thispageid = 37;
$ze = 37;
include ('../../config/config.inc.php');
$dynamic = '1';
$datepicker = 1;
include ('../../require/header.php');

if (isset($_REQUEST['submit'])) {
    @extract($_REQUEST);
    $ip = $_SERVER['REMOTE_ADDR'];
    
    $get1 = $db->prepare("SELECT * FROM `transactions` WHERE `id`=?");
    $get1->execute(array($_POST['bill_id']));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    
    $insert = $db->prepare("INSERT INTO `accounts_payment` SET `supplier`=?, `date`=?, `bill_id`=?,`bill_no`=?,`bill_date`=?, `amount`=?,`received_amout`=?,`pay_now_amount`=?, `pay_type`=?, `bank`=?, `bank_pay_type`=?, `bank_date`=?, `description`=?, `ip`=? ");
    $insert->execute(array($supplier,date("Y-m-d",strtotime($date)),$get['ref_id'],$get['bill_no'],$get['bill_date'],$paynow,$paytype,$bank,$cheque,$cdate,$desc,$ip));
    
}
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Receipt
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
            <li><a href="<?php echo $sitename; ?>accounts/receipt.htm"> Receipt </a></li>
            <li class="active"><?php
                if ($_REQUEST['lid'] != '') {
                    echo 'Edit';
                } else {
                    echo 'Add New';
                }
                ?> Receipt</li>
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
                    <?php echo $msg;
                    ?>
                       <div class="panel panel-info">
                        <div class="panel-heading">
                            <div class="panel-title">Receipt</div>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <label>Customers <span style="color:#FF0000;">*</span></label>

                                    <select onchange="getsuptrans(this.value)" name="customer" id="customer" class="form-control" required="required">
                                        <option value="">Please select</option>
                                       <?php  
                                       $sup = $db->prepare("SELECT * FROM `customer` WHERE `Status`=? ");
                                       $sup->execute(array(1));
                                       while($s = $sup->fetch()){
                                           echo '<option value="'.$s['CusID'].'" >'.$s['Person'].'</option> ';
                                       }
                                        ?>                                               
                                     </select>
                                </div>
                                <div class="col-md-4"></div>
                                <div class="col-md-4">
                                    <label>Date<span style="color:#FF0000;">*</span></label>
                                    <input type="text" class="form-control usedatepicker" placeholder="Date" name="date"   value="" required="required"  />
                                </div>

                            </div>

                            <br />
                            <div class="container-fluit">
                                <div class="panel panel-info">
                                    <div class="panel-heading">
                                        <div class="panel-title"><br/></div>
                                    </div>
                                    <div class="panel-body">  
                                        <div class="table-responsive">

                                            <table class="table" width="100%">
                                         <thead>
                                         <th>Bill No</th>
                                         <th>Bill Date</th>
                                         <th>Total Amount</th>
                                         <th>Received Amount</th>
                                         <th>Balance</th>
                                         <th>Pay Now</th>
                                         </thead>
                                         <tbody id="data_pay">
                                             <tr>
                                                 <td></td>
                                             </tr>
                                         </tbody>
                                     </table>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <h4 id="tot_amt">Total Amount : 0.00</h4>                                                
                                            </div>
                                            <div class="col-md-3">
                                                <h4 id="rec_amt">Received Amount : 0.00</h4>
                                                <input type="hidden" id="rec_amt_hid" value="">
                                            </div>
                                            <div class="col-md-3">
                                                <h4 id="bal_amt">Balance Amount : 0.00</h4>
                                                <input type="hidden" id="bal_amt_hid" value="">
                                            </div>
                                            <div class="col-md-3">
                                                <input type="hidden" id="total_hid" name="total" value="0.00" />
                                                <input type="hidden" id="count_i" name="count_" value="" />
                                                <h4 id="show_total" style="float: right;">Total Amt : 0.00</h4>
                                            </div>
                                        </div>

                                    </div>
                                </div> 

                            </div>
                            <div class="container-fluit">
                                <div class="row bankdetails">
                                   <div class="col-md-3">
                                        <label>Pay Type <span style="color:#FF0000;">*</span></label>

                                        <select name="paytype" id="paytype" onchange="getcash(this.value)" class="form-control" required="required">
                                            <option value="">Select Type</option>
                                            <option value="1">Cash</option>
                                            <option value="2">Bank</option>
                                            </select>
                                    </div>
                                     <div class="col-md-3 bankdata" style="display:none" id="bank" >
                                        <label>Bank<span style="color:#FF0000;">*</span></label>
                                        <select class="form-control requireds"  name="bank">
                                            <option value="">Select Bank</option>
                                                                                        <option value="17">Dena Bank - CC</option>
                                                                                       <option value="18">Dena Bank - CA</option>
                                                                                       <option value="19">TMB - CA</option>
                                                                                   </select>      
                                    </div>
                                    <div class="col-md-3 bankdata" style="display:none" id="cheque" >
                                        <label>Cheque/DD/Transaction No<span style="color:#FF0000;">*</span></label>
                                        <input type="text" class="form-control requireds" placeholder="Cheque/DD/Transaction No" name="cheque"   value="" pattern="[a-z A-Z 0-9.,-]{0,100}" title="Allowed Attribute [a-z A-Z 0-9.,-]{0,100}" required="required"  />          
                                    </div>
                                    <div class="col-md-3 bankdata" style="display:none" id="date">
                                        <label>Date<span style="color:#FF0000;">*</span></label>
                                        <input type="text" class="form-control usedatepicker requireds" placeholder="Date" name="cdate"    value="" required="required"  />
                                    </div> 

                                </div> <br/> 
                                <div class="row">
                                     <div class="col-md-12 " id="textarea">
                                        <label>Description</label>
                                        <textarea  rows="6" class="form-control " col="80" name="desc"  ></textarea>
                                    </div></div>
                            </div>








                </div>
            </div>
                    </form>
                    </section><!-- /.content -->
                </div><!-- /.content-wrapper -->


                <?php include ('../../require/footer.php'); ?>
                <script>
                    function getsuptrans(a){
                       $.ajax({
                           type:"POST",
                           url:"<?php echo $sitename.'pages/master/userajax.php' ?>",
                           dataType: 'JSON',
                           data:{id:a,payment_cus:'get'},
                           success:function(data){                              
                             $('#data_pay').html(data['r']);
                             if(data['nodata'] != 1){
                             $('#tot_amt').html('Total Amount : ' + data['tot']);
                             $('#rec_amt_hid').val(data['rec']);
                             $('#rec_amt').html('Received Amount : ' + data['rec']);
                             $('#bal_amt_hid').val(data['bal']);
                             $('#bal_amt').html('Balance Amount : ' + data['bal']);
                             $('#count_i').val(data['count']);
                             }
                           },
                       }) ;
                    }
                    function getcash(a){
                      if(a == '2'){
                          $('.bankdata').show();
                      }else{
                          $('.bankdata').hide();
                      }    
                    }
                    function paynow1212(){                        
                      var count = $('#count_i').val();                    
                      var i = 1;
                      var tot_may = 0;
                      var rec_amt = $('#rec_amt_hid').val();
                      var bal_amt = $('#bal_amt_hid').val();                        
                      for(i = 1; i <= count; i++){
                        tot_may  += parseFloat($('#paynow' + i).val());
                      }
                      var tot_rec = rec_amt + tot_may;
                      var tot_bal = bal_amt - tot_may;
                      $('#rec_amt').html('Received Amount : ' + tot_rec);
                      $('#bal_amt').html('Balance Amount : ' + tot_bal);
                      $('#show_total').html('Total Amount : ' + tot_may);
                    }    
                </script>