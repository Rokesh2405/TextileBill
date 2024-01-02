<?php
$report = 1;
include 'config.inc.php';
//echo 'yes';
global $db;

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
    } elseif ($_REQUEST['country'] != '') {
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
    } elseif (($_REQUEST['image'] != '') && ($_REQUEST['id'] != '') && ($_REQUEST['table'] != '') && ($_REQUEST['path'] != '') && ($_REQUEST['images'] != '') && ($_REQUEST['pid'] != '')) {

        unlink($_REQUEST['path'] . $_REQUEST['image']);
        $updateimg = $db->prepare("UPDATE `" . $_REQUEST['table'] . "` SET `" . $_REQUEST['images'] . "`=? WHERE `" . $_REQUEST['pid'] . "`=?");
        $updateimg->execute(array('', $_REQUEST['id']));
        $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`,`info`,`company_id`) VALUES (?,?,?,?,?,?,?,?)");
        $htry->execute(array('Manage Profile', 9, 'Delete', $_SESSION['UID'], $_SERVER['REMOTE_ADDR'], $_REQUEST['id'], 'Image Deletion', $_SESSION['COMPANY_ID']));
        echo '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-close"></i>Succesfully Deleted</h4><!--<a href="' . $sitename . 'settings/adddepartment.htm">Add another one</a>--></div>';
    } elseif (($_REQUEST['stimgname'] != '') && ($_REQUEST['id'] != '')) {
        unlink("../pages/master/images/advertisment/" . $_REQUEST['stimgname']);

        $updateimg = $db->prepare("UPDATE `create_ads` SET `images`=REPLACE(images,'" . $_REQUEST['stimgname'] . "','') WHERE `id`='" . $_REQUEST['id'] . "'");
        $updateimg->execute();
        $htry = $db->prepare("INSERT `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`,`info`,`company_id`) VALUES (?,?,?,?,?,?,?,?)");
        $htry->execute(array('Stock Entry Point', 18, 'Delete', $_SESSION['UID'], $_SERVER['REMOTE_ADDR'], $_REQUEST['id'], 'Image Deletion', $_SESSION['COMPANY_ID']));
        echo '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-close"></i>Succesfully Deleted</h4><!--<a href="' . $sitename . 'settings/adddepartment.htm">Add another one</a>--></div>';
    } elseif (($_REQUEST['a'] != '') && ($_REQUEST['b'] != '') && ($_REQUEST['c'] != '')) {
        unlink("../pages/master/images/" . $_REQUEST['a']);
        $updateimg = $db->prepare("UPDATE `itemsmaster` SET `image`=? WHERE `iid`=?");
        $updateimg->execute(array('', $_REQUEST['c']));
        $htry = $db->prepare("INSERT `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`,`info`) VALUES (?,?,?,?,?,?,?)");
        $htry->execute(array('Items Master', 9, 'Delete', $_SESSION['UID'], $_SERVER['REMOTE_ADDR'], $_REQUEST['c'], 'Image Deletion'));
        echo '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-close"></i>Succesfully Deleted</h4><!--<a href="' . $sitename . 'settings/adddepartment.htm">Add another one</a>--></div>';
    } elseif (($_REQUEST['a'] != '') && ($_REQUEST['b'] != '') && ($_REQUEST['c'] != '')) {

        unlink("../../images/company/logo" . $_REQUEST['a']);
        $updateimg = $db->prepare("UPDATE `company` SET `image`=? WHERE `comid`=?");
        $updateimg->execute(array('', $_REQUEST['b']));
        $htry = $db->prepare("INSERT `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`,`info`) VALUES (?,?,?,?,?,?,?)");
        $htry->execute(array('company Master', 9, 'Delete', $_SESSION['UID'], $_SERVER['REMOTE_ADDR'], $_REQUEST['c'], 'Image Deletion'));
        echo '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-close"></i>Succesfully Deleted</h4><!--<a href="' . $sitename . 'settings/adddepartment.htm">Add another one</a>--></div>';
    } elseif (($_REQUEST['a'] != '') && ($_REQUEST['b'] != '')) {
        unlink("../pages/master/images/" . $_REQUEST['a']);
        $updateimg = $db->prepare("UPDATE `vehiclemaster` SET `image`=? WHERE `vid`=?");
        $updateimg->execute(array('', $_REQUEST['b']));
        $htry = $db->prepare("INSERT `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`,`info`) VALUES (?,?,?,?,?,?,?)");
        $htry->execute(array('Vehicle Master', 32, 'Delete', $_SESSION['UID'], $_SERVER['REMOTE_ADDR'], $_REQUEST['c'], 'Image Deletion'));
        echo '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-close"></i>Succesfully Deleted</h4><!--<a href="' . $sitename . 'settings/adddepartment.htm">Add another one</a>--></div>';
    } elseif (($_REQUEST['a'] != '') && ($_REQUEST['b'] != '')) {
        unlink("../pages/master/images/" . $_REQUEST['a']);
        $updateimg = $db->prepare("UPDATE `employeemaster` SET `image`=? WHERE `eid`=?");
        $updateimg->execute(array('', $_REQUEST['b']));
        $htry = $db->prepare("INSERT `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`,`info`) VALUES (?,?,?,?,?,?,?)");
        $htry->execute(array('Employee Master', 13, 'Delete', $_SESSION['UID'], $_SERVER['REMOTE_ADDR'], $_REQUEST['c'], 'Image Deletion'));
        echo '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-close"></i>Succesfully Deleted</h4><!--<a href="' . $sitename . 'settings/adddepartment.htm">Add another one</a>--></div>';
    } elseif (($_REQUEST['thumpnamestoc'] != '') && ($_REQUEST['id'] != '')) {
        unlink("../pages/stock/stockentry/thump/" . $_REQUEST['thumpnamestoc']);
        $updateimg = $db->prepare("UPDATE `stock_entry` SET `dri_thumb`=? WHERE `sid`=?");
        $updateimg->execute(array('', $_REQUEST['id']));
        $htry = $db->prepare("INSERT `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`,`info`) VALUES (?,?,?,?,?,?,?)");
        $htry->execute(array('Stock Entry Point', 18, 'Delete', $_SESSION['UID'], $_SERVER['REMOTE_ADDR'], $_REQUEST['id'], 'Thump Image Deletion'));
        echo '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-close"></i>Succesfully Deleted</h4><!--<a href="' . $sitename . 'settings/adddepartment.htm">Add another one</a>--></div>';
    } elseif ($_REQUEST['mid'] != '') {
        ?>
    <select class="form-control" name="brand" id="brand">
    <?php
    $nbays_brand = $db->prepare("SELECT * FROM `brand` WHERE `status`!=? AND `manufacture`=? AND `company_id`=? ORDER BY `order` ASC");
    $nbays_brand->execute(array(2, $_REQUEST['mid'], $_SESSION['COMPANY_ID']));

    $catnum = $nbays_brand->rowCount();
    if ($catnum > 0) {
        ?>
            <option value="">Select the Brand</option>
        <?php
        while ($fetchcat = $nbays_brand->fetch(PDO::FETCH_ASSOC)) {
            ?>
                <option value="<?php echo $fetchcat['bid']; ?>"><?php echo stripslashes($fetchcat['brandname']); ?></option>
                <?php
            }
        } else {
            ?>
            <option value="">--No Brands Available--</option>
        <?php } ?>
    </select>
    <?php
    }

    if ($_REQUEST['gid'] != '') {
        ?>
    <select class="form-control" name="subgroup" id="subgroup">
        <?php
        $nbays_subgroup = $db->prepare("SELECT * FROM `subgroupmaster` WHERE `status`!=? AND `group_id`=? ORDER BY `order` ASC");
        $nbays_subgroup->execute(array(2, $_REQUEST['gid']));

        $catnum = $nbays_subgroup->rowCount();
        if ($catnum > 0) {
            ?>
            <option value="">Select the Sub Group</option>
            <?php
            while ($fsel = $nbays_subgroup->fetch(PDO::FETCH_ASSOC)) {
                ?>
                <option value="<?php echo $fsel['gid']; ?>"><?php echo stripslashes($fsel['subgroup']); ?></option>
                <?php
            }
        } else {
            ?>
            <option value="">--No Sub group Available--</option>
        <?php } ?>
    </select> 
    <?php
    }

    if ($_REQUEST['desid'] != '') {
        ?>
    <select class="form-control" name="designation" id="designation">
        <?php
        $nbays_designation = $db->prepare("SELECT * FROM `designation` WHERE `status`!=? AND `department_id`=? AND `company_id`=?  ORDER BY `order` ASC");
        $nbays_designation->execute(array(2, $_REQUEST['desid'], $_SESSION['COMPANY_ID']));
        $catnum = $nbays_designation->rowCount();

        if ($catnum > 0) {
            ?>
            <option value="">Select the Designation</option>
            <?php
            while ($fsel = $nbays_designation->fetch(PDO::FETCH_ASSOC)) {
                ?>
                <option value="<?php echo $fsel['id']; ?>"><?php echo stripslashes($fsel['designation']); ?></option>
                <?php
            }
        } else {
            ?>
            <option value="">--No Designation Available--</option>
        <?php } ?>
    </select> 
        <?php
    }

    if ($_REQUEST['src'] == 'attendance') {
        ?>
    <select class="form-control" name="empname" id="empname" required>
        <option value="">All Employees </option>
    <?php
    $nbays_employeename = $db->prepare("SELECT * FROM `employeemaster` WHERE `status`!=? AND `sitelocid`=?");
    $nbays_employeename->execute(array(2, $_REQUEST['a']));

    while ($fsel = $nbays_employeename->fetch(PDO::FETCH_ASSOC)) {
        ?>
            <option value="<?php echo $fsel['emp_id']; ?>"
            <?php
            if ($fsel['emp_id'] == $_REQUEST['emp_id']) {
                echo 'selected="selected"';
            }
            ?>><?php echo stripslashes($fsel['empname'] . ' - (' . $fsel['emp_id'] . ')'); ?></option>
        <?php } ?>
    </select>
        <?php
    }
    if ($_REQUEST['auser'] != '') {
        $uname = trim($_REQUEST['auser']);
        $aname = trim($_REQUEST['auser']);
        $nbays_auser = $db->prepare("SELECT `username` FROM `usermaster` WHERE `status`!=? AND trim(`username`)=? UNION ALL SELECT `val1` as `username` FROM `users` WHERE trim(`val1`)=? ");
        $nbays_auser->execute(array(2, $uname, $aname));
        $sel = $nbays_auser->rowCount();

        if ($sel > 0) {

            echo "<div style='padding:10px !important;height:40px' class='alert alert-danger alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button><i class='icon fa fa-close'></i>User name already exist.</div><input type='hidden' name='auser' id='usav' value='1' />";
        } else {
            echo "<div style='padding:10px !important;height:40px' class='alert alert-success alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button><i class='icon fa fa-check'></i>User name available.</div><input type='hidden' name='auser' id='usav' value='0' />";
        }
    }
//sub category
    if ($_REQUEST['subid'] != '') {
        ?>
    <select class="form-control" name="subcategoryname" id="subcategoryname">
    <?php
    $s = '';
    if ($_REQUEST['subid'] != '') {
        $s = "AND FIND_IN_SET('" . $_REQUEST['subid'] . "',`category`) ";
    } else {
        $s = '';
    }
    $k = '';
    if ($_REQUEST['stype'] != '') {
        if ($_REQUEST['stype'] == '0') {
            $tt = '3';
        } elseif ($_REQUEST['stype'] == '1') {
            $tt = '4';
        } elseif ($_REQUEST['stype'] == '2') {
            $tt = '5';
        } elseif ($_REQUEST['stype'] == '3') {
            $tt = '6';
        }
        $k = "AND FIND_IN_SET('" . $tt . "',`type`) ";
    } else {
        $k = '';
    }


    $cat = $db->prepare("SELECT * FROM `subcategory` WHERE `status`!='2' " . $s . $k . " ");
    $cat->execute();
    $catnum = ($cat->rowCount());
    if ($catnum > 0) {
        ?>
            <option value="">Select the Sub Category</option>
            <?php
            while ($fsel = $cat->fetch(PDO::FETCH_ASSOC)) {
                ?>
                <option value="<?php echo $fsel['scid']; ?>"><?php echo stripslashes($fsel['subcategoryname']); ?></option>
                <?php
            }
        } else {
            ?>
            <option value="">--No Sub Category Available--</option>
        <?php } ?>
    </select> 
        <?php
    }if ($_REQUEST['subcomid'] != '') {
        echo "SELECT * FROM `subcategory` WHERE `status`!='2' AND FIND_IN_SET('" . $_REQUEST['subcomid'] . "',`category`)";
        ?>
    <select class="form-control" name="subcategoryname" id="subcategoryname">
        <?php
        $nbays_subcategoryname = $db->prepare("SELECT * FROM `subcategory` WHERE `status`!=? AND FIND_IN_SET(?,`category`)");
        $nbays_subcategoryname->execute(array(2, $_REQUEST['subcomid']));
        $catnum = $nbays_subcategoryname->rowCount();
        if ($catnum > 0) {
            ?>
            <option value="">Select the Sub Category</option>
            <?php
            while ($fsel = $nbays_subcategoryname->fetch(PDO::FETCH_ASSOC)) {
                ?>
                <option value="<?php echo $fsel['scid']; ?>"><?php echo stripslashes($fsel['subcategoryname']); ?></option>
                <?php
            }
        } else {
            ?>
            <option value="">--No Sub Category Available--</option>
        <?php } ?>
    </select> 
        <?php
    }
    if ($_POST['mobile']) {

        $nbays_mobile = $db->prepare("SELECT * FROM `customer` WHERE `cusid`=?");
        $nbays_mobile->execute(array($_POST['mobile']));

        $fetchcat = $nbays_mobile->fetch(PDO::FETCH_ASSOC);
        $catnum = $nbays_mobile->rowCount();
        if ($catnum > 0) {
            ?>
        <div id="phonenumber">
            <label>Mobile Number <span style="color:#FF0000;">*</span></label>
            <input type="text" name="phonenumber"   class="form-control" placeholder="Enter The Mobile No"  autocomplete="off" required="required" value="<?php echo $fetchcat['phoneno']; ?>"/>
        </div>
        <?php
    }
}

if ($_POST['email']) {
    $nbays_email = $db->prepare("SELECT * FROM `customer` WHERE `cusid`=?");
    $nbays_email->execute(array($_POST['email']));
    $fetchcat = $nbays_email->fetch(PDO::FETCH_ASSOC);
    $catnum = $nbays_email->rowCount();

    if ($catnum > 0) {
        ?>
        <div id="email">
            <label>Email</label>
            <input type="email" name="email"  class="form-control" placeholder="Enter the Email"  minlength="6" maxlength="55" autocomplete="off" value="<?php echo $fetchcat['emailid']; ?>" />
        </div>
        <?php
    }
}
if ($_POST['addetails']) {
    $nbays_adddetails = $db->prepare("SELECT * FROM `company` WHERE `cusid`=?");
    $nbays_adddetails->execute(array($_POST['addetails']));
    $checkcat = $nbays_adddetails->fetch(PDO::FETCH_ASSOC);

    if ($checkcat['comid'] != '') {
        $nbays_companyid = $db->prepare("SELECT * FROM `company` WHERE `cusid`=?");
        $nbays_companyid->execute(array($_POST['addetails']));
        $catnum = $nbays_companyid->rowCount();
        $fetchcat = $nbays_companyid->fetch(PDO::FETCH_ASSOC);

        if ($catnum > 0) {
            ?>
            <div class="panel-body" id="addetails">
                <div class='row'>
                    <div class="col-md-4">
                        <label>Address <span style="color:#FF0000;">*</span></label>
                        <textarea name="Address2" id="autocomplete" required="required" class="form-control" placeholder="Enter The Address" onFocus="geolocate()"><?php echo $fetchcat['address']; ?></textarea>

                    </div>
                    <div class="col-md-2">
                        <label>Door No <span style="color:#FF0000;"></span></label>
                        <input type="text" class="form-control" placeholder="Enter The Door No" name="DoorNo" id="street_number"  
                               pattern="[0-9A-Za-z ,/.,-_':]{1,60}" title="Allowed Character (0-9 A-Za-z /.,-_':)" 
                               value="<?php echo $fetchcat['doorno']; ?>" />
                    </div>
                    <div class="col-md-3">

                        <label>Street Name</label>
                        <textarea name="Address1" id="route"  class="form-control" placeholder="Enter The Street Name"><?php echo $fetchcat['streetaddress']; ?></textarea>

                    </div>
                    <div class="col-md-3">
                        <label>District <span style="color:#FF0000;">*</span></label>
                        <input class="form-control" id="locality"  name="districtname" placeholder="Enter The District" value="<?php echo $fetchcat['districtname']; ?>"   />
                    </div>

                </div><br/><div class="row">
                    <div class="col-md-4">
                        <label>State <span style="color:#FF0000;">*</span></label>
                        <input class="form-control" id="administrative_area_level_1" name="state"  required="required" placeholder="Enter The State" value="<?php echo $fetchcat['state']; ?>" />

                    </div>

                    <div class="col-md-4">
                        <label>Post Code</label>
                        <input type="text" name="PostCode" id="postal_code"  class="form-control" pattern="[a-zA-Z ()0-9-]{3,20}" title="Allowed Characters (a-zA-Z ()0-9-)(3-20)"placeholder="Enter The Post Code" value="<?php echo $fetchcat['postcode']; ?>" />

                    </div>
                    <div class="col-md-4">
                        <label>Country <span style="color:#FF0000;">*</span></label>
                        <input class="form-control" id="country" name="Country" placeholder="Enter The Country" required="required" value="<?php echo $fetchcat['country']; ?>" />

                    </div>

                </div>
            </div>
            <?php
        }
    } else {
        $nbays_customerid = $db->prepare("SELECT * FROM `customer` WHERE `cusid`=?");
        $nbays_customerid->execute(array($_POST['addetails']));
        $catnum = $nbays_customerid->rowCount();
        $fetchcat = $nbays_customerid->fetch(PDO::FETCH_ASSOC);

        if ($catnum > 0) {
            ?>
            <div class="panel-body" id="addetails">
                <div class='row'>
                    <div class="col-md-4">
                        <label>Address <span style="color:#FF0000;">*</span></label>
                        <textarea name="Address2" id="autocomplete" required="required" class="form-control" placeholder="Enter The Address" onFocus="geolocate()"><?php echo $fetchcat['address2']; ?></textarea>

                    </div>
                    <div class="col-md-2">
                        <label>Door No <span style="color:#FF0000;"></span></label>
                        <input type="text" class="form-control" placeholder="Enter The Door No" name="DoorNo" id="street_number"  
                               pattern="[0-9A-Za-z ,/.,-_':]{1,60}" title="Allowed Character (0-9 A-Za-z /.,-_':)" 
                               value="<?php echo $fetchcat['doorno']; ?>" />
                    </div>
                    <div class="col-md-3">

                        <label>Street Name</label>
                        <textarea name="Address1" id="route"  class="form-control" placeholder="Enter The Street Name"><?php echo $fetchcat['address1']; ?></textarea>

                    </div>
                    <div class="col-md-3">
                        <label>District <span style="color:#FF0000;">*</span></label>
                        <input class="form-control" id="locality"  name="districtname" placeholder="Enter The District" value="<?php echo $fetchcat['city']; ?>"   />
                    </div>

                </div><br/><div class="row">
                    <div class="col-md-4">
                        <label>State <span style="color:#FF0000;">*</span></label>
                        <input class="form-control" id="administrative_area_level_1" name="state"  required="required" placeholder="Enter The State" value="<?php echo $fetchcat['state']; ?>" />

                    </div>

                    <div class="col-md-4">
                        <label>Post Code</label>
                        <input type="text" name="PostCode" id="postal_code"  class="form-control"pattern="[a-zA-Z ()0-9-]{3,20}" title="Allowed Characters (a-zA-Z ()0-9-)(3-20)"placeholder="Enter The Post Code" value="<?php echo $fetchcat['postcode']; ?>" />

                    </div>
                    <div class="col-md-4">
                        <label>Country <span style="color:#FF0000;">*</span></label>
                        <input class="form-control" id="country" name="Country" placeholder="Enter The Country" required="required" value="<?php echo $fetchcat['country']; ?>" />

                    </div>

                </div>
            </div>
            <?php
        }
    }
}if ($_POST['cus']) {
    $nbays_customer_wallet = $db->prepare("SELECT * FROM `customer` WHERE `cusid`=?");
    $nbays_customer_wallet->execute(array($_POST['cus']));
    $checkcus = $nbays_customer_wallet->fetch(PDO::FETCH_ASSOC);

    if ($checkcus['wallet_amount'] >= 20) {
        ?>
        <div class="row" >
            <div class="col-md-12">

                <input type="checkbox" name="adtype" id="adtype" value="2"  style="transform: scale(2); cursor: pointer; float: left;" />
                <label for="adtype" style="transform: scale(1); cursor: pointer; float: left; text-align: center; padding:.0% 0 0 1%" >Make as Featured - 20 Credits</label>

            </div>
        </div>
        <?php
    }
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
            if ($_POST['user_check'] != '') {
                if ($_POST['id'] == '') {
                    $cus = $db->prepare("SELECT `uid` FROM `usermaster` WHERE `userid`=? ");
                    $cus->execute(array($_POST['name']));
                    $c = $cus->fetch();
                } else {
                    $cus = $db->prepare("SELECT `uid` FROM `usermaster` WHERE `userid`=? AND `uid`!= ? ");
                    $cus->execute(array($_POST['name'], $_POST['id']));
                    $c = $cus->fetch();
                }
                $admin = $db->prepare("SELECT `id` FROM `users` WHERE `val1`=? ");
                $admin->execute(array($_POST['name']));
                $ad = $admin->fetch();
                 $cmpny = $db->prepare("SELECT `id` FROM `companies` WHERE `username`=? ");
                $cmpny->execute(array($_POST['name']));
                $cp = $cmpny->fetch();
                if ($c['uid'] != '' || $ad['id'] != '' || $cp['id'] != '') {
                    echo 'yes';
                } else {
                    echo 'no';
                }
            }
            if ($_POST['cus_check'] != '') {
                if ($_POST['email'] == '' && $_POST['name'] != '') {
                    $cus = $db->prepare("SELECT `CusID` FROM `customer` WHERE `Company`=? AND `CusID` != ? AND `company_id`=?");
                    $cus->execute(array($_POST['name'], $_POST['cus_id'], $_SESSION['COMPANY_ID']));
                    $c = $cus->fetch();
                    if ($c['CusID'] != '') {
                        echo 'yes';
                    } else {
                        echo 'no';
                    }
                } elseif ($_POST['email'] != '') {
                    $email = $_POST["email"];
                    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        echo "invalid";
                    } else {
                        $cus = $db->prepare("SELECT `CusID` FROM `customer` WHERE `E-mail`=? AND `CusID` != ? AND `company_id`=?");
                        $cus->execute(array($_POST['email'], $_POST['cus_id'], $_SESSION['COMPANY_ID']));
                        $c = $cus->fetch();
                        if ($c['CusID'] != '') {
                            echo 'yes-mail';
                        } else {
                            echo 'no-mail';
                        }
                    }
                }
            }
            if ($_POST['sup_check'] != '') {
                if ($_POST['email'] == '' && $_POST['name'] != '') {
                    $cus = $db->prepare("SELECT `SupID` FROM `suppliers` WHERE `Company`=? AND `SupID` != ? AND `company_id`=?");
                    $cus->execute(array($_POST['name'], $_POST['sup_id'], $_SESSION['COMPANY_ID']));
                    $c = $cus->fetch();
                    if ($c['SupID'] != '') {
                        echo 'yes';
                    } else {
                        echo 'no';
                    }
                } elseif ($_POST['email'] != '') {
                    $email = $_POST["email"];
                    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        echo "invalid";
                    } else {
                        $cus = $db->prepare("SELECT `SupID` FROM `suppliers` WHERE `E-mail`=? AND `SupID` != ? AND `company_id`=?");
                        $cus->execute(array($_POST['email'], $_POST['sup_id'], $_SESSION['COMPANY_ID']));
                        $c = $cus->fetch();
                        if ($c['SupID'] != '') {
                            echo 'yes-mail';
                        } else {
                            echo 'no-mail';
                        }
                    }
                }
            }
            if ($_POST['sup_check1'] != '') {
                if ($_POST['email'] != '') {
                    $email = $_POST["email"];
                    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        echo "invalid";
                    } else {
                        $cus = $db->prepare("SELECT `EmpID` FROM `employee` WHERE `E-mail-Config` = ? AND `EmpID` != ? AND `company_id`=?");
                        $cus->execute(array($_POST['email'], $_POST['sup_id'], $_SESSION['COMPANY_ID']));
                        $c = $cus->fetch();
                        if ($c['EmpID'] != '') {
                            echo 'yes-mail';
                        } else {
                            echo 'no-mail';
                        }
                    }
                }
            }
            if ($_POST['cusdetails']) {
                $nbays_customer_details = $db->prepare("SELECT * FROM `customer` WHERE `cusid`=?");
                $nbays_customer_details->execute(array($_POST['cusdetails']));
                $catnum = $nbays_customer_details->rowCount();
                $fetchcat = $nbays_customer_details->fetch(PDO::FETCH_ASSOC);
                // $cat = DB("SELECT * FROM `customer` WHERE `cusid`='" . $_POST['cusdetails'] . "'");
                //  $fetchcat = mysql_fetch_array($cat);
                //  $catnum = mysql_num_rows($cat);
                if ($catnum > 0) {
                    // echo json_encode(array($dat['crqty'],$dat['crtotwt']));
                    ?>

        <div class="panel-body" id="customerdetails">
            <div class="row">
                <div class="col-md-4">
                    <label>Address</label>
                    <textarea name="Address2" id="autocomplete" class="form-control" placeholder="Enter The Address" onFocus="geolocate()"><?php echo $fetchcat['address2']; ?></textarea>

                </div>
                <div class="col-md-2">
                    <label>Door No <span style="color:#FF0000;"></span></label>
                    <input type="text" class="form-control" placeholder="Enter The Door No" name="DoorNo" id="street_number"  
                           pattern="[0-9A-Za-z ,/.,-_':]{1,60}" title="Allowed Character (0-9 A-Za-z /.,-_':)" 
                           value="<?php echo $fetchcat['doorno']; ?>" />
                </div>
                <div class="col-md-3">

                    <label>Street Name</label>
                    <textarea name="Address1" id="route"  class="form-control" placeholder="Enter The Street Name"><?php echo $fetchcat['address1']; ?></textarea> 
                </div>
                <div class="col-md-3">
                    <label>District <span style="color:#FF0000;">*</span></label>
                    <input class="form-control" id="locality"  name="districtname" placeholder="Enter The District" value="<?php echo $fetchcat['city']; ?>"   />
                </div>

            </div></br><div class="row">
                <div class="col-md-3">
                    <label>State <span style="color:#FF0000;">*</span></label>
                    <input class="form-control" id="administrative_area_level_1" name="state"  required="required" placeholder="Enter The State" value="<?php echo $fetchcat['state']; ?>" />

                </div>

                <div class="col-md-3">
                    <label>Post Code</label>
                    <input type="text" name="PostCode" id="postal_code"  class="form-control"pattern="[a-zA-Z ()0-9-]{3,20}" title="Allowed Characters (a-zA-Z ()0-9-)(3-20)"placeholder="Enter The Post Code" value="<?php echo $fetchcat['postcode']; ?>" />
                </div>
                <div class="col-md-3">
                    <label>Country <span style="color:#FF0000;">*</span></label>
                    <input class="form-control" id="country" name="Country" placeholder="Enter The Country" required="required" value="<?php echo $fetchcat['country']; ?>" />

                </div>
                <div class="col-md-3">
                    <label>Status  <span style="color:#FF0000;">*</span></label>
                    <select name="status" id="status" class="form-control">
                        <option value="1" <?php
        if (getcompanydetails('status', $_REQUEST['comid']) == '1') {
            echo 'selected';
        }
        ?>>Active</option>
                        <option value="2" <?php
        if (getcompanydetails('status', $_REQUEST['comid']) == '2') {
            echo 'selected';
        }
        ?>>Inactive</option>
                    </select>
                </div>
            </div>
        </div>
                        <?php
                            }
                        }
                        if ($_REQUEST['typeid'] != '') {
                            ?>
    <select class="form-control" name="usertype" id="usertype">
        <option value="">Select the type</option>

    <?php
    $nbays_typeid = $db->prepare("SELECT * FROM `customer` WHERE `cusid`=?");
    $nbays_typeid->execute(array($_REQUEST['typeid']));
    $sel = $nbays_typeid->fetch(PDO::FETCH_ASSOC);
    //$sel = DB_QUERY("SELECT * FROM `customer` WHERE `cusid`='" . $_REQUEST['typeid'] . "'");
    $nbays_typeid_company = $db->prepare("SELECT * FROM `company` WHERE `cusid`=?");
    $nbays_typeid_company->execute($_REQUEST['typeid']);
    $selcompany = $nbays_typeid_company->fetch(PDO::FETCH_ASSOC);

    //  $selcompany = DB_QUERY("SELECT * FROM `company` WHERE `cusid`='" . $_REQUEST['typeid'] . "'");
    $amount = $sel['wallet_amount'];
    if ($amount != '' && $amount >= 100) {
        ?>
            <option value="1">Featured</option>
            <option value="2">Free</option>
        <?php } else { ?>
            <option value="2">Free</option>
        <?php } ?>
    </select> 

        <?php
    }
    if ($_REQUEST['adtypeid'] != '') {
        ?>

    <option value="">Select Ad type</option>

        <?php
        $nbays_adtypeid = $db->prepare("SELECT * FROM `customer` WHERE `cusid`=?");
        $nbays_adtypeid->execute(array($_REQUEST['adtypeid']));
        $sel = $nbays_adtypeid->fetch(PDO::FETCH_ASSOC);
        // $sel = DB_QUERY("SELECT * FROM `customer` WHERE `cusid`='" . $_REQUEST['adtypeid'] . "'");
        //echo "SELECT * FROM `customer` WHERE `cusid`='".$_REQUEST['adtypeid']."'";echo "500";
        $nbays_adtypeid_company = $db->prepare("SELECT * FROM `company` WHERE `cusid`=?");
        $nbays_adtypeid_company->execute(array($_REQUEST['adtypeid']));
        $selcompany = $nbays_adtypeid_company->fetch(PDO::FETCH_ASSOC);
        // $selcompany = DB_QUERY("SELECT * FROM `company` WHERE `cusid`='" . $_REQUEST['adtypeid'] . "'");
        $amount = $sel['wallet_amount'];
        if ($amount != '' && $amount >= 20) {
            ?>
        <option value="1">Free</option>
        <option value="2">Premium</option>
    <?php } else { ?>
        <option value="1">Free</option>
    <?php } ?>


    <?php
}
if ($_REQUEST['subidd'] != '') {
    ?>
    <select class="form-control" name="districtname" id="districtname">
    <?php
    $nbays_districtname = $db->prepare("SELECT * FROM `district` WHERE `status`!=? AND `state`=? ORDER BY `districtname` ASC");
    $nbays_districtname->execute(array(2, $_REQUEST['subidd']));
    $catnum = $nbays_districtname->rowCount();
    //echo "SELECT * FROM `subgroupmaster` WHERE `status`!='2' " . $s . " ORDER BY `order` ASC";
    // $cat = DB("SELECT * FROM `district` WHERE `status`!='2' AND `state`='" . $_REQUEST['subidd'] . "'   ORDER BY `districtname` ASC");
    //$catnum = mysql_num_rows($cat);
    if ($catnum > 0) {
        ?>
            <option value="">Select the District</option>
            <?php
            while ($fsel = $nbays_districtname->fetch(PDO::FETCH_ASSOC)) {
                ?>
                <option value="<?php echo $fsel['diid']; ?>"><?php echo stripslashes($fsel['districtname']); ?></option>
                <?php
            }
        } else {
            ?>
            <option value="">--No District Available--</option>
        <?php } ?>
    </select> 

        <?php
    }
    if ($_REQUEST['adtypes'] != '') {
        ?>

        <?php
        if ($_REQUEST['adtypes'] != '') {
            $nbays_adtypes = $db->prepare("SELECT `wallet_amount` FROM `customer` WHERE `cusid`=?");
            $nbays_adtypes->execute(array($_REQUEST['adtypes']));
            $catnum = $nbays_adtypes->rowCount();

            //echo "SELECT * FROM `subgroupmaster` WHERE `status`!='2' " . $s . " ORDER BY `order` ASC";
            // $cat = DB("SELECT `wallet_amount` FROM `customer` WHERE `cusid`='" . $_REQUEST['adtypes'] . "'");
            // echo "SELECT `wallet_amount` FROM `customer` WHERE `cusid`='" . $_REQUEST['adtypes'] . "'";
            // $catnum = mysql_num_rows($cat);
            if ($catnum > 0) {
                ?>
            <option value="">Select ad types</option>
            <?php
            while ($fsel = $nbays_adtypes->fetch(PDO::FETCH_ASSOC)) {
                if ($fsel['wallet_amount'] == '') {
                    ?>
                    <option value="1">FREE</option>
                    <?php
                }
            }
        } else {
            ?>
            <option value="">--No District Available--</option>
            <?php
        }
    }
    ?>
    </select> 

    <?php
}
if ($_REQUEST['psubidd'] != '') {
    ?>
    <select class="form-control" name="pdistrictname" id="pdistrictname">
    <?php
    $nbays_pdistrictname = $db->prepare("SELECT * FROM `district` WHERE `status`!=? AND `state`=? ORDER BY `districtname` ASC");
    $nbays_pdistrictname->execute(array(2, $_REQUEST['psubidd']));
    $catnum = $nbays_pdistrictname->rowCount();
    //echo "SELECT * FROM `subgroupmaster` WHERE `status`!='2' " . $s . " ORDER BY `order` ASC";
    //  $cat = DB("SELECT * FROM `district` WHERE `status`!='2' AND `state`='" . $_REQUEST['psubidd'] . "' ORDER BY `districtname` ASC");
    //  $catnum = mysql_num_rows($cat);
    if ($catnum > 0) {
        ?>
            <option value="">Select the District</option>
            <?php
            while ($fsel = $nbays_pdistrictname->fetch(PDO::FETCH_ASSOC)) {
                ?>
                <option value="<?php echo $fsel['diid']; ?>"><?php echo stripslashes($fsel['districtname']); ?></option>
                <?php
            }
        } else {
            ?>
            <option value="">--No District Available--</option>
        <?php } ?>
    </select> 
        <?php
    }

    if ($_REQUEST['subiddln'] != '') {
        ?>
    <select class="form-control" name="locationname" id="locationname">
        <?php
        $nbays_locationname = $db->prepare("SELECT * FROM `location` WHERE `status`!=? AND `district`=? ORDER BY `locationname` ASC ");
        $nbays_locationname->execute(array(2, $_REQUEST['subiddln']));
        $catnum = $nbays_locationname->rowCount();
        //echo "SELECT * FROM `subgroupmaster` WHERE `status`!='2' " . $s . " ORDER BY `order` ASC";
        // $cat = DB("SELECT * FROM `location` WHERE `status`!='2' AND `district`='" . $_REQUEST['subiddln'] . "' ORDER BY `locationname` ASC ");
        // $catnum = mysql_num_rows($cat);
        if ($catnum > 0) {
            ?>
            <option value="">Select the Location</option>
            <?php
            while ($fsel = $nbays_locationname->fetch(PDO::FETCH_ASSOC)) {
                ?>
                <option value="<?php echo $fsel['loid']; ?>"><?php echo stripslashes($fsel['locationname']); ?></option>
                <?php
            }
        } else {
            ?>
            <option value="">--No Location Available--</option>
        <?php } ?>
    </select> 
        <?php
    }



    if ($_REQUEST['psubiddln'] != '') {
        ?>
    <select class="form-control" name="plocationname" id="plocationname">
        <?php
        $nbays_plocationname = $db->prepare("SELECT * FROM `location` WHERE `status`!=? AND `district`=? ORDER BY `locationname` ASC ");
        $nbays_plocationname->execute(array(2, $_REQUEST['psubiddln']));
        $catnum = $nbays_plocationname->rowCount();
        //echo "SELECT * FROM `subgroupmaster` WHERE `status`!='2' " . $s . " ORDER BY `order` ASC";
        // $cat = DB("SELECT * FROM `location` WHERE `status`!='2' AND `district`='" . $_REQUEST['psubiddln'] . "' ORDER BY `locationname` ASC ");
        // $catnum = mysql_num_rows($cat);
        if ($catnum > 0) {
            ?>
            <option value="">Select the Location</option>
            <?php
            while ($fsel = $nbays_plocationname->fetch(PDO::FETCH_ASSOC)) {
                ?>
                <option value="<?php echo $fsel['loid']; ?>"><?php echo stripslashes($fsel['locationname']); ?></option>
                <?php
            }
        } else {
            ?>
            <option value="">--No Location Available--</option>
        <?php } ?>
    </select> 
        <?php
    }



    if ($_REQUEST['subiddd'] != '') {
        ?>
    <select class="form-control" name="firstname" id="firstname">
        <?php
        $nbays_firstname = $db->prepare("SELECT * FROM `customer` WHERE `status`!=? AND `cusid`=?");
        $nbays_firstname->execute(array(2, $_REQUEST['subiddd']));
        $catnum = $nbays_firstname->rowCount();
        //echo "SELECT * FROM `subgroupmaster` WHERE `status`!='2' " . $s . " ORDER BY `order` ASC";
        // $cat = DB("SELECT * FROM `customer` WHERE `status`!='2' AND `cusid`='" . $_REQUEST['subiddd'] . "'");
        // $catnum = mysql_num_rows($cat);
        if ($catnum > 0) {
            ?>
            <option value="">Select the Agent</option>
            <?php
            while ($fsel = $nbays_firstname->fetch(PDO::FETCH_ASSOC)) {
                ?>
                <option value="<?php echo $fsel['cusid']; ?>"><?php echo stripslashes($fsel['agentname']); ?></option>
                <?php
            }
        } else {
            ?>
            <option value="">--No Agent Available--</option>
        <?php } ?>
    </select> 
        <?php
    }



    if ($_REQUEST['subidac'] != '') {
        ?>
    <select class="form-control" name="firstname" id="firstname">
        <?php
        $nbays_subidac = $db->prepare("SELECT * FROM `customer` WHERE `status`!=? AND `customer`=? ");
        $nbays_subidac->execute(array(2, $_REQUEST['subidac']));
        $catnum = $nbays_subidac->rowCount();
        //echo "SELECT * FROM `subgroupmaster` WHERE `status`!='2' " . $s . " ORDER BY `order` ASC";
        // $cat = DB("SELECT * FROM `customer` WHERE `status`!='2' AND `customer`='" . $_REQUEST['subidac'] . "'");
        // $catnum = mysql_num_rows($cat);
        if ($catnum > 0) {
            ?>
            <option value="">Select the Agent</option>
            <?php
            while ($fsel = $nbays_subidac->fetch(PDO::FETCH_ASSOC)) {
                ?>
                <option value="<?php echo $fsel['cusid']; ?>"><?php echo stripslashes($fsel['agentname']); ?></option>
                <?php
            }
        } else {
            ?>
            <option value="">--No Agent Available--</option>
        <?php } ?>
    </select> 
        <?php
    }

    if ($_REQUEST['subidcl'] != '') {
        ?>

    <select class="form-control" name="innerid" id="innerid">
        <?php
        $nbays_innerid = $db->prepare("SELECT * FROM `innercategory` WHERE `status`!=? AND `subcategory`=?");
        $nbays_innerid->execute(array(2, $_REQUEST['subidcl']));
        $catnum = $nbays_innerid->rowCount();
        //echo "SELECT * FROM `subgroupmaster` WHERE `status`!='2' " . $s . " ORDER BY `order` ASC";
        // $cat = DB("SELECT * FROM `innercategory` WHERE `status`!='2' AND `subcategory`='" . $_REQUEST['subidcl'] . "'");
        // $catnum = mysql_num_rows($cat);
        if ($catnum > 0) {
            ?>
            <option value="">Select the Inner Category</option>
            <?php
            while ($fsel = $nbays_innerid->fetch(PDO::FETCH_ASSOC)) {
                ?>
                <option value="<?php echo $fsel['icid']; ?>"><?php echo stripslashes($fsel['innercategoryname']); ?></option>
                <?php
            }
        } else {
            ?>
            <option value="">--No InnerCategory Available--</option>
        <?php } ?>
    </select>

        <?php
    }
    if ($_REQUEST['subidrm'] != '') {
        ?>
    <select class="form-control" name="subcategoryname" id="subcategoryname"">
        <?php
        $nbays_subidrm = $db->prepare("SELECT * FROM `subcategory` WHERE `status`!=? AND `category` IN (?)");
        $nbays_subidrm->execute(array(2, $_REQUEST['subidrm']));
        $catnum = $nbays_subidrm->rowCount();
        // echo "SELECT * FROM `subcategory` WHERE `status`!='2' " . $s . "";
        // $cat = DB("SELECT * FROM `subcategory` WHERE `status`!='2' AND `category` IN (" . $_REQUEST['subidrm'] . ")");
        // $catnum = mysql_num_rows($cat);
        if ($catnum > 0) {
            ?>
            <!--option value="">Select the sub category</option>-->
            <?php
            while ($fsel = $nbays_subidrm->fetch(PDO::FETCH_ASSOC)) {
                ?>
                <option value="<?php echo $fsel['scid']; ?>"><?php echo stripslashes($fsel['subcategoryname']); ?></option>
                <?php
            }
        } else {
            ?>
            <!--   <option value="">--No sub category Available--</option>-->
        <?php } ?>
    </select> 
        <?php
    }
    if ($_REQUEST['subidstate'] != '') {
        ?>
    <select class="form-control" name="districtname" id="districtname">
        <?php
        $nbays_subidstate = $db->prepare("SELECT * FROM `district` WHERE `status`!=? AND `state`=? ");
        $nbays_subidstate->execute(array(2, $_REQUEST['subidstate']));
        $catnum = $nbays_subidstate->rowCount();
        //echo "SELECT * FROM `subgroupmaster` WHERE `status`!='2' " . $s . " ORDER BY `order` ASC";
        //$cat = DB("SELECT * FROM `district` WHERE `status`!='2' AND `state`='" . $_REQUEST['subidstate'] . "' ");
        // $catnum = mysql_num_rows($cat);
        if ($catnum > 0) {
            ?>
            <option value="">Select the District</option>
            <?php
            while ($fsel = $nbays_subidstate->fetch(PDO::FETCH_ASSOC)) {
                ?>
                <option value="<?php echo $fsel['diid']; ?>"><?php echo stripslashes($fsel['districtname']); ?></option>
                <?php
            }
        } else {
            ?>
            <option value="">--No District Available--</option>
        <?php } ?>
    </select> 
        <?php
    }


    if ($_REQUEST['subiddis'] != '') {
        ?>

        <?php
        $nbays_subiddis = $db->prepare("SELECT * FROM `location` WHERE `status`!=? AND `district`=?");
        $nbays_subiddis->execute(array(2, $_REQUEST['subiddis']));
        $catnum = $nbays_subiddis->rowCOunt();
        //echo "SELECT * FROM `subgroupmaster` WHERE `status`!='2' " . $s . " ORDER BY `order` ASC";
        // $cat = DB("SELECT * FROM `location` WHERE `status`!='2' AND `district`='" . $_REQUEST['subiddis'] . "' ");
        // $catnum = mysql_num_rows($cat);
        if ($catnum > 0) {
            ?>
        <option value="">Select the Location</option>
        <?php
        while ($fsel = $nbays_subiddis->fetch(PDO::FETCH_ASSOC)) {
            ?>
            <option value="<?php echo $fsel['loid']; ?>"><?php echo stripslashes($fsel['locationname']); ?></option>
            <?php
        }
    } else {
        ?>
        <option value="">--No Location Available--</option>
    <?php } ?>

    <?php
}

if ($_REQUEST['agentid'] != '') {
    ?>

    <?php
    $nbays_agentid = $db->prepare("SELECT * FROM `customer` WHERE `status`!=? AND `agentcode`=? ");
    $nbays_agentid->execute(2, $_REQUEST['agentid']);
    $catnum = $nbays_agentid->rowCount();
    //echo "SELECT * FROM `subgroupmaster` WHERE `status`!='2' " . $s . " ORDER BY `order` ASC";
    //$cat = DB("SELECT * FROM `customer` WHERE `status`!='2' AND `agentcode`='" . $_REQUEST['agentid'] . "' ");
    // $catnum = mysql_num_rows($cat);
    if ($catnum > 0) {
        ?>
        <option value="">Select the Customer</option>
        <?php
        while ($fsel = $nbays_agentid->fetch(PDO::FETCH_ASSOC)) {
            ?>
            <option value="<?php echo $fsel['cusid']; ?>">
            <?php
            if ($fsel['cusid'] == getadvertis('customerid', $_REQUEST['id'])) {
                echo 'selected="selected"';
            }
            ?>
            <?php echo stripslashes($fsel['firstname']) . ' ' . stripslashes($fsel['lastname']); ?></option>
            <?php
        }
    } else {
        ?>
        <option value="">--No Customer Available--</option>
        <?php } ?>
        <?php
    }

    if ($_REQUEST['agen'] != '') {
        $nbays_agen = $db->prepare("SELECT `agentcode` FROM `customer` WHERE `status`!=? AND `cusid`=? ");
        $nbays_agen->execute(array(2, $_REQUEST['agen']));
        $cat = $nbays_agen->fetch(PDO::FETCH_ASSOC);

        $nbays_agen1 = $db->prepare("SELECT * FROM `agent` WHERE `status`!=? AND `agent_id`=? ");
        $nbays_agen1->execute(array(2, $cat['agentcode']));
        $cat1 = $nbays_agen1->fetch(PDO::FETCH_ASSOC);

        // $cat = DB_QUERY("SELECT `agentcode` FROM `customer` WHERE `status`!='2' AND `cusid`='" . $_REQUEST['agen'] . "' ");
        //$cat1 = DB_QUERY("SELECT * FROM `agent` WHERE `status`!='2' AND `agent_id`='" . $cat['agentcode'] . "' ");
        ?>
    <?php
    //echo $cat['agentcode'];

    echo stripslashes(stripslashes($cat1['firstname']) . ' ' . stripslashes($cat1['lastname']) . ' ' . stripslashes($cat1['agent_id']));
} if ($_REQUEST['contact'] != '') {
    $nbays_contact = $db->prepare("SELECT `firstname` FROM `customer` WHERE `status`!=? AND `cusid`=? ");
    $nbays_contact->execute(array(2, $_REQUEST['contact']));
    $cat = $nbays_contact->fetch(PDO::FETCH_ASSOC);

    // $cat = DB_QUERY("SELECT `firstname` FROM `customer` WHERE `status`!='2' AND `cusid`='" . $_REQUEST['contact'] . "' ");
    ?>
    <?php
    //echo $cat['agentcode'];

    echo stripslashes($cat['firstname']);
}if ($_REQUEST['contactno'] != '') {
    $nbays_cuscontact = $db->prepare("SELECT `phoneno` FROM `customer` WHERE `status`!=? AND `cusid`=? ");
    $nbays_cuscontact->execute(array(2, $_REQUEST['contactno']));
    $cat = $nbays_cuscontact->fetch(PDO::FETCH_ASSOC);

    // $cat = DB_QUERY("SELECT `phoneno` FROM `customer` WHERE `status`!='2' AND `cusid`='" . $_REQUEST['contactno'] . "' ");
    ?>
    <?php
    //echo $cat['agentcode'];

    echo stripslashes($cat['phoneno']);
}if ($_REQUEST['update_by'] != '') {
    // alert('hi');
    $nbays_phone = $db->prepare("SELECT * FROM `employeemaster` WHERE `status`!=? ");
    $nbays_phone->execute(array(2));

    $nbays_update_by = $db->prepare("SELECT * FROM `agent` WHERE `status`!=? ");
    $nbays_update_by->execute(array(2));

    // $sels = DB("SELECT * FROM `employeemaster` WHERE `status`!='2'");
    //$sel = DB("SELECT * FROM `agent` WHERE `status`!='2'");
    // echo "SELECT * FROM `agent` WHERE `status`!='2'";


    if ($_REQUEST['update_by'] == 4) {
        while ($fsel = $nbays_phone->fetch(PDO::FETCH_ASSOC)) {
            ?>
            <option value="<?php echo $fsel['empcode']; ?>">

            <?php echo stripslashes($fsel['title']) . '. ' . ucfirst(stripslashes($fsel['empname'])) . ' ' . stripslashes($fsel['lastname']); ?></option>
            <?php
        }
    }

    if ($_REQUEST['update_by'] == 3) {
        while ($fsel = $nbays_update_by->fetch(PDO::FETCH_ASSOC)) {
            ?>
            <option value="<?php echo $fsel['agent_id']; ?>">

                <?php echo stripslashes($fsel['title']) . '. ' . ucfirst(stripslashes($fsel['firstname'])) . ' ' . stripslashes($fsel['lastname']); ?></option>
                <?php
        }
    }
}
if ($_REQUEST['locid'] != '') {
    $_SESSION['location'] = $_REQUEST['locid'];
    echo '<meta http-equiv="refresh" content="0">';
}

if ($_REQUEST['enqid'] != '') {
    $nbays_enqid = $db->prepare("DELETE  FROM `company-enquiry` WHERE `ceid`=? ");
    $nbays_enqid->execute(array($_REQUEST['enqid']));

    // DB("DELETE  FROM `company-enquiry` WHERE `ceid`='" . $_REQUEST['enqid'] . "'");


    $del = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-close"></i> Successfully Deleted!!</h4></div>';
    echo $del;
    echo '<meta http-equiv="refresh" content="0">';
    header("Refresh:10");
}


if ($_REQUEST['contactno'] != '' || $_REQUEST['contactemail'] != '') {
    if ($_REQUEST['contactno'] != '') {

        $nbays_phone = $db->prepare("SELECT * FROM `create_ads` WHERE `status`!=? AND (`contactno`=? ) ");
        $nbays_phone->execute(array(1, $_REQUEST['contactno']));
    }
    if ($_REQUEST['contactemail'] != '') {

        $nbays_phone = $db->prepare("SELECT * FROM `create_ads` WHERE `status`!=? AND (`contactemail`=? ) ");
        $nbays_phone->execute(array(1, $_REQUEST['contactemail']));
    }
    if ($_REQUEST['contactno'] != '' && $_REQUEST['contactemail'] != '') {
        $nbays_phone = $db->prepare("SELECT * FROM `create_ads` WHERE `status`!=? AND (`contactno`=? OR `contactemail`=?  ) ");
        $nbays_phone->execute(array(1, $_REQUEST['contactno'], $_REQUEST['contactemail']));
    }


    if ($nbays_phone->rowCount() < 5) {
        ?>
        <div class="row ">
            <div class="col-md-9 col-sm-9 col-xs-12">
                <h3>Free Listing   <small>Submit 5 Listings</small></h3>
                <p>Lorem ipsum dolor sit amet, non odio tincidunt ut ante, lorem a euismod suspendisse vel, sed quam nulla mauris iaculis.</p>
            </div>
            <!-- end col -->
            <div class="col-md-3 col-sm-3 col-xs-12">
                <div class="pricing-list-price text-center">
                    <h4><i class="fa fa-inr"></i> 0.00</h4>
                    <a href="javascript:void(0)" onclick="viewpay(1);" class="btn btn-theme btn-sm btn-block">Select</a>
                </div>
            </div>
            <!-- end col -->
        </div>	
        <?php
    } else {
        echo '';
    }
}
if ($_REQUEST['pricing'] == 'payment') {

    $data['pay'] = '<div class="row">
                                            <div class="col-md-9 col-sm-9 col-xs-12">
                                                <h3>Premium Listing   <small>Submit 10 Listings</small></h3>
                                                <p>Lorem ipsum dolor sit amet, non odio tincidunt ut ante, lorem a euismod suspendisse vel, sed quam nulla mauris iaculis.</p>
                                            </div>
                                            <!-- end col -->
                                            <div class="col-md-3 col-sm-3 col-xs-12">
                                                <div class="pricing-list-price text-center">
                                                    <h4> 20 Credits</h4>
                                                    <a onclick="viewpay(2);" class="btn btn-theme btn-sm btn-block">Select</a>
                                                </div>
                                            </div>
                                            <!-- end col -->
                                        </div>';

    $data['button'] = '<button class="btn btn-theme pull-right" name="save" id="save" type="submit">Publish My Ad</button>';
    echo json_encode($data);
}

if ($_REQUEST['viewpay'] != '') {
    $viewpay = $_REQUEST['viewpay'];
    if ($viewpay == 1) {
        echo '';
    } else if ($viewpay == 2) {
        ?>

        <li>
            <input type="radio" id="bank" value="1" name="payment_method">
            <label  for="bank"> Direct Bank Transfer</label>
        </li>
        <li>
            <input type="radio" id="cheque" value="2" name="payment_method" >
            <label for="cheque">Cheque Payment</label>
        </li>
        <li>
            <input type="radio" id="paypal" value="3" name="payment_method" >
            <label for="paypal">Paypal</label>
        </li>
        <li>
            <input type="radio" id="card" value="4" name="payment_method" >
            <label for="card">Credit Card</label>
        </li>    


        <?php
    }
}
if ($_REQUEST['reset_id']) {

    $reset = $db->prepare("UPDATE `bill_settings` SET `current_value`=? WHERE `id`=? AND `company_id`=?");
    $reset->execute(array('1', $_REQUEST['reset_id'], $_SESSION['COMPANY_ID']));

    $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i> Successfully Reseted!</h4></div>';

    echo $res;
}
if ($_POST['getstate'] == '1' && $_POST['country_id'] != '') {
    echo state_list('', $_POST['country_id'], $_POST['ed']);
}
if ($_POST['getcity'] == '1' && $_POST['state_id'] != '') {
    echo city_list('', $_POST['state_id'], $_POST['ed']);
}

if ($_POST['getstate_cus'] == '1' && $_POST['country_id'] != '') {
    $states = $db->prepare("SELECT * FROM `states` WHERE `id`!='' AND `country_id`=?");
    $states->execute(array($_POST['country_id']));
    $select = '<option value="">Select State</option>';
    while ($fetch = $states->fetch()) {
        $select .= '<option value="' . $fetch['id'] . '">' . $fetch['name'] . '</option>';
    }
    echo $select;
}
if ($_POST['getcity_cus'] == '1' && $_POST['state_id'] != '') {
    $states = $db->prepare("SELECT * FROM `cities` WHERE `id`!='' AND `state_id`=?");
    $states->execute(array($_POST['state_id']));
    $select = '<option value="">Select City</option>';
    while ($fetch = $states->fetch()) {
        $select .= '<option value="' . $fetch['id'] . '">' . $fetch['name'] . '</option>';
    }
    echo $select;
}
if ($_POST['deladdr'] == '1' && $_POST['addr_id'] != '') {
    $da = $db->prepare("DELETE FROM `customer_address` WHERE `id`=? AND `company_id`=?");
    $da->execute(array($_POST['addr_id'], $_SESSION['COMPANY_ID']));
    echo "success";
}
?>
