<?php
include ('../../config/config.inc.php');

// echo "SELECT * FROM `loan` WHERE `status`='1' AND `id` ='". $_REQUEST['receiptno']."' ";
if ($_REQUEST['loanid'] != '') {

    $receiptlist = FETCH_ALL("SELECT * FROM `loan` WHERE `status`=? AND `id` =? ", '1', $_REQUEST['loanid']);
    ?>

    <div class="row">
        <!--<input type="text" name="currdate" id="currdate" value=""/>-->
        <div class="col-md-4">
            <label>Date of Pawn<span style="color:#FF0000;">*</span></label>
            <div class="input-group date">
                <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                </div>
                <input type="text" class="form-control pull-right usedatepicker" name="date" id="date" required="required"  value="<?php
                if (isset($_REQUEST['loanid'])) {
                    echo date('d-m-Y', strtotime($receiptlist['date']));
                } else {
                    echo date('d-m-Y');
                }
                ?>" >
            </div>  
        </div>
        <div class="col-md-4">
            <label>Name <span style="color:#FF0000;">*</span></label>
            <input type="text"  required="required" name="name" id="name" placeholder="Enter Name" class="form-control" value="<?php echo $receiptlist['name'] ?>" />
        </div>
        <div class="col-md-4">
            <label>Mobile Number <span style="color:#FF0000;">*</span></label>
            <input type="text" required="required" name="mobileno" id="mobileno" placeholder="Enter Mobile Number" class="form-control" value="<?php echo $receiptlist['mobileno']; ?>" maxlength="10"/>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-4">
            <label>Object <span style="color:#FF0000;"></span></label>
            <textarea name="objectname" id="objectname" class="form-control"><?php
//                $customerlist = FETCH_all("SELECT * FROM `loan` WHERE `status`=? AND `receipt_no` =? AND `returnstatus`=? ", '1', $_REQUEST['receiptno'], '1');
//            echo $cutomerlist['id'].'<br>';
                $i = 1;
                $objectlist = $db->prepare("SELECT * FROM `object_detail` WHERE `status`=? AND `object_id` =?");
                $objectlist->execute(array('1',$_REQUEST['loanid']));
                $count = $objectlist->rowcount();
                while ($objectfetch = $objectlist->fetch(PDO::FETCH_ASSOC)) {
                    echo getobject('objectname', $objectfetch['object']) . ' - ' . $objectfetch['quantity'];
                    if ($i == $count) {
                        echo '';
                    } else {
                        echo ',';
                    }
                    $i++;
                }
                ?>  </textarea>
        </div>
        <div class="col-md-4">
            <label>Net Weight (in gms) <span style="color:#FF0000;"></span></label>
            <input type="text"  required="required" name="netweight" id="netweight" placeholder="Enter Net Weight" class="form-control" value="<?php echo $receiptlist['netweight']; ?>"/>
        </div>
        <div class="col-md-4">
            <label>Amount <span style="color:#FF0000;"></span></label>
            <input type="text" required="required" name="amount" id="amount" placeholder="Enter Amount" class="form-control" value="<?php echo $receiptlist['amount']; ?>" onchange="amountvalue()"/>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-4">
            <label>Interest Percent<span style="color:#FF0000;"></span></label>
            <input type="text" id="interestpercent"  name="interestpercent" placeholder="Enter Interest Percent" class="form-control" value="<?php echo $receiptlist['interestpercent']; ?>" />
        </div>
        <div class="col-md-4">
            <label>Interest <span style="color:#FF0000;"></span></label>
            <input type="text" id="interest"  name="interest" placeholder="Enter Interest Amount" class="form-control" value="<?php echo $receiptlist['interest']; ?>" />
            <!-- pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" -->
        </div>
        <div class="col-md-4">
            <label>Status <span style="color:#FF0000;">*</span></label>                                  
            <select name="status" class="form-control">
                <option value="1" <?php
                if (stripslashes($receiptlist['interest'] == '1')) {
                    echo 'selected';
                }
                ?>>Pawned</option>
                <option value="0" <?php
                if (stripslashes($receiptlist['interest'] == '0')) {
                    echo 'selected';
                }
                ?>>Returned</option>

            </select>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-4">
            <label>Pawn Days <span style="color:#FF0000;">*</span></label>
            <input type="text" id="pawndays"  name="pawndays" class="form-control" value="<?php echo $dateDiff; ?>" onchange="pawndays()" />
        </div>
    </div>
    <br>
    <div class="panel panel-info">
        <div class="panel-heading" style="background-color: #d9f7df;">Calculation</div>
        <div class="panel-body">
            <div class="col-md-4">
                <label>Interest <span style="color:#FF0000;">*</span></label>
                <input type="text" required="required" id="interestvalue"  name="interestvalue" class="form-control" value="<?php echo $receiptlist['interest']; ?>" />
            </div>
            <div class="col-md-4">
                <label>Days <span style="color:#FF0000;">*</span></label>
                <input type="text" required="required" id="days"  name="days" class="form-control" value="<?php echo $dateDiff; ?>" />
            </div>
            <div class="col-md-4">
                <label>Total Interest<span style="color:#FF0000;">*</span></label>
                <input type="text" required="required" id="totalinterest"  name="totalinterest" class="form-control" value="<?php echo $receiptlist['totalinterest']; ?>" />
            </div>
            <div class="col-md-4">
                <label>PAmount <span style="color:#FF0000;">*</span></label>
                <input type="text" required="required" id="amountvalue"  name="amountvalue" class="form-control" value="<?php echo $receiptlist['amount']; ?>" />
            </div>
            <div class="col-md-4">
                <label>Final Pay <span style="color:#FF0000;">*</span></label>
                <input type="text" required="required" id="finalpay"  name="finalpay" class="form-control" value="<?php echo $receiptlist['finalpay']; ?>" />
            </div>
        </div>
    </div>

    <?php
}
?>
<script>
    $('.usedatepicker').datepicker({
        autoclose: true
    });
    function roundToTwo(num) {    
    return +(Math.round(num + "e+2")  + "e-2");
}

    function final_pay(a) {

        var d = document.getElementById('date').value;
        var current_date = a;
        from = moment(d, 'DD-MM-YYYY'); // format in which you have the date
        to = moment(current_date, 'DD-MM-YYYY');
        var resultdate = to.diff(from, 'days');
//        var resultdate = Math.abs(different / 86400);
        $('#days').val(resultdate);
        $('#pawndays').val(resultdate);

//        alert(current_date);
//        var days = $('#days').val();
        var amount = $('#amount').val();
        var interest = $('#interest').val();
        var interestminus = (amount - interest);
        var interesrperday = (interestminus / 30);
        var totalinterest = interesrperday * resultdate;
        document.getElementById('totalinterest').value = roundToTwo(totalinterest);
        var finalamount = +totalinterest + +amount;
//                alert(finalamount);
        document.getElementById('finalpay').value = roundToTwo(finalamount);


//         document getElementById('currdate').value = current_date;
    }
//    function dateDiffInDays(date1, date2) {
//        // Calulating the difference in timestamps 
//        var dateobj = new Date(date1); 
//        alert(date1);
//        var dateobj1 = new Date(date2); 
//        var diff = dateobj.toTimeString() - dateobj1.toTimeString();
//        var resultdate = Math.abs(diff / 86400);
//        // 1 day = 24 hours 
//        // 24 * 60 * 60 = 86400 seconds 
//        return resultdate;
//    }
</script>

