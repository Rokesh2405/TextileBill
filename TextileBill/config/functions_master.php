<?php

function getstylepattern($a, $b) {
    global $db;
    $get1 = $db->prepare("SELECT * FROM `objectprice` WHERE `id`=?");
    $get1->execute(array($b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}

function delpattern($a) {
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    foreach ($b as $c) {
        global $db;
  $get = $db->prepare("DELETE FROM `pattern` WHERE `id` =? ");
        //$get = $db->prepare("UPDATE `patient` SET `status`=? WHERE `bid`=?");
        $get->execute(array(trim($c)));
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i> Successfully Deleted!</h4></div>';
    return $res;
}

function addpattern($pattern,$status,$getid) 
{
   global $db;
    if ($getid == '') {
        $link2 = FETCH_all("SELECT `id` FROM `pattern` WHERE `pattern`=?", $pattern);
        if ($link2['id'] == '') {
           $resa = $db->prepare("INSERT INTO `pattern` (`pattern`,`status`) VALUES(?,?)");
            $resa->execute(array($pattern,$status));

  $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';
        } else {
            $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i>This Pattern is already exists. Please try with different Beat name</h4></div>';
        }
    } else {
        $link1 = FETCH_all("SELECT `id` FROM `pattern` WHERE `pattern`=? AND `id`!=?", $pattern,$getid);
        if ($link1['id'] == '') {
           $resa = $db->prepare("UPDATE `pattern` SET `pattern`=? WHERE `id`=?");
            $resa->execute(array($pattern, $getid));

            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><h4><i class="icon fa fa-check"></i>Successfully Updated</h4></div>';
        } else {
            $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i>This Pattern is already exists. Please try with different Beat name</h4></div>';
        }
    }
    return $res;

}

function getpattern($a, $b) {
    global $db;
  
    $get1 = $db->prepare("SELECT * FROM `pattern` WHERE `id`=?");
    $get1->execute(array($b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}
function delstyle($a) {
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    foreach ($b as $c) {
        global $db;
  $get = $db->prepare("DELETE FROM `style` WHERE `id` =? ");
        //$get = $db->prepare("UPDATE `patient` SET `status`=? WHERE `bid`=?");
        $get->execute(array(trim($c)));
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i> Successfully Deleted!</h4></div>';
    return $res;
}

function addstyle($style,$status,$getid) 
{
   global $db;
    if ($getid == '') {
        $link2 = FETCH_all("SELECT `id` FROM `style` WHERE `style`=?", $style);
        if ($link2['id'] == '') {
           $resa = $db->prepare("INSERT INTO `style` (`style`,`status`) VALUES(?,?)");
            $resa->execute(array($style,$status));

  $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';
        } else {
            $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i>This Style is already exists. Please try with different Beat name</h4></div>';
        }
    } else {
        $link1 = FETCH_all("SELECT `id` FROM `style` WHERE `style`=? AND `id`!=?", $style,$getid);
        if ($link1['id'] == '') {
           $resa = $db->prepare("UPDATE `style` SET `style`=? WHERE `id`=?");
            $resa->execute(array($style, $getid));

            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><h4><i class="icon fa fa-check"></i>Successfully Updated</h4></div>';
        } else {
            $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i>This Style is already exists. Please try with different Beat name</h4></div>';
        }
    }
    return $res;

}

function getstyle($a, $b) {
    global $db;
  
    $get1 = $db->prepare("SELECT * FROM `style` WHERE `id`=?");
    $get1->execute(array($b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}

function delbrand($a) {
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    foreach ($b as $c) {
        global $db;
  $get = $db->prepare("DELETE FROM `brands` WHERE `id` =? ");
        //$get = $db->prepare("UPDATE `patient` SET `status`=? WHERE `bid`=?");
        $get->execute(array(trim($c)));
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i> Successfully Deleted!</h4></div>';
    return $res;
}

function addbrand($brand,$status,$getid) 
{
   global $db;
    if ($getid == '') {
        $link2 = FETCH_all("SELECT `id` FROM `brands` WHERE `brand`=?", $brand);
        if ($link2['id'] == '') {
           $resa = $db->prepare("INSERT INTO `brands` (`brand`,`status`) VALUES(?,?)");
            $resa->execute(array($brand,$status));

  $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';
        } else {
            $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i>This Brand is already exists. Please try with different Beat name</h4></div>';
        }
    } else {
        $link1 = FETCH_all("SELECT `id` FROM `brands` WHERE `brand`=? AND `id`!=?", $brand,$getid);
        if ($link1['id'] == '') {
           $resa = $db->prepare("UPDATE `brands` SET `brand`=? WHERE `id`=?");
            $resa->execute(array($brand, $getid));

            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><h4><i class="icon fa fa-check"></i>Successfully Updated</h4></div>';
        } else {
            $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i>This Brand is already exists. Please try with different Beat name</h4></div>';
        }
    }
    return $res;

}

function getbrands($a, $b) {
    global $db;

    $get1 = $db->prepare("SELECT * FROM `brands` WHERE `id`=?");
    $get1->execute(array($b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}

function addbeatsalesman($beatid1,$beat,$salesman,$area,$beatcustomer,$status,$getid)
{
   global $db;
    if ($getid == '') {
        $link2 = FETCH_all("SELECT `id` FROM `beatsalesman` WHERE `salesman`=?", $salesman);
        if ($link2['id'] == '') {
            $resa = $db->prepare("INSERT INTO `beatsalesman` (`salesman`,`status`) VALUES(?,?)");
            $resa->execute(array($salesman,$status));

            $l_insert = $db->lastinsertid();
            $i=0;
            foreach($beat as $beats){
            $day=$i;
            $beat1=$beats;
            $area1=$area[$i];
            $customer1=implode(',',$beatcustomer[$i]);
            $resa1 = $db->prepare("INSERT INTO `daywise_beat` (`beatsalesman_id`,`day`,`beat`,`area`,`customer`) VALUES (?,?,?,?,?) ");
            $resa1->execute(array($l_insert,$day,$beat1,$area1,$customer1));
            $i++;
            }
  $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';
        } else {
            $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i>This Salesman name is already exists. Please try with different Salesman name</h4></div>';
        }
    } else {
        $link1 = FETCH_all("SELECT `id` FROM `beatsalesman` WHERE `salesman`=? AND `id`!=?", $salesman, $getid);
        if ($link1['id'] == '') {
            $resa = $db->prepare("UPDATE `beatsalesman` SET `salesman`=?,`status`=? WHERE `id`=?");
            $resa->execute(array($salesman,$status, $getid));


           $l_insert = $getid;
            $i=0;
            foreach($beat as $beats){
            $day=$i;
            $beat1=$beats;
            $area1=$area[$i];
            $customer1=implode(',',$beatcustomer[$i]);
$beatid11=$beatid1[$i];
        
        if($beatid11=='') {
            $resa1 = $db->prepare("INSERT INTO `daywise_beat` (`beatsalesman_id`,`day`,`beat`,`area`,`customer`) VALUES (?,?,?,?,?) ");
            $resa1->execute(array($l_insert,$day,$beat1,$area1,$customer1));
        }
        else
        {
$resa1 = $db->prepare("UPDATE `daywise_beat` SET `day`=?,`beat`=?,`area`=?,`customer`=? WHERE `id`=? ");
            $resa1->execute(array($day,$beat1,$area1,$customer1,$beatid11));
        }
            $i++;
            }


            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><h4><i class="icon fa fa-check"></i>Successfully Updated</h4></div>';
        } else {
            $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i>This Salesman name is already exists. Please try with different Salesman name</h4></div>';
        }
    }
    return $res;

}

function getbeatsalesman($a, $b) {
    global $db;
    $get1 = $db->prepare("SELECT * FROM `beatsalesman` WHERE `id`=?");
    $get1->execute(array($b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}


function delbeatsalesman($a) {
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    foreach ($b as $c) {
        global $db;
  $get = $db->prepare("DELETE FROM `beatsalesman` WHERE `id` =? ");
        //$get = $db->prepare("UPDATE `patient` SET `status`=? WHERE `bid`=?");
        $get->execute(array(trim($c)));
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i> Successfully Deleted!</h4></div>';
    return $res;
}

function addbeat($beatname,$area,$customer,$status,$getid) 
{
   global $db;
    if ($getid == '') {
        $link2 = FETCH_all("SELECT `id` FROM `beat` WHERE `beatname`=? AND `area`=? AND `customer`=?", $beatname,$area,$customer);
        if ($link2['id'] == '') {
            $cus=implode(',',$customer);
            $resa = $db->prepare("INSERT INTO `beat` (`beatname`,`area`,`customer`,`status`) VALUES(?,?,?,?)");
            $resa->execute(array($beatname,$area,$cus,$status));

  $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';
        } else {
            $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i>This Beat Details is already exists. Please try with different Beat name</h4></div>';
        }
    } else {
        $link1 = FETCH_all("SELECT `id` FROM `beat` WHERE `beatname`=? AND `area`=? AND `customer`=? AND `id`!=?", $beatname,$area,$customer,$getid);
        if ($link1['id'] == '') {
              $cus=implode(',',$customer);
            $resa = $db->prepare("UPDATE `beat` SET `beatname`=?,`area`=?,`customer`=?,`status`=? WHERE `id`=?");
            $resa->execute(array($beatname,$area,$cus,$status, $getid));

            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><h4><i class="icon fa fa-check"></i>Successfully Updated</h4></div>';
        } else {
            $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i>This Beat Details is already exists. Please try with different Beat name</h4></div>';
        }
    }
    return $res;

}

function getbeat($a, $b) {
    global $db;
    $get1 = $db->prepare("SELECT * FROM `beat` WHERE `id`=?");
    $get1->execute(array($b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}


function delbeat($a) {
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    foreach ($b as $c) {
        global $db;
  $get = $db->prepare("DELETE FROM `beat` WHERE `id` =? ");
        //$get = $db->prepare("UPDATE `patient` SET `status`=? WHERE `bid`=?");
        $get->execute(array(trim($c)));
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i> Successfully Deleted!</h4></div>';
    return $res;
}

function getsalesreturn1($a, $b) {
    global $db;
    $get1 = $db->prepare("SELECT * FROM `sales_return` WHERE id=?");
    $get1->execute(array($b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}
function addsalesreturn1($style1,$meter1,$orgrate1,$taxtype,$cgstvalue,$sgstvalue,$mrp_price1,$hsn1,$billtypemast,$bill_advanceamt,$bill_balanceamt,$gstresult1,$gsttype,$gstvalue,$billtype,$order_method,$oid1,$payment_mode,$customer_name, $order_type, $date, $bill_no,$object1, $quantity1, $rate1, $total1, $given_amt, $balance_amt,$sub_total,$discount,$packing_charge,$delivery_charge,$tot_amt,$getid) 
{
   global $db;
   if ($getid == '') 
    {
if($_SESSION['usertype']=='subuser') {
$createdby='subuser';
}
else
{
$createdby='admin';
}   
$createdid=$_SESSION['UID'];
$resa = $db->prepare("INSERT INTO `sales_return` (`cgstvalue`,`sgstvalue`,`taxtype`,`billtypemast`,`bill_advanceamt`,`bill_balanceamt`,`gsttype`,`gstvalue`,`createdby`,`created_id`,`billtype`,`order_method`,`payment_mode`,`customer_id`,`order_type`,`date`,`bill_number`,`given_amnt`,`balance_amnt`,`sub_tot`,`discount`,`packing_charges`,`delivery_charges`,`total_amnt`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");

$resa->execute(array($cgstvalue,$sgstvalue,$taxtype,$billtypemast,$bill_advanceamt,$bill_balanceamt,$gsttype,$gstvalue,$createdby,$createdid,$billtype,$order_method,$payment_mode,$customer_name,$order_type,$date,$bill_no,$given_amt,$balance_amt,$sub_total, $discount, $packing_charge, $delivery_charge, $tot_amt));



            $l_insert = $db->lastinsertid();
            $salesprint=getsettings('setting_value','1');
            if($salesprint=='1') {
             $url="../../MPDF/bill.php?id=".$l_insert;
            }
            else
            {
             $url="../../MPDF/billinvoice.php?id=".$l_insert;   
            }
           // update_bill_value('5');
            $objectval = explode(',', $object1);
            $quantity = explode(',', $quantity1);
            $rate = explode(',', $rate1);
            $total = explode(',', $total1);
             $style = explode(',', $style1);
            $meter = explode(',', $meter1);
            $orgrate = explode(',', $orgrate1);

              $mrp_price = explode(',', $mrp_price1);
            $hsn = explode(',', $hsn1);
            $gstresult=explode(',',$gstresult1);
            foreach ($objectval as $key => $value)
             {
                    
                if ($objectval[$key] != '') 
                {
                    
            $resa = $db->prepare("INSERT INTO `sales_return_details` (`style`,`meter`,`orgrate`,`mrp_price`,`hsn`,`gstresult`,`object_id`,`bill_no`,`product_name`,`qty`,`rate`,`total`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?) ");
            $resa->execute(array($style[$key],$meter[$key],$orgrate[$key],$mrp_price[$key],$hsn[$key],$gstresult[$key],$l_insert,$bill_no,$objectval[$key], $quantity[$key], $rate[$key], $total[$key]));
                    
                }
            }

              $get = $db->prepare("TRUNCATE `temp_sales_details` ");
         $get->execute(array());



if($billtypemast==2) {
 $chkcredit = FETCH_all("SELECT * FROM `credit_payment` WHERE `type`='sales' AND `billno`=?", $bill_no);
   if($chkcredit['id']=='') { 

  $cresa = $db->prepare("INSERT INTO `credit_payment` (`type`,`billno`,`supplier_id`,`purchase_id`,`purchase_amt`,`advance_amt`,`balance_amt`) VALUES(?,?,?,?,?,?,?)");
$cresa->execute(array('sales',$bill_no,$customer_name,$l_insert,$tot_amt,$given_amt,$balance_amt));
      
   }
   else
   {
       $cresa = $db->prepare("UPDATE `credit_payment` SET `billno`=?,`supplier_id`=?,`purchase_amt`=?,`advance_amt`=?,`balance_amt`=? WHERE `purchase_id`=? AND `type`='sales' ");
$cresa->execute(array($bill_no,$customer_name,$tot_amt,$given_amt,$balance_amt,$getid)); 
   }
   
}

 $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';

// echo "<script>window.open('".$url."', '_blank');</script>";
    }
    else
    {

$resa = $db->prepare("UPDATE `sales_return` SET `cgstvalue`=?,`sgstvalue`=?,`taxtype`=?,`billtypemast`=?,`bill_advanceamt`=?,`bill_balanceamt`=?,`gsttype`=?,`gstvalue`=?,`billtype`=?,`order_method`=?,`payment_mode`=?,`customer_id`=?,`order_type`=?,`date`=?,`bill_number`=?,`given_amnt`=?,`balance_amnt`=?,`sub_tot`=?,`discount`=?,`packing_charges`=?,`delivery_charges`=?,`total_amnt`=? WHERE `id`=?");

$resa->execute(array($cgstvalue,$sgstvalue,$taxtype,$billtypemast,$bill_advanceamt,$bill_balanceamt,$gsttype,$gstvalue,$billtype,$order_method,$payment_mode,$customer_name,$order_type,$date,$bill_no,$given_amt,$balance_amt,$sub_total, $discount, $packing_charge, $delivery_charge, $tot_amt,$getid));

 $salesprint=getsettings('setting_value','1');
            if($salesprint=='1') {
             $url="../../MPDF/bill.php?id=".$getid;
            }
            else
            {
             $url="../../MPDF/billinvoice.php?id=".$getid;   
            }

             $oid = explode(',', $oid1);
              
             $objectval = explode(',', $object1);
            $quantity = explode(',', $quantity1);
            $rate = explode(',', $rate1);
            $total = explode(',', $total1);
              $style = explode(',', $style1);
            $meter = explode(',', $meter1);
            $orgrate = explode(',', $orgrate1);
            $mrp_price = explode(',', $mrp_price1);
                $hsn = explode(',', $hsn1);
             $gstresult=explode(',',$gstresult1);
            foreach ($objectval as $key => $value)
             {
                    
                if ($objectval[$key] != '') 
                {
                    if($oid[$key]=='') {
                    $resa = $db->prepare("INSERT INTO `sales_return_details` (`style`,`meter`,`orgrate`,`mrp_price`,`hsn`,`gstresult`,`object_id`,`bill_no`,`product_name`,`qty`,`rate`,`total`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?) ");
            $resa->execute(array($style[$key],$meter[$key],$orgrate[$key],$mrp_price[$key],$hsn[$key],$gstresult[$key],$getid,$bill_no,$objectval[$key], $quantity[$key], $rate[$key], $total[$key]));
                    }
                    else
                    {
                     $resa = $db->prepare("UPDATE `sales_return_details` SET `style`=?,`meter`=?,`orgrate`=?,`mrp_price`=?,`hsn`=?,`gstresult`=?,`object_id`=?,`bill_no`=?,`product_name`=?,`qty`=?,`rate`=?,`total`=? WHERE `id`=? ");
            $resa->execute(array($style[$key],$meter[$key],$orgrate[$key],$mrp_price[$key],$hsn[$key],$gstresult[$key],$getid,$bill_no,$objectval[$key], $quantity[$key], $rate[$key], $total[$key], $oid[$key]));    
                    }
                    
                    
                }
            }
            $get = $db->prepare("TRUNCATE `temp_sales_details` ");
         $get->execute(array());

         if($billtypemast==2) {
 $chkcredit = FETCH_all("SELECT * FROM `credit_payment` WHERE `type`='sales' AND `billno`=?", $bill_no);
   if($chkcredit['id']=='') { 

  $cresa = $db->prepare("INSERT INTO `credit_payment` (`type`,`billno`,`supplier_id`,`purchase_id`,`purchase_amt`,`advance_amt`,`balance_amt`) VALUES(?,?,?,?,?,?,?)");
$cresa->execute(array('sales',$bill_no,$customer_name,$l_insert,$tot_amt,$given_amt,$balance_amt));
      
   }
   else
   {
       $cresa = $db->prepare("UPDATE `credit_payment` SET `billno`=?,`supplier_id`=?,`purchase_amt`=?,`advance_amt`=?,`balance_amt`=? WHERE `purchase_id`=? AND `type`='sales' ");
$cresa->execute(array($bill_no,$customer_name,$tot_amt,$given_amt,$balance_amt,$getid)); 
   }
   
}



            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><h4><i class="icon fa fa-check"></i>Successfully Updated</h4></div>';
// echo "<script>window.open('".$url."', '_blank');</script>";
    }
    return $res;
    
}


function getsalesorder($a, $b) {
    global $db;
    $get1 = $db->prepare("SELECT * FROM `sales_order` WHERE id=?");
    $get1->execute(array($b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}
function addsalesorder($style1,$meter1,$orgrate1,$taxtype,$cgstvalue,$sgstvalue,$mrp_price1,$salesman,$hsn1,$billtypemast,$bill_advanceamt,$bill_balanceamt,$gstresult1,$gsttype,$gstvalue,$billtype,$order_method,$oid1,$payment_mode,$customer_name, $order_type, $date, $bill_no,$object1, $quantity1, $rate1, $total1, $given_amt, $balance_amt,$sub_total,$discount,$packing_charge,$delivery_charge,$tot_amt,$getid) 
{
   global $db;
   if ($getid == '') 
    {
if($_SESSION['usertype']=='subuser') {
$createdby='subuser';
}
else
{
$createdby='admin';
}   
$createdid=$_SESSION['UID'];
$resa = $db->prepare("INSERT INTO `sales_order` (`taxtype`,`cgstvalue`,`sgstvalue`,`salesman`,`billtypemast`,`bill_advanceamt`,`bill_balanceamt`,`gsttype`,`gstvalue`,`createdby`,`created_id`,`billtype`,`order_method`,`payment_mode`,`customer_id`,`order_type`,`date`,`bill_number`,`given_amnt`,`balance_amnt`,`sub_tot`,`discount`,`packing_charges`,`delivery_charges`,`total_amnt`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");

$resa->execute(array($taxtype,$cgstvalue,$sgstvalue,$salesman,$billtypemast,$bill_advanceamt,$bill_balanceamt,$gsttype,$gstvalue,$createdby,$createdid,$billtype,$order_method,$payment_mode,$customer_name,$order_type,$date,$bill_no,$given_amt,$balance_amt,$sub_total, $discount, $packing_charge, $delivery_charge, $tot_amt));



            $l_insert = $db->lastinsertid();

              if($billtypemast==2) {
            $cresa = $db->prepare("INSERT INTO `credit_payment` (`type`,`billno`,`supplier_id`,`purchase_id`,`purchase_amt`,`advance_amt`,`balance_amt`) VALUES(?,?,?,?,?,?,?)");
$cresa->execute(array('sales',$bill_no,$customer_name,$l_insert,$tot_amt,$given_amt,$balance_amt));
       }
       


            $salesprint=getsettings('setting_value','1');
            if($salesprint=='1') {
             $url="../../MPDF/bill_order.php?id=".$l_insert;
            }
            else
            {
             $url="../../MPDF/billinvoice_order.php?id=".$l_insert;   
            }

           // update_bill_value('5');


            $objectval = explode(',', $object1);
            $quantity = explode(',', $quantity1);
            $rate = explode(',', $rate1);
            $total = explode(',', $total1);
             $style = explode(',', $style1);
            $meter = explode(',', $meter1);
            $orgrate = explode(',', $orgrate1);

             $mrp_price = explode(',', $mrp_price1);
            $hsn = explode(',', $hsn1);
            $gstresult=explode(',',$gstresult1);
            foreach ($objectval as $key => $value)
             {
                    
                if ($objectval[$key] != '') 
                {
                    
                    $resa = $db->prepare("INSERT INTO `sales_order_details` (`style`,`meter`,`orgrate`,`mrp_price`,`hsn`,`gstresult`,`object_id`,`bill_no`,`product_name`,`qty`,`rate`,`total`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?) ");
            $resa->execute(array($style[$key],$meter[$key],$orgrate[$key],$mrp_price[$key],$hsn[$key],$gstresult[$key],$l_insert,$bill_no,$objectval[$key], $quantity[$key], $rate[$key], $total[$key]));
                    
                }
            }
            $get = $db->prepare("TRUNCATE `temp_sales_details` ");
         $get->execute(array());
 $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';
 echo "<script>window.open('".$url."', '_blank');</script>";
    }
    else
    {

$resa = $db->prepare("UPDATE `sales_order` SET `taxtype`=?,`cgstvalue`=?,`sgstvalue`=?,`salesman`=?,`billtypemast`=?,`bill_advanceamt`=?,`bill_balanceamt`=?,`gsttype`=?,`gstvalue`=?,`billtype`=?,`order_method`=?,`payment_mode`=?,`customer_id`=?,`order_type`=?,`date`=?,`bill_number`=?,`given_amnt`=?,`balance_amnt`=?,`sub_tot`=?,`discount`=?,`packing_charges`=?,`delivery_charges`=?,`total_amnt`=? WHERE `id`=?");

$resa->execute(array($taxtype,$cgstvalue,$sgstvalue,$salesman,$billtypemast,$bill_advanceamt,$bill_balanceamt,$gsttype,$gstvalue,$billtype,$order_method,$payment_mode,$customer_name,$order_type,$date,$bill_no,$given_amt,$balance_amt,$sub_total, $discount, $packing_charge, $delivery_charge, $tot_amt,$getid));



if($billtypemast==2) {
 $chkcredit = FETCH_all("SELECT * FROM `credit_payment` WHERE `type`='sales' AND `purchase_id`=?", $getid);
   if($chkcredit['id']=='') { 

  $cresa = $db->prepare("INSERT INTO `credit_payment` (`type`,`billno`,`supplier_id`,`purchase_id`,`purchase_amt`,`advance_amt`,`balance_amt`) VALUES(?,?,?,?,?,?,?)");
$cresa->execute(array('sales',$bill_no,$customer_name,$getid,$tot_amt,$given_amt,$balance_amt));
      
   }
   else
   {
       $cresa = $db->prepare("UPDATE `credit_payment` SET `billno`=?,`supplier_id`=?,`purchase_amt`=?,`advance_amt`=?,`balance_amt`=? WHERE `purchase_id`=? AND `type`='sales' ");
$cresa->execute(array($bill_no,$customer_name,$tot_amt,$given_amt,$balance_amt,$getid)); 
   }
   
}



 $salesprint=getsettings('setting_value','1');
            if($salesprint=='1') {
             $url="../../MPDF/bill_order.php?id=".$getid;
            }
            else
            {
             $url="../../MPDF/billinvoice_order.php?id=".$getid;   
            }

             $oid = explode(',', $oid1);
              
             $objectval = explode(',', $object1);
            $quantity = explode(',', $quantity1);
            $rate = explode(',', $rate1);
            $total = explode(',', $total1);
            $mrp_price = explode(',', $mrp_price1);
             $style = explode(',', $style1);
            $meter = explode(',', $meter1);
            $orgrate = explode(',', $orgrate1);
            $hsn = explode(',', $hsn1);
            $gstresult=explode(',',$gstresult1);
            foreach ($objectval as $key => $value)
             {
                    
                if ($objectval[$key] != '') 
                {
                    if($oid[$key]=='') {
                    $resa = $db->prepare("INSERT INTO `sales_order_details` (`style`,`meter`,`orgrate`,`mrp_price`,`hsn`,`gstresult`,`object_id`,`bill_no`,`product_name`,`qty`,`rate`,`total`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?) ");
            $resa->execute(array($style[$key],$meter[$key],$orgrate[$key],$mrp_price[$key],$hsn[$key],$gstresult[$key],$getid,$bill_no,$objectval[$key], $quantity[$key], $rate[$key], $total[$key]));
                    }
                    else
                    {
                     $resa = $db->prepare("UPDATE `sales_order_details` SET `style`=?,`meter`=?,`orgrate`=?,`mrp_price`=?,`hsn`=?,`gstresult`=?,`object_id`=?,`bill_no`=?,`product_name`=?,`qty`=?,`rate`=?,`total`=? WHERE `id`=? ");
            $resa->execute(array($style[$key],$meter[$key],$orgrate[$key],$mrp_price[$key],$hsn[$key],$gstresult[$key],$getid,$bill_no,$objectval[$key], $quantity[$key], $rate[$key], $total[$key], $oid[$key]));    
                    }
                    
                    
                }
            }
            $get = $db->prepare("TRUNCATE `temp_sales_details` ");
         $get->execute(array());

            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><h4><i class="icon fa fa-check"></i>Successfully Updated</h4></div>';
 echo "<script>window.open('".$url."', '_blank');</script>";
    }
    return $res;
    
}

function addsalesman($username,$password,$salescode,$emailid,$cusid,$name,$contact_person,$mobileno,$area,$city,$state,$pincode,$gst,$address,$status,$getid) {
    global $db;


    if ($getid == '') {
        $link1 = FETCH_all("SELECT `id` FROM `salesman` WHERE `username`=?", $username);
if($link1['id']=='') {
$resa = $db->prepare("INSERT INTO `salesman` (`username`,`password`,`salescode`,`emailid`,`cusid`,`contact_person`,`city`,`state`,`pincode`,`gst`,`name`,`mobileno`,`address`,`status`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
        $resa->execute(array($username,$password,$salescode,$emailid,$cusid,$contact_person,$city,$state,$pincode,$gst,$name,$mobileno, $address,$status));
        $l_insert = $db->lastinsertid();
        update_bill_value('2');

    

$uresa = $db->prepare("INSERT INTO users (`usertype`, `name`, `val1`, `val2`, `val3`, `merchant`) VALUES (?,?,?,?,?,?)" );
$uresa->execute(array('salesman',$name,$username,md5($password),'1',$l_insert));


        $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
        $htry->execute(array('Salesman Mgmt', 10, 'INSERT', $_SESSION['UID'], $ip, $id));


        $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';
    }
    else
    {
          $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i>Username already exists!</h4></div>';
    }
    } else {
 $link1 = FETCH_all("SELECT `id` FROM `salesman` WHERE `username`=? AND `id`!=?", $username,$getid);
if($link1['id']=='') {
    $resa = $db->prepare("UPDATE `salesman` SET `username`=?,`password`=?,`salescode`=?,`emailid`=?,`contact_person`=?,`city`=?,`state`=?,`pincode`=?,`gst`=?,`name`=?,`mobileno`=?,`address`=?,`status`=? WHERE `id`=?");
        $resa->execute(array($username,$password,$salescode,$emailid,$contact_person,$city,$state,$pincode,$gst,$name,$mobileno,$address,$status,$getid));


// Update username

$uresa = $db->prepare("UPDATE `users` SET  `name`=?, `val1`=?, `val2`=?, `val3`=? WHERE `usertype`=? AND `merchant`=? " );
$uresa->execute(array($name,$username,md5($password),'1','salesman',$getid));

// Update Username

        $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
        $htry->execute(array('Customer Mgmt', 10, 'UPDATE', $_SESSION['UID'], $ip, $getid));

        $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><h4><i class="icon fa fa-check"></i>Successfully Updated</h4></div>';
         }
    else
    {
          $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i>Username already exists!</h4></div>';
    }
//            } else {
//                $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i>Mobile Number already exists!</h4></div>';
//            }
    }
    return $res;
}

function delsalesman($a) {
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    foreach ($b as $c) {
        global $db;
         $get = $db->prepare("DELETE FROM `salesman` WHERE `id` =? ");
        $get->execute(array(trim($c)));
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i> Successfully Deleted!</h4></div>';
    return $res;
}

function getsalesman($a, $b) {
    global $db;
    $get1 = $db->prepare("SELECT * FROM `salesman` WHERE `id`=?");
    $get1->execute(array($b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}

function delpaymentmode($a) {
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    foreach ($b as $c) {
        global $db;

          $get1 = $db->prepare("DELETE FROM `paymentmode` WHERE `id` =? ");
         $get1->execute(array(trim($c)));
    }
    
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i> Successfully Deleted!</h4></div>';
    return $res;
}


function getpaymentmode($a,$b) {
    global $db;
    $get1 = $db->prepare("SELECT * FROM `paymentmode` WHERE `id`=?");
    $get1->execute(array($b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}

function addpaymentmode($paymentmode,$status,$getid)
{
   global $db;
    if ($getid == '') {
        $link2 = FETCH_all("SELECT `id` FROM `paymentmode` WHERE `paymentmode`=?", $paymentmode);
        if ($link2['id'] == '') {
            $resa = $db->prepare("INSERT INTO `paymentmode` (`paymentmode`,`status`) VALUES(?,?)");
            $resa->execute(array($paymentmode,$status));
 

  $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';
        } else {
            $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i>This Payment Mode is already exists. Please try with different Service name</h4></div>';
        }
    } else {
        $link1 = FETCH_all("SELECT `id` FROM `paymentmode` WHERE `paymentmode`=? AND `id`!=?", $paymentmode, $getid);
        if ($link1['id'] == '') {
            $resa = $db->prepare("UPDATE `paymentmode` SET `paymentmode`=?,`status`=? WHERE `id`=?");
            $resa->execute(array($paymentmode,$status, $getid));

           
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><h4><i class="icon fa fa-check"></i>Successfully Updated</h4></div>';
        } else {
            $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i>This Payment Mode is already exists. Please try with different Service name</h4></div>';
        }
    }
    return $res;

}

function delordertype($a) {
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    foreach ($b as $c) {
        global $db;

          $get1 = $db->prepare("DELETE FROM `ordertype` WHERE `id` =? ");
         $get1->execute(array(trim($c)));
    }
    
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i> Successfully Deleted!</h4></div>';
    return $res;
}


function getordertype($a,$b) {
    global $db;
    $get1 = $db->prepare("SELECT * FROM `ordertype` WHERE `id`=?");
    $get1->execute(array($b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}

function addordertype($ordertype,$status,$getid)
{
   global $db;
    if ($getid == '') {
        $link2 = FETCH_all("SELECT `id` FROM `ordertype` WHERE `ordertype`=?", $ordertype);
        if ($link2['id'] == '') {
            $resa = $db->prepare("INSERT INTO `ordertype` (`ordertype`,`status`) VALUES(?,?)");
            $resa->execute(array($ordertype,$status));
 

  $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';
        } else {
            $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i>This GST is already exists. Please try with different Service name</h4></div>';
        }
    } else {
        $link1 = FETCH_all("SELECT `id` FROM `ordertype` WHERE `ordertype`=? AND `id`!=?", $ordertype, $getid);
        if ($link1['id'] == '') {
            $resa = $db->prepare("UPDATE `ordertype` SET `ordertype`=?,`status`=? WHERE `id`=?");
            $resa->execute(array($ordertype,$status, $getid));

           
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><h4><i class="icon fa fa-check"></i>Successfully Updated</h4></div>';
        } else {
            $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i>This GST is already exists. Please try with different Service name</h4></div>';
        }
    }
    return $res;

}


function delgst($a) {
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    foreach ($b as $c) {
        global $db;

          $get1 = $db->prepare("DELETE FROM `gst` WHERE `id` =? ");
         $get1->execute(array(trim($c)));
    }
    
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i> Successfully Deleted!</h4></div>';
    return $res;
}


function getgst($a,$b) {
    global $db;
    $get1 = $db->prepare("SELECT * FROM `gst` WHERE `id`=?");
    $get1->execute(array($b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}

function addgst($gst,$status,$getid) 
{
   global $db;
    if ($getid == '') {
        $link2 = FETCH_all("SELECT `id` FROM `gst` WHERE `gst`=?", $gst);
        if ($link2['id'] == '') {
            $resa = $db->prepare("INSERT INTO `gst` (`gst`,`status`) VALUES(?,?)");
            $resa->execute(array($gst,$status));
 

  $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';
        } else {
            $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i>This GST is already exists. Please try with different Service name</h4></div>';
        }
    } else {
        $link1 = FETCH_all("SELECT `id` FROM `gst` WHERE `gst`=? AND `id`!=?", $gst, $getid);
        if ($link1['id'] == '') {
            $resa = $db->prepare("UPDATE `gst` SET `gst`=?,`status`=? WHERE `id`=?");
            $resa->execute(array($gst,$status, $getid));

           
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><h4><i class="icon fa fa-check"></i>Successfully Updated</h4></div>';
        } else {
            $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i>This GST is already exists. Please try with different Service name</h4></div>';
        }
    }
    return $res;

}

function getsettings($a,$b) {
    global $db;
    $get1 = $db->prepare("SELECT * FROM `settings` WHERE `id`=?");
    $get1->execute(array($b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}


///////////////////////////
function getpurchasetotqty($a) {
    global $db;
    $get1 = $db->prepare("SELECT SUM(`pquantity`) AS `totqty` FROM `purchase_object_detail` WHERE `object_id`=?");
    $get1->execute(array($a));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get['totqty'];
    return $res;
}

function delonlineorder($a) {
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    foreach ($b as $c) {
        global $db;


        $get = $db->prepare("DELETE FROM `online_order_deatils` WHERE `object_id` =? ");
         $get->execute(array(trim($c)));
		 
		  $get1 = $db->prepare("DELETE FROM `online_order` WHERE `id` =? ");
         $get1->execute(array(trim($c)));
    }
	
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i> Successfully Deleted!</h4></div>';
    return $res;
}



function delstoreorder($a) {
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    foreach ($b as $c) {
        global $db;


        $get = $db->prepare("DELETE FROM `online_store_order_deatils` WHERE `object_id` =? ");
         $get->execute(array(trim($c)));
		 
		  $get1 = $db->prepare("DELETE FROM `online_store_order` WHERE `id` =? ");
         $get1->execute(array(trim($c)));
    }
	
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i> Successfully Deleted!</h4></div>';
    return $res;
}
function getsalesreturntotqty($a) {
    global $db;
    $get1 = $db->prepare("SELECT SUM(`qty`) AS `totqty` FROM `sales_return_details` WHERE `object_id`=?");
    $get1->execute(array($a));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get['totqty'];
    return $res;
}
function getsalestotqty($a) {
    global $db;
    $get1 = $db->prepare("SELECT SUM(`qty`) AS `totqty` FROM `sales_order_details` WHERE `object_id`=?");
    $get1->execute(array($a));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get['totqty'];
    return $res;
}

function getonlinetotqty($a) {
    global $db;
    $get1 = $db->prepare("SELECT SUM(`qty`) AS `totqty` FROM `online_order_deatils` WHERE `object_id`=?");
    $get1->execute(array($a));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get['totqty'];
    return $res;
}

function getstoretotqty($a) {
    global $db;
    $get1 = $db->prepare("SELECT SUM(`qty`) AS `totqty` FROM `online_store_order_deatils` WHERE `object_id`=?");
    $get1->execute(array($a));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get['totqty'];
    return $res;
}


function getdailyexpense($a, $b) {
    global $db;
    $get1 = $db->prepare("SELECT * FROM `daily_expense` WHERE `id`=?");
    $get1->execute(array($b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}

// object starts here 
function adddailyexpense($date,$type,$amount,$billno,$comment,$getid)
{
   global $db;
    if ($getid == '') {
  
  
            $resa = $db->prepare("INSERT INTO `daily_expense` (`date`,`type`,`amount`,`billno`,`comment`) VALUES(?,?,?,?,?)");
            $resa->execute(array($date,$type,$amount,$billno,$comment));


            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
            $htry->execute(array('Daily Expense Mgmt', 10, 'INSERT', $_SESSION['UID'], $ip, $id));
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';
      
	  
    } else {
       
            $resa = $db->prepare("UPDATE `daily_expense` SET `date`=?,`type`=?,`amount`=?,`billno`=?,`comment`=? WHERE `id`=?");
            $resa->execute(array($date,$type,$amount,$billno,$getid));

           

            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
            $htry->execute(array('Daily Expense Mgmt', 10, 'UPDATE', $_SESSION['UID'], $ip, $getid));
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><h4><i class="icon fa fa-check"></i>Successfully Updated</h4></div>';
       
	   
    }
    return $res;

}

function delexpense($a) {
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    foreach ($b as $c) {
        global $db;
        $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
            $htry->execute(array('Customer Mgmt', 10, 'DELETE', $_SESSION['UID'], $ip, $getid));
        $get = $db->prepare("DELETE FROM `expense_type` WHERE `id` =? ");
        $get->execute(array(trim($c)));
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i> Successfully Deleted!</h4></div>';
    return $res;
}

function getexpense($a, $b) {
    global $db;
    $get1 = $db->prepare("SELECT * FROM `expense_type` WHERE `id`=?");
    $get1->execute(array($b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}

// object starts here 
function addexpense($type,$status,$getid)
{
   global $db;
    if ($getid == '') {
        $link2 = FETCH_all("SELECT `id` FROM `expense_type` WHERE `type`=?", $type);
        if ($link2['id'] == '') {
            $resa = $db->prepare("INSERT INTO `expense_type` (`type`,`status`) VALUES(?,?)");
            $resa->execute(array($type,$status));


            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
            $htry->execute(array('Expense Mgmt', 10, 'INSERT', $_SESSION['UID'], $ip, $id));
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';
        } else {
            $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i>This Type is already exists. Please try with different Type</h4></div>';
        }
    } else {
        $link1 = FETCH_all("SELECT `id` FROM `expense_type` WHERE `type`=? AND `id`!=?", $type, $getid);
        if ($link1['id'] == '') {
            $resa = $db->prepare("UPDATE `expense_type` SET `type`=?,`status`=? WHERE `id`=?");
            $resa->execute(array($type,$status, $getid));

           

            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
            $htry->execute(array('Expense Type Mgmt', 10, 'UPDATE', $_SESSION['UID'], $ip, $getid));
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><h4><i class="icon fa fa-check"></i>Successfully Updated</h4></div>';
        } else {
            $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i>This Type is already exists. Please try with different Expense Type</h4></div>';
        }
    }
    return $res;

}



function add_unit($unit,$status,$getid)
{
	global $db;
     if ($getid == '') {
          $link1 = FETCH_all("SELECT `id` FROM `units` WHERE `unit`=? ", $unit);
        if ($link1['id'] == '') {
$resa = $db->prepare("INSERT INTO `units` (`unit`,`status`) VALUES (?,?)");
$resa->execute(array($unit,$status));
        // $l_insert = $db->lastinsertid();
       // update_bill_value('2');
        //hotel_users
        $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
        $htry->execute(array('Customer Mgmt', 10, 'INSERT', $_SESSION['UID'], $ip, $id));

        $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';
		}
		else
		{
		$res = '<div class="alert alert-error alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4>Unit Already Exist</h4></div>';	
		}
		
    } else {
  $link1 = FETCH_all("SELECT `id` FROM `units` WHERE `unit`=? AND `id`!=? ", $unit,$getid);
        if ($link1['id'] == '') {
    $resa = $db->prepare("UPDATE `units` SET `unit`=?,`status`=? WHERE `id`=?");
$resa->execute(array($unit,$status,$getid));

        $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
        $htry->execute(array('Customer Mgmt', 10, 'UPDATE', $_SESSION['UID'], $ip, $getid));

        $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><h4><i class="icon fa fa-check"></i>Successfully Updated</h4></div>';
		}
		else
		{
		$res = '<div class="alert alert-error alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4>Unit Already Exist</h4></div>';	
		}
		

    }
    return $res;
}
function del_unit($a) {
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    foreach ($b as $c) {
        global $db;
        $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
            $htry->execute(array('Customer Mgmt', 10, 'DELETE', $_SESSION['UID'], $ip, $getid));
        $get = $db->prepare("DELETE FROM `units` WHERE `id` =? ");
        $get->execute(array(trim($c)));
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i> Successfully Deleted!</h4></div>';
    return $res;
}

function getunits($a, $b) {
    global $db;
    $get1 = $db->prepare("SELECT * FROM `units` WHERE `id`=?");
    $get1->execute(array($b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}

function add_subcategory($category,$subcategory,$status,$getid)
{
	global $db;
     if ($getid == '') {
          $link1 = FETCH_all("SELECT `id` FROM `subcategory` WHERE `category`=? AND `subcategory`=?", $category,$subcategory);
        if ($link1['id'] == '') {
$resa = $db->prepare("INSERT INTO `subcategory` (`category`,`subcategory`,`status`) VALUES (?,?,?)");
$resa->execute(array($category,$subcategory,$status));
        // $l_insert = $db->lastinsertid();
       // update_bill_value('2');
        //hotel_users
        $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
        $htry->execute(array('Customer Mgmt', 10, 'INSERT', $_SESSION['UID'], $ip, $id));

        $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';
		}
		else
		{
		$res = '<div class="alert alert-error alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4>Subcategory Already Exist</h4></div>';	
		}
		
    } else {
  $link1 = FETCH_all("SELECT `id` FROM `subcategory` WHERE `category`=? AND `subcategory`=? AND `id`!=? ", $category,$subcategory,$getid);
        if ($link1['id'] == '') {
    $resa = $db->prepare("UPDATE `subcategory` SET `category`=?,`subcategory`=?,`status`=? WHERE `id`=?");
$resa->execute(array($category,$subcategory,$status,$getid));

        $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
        $htry->execute(array('Customer Mgmt', 10, 'UPDATE', $_SESSION['UID'], $ip, $getid));

        $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><h4><i class="icon fa fa-check"></i>Successfully Updated</h4></div>';
		}
		else
		{
		$res = '<div class="alert alert-error alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4>Subcategory Already Exist</h4></div>';	
		}
		

    }
    return $res;
}
function del_subcategory($a) {
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    foreach ($b as $c) {
        global $db;
        $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
            $htry->execute(array('Customer Mgmt', 10, 'DELETE', $_SESSION['UID'], $ip, $getid));
        $get = $db->prepare("DELETE FROM `subcategory` WHERE `id` =? ");
        $get->execute(array(trim($c)));
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i> Successfully Deleted!</h4></div>';
    return $res;
}

function getsubcategory($a, $b) {
    global $db;
    $get1 = $db->prepare("SELECT * FROM `subcategory` WHERE `id`=?");
    $get1->execute(array($b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}

function addobject($styleid,$estyle,$epattern,$eprice,$pricetype,$barcodeText,$barcodeType,$barcodeDisplay,$barcodeSize,$printText,$barcode_type,$mrp_price,$unit_per_pack,$barcode,$in_stock,$hsn,$productcode,$gst,$objectname,$category,$subcategory,$unit,$price,$status, $getid)
{
    global $db;
    if ($getid == '') {
        $link2 = FETCH_all("SELECT `id` FROM `object` WHERE `productcode`=? AND `objectname`=? AND `category`=? ", $productcode,$objectname, $category);
        if ($link2['id'] == '') {
            $resa = $db->prepare("INSERT INTO `object` (`purchase_price`,`pricetype`,`barcodeText`,`barcodeType`,`barcodeDisplay`,`barcodeSize`,`printText`,`barcode_type`,`mrp_price`,`unit_per_pack`,`barcode`,`in_stock`,`hsn`,`gst`,`productcode`,`objectname`,`category`,`subcategory`,`unit`,`price`,`status`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
            $resa->execute(array($purchase_price,$pricetype,$barcodeText,$barcodeType,$barcodeDisplay,$barcodeSize,$printText,$barcode_type,$mrp_price,$unit_per_pack,$barcode,$in_stock,$hsn,$gst,$productcode,$objectname,$category,$subcategory,$unit,$price,$status));
 $l_insert = $db->lastinsertid();
 $style=explode(',',$estyle);
 $pattern=explode(',',$epattern);
$price=explode(',',$eprice);
$i=0;
foreach($style as $style1)
{
    if($style1!='') {
    $pattern1=$pattern[$i];
    $price1=$price[$i];
 $stylrow = $db->prepare("INSERT INTO `objectprice` (`style`,`pattern`,`price`,`object_id`) VALUES (?,?,?,?)");
 $stylrow->execute(array($style1,$pattern1,$price1,$l_insert));
}
 $i++;
}
            // $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
            // $htry->execute(array('Object Mgmt', 10, 'INSERT', $_SESSION['UID'], $ip, $id));
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';
 $url=$sitename.$l_insert.'/editobject.htm';
            header("Location:".$url. "");
        exit;
        } else {
            $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i>This product name is already exists. Please try with different product name</h4></div>';
        }
    } else {
        $link1 = FETCH_all("SELECT `id` FROM `object` WHERE `productcode`=? AND `objectname`=? AND `category`=? AND `id`!=?", $productcode,$objectname,$category, $getid);
        if ($link1['id'] == '') {
            
            $resa = $db->prepare("UPDATE `object` SET `purchase_price`=?,`pricetype`=?,`barcodeText`=?,`barcodeType`=?,`barcodeDisplay`=?,`barcodeSize`=?,`printText`=?,`barcode_type`=?,`mrp_price`=?,`unit_per_pack`=?,`barcode`=?,`in_stock`=?,`hsn`=?,`gst`=?,`productcode`=?,`objectname`=?,`category`=?,`unit`=?,`price`=?, `status`=? WHERE `id`=?");
            $resa->execute(array($purchase_price,$pricetype,$barcodeText,$barcodeType,$barcodeDisplay,$barcodeSize,$printText,$barcode_type,$mrp_price,$unit_per_pack,$barcode,$in_stock,$hsn,$gst,$productcode,$objectname, $category,$unit,$price,$status, $getid));

     $styleids=explode(',',$styleid);
    $style=explode(',',$estyle);
 $pattern=explode(',',$epattern);
$price=explode(',',$eprice);
$i=0;
foreach($style as $style1)
{
    if($style1!='') {
    $pattern1=$pattern[$i];
    $price1=$price[$i];
    $styleid1=$styleids[$i];
    if($styleid1=='') {
 $stylrow = $db->prepare("INSERT INTO `objectprice` (`style`,`pattern`,`price`,`object_id`) VALUES (?,?,?,?)");
 $stylrow->execute(array($style1,$pattern1,$price1,$getid));
}
else
{
$stylrow = $db->prepare("UPDATE `objectprice` SET `style`=?,`pattern`=?,`price`=? WHERE `id`=? ");
 $stylrow->execute(array($style1,$pattern1,$price1,$styleid1));
}
}
 $i++;
}


            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><h4><i class="icon fa fa-check"></i>Successfully Updated</h4></div>';
        } else {
            $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i>This product name is already exists. Please try with different product name</h4></div>';
        }
    }
    return $res;
}
//////////////////////////
function addobject1($subcategory,$objectname,$category,$unit,$price,$status, $getid) 
{
    global $db;
    if ($getid == '') {
        $link2 = FETCH_all("SELECT `id` FROM `stock_product` WHERE `objectname`=?", $objectname);
        if ($link2['id'] == '') {
            $resa = $db->prepare("INSERT INTO `stock_product` (`objectname`,`category`,`subcategory`,`unit`,`price`,`status`) VALUES(?,?,?,?,?,?)");
            $resa->execute(array($objectname,$category,$subcategory,$unit,$price,$status));


            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
            $htry->execute(array('Object Mgmt', 10, 'INSERT', $_SESSION['UID'], $ip, $id));
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';
        } else {
            $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i>This area name is already exists. Please try with different Service name</h4></div>';
        }
    } else {
        $link1 = FETCH_all("SELECT `id` FROM `stock_product` WHERE `objectname`=? AND `id`!=?", $objectname, $getid);
        if ($link1['id'] == '') {
            $resa = $db->prepare("UPDATE `stock_product` SET `objectname`=?,`category`=?,`subcategory`=?,`unit`=?,`price`=?, `status`=? WHERE `id`=?");
            $resa->execute(array($objectname, $category,$subcategory,$unit,$price,$status, $getid));

           

            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
            $htry->execute(array('Object Mgmt', 10, 'UPDATE', $_SESSION['UID'], $ip, $getid));
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><h4><i class="icon fa fa-check"></i>Successfully Updated</h4></div>';
        } else {
            $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i>This area name is already exists. Please try with different Service name</h4></div>';
        }
    }
    return $res;
}
//////////////////////////
function addcategory($objectname,$status,$getid) 
{
   global $db;
    if ($getid == '') {
        $link2 = FETCH_all("SELECT `id` FROM `categories` WHERE `objectname`=?", $objectname);
        if ($link2['id'] == '') {
            $resa = $db->prepare("INSERT INTO `categories` (`objectname`,`status`) VALUES(?,?)");
            $resa->execute(array($objectname,$status));


            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
            $htry->execute(array('Object Mgmt', 10, 'INSERT', $_SESSION['UID'], $ip, $id));
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';
        } else {
            $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i>This area name is already exists. Please try with different Service name</h4></div>';
        }
    } else {
        $link1 = FETCH_all("SELECT `id` FROM `categories` WHERE `objectname`=? AND `id`!=?", $objectname, $getid);
        if ($link1['id'] == '') {
            $resa = $db->prepare("UPDATE `categories` SET `objectname`=?,`status`=? WHERE `id`=?");
            $resa->execute(array($objectname,$status, $getid));

           

            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
            $htry->execute(array('Object Mgmt', 10, 'UPDATE', $_SESSION['UID'], $ip, $getid));
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><h4><i class="icon fa fa-check"></i>Successfully Updated</h4></div>';
        } else {
            $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i>This area name is already exists. Please try with different Service name</h4></div>';
        }
    }
    return $res;

}

function getobject1($a, $b) {
    global $db;
    $get1 = $db->prepare("SELECT * FROM `stock_product` WHERE `id`=?");
    $get1->execute(array($b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}


function delobject1($a) {
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    foreach ($b as $c) {
        global $db;
$htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
            $htry->execute(array('Object Mgmt', 10, 'DELETE', $_SESSION['UID'], $ip, $getid));
        $get = $db->prepare("DELETE FROM `stock_product` WHERE `id` =? ");
        //$get = $db->prepare("UPDATE `patient` SET `status`=? WHERE `bid`=?");
        $get->execute(array(trim($c)));
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i> Successfully Deleted!</h4></div>';
    return $res;
}

function getobject($a, $b) {
    global $db;
    $get1 = $db->prepare("SELECT * FROM `object` WHERE `id`=?");
    $get1->execute(array($b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}

function getcategory($a, $b) {
    global $db;
    $get1 = $db->prepare("SELECT * FROM `categories` WHERE `id`=?");
    $get1->execute(array($b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}

function getidproof($a, $b) {
    global $db;
    $get1 = $db->prepare("SELECT * FROM `id_proof` WHERE `id`=?");
    $get1->execute(array($b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}

function delobject($a) {
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    foreach ($b as $c) {
        global $db;
$htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
            $htry->execute(array('Object Mgmt', 10, 'DELETE', $_SESSION['UID'], $ip, $getid));
        $get = $db->prepare("DELETE FROM `object` WHERE `id` =? ");
        //$get = $db->prepare("UPDATE `patient` SET `status`=? WHERE `bid`=?");
        $get->execute(array(trim($c)));
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i> Successfully Deleted!</h4></div>';
    return $res;
}

// object ends here

function getobjectsilver($a, $b) {
    global $db;
    $get1 = $db->prepare("SELECT * FROM `stock_product` WHERE `id`=?");
    $get1->execute(array($b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}
function delobjectsilver($a) {
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    foreach ($b as $c) {
        global $db;
$htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
            $htry->execute(array('silverbject Mgmt', 10, 'DELETE', $_SESSION['UID'], $ip, $getid));
        //$get = $db->prepare("DELETE FROM `silverobject` WHERE `id` =? ");
        $get = $db->prepare("UPDATE `silverobject` SET `status`= 0 WHERE `id`=?");
        $get->execute(array(trim($c)));
        // $get = $db->prepare("UPDATE `patient` SET `status`=? WHERE `bid`=?");
        // $get->execute(array(0,$c));
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i> Successfully Deleted!</h4></div>';
    return $res;
}

function addobjectsilver($objectname, $status, $getid) {
    global $db;
    if ($getid == '') {
        $link2 = FETCH_all("SELECT `id` FROM `silverobject` WHERE `objectname`=?", $objectname);
        if ($link2['id'] == '') {
            $resa = $db->prepare("INSERT INTO `silverobject` (`objectname`,`status`) VALUES(?,?)");
            $resa->execute(array($objectname, $status));

            // $l_insert = $db->lastinsertid();
            // $proofname = explode('',$proofname1);
            // $proof = explode('',$proof1);
            // $resa = $db->prepare("INSERT INTO `id_proof` (`proofname`,`proof`,`object_id`) VALUES (?,?,?) ");
            // $resa->execute(array($proofname,$proof,$l_insert));
            // $object = explode('',$object1);
            // $quantity = explode('',$quantity1);
            // $resa = $db->prepare("INSERT INTO `object_detail` (`object`,`quantity`,`object_id`) VALUES (?,?,?)");
            // $resa->execute(array($object,$quantity,$l_insert));

            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
            $htry->execute(array('silver Object Mgmt', 10, 'INSERT', $_SESSION['UID'], $ip, $id));
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';
        } else {
            $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i>This area name is already exists. Please try with different Service name</h4></div>';
        }
    } else {
        $link1 = FETCH_all("SELECT `id` FROM `silverobject` WHERE `objectname`=? AND `id`!=?", $objectname, $getid);
        if ($link1['id'] == '') {
            $resa = $db->prepare("UPDATE `silverobject` SET `objectname`=?, `status`=? WHERE `id`=?");
            $resa->execute(array($objectname, $status, $getid));

            // $resa = $db->prepare("UPDATE `id_proof` SET `proof_name`=?,`proof`=? WHERE `id`=? ");
            // $resa->execute(array($proofname,$proof,$getid));
            // $resa = $db->prepare("UPDATE `object_detail` SET `object`=?,`quantity`=? WHERE `id`=? ");
            // $resa->execute(array($object,$quantity,$getid));

            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
            $htry->execute(array('silver Object Mgmt', 10, 'UPDATE', $_SESSION['UID'], $ip, $getid));
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><h4><i class="icon fa fa-check"></i>Successfully Updated</h4></div>';
        } else {
            $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i>This area name is already exists. Please try with different Service name</h4></div>';
        }
    }
    return $res;
}

/* Driver Start here */
//sales return fuction
function addsalesreturn($cname, $supplierobject1, $sales_date, $reasonofreturn, $quantity, $requantity, $remquantity,$returndate,$object_id) 
{
    global $db;
    $resa = $db->prepare("INSERT INTO `salesreturn`(`Customer_name`, `silver_object`, `sales_date`, `reson_return`, `total_quantity`, `return_quantity`, `remaining_quantity`, `return_date`) VALUES(?,?,?,?,?,?,?,?)");
    $resa->execute(array($cname, $supplierobject1, $sales_date, $reasonofreturn, $quantity, $requantity, $remquantity,$returndate));
    $resa1 = $db->prepare("UPDATE `sales_object_detail` SET `squantity`=? WHERE `object`=? and object_id=?");
    $resa1->execute(array($remquantity,$object_id,$cname));

}
//sales return function
function adddriver($salary_per_sqm, $salary_per_km, $salary_per_weight, $salary_per_hour, $documentnamelist, $title, $firstname, $lastname, $email, $app_access, $username, $password, $mobile, $landline, $address1, $address2, $suburb, $state, $country, $postcode, $license, $licensenumber, $photo, $dob, $doj, $dot, $designation, $basic_salary, $salary_frequency, $documentlist, $emp_group, $status, $documentexpirelist, $ip, $getid) {
    global $db;
    if ($getid == '') {
        $link1 = FETCH_all("SELECT `did` FROM `driver` WHERE `email`=?", $email);
        if ($link1['did'] == '' || $link1['did'] != '') {
            $link2 = FETCH_all("SELECT `did` FROM `driver` WHERE `mobile`=?", $mobile);
            if ($link2['did'] == '') {
                $resa = $db->prepare("INSERT INTO `driver` (`salary_per_sqm`,`salary_per_km`,`salary_per_weight`,`salary_per_hour`,`documentname`,`title`,`firstname`,`lastname`,`email`,`app_access`,`username`,`password`,`mobile`,`landline`,`address1`,`address2`,`suburb`,`state`,`country`,`postcode`,`license`,`licensenumber`,`photo`,`dob`,`doj`,`dot`, `designation`,`salary_frequency`,`emp_group`,`documents`,`status`,`document_expiry_date`,`ip`,`inserted_by`) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
                $resa->execute(array($salary_per_sqm, $salary_per_km, $salary_per_weight, $salary_per_hour, $documentnamelist, $title, $firstname, $lastname, $email, $app_access, $username, $password, $mobile, $landline, $address1, $address2, $suburb, $state, $country, $postcode, $license, $licensenumber, $photo, $dob, $doj, $dot, $designation, $salary_frequency, $emp_group, $documentlist, $status, $documentexpirelist, $ip, $_SESSION['UID']));

                $id = $db->lastInsertId();
                $driverid = '5AABD' . str_pad($id, 5, 0, STR_PAD_LEFT);

                $resa = pFETCH("UPDATE `driver` SET `driverid`=? WHERE `did`=?", $driverid, $id);
                $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
                $htry->execute(array('Driver Mgmt', 9, 'INSERT', $_SESSION['UID'], $ip, $id));

                $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';
            } else {
                $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i>Mobile Number already exists!</h4></div>';
            }
        } else {
            $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i>Email already exists!</h4></div>';
        }
    } else {
        $link1 = FETCH_all("SELECT `did` FROM `driver` WHERE `email`=? AND `did`!=?", $email, $getid);
        if ($link1['did'] == '' || $link1['did'] != '') {
            $link2 = FETCH_all("SELECT `did` FROM `driver` WHERE `mobile`=? AND `did`!=?", $mobile, $getid);
            if ($link2['did'] == '') {


                $resa = $db->prepare("UPDATE `driver` SET `salary_per_sqm`=?,`salary_per_km`=?,`salary_per_weight`=?,`salary_per_hour`=?,`documentname`=?,`title`=?,`firstname`=?,`lastname`=?,`email`=?,`app_access`=?,`username`=?,`password`=?,`mobile`=?,`landline`=?,`address1`=?,`address2`=?,`suburb`=?,`state`=?,`country`=?,`postcode`=?,`license`=?,`licensenumber`=?,`photo`=?,`dob`=?,`doj`=?,`dot`=?, `designation`=?,`salary_frequency`=?,`emp_group`=?,`documents`=?,`status`=?,`document_expiry_date`=?,`ip`=?,`inserted_by`=? WHERE `did`=?");
                $resa->execute(array(trim($salary_per_sqm), trim($salary_per_km), trim($salary_per_weight), trim($salary_per_hour), trim($documentnamelist), trim($title), trim($firstname), trim($lastname), trim($email), $app_access, trim($username), trim($password), trim($mobile), trim($landline), trim($address1), trim($address2), trim($suburb), trim($state), trim($country), trim($postcode), trim($license), trim($licensenumber), trim($photo), trim($dob), trim($doj), trim($dot), trim($designation), trim($salary_frequency), trim($emp_group), trim($documentlist), trim($status), $documentexpirelist, $ip, $_SESSION['UID'], $getid));

                $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
                $htry->execute(array('Driver Mgmt', 9, 'UPDATE', $_SESSION['UID'], $ip, $getid));

                $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><h4><i class="icon fa fa-check"></i>Successfully Updated</h4></div>';
            } else {
                $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i>Mobile Number already exists!</h4></div>';
            }
        } else {
            $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i>Email already exists!</h4></div>';
        }
    }
    return $res;
}

function deldriver($a) {
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    foreach ($b as $c) {
        global $db;
        $get = $db->prepare("UPDATE `driver` SET `status`=? WHERE `did` = ? ");
        $get->execute(array('2', $c));
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i> Successfully Deleted!</h4></div>';
    return $res;
}

function getdriver($a, $b) {
    global $db;
    $get1 = $db->prepare("SELECT * FROM `driver` WHERE `did`=?");
    $get1->execute(array($b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}

/* Driver Code start here */



/* Service Code Start Here */

function addservice($name, $status, $ip, $getid) {
    global $db;
    if ($getid == '') {
        $link2 = FETCH_all("SELECT `id` FROM `service` WHERE `name`=?", $name);
        if ($link2['id'] == '') {
            $resa = $db->prepare("INSERT INTO `service` (`name`,`status`) VALUES(?,?)");
            $resa->execute(array($name, $status));

            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
            $htry->execute(array('Service Mgmt', 10, 'INSERT', $_SESSION['UID'], $ip, $id));
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';
        } else {
            $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i>This area name is already exists. Please try with different Service name</h4></div>';
        }
    } else {
        $link1 = FETCH_all("SELECT `id` FROM `service` WHERE `name`=? AND `id`!=?", $name, $getid);
        if ($link1['id'] == '') {
            $resa = $db->prepare("UPDATE `service` SET `name`=?, `status`=? WHERE `id`=?");
            $resa->execute(array($name, $status, $getid));
            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
            $htry->execute(array('Service Mgmt', 10, 'UPDATE', $_SESSION['UID'], $ip, $getid));
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><h4><i class="icon fa fa-check"></i>Successfully Updated</h4></div>';
        } else {
            $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i>This area name is already exists. Please try with different Service name</h4></div>';
        }
    }
    return $res;
}

function getservice($a, $b) {
    global $db;
    $get1 = $db->prepare("SELECT * FROM `service` WHERE `id`=?");
    $get1->execute(array($b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}

function delservice($a) {
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    foreach ($b as $c) {
        global $db;

        $get = $db->prepare("DELETE FROM `service` WHERE `id` =? ");
        $get->execute(array(trim($c)));
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i> Successfully Deleted!</h4></div>';
    return $res;
}

/* Customer Group Code Start Here */

function addcustomergroup($groupname, $discount, $status, $ip, $getid) {
    global $db;
    if ($getid == '') {
        $link2 = FETCH_all("SELECT `id` FROM `customergroup` WHERE `groupname`=?", $groupname);
        if ($link2['id'] == '') {
            $resa = $db->prepare("INSERT INTO `customergroup` (`groupname`,`discount`,`status`,`ip`,`inserted_by`) VALUES(?,?,?,?,?)");
            $resa->execute(array($groupname, $discount, $status, $ip, $_SESSION['UID']));
            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
            $htry->execute(array('CustomerGroup Mgmt', 10, 'INSERT', $_SESSION['UID'], $ip, $id));
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';
        } else {
            $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i>Group Name exists!</h4></div>';
        }
    } else {
        $link1 = FETCH_all("SELECT `id` FROM `customergroup` WHERE `groupname`=? AND `id`!=?", $groupname, $getid);
        if ($link1['id'] == '') {
            $resa = $db->prepare("UPDATE `customergroup` SET `discount`=?,`groupname`=?,  `status`=?, `ip`=?, `updated_by`=? WHERE `id`=?");
            $resa->execute(array($discount, trim($groupname), $status, trim($ip), $_SESSION['UID'], $getid));
            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
            $htry->execute(array('Customer Group Mgmt', 10, 'UPDATE', $_SESSION['UID'], $ip, $getid));
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><h4><i class="icon fa fa-check"></i>Successfully Updated</h4></div>';
        } else {
            $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i>Email already exists!</h4></div>';
        }
    }
    return $res;
}

function delcustomergroup($a) {
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    foreach ($b as $c) {
        global $db;
        $get = $db->prepare("UPDATE `customergroup` SET `status`=? WHERE `id` = ? ");
        $get->execute(array('2', $c));
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i> Successfully Deleted!</h4></div>';
    return $res;
}

function getcustomergroup($a, $b) {
    global $db;
    $get1 = $db->prepare("SELECT * FROM `customergroup` WHERE `id`=?");
    $get1->execute(array($b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}

/* Customer Group Code  End Here */

function getcustomercontact($a, $b) {
    global $db;
    $res = '';
    $get1 = pFETCH("SELECT * FROM `contact_informations` WHERE `customer_id`=?", $b);
    while ($fget = $get1->fetch(PDO::FETCH_ASSOC)) {
        $res.=$fget[$a] . ' ,';
    }
    $ress = substr($res, 0, -2);
    return $ress;
}

/* Customer Code Start Here */

function addcustomer1($credit_limit_days,$credit_limit_amt,$emailid,$cusid,$name,$contact_person,$mobileno,$area,$city,$state,$pincode,$gst,$address,$status,$getid) {
    global $db;


    if ($getid == '') {
        $link1 = FETCH_all("SELECT `id` FROM `customer` WHERE `status`=?", '1');

$resa = $db->prepare("INSERT INTO `customer` (`credit_limit_days`,`credit_limit_amt`,`emailid`,`cusid`,`contact_person`,`city`,`state`,`pincode`,`gst`,`name`,`mobileno`,`address`,`status`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)");
        $resa->execute(array($credit_limit_days,$credit_limit_amt,$emailid,$cusid,$contact_person,$city,$state,$pincode,$gst,$name,$mobileno, $address,$status));
        // $l_insert = $db->lastinsertid();
        update_bill_value('2');

        $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
        $htry->execute(array('Customer Mgmt', 10, 'INSERT', $_SESSION['UID'], $ip, $id));

        $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';
    } else {

    $resa = $db->prepare("UPDATE `customer` SET `credit_limit_days`=?,`credit_limit_amt`=?,`emailid`=?,`contact_person`=?,`city`=?,`state`=?,`pincode`=?,`gst`=?,`name`=?,`mobileno`=?,`address`=? WHERE `id`=?");
        $resa->execute(array($credit_limit_days,$credit_limit_amt,$emailid,$contact_person,$city,$state,$pincode,$gst,$name,$mobileno,$address,$getid));

        $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
        $htry->execute(array('Customer Mgmt', 10, 'UPDATE', $_SESSION['UID'], $ip, $getid));

        $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><h4><i class="icon fa fa-check"></i>Successfully Updated</h4></div>';
//            } else {
//                $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i>Mobile Number already exists!</h4></div>';
//            }
    }
    return $res;
}

function delcustomer($a) {
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    foreach ($b as $c) {
        global $db;
        $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
            $htry->execute(array('Customer Mgmt', 10, 'DELETE', $_SESSION['UID'], $ip, $getid));
        $get = $db->prepare("DELETE FROM `customer` WHERE `id` =? ");
        $get->execute(array(trim($c)));
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i> Successfully Deleted!</h4></div>';
    return $res;
}

function getcustomer($a, $b) {
    global $db;
    $get1 = $db->prepare("SELECT * FROM `customer` WHERE `id`=?");
    $get1->execute(array($b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}
/////////////////USER MANAGEMENT START////////////////////
function add_user($status,$user_name,$user_mobile,$user_usertype,$user_username,$user_password,$user_address,$user_profile_photo,$getid) {
    global $db;


    if ($getid == '') {
        //$link1 = FETCH_all("SELECT `id` FROM `hotel_users` WHERE `status`=?", '1');

$resa = $db->prepare("INSERT INTO `hotel_users` (`status`,`user_name`,`user_mobile`,`user_usertype`,`user_username`,`user_password`,`user_address`) VALUES(?,?,?,?,?,?,?)");
$resa->execute(array($status,$user_name,$user_mobile,$user_usertype,$user_username,$user_password,$user_address));
        // $l_insert = $db->lastinsertid();
		$lastid11=$db->lastInsertId();
//create user
$uresa = $db->prepare("INSERT INTO users (`usertype`,`name`,`merchant`,`val1`, `val2`, `val3`) VALUES (?,?,?,?,?,?)" );
$uresa->execute(array('subuser',$user_name,$lastid11,$user_username,md5($user_password),$status));
//create user

        update_bill_value('2');
        //hotel_users
        $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
        $htry->execute(array('Customer Mgmt', 10, 'INSERT', $_SESSION['UID'], $ip, $id));

        $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';
    } else {

    $resa = $db->prepare("UPDATE `hotel_users` SET `status`=?,`user_name`=?,`user_mobile`=?,`user_usertype`=?,`user_username`=?,`user_password`=?,`user_address`=? WHERE `user_id`=?");
$resa->execute(array($status,$user_name,$user_mobile,$user_usertype,$user_username,$user_password,$user_address,$getid));


//update user
$uresa = $db->prepare("UPDATE users SET `name`=?, `val1`=?, `val2`=?, `val3`=? WHERE `merchant`=? AND `usertype`=? " );
$uresa->execute(array($name,$user_username,md5($user_password),$status,$getid,'subuser'));
//update user


        $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
        $htry->execute(array('Customer Mgmt', 10, 'UPDATE', $_SESSION['UID'], $ip, $getid));

        $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><h4><i class="icon fa fa-check"></i>Successfully Updated</h4></div>';

    }
    return $res;
}

function del_users($a) {
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    foreach ($b as $c) {
        global $db;
        $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
            $htry->execute(array('Customer Mgmt', 10, 'DELETE', $_SESSION['UID'], $ip, $getid));
		$get1 = $db->prepare("DELETE FROM `users` WHERE `merchant` =? AND `usertype`=?");
        $get1->execute(array(trim($c),'subuser'));
		
        $get = $db->prepare("DELETE FROM `hotel_users` WHERE `user_id` =? ");
        $get->execute(array(trim($c)));
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i> Successfully Deleted!</h4></div>';
    return $res;
}

function get_users($a, $b) {
    global $db;
    $get1 = $db->prepare("SELECT * FROM `hotel_users` WHERE `user_id`=?");
    $get1->execute(array($b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}
/////////////////USER MANAGEMENT END//////////////////////
/////////////////CATEGORIES MANAGEMENT START///////////////////
function add_categories($category_name,$status,$getid)
{
	global $db;
     if ($getid == '') {
     $link1 = FETCH_all("SELECT `category_id` FROM `hotel_categories` WHERE `category_name`=?", $category_name);
if($link1['category_id']=='') {
$resa = $db->prepare("INSERT INTO `hotel_categories` (`category_name`,`status`) VALUES (?,?)");
$resa->execute(array($category_name,$status));
        // $l_insert = $db->lastinsertid();
       // update_bill_value('2');
        //hotel_users
        $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
        $htry->execute(array('Customer Mgmt', 10, 'INSERT', $_SESSION['UID'], $ip, $id));

        $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';
}
else
{
$res = '<div class="alert alert-error alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4>Category Already Exist</h4></div>';	
}
    } else {
   $link1 = FETCH_all("SELECT `category_id` FROM `hotel_categories` WHERE `category_name`=? AND `category_id`!=?", $category_name,$getid);
if($link1['category_id']=='') {
	
    $resa = $db->prepare("UPDATE `hotel_categories` SET `category_name`=?,`status`=? WHERE `category_id`=?");
$resa->execute(array($category_name,$status,$getid));

        $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
        $htry->execute(array('Customer Mgmt', 10, 'UPDATE', $_SESSION['UID'], $ip, $getid));

        $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><h4><i class="icon fa fa-check"></i>Successfully Updated</h4></div>';
}
else
{
$res = '<div class="alert alert-error alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4>Category Already Exist</h4></div>';	
}
    }
    return $res;
}
function del_categories($a) {
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    foreach ($b as $c) {
        global $db;
        $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
            $htry->execute(array('Customer Mgmt', 10, 'DELETE', $_SESSION['UID'], $ip, $getid));
        $get = $db->prepare("DELETE FROM `hotel_categories` WHERE `category_id` =? ");
        $get->execute(array(trim($c)));
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i> Successfully Deleted!</h4></div>';
    return $res;
}

function getcategories($a, $b) {
    global $db;
    $get1 = $db->prepare("SELECT * FROM `hotel_categories` WHERE `category_id`=?");
    $get1->execute(array($b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}
/////////////////CATEGORIES MANAGEMENT END///////////////////
function addloan($cusid, $customerid, $date,$valueofitem, $receipt_no, $name, $mobileno, $image, $address, $object1, $object_image1, $idproof, $proofname1, $proof1, $quantity1, $totalquantity, $netweight, $amount, $interestpercent, $interest, $status, $ip, $getid) {
    global $db;

    if ($getid == '') {
        $link1 = FETCH_all("SELECT * FROM `loan` WHERE `receipt_no`=?", $receipt_no);
        if ($link1['receipt_no'] == '') {
//        $link1 = FETCH_all("SELECT `id` FROM `loan` WHERE `status`=?", '1');

            $resa = $db->prepare("INSERT INTO `loan` (`cusid`,`customerid`,`date`,`valueofitem`,`receipt_no`,`name`,`address`,`mobileno`,`totalquantity`,`image`,`idproof`,`netweight`,`amount`,`interestpercent`,`interest`,`status`,`returnstatus`) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
            $resa->execute(array($cusid, $customerid, date('Y-m-d', strtotime($date)),$valueofitem, $receipt_no, $name, $address, $mobileno, $totalquantity, $image, $idproof, $netweight, $amount, $interestpercent, $interest, $status, '2'));
            $l_insert = $db->lastinsertid();
            update_bill_value('5');

            $objectval = explode(',', $object1);
            $quantity = explode(',', $quantity1);
            $object_image = explode(',', $object_image1);
//                print_r($objectval);
//                exit;

            foreach ($objectval as $key => $value) {
                if ($objectval[$key] != '') {

                    $resa = $db->prepare("INSERT INTO `object_detail` (`object`,`quantity`,`object_image`,`object_id`,`status`) VALUES (?,?,?,?,?) ");
                    $resa->execute(array($objectval[$key], $quantity[$key], $object_image[$key], $l_insert, '1'));
                }
            }
            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
            $htry->execute(array('Customer Mgmt', 10, 'INSERT', $_SESSION['UID'], $ip, $id));
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';
        } else {
            $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-check"></i>Already Exists !...</h4></div>';
        }

        header("Location:../MPDF/receiptprint.php?id=".$l_insert. "");
        exit;
    } else {
        $link1 = FETCH_all("SELECT * FROM `loan` WHERE `receipt_no`=? AND `id`!=?", $receipt_no, $getid);
        if ($link1['receipt_no'] == '') {

            $resa = $db->prepare("UPDATE `loan` SET `cusid`=?,`customerid`=?,`date`=?,`valueofitem`=?,`receipt_no`=?,`name`=?,`address`=?,`mobileno`=?,`totalquantity`=?,`image`=?,`idproof`=?,`object`=?,`quantity`=?,`netweight`=?,`amount`=?,`interestpercent`=?,`interest`=?,`status`=? WHERE `id`=?");
            $resa->execute(array($cusid, $customerid, date('d-m-Y', strtotime($date)),$valueofitem, $receipt_no, $name, $address, $mobileno, $totalquantity, $image, $idproof, $object, $quantity, $netweight, $amount, $interestpercent, $interest, $status, $getid));

            $get = $db->prepare("DELETE FROM `object_detail` WHERE `object_id` =? ");
            $get->execute(array(trim($getid)));

            $objectval = explode(',', $object1);
            $quantity = explode(',', $quantity1);
            $object_image = explode(',', $object_image1);

            foreach ($objectval as $key => $value) {

                if ($objectval[$key] != '') {
                    $resa = $db->prepare("INSERT INTO `object_detail` (`object`,`quantity`,`object_image`,`object_id`,`status`) VALUES (?,?,?,?,?) ");
                    $resa->execute(array($objectval[$key], $quantity[$key], $object_image[$key], $getid, '1'));
                }
            }

            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
            $htry->execute(array('Customer Mgmt', 10, 'UPDATE', $_SESSION['UID'], $ip, $getid));

            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><h4><i class="icon fa fa-check"></i>Successfully Updated</h4></div>';
        } else {
            $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-check"></i>Already Exists !..</h4></div>';
        }return $res;
    }
    
}

function delloan($a) {
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    foreach ($b as $c) {
        global $db;
        $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
            $htry->execute(array('Loan Mgmt', 10, 'DELETE', $_SESSION['UID'], $ip, $getid));
        $get = $db->prepare("DELETE FROM `loan` WHERE `id` =? ");
        $get->execute(array(trim($c)));
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i> Successfully Deleted!</h4></div>';
    return $res;
}

function getloan($a, $b) {
    global $db;
    $get1 = $db->prepare("SELECT * FROM `loan` WHERE `id`=?");
    $get1->execute(array($b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}


function getobjectdetail($a, $b) {
    global $db;
    $get1 = $db->prepare("SELECT * FROM `object_detail` WHERE `id`=?");
    $get1->execute(array($b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}

/* Customer Code Start Here */

function addreturn($customerid, $customeridname, $object, $loanid, $date, $name, $mobileno, $netweight, $amount, $interestpercent, $interest, $status, $pawndays, $currentdate, $totalinterest, $pamount, $finalpay, $ip, $getid) {
    global $db;
    $link1 = FETCH_all("SELECT * FROM `return` WHERE `id`=?", $getid);
    if ($link1['id'] == '') {

        $link1 = FETCH_all("SELECT * FROM `return` WHERE `loanid`=?", $loanid);
        if ($link1['loanid'] == '') {
            $loanvar = FETCH_all("SELECT * FROM `loan` WHERE `id`=?", $loanid);
            $receipt_no = $loanvar['receipt_no'];
            $resa = $db->prepare("INSERT INTO `return` (`customerid`,`customeridname`,`object`,`loanid`,`receipt_no`,`date`,`name`,`mobileno`,`netweight`,`amount`,`interestpercent`,`interest`,`status`,`pawndays`,`currentdate`,`totalinterest`,`pamount`,`finalpay`,`ip`) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
            $resa->execute(array($customerid, $customeridname, $object, $loanid, $receipt_no, date('d-m-Y', strtotime($date)), $name, $mobileno, $netweight, $amount, $interestpercent, $interest, $status, $pawndays, $currentdate, $totalinterest, $pamount, $finalpay, $ip));

            $returnstatus = $db->lastinsertid();
            if ($status == '1') {
                $resaa = $db->prepare("UPDATE `loan` SET `returnstatus`=? WHERE `receipt_no`=? ");
                $resaa->execute(array('1', $receipt_no));
            } else {
                $resaa = $db->prepare("UPDATE `loan` SET `returnstatus`=? WHERE `receipt_no`=? ");
                $resaa->execute(array('0', $receipt_no));
            }

            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
            $htry->execute(array('Retrun Mgmt', 10, 'INSERT', $_SESSION['UID'], $ip, $getid));

            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';
        } else {
            $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-check"></i>Already Exsits!...</h4></div>';
        }
    } else {
        $link1 = FETCH_all("SELECT * FROM `return` WHERE `loanid`=? AND `id`!=?", $loanid, $getid);
        if ($link1['loanid'] == '') {
            $loanvar = FETCH_all("SELECT * FROM `loan` WHERE `id`=?", $loanid);
            $receipt_no = $loanvar['receipt_no'];
            if ($status == '1') {
                $resaa = $db->prepare("UPDATE `loan` SET `returnstatus`=? WHERE `receipt_no`=? ");
                $resaa->execute(array('1', $receipt_no));
            } else {
                $resaa = $db->prepare("UPDATE `loan` SET `returnstatus`=? WHERE `receipt_no`=? ");
                $resaa->execute(array('0', $receipt_no));
            }
            $resa = $db->prepare("UPDATE `return` SET `customerid`=?,`customeridname`=?,`object`=?,`loanid`=?,`receipt_no`=?,`date`=?,`name`=?,`mobileno`=?,`netweight`=?,`amount`=?,`interestpercent`=?,`interest`=?,`status`=?,`pawndays`=?,`currentdate`=?,`totalinterest`=?,`pamount`=?,`finalpay`=?,`ip`=? WHERE `id`=?");
            $resa->execute(array($customerid, $customeridname, $object, $loanid, $receipt_no, date('Y-m-d', strtotime($date)), $name, $mobileno, $netweight, $amount, $interestpercent, $interest, $status, $pawndays, $currentdate, $totalinterest, $pamount, $finalpay, $ip, $getid));

            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
            $htry->execute(array('return Mgmt', 10, 'UPDATE', $_SESSION['UID'], $ip, $getid));

            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><h4><i class="icon fa fa-check"></i>Successfully Updated</h4></div>';
        } else {
            $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><h4><i class="icon fa fa-check"></i>Already exists !...</h4></div>';
        }
    }
    return $res;
}

function getreturn($a, $b) {
    global $db;
    $get1 = $db->prepare("SELECT * FROM `return` WHERE `id`=?");
    $get1->execute(array($b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}

function delreturn($a) {
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    foreach ($b as $c) {
        global $db;
        $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
            $htry->execute(array('return Mgmt', 10, 'DELETE', $_SESSION['UID'], $ip, $getid));
        $get = $db->prepare("DELETE FROM `return` WHERE `id` =? ");
        $get->execute(array(trim($c)));
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i> Successfully Deleted!</h4></div>';
    return $res;
}

function addbankstatus($receiptno,$loanno,$name,$cus_amount, $bankname, $dateofpawn, $object1,$quantity1,$totalquantity, $weight, $amount, $interestpercent, $interest,$month, $status, $totalamount, $returndate,$no_of_days, $ip, $getid) 
{
    global $db;
    $link1 = FETCH_all("SELECT * FROM `bankstatus` WHERE `id`=?", $getid);
    if ($link1['id'] == '') 
    {
    $resa = $db->prepare("INSERT INTO `bankstatus` (`receiptno`,`loanno`,`name`,`cus_amount`,`bankname`,`no_of_days`,`dateofpawn`,`totalquantity`,`weight`,`amount`,`interestpercent`,`interest`,`month`,`status`,`totalamount`,`returndate`,`ip`) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
        $resa->execute(array($receiptno,$loanno,$name,$cus_amount,$bankname,$no_of_days, date('Y-m-d', strtotime($dateofpawn)), $totalquantity,$weight, $amount, $interestpercent, $interest,$month, $status, $totalamount, $returndate, $ip));
$l_insert = $db->lastinsertid();
//         update_bill_value('2');
        
        $objectval = explode(',', $object1);
            $quantity = explode(',', $quantity1);
            $object_image = explode(',', $object_image1);
            foreach ($objectval as $key => $value)
             {
                if ($objectval[$key] != '') 
                {

                    $resa = $db->prepare("INSERT INTO `bank_object_detail` (`object`,`quantity`,`object_image`,`object_id`,`status`) VALUES (?,?,?,?,?) ");
                    $resa->execute(array($objectval[$key], $quantity[$key], $object_image[$key], $l_insert, '1'));
                }
            }

        $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
        $htry->execute(array('Bank status Mgmt', 10, 'INSERT', $_SESSION['UID'], $ip, $getid));

        $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';
    } 
    else 
    {
        
        $resa = $db->prepare("UPDATE `bankstatus` SET `receiptno`=?,`loanno`=?,`name`=?,`cus_amount`=?,`bankname`=?,`no_of_days`=?,`dateofpawn`=?,`totalquantity`=?,`weight`=?,`amount`=?,`interestpercent`=?,`interest`=?,`month`=?,`status`=?,`totalamount`=?,`returndate`=?,`ip`=? WHERE `id`=?");
        $resa->execute(array($receiptno,$loanno,$name,$cus_amount, $bankname,$no_of_days, date('Y-m-d', strtotime($dateofpawn)), $totalquantity, $weight, $amount, $interestpercent, $interest,$month, $status, $totalamount, $returndate, $ip, $getid));
         $get = $db->prepare("DELETE FROM `bank_object_detail` WHERE `object_id` =? ");
            $get->execute(array(trim($getid)));

            $objectval = explode(',', $object1);
            $quantity = explode(',', $quantity1);
            $object_image = explode(',', $object_image1);

            foreach ($objectval as $key => $value) {

                if ($objectval[$key] != '') {
                    $resa = $db->prepare("INSERT INTO `bank_object_detail` (`object`,`quantity`,`object_image`,`object_id`,`status`) VALUES (?,?,?,?,?) ");
                    $resa->execute(array($objectval[$key], $quantity[$key], $object_image[$key], $getid, '1'));
                }
            }


        $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
        $htry->execute(array('return Mgmt', 10, 'UPDATE', $_SESSION['UID'], $ip, $getid));

        $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><h4><i class="icon fa fa-check"></i>Successfully Updated</h4></div>';

    }
    return $res;
}

// }

function addpurchasereturn($style1,$meter1,$orgrate1,$mrp_price1,$hsn1,$oid1,$bill_no,$supplierid, $date, $netweight, $amount, $status,$object1, $quantity1,$rate1,$tamount1, $sub_total,$discount,$tot_amt,$payment_type,$advance_amount,$balance_amount,$getid)
{
    global $db;
     if ($getid == '') {
       

            $resa = $db->prepare("INSERT INTO `purchasereturn` (`bill_number`,`supplierid`,`date`,`status`,`sub_total`,`discount`,`tot_amt`,`advance_amount`,`balance_amount`,`payment_type`) VALUES(?,?,?,?,?,?,?,?,?,?)");
            $resa->execute(array($bill_no,$supplierid, date('Y-m-d', strtotime($date)),$status, $sub_total, $discount,$tot_amt,$advance_amount,$balance_amount,$payment_type));
            $l_insert = $db->lastinsertid();
//        if($payment_type==0) {
//             $cresa = $db->prepare("INSERT INTO `credit_payment` (`type`,`billno`,`supplier_id`,`purchase_id`,`purchase_amt`,`advance_amt`,`balance_amt`) VALUES(?,?,?,?,?,?,?)");
// $cresa->execute(array('purchase',$bill_no,$supplierid,$l_insert,$tot_amt,$advance_amount,$balance_amount));
//        }
       

            $objectval = explode(',', $object1);
            $quantity = explode(',', $quantity1);
            $rate = explode(',', $rate1);
             $style = explode(',', $style1);
            $meter = explode(',', $meter1);
            $orgrate = explode(',', $orgrate1);
            $mrp_price = explode(',', $mrp_price1);
            $tamount = explode(',', $tamount1);
 $hsn = explode(',', $hsn1);

            foreach ($objectval as $key => $value) 
            {
                if ($objectval[$key] != '') {
 
 $getproduct = FETCH_all("SELECT `id` FROM `object` WHERE `objectname`=?", $objectval[$key]);
 
 $proid=$getproduct['id'];
                    $resa = $db->prepare("INSERT INTO `purchasereturn_object_detail` (`style`,`meter`,`orgrate`,`mrp_price`,`hsn`,`productid`,`object`,`pquantity`,`rate`,`amount`,`object_id`,`status`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?) ");
                    $resa->execute(array($style[$key],$meter[$key],$orgrate[$key],$mrp_price[$key],$hsn[$key],$proid,$objectval[$key], $quantity[$key],$rate[$key],$tamount[$key], $l_insert, '1'));
               
                }
            }
             
            $get = $db->prepare("TRUNCATE `temp_purchase_detail` ");
         $get->execute(array());
                 

                 if($payment_type==0) {
 $chkcredit = FETCH_all("SELECT * FROM `credit_payment` WHERE `type`='purchase' AND `billno`=?", $bill_no);
   if($chkcredit['id']=='') { 

   $cresa = $db->prepare("INSERT INTO `credit_payment` (`type`,`billno`,`supplier_id`,`purchase_id`,`purchase_amt`,`advance_amt`,`balance_amt`) VALUES(?,?,?,?,?,?,?)");
$cresa->execute(array('purchase',$bill_no,$supplierid,$getid,$tot_amt,$advance_amount,$balance_amount));
   }
   else
   {
       $cresa = $db->prepare("UPDATE `credit_payment` SET `billno`=?,`supplier_id`=?,`purchase_amt`=?,`advance_amt`=?,`balance_amt`=? WHERE `purchase_id`=? AND `type`=? ");
$cresa->execute(array($bill_no,$supplierid,$tot_amt,$advance_amount,$balance_amount,$getid,'purchase')); 
   }
   
}


           
            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
            $htry->execute(array('purchase Mgmt', 10, 'INSERT', $_SESSION['UID'], $ip, $id));
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';
        

//        header("Location:../MPDF/receiptprint.php?id=".$l_insert. "");
//        exit;
    } else {
//        $link1 = FETCH_all("SELECT * FROM `loan` WHERE `receipt_no`=? AND `id`!=?", $receipt_no, $getid);
    

            
            
            $resa = $db->prepare("UPDATE `purchasereturn` SET `bill_number`=?,`supplierid`=?,`date`=?,`status`=?,`sub_total`=?,`discount`=?,`tot_amt`=?,`advance_amount`=?,`balance_amount`=?,`payment_type`=? WHERE `id`=? ");
            $resa->execute(array($bill_no,$supplierid, date('Y-m-d', strtotime($date)),$status, $sub_total, $discount,$tot_amt,$advance_amount,$balance_amount,$payment_type,$getid));

// if($payment_type==0) {
//  $chkcredit = FETCH_all("SELECT * FROM `credit_payment` WHERE `type`='purchase' AND `purchase_id`=?", $getid);
//    if($chkcredit['id']=='') { 

//    $cresa = $db->prepare("INSERT INTO `credit_payment` (`type`,`billno`,`supplier_id`,`purchase_id`,`purchase_amt`,`advance_amt`,`balance_amt`) VALUES(?,?,?,?,?,?,?)");
// $cresa->execute(array('purchase',$bill_no,$supplierid,$getid,$tot_amt,$advance_amount,$balance_amount));
//    }
//    else
//    {
//        $cresa = $db->prepare("UPDATE `credit_payment` SET `billno`=?,`supplier_id`=?,`purchase_amt`=?,`advance_amt`=?,`balance_amt`=? WHERE `purchase_id`=? AND `type`=?");
// $cresa->execute(array($bill_no,$supplierid,$tot_amt,$advance_amount,$balance_amount,$getid,'purchase')); 
//    }
   
// }
//             $oid= explode(',',$oid1);
            $objectval = explode(',', $object1);
            $quantity = explode(',', $quantity1);
            $rate = explode(',', $rate1);
            $mrp_price = explode(',', $mrp_price1);
             $style = explode(',', $style1);
            $meter = explode(',', $meter1);
            $orgrate = explode(',', $orgrate1);
            $tamount = explode(',', $tamount1);
            $hsn = explode(',', $hsn1);

            foreach ($objectval as $key => $value) 
            {
                if ($objectval[$key] != '') {
                     
 $getproduct = FETCH_all("SELECT `id` FROM `object` WHERE `objectname`=?", $objectval[$key]);
 
 $proid=$getproduct['id'];
                    if($oid[$key]=='') { 
                    $resa = $db->prepare("INSERT INTO `purchasereturn_object_detail` (`style`,`meter`,`orgrate`,`mrp_price`,`hsn`,`productid`,`object`,`pquantity`,`rate`,`amount`,`object_id`,`status`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?) ");
                    $resa->execute(array($style[$key],$meter[$key],$orgrate[$key],$mrp_price[$key],$hsn[$key],$proid,$objectval[$key], $quantity[$key],$rate[$key],$tamount[$key], $getid, '1'));
                    }
                    else {
                         $resa = $db->prepare("UPDATE `purchasereturn_object_detail` SET `style`=?,`meter`=?,`orgrate`=?,`mrp_price`=?,`hsn`=?,`productid`=?,`object`=?,`pquantity`=?,`rate`=?,`amount`=?,`object_id`=?,`status`=? WHERE `id`=?");
                    $resa->execute(array($style[$key],$meter[$key],$orgrate[$key],$mrp_price[$key],$hsn[$key],$proid,$objectval[$key], $quantity[$key],$rate[$key],$tamount[$key], $getid, '1',$oid[$key]));
                    }
                    
                    
                    
                }
            }
             
               
               $get = $db->prepare("TRUNCATE `temp_purchase_detail` ");
         $get->execute(array());


            if($payment_type==0) {
 $chkcredit = FETCH_all("SELECT * FROM `credit_payment` WHERE `type`='purchase' AND `billno`=?", $bill_no);
   if($chkcredit['id']=='') { 

   $cresa = $db->prepare("INSERT INTO `credit_payment` (`type`,`billno`,`supplier_id`,`purchase_id`,`purchase_amt`,`advance_amt`,`balance_amt`) VALUES(?,?,?,?,?,?,?)");
$cresa->execute(array('purchase',$bill_no,$supplierid,$getid,$tot_amt,$advance_amount,$balance_amount));
   }
   else
   {
       $cresa = $db->prepare("UPDATE `credit_payment` SET `billno`=?,`supplier_id`=?,`purchase_amt`=?,`advance_amt`=?,`balance_amt`=? WHERE `purchase_id`=? AND `type`=? ");
$cresa->execute(array($bill_no,$supplierid,$tot_amt,$advance_amount,$balance_amount,$getid,'purchase')); 
   }
   
}

            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><h4><i class="icon fa fa-check"></i>Successfully Updated</h4></div>';
       
    }return $res;
}

function getbankstatus($a, $b) {
    global $db;
    $get1 = $db->prepare("SELECT * FROM `bankstatus` WHERE `id`=?");
    $get1->execute(array($b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}

function delbankstatus($a) {
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    foreach ($b as $c) {
        global $db;
        $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
            $htry->execute(array('bankstatus Mgmt', 10, 'DELETE', $_SESSION['UID'], $ip, $getid));
        $get = $db->prepare("DELETE FROM `bankstatus` WHERE `id` =? ");
        $get->execute(array(trim($c)));
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i> Successfully Deleted!</h4></div>';
    return $res;
}

function addreturnview($customerid, $customeridname, $object, $receiptno, $date, $name, $mobileno, $netweight, $amount, $interestpercent, $interest, $status, $pawndays, $currentdate, $totalinterest, $pamount, $finalpay, $ip, $getid) {
    global $db;
    $link1 = FETCH_all("SELECT * FROM `returnview` WHERE `id`=?", $getid);
    if ($link1['id'] == '') {

        $resa = $db->prepare("INSERT INTO `returnview` (`customerid`,`customeridname`,`object`,`receiptno`,`date`,`name`,`mobileno`,`netweight`,`amount`,`interestpercent`,`interest`,`status`,`pawndays`,`currentdate`,`totalinterest`,`pamount`,`finalpay`,`ip`) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
        $resa->execute(array($customerid, $customeridname, $object, $receiptno, date('d-m-Y', strtotime($date)), $name, $mobileno, $netweight, $amount, $interestpercent, $interest, $status, $pawndays, $currentdate, $totalinterest, $pamount, $finalpay, $ip));

        $returnstatus = $db->lastinsertid();

        $resa = $db->prepare("UPDATE `loan` SET `returnstatus`=? WHERE `id`=?");
        $resa->execute(array(0, $returnstatus));
        $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
        $htry->execute(array('Retrun Mgmt', 10, 'INSERT', $_SESSION['UID'], $ip, $getid));

        $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';
    } else {

        $resa = $db->prepare("UPDATE `returnview` SET `customerid`=?,`customeridname`=?,`object`=?,`receiptno`=?,`date`=?,`name`=?,`mobileno`=?,`netweight`=?,`amount`=?,`interestpercent`=?,`interest`=?,`status`=?,`pawndays`=?,`currentdate`=?,`totalinterest`=?,`pamount`=?,`finalpay`=?,`ip`=? WHERE `id`=?");
        $resa->execute(array($customerid, $customeridname, $object, $receiptno, date('Y-m-d', strtotime($date)), $name, $mobileno, $netweight, $amount, $interestpercent, $interest, $status, $pawndays, $currentdate, $totalinterest, $pamount, $finalpay, $ip, $getid));

        $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
        $htry->execute(array('return Mgmt', 10, 'UPDATE', $_SESSION['UID'], $ip, $getid));

        $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><h4><i class="icon fa fa-check"></i>Successfully Updated</h4></div>';
    }
    return $res;
}

function getreturnview($a, $b) {
    global $db;
    $get1 = $db->prepare("SELECT * FROM `returnview` WHERE `id`=?");
    $get1->execute(array($b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}

function delreturnview($a) {
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    foreach ($b as $c) {
        global $db;
        $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
            $htry->execute(array('return Mgmt', 10, 'DELETE', $_SESSION['UID'], $ip, $getid));
        $get = $db->prepare("DELETE FROM `returnview` WHERE `id` =? ");
        $get->execute(array(trim($c)));
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i> Successfully Deleted!</h4></div>';
    return $res;
}
function getsupplier($a, $b) {
    global $db;
    $get1 = $db->prepare("SELECT * FROM `supplier` WHERE `id`=?");
    $get1->execute(array($b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}

function addsupplier($shopname, $suppliername, $area, $mobileno,$status,$ip,$getid) {
    global $db;
     $link1 = FETCH_all("SELECT `id` FROM `supplier` WHERE `suppliername`=?", $suppliername);
    if ($link1['id'] == '') {

$resa = $db->prepare("INSERT INTO `supplier` (`shopname`,`suppliername`, `area`,`mobileno`,`status`,`date`,`ip`) VALUES(?,?,?,?,?,?,?)");
            $resa->execute(array($shopname, $suppliername , $area, $mobileno,$status,date('Y-m-d'),$ip));


            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';
      
    } else {
        
            $resa = $db->prepare("UPDATE `supplier` SET `shopname`=?,`suppliername`=? ,`area`=? ,`mobileno`=?, `status`=?, `date`=?, `ip`=? WHERE `id`=?");
            $resa->execute(array(trim($shopname), trim($suppliername),trim($area), trim($mobileno), trim($status), date('Y-m-d'),$ip,$getid));

            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
            $htry->execute(array('supplier Mgmt', 17, 'Update', $_SESSION['UID'], $ip, $id));
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><h4><i class="icon fa fa-check"></i>Successfully Updated</h4></div>';
        
    }
    return $res;
}

function delsupplier($a) {
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    foreach ($b as $c) {
        global $db;
        $get = $db->prepare("DELETE FROM `supplier` WHERE `id` = ? ");
        $get->execute(array($c));
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i> Successfully Deleted!</h4></div>';
    return $res;
}
function 
getpurchase($a, $b) {
    global $db;
    $get1 = $db->prepare("SELECT * FROM `purchase` WHERE `id`=?");
    $get1->execute(array($b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}


function addpurchaseorder($style1,$meter1,$orgrate1,$mrp_price1,$hsn1,$oid1,$bill_no,$supplierid, $date, $netweight, $amount, $status,$object1, $quantity1,$rate1,$tamount1, $sub_total,$discount,$tot_amt,$payment_type,$advance_amount,$balance_amount,$getid)
{
    global $db;
     if ($getid == '') {
       

            $resa = $db->prepare("INSERT INTO `purchaseorder` (`bill_number`,`supplierid`,`date`,`status`,`sub_total`,`discount`,`tot_amt`,`advance_amount`,`balance_amount`,`payment_type`) VALUES(?,?,?,?,?,?,?,?,?,?)");
            $resa->execute(array($bill_no,$supplierid, date('Y-m-d', strtotime($date)),$status, $sub_total, $discount,$tot_amt,$advance_amount,$balance_amount,$payment_type));
            $l_insert = $db->lastinsertid();
       if($payment_type==0) {
            $cresa = $db->prepare("INSERT INTO `credit_payment` (`type`,`billno`,`supplier_id`,`purchase_id`,`purchase_amt`,`advance_amt`,`balance_amt`) VALUES(?,?,?,?,?,?,?)");
$cresa->execute(array('purchase',$bill_no,$supplierid,$l_insert,$tot_amt,$advance_amount,$balance_amount));
       }
       

            $objectval = explode(',', $object1);
            $quantity = explode(',', $quantity1);
            $rate = explode(',', $rate1);
            $style = explode(',', $style1);
            $meter = explode(',', $meter1);
            $orgrate = explode(',', $orgrate1);
             $mrp_price = explode(',', $mrp_price1);
            $tamount = explode(',', $tamount1);
 $hsn = explode(',', $hsn1);

            foreach ($objectval as $key => $value) 
            {
                if ($objectval[$key] != '') {
 
 $getproduct = FETCH_all("SELECT `id` FROM `object` WHERE `objectname`=?", $objectval[$key]);
 
 $proid=$getproduct['id'];
                    $resa = $db->prepare("INSERT INTO `purchaseorder_object_detail` (`style`,`meter`,`orgrate`,`mrp_price`,`hsn`,`productid`,`object`,`pquantity`,`rate`,`amount`,`object_id`,`status`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?) ");
                    $resa->execute(array($style[$key],$meter[$key],$orgrate[$key],$mrp_price[$key],$hsn[$key],$proid,$objectval[$key], $quantity[$key],$rate[$key],$tamount[$key], $l_insert, '1'));
               
                }
            }
             
                        $get = $db->prepare("TRUNCATE `temp_purchase_detail` ");
         $get->execute(array());
           
            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
            $htry->execute(array('purchase Mgmt', 10, 'INSERT', $_SESSION['UID'], $ip, $id));
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';
        

//        header("Location:../MPDF/receiptprint.php?id=".$l_insert. "");
//        exit;
    } else {
//        $link1 = FETCH_all("SELECT * FROM `loan` WHERE `receipt_no`=? AND `id`!=?", $receipt_no, $getid);
    

            
            
            $resa = $db->prepare("UPDATE `purchaseorder` SET `bill_number`=?,`supplierid`=?,`date`=?,`status`=?,`sub_total`=?,`discount`=?,`tot_amt`=?,`advance_amount`=?,`balance_amount`=?,`payment_type`=? WHERE `id`=? ");
            $resa->execute(array($bill_no,$supplierid, date('Y-m-d', strtotime($date)),$status, $sub_total, $discount,$tot_amt,$advance_amount,$balance_amount,$payment_type,$getid));

if($payment_type==0) {
 $chkcredit = FETCH_all("SELECT * FROM `credit_payment` WHERE `type`='purchase' AND `purchase_id`=?", $getid);
   if($chkcredit['id']=='') { 

   $cresa = $db->prepare("INSERT INTO `credit_payment` (`type`,`billno`,`supplier_id`,`purchase_id`,`purchase_amt`,`advance_amt`,`balance_amt`) VALUES(?,?,?,?,?,?,?)");
$cresa->execute(array('purchase',$bill_no,$supplierid,$getid,$tot_amt,$advance_amount,$balance_amount));
   }
   else
   {
       $cresa = $db->prepare("UPDATE `credit_payment` SET `billno`=?,`supplier_id`=?,`purchase_amt`=?,`advance_amt`=?,`balance_amt`=? WHERE `purchase_id`=? AND `type`=? ");
$cresa->execute(array($bill_no,$supplierid,$tot_amt,$advance_amount,$balance_amount,$getid,'purchase')); 
   }
   
}
            $oid= explode(',',$oid1);
            $objectval = explode(',', $object1);
            $quantity = explode(',', $quantity1);
            $rate = explode(',', $rate1);
              $style = explode(',', $style1);
            $meter = explode(',', $meter1);
            $orgrate = explode(',', $orgrate1);
             $mrp_price = explode(',', $mrp_price1);
            $tamount = explode(',', $tamount1);
            $hsn = explode(',', $hsn1);

            foreach ($objectval as $key => $value) 
            {
                if ($objectval[$key] != '') {
                     
 $getproduct = FETCH_all("SELECT `id` FROM `object` WHERE `objectname`=?", $objectval[$key]);
 
 $proid=$getproduct['id'];
                    if($oid[$key]=='') { 
                    $resa = $db->prepare("INSERT INTO `purchaseorder_object_detail` (`style`,`meter`,`orgrate`,`mrp_price`,`hsn`,`productid`,`object`,`pquantity`,`rate`,`amount`,`object_id`,`status`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?) ");
                    $resa->execute(array($style[$key],$meter[$key],$orgrate[$key],$mrp_price[$key],$hsn[$key],$proid,$objectval[$key], $quantity[$key],$rate[$key],$tamount[$key], $getid, '1'));
                    }
                    else {
                         $resa = $db->prepare("UPDATE `purchaseorder_object_detail` SET `style`=?,`meter`=?,`orgrate`=?,`mrp_price`=?,`hsn`=?,`productid`=?,`object`=?,`pquantity`=?,`rate`=?,`amount`=?,`object_id`=?,`status`=? WHERE `id`=?");
                    $resa->execute(array($style[$key],$meter[$key],$orgrate[$key],$mrp_price[$key],$hsn[$key],$proid,$objectval[$key], $quantity[$key],$rate[$key],$tamount[$key], $getid, '1',$oid[$key]));
                    }
                    
                    
                    
                }
            }
             
               
               
       $get = $db->prepare("TRUNCATE `temp_purchase_detail` ");
         $get->execute(array());
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><h4><i class="icon fa fa-check"></i>Successfully Updated</h4></div>';
       
    }return $res;
}


function addpurchase($discount_percent1,$discount_value1,$margin1,$sales_price1,$overallchk,$cmargin,$entry_person,$style1,$meter1,$orgrate1,$mrp_price1,$hsn1,$oid1,$bill_no,$supplierid, $date, $netweight, $amount, $status,$object1, $quantity1,$rate1,$tamount1, $sub_total,$discount,$tot_amt,$payment_type,$advance_amount,$balance_amount,$getid)
{
    global $db;
     global $sitename;
     if ($getid == '') {
           $resa = $db->prepare("INSERT INTO `purchase` (`overallchk`,`cmargin`,`entry_person`,`bill_number`,`supplierid`,`date`,`status`,`sub_total`,`discount`,`tot_amt`,`advance_amount`,`balance_amount`,`payment_type`) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?)");
            $resa->execute(array($overallchk,$cmargin,$entry_person,$bill_no,$supplierid, date('Y-m-d', strtotime($date)),$status, $sub_total, $discount,$tot_amt,$advance_amount,$balance_amount,$payment_type));
            $l_insert = $db->lastinsertid();
       if($payment_type==0) {
            $cresa = $db->prepare("INSERT INTO `credit_payment` (`type`,`billno`,`supplier_id`,`purchase_id`,`purchase_amt`,`advance_amt`,`balance_amt`) VALUES(?,?,?,?,?,?,?)");
$cresa->execute(array('purchase',$bill_no,$supplierid,$l_insert,$tot_amt,$advance_amount,$balance_amount));
	   }
	   

            $objectval = explode(',', $object1);
            $quantity = explode(',', $quantity1);
            $rate = explode(',', $rate1);
             $style = explode(',', $style1);
            $meter = explode(',', $meter1);
            $orgrate = explode(',', $orgrate1);
            $mrp_price = explode(',', $mrp_price1);
            $tamount = explode(',', $tamount1);
            $hsn = explode(',', $hsn1);
            $discount_percent = explode(',', $discount_percent1);
            $discount_value = explode(',', $discount_value1);
            $margin = explode(',', $margin1);
            $sales_price = explode(',', $sales_price1);
            foreach ($objectval as $key => $value) 
            {
                if ($objectval[$key] != '') {
 
 $getproduct = FETCH_all("SELECT `id` FROM `object` WHERE `objectname`=?", $objectval[$key]);
 
 $proid=$getproduct['id'];
                    $resa = $db->prepare("INSERT INTO `purchase_object_detail` (`discount_percent`,`discount_value`,`margin`,`sales_price`,`style`,`meter`,`orgrate`,`mrp_price`,`hsn`,`productid`,`object`,`pquantity`,`rate`,`amount`,`object_id`,`status`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ");
                    $resa->execute(array($discount_percent[$key],$discount_value[$key],$margin[$key],$sales_price[$key],$style[$key],$meter[$key],$orgrate[$key],$mrp_price[$key],$hsn[$key],$proid,$objectval[$key], $quantity[$key],$rate[$key],$tamount[$key], $l_insert, '1'));
               
                }
            }
             
                 
           
            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
            $htry->execute(array('purchase Mgmt', 10, 'INSERT', $_SESSION['UID'], $ip, $id));
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';
      $url=$sitename.'/pages/process/purchasebarcode.php?purchaseid='.$l_insert;
  echo "<script>
        window.open('".$url."', '_blank');
    </script>";



//        header("Location:../MPDF/receiptprint.php?id=".$l_insert. "");
//        exit;
    } else {
//        $link1 = FETCH_all("SELECT * FROM `loan` WHERE `receipt_no`=? AND `id`!=?", $receipt_no, $getid);
    

            
			
            $resa = $db->prepare("UPDATE `purchase` SET `overallchk`=?,`cmargin`=?,`entry_person`=?,`bill_number`=?,`supplierid`=?,`date`=?,`status`=?,`sub_total`=?,`discount`=?,`tot_amt`=?,`advance_amount`=?,`balance_amount`=?,`payment_type`=? WHERE `id`=? ");
            $resa->execute(array($overallchk,$cmargin,$entry_person,$bill_no,$supplierid, date('Y-m-d', strtotime($date)),$status, $sub_total, $discount,$tot_amt,$advance_amount,$balance_amount,$payment_type,$getid));

if($payment_type==0) {
 $chkcredit = FETCH_all("SELECT * FROM `credit_payment` WHERE `type`='purchase' AND `purchase_id`=?", $getid);
   if($chkcredit['id']=='') { 

   $cresa = $db->prepare("INSERT INTO `credit_payment` (`type`,`billno`,`supplier_id`,`purchase_id`,`purchase_amt`,`advance_amt`,`balance_amt`) VALUES(?,?,?,?,?,?,?)");
$cresa->execute(array('purchase',$bill_no,$supplierid,$getid,$tot_amt,$advance_amount,$balance_amount));
   }
   else
   {
	   $cresa = $db->prepare("UPDATE `credit_payment` SET `billno`=?,`supplier_id`=?,`purchase_amt`=?,`advance_amt`=?,`balance_amt`=? WHERE `purchase_id`=? AND `type`=? ");
$cresa->execute(array($bill_no,$supplierid,$tot_amt,$advance_amount,$balance_amount,$getid,'purchase')); 
   }
   
}
            $oid= explode(',',$oid1);
            $objectval = explode(',', $object1);
            $quantity = explode(',', $quantity1);
            $rate = explode(',', $rate1);
             $style = explode(',', $style1);
            $meter = explode(',', $meter1);
            $orgrate = explode(',', $orgrate1);
             $mrp_price = explode(',', $mrp_price1);
            $tamount = explode(',', $tamount1);
            $hsn = explode(',', $hsn1);
              $discount_percent = explode(',', $discount_percent1);
            $discount_value = explode(',', $discount_value1);
            $margin = explode(',', $margin1);
            $sales_price = explode(',', $sales_price1);

            foreach ($objectval as $key => $value) 
            {
                if ($objectval[$key] != '') {
					 
 $getproduct = FETCH_all("SELECT `id` FROM `object` WHERE `objectname`=?", $objectval[$key]);
 
 $proid=$getproduct['id'];
                    if($oid[$key]=='') { 
                    $resa = $db->prepare("INSERT INTO `purchase_object_detail` (`discount_percent`,`discount_value`,`margin`,`sales_price`,`style`,`meter`,`orgrate`,`mrp_price`,`hsn`,`productid`,`object`,`pquantity`,`rate`,`amount`,`object_id`,`status`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ");
                    $resa->execute(array($discount_percent[$key],$discount_value[$key],$margin[$key],$sales_price[$key],$style[$key],$meter[$key],$orgrate[$key],$mrp_price[$key],$hsn[$key],$proid,$objectval[$key], $quantity[$key],$rate[$key],$tamount[$key], $getid, '1'));
					}
					else {
						 $resa = $db->prepare("UPDATE `purchase_object_detail` SET `discount_percent`=?,`discount_value`=?,`margin`=?,`sales_price`=?,`style`=?,`meter`=?,`orgrate`=?,`mrp_price`=?,`hsn`=?,`productid`=?,`object`=?,`pquantity`=?,`rate`=?,`amount`=?,`object_id`=?,`status`=? WHERE `id`=?");
                    $resa->execute(array($discount_percent[$key],$discount_value[$key],$margin[$key],$sales_price[$key],$style[$key],$meter[$key],$orgrate[$key],$mrp_price[$key],$hsn[$key],$proid,$objectval[$key], $quantity[$key],$rate[$key],$tamount[$key], $getid, '1',$oid[$key]));
					}
					
					
					
                }
            }
             
         $url=$sitename.'/pages/process/purchasebarcode.php?purchaseid='.$getid;
  echo "<script>
        window.open('".$url."', '_blank');
    </script>";
       
			   

            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><h4><i class="icon fa fa-check"></i>Successfully Updated</h4></div>';
       
    }return $res;
}
///////////////////////////////////////
function add_sales_purchase($supplierid, $date, $netweight, $amount, $status,$object1, $quantity1,$rate1,$tamount1, $getid) 
{
    global $db;
$link1 = FETCH_all("SELECT `suppliername` FROM `supplier` WHERE `id`=?", $supplierid);
$s_name = $link1['suppliername'];
     if ($getid == '') {
       

            $resa = $db->prepare("INSERT INTO `sales_purchase` (`supplierid`,`date`,`netweight`,`amount`,`status`) VALUES(?,?,?,?,?)");
            $resa->execute(array($s_name, date('Y-m-d', strtotime($date)),$netweight, $amount, $status));
            $l_insert = $db->lastinsertid();
       
            update_bill_value('5');

            $objectval = explode(',', $object1);
            $quantity = explode(',', $quantity1);
            $rate = explode(',', $rate1);
            $tamount = explode(',', $tamount1);
 

            foreach ($objectval as $key => $value) 
            {
                if ($objectval[$key] != '') {

                    $resa = $db->prepare("INSERT INTO `sales_purchase_object_detail` (`object`,`pquantity`,`rate`,`amount`,`object_id`,`status`) VALUES (?,?,?,?,?,?) ");
                    $resa->execute(array($objectval[$key], $quantity[$key],$rate[$key],$tamount[$key], $l_insert, '1'));
                    

           
                
                
           
                }
            }
             
                 
           
            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
            $htry->execute(array('purchase Mgmt', 10, 'INSERT', $_SESSION['UID'], $ip, $id));
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';
        

//        header("Location:../MPDF/receiptprint.php?id=".$l_insert. "");
//        exit;
    } else {
//        $link1 = FETCH_all("SELECT * FROM `loan` WHERE `receipt_no`=? AND `id`!=?", $receipt_no, $getid);
    

            $resa = $db->prepare("UPDATE `purchase` SET `supplierid`=?,`date`=?,`valueofitem`=?,`totalquantity`=?,`image`=?,`idproof`=?,`quantity`=?,`netweight`=?,`amount`=?,`interestpercent`=?,`interest`=?,`status`=? WHERE `id`=?");
            $resa->execute(array($supplierid, date('Y-m-d', strtotime($date)),$valueofitem, $totalquantity, $image, $idproof,  $quantity, $netweight, $amount, $interestpercent, $interest, $status, $getid));
 
            $resa = $db->prepare("UPDATE `stocks` SET `supplier_id`=?,`date`=?,`rate`=?,`weight`=?,`status`=? WHERE `purid`=?");
            $resa->execute(array($supplierid, date('Y-m-d', strtotime($date)), $amount, $netweight,'1',$getid));
            $get = $db->prepare("DELETE FROM `purchase_object_detail` WHERE `object_id` =? ");
            $get->execute(array(trim($getid)));

            $objectval = explode(',', $object1);
            $quantity = explode(',', $quantity1);
            $object_image = explode(',', $object_image1);

            foreach ($objectval as $key => $value) {
                    
                if ($objectval[$key] != '') {
                    
                    $resa = $db->prepare("INSERT INTO `purchase_object_detail` (`object`,`pquantity`,`object_image`,`object_id`,`status`) VALUES (?,?,?,?,?) ");
                    $resa->execute(array($objectval[$key], $quantity[$key], $object_image[$key], $getid, '1'));
                    $resa = $db->prepare("UPDATE `stocks` SET `object_name`=?,`qty`=?,`status`=? WHERE `purid`=?");
            $resa->execute(array($objectval[$key], $quantity[$key],'1',$getid));
                }
            }
          

            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
            $htry->execute(array('Purchase Mgmt', 10, 'UPDATE', $_SESSION['UID'], $ip, $getid));

            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><h4><i class="icon fa fa-check"></i>Successfully Updated</h4></div>';
       
    }return $res;
}
///////////////////////////////////////
function delpurchaseorder($a) {
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    foreach ($b as $c) {
        global $db;
        foreach ($b as $c) {

                    $get = $db->prepare("DELETE FROM `purchaseorder_object_detail` WHERE `object_id` = ? ");
        $get->execute(array($c));

            }
        $get = $db->prepare("DELETE FROM `purchaseorder` WHERE `id` = ? ");
        $get->execute(array($c));
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i> Successfully Deleted!</h4></div>';
    return $res;
}
function delpurchasereturn($a) {
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    foreach ($b as $c) {
        global $db;
        foreach ($b as $c) {

                    $get = $db->prepare("DELETE FROM `purchasereturn_object_detail` WHERE `object_id` = ? ");
        $get->execute(array($c));

            }
        $get = $db->prepare("DELETE FROM `purchasereturn` WHERE `id` = ? ");
        $get->execute(array($c));
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i> Successfully Deleted!</h4></div>';
    return $res;
}

function delpurchase($a) {
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    foreach ($b as $c) {
        global $db;
        foreach ($b as $c) {

                    $get = $db->prepare("DELETE FROM `purchase_object_detail` WHERE `object_id` = ? ");
        $get->execute(array($c));

            }
        $get = $db->prepare("DELETE FROM `purchase` WHERE `id` = ? ");
        $get->execute(array($c));
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i> Successfully Deleted!</h4></div>';
    return $res;
}

// sales fn

function getsales($a, $b) {
    global $db;
    $get1 = $db->prepare("SELECT * FROM `online_order` WHERE `id`=?");
    $get1->execute(array($b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}
function getsales1($a, $b) {
    global $db;
    $get1 = $db->prepare("SELECT * FROM `sale_bill` WHERE id=4");
    $get1->execute(array($b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}
function addsales1($style1,$meter1,$orgrate1,$taxtype,$mrp_price1,$salesman,$hsn1,$billtypemast,$bill_advanceamt,$bill_balanceamt,$gstresult1,$gsttype,$gstvalue,$cgstvalue,$sgstvalue,$billtype,$order_method,$oid1,$payment_mode,$customer_name, $order_type, $date, $bill_no,$object1, $quantity1, $rate1, $total1, $given_amt, $balance_amt,$sub_total,$discount,$packing_charge,$delivery_charge,$tot_amt,$getid)
{
   global $db;
   if ($getid == '') 
    {
if($_SESSION['usertype']=='subuser') {
$createdby='subuser';
}
else
{
$createdby='admin';
}	
$createdid=$_SESSION['UID'];
$resa = $db->prepare("INSERT INTO `online_order` (`cgstvalue`,`sgstvalue`,`taxtype`,`salesman`,`billtypemast`,`bill_advanceamt`,`bill_balanceamt`,`gsttype`,`gstvalue`,`createdby`,`created_id`,`billtype`,`order_method`,`payment_mode`,`customer_id`,`order_type`,`date`,`bill_number`,`given_amnt`,`balance_amnt`,`sub_tot`,`discount`,`packing_charges`,`delivery_charges`,`total_amnt`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");

$resa->execute(array($cgstvalue,$sgstvalue,$taxtype,$salesman,$billtypemast,$bill_advanceamt,$bill_balanceamt,$gsttype,$gstvalue,$createdby,$createdid,$billtype,$order_method,$payment_mode,$customer_name,$order_type,$date,$bill_no,$given_amt,$balance_amt,$sub_total, $discount, $packing_charge, $delivery_charge, $tot_amt));



            $l_insert = $db->lastinsertid();
            $salesprint=getsettings('setting_value','1');
            if($salesprint=='1') {
			 $url="../../MPDF/bill.php?id=".$l_insert;
            }
            else
            {
             $url="../../MPDF/billinvoice2.php?id=".$l_insert;   
            }
           // update_bill_value('5');
            $objectval = explode(',', $object1);
            $quantity = explode(',', $quantity1);
            $rate = explode(',', $rate1);
            $total = explode(',', $total1);
            $mrp_price = explode(',', $mrp_price1);
            $style = explode(',', $style1);
            $meter = explode(',', $meter1);
            $orgrate = explode(',', $orgrate1);

            $hsn = explode(',', $hsn1);
            $gstresult=explode(',',$gstresult1);
            foreach ($objectval as $key => $value)
             {
                    
                if ($objectval[$key] != '') 
                {
                    
                    $resa = $db->prepare("INSERT INTO `online_order_deatils` (`style`,`meter`,`orgrate`,`hsn`,`gstresult`,`object_id`,`bill_no`,`product_name`,`qty`,`rate`,`total`,`mrp_price`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?) ");
            $resa->execute(array($style[$key],$meter[$key],$orgrate[$key],$hsn[$key],$gstresult[$key],$l_insert,$bill_no,$objectval[$key], $quantity[$key], $rate[$key], $total[$key], $mrp_price[$key]));
                    
                }
            }
 $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';

echo "<script>window.open('".$url."', '_blank');</script>";
    }
    else
    {

$resa = $db->prepare("UPDATE `online_order` SET `cgstvalue`=?,`sgstvalue`=?,`taxtype`=?,`salesman`=?,`billtypemast`=?,`bill_advanceamt`=?,`bill_balanceamt`=?,`gsttype`=?,`gstvalue`=?,`billtype`=?,`order_method`=?,`payment_mode`=?,`customer_id`=?,`order_type`=?,`date`=?,`bill_number`=?,`given_amnt`=?,`balance_amnt`=?,`sub_tot`=?,`discount`=?,`packing_charges`=?,`delivery_charges`=?,`total_amnt`=? WHERE `id`=?");

$resa->execute(array($cgstvalue,$sgstvalue,$taxtype,$salesman,$billtypemast,$bill_advanceamt,$bill_balanceamt,$gsttype,$gstvalue,$billtype,$order_method,$payment_mode,$customer_name,$order_type,$date,$bill_no,$given_amt,$balance_amt,$sub_total, $discount, $packing_charge, $delivery_charge, $tot_amt,$getid));

 $salesprint=getsettings('setting_value','1');
            if($salesprint=='1') {
             $url="../../MPDF/bill.php?id=".$getid;
            }
            else
            {
             $url="../../MPDF/billinvoice2.php?id=".$getid;   
            }

			 $oid = explode(',', $oid1);
			  
             $objectval = explode(',', $object1);
            $quantity = explode(',', $quantity1);
            $rate = explode(',', $rate1);
            $total = explode(',', $total1);
              $style = explode(',', $style1);
            $meter = explode(',', $meter1);
            $orgrate = explode(',', $orgrate1);
             $mrp_price = explode(',', $mrp_price1);
                $hsn = explode(',', $hsn1);
             $gstresult=explode(',',$gstresult1);
            foreach ($objectval as $key => $value)
             {
                    
                if ($objectval[$key] != '') 
                {
                    if($oid[$key]=='') {
                    $resa = $db->prepare("INSERT INTO `online_order_deatils` (`style`,`meter`,`orgrate`,`mrp_price`,`hsn`,`gstresult`,`object_id`,`bill_no`,`product_name`,`qty`,`rate`,`total`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?) ");
            $resa->execute(array($style[$key],$meter[$key],$orgrate[$key],$mrp_price[$key],$hsn[$key],$gstresult[$key],$getid,$bill_no,$objectval[$key], $quantity[$key], $rate[$key], $total[$key]));
					}
					else
					{
					 $resa = $db->prepare("UPDATE `online_order_deatils` SET `style`=?,`meter`=?,`orgrate`=?,`mrp_price`=?,`hsn`=?,`gstresult`=?,`object_id`=?,`bill_no`=?,`product_name`=?,`qty`=?,`rate`=?,`total`=? WHERE `id`=? ");
            $resa->execute(array($style[$key],$meter[$key],$orgrate[$key],$mrp_price[$key],$hsn[$key],$gstresult[$key],$getid,$bill_no,$objectval[$key], $quantity[$key], $rate[$key], $total[$key], $oid[$key]));	
					}
					
                    
                }
            }
			
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><h4><i class="icon fa fa-check"></i>Successfully Updated</h4></div>';
 echo "<script>window.open('".$url."', '_blank');</script>";
    }
    return $res;
    
}
///////////////////////////
function getstoreorder($a, $b) {
    global $db;
    $get1 = $db->prepare("SELECT * FROM `online_store_order` WHERE `id`=?");
    $get1->execute(array($b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}

function addsales1_store($oid1,$payment_mode,$customer_name, $order_type, $date, $bill_no,$object1, $quantity1, $rate1, $total1, $given_amt, $balance_amt,$sub_total,$discount,$packing_charge,$delivery_charge,$tot_amt,$getid) 
{
   global $db;
   if ($getid == '') 
    {
        
$resa = $db->prepare("INSERT INTO `online_store_order` (`payment_mode`,`customer_id`,`order_type`,`date`,`bill_number`,`given_amnt`,`balance_amnt`,`sub_tot`,`discount`,`packing_charges`,`delivery_charges`,`total_amnt`) VALUES(?,?,?,?,?,?,?,?,?,?,?,?)");

$resa->execute(array($payment_mode,$customer_name,$order_type,$date,$bill_no,$given_amt,$balance_amt,$sub_total, $discount, $packing_charge, $delivery_charge, $tot_amt));



            $l_insert = $db->lastinsertid();
			 $url="../../MPDF/storebill.php?id=".$l_insert;
            update_bill_value('5');
            $objectval = explode(',', $object1);
            $quantity = explode(',', $quantity1);
            $rate = explode(',', $rate1);
            $total = explode(',', $total1);
            foreach ($objectval as $key => $value)
             {
                    
                if ($objectval[$key] != '') 
                {
                    
                    $resa = $db->prepare("INSERT INTO `online_store_order_deatils` (`object_id`,`bill_no`,`product_name`,`qty`,`rate`,`total`) VALUES (?,?,?,?,?,?) ");
            $resa->execute(array($l_insert,$bill_no,$objectval[$key], $quantity[$key], $rate[$key], $total[$key]));
                    
                }
            }
$res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';
//echo "<script>window.open('".$url."', '_blank');</script>";
    }
    else
    {

$resa = $db->prepare("UPDATE `online_store_order` SET `payment_mode`=?,`customer_id`=?,`order_type`=?,`date`=?,`bill_number`=?,`given_amnt`=?,`balance_amnt`=?,`sub_tot`=?,`discount`=?,`packing_charges`=?,`delivery_charges`=?,`total_amnt`=? WHERE `id`=?");

$resa->execute(array($payment_mode,$customer_name,$order_type,$date,$bill_no,$given_amt,$balance_amt,$sub_total, $discount, $packing_charge, $delivery_charge, $tot_amt,$getid));



			 $url="../../MPDF/storebill.php?id=".$getid;
           
		   
		    $oid=explode(',',$oid1);
            $objectval = explode(',', $object1);
            $quantity = explode(',', $quantity1);
            $rate = explode(',', $rate1);
            $total = explode(',', $total1);
            foreach ($objectval as $key => $value)
             {
                    
                if ($objectval[$key] != '') 
                {
                    if($oid[$key]=='') {
                    $resa = $db->prepare("INSERT INTO `online_store_order_deatils` (`object_id`,`bill_no`,`product_name`,`qty`,`rate`,`total`) VALUES (?,?,?,?,?,?) ");
            $resa->execute(array($getid,$bill_no,$objectval[$key], $quantity[$key], $rate[$key], $total[$key]));
                    }
					else{
					  $resa = $db->prepare("UPDATE `online_store_order_deatils` SET `object_id`=?,`bill_no`=?,`product_name`=?,`qty`=?,`rate`=?,`total`=? WHERE `id`=?");
            $resa->execute(array($getid,$bill_no,$objectval[$key], $quantity[$key], $rate[$key], $total[$key],$oid[$key]));	
					}
                }
            }
			
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><h4><i class="icon fa fa-check"></i>Successfully Updated</h4></div>';
//echo "<script>window.open('".$url."', '_blank');</script>";
    }
    return $res;
    
}
////////////////////////////


function delsalesorder($a) {
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    foreach ($b as $c) {
        global $db;
          $get = $db->prepare("DELETE FROM `sales_order_details` WHERE `object_id` =? ");
         $get->execute(array(trim($c)));
         
          $get1 = $db->prepare("DELETE FROM `sales_order` WHERE `id` =? ");
         $get1->execute(array(trim($c)));
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i> Successfully Deleted!</h4></div>';
    return $res;
}

function delsalesreturn($a) {
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    foreach ($b as $c) {
        global $db;
          $get = $db->prepare("DELETE FROM `sales_return_details` WHERE `object_id` =? ");
         $get->execute(array(trim($c)));
         
          $get1 = $db->prepare("DELETE FROM `sales_return` WHERE `id` =? ");
         $get1->execute(array(trim($c)));
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i> Successfully Deleted!</h4></div>';
    return $res;
}


function delsales($a) {
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    foreach ($b as $c) {
        global $db;
        $get = $db->prepare("DELETE FROM `sales` WHERE `id` = ? ");
        $get->execute(array($c));
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i> Successfully Deleted!</h4></div>';
    return $res;
}


function addmembership($membershipid, $planname, $amount, $valid_fromdate, $valid_todate, $description, $status, $ip, $getid) {
    global $db;

    if ($getid == '') {

        $link1 = FETCH_all("SELECT `cid` FROM `membership` WHERE `planname`=?", $planname);
        if ($link1['cid'] == '') {
            $resa = $db->prepare("INSERT INTO `membership` (`membershipid`,`planname`,`amount`,`valid_fromdate`,`valid_todate`,`description`,`status`) VALUES(?,?,?,?,?,?,?)");
            $resa->execute(array($membershipid, $planname, $amount, $valid_fromdate, $valid_todate, $description, $status));

            update_bill_value('4');


            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
            $htry->execute(array('Membership Mgmt', 10, 'INSERT', $_SESSION['UID'], $ip, $id));

            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';
        } else {
            $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i>Membership Plan Name already exists!</h4></div>';
        }
    } else {
        $link1 = FETCH_all("SELECT `cid` FROM `membership` WHERE `planname`=? AND `cid`!=?", $cname, $getid);
        if ($link1['cid'] == '') {
            $resa = $db->prepare("UPDATE `membership` SET `membershipid`=?,`planname`=?,`amount`=?,`valid_fromdate`=?,`valid_todate`=?,`description`=?,`status`=? WHERE `cid`=?");
            $resa->execute(array($membershipid, $planname, $amount, $valid_fromdate, $valid_todate, $description, $status, $getid));


            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
            $htry->execute(array('Customer Mgmt', 10, 'UPDATE', $_SESSION['UID'], $ip, $getid));

            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><h4><i class="icon fa fa-check"></i>Successfully Updated</h4></div>';
        } else {
            $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i>Customer Name already exists!</h4></div>';
        }
    }
    return $res;
}

function delmembership($a) {
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    foreach ($b as $c) {
        global $db;
        $get = $db->prepare("DELETE FROM `membership` WHERE `cid` =? ");
        $get->execute(array(trim($c)));
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i> Successfully Deleted!</h4></div>';
    return $res;
}

function getmembership($a, $b) {
    global $db;
    $get1 = $db->prepare("SELECT * FROM `membership` WHERE `cid`=?");
    $get1->execute(array($b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}

function addprovider($merchantname, $area, $address, $offerids, $offernames, $discounts, $valid_fromdates, $valid_todates, $statuss, $status, $ip, $getid) {
    global $db;

    if ($getid == '') {

        $link1 = FETCH_all("SELECT `id` FROM `provider` WHERE `merchantname`=?", $merchantname);


        if ($link1['id'] == '') {

            $resa = $db->prepare("INSERT INTO `provider` (`merchantname`,`area`,`address`,`status`) VALUES(?,?,?,?)");
            $resa->execute(array($merchantname, $area, $address, $status));

            $ins_id = $db->lastInsertId();

            update_bill_value('3');

            $offerids1 = explode(',', $offerids);
            $offernames1 = explode(',', $offernames);
            $discounts1 = explode(',', $discounts);


            $valid_fromdates1 = explode(',', $valid_fromdates);
            $valid_todates1 = explode(',', $valid_todates);

            $status1 = explode(',', $statuss);


            foreach ($valid_todates1 as $key => $value) {
                //echo "teste";exit;
                if ($valid_todates1[$key] != '') {

                    $fdate = date('Y-m-d', strtotime($valid_fromdates1[$key]));
//echo "<br>";
                    $tdate = date('Y-m-d', strtotime($valid_todates1[$key]));

                    $resa1 = $db->prepare("INSERT INTO `offerdetails` (`prov_id`,`merchantid`,`offerid`,`offername`,`discount`,`valid_fromdate`,`valid_todate`,`status`) VALUES(?,?,?,?,?,?,?,?)");
                    $resa1->execute(array($ins_id, $merchantname, $offerids1[$key], $offernames1[$key], $discounts1[$key], $fdate, $tdate, $status1[$key]));
                }
            }
            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
            $htry->execute(array('Provider Mgmt', 10, 'INSERT', $_SESSION['UID'], $ip, $id));

            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';
        } else {
            $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i>Merchant Name already exists!</h4></div>';
        }
    } else {
        $link1 = FETCH_all("SELECT `id` FROM `provider` WHERE `merchantname`=? AND `id`!=?", $merchantname, $getid);
        if ($link1['id'] == '') {

            $resa = $db->prepare("UPDATE `provider` SET `merchantname`=?,`area`=?,`address`=?,`status`=? WHERE `id`=?");
            $resa->execute(array($merchantname, $area, $address, $status, $getid));




            $get1 = $db->prepare("DELETE FROM `offerdetails` WHERE `prov_id` = ? ");
            $get1->execute(array($getid));


            $offerids1 = explode(',', $offerids);
            $offernames1 = explode(',', $offernames);
            $discounts1 = explode(',', $discounts);


            $valid_fromdates1 = explode(',', $valid_fromdates);
            $valid_todates1 = explode(',', $valid_todates);

            $status1 = explode(',', $statuss);


            foreach ($valid_todates1 as $key => $value) {
                //echo "teste";exit;
                if ($valid_todates1[$key] != '') {

                    $fdate = date('Y-m-d', strtotime($valid_fromdates1[$key]));
//echo "<br>";
                    $tdate = date('Y-m-d', strtotime($valid_todates1[$key]));

                    $resa1 = $db->prepare("INSERT INTO `offerdetails` (`prov_id`,`merchantid`,`offerid`,`offername`,`discount`,`valid_fromdate`,`valid_todate`,`status`) VALUES(?,?,?,?,?,?,?,?)");
                    $resa1->execute(array($getid, $merchantname, $offerids1[$key], $offernames1[$key], $discounts1[$key], $fdate, $tdate, $status1[$key]));
                }
            }


            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
            $htry->execute(array('Provider Mgmt', 10, 'UPDATE', $_SESSION['UID'], $ip, $getid));

            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><h4><i class="icon fa fa-check"></i>Successfully Updated</h4></div>';
        } else {
            $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i>Merchant Name already exists!</h4></div>';
        }
    }
    return $res;
}

/* Customer Code End Here */

function delprovider($a) {
    global $db;
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    foreach ($b as $c) {

        $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");

        $htry->execute(array('Provider', $thispageid, 'Delete', $_SESSION['UID'], $_SERVER['REMOTE_ADDR'], trim($c)));


        $get1 = $db->prepare("DELETE FROM `offerdetails` WHERE `prov_id` =? ");
        $get1->execute(array(trim($c)));

        $get = $db->prepare("DELETE FROM `provider` WHERE `id` =? ");
        $get->execute(array(trim($c)));
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i> Successfully Deleted</h4></div>';
    return $res;
}

function getprovider($a, $b) {
    global $db;
    $get1 = $db->prepare("SELECT * FROM `provider` WHERE `id`=?");
    $get1->execute(array($b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}

function delmerchant($a) {
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    foreach ($b as $c) {
        global $db;

        $get = $db->prepare("DELETE FROM `sales_merchant` WHERE `id` =? ");
        $get->execute(array(trim($c)));
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i> Successfully Deleted!</h4></div>';
    return $res;
}

function addmerchant($merchantid, $merchantname, $shopname, $cnumber, $scnumber, $emailid, $address, $description, $status, $ip, $getid) {
    global $db;
    if ($getid == '') {
        $link1 = FETCH_all("SELECT `id` FROM `sales_merchant` WHERE `merchantname`=?", $merchantname);
        if ($link1['id'] == '') {

            $resa = $db->prepare("INSERT INTO `sales_merchant` ( `merchantid`, `merchantname`, `shopname`, `address`, `cnumber`, `scnumber`, `emailid`, `description`, `status`) VALUES(?,?,?,?,?,?,?,?,?)");
            $resa->execute(array($merchantid, $merchantname, $shopname, $address, $cnumber, $scnumber, $emailid, $description, $status));


            update_bill_value('1');

            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
            $htry->execute(array('Employee Designation Mgmt', 15, 'INSERT', $_SESSION['UID'], $ip, $id));

            //$res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';

            //echo '<meta http-equiv="refresh" content="3;url=' . $sitename . 'merchant.htm' . '">';
            //exit;
        } else {
            $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i>Merchant Name already exists!</h4></div>';
        }
    } else {

        $link1 = FETCH_all("SELECT `id` FROM `sales_merchant` WHERE `merchantname`=? AND `id`!=?", $merchantname, $getid);
        if ($link1['id'] == '') {

            $resa = $db->prepare("UPDATE `sales_merchant` SET `merchantid`=?,`merchantname`=?,`shopname`=?,`address`=?,`cnumber`=?,`scnumber`=?,`emailid`=?,`description`=?,`status`=? WHERE `id`=?");
            $resa->execute(array($merchantid, $merchantname, $shopname, $address, $cnumber, $scnumber, $emailid, $description, $status, $getid));

            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
            $htry->execute(array('Employee Designation Category Mgmt', 15, 'UPDATE', $_SESSION['UID'], $ip, $getid));

            // $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><h4><i class="icon fa fa-check"></i>Successfully Updated</h4></div>';
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><h4><i class="icon fa fa-check"></i>Successfully Updated</h4></div>';

            //echo '<meta http-equiv="refresh" content="3;url=' . $sitename . 'merchant.htm' . '">';
            //exit;
        } else {
            $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i>Merchant Name already exists!</h4></div>';
        }
    }
    return $res;
}

function getmerchant($a, $b) {
    global $db;
    $get1 = $db->prepare("SELECT * FROM `sales_merchant` WHERE `id`=?");
    $get1->execute(array($b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}

function addimage($image, $imagename, $imagealt, $status, $ip, $thispageid, $getid) {
    global $db;
    if ($getid == '') {

        $link23 = $db->prepare("SELECT * FROM `imageup` WHERE `image_name` = ? ");
        $link23->execute(array($imagename));
        $link22 = $link23->fetch();
        if ($link22['image_name'] == '') {

            $qa = $db->prepare("INSERT INTO `imageup`(`image`, `image_name`, `image_alt`, `status`, `ip`, `updated_by`) values(?, ?, ?, ?, ?, ?) ");
            $qa->execute(array($image, $imagename, $imagealt, $status, $ip, $_SESSION['UID']));

            $id = $db->lastInsertId();
            $htry = $db->prepare("INSERT INTO `history`(`page`, `pageid`, `action`, `userid`, `ip`, `actionid`) VALUES(?, ?, ?, ?, ?, ?)");
            $htry->execute(array('imageup', 40, 'Insert', $_SESSION['UID'], $ip, $getid));

            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button><h4><i class="icon fa fa-check"></i> Successfully Saved</h4></div>';
        } else {
            $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="fa fa-times"></i></button><h4><i class="icon fa fa-close"></i> Image Name already exists!</h4></div>';
        }
        return $res;
    }
}

function getimage($a, $b) {
    global $db;
    $res = $db->prepare("SELECT * FROM `imageup` WHERE `aiid` = ? ");
    $res->execute(array($b));
    $res = $res->fetch();
    return $res[$a];
}

function getstaticpages($a, $b) {
    global $db;
    $get1 = $db->prepare("SELECT * FROM `static_pages` WHERE `stid`=?");
    $get1->execute(array($b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
//$res = "SELECT * FROM `sendgrid` WHERE `sgid`='$b'";
    return $res;
}

function delstaticpages($a) {
    global $db;
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    foreach ($b as $c) {
        $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
        $htry->execute(array('staticPages', $thispageid, 'Delete', $_SESSION['UID'], $_SERVER['REMOTE_ADDR'], trim($c)));
        $get = $db->prepare("DELETE FROM `static_pages` WHERE `stid` =? ");
        $get->execute(array(trim($c)));
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i> Successfully Deleted</h4></div>';
    return $res;
}

?>