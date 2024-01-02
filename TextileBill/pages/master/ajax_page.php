<?php
include ('../../config/config.inc.php');


if ($_REQUEST['customerid'] != '') {
    
    // echo $_REQUEST['incharge'];
    $customerlist = FETCH_all("SELECT * FROM `customer` WHERE `status`=? AND `id` =? ", '1', $_REQUEST['customerid']);
    ?>
    
    
            <div class="col-md-4">
                <label>Customer Name <span style="color:#FF0000;">*</span></label>
                <input type="text" name="name" id="name" class="form-control" value="<?php echo $customerlist['name']; ?>" />
            </div>
            <div class="col-md-4">
                <label>Mobile Number <span style="color:#FF0000;">*</span></label>
                <input type="text" name="mobileno" id="mobileno" class="form-control" value="<?php echo $customerlist['mobileno'];?>" />
            </div>
            <div class="col-md-4">
                <label>Address <span style="color:#FF0000;">*</span></label>
                <textarea name="address" id="address" class="form-control" ><?php echo $customerlist['address']; ?></textarea>
            </div>

            <!-- <p>  Name : <?php echo $customerlist['title'] . '.' . $customerlist['officername']; ?></p>
            <p>  Phone Number: <?php echo $customerlist['phonenumber']; ?></p>
            <p> Station / Unit : <?php echo $customerlist['station']; ?></p> -->

    
    <?php
}
?>

