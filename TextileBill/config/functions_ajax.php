<?php
$report = 1;
include 'config.inc.php';
global $db;

 if ($_REQUEST['category'] != '') {
	 
	 $nbays_brand = $db->prepare("SELECT * FROM `subcategory` WHERE `status`=? AND `category`=? ORDER BY `subcategory` ASC");
        $nbays_brand->execute(array(1, $_REQUEST['category']));

        $catnum = $nbays_brand->rowCount();
	
        if ($catnum > 0) {
           $cat1.='<option value="">Select the Subcategory</option>';
           while ($fetchcat = $nbays_brand->fetch(PDO::FETCH_ASSOC)) {
               
                $cat1.= '<option value="'.$fetchcat['id'].'">'.stripslashes($fetchcat['subcategory']).'</option>';
           }
        } else {
          
            $cat1.= '<option value="">--No Subcategory Available--</option>';
        } 
echo $cat1;
exit;		
 }
 if (($_REQUEST['ordermethod'] != '')) {
    //city list
    ?>
	<option value="">Select</option>
   <?php
       if($_REQUEST['ordermethod']=='1') {
            ?>
            <option value="1">Vendor Order</option>
			<option value="0">Phone Order</option>
            <?php
        } if($_REQUEST['ordermethod']=='2') {
            ?>
          <option value="1">Dinnig Order</option>
			<option value="0">Take Away</option>
        <?php } ?>
    
	
    <?php
}
if (($_REQUEST['country'] != '') && ($_REQUEST['state'] != '')) {
    //city list
    ?>

    <select class="form-control" name="city" id="city">
        <?php
        $nbays_brand = $db->prepare("SELECT * FROM `city` WHERE `status`!=? AND `CountryName`=? AND `State_name`=? ORDER BY `CityName` ASC");
        $nbays_brand->execute(array(2, $_REQUEST['country'], $_REQUEST['state']));

        $catnum = $nbays_brand->rowCount();
        if ($catnum > 0) {
            ?>
            <option value="">Select</option>
            <?php
            while ($fetchcat = $nbays_brand->fetch(PDO::FETCH_ASSOC)) {
                ?>
                <option value="<?php echo $fetchcat['CTID']; ?>"><?php echo stripslashes($fetchcat['CityName']); ?></option>
                <?php
            }
        } else {
            ?>
            <option value="">--No Cities Available--</option>
        <?php } ?>
    </select>
    <?php
} if (($_REQUEST['country'] != '') && ($_REQUEST['state'] == '')) {
    ?>

    <select class="form-control" name="state" id="state">
        <?php
        $nbays_brand = $db->prepare("SELECT * FROM `state` WHERE `status`!=? AND `CountryName`=?  ORDER BY `State_name` ASC");
        $nbays_brand->execute(array(2, $_REQUEST['country']));

        $catnum = $nbays_brand->rowCount();
        if ($catnum > 0) {
            ?>
            <option value="">Select</option>
            <?php
            while ($fetchcat = $nbays_brand->fetch(PDO::FETCH_ASSOC)) {
                ?>
                <option value="<?php echo $fetchcat['SID']; ?>"><?php echo stripslashes($fetchcat['State_name']); ?></option>
                <?php
            }
        } else {
            ?>
            <option value="">--No Cities Available--</option>
        <?php } ?>
    </select>
    <?php
}

if ($_POST['del_pro_image1'] == '1') {

    $updata = [];
    $updataname = [];
    $get1 = $db->prepare("SELECT * FROM `driver` WHERE `did`=?");

    $get1->execute(array($_POST['id']));
    $get = $get1->fetch();
    $db_img = $get['documents'];
    $db_nameimg = explode(',', $get['documentname']);
    $getimage_ar = explode(',', $db_img);
    foreach ($getimage_ar as $key => $img) {

        if ($img == $_POST['img']) {
            unlink('../../images/documents/' . $img);
        } else {
            $updataname[] = $db_nameimg[$key];
            $updata[] = $img;
        }
    }

    $updatares = implode(',', $updata);
    $updataresname = implode(',', $updataname);
    //$updatares1 = array_unique($updatares);
    //print_r($updataresname);
    //print_r($updatares);
    //exit;
    $update = $db->prepare(" UPDATE `driver` SET `documents`=?,`documentname`=? WHERE `did`=? ");
    $update->execute(array($updatares, $updataresname, $_POST['id']));
    echo 'suc';
}

if ($_POST['vgalleryid'] != '') {
    $data = FETCH_all("SELECT `title`,`content` FROM `vgallery` WHERE `gaid`=?", $_POST['vgalleryid']);
    if ($_POST['title'] != '') {
        echo $data['title'];
    } elseif ($_POST['desc'] != '') {
        echo stripslashes($data['content']);
    }
}

if (($_POST['room'] != '') && ($_POST['roomtype'] != '')) {
    $roomrecord = FETCH_all("SELECT * FROM `roomallocation` WHERE `alid`=?", $_POST['roomallocatedid']);
    $message .= '<div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" id="mtitle">Book Now - Room Number : ' . getrooms('room_number', $_REQUEST['room']) . '</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <label>Customer Mobile</label>
                        <div class="input-group">
                            <input type="text" name="bookingphone" id="bookingphone" class="form-control" value="' . $roomrecord['phone'] . '" />
                            <span class="input-group-addon" onclick="getcustomer(' . $_REQUEST['roomallocatedid'] . ');"><i class="fa fa-search"></i></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label>Select Customer</label>
                        <select name="bookingcustomer" id="bookingcustomer" class="form-control" onchange="getcustomer(' . $_REQUEST['roomallocatedid'] . ');">
                            <option value="">Select Customer</option>
                            ';
    $reg = pFETCH("SELECT * FROM `register` WHERE `status`=?", '1');
    while ($freg = $reg->fetch(PDO::FETCH_ASSOC)) {
        if ($freg['rid'] == $roomrecord['customer_id']) {
            $sel = 'selected';
        } else {
            $sel = '';
        }
        $message .= '<option value="' . $freg['rid'] . '" ' . $sel . '>' . $freg['name'] . ' ' . $freg['lname'] . ' - ' . $freg['phone'] . '</option>';
    }
    $message .= '
                        </select>
                    </div>
                </div>
                <div class="clearfix"><br /></div>
                <div class="row">
                    <div class="col-md-6">
                        <label>First Name</label>
                        <input type="text" name="bookingname" id="bookingname" class="form-control" value="' . $roomrecord['name'] . '" />
                    </div>
                    <div class="col-md-6">
                        <label>Last Name</label>
                        <input type="text" name="bookinglname" id="bookinglname" class="form-control" value="' . $roomrecord['lname'] . '" />
                    </div>
                </div>
                <div class="clearfix"><br /></div>
                <div class="row">
                    <div class="col-md-6">
                        <label>Email</label>
                        <input type="email" name="bookingmail" id="bookingmail" class="form-control" value="' . $roomrecord['email'] . '" />
                    </div>
                    <div class="col-md-6">
                        <label>Booking ID</label>
                        <input type="hidden" name="alid" id="alid" value="' . $_REQUEST['roomallocatedid'] . '" />
                        <input type="hidden" name="roomval" id="roomval" value="' . $_REQUEST['room'] . '" />
                        <input type="hidden" name="roomnumber" id="roomnumber" value="' . getrooms('room_number', $_REQUEST['room']) . '" />
                        <input type="hidden" name="roomtype" id="roomtype" value="' . $_REQUEST['roomtype'] . '" />
                        <div class="input-group">
                            <input type="text" name="booking_id" id="booking_id" class="form-control" value="' . $roomrecord['booking_id'] . '" />
                            <span class="input-group-addon" onclick="getcustomer1(' . $_REQUEST['roomallocatedid'] . ');"><i class="fa fa-search"></i></span>
                        </div>
                    </div>
                </div>
                <div class="clearfix"><br /></div>
                <div class="row">
                    <div class="col-md-12">
                        <label>Comments</label>
                        <textarea name="bookingcomments" id="bookingcomments" class="form-control">' . $roomrecord['comments'] . '</textarea>
                    </div>
                </div>
                <div class="clearfix"><br /></div>
                <div class="row">
                    <div class="col-md-6">
                        <label>Status</label>
                        <select name="status" id="status" class="form-control">
                            <option value="1" ';
    if ($roomrecord['status'] == '1') {
        $message .= 'selected';
    }
    $message .= '>Allocate</option>
                            <option value="2" ';
    if ($roomrecord['status'] == '2') {
        $message .= 'selected';
    }
    $message .= '>Block</option>
                        </select>
                    </div>
                    <div class="col-md-6 pull-right">
                        <button type="submit" name="bsubmit" id="bsubmit" class="btn btn-success">Allocate Now</button>
                    </div>
                </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>';
    echo $message;
}

if (($_POST['mobileid'] != '') || ($_POST['userid'] != '')) {
    if ($_POST['booking_id'] != '') {
        $cusid = FETCH_all("SELECT * FROM `booking` WHERE `booking_id`=?", $_POST['booking_id']);
        $register = FETCH_all("SELECT * FROM `register` WHERE `rid`=?", $cusid);
    } elseif ($_POST['userid'] != '') {
        $register = FETCH_all("SELECT * FROM `register` WHERE `rid`=? AND `status`=?", $_POST['userid'], '1');
    } elseif ($_POST['mobileid'] != '') {
        $register = FETCH_all("SELECT * FROM `register` WHERE `phone`=? AND `status`=?", $_POST['mobileid'], '1');
    }
    //echo "SELECT * FROM `register` WHERE `phone`='".$_POST['mobileid']."' AND `status`=1";
    if ($register['rid'] != '') {
        $roomrecord = FETCH_all("SELECT * FROM `roomallocation` WHERE `alid`=?", $_POST['roomallocatedid']);
        $message .= '<div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" id="mtitle">Book Now - Room Number : ' . getrooms('room_number', $_REQUEST['room']) . '</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <label>Customer Mobile</label>
                        <div class="input-group">
                            <input type="text" name="bookingphone" id="bookingphone" class="form-control" value="' . $register['phone'] . '" />
                            <span class="input-group-addon" onclick="getcustomer(' . $_REQUEST['roomallocatedid'] . ');"><i class="fa fa-search"></i></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label>Select Customer</label>
                        <select name="bookingcustomer" id="bookingcustomer" class="form-control" onchange="getcustomer(' . $_REQUEST['roomallocatedid'] . ');">
                            <option value="">Select Customer</option>
                            ';
        $reg = pFETCH("SELECT * FROM `register` WHERE `status`=?", '1');
        while ($freg = $reg->fetch(PDO::FETCH_ASSOC)) {
            if ($freg['rid'] == $register['rid']) {
                $sel = 'selected';
            } else {
                $sel = '';
            }
            $message .= '<option value="' . $freg['rid'] . '" ' . $sel . '>' . $freg['name'] . ' ' . $freg['lname'] . ' - ' . $freg['phone'] . '</option>';
        }
        $message .= '
                        </select>
                    </div>
                </div>
                <div class="clearfix"><br /></div>
                <div class="row">
                    <div class="col-md-6">
                        <label>First Name</label>
                        <input type="text" name="bookingname" id="bookingname" class="form-control" value="' . $register['name'] . '" />
                    </div>
                    <div class="col-md-6">
                        <label>Last Name</label>
                        <input type="text" name="bookinglname" id="bookinglname" class="form-control" value="' . $register['lname'] . '" />
                    </div>
                </div>
                <div class="clearfix"><br /></div>
                <div class="row">
                    <div class="col-md-6">
                        <label>Email</label>
                        <input type="email" name="bookingmail" id="bookingmail" class="form-control" value="' . $register['email'] . '" />
                    </div>
                    <div class="col-md-6">
                        <label>Booking ID</label>
                        <input type="hidden" name="alid" id="alid" value="' . $_REQUEST['roomallocatedid'] . '" />
                        <input type="hidden" name="roomval" id="roomval" value="' . $_REQUEST['room'] . '" />
                        <input type="hidden" name="roomnumber" id="roomnumber" value="' . getrooms('room_number', $_REQUEST['room']) . '" />
                        <input type="hidden" name="roomtype" id="roomtype" value="' . $_REQUEST['roomtypes'] . '" />
                        <div class="input-group">
                            <input type="text" name="booking_id" id="booking_id" class="form-control" value="' . $roomrecord['booking_id'] . '" />
                            <span class="input-group-addon" onclick="getcustomer1(' . $_REQUEST['roomallocatedid'] . ');"><i class="fa fa-search"></i></span>
                        </div>
                    </div>
                </div>
                <div class="clearfix"><br /></div>
                <div class="row">
                    <div class="col-md-12">
                        <label>Comments</label>
                        <textarea name="bookingcomments" id="bookingcomments" class="form-control"></textarea>
                    </div>
                </div>
                <div class="clearfix"><br /></div>
                <div class="row">
                    <div class="col-md-6">
                        <label>Status</label>
                        <select name="status" id="status" class="form-control">
                            <option value="1" ';
        if ($roomrecord['status'] == '1') {
            $message .= 'selected';
        }
        $message .= '>Allocate</option>
                            <option value="2" ';
        if ($roomrecord['status'] == '2') {
            $message .= 'selected';
        }
        $message .= '>Block</option>
                        </select>
                    </div>
                    <div class="col-md-6 pull-right">
                        <button type="submit" name="bsubmit" id="bsubmit" class="btn btn-success">Allocate Now</button>
                    </div>
                </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>';
        echo $message;
    } else {
        echo 'new';
    }
}

if ($_POST['auser'] != '') {
    $chk = FETCH_all("SELECT `id` FROM `users` WHERE `val1`=?", $_POST['auser']);
    if ($chk['id'] != '') {
        echo 'Username Already Exists';
    } else {
        echo 'Username Available';
    }
}

if ($_POST['popupadv'] == '1') {
    $_SESSION['adpopclose'] = '1';
}

if (($_REQUEST['image'] != '') && ($_REQUEST['id'] != '') && ($_REQUEST['table'] != '') && ($_REQUEST['path'] != '') && ($_REQUEST['images'] != '') && ($_REQUEST['pid'] != '')) {

    if (is_dir($_REQUEST['path'] . 'thump/')) {
        unlink($_REQUEST['path'] . 'thump/' . $_REQUEST['image']);
    }
    if (is_dir($_REQUEST['path'] . 'big/')) {
        unlink($_REQUEST['path'] . 'big/' . $_REQUEST['image']);
    }
    if (is_dir($_REQUEST['path'] . 'small/')) {
        unlink($_REQUEST['path'] . 'small/' . $_REQUEST['image']);
    }

    unlink($_REQUEST['path'] . $_REQUEST['image']);

    $updateimg = $db->prepare("UPDATE `" . $_REQUEST['table'] . "` SET `" . $_REQUEST['images'] . "`=? WHERE `" . $_REQUEST['pid'] . "`=?");
    $updateimg->execute(array('', $_REQUEST['id']));

    /* $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`,`info`) VALUES (?,?,?,?,?,?,?)");
      $htry->execute(array($_REQUEST['table'], 9, 'Delete', $_SESSION['UID'], $_SERVER['REMOTE_ADDR'], $_REQUEST['id'], 'Image Deletion')); */

    echo '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-close"></i>Succesfully Deleted</h4></div>';
}

if ($_REQUEST['delimag'] != '') {
    $sel1 = $db->prepare("SELECT * FROM `imageup` WHERE `aiid`=?");
    $sel1->execute(array($_REQUEST['delimag']));
    $sel = $sel1->fetch();
    unlink("../../images/imageup/" . $sel['image']);

    $get = $db->prepare("DELETE FROM `imageup` WHERE `aiid` =? ");
    $get->execute(array(trim($_REQUEST['delimag'])));

    echo '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-close"></i>Succesfully Deleted, Image will be deleted in few seconds</h4></div>';

    echo '<meta http-equiv="refresh" content="3;url=' . $sitename . 'others/viewimage.htm/' . '">';
    exit;
}


if ($_REQUEST['newssubmit'] != '') {
    @extract($_REQUEST);
    $ip = $_SERVER['REMOTE_ADDR'];

    $msgg = addsubscribe($_REQUEST['newssubmit'], $ip);
    echo $msgg;
}

if ($_REQUEST['changestate'] != '') {
    @extract($_REQUEST);
    ?>
    <select name="shipcity" id="shipcity" required="required" class="form-control" >
        <option value="">Select City</option>
        <?php
        $cst = pFETCH("SELECT * FROM `shipping_city` WHERE `status`=? AND `ship_state`=?", '1', $changestate);
        while ($fcst = $cst->fetch(PDO::FETCH_ASSOC)) {
            ?>
            <option value="<?php echo $fcst['scid']; ?>"><?php echo $fcst['shipping_city']; ?></option>
            <?php
        }
        ?>
    </select>
    <?php
}

if ($_POST['attribute']) {
    $nbays_attribute = $db->prepare("SELECT * FROM `subcategory` WHERE `scid`=?");
    $nbays_attribute->execute(array($_POST['attribute']));
    $checkcat = $nbays_attribute->fetch(PDO::FETCH_ASSOC);
    // $checkcat = DB_QUERY("SELECT * FROM `subcategory` WHERE `scid`='" . $_POST['attribute'] . "'");
    if ($checkcat['attributeset'] != '') {
        ?>
        <div class="panel" style="width: 100%; margin-bottom: 10px;  alignment-baseline: central">
            <div class="panel-heading" style="background-color:#f95483">
                <div class="panel-title" style="font-size:25px;color:white;font-weight:bold;">
                    Specification(s)
                </div></div>
        </div>
        <div class="panel panel-info" style="width: 100%;  alignment-baseline: central">
            <div class="panel-body color">
                <div class="row">
                    <?php
                    $serve = explode(',', $checkcat['attributeset']);
                    if (count($serve) > 0) {
                        $y = 0;
                        foreach ($serve as $i => $servicesname) {
                            $nbays_attribute_type = $db->prepare("SELECT * FROM `attributetype` where `attribute`=?");
                            $nbays_attribute_type->execute(array($servicesname));
                            //  $attrtype = DB("SELECT * FROM `attributetype` where `attribute`='" . $servicesname . "'");
                            while ($rescheck = $nbays_attribute_type->fetch(PDO::FETCH_ASSOC)) {
                                $attvalue = explode(',', $rescheck['value']);
                                $y++;
                                ?>
                                <div class="col-md-6">
                                    <select  id="attvalue" name="attvalue[]">
                                        <option value="">Select <?php echo $rescheck['attributtitle']; ?></option>
                                        <?php
                                        $attrval = explode(',', $rescheck['value']);
                                        foreach ($attrval as $i => $j) {
                                            ?>
                                            <option value="<?php echo $rescheck['attributtitle'] . '###' . $j; ?>"><?php echo $j; ?></option>  
                                        <?php } ?>     
                                    </select>
                                </div>
                                <?php
                                if ($y == '2') {
                                    echo '</div><br /><div class="row">';
                                    $y = '0';
                                }
                            }
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
        <?php
    }
}
if ($_POST['attribute1']) {
    $nbays_attribute1 = $db->prepare("SELECT * FROM `subcategory` WHERE `scid`=?");
    $nbays_attribute1->execute(array($_POST['attribute1']));
    $checkcat = $nbays_attribute1->fetch(PDO::FETCH_ASSOC);
    // $checkcat = DB_QUERY("SELECT * FROM `subcategory` WHERE `scid`='" . $_POST['attribute1'] . "'");
    if ($checkcat['attributeset'] != '') {
        ?> <div class="panel panel-info">
            <div class="panel-heading">
                <div class="panel-title">Specification(s)</div>
            </div>
            <div class="panel-body">

                <div class="row">
                    <?php
                    $serve = explode(',', $checkcat['attributeset']);
                    if (count($serve) > 0) {
                        $y = 0;
                        foreach ($serve as $i => $servicesname) {
                            $nbays_attribute1_type = $db->prepare("SELECT * FROM `attributetype` where `attribute`=?");
                            $nbays_attribute1_type->execute(array($servicesname));
                            //  $attrtype = DB("SELECT * FROM `attributetype` where `attribute`='" . $servicesname . "'");
                            while ($rescheck = $nbays_attribute1_type->fetch(PDO::FETCH_ASSOC)) {
                                $attvalue = explode(',', $rescheck['value']);
                                $y++;
                                ?>
                                <div class="col-md-6">
                                    <select class="form-control" id="attvalue" name="attvalue[]">
                                        <option value="">Select <?php echo $rescheck['attributtitle']; ?></option>
                                        <?php
                                        $attrval = explode(',', $rescheck['value']);
                                        foreach ($attrval as $i => $j) {
                                            ?>
                                            <option value="<?php echo $rescheck['attributtitle'] . '###' . $j; ?>"><?php echo $j; ?></option>  
                                        <?php } ?>     
                                    </select>
                                </div>
                                <?php
                                if ($y == '2') {
                                    echo '</div><br /><div class="row">';
                                    $y = '0';
                                }
                            }
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
        <?php
    }
}
if ($_POST['cur'] != '') {
    $_SESSION['FRONT_WEB_CURRENCY'] = $_POST['cur'];
    echo json_encode(array('suc'));
    exit;
}
if ($_REQUEST['reset_id']) {

    $reset = $db->prepare("UPDATE `bill_settings` SET `current_value`=? WHERE `id`=? ");
    $reset->execute(array('1', $_REQUEST['reset_id']));

    $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i> Successfully Reseted!</h4></div>';

    echo $res;
}
if (($_REQUEST['orderstatus'] != '') && ($_REQUEST['orderid'] != '')) {
    $norder = FETCH_all("SELECT * FROM `norder` WHERE `oid`=?", $_REQUEST['orderid']);

    $general = FETCH_all("SELECT * FROM `manageprofile` WHERE `pid` = ?", '1');

    $from = $general['recoveryemail'];

    pFETCH("UPDATE `norder` SET `order_status`=? WHERE `oid`=?", $_REQUEST['orderstatus'], $_REQUEST['orderid']);

    if ($_REQUEST['orderstatus'] == '0') {
        $ostatus = 'Awaiting for Payment';
    } elseif ($_REQUEST['orderstatus'] == '1') {
        $ostatus = 'Awaiting Fulfillment';
    } elseif ($_REQUEST['orderstatus'] == '2') {
        $ostatus = 'Completed';
    } elseif ($_REQUEST['orderstatus'] == '3') {
        $ostatus = 'Cancelled';
    } elseif ($_REQUEST['orderstatus'] == '4') {
        $ostatus = 'Declined';
    } elseif ($_REQUEST['orderstatus'] == '5') {
        $ostatus = 'Refunded';
    } elseif ($_REQUEST['orderstatus'] == '6') {
        $ostatus = 'Partially Refunded';
    }

    if ($norder['guest'] == '1') {
        $name = getguest1('email', $norder['CusID']) . ' ( Guest )';
        $cemail = getguest1('email', $norder['CusID']);
    } else {
        $name = getcustomer1('FirstName', $norder['CusID']);
        $cemail = getcustomer1('E-mail', $norder['CusID']);
    }

    $to = $cemail;

    $subject = 'Your Everest Gifts Order Has Been Updated ' . $norder['order_id'];

    $mailcontent = '<table style="width:600px; font-family:arial; font-size:13px;" cellpadding="0" cellspacing="0">
                <tr>
                    <td><h2 style="color:#cc6600; border-bottom:1px solid #cc6600;">Order Status Changed</h2></td>
                </tr>
                <tr>
                    <td><p><b>Hi ' . $name . '</b>,</p><p>An order you recently placed on our website has had its status changed.</p><p>The status of order ' . $norder['order_id'] . ' is now ' . $ostatus . '</p></td>
                </tr>
                <tr>
                    <td>
                        <table style="width:100%; border-bottom:1px solid #cc6600; padding:2%; font-size:13px;" cellpadding="0" cellspacing="0">
                            <tr>
                                <td width="60%;" align="left">
                                    <h4>Order Number : ' . $norder['order_id'] . '</h4>
                                    <p>Order Date : ' . date('d-M-Y H:i:s A', strtotime($norder['datetime'])) . '</p>
                                    <p>Payment Method : ' . $norder['payment_mode'] . '</p>
                                    <h4>Currency : ' . $norder['currency'] . '</h4>
                                </td>
                                <td width="40%;">
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table style="width:100%; border-bottom:1px solid #cc6600; padding:2%; font-size:13px;" cellpadding="0" cellspacing="0">
                            <tr>
                                <td width="50%;">
                                    <a href="http://www.everestgifts.com.au/" target="_blank">Everest Gifts</a>
                                </td>
                                <td width="50%;" align="right"></td>
                        </table>
                    </td>
                </tr>
            </table>';

    if ($_REQUEST['sendmail'] == '1') {
        //Customer Email
        sendoldmail($subject, $mailcontent, $from, $to);
    }
    echo '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fa fa-check"></i> Order Updated Successfully!!! </div>';
}
if ($_POST['del_contact_id'] != '') {
    $del_rec = $db->prepare("DELETE FROM `contact_informations` WHERE `id`=?");
    $del_rec->execute(array($_POST['del_contact_id']));
    echo 'suc';
}



?>
