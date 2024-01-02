<?php

/* Customer Group Code Start Here */

function addpassup($name, $value, $ip, $status, $getid) {
    global $db;
    if ($getid == '') {
        $link2 = FETCH_all("SELECT `id` FROM `passup` WHERE `name`=?", $name);
        if ($link2['id'] == '') {
            $resa = $db->prepare("INSERT INTO `passup` (`name`,`value`,`ip`,`status`,`inserted_by`) VALUES(?,?,?,?,?)");
            $resa->execute(array($name, $value, $ip, $status, $_SESSION['UID']));
            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
            $htry->execute(array('Passup Mgmt', 10, 'INSERT', $_SESSION['UID'], $ip, $id));

            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';
        } else {
            $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i>Group Name exists!</h4></div>';
        }
    } else {
        $link1 = FETCH_all("SELECT `id` FROM `passup` WHERE `name`=? AND `id`!=?", $name, $getid);
        if ($link1['id'] == '') {
            $resa = $db->prepare("UPDATE `passup` SET `name`=?, `value`=?,`ip`=?, `status`=?, `updated_by`=? WHERE `id`=?");
            $resa->execute(array(trim($name), trim($value), trim($ip), $status, $_SESSION['UID'], $getid));

            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
            $htry->execute(array('Passup Mgmt', 10, 'UPDATE', $_SESSION['UID'], $ip, $getid));

            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><h4><i class="icon fa fa-check"></i>Successfully Updated</h4></div>';
        } else {
            $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i>Email already exists!</h4></div>';
        }
    }
    return $res;
}

function delpassup($a) {
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    foreach ($b as $c) {
        global $db;
        $get = $db->prepare("DELETE FROM `passup` WHERE `id` = ? ");
        $get->execute(array($c));
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i> Successfully Deleted!</h4></div>';
    return $res;
}

function getpassup($a, $b) {
    global $db;
    $get1 = $db->prepare("SELECT * FROM `passup` WHERE `id`=?");
    $get1->execute(array($b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}

/* Customer Group Code  End Here */
/* Pricing Category Start here */

function addjob($productname, $count, $kilometer, $singleprosize, $procount, $totalsquare, $jobtype, $payperhour, $workingdays, $totalpay, $pickuptime, $customertype, $pickupdate, $pricecategory, $customer, $name, $email, $mobileno, $address, $state, $country, $pickup, $drop, $pname, $weight, $price, $driver, $status, $ip, $getid) {
    global $db;
    if ($getid == '') {

        if ($customertype == '1') {
            $resa = $db->prepare("INSERT INTO `customer` (`firstname`, `email`, `mobile`, `address1`, `state`, `country`,`status`) VALUES(?,?,?,?,?,?,?)");
            $resa->execute(array($name, $email, $mobileno, $address, $state, $country, '1'));
        }


        $resa = $db->prepare("INSERT INTO `jobs` (`productname`,`count1`,`kilometerorg`,`singleprosize`,`procount`,`totalsquare`,`jobtype`,`payperhour`,`workingdays`,`totalpay`,`pickuptime`,`pricecategory`,`pickupdate`,`customer`,`customertype`,`pickup`, `drop`, `pname`, `weight`, `price`, `driver`, `status`) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
        $resa->execute(array($productname, $count, $kilometer, $singleprosize, $procount, $totalsquare, $jobtype, $payperhour, $workingdays, $totalpay, $pickuptime, $pricecategory, $pickupdate, $customer, $customertype, $pickup, $drop, $pname, $weight, $price, $driver, $status));

        $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
        $htry->execute(array('Jobs Mgmt', 15, 'INSERT', $_SESSION['UID'], $ip, $id));

        $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';
    } else {
        $resa = $db->prepare("UPDATE `jobs` SET `productname`=?,`count1`=?,`kilometerorg`=?,`singleprosize`=?,`procount`=?,`totalsquare`=?,`jobtype`=?,`payperhour`=?,`workingdays`=?,`totalpay`=?,`pickuptime`=?,`pricecategory`=?,`pickupdate`=?,`customer`=?,`customertype`=?,`pickup`=?,`drop`=?,`pname`=?,`weight`=?,`price`=?,`driver`=?,`status`=? WHERE `id`=?");
        $resa->execute(array($productname, $count, $kilometer, $singleprosize, $procount, $totalsquare, $jobtype, $payperhour, $workingdays, $totalpay, $pickuptime, $pricecategory, $pickupdate, $customer, $customertype, $pickup, $drop, $pname, $weight, $price, $driver, $status, $getid));

        $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
        $htry->execute(array('Jobs Mgmt', 15, 'UPDATE', $_SESSION['UID'], $ip, $getid));

        $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><h4><i class="icon fa fa-check"></i>Successfully Updated</h4></div>';
    }
    return $res;
}

function addjob_new($finalnettotal, $task_extraamt, $cusreference, $job_notes, $additionchargprc, $task_empamt2, $task_tax, $amt, $passupvalue, $task_passup12, $passup_amount2, $task_totamount, $task_description, $task_qty, $task_unitprice, $task_unitprice1, $additioncharg, $pay_id, $task_employee2, $task_description2, $task_qty2, $task_unitprice2, $jobid, $customer, $price_category, $pickup_date, $pickup_time, $pickup_location, $pickup_lat, $pickup_lng, $drop_location, $drop_lat, $drop_lng, $km, $description, $status, $subtotal, $nettotal, $tax, $additionalcharge, $empqty1, $Emptotal, $ip, $getid) {
    global $db;
    $cudate = date('Y-m-d');

    if ($getid == '') {
        $jobid = get_bill_settings('prefix', '2') . str_pad(get_bill_settings('current_value', '2'), get_bill_settings('format', '2'), '0', STR_PAD_LEFT);

        update_bill_value('2');
        $ins = $db->prepare("INSERT INTO `jobs_new` SET `finalnettotal`=?,`cusreference`=?,`job_notes`=?,`tax_id`=?,`additionalchargerate`=?,`additionalchargeprice`=?,`datetime`=?,`jobid`=?,`customer`=?,`price_category`=?,`pickup_date`=?,`pickup_time`=?,`pickup_location`=?,`pickup_lat`=?,`pickup_lng`=?,`drop_location`=?,`drop_lat`=?,`drop_lng`=?,`km`=?,`description`=?,`status`=?,`subtotal`=?,`nettotal`=?,`tax`=?,`additionalcharge`=?,`empqty1`=?,`emptotal`=?,`ip`=?,`created_date`=?,`modified_date`=?");
        $ins->execute(array($finalnettotal, $cusreference,$job_notes, $task_tax, $additionchargprc, $amt, $cudate, $jobid, $customer, $price_category, date("Y-m-d", strtotime($pickup_date)), date("H:i:s", strtotime($pickup_time)), $pickup_location, $pickup_lat, $pickup_lng, $drop_location, $drop_lat, $drop_lng, $km, $description, $status, $subtotal, $nettotal, $tax, $additioncharg, $empqty1, $Emptotal, $ip, date("Y-m-d H:i:s"), date("Y-m-d H:i:s")));

        $ins_id = $db->lastInsertId();

        $task_description1 = explode('*&&*&*', $task_description);
        $task_qty1 = explode(',', $task_qty);
        $task_unitprice1 = explode(',', $task_unitprice);


        $task_totamount1 = explode(',', $task_totamount);
        $task_passup1 = explode(',', $passupvalue);
        $task_passup11 = explode(',', $task_passup12);
        $passup_amount1 = explode(',', $passup_amount2);

        foreach ($task_description1 as $key => $value) {
            //echo "teste";exit;
            if ($task_description1[$key] != '') {
                $totamt = $task_totamount1[$key];

                $ins_det = $db->prepare("INSERT INTO `job_invoice` SET `job_id`=?,`date`=?,`subject`=?,`task_description`=?,`task_quty`=?,`task_unit_price`=?,`task_gst`=?,`task_amount_aud`=?");
                $ins_det->execute(array($ins_id, $cudate, 'Task', $task_description1[$key], $task_qty1[$key], $task_unitprice1[$key], '10', $totamt));
            }
        }

        $task_passup8 = explode(',', $passupvalue);
        foreach ($task_passup8 as $key => $value) {
            if ($value != '') {
                $passup = FETCH_all("SELECT * FROM `passup` WHERE `id` = ?", $value);
                $totamt = $task_totamount1[$key] * $passup['value'] / 100;
                $cudate = date('Y-m-d');

                $ins_det = $db->prepare("INSERT INTO `job_invoice` SET `job_id`=?,`date`=?,`subject`=?,`task_description`=?,`task_quty`=?,`task_unit_price`=?,`task_gst`=?,`task_amount_aud`=?");
                $ins_det->execute(array($ins_id, $cudate, 'Passup Charge', $passup['name'], '1', $task_passup12[$key], '10', $totamt));
            }
        }

        $task_description21 = explode('*&&*&*', $task_description2);
        $task_employee21 = explode(',', $task_employee2);
        $task_unitprice21 = explode(',', $task_unitprice2);
        $empqty11 = explode(',', $task_qty2);
        $empextraamt = explode(',', $task_extraamt);

        $task_empamt21 = explode(',', $task_empamt2);

        foreach ($task_description21 as $key => $value) {
            if ($task_empamt21[$key] != '') {

                $totamt = $task_empamt21[$key] * $empqty11[$key];
                $cudate = date('Y-m-d');

                $ins_det = $db->prepare("INSERT INTO `paycalculation` SET `employee`=?,`job_id`=?,`date`=?,`task_extra_amt`=?,`subject`=?,`task_description`=?,`task_quty`=?,`task_unit_price`=?,`task_gst`=?,`task_amount_aud`=?");
                $ins_det->execute(array($task_employee21[$key], $ins_id, date("Y-m-d", strtotime($pickup_date)), $empextraamt[$key], 'Worker Charge', $task_description21[$key], $empqty11[$key], $task_unitprice21[$key], '10', $task_empamt21[$key]));
                $linsid = $db->lastInsertId();
                
                $ins_det = $db->prepare("INSERT INTO `job_invoice` SET `employee`=?,`job_id`=?,`date`=?,`task_extra_amt`=?,`subject`=?,`task_description`=?,`task_quty`=?,`task_unit_price`=?,`task_gst`=?,`task_amount_aud`=?,`pay_id`=?");
                $ins_det->execute(array($task_employee21[$key], $ins_id, $cudate, $empextraamt[$key], 'Worker Charge', $task_description21[$key], $empqty11[$key], $task_unitprice21[$key], '10', $task_empamt21[$key],$linsid));                
                
            }
        }




        /*foreach ($task_description21 as $key => $value) {
            if ($task_empamt21[$key] != '') {

                $totamt = $task_empamt21[$key] * $empqty11[$key];
                $cudate = date('Y-m-d');

                $ins_det = $db->prepare("INSERT INTO `paycalculation` SET `employee`=?,`job_id`=?,`date`=?,`task_extra_amt`=?,`subject`=?,`task_description`=?,`task_quty`=?,`task_unit_price`=?,`task_gst`=?,`task_amount_aud`=?");
                $ins_det->execute(array($task_employee21[$key], $ins_id, $cudate, $empextraamt[$key], 'Worker Charge', $task_description21[$key], $empqty11[$key], $task_unitprice21[$key], '10', $task_empamt21[$key]));
            }
        }*/


        $additionchargprc = explode(',', $additionchargprc);
        $additioncharg1 = explode(',', $additioncharg);
        foreach ($additioncharg1 as $key => $value) {
            if ($value != '') {
                $additionalcharge = FETCH_all("SELECT * FROM `additional_charges` WHERE `id` = ?", $value);
                $totamt = $subtotal * ($additionchargprc[$key] / 100);
                $cudate = date('Y-m-d');
                $ins_det = $db->prepare("INSERT INTO `job_invoice` SET `job_id`=?,`addition_chargeid`=?,`date`=?,`subject`=?,`task_description`=?,`task_quty`=?,`task_unit_price`=?,`task_gst`=?,`task_amount_aud`=?");
                $ins_det->execute(array($ins_id, $additionalcharge['id'], $cudate, 'Additional Charge', $additionalcharge['name'], '1', $additionchargprc[$key], '10', $totamt));
            }
        }


        foreach ($task_description1 as $key => $value) {
            //echo "teste";exit;
            if ($task_description1[$key] != '') {
                $totamt = $task_unitprice[$key];

                $ins_det = $db->prepare("INSERT INTO `job_task` SET `job_id`=?,`description`=?,`qty`=?,`per_rate`=?,`total_rate`=?,`passup`=?,`passup_rate`=?,`amount`=?");
                $ins_det->execute(array($ins_id, $task_description1[$key], $task_qty1[$key], $task_unitprice1[$key], $task_totamount1[$key], $task_passup1[$key], $task_passup11[$key], $passup_amount1[$key]));
            }
        }


        /*
          foreach($task_passup_request as $key => $value){
          if($task_passup_request[$key]!=''){
          $ins_det = $db->prepare("INSERT INTO `jobs_new_details` SET `job_id`=?,`passup_request`=?,`description`=?,`unit_price`=?,`qty`=?,`tax`=?,`tax_amount`=?,`amount`=?");
          $ins_det->execute(array($ins_id,$task_passup_request[$key],$task_description[$key],$task_price[$key],$task_qty[$key],$task_tax[$key],$task_tax_amount[$key],$task_amount[$key]));
          }
          } */

        $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';
    } else {


        $ins = $db->prepare("UPDATE `jobs_new` SET `finalnettotal`=?,`cusreference`=?,`job_notes`=?,`additionalchargerate`=?,`tax_id`=?,`additionalchargeprice`=?,`datetime`=?,`jobid`=?,`customer`=?,`price_category`=?,`pickup_date`=?,`pickup_time`=?,`pickup_location`=?,`pickup_lat`=?,`pickup_lng`=?,`drop_location`=?,`drop_lat`=?,`drop_lng`=?,`km`=?,`description`=?,`status`=?,`subtotal`=?,`nettotal`=?,`tax`=?,`additionalcharge`=?,`empqty1`=?,`emptotal`=?,`ip`=?,`modified_date`=? WHERE `id`=?");
        $ins->execute(array($finalnettotal, $cusreference,$job_notes, $additionchargprc, $task_tax, $amt, $cudate, $jobid, $customer, $price_category, date("Y-m-d", strtotime($pickup_date)), date("H:i:s", strtotime($pickup_time)), $pickup_location, $pickup_lat, $pickup_lng, $drop_location, $drop_lat, $drop_lng, $km, $description, $status, $subtotal, $nettotal, $tax, $additioncharg, $empqty1, $Emptotal, $ip, date("Y-m-d H:i:s"), $getid));


        $get1 = $db->prepare("DELETE FROM `job_invoice` WHERE `job_id` = ? ");
        $get1->execute(array($getid));


        $get2 = $db->prepare("DELETE FROM `job_task` WHERE `job_id` = ? ");
        $get2->execute(array($getid));


        $ins_id = $getid;

        $task_description1 = explode('*&&*&*', $task_description);
        $task_qty1 = explode(',', $task_qty);
        $task_unitprice1 = explode(',', $task_unitprice);


        $task_totamount1 = explode(',', $task_totamount);
        $task_passup1 = explode(',', $passupvalue);
        $task_passup11 = explode(',', $task_passup12);
        $passup_amount1 = explode(',', $passup_amount2);

        foreach ($task_description1 as $key => $value) {
            //echo "teste";exit;
            if ($task_description1[$key] != '') {
                $totamt = $task_totamount1[$key];

                $ins_det = $db->prepare("INSERT INTO `job_invoice` SET `job_id`=?,`date`=?,`subject`=?,`task_description`=?,`task_quty`=?,`task_unit_price`=?,`task_gst`=?,`task_amount_aud`=?");
                $ins_det->execute(array($ins_id, $cudate, 'Task', $task_description1[$key], $task_qty1[$key], $task_unitprice1[$key], '10', $totamt));
            }
        }

        $task_passup8 = explode(',', $passupvalue);
        foreach ($task_passup8 as $key => $value) {
            if ($value != '') {
                $passup = FETCH_all("SELECT * FROM `passup` WHERE `id` = ?", $value);
                $totamt = $task_totamount1[$key] * $passup['value'] / 100;
                $cudate = date('Y-m-d');

                $ins_det = $db->prepare("INSERT INTO `job_invoice` SET `job_id`=?,`date`=?,`subject`=?,`task_description`=?,`task_quty`=?,`task_unit_price`=?,`task_gst`=?,`task_amount_aud`=?");
                $ins_det->execute(array($ins_id, $cudate, 'Passup Charge', $passup['name'], '1', $task_passup12[$key], '10', $totamt));
            }
        }

        $task_description21 = explode('*&&*&*', $task_description2);
        $task_employee21 = explode(',', $task_employee2);
        $task_unitprice21 = explode(',', $task_unitprice2);
        $empqty11 = explode(',', $task_qty2);
        $empextraamt = explode(',', $task_extraamt);

        $task_empamt21 = explode(',', $task_empamt2);

        foreach ($task_description21 as $key => $value) {
            if ($task_empamt21[$key] != '') {

                $totamt = $task_empamt21[$key] * $empqty11[$key];
                $cudate = date('Y-m-d');
                
                if($pay_id[$key]==''){
                    $ins_det = $db->prepare("INSERT INTO `paycalculation` SET `employee`=?,`job_id`=?,`date`=?,`task_extra_amt`=?,`subject`=?,`task_description`=?,`task_quty`=?,`task_unit_price`=?,`task_gst`=?,`task_amount_aud`=?");
                    $ins_det->execute(array($task_employee21[$key], $ins_id, date("Y-m-d", strtotime($pickup_date)), $empextraamt[$key], 'Worker Charge', $task_description21[$key], $empqty11[$key], $task_unitprice21[$key], '10', $task_empamt21[$key]));
                    $linsid = $db->lastInsertId();
                }else{
                    if(getpaycalc('id',$pay_id[$key])==''){
                        $ins_det = $db->prepare("INSERT INTO `paycalculation` SET `employee`=?,`job_id`=?,`date`=?,`task_extra_amt`=?,`subject`=?,`task_description`=?,`task_quty`=?,`task_unit_price`=?,`task_gst`=?,`task_amount_aud`=?");
                        $ins_det->execute(array($task_employee21[$key], $ins_id, date("Y-m-d", strtotime($pickup_date)), $empextraamt[$key], 'Worker Charge', $task_description21[$key], $empqty11[$key], $task_unitprice21[$key], '10', $task_empamt21[$key]));                        
                        $linsid = $db->lastInsertId();
                    }else{
                        $ins_det = $db->prepare("UPDATE `paycalculation` SET `employee`=?,`job_id`=?,`date`=?,`task_extra_amt`=?,`subject`=?,`task_description`=?,`task_quty`=?,`task_unit_price`=?,`task_gst`=?,`task_amount_aud`=? WHERE `id`=?");
                        $ins_det->execute(array($task_employee21[$key], $ins_id, date("Y-m-d", strtotime($pickup_date)), $empextraamt[$key], 'Worker Charge', $task_description21[$key], $empqty11[$key], $task_unitprice21[$key], '10', $task_empamt21[$key],$pay_id[$key]));
                        $linsid = $pay_id[$key];
                    }                    
                }

                $ins_det = $db->prepare("INSERT INTO `job_invoice` SET `employee`=?,`job_id`=?,`date`=?,`task_extra_amt`=?,`subject`=?,`task_description`=?,`task_quty`=?,`task_unit_price`=?,`task_gst`=?,`task_amount_aud`=?,`pay_id`=?");
                $ins_det->execute(array($task_employee21[$key], $ins_id, $cudate, $empextraamt[$key], 'Worker Charge', $task_description21[$key], $empqty11[$key], $task_unitprice21[$key], '10', $task_empamt21[$key],$linsid));
            }
        }



        $additionchargprc = explode(',', $additionchargprc);
        $additioncharg1 = explode(',', $additioncharg);
        foreach ($additioncharg1 as $key => $value) {
            if ($value != '') {
                $additionalcharge = FETCH_all("SELECT * FROM `additional_charges` WHERE `id` = ?", $value);
                $totamt = $subtotal * ($additionchargprc[$key] / 100);
                $cudate = date('Y-m-d');
                $ins_det = $db->prepare("INSERT INTO `job_invoice` SET `job_id`=?,`addition_chargeid`=?,`date`=?,`subject`=?,`task_description`=?,`task_quty`=?,`task_unit_price`=?,`task_gst`=?,`task_amount_aud`=?");
                $ins_det->execute(array($ins_id, $additionalcharge['id'], $cudate, 'Additional Charge', $additionalcharge['name'], '1', $additionchargprc[$key], '10', $totamt));
            }
        }




        foreach ($task_description1 as $key => $value) {
            //echo "teste";exit;
            if ($task_description1[$key] != '') {
                $totamt = $task_unitprice[$key];

                $ins_det = $db->prepare("INSERT INTO `job_task` SET `job_id`=?,`description`=?,`qty`=?,`per_rate`=?,`total_rate`=?,`passup`=?,`passup_rate`=?,`amount`=?");
                $ins_det->execute(array($ins_id, $task_description1[$key], $task_qty1[$key], $task_unitprice1[$key], $task_totamount1[$key], $task_passup1[$key], $task_passup11[$key], $passup_amount1[$key]));
            }
        }


        $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-check"></i>Successfully Updated</h4></div>';
    }
    return $res;
}

function deljob($a) {
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);

    $err_ids = [];

    foreach ($b as $c) {
        global $db;
        $del_check = $db->prepare("SELECT `id` FROM `jobinvoice` WHERE FIND_IN_SET('$c',`jobids`)");
        $del_check->execute();
        if ($del_check->rowCount() > 0) {
            $err_ids[] = $c;
        } else {
            /*$get0 = $db->prepare("DELETE FROM `paycalculation` WHERE `job_id`=?");
            $get0->execute(array($c));
            $get1 = $db->prepare("DELETE FROM `jobs_new_details` WHERE `job_id`=?");
            $get1->execute(array($c));
            $get2 = $db->prepare("DELETE FROM `job_task` WHERE `job_id`=?");
            $get2->execute(array($c));
            $get3 = $db->prepare("DELETE FROM `job_invoice` WHERE `job_id`=?");
            $get3->execute(array($c));
            $get4 = $db->prepare("DELETE FROM `jobs_new` WHERE `id` = ? ");
            $get4->execute(array($c));*/
            $get4 = $db->prepare("UPDATE `jobs_new` SET `status`=? WHERE `id` = ? ");
            $get4->execute(array('4',$c));
        }
    }
    if (!empty($err_ids)) {
        $jobidss = [];
        foreach ($err_ids as $err_id) {
            $jobidss[] = getjob('jobid', $err_id);
        }
        $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i> ' . implode(',', $jobidss) . ' Jobs Are Not Deleted! Because these job have invoices</h4></div>';
    } else {
        $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i> Successfully Deleted!</h4></div>';
    }
    return $res;
}

function getjob($a, $b) {
    global $db;
    $get1 = $db->prepare("SELECT * FROM `jobs_new` WHERE `id`=?");
    $get1->execute(array($b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}

function addjobalerts($work_start,$customer_location_reached,$trip_start,$trip_end,$job_completed){
    global $db;
    $get1 = $db->prepare("UPDATE `job_alerts` SET `work_start`=?,`customer_location_reached`=?,`trip_start`=?,`trip_end`=?,`job_completed`=?,`updated_time`=?,`updated_ip`=?,`updated_by`=? WHERE `id`=?");
    $get1->execute([$work_start,$customer_location_reached,$trip_start,$trip_end,$job_completed,date("Y-m-d H:i:s"),getClientIP(),$_SESSION['UID'],'1']);
    $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-check"></i> Successfully Updated!</h4></div>';
    return $res;
}

function getpaycalc($a, $b) {
    global $db;
    $get1 = $db->prepare("SELECT * FROM `paycalculation` WHERE `id`=?");
    $get1->execute(array($b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}

function addpaycalculation($payid1, $employee, $task_invoicedate, $task_invoiceid,$task_job_id, $task_empdesc, $task_empunitprice, $task_quty, $task_extraamt, $task_tot_amt, $task_paid_amt, $task_payable_amt, $status) {

    global $db;
    $invoicedate = explode(',', $task_invoicedate);
    $invoiceid1 = explode(',', $task_invoiceid);
    $job_id1 = explode(',', $task_job_id);
    $emp_desc = explode(',', $task_empdesc);
    $unitprice = explode(',', $task_empunitprice);
    $task_qty = explode(',', $task_quty);
    $extra_amt = explode(',', $task_extraamt);
    $tot_amt = explode(',', $task_tot_amt);
    $paid_amt = explode(',', $task_paid_amt);
    $payable_amt = explode(',', $task_payable_amt);
    $status = explode(',', $status);
    $payid = explode(',', $payid1);



    foreach ($invoicedate as $key => $value) {

        $ins = $db->prepare("UPDATE `paycalculation` SET `employee`=?,`invoice_id`=?,`job_id`=?,`date`=?,`task_extra_amt`=?,`subject`=?,`task_description`=?,`task_quty`=?,`task_unit_price`=?,`task_gst`=?,`task_amount_aud`=?,`paid_amt`=?,`payable_amt`=?,`status`=? WHERE `id`=?");
        $ins->execute(array($employee, $invoiceid1[$key],$job_id1[$key], $invoicedate[$key], $extra_amt[$key], 'Worker Charge', $emp_desc[$key], $task_qty[$key], $unitprice[$key], '10', $tot_amt[$key], $paid_amt[$key], $payable_amt[$key], $status[$key], $payid[$key]));
    }
    $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-check"></i>Calculations Updated Successfully</h4></div>';
    return $res;
}

function addinvoice($status, $finalnettotal, $task_extraamt, $invoicefrom, $invoice_jobid, $additionchargprc, $task_empamt2, $task_tax, $amt, $passupvalue, $task_passup12, $passup_amount2, $task_totamount, $task_description, $task_qty, $task_unitprice, $task_unitprice1, $additioncharg, $pay_id,$task_employee2, $task_description2, $task_qty2, $task_unitprice2, $jobid, $customer, $price_category, $pickup_date, $pickup_time,$due_date, $pickup_location, $pickup_lat, $pickup_lng, $drop_location, $drop_lat, $drop_lng, $km, $description, $subtotal, $nettotal, $tax, $additionalcharge, $empqty1, $Emptotal, $draft, $jid_t, $jid_a, $jid_w, $ip, $getid) {
    global $db;
    $cudate = date('Y-m-d');
$ret_msg = $draft == '1' ? 'Draft' : 'Invoice';
    if ($getid == '') {

        if ($draft == 0) {
            $invno = get_bill_settings('prefix', '1') . str_pad(get_bill_settings('current_value', '1'), get_bill_settings('format', '1'), '0', STR_PAD_LEFT);
        } else {
            $invno = 0;
        }

        $pickup_date = $pickup_date!='' ? $pickup_date : date("Y-m-d");
        $due_date = $due_date!='' ? $due_date : date("Y-m-d",strtotime("+1 Weeks"));

        $ins = $db->prepare("INSERT INTO `jobinvoice` SET `status`=?,`finalnettotal`=?,`invoice_from`=?,`jobids`=?,`tax_id`=?,`additionalchargerate`=?,`additionalchargeprice`=?,`datetime`=?,`invoiceid`=?,`customer`=?,`price_category`=?,`pickup_date`=?,`pickup_time`=?,`due_date`=?,`pickup_location`=?,`pickup_lat`=?,`pickup_lng`=?,`drop_location`=?,`drop_lat`=?,`drop_lng`=?,`km`=?,`description`=?,`subtotal`=?,`nettotal`=?,`tax`=?,`additionalcharge`=?,`empqty1`=?,`emptotal`=?,`ip`=?,`draft`=?");
        $ins->execute(array($status, $finalnettotal, $invoicefrom, $invoice_jobid, $task_tax, $additionchargprc, $amt, $cudate, $invno, $customer, $price_category, date("Y-m-d", strtotime($pickup_date)), date("H:i:s", strtotime($pickup_time)),date("Y-m-d", strtotime($due_date)), $pickup_location, $pickup_lat, $pickup_lng, $drop_location, $drop_lat, $drop_lng, $km, $description, $subtotal, $nettotal, $tax, $additioncharg, $empqty1, $Emptotal, $ip, $draft));

        $ins_id = $db->lastInsertId();

        if ($draft == '0') {
            update_bill_value('1');
        }



        $task_description1 = explode('*&&*&*', $task_description);
        $task_qty1 = explode(',', $task_qty);
        $task_unitprice1 = explode(',', $task_unitprice);


        $task_totamount1 = explode(',', $task_totamount);
        $task_passup1 = explode(',', $passupvalue);
        $task_passup11 = explode(',', $task_passup12);
        $passup_amount1 = explode(',', $passup_amount2);

        foreach ($task_description1 as $key => $value) {
            //echo "teste";exit;
            if ($task_description1[$key] != '') {
                $totamt = $task_totamount1[$key];
                $jid_t[$key - 1] = $jid_t[$key - 1] != '' ? $jid_t[$key - 1] : 0;
                $ins_det = $db->prepare("INSERT INTO `job_newinvoice` SET `job_id`=?,`jid`=?,`date`=?,`subject`=?,`task_description`=?,`task_quty`=?,`task_unit_price`=?,`task_gst`=?,`task_amount_aud`=?");
                $ins_det->execute(array($ins_id, $jid_t[$key - 1], $cudate, 'Task', $task_description1[$key], $task_qty1[$key], $task_unitprice1[$key], '10', $totamt));
            }
        }

        $task_passup8 = explode(',', $passupvalue);
        foreach ($task_passup8 as $key => $value) {
            if ($value != '') {
                $passup = FETCH_all("SELECT * FROM `passup` WHERE `id` = ?", $value);
                $totamt = $task_totamount1[$key] * $passup['value'] / 100;
                $cudate = date('Y-m-d');

                $ins_det = $db->prepare("INSERT INTO `job_newinvoice` SET `job_id`=?,`date`=?,`subject`=?,`task_description`=?,`task_quty`=?,`task_unit_price`=?,`task_gst`=?,`task_amount_aud`=?");
                $ins_det->execute(array($ins_id, $cudate, 'Passup Charge', $passup['name'], '1', $task_passup12[$key], '10', $totamt));
            }
        }

        $task_description21 = explode('*&&*&*', $task_description2);
        $task_employee21 = explode(',', $task_employee2);
        $task_unitprice21 = explode(',', $task_unitprice2);
        $empqty11 = explode(',', $task_qty2);
        $empextraamt = explode(',', $task_extraamt);

        $task_empamt21 = explode(',', $task_empamt2);

        foreach ($task_description21 as $key => $value) {
            if ($task_empamt21[$key] != '') {

                $totamt = $task_empamt21[$key] * $empqty11[$key];
                $cudate = date('Y-m-d');
                $jid_w[$key - 1] = $jid_w[$key - 1] != '' ? $jid_w[$key - 1] : 0;
                
                if($jid_w[$key - 1] != 0){
                    $chkpay = $db->prepare("SELECT `id` FROM `paycalculation` WHERE `job_id`=? ORDER BY `id` DESC LIMIT 1");
                    $chkpay->execute(array($jid_w[$key - 1]));
                    $getpay = $chkpay->fetch();
                    $ins_det1 = $db->prepare("UPDATE `paycalculation` SET `invoice_id`=? WHERE id=?");
                    $ins_det1->execute(array($ins_id, $getpay['id']));
                    $linsid = $getpay['id'];
                }else{
                    $ins_det = $db->prepare("INSERT INTO `paycalculation` SET `employee`=?,`invoice_id`=?,`date`=?,`task_extra_amt`=?,`subject`=?,`task_description`=?,`task_quty`=?,`task_unit_price`=?,`task_gst`=?,`task_amount_aud`=?");
                    $ins_det->execute(array($task_employee21[$key], $ins_id, date("Y-m-d", strtotime($pickup_date)), $empextraamt[$key], 'Worker Charge', $task_description21[$key], $empqty11[$key], $task_unitprice21[$key], '10', $task_empamt21[$key]));
                    $linsid = $db->lastInsertId();
                }                                                                
                $linsid = $linsid != '' ? $linsid : 0;
                $ins_det = $db->prepare("INSERT INTO `job_newinvoice` SET `employee`=?,`job_id`=?,`jid`=?,`date`=?,`task_extra_amt`=?,`subject`=?,`task_description`=?,`task_quty`=?,`task_unit_price`=?,`task_gst`=?,`task_amount_aud`=?,`pay_id`=?");
                $ins_det->execute(array($task_employee21[$key], $ins_id, $jid_w[$key - 1], $cudate, $empextraamt[$key], 'Worker Charge', $task_description21[$key], $empqty11[$key], $task_unitprice21[$key], '10', $task_empamt21[$key],$linsid));
            }
        }


        /*$invobids = explode(',', $invoice_jobid);

        if ($invoice_jobid != '') {
            // $s = "`id` IN ($invoice_jobid)";
            foreach ($invobids as $invobids1) {

                $ins_det1 = $db->prepare("UPDATE `paycalculation` SET `invoice_id`=? WHERE job_id=?");
                $ins_det1->execute(array($ins_id, $invobids1));
            }
        } else {
            foreach ($task_description21 as $key => $value) {
                if ($task_empamt21[$key] != '') {

                    $totamt = $task_empamt21[$key] * $empqty11[$key];
                    $cudate = date('Y-m-d');

                    $ins_det = $db->prepare("INSERT INTO `paycalculation` SET `employee`=?,`invoice_id`=?,`date`=?,`task_extra_amt`=?,`subject`=?,`task_description`=?,`task_quty`=?,`task_unit_price`=?,`task_gst`=?,`task_amount_aud`=?");
                    $ins_det->execute(array($task_employee21[$key], $ins_id, $cudate, $empextraamt[$key], 'Worker Charge', $task_description21[$key], $empqty11[$key], $task_unitprice21[$key], '10', $task_empamt21[$key]));
                }
            }
        }*/

          

        $additionchargprc = explode(',', $additionchargprc);
        $additioncharg1 = explode(',', $additioncharg);
        foreach ($additioncharg1 as $key => $value) {
            if ($value != '') {
                $additionalcharge = FETCH_all("SELECT * FROM `additional_charges` WHERE `id` = ?", $value);
                $totamt = $subtotal * ($additionchargprc[$key] / 100);
                $cudate = date('Y-m-d');

                $jid_a[$key] = $jid_a[$key] != '' ? $jid_a[$key] : 0;

                $ins_det = $db->prepare("INSERT INTO `job_newinvoice` SET `job_id`=?,`jid`=?,`addition_chargeid`=?,`date`=?,`subject`=?,`task_description`=?,`task_quty`=?,`task_unit_price`=?,`task_gst`=?,`task_amount_aud`=?");
                $ins_det->execute(array($ins_id, $jid_a[$key], $additionalcharge['id'], $cudate, 'Additional Charge', $additionalcharge['name'], '1', $additionchargprc[$key], '10', $totamt));
            }
        }


        foreach ($task_description1 as $key => $value) {
            //echo "teste";exit;
            if ($task_description1[$key] != '') {
                $totamt = $task_unitprice[$key];
                $jid_t[$key - 1] = $jid_t[$key - 1] != '' ? $jid_t[$key - 1] : 0;
                $ins_det = $db->prepare("INSERT INTO `job_newtask` SET `job_id`=?,`jid`=?,`description`=?,`qty`=?,`per_rate`=?,`total_rate`=?,`passup`=?,`passup_rate`=?,`amount`=?");
                $ins_det->execute(array($ins_id,$jid_t[$key - 1], $task_description1[$key], $task_qty1[$key], $task_unitprice1[$key], $task_totamount1[$key], $task_passup1[$key], $task_passup11[$key], $passup_amount1[$key]));
            }
        }


        /*
          foreach($task_passup_request as $key => $value){
          if($task_passup_request[$key]!=''){
          $ins_det = $db->prepare("INSERT INTO `jobs_new_details` SET `job_id`=?,`passup_request`=?,`description`=?,`unit_price`=?,`qty`=?,`tax`=?,`tax_amount`=?,`amount`=?");
          $ins_det->execute(array($ins_id,$task_passup_request[$key],$task_description[$key],$task_price[$key],$task_qty[$key],$task_tax[$key],$task_tax_amount[$key],$task_amount[$key]));
          }
          } */
        
        $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-check"></i>'.$ret_msg.' Generated Successfully</h4></div>';
    } else {

        if ($draft == '0' && getinvoice('draft', $getid) == '1') {
            $invno = get_bill_settings('prefix', '1') . str_pad(get_bill_settings('current_value', '1'), get_bill_settings('format', '1'), '0', STR_PAD_LEFT);
            update_bill_value('1');
            $ups = $db->prepare("UPDATE `jobinvoice` SET `invoiceid`=?,`draft`=? WHERE `id`=?");
            $ups->execute(array($invno, '0', $getid));
        }

        $ins = $db->prepare("UPDATE `jobinvoice` SET `status`=?,`finalnettotal`=?,`jobids`=?,`additionalchargerate`=?,`tax_id`=?,`additionalchargeprice`=?,`datetime`=?,`customer`=?,`price_category`=?,`pickup_date`=?,`pickup_time`=?,`due_date`=?,`pickup_location`=?,`pickup_lat`=?,`pickup_lng`=?,`drop_location`=?,`drop_lat`=?,`drop_lng`=?,`km`=?,`description`=?,`subtotal`=?,`nettotal`=?,`tax`=?,`additionalcharge`=?,`empqty1`=?,`emptotal`=?,`ip`=? WHERE `id`=?");
        $ins->execute(array($status, $finalnettotal, $invoice_jobid, $additionchargprc, $task_tax, $amt, $cudate, $customer, $price_category, date("Y-m-d", strtotime($pickup_date)), date("H:i:s", strtotime($pickup_time)), date("Y-m-d", strtotime($due_date)), $pickup_location, $pickup_lat, $pickup_lng, $drop_location, $drop_lat, $drop_lng, $km, $description, $subtotal, $nettotal, $tax, $additioncharg, $empqty1, $Emptotal, $ip, $getid));


        $get1 = $db->prepare("DELETE FROM `job_newinvoice` WHERE `job_id` = ? ");
        $get1->execute(array($getid));


        $get2 = $db->prepare("DELETE FROM `job_newtask` WHERE `job_id` = ? ");
        $get2->execute(array($getid));


        $ins_id = $getid;

        $task_description1 = explode('*&&*&*', $task_description);
        $task_qty1 = explode(',', $task_qty);
        $task_unitprice1 = explode(',', $task_unitprice);


        $task_totamount1 = explode(',', $task_totamount);
        $task_passup1 = explode(',', $passupvalue);
        $task_passup11 = explode(',', $task_passup12);
        $passup_amount1 = explode(',', $passup_amount2);

        foreach ($task_description1 as $key => $value) {
            //echo "teste";exit;
            if ($task_description1[$key] != '') {
                $totamt = $task_totamount1[$key];

                $ins_det = $db->prepare("INSERT INTO `job_newinvoice` SET `job_id`=?,`date`=?,`subject`=?,`task_description`=?,`task_quty`=?,`task_unit_price`=?,`task_gst`=?,`task_amount_aud`=?");
                $ins_det->execute(array($ins_id, $cudate, 'Task', $task_description1[$key], $task_qty1[$key], $task_unitprice1[$key], '10', $totamt));
            }
        }

        $task_passup8 = explode(',', $passupvalue);
        foreach ($task_passup8 as $key => $value) {
            if ($value != '') {
                $passup = FETCH_all("SELECT * FROM `passup` WHERE `id` = ?", $value);
                $totamt = $task_totamount1[$key] * $passup['value'] / 100;
                $cudate = date('Y-m-d');

                $ins_det = $db->prepare("INSERT INTO `job_newinvoice` SET `job_id`=?,`date`=?,`subject`=?,`task_description`=?,`task_quty`=?,`task_unit_price`=?,`task_gst`=?,`task_amount_aud`=?");
                $ins_det->execute(array($ins_id, $cudate, 'Passup Charge', $passup['name'], '1', $task_passup12[$key], '10', $totamt));
            }
        }

        $task_description21 = explode('*&&*&*', $task_description2);
        $task_employee21 = explode(',', $task_employee2);
        $task_unitprice21 = explode(',', $task_unitprice2);
        $empqty11 = explode(',', $task_qty2);
        $empextraamt = explode(',', $task_extraamt);

        $task_empamt21 = explode(',', $task_empamt2);

       /* foreach ($task_description21 as $key => $value) {
            if ($task_empamt21[$key] != '') {

                $totamt = $task_empamt21[$key] * $empqty11[$key];
                $cudate = date('Y-m-d');

                $ins_det = $db->prepare("INSERT INTO `job_newinvoice` SET `employee`=?,`job_id`=?,`date`=?,`task_extra_amt`=?,`subject`=?,`task_description`=?,`task_quty`=?,`task_unit_price`=?,`task_gst`=?,`task_amount_aud`=?");
                $ins_det->execute(array($task_employee21[$key], $ins_id, $cudate, $empextraamt[$key], 'Worker Charge', $task_description21[$key], $empqty11[$key], $task_unitprice21[$key], '10', $task_empamt21[$key]));
            }
        }


        $invobids = explode(',', $invoice_jobid);

        if ($invoice_jobid != '') {
            // $s = "`id` IN ($invoice_jobid)";
            foreach ($invobids as $invobids1) {

                $ins_det1 = $db->prepare("UPDATE `paycalculation` SET `invoice_id`=? WHERE job_id=?");
                $ins_det1->execute(array($ins_id, $invobids1));
            }
        } else {
            foreach ($task_description21 as $key => $value) {
                if ($task_empamt21[$key] != '') {

                    $totamt = $task_empamt21[$key] * $empqty11[$key];
                    $cudate = date('Y-m-d');

                    $ins_det = $db->prepare("INSERT INTO `paycalculation` SET `employee`=?,`invoice_id`=?,`date`=?,`task_extra_amt`=?,`subject`=?,`task_description`=?,`task_quty`=?,`task_unit_price`=?,`task_gst`=?,`task_amount_aud`=?");
                    $ins_det->execute(array($task_employee21[$key], $ins_id, $cudate, $empextraamt[$key], 'Worker Charge', $task_description21[$key], $empqty11[$key], $task_unitprice21[$key], '10', $task_empamt21[$key]));
                }
            }
        }

        foreach ($task_description21 as $key => $value) {
            if ($task_empamt21[$key] != '') {

                $totamt = $task_empamt21[$key] * $empqty11[$key];
                $cudate = date('Y-m-d');

                $ins_det = $db->prepare("INSERT INTO `paycalculation` SET `employee`=?,`job_id`=?,`date`=?,`task_extra_amt`=?,`subject`=?,`task_description`=?,`task_quty`=?,`task_unit_price`=?,`task_gst`=?,`task_amount_aud`=?");
                $ins_det->execute(array($task_employee21[$key], $ins_id, $cudate, $empextraamt[$key], 'Worker Charge', $task_description21[$key], $empqty11[$key], $task_unitprice21[$key], '10', $task_empamt21[$key]));
            }
        }*/


        foreach ($task_description21 as $key => $value) {
            if ($task_empamt21[$key] != '') {

                $totamt = $task_empamt21[$key] * $empqty11[$key];
                $cudate = date('Y-m-d');
                
                $newjid = 0;
                if($pay_id[$key]==''){
                    $ins_det = $db->prepare("INSERT INTO `paycalculation` SET `employee`=?,`invoice_id`=?,`date`=?,`task_extra_amt`=?,`subject`=?,`task_description`=?,`task_quty`=?,`task_unit_price`=?,`task_gst`=?,`task_amount_aud`=?");
                    $ins_det->execute(array($task_employee21[$key], $ins_id, date("Y-m-d", strtotime($pickup_date)), $empextraamt[$key], 'Worker Charge', $task_description21[$key], $empqty11[$key], $task_unitprice21[$key], '10', $task_empamt21[$key]));
                    $linsid = $db->lastInsertId();
                }else{
                    if(getpaycalc('id',$pay_id[$key])==''){
                        $ins_det = $db->prepare("INSERT INTO `paycalculation` SET `employee`=?,`invoice_id`=?,`date`=?,`task_extra_amt`=?,`subject`=?,`task_description`=?,`task_quty`=?,`task_unit_price`=?,`task_gst`=?,`task_amount_aud`=?");
                        $ins_det->execute(array($task_employee21[$key], $ins_id, date("Y-m-d", strtotime($pickup_date)), $empextraamt[$key], 'Worker Charge', $task_description21[$key], $empqty11[$key], $task_unitprice21[$key], '10', $task_empamt21[$key]));                        
                        $linsid = $db->lastInsertId();
                    }else{
                        $dates = (strtolower(getinvoice('invoice_from', $getid))=='job') ? "" : ",`date`='".date("Y-m-d", strtotime($pickup_date))."'";
                    $ins_det = $db->prepare("UPDATE `paycalculation` SET `employee`=?,`invoice_id`=?$dates,`task_extra_amt`=?,`subject`=?,`task_description`=?,`task_quty`=?,`task_unit_price`=?,`task_gst`=?,`task_amount_aud`=? WHERE `id`=?");
                    $ins_det->execute(array($task_employee21[$key], $ins_id, $empextraamt[$key], 'Worker Charge', $task_description21[$key], $empqty11[$key], $task_unitprice21[$key], '10', $task_empamt21[$key],$pay_id[$key]));
                    $linsid = $pay_id[$key];
                    }
                    $getpay = $db->prepare("SELECT job_id FROM `paycalculation` WHERE `id`=?");
                    $getpay->execute(array($pay_id[$key]));
                    $gets = $getpay->fetch();
                    $newjid = $gets['job_id'];
                    $newjid = $newjid != '' ? $newjid : 0;
                }

                $ins_det = $db->prepare("INSERT INTO `job_newinvoice` SET `employee`=?,`job_id`=?,`jid`=?,`date`=?,`task_extra_amt`=?,`subject`=?,`task_description`=?,`task_quty`=?,`task_unit_price`=?,`task_gst`=?,`task_amount_aud`=?,`pay_id`=?");
                $ins_det->execute(array($task_employee21[$key], $ins_id,$newjid, $cudate, $empextraamt[$key], 'Worker Charge', $task_description21[$key], $empqty11[$key], $task_unitprice21[$key], '10', $task_empamt21[$key],$linsid));
            }
        }
        
        
        $additionchargprc = explode(',', $additionchargprc);
        $additioncharg1 = explode(',', $additioncharg);
        foreach ($additioncharg1 as $key => $value) {
            if ($value != '') {
                $additionalcharge = FETCH_all("SELECT * FROM `additional_charges` WHERE `id` = ?", $value);
                $totamt = $subtotal * ($additionchargprc[$key] / 100);
                $cudate = date('Y-m-d');
                $ins_det = $db->prepare("INSERT INTO `job_newinvoice` SET `job_id`=?,`addition_chargeid`=?,`date`=?,`subject`=?,`task_description`=?,`task_quty`=?,`task_unit_price`=?,`task_gst`=?,`task_amount_aud`=?");
                $ins_det->execute(array($ins_id, $additionalcharge['id'], $cudate, 'Additional Charge', $additionalcharge['name'], '1', $additionchargprc[$key], '10', $totamt));
            }
        }




        foreach ($task_description1 as $key => $value) {
            //echo "teste";exit;
            if ($task_description1[$key] != '') {
                $totamt = $task_unitprice[$key];

                $ins_det = $db->prepare("INSERT INTO `job_newtask` SET `job_id`=?,`description`=?,`qty`=?,`per_rate`=?,`total_rate`=?,`passup`=?,`passup_rate`=?,`amount`=?");
                $ins_det->execute(array($ins_id, $task_description1[$key], $task_qty1[$key], $task_unitprice1[$key], $task_totamount1[$key], $task_passup1[$key], $task_passup11[$key], $passup_amount1[$key]));
            }
        }


        $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-check"></i>Successfully Updated</h4></div>';
    }
    return $res;
}

function delinvoice($a) {
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    foreach ($b as $c) {
        global $db;
        $getpay = $db->prepare("SELECT `id`,`job_id` FROM `paycalculation` WHERE `invoice_id`='$c'");
        $getpay->execute();
        while($fetchpay = $getpay->fetch()){
            if($fetchpay['job_id']!=''){
                $get0 = $db->prepare("UPDATE `paycalculation` SET `invoice_id`='' WHERE `id`=?");
                $get0->execute(array($fetchpay['id']));
            }else{
                $get0 = $db->prepare("DELETE FROM `paycalculation` WHERE `id`=?");
                $get0->execute(array($fetchpay['id']));
            }
        }               
        $get1 = $db->prepare("DELETE FROM `jobinvoice` WHERE `id`=?");
        $get1->execute(array($c));
        $get = $db->prepare("DELETE FROM `job_newinvoice` WHERE `job_id` = ? ");
        $get->execute(array($c));
        $get3 = $db->prepare("DELETE FROM `job_newtask` WHERE `job_id` = ? ");
        $get3->execute(array($c));
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i> Successfully Deleted!</h4></div>';
    return $res;
}

function getinvoice($a, $b) {
    global $db;
    $get1 = $db->prepare("SELECT * FROM `jobinvoice` WHERE `id`=?");
    $get1->execute(array($b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}

function getnewinvoice($a, $b) {
    global $db;
    $get1 = $db->prepare("SELECT * FROM `job_newinvoice` WHERE `id`=?");
    $get1->execute(array($b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}

function addjobtype($type, $uom, $priceperunit, $order, $description, $status, $ip, $getid) {
    global $db;
    if ($getid == '') {

        $resa = $db->prepare("INSERT INTO `jobtype` (`type`,`uom`,`priceperunit`,`order`,`description`,`status`) VALUES(?,?,?,?,?,?)");
        $resa->execute(array($type, $uom, $priceperunit, $order, $description, $status));

        $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
        $htry->execute(array('Job Type Mgmt', 13, 'INSERT', $_SESSION['UID'], $ip, $id));

        $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';
    } else {
        $resa = $db->prepare("UPDATE `jobtype` SET `type`=?,`uom`=?,`priceperunit`=?,`order`=?,`description`=?,`status`=? WHERE `id`=?");
        $resa->execute(array($type, $uom, $priceperunit, $order, $description, $status, $getid));

        $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
        $htry->execute(array('Jobs Mgmt', 15, 'UPDATE', $_SESSION['UID'], $ip, $getid));

        $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><h4><i class="icon fa fa-check"></i>Successfully Updated</h4></div>';
    }
    return $res;
}

function deljobtype($a) {
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    foreach ($b as $c) {
        global $db;
        $get = $db->prepare("UPDATE `jobtype` SET `status`=? WHERE `id` = ? ");
        $get->execute(array('2', $c));
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i> Successfully Deleted!</h4></div>';
    return $res;
}

function getjobtype($a, $b) {
    global $db;
    $get1 = $db->prepare("SELECT * FROM `jobtype` WHERE `id`=?");
    $get1->execute(array($b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}

function Create_Payslip($employee, $payid) {
    global $db;
    $create_payslip_query = $db->prepare("INSERT INTO `payslip` SET `employee`=?,`date`=?,`draft`=?,`ip`=?");
    $create_payslip_query->execute(array($employee, date("Y-m-d"),'1', getClientIP()));
    $insert_id = $db->lastInsertId();
    foreach ($payid as $payidn) {
        $create_payslip_details = $db->prepare("INSERT INTO `payslip_details` (paycalculation_id,payslip_id,subject,addition_chargeid,employee,job_id,invoice_id,date,task_description,task_quty,task_unit_price,task_gst,task_amount_aud,task_extra_amt,subtotal,tot_gst,total_aud,paid_amt,payable_amt,status) SELECT id,'" . $insert_id . "',subject,addition_chargeid,employee,job_id,invoice_id,date,task_description,task_quty,task_unit_price,task_gst,task_amount_aud,task_extra_amt,subtotal,tot_gst,total_aud,paid_amt,payable_amt,status FROM `paycalculation` WHERE `id`='" . $payidn . "'");
        $create_payslip_details->execute();
    }
}

function InvoiceMail1($contact_ids, $id) {
    global $db,$sitename;
    $jobdetail = FETCH_all("SELECT * FROM `jobinvoice` WHERE `id` = ?", $id);
    $jobinvoice = FETCH_all("SELECT * FROM `job_newinvoice` WHERE `job_id` = ?", $id);
    $mangprofile = FETCH_all("SELECT * FROM `manageprofile` WHERE `pid` = ?", '1');
    $cusdetails = FETCH_all("SELECT * FROM `customer` WHERE `cid` = ?", $jobdetail['customer']);
    $cus_detail22 = '';
    $cus_detail11 = '';
    if ($cusdetails['photo'] != '') {
        $cus_detail22 = '<img src=" ' . $sitename . 'images/customer/' . $cusdetails['photo'] . '" style="padding-bottom:10px;width: 120px;height: 120px;" height="400px" />';
    }
    $cus_detail11 = $cusdetails['companyname'] . '  <br>  ' . $cusdetails['cmpyabnno'] . ' <br> ' . $cusdetails['address1'] . ',' . $cusdetails['address2'] . ',' . $cusdetails['suburb'] . ' <br> ' . $cusdetails['state'] . ' - ' . $cusdetails['postcode'] . ' <br> ' . getValue('countries', 'id', $cusdetails['country'], 'name') . ' <br> ' . $cusdetails['email'] . ' <br> ' . $cusdetails['mobile'] . ' ';

    $cusaddress = $cusdetails['address1'] . ',' . $cusdetails['address2'] . ',' . $cusdetails['suburb'] . ',' . $cusdetails['state'];


    if ($jobdetail['status'] == '2') {
        $sts = "PAID";
    } else {
        $sts = "NOT PAID";
    }
    $MESSAGE .= '<table border="0" style="width:60%" > 
            <tr>  
                <td style="width:70%; float:left;"><img src="' . $sitename . 'images/5aab.png" style="width:80px" /></td> 
                <td style="width:30%; float:left;"></td> 
            </tr> 
            <tr>  
                <td></td> 
                <td></td> 
            </tr> 
            <tr>  
                <td style="width:70%;font-size:30"><b>TAX INVOICE</b></td> 
                <td style="width:30%;"> 
                    <table border="0" style="width:300px; float:left;font-size:11px">  
                        <tr>
                            <td style="width:40%; float:left;"><b>Invoice Date</b><br>' . $jobinvoice['date'] . '</td>
                            <td style="width:5%; float:left;"></td>
                            <td rowspan="2" style="width:55%; float:left">5AAB TRANSPORT<br>Unit 1 , 575 SOMMERVILLE <br> RD , SUNSHINE VIC 3020.<br>AUSTRALIA<br>T: 03 9364 8258 <!--<br> harry : 0422 623 777 <br> Amin : 0411373272--> </td>
                        </tr>
                        <tr>
                            <td style="width:40%; float:left;"><b>Invoice Number</b><br>INV-' . $jobdetail['invoiceid'] . '</td>
                            <td style="width:5%; float:left;"></td>                            
                        </tr>
						<tr>
						<td colspan="3">&nbsp;</td>
						</tr><tr>
						<td colspan="3">&nbsp;</td>
						</tr>
						 <!--<tr>
                            <td style="width:40%; float:left;"><b>STATUS</b></td>
							<td style="width:5%; float:left;"></td>
                            <td style="width:20%; float:left;">' . $sts . '</td>
							</tr>--><tr>
                            <td style="width:40%; float:left;"><b>Cusotmer Reference</b></td>
							<td style="width:5%; float:left;"></td>
                            <td style="width:20%; float:left;">' . $jobdetail['description'] . '</td>
							</tr>
                                                        <tr>
						<td colspan="3">&nbsp;</td>
						</tr><tr>
						<td colspan="3">&nbsp;</td>
						</tr>
                                                <tr>
                            <td style="width:40%; float:left;"><b>ABN Number</b></td>
							<td style="width:5%; float:left;"></td>
                            <td style="width:20%; float:left;">' . getprofile('abn', 1) . '</td>
							</tr>
						
						
                    </table> 
                </td> 
            </tr> 
			
            <tr>
			<td><table border="0" style="width:300px; float:left;font-size:11px"> 
                        <tr>
                            <td style=" float:left;">' . $cus_detail22 . '</td>
                            <td style=" float:left;">' . $cus_detail11 . '</td>                            
                        </tr>            
                    </table></td>
</tr> 			
        </table>  
        
        <table style="width:60%;margin-top:100px;font-size:11px">
          <tr> 
           <td style="padding:10px;border-bottom:1px solid;text-align:left;width:50%"> <b>Description</b> </td>
           <td style="padding:10px;border-bottom:1px solid;text-align:left;width:10%"> <b>Quantity</b> </td>
           <td style="padding:10px;border-bottom:1px solid;text-align:left;width:15%"> <b>Unit Price</b> </td>
           <td style="padding:10px;border-bottom:1px solid;text-align:left;width:10%"> <b>GST</b> </td>
           <td style="padding:10px;border-bottom:1px solid;text-align:right;width:15%"> <b>Amount AUD</b> </td>
          </tr>';


    $futotal = '';
    $jobs = pFETCH("SELECT * FROM `job_newinvoice` WHERE `subject`=? AND `job_id`=? ", 'Task', $id);
    while ($jobslist = $jobs->fetch(PDO::FETCH_ASSOC)) {
        $tamount += $jobslist['task_amount_aud'];

        //$uprice=$jobslist['task_quty']*$jobslist['task_amount_aud'];

        $date = date_create($jobslist['date']);

        $futotal += $jobslist['task_amount_aud'];
        $MESSAGE .= '<tr> 
           <td style="padding:10px;border-bottom:1px solid  #ddd;text-align:left;width:50%">' . $jobslist['task_description'] . '<br>' . date_format($date, "d M") . '<br>' . $jobdetail['jobid'] . ' ' . $jobdetail['drop_location'] . '</td>
           <td style="padding:10px;border-bottom:1px solid #ddd;text-align:left;width:10%">' . $jobslist['task_quty'] . '</td>
           <td style="padding:10px;border-bottom:1px solid #ddd;text-align:left;width:15%">' . $jobslist['task_unit_price'] . '</td>
           <td style="padding:10px;border-bottom:1px solid #ddd;text-align:left;width:10%">10%</td>
           <td style="padding:10px;border-bottom:1px solid #ddd;text-align:right;width:15%">' . $jobslist['task_amount_aud'] . '</td>
          </tr>';
    }
    $jobs = pFETCH("SELECT * FROM `job_newinvoice` WHERE `subject`=? AND `job_id`=? ", 'Passup Charge', $id);
    while ($jobslist = $jobs->fetch(PDO::FETCH_ASSOC)) {
        $tamount += $jobslist['task_amount_aud'];
        if ($jobslist['task_amount_aud'] == 'Passup Charge') {
            $uprice = $jobslist['task_quty'] * $jobslist['task_amount_aud'];
        } else {
            $uprice = $jobslist['task_unit_price'];
        }
        $date = date_create($jobslist['date']);

        $futotal += $jobslist['task_amount_aud'];
        $MESSAGE .= '<tr> 
           <td style="padding:10px;border-bottom:1px solid  #ddd;text-align:left;width:50%">' . $jobslist['task_description'] . '<br>' . date_format($date, "d M") . '<br>' . $jobdetail['jobid'] . ' ' . $jobdetail['drop_location'] . '</td>
           <td style="padding:10px;border-bottom:1px solid #ddd;text-align:left;width:10%">' . $jobslist['task_quty'] . '</td>
           <td style="padding:10px;border-bottom:1px solid #ddd;text-align:left;width:15%">' . $jobslist['task_unit_price'] . '</td>
           <td style="padding:10px;border-bottom:1px solid #ddd;text-align:left;width:10%">10%</td>
           <td style="padding:10px;border-bottom:1px solid #ddd;text-align:right;width:15%">' . $jobslist['task_amount_aud'] . '</td>
          </tr>';
    }
    $jobs = pFETCH("SELECT * FROM `job_newinvoice` WHERE `subject`=? AND `job_id`=? ", 'Additional Charge', $id);
    while ($jobslist = $jobs->fetch(PDO::FETCH_ASSOC)) {
        $tamount += $jobslist['task_unit_price'];
//$date = date_create($jobslist['date']);


        $futotal += $jobslist['task_unit_price'];
        $MESSAGE .= '<tr> 
           <td style="padding:10px;border-bottom:1px solid  #ddd;text-align:left;width:50%">' . $jobslist['task_description'] . '<br>' . date_format($date, "d M") . '<br>' . $jobdetail['jobid'] . ' ' . $jobdetail['drop_location'] . '</td>
           <td style="padding:10px;border-bottom:1px solid #ddd;text-align:left;width:10%">' . $jobslist['task_quty'] . '</td>
           <td style="padding:10px;border-bottom:1px solid #ddd;text-align:left;width:15%">' . $jobslist['task_unit_price'] . '</td>
           <td style="padding:10px;border-bottom:1px solid #ddd;text-align:left;width:10%">10%</td>
           <td style="padding:10px;border-bottom:1px solid #ddd;text-align:right;width:15%">' . $jobslist['task_unit_price'] . '</td>
          </tr>';
    }

    $tax = $futotal * $mangprofile['tax'] / 100;
    $tt = $futotal + $tax;
    $MESSAGE .= ' <tr> 
           <td style="padding:10px;width:50%"> </td>
           <td style="padding:10px;text-align:left;width:10%"> </td>
           <td colspan="2" style="padding:10px;text-align:right;width:25%"> Subtotal </td>          
           <td style="padding:10px;text-align:right;width:15%">$' . $futotal . ' </td>
          </tr>
          
         <tr> 
           <td style="padding:10px;width:50%"> </td>
           <td style="padding:10px;text-align:left;width:10%"> </td>
           <td colspan="2" style="padding:10px;text-align:right;width:25%"> GST (' . $mangprofile['tax'] . '%)</td>          
           <td style="padding:10px;text-align:right;width:15%">$' . $tax . '</td>
          </tr>
          <tr> 
           <td style="padding:10px;width:50%"> </td>
           <td style="padding:10px;text-align:left;width:10%"> </td>
           <td colspan="2" style="padding:10px;text-align:right;width:25%"><b> TOTAL AUD </b></td>          
           <td style="padding:10px;text-align:right;width:15%"> <b>$' . $tt . '</b> </td>
          </tr>
          
        </table> 
        
       

        ';
    $HEADERS = "From: 5AAB < " . getprofile('recoveryemail', 1) . " >\n";
    $HEADERS .= "X-Sender: 5AAB < " . getprofile('recoveryemail', 1) . " >\n";
    $HEADERS .= 'X-Mailer: PHP/' . phpversion();
    $HEADERS .= "X-Priority: 1\n"; // Urgent message!
    //$headers .= "Return-Path: itsolusenz1@gmail.com\n"; // Return path for errors
    $HEADERS .= "MIME-Version: 1.0\r\n";
    $HEADERS .= "Content-Type: text/html; charset=iso-8859-1\n";
    foreach ($contact_ids as $selc) {
        $get1 = $db->prepare("SELECT * FROM `contact_informations` WHERE `id` = ?");
        $get1->execute(array($selc));
        while ($fetch_records = $get1->fetch(PDO::FETCH_ASSOC)) {
            mail($fetch_records['contact_email'], 'Invoice - 5AAB', $MESSAGE, $HEADERS);
        }
    }
}
function InvoiceMail($contact_ids, $id) {
    global $db, $sitename;
    $jobinvoice = FETCH_all("SELECT * FROM `jobinvoice` WHERE `id`=?", $id);
    $uid = md5(uniqid(time()));
    file_get_contents($sitename.'MPDF/invoice/invoice.php?id='.$id.'&saveY='.$uid);    
    $content = chunk_split(base64_encode(file_get_contents($sitename.'MPDF/invoice/'.$uid.'.pdf')));
    $HEADERS = "From: 5AAB < " . getprofile('recoveryemail', 1) . " >\n";
    $HEADERS .= "X-Sender: 5AAB < " . getprofile('recoveryemail', 1) . " >\n";
    $HEADERS .= 'X-Mailer: PHP/' . phpversion();
    $HEADERS .= "X-Priority: 1\n"; // Urgent message!
    //$headers .= "Return-Path: itsolusenz1@gmail.com\n"; // Return path for errors
    $HEADERS .= "MIME-Version: 1.0\r\n";
    //$HEADERS .= "Content-Type: text/html; charset=iso-8859-1\n";
    $HEADERS .= "Content-Type: multipart/mixed; boundary=\"" . $uid . "\"\r\n\r\n";
    
    $MESSAGE .= "--" . $uid . "\r\n";
    $MESSAGE .= "Content-type:text/html; charset=utf-8\n";
    $MESSAGE .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
    $MESSAGE .=  getemailtemplate('description','1') . "\r\n\r\n";

    $MESSAGE .= "--" . $uid . "\r\n";
    $MESSAGE .= "Content-Type: application/octet-stream; name=\"Invoice No - ".$jobinvoice['invoiceid'].".pdf\"\r\n"; // use different content types here
    $MESSAGE .= "Content-Transfer-Encoding: base64\r\n";
    $MESSAGE .= "Content-Disposition: attachment; filename=\"Invoice No - ".$jobinvoice['invoiceid'].".pdf\"\r\n\r\n"; // For Attachment
    $MESSAGE .= $content . "\r\n\r\n";
    $MESSAGE .= "--" . $uid . "--";
//            mail(getdriver('email',$viewpay['employee']),'Pay Slip - 5AAB',$MESSAGE,$HEADERS);
     foreach ($contact_ids as $selc) {
        $get1 = $db->prepare("SELECT * FROM `contact_informations` WHERE `id` = ?");
        $get1->execute(array($selc));
        while ($fetch_records = $get1->fetch(PDO::FETCH_ASSOC)) {
            //mail($fetch_records['contact_email'], 'Invoice - 5AAB', $MESSAGE, $HEADERS);
            mail($fetch_records['contact_email'], getemailtemplate('subject','1'), $MESSAGE,$HEADERS);
        }
    }   
    unlink('../../MPDF/invoice/'.$uid.'.pdf');
}
function PayslipMail1($id){
    global $db,$sitename;
    $payslip = FETCH_all("SELECT * FROM `payslip` WHERE `id` = ?", $id);
$mangprofile = FETCH_all("SELECT * FROM `manageprofile` WHERE `pid` = ?", '1');
$cusdetails = FETCH_all("SELECT * FROM `driver` WHERE `did` = ?", $payslip['employee']);
$cus_detail22 = '';
$cus_detail11 = '';
if ($cusdetails['photo'] != '') {
    $cus_detail22 = '<img src=" ' . $sitename . 'images/driver/profile/' . $cusdetails['photo'] . '" style="padding-bottom:10px;width: 120px;height: 120px;" height="400px" /><br />';
}
$cus_detail11 = $cusdetails['firstname'].' '.$cusdetails['lastname'].'<br />'.$cusdetails['address1'] . ',' . $cusdetails['address2'] . ',' . $cusdetails['suburb'] . ' <br> ' . $cusdetails['state'] . ' - ' . $cusdetails['postcode'] . ' <br> ' . getValue('countries', 'id', $cusdetails['country'], 'name') . ' <br> ' . $cusdetails['email'] . ' <br> ' . $cusdetails['mobile'] . ' ';

$cusaddress = $cusdetails['address1'] . ',' . $cusdetails['address2'] . ',' . $cusdetails['suburb'] . ',' . $cusdetails['state'];


if ($jobdetail['status'] == '2') {
    $sts = "PAID";
} else {
    $sts = "NOT PAID";
}

$MESSAGE .= '<table border="0" style="width:60%" > 
            <tr>  
                <td style="width:70%; float:left;"><img src="'.$sitename.'images/5aab.png" style="width:80px" /></td> 
                <td style="width:30%; float:left;"></td> 
            </tr> 
            <tr>  
                <td colspan="2"></td> 
            </tr> 
            <tr>  
                <td style="width:70%;font-size:30;vertical-align:top;"><b>Pay Slip</b></td> 
                <td style="width:30%;"> 
                    <table border="0" style="width:300px; float:left;">  
                        <tr>
                            <td style="width:40%; float:left;vertical-align:top;"><b>Pay Slip Date</b><br>' . $payslip['date'] . '</td>
                            <td style="width:5%; float:left;"></td>
                            <td rowspan="2" style="width:55%; float:left">5AAB TRANSPORT<br>Unit 1 , 575 SOMMERVILLE <br> RD , SUNSHINE VIC 3020.<br>AUSTRALIA<br>T: 03 9364 8258 <!--<br> harry : 0422 623 777 <br> Amin : 0411373272--> </td>
                        </tr>		
                    </table> 
                </td> 
            </tr> 
			
            <tr>
			<td colspan="2">
                        <table border="0" style="width:300px; float:left;"> 
                        <tr>
                            <td style=" float:left;">' . $cus_detail22 . '</td>
                            <td style=" float:left;">' . $cus_detail11 . '</td>                            
                        </tr>            
                    </table></td>
</tr> 			
        </table>  
        
        <table style="width:60%;margin-top:100px;font-size:11px">
          <tr> 
           <td style="padding:10px;border-bottom:1px solid;text-align:left;width:50%"> <b>Description</b> </td>
           <td style="padding:10px;border-bottom:1px solid;text-align:left;width:10%"> <b>Quantity</b> </td>
           <td style="padding:10px;border-bottom:1px solid;text-align:left;width:15%"> <b>Unit Price</b> </td>
           <td style="padding:10px;border-bottom:1px solid;text-align:left;width:10%"> <b>Extra Amount</b> </td>
           <td style="padding:10px;border-bottom:1px solid;text-align:right;width:15%"> <b>Amount AUD</b> </td>
          </tr>';

$futotal='';
$jobs = pFETCH("SELECT * FROM `job_newinvoice` WHERE `subject`=? AND `job_id`=? ",'Task', $_REQUEST['id']);
while ( $jobslist = $jobs->fetch(PDO::FETCH_ASSOC)) {
$tamount+=$jobslist['task_amount_aud'];

	//$uprice=$jobslist['task_quty']*$jobslist['task_amount_aud'];

$date = date_create($jobslist['date']);

//$comt = $jobslist['jid'] != '0' ? ' - '.getjob('cusreference',$jobslist['jid']) : '';

$futotal+=$jobslist['task_amount_aud'];
$MESSAGE  .= '<tr> 
           <!--<td style="padding:10px;border-bottom:1px solid  #ddd;text-align:left;width:50%">'.str_replace("\r\n", "<br />", $jobslist['task_description']).$comt.'<br>'.date_format($date, "d M").'<br>'.$jobdetail['jobid'].' '.$jobdetail['drop_location'].'</td>-->
           <td style="padding:10px;border-bottom:1px solid  #ddd;text-align:left;width:50%">'.str_replace("\r\n", "<br />", $jobslist['task_description']).$comt.'</td>
           <td style="padding:10px;border-bottom:1px solid #ddd;text-align:left;width:10%">'.$jobslist['task_quty'].'</td>
           <td style="padding:10px;border-bottom:1px solid #ddd;text-align:left;width:15%">'.$jobslist['task_unit_price'].'</td>
           <td style="padding:10px;border-bottom:1px solid #ddd;text-align:left;width:10%">10%</td>
           <td style="padding:10px;border-bottom:1px solid #ddd;text-align:right;width:15%">'.$jobslist['task_amount_aud'].'</td>
          </tr>';
 }  
 $jobs = pFETCH("SELECT * FROM `job_newinvoice` WHERE `subject`=? AND `job_id`=? ",'Passup Charge', $_REQUEST['id']);
while ($jobslist = $jobs->fetch(PDO::FETCH_ASSOC)) {
$tamount+=$jobslist['task_amount_aud'];
if($jobslist['task_amount_aud']=='Passup Charge')
{
	$uprice=$jobslist['task_quty']*$jobslist['task_amount_aud'];
}
else
{
	$uprice=$jobslist['task_unit_price'];
}
$date = date_create($jobslist['date']);
//$comt = $jobslist['jid'] != '0' ? ' - '.getjob('cusreference',$jobslist['jid']) : '';

$futotal+=$jobslist['task_amount_aud'];
$MESSAGE  .= '<tr> 
           <!--<td style="padding:10px;border-bottom:1px solid  #ddd;text-align:left;width:50%">'.$jobslist['task_description'].$comt.'<br>'.date_format($date, "d M").'<br>'.$jobdetail['jobid'].' '.$jobdetail['drop_location'].'</td>-->
           <td style="padding:10px;border-bottom:1px solid  #ddd;text-align:left;width:50%">'.$jobslist['task_description'].$comt.'</td>
           <td style="padding:10px;border-bottom:1px solid #ddd;text-align:left;width:10%">'.$jobslist['task_quty'].'</td>
           <td style="padding:10px;border-bottom:1px solid #ddd;text-align:left;width:15%">'.$jobslist['task_unit_price'].'</td>
           <td style="padding:10px;border-bottom:1px solid #ddd;text-align:left;width:10%">10%</td>
           <td style="padding:10px;border-bottom:1px solid #ddd;text-align:right;width:15%">'.$jobslist['task_amount_aud'].'</td>
          </tr>';
 }  
 $jobs = pFETCH("SELECT * FROM `job_newinvoice` WHERE `subject`=? AND `job_id`=? ",'Additional Charge', $_REQUEST['id']);
while ($jobslist = $jobs->fetch(PDO::FETCH_ASSOC)) {
$tamount += $jobslist['task_amount_aud'];
    $tbl = '';
    if ($jobslist['job_id'] != '') {
        $desc = getjob('');
        $tbl_id = $jobslist['job_id'];
    } elseif ($jobslist['invoice_id'] != '') {
        $desc = '';
        $tbl = 'new';
        $tbl_id = $jobslist['invoice_id'];
    } else {
        $desc = $jobslist['task_description'];
    }
    //$uprice=$jobslist['task_quty']*$jobslist['task_amount_aud'];
//echo "SELECT * FROM `job_".$tbl."invoice` WHERE `subject`=? AND `job_id`=? ". 'Worker Charge'. $tbl_id; exit;
    $jobsnew = pFETCH("SELECT * FROM `job_".$tbl."invoice` WHERE `subject`=? AND `job_id`=? ", 'Task', $tbl_id);
    while ($jobsNewlist = $jobsnew->fetch(PDO::FETCH_ASSOC)) {
        $MESSAGE .= '<tr> 
           <td style="padding:10px;border-bottom:1px solid  #ddd;text-align:left;width:50%">' . str_replace("\r\n", "<br />",$jobsNewlist['task_description']) . '<!--<br>' . date_format($date, "d M") . '<br>' . $jobdetail['jobid'] . ' ' . $jobdetail['drop_location'] . '--></td>
           <td style="padding:10px;border-bottom:1px solid #ddd;text-align:left;width:10%">' . $jobsNewlist['task_quty'] . '</td>
           <td style="padding:10px;border-bottom:1px solid #ddd;text-align:left;width:15%">' . $jobslist['task_unit_price'] . '</td>
           <td style="padding:10px;border-bottom:1px solid #ddd;text-align:left;width:10%">' . $jobslist['task_extra_amt'] . '</td>
           <td style="padding:10px;border-bottom:1px solid #ddd;text-align:right;width:15%">' . (($jobsNewlist['task_quty'] * $jobslist['task_unit_price']) + $jobslist['task_extra_amt']) . '</td>
          </tr>';
    }
    $date = date_create($jobslist['date']);

    $futotal += $jobslist['task_amount_aud'];    
 }  

$tax = $futotal * $mangprofile['tax'] / 100;
//$tt = $futotal + $tax;
$tt = $futotal;
$MESSAGE .= ' <tr> 
           <td style="padding:10px;width:50%"> </td>
           <td style="padding:10px;text-align:left;width:10%"> </td>
           <td colspan="2" style="padding:10px;text-align:right;width:25%"> Subtotal </td>          
           <td style="padding:10px;text-align:right;width:15%">$' . $futotal . ' </td>
          </tr>
          
         <!--<tr> 
           <td style="padding:10px;width:50%"> </td>
           <td style="padding:10px;text-align:left;width:10%"> </td>
           <td colspan="2" style="padding:10px;text-align:right;width:25%"> GST (' . $mangprofile['tax'] . '%)</td>          
           <td style="padding:10px;text-align:right;width:15%">$' . $tax . '</td>
          </tr>-->
          <tr> 
           <td style="padding:10px;width:50%"> </td>
           <td style="padding:10px;text-align:left;width:10%"> </td>
           <td colspan="2" style="padding:10px;text-align:right;width:25%"><b> TOTAL AUD </b></td>          
           <td style="padding:10px;text-align:right;width:15%"> <b>$' . $tt . '</b> </td>
          </tr>
          
        </table> 
        
       

        ';

 $HEADERS  = "From: 5AAB < ".getprofile('recoveryemail',1)." >\n";
        $HEADERS .= "X-Sender: 5AAB < ".getprofile('recoveryemail',1)." >\n";
        $HEADERS .= 'X-Mailer: PHP/' . phpversion();
        $HEADERS .= "X-Priority: 1\n"; // Urgent message!
        //$headers .= "Return-Path: itsolusenz1@gmail.com\n"; // Return path for errors
        $HEADERS .= "MIME-Version: 1.0\r\n";
        $HEADERS .= "Content-Type: text/html; charset=iso-8859-1\n";
            mail(getdriver('email',$payslip['employee']),'Pay Slip - 5AAB',$MESSAGE,$HEADERS);
        
}
function PayslipMail($id) {
    global $db, $sitename;
    $viewpay = FETCH_all("SELECT * FROM `payslip` WHERE `id`=?", $id);
    $uid = md5(uniqid(time()));
    file_get_contents($sitename.'MPDF/invoice/payslip.php?id='.$id.'&saveY='.$uid);    
    $content = chunk_split(base64_encode(file_get_contents($sitename.'MPDF/invoice/'.$uid.'.pdf')));
    $HEADERS = "From: 5AAB < " . getprofile('recoveryemail', 1) . " >\n";
    $HEADERS .= "X-Sender: 5AAB < " . getprofile('recoveryemail', 1) . " >\n";
    $HEADERS .= 'X-Mailer: PHP/' . phpversion();
    $HEADERS .= "X-Priority: 1\n"; // Urgent message!
    //$headers .= "Return-Path: itsolusenz1@gmail.com\n"; // Return path for errors
    $HEADERS .= "MIME-Version: 1.0\r\n";
    //$HEADERS .= "Content-Type: text/html; charset=iso-8859-1\n";
    $HEADERS .= "Content-Type: multipart/mixed; boundary=\"" . $uid . "\"\r\n\r\n";
    
    $MESSAGE .= "--" . $uid . "\r\n";
    $MESSAGE .= "Content-type:text/html; charset=utf-8\n";
    $MESSAGE .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
    $MESSAGE .=  getemailtemplate('description','2') . "\r\n\r\n";

    $MESSAGE .= "--" . $uid . "\r\n";
    $MESSAGE .= "Content-Type: application/octet-stream; name=\"Pay Slip.pdf\"\r\n"; // use different content types here
    $MESSAGE .= "Content-Transfer-Encoding: base64\r\n";
    $MESSAGE .= "Content-Disposition: attachment; filename=\"Pay Slip.pdf\"\r\n\r\n"; // For Attachment
    $MESSAGE .= $content . "\r\n\r\n";
    $MESSAGE .= "--" . $uid . "--";
//            mail(getdriver('email',$viewpay['employee']),'Pay Slip - 5AAB',$MESSAGE,$HEADERS);
    mail(getdriver('email', $viewpay['employee']), getemailtemplate('subject','2'), $MESSAGE,$HEADERS);
    unlink('../../MPDF/invoice/'.$uid.'.pdf');
}
?>