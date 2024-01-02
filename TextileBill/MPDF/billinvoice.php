<?php
require_once 'vendor/autoload.php';
include ('../config/config.inc.php');


$supplier = FETCH_all("SELECT * FROM `online_order` WHERE `id`=?", $_REQUEST['id']);
$manageprofile = FETCH_all("SELECT * FROM `manageprofile` WHERE `pid`=?", 1);

$message = '
<table width="100%" border="0" cellpadding="0" cellspacing="0">
<tr>
<td width="70%"><img src="'.$sitename.'pages/profile/image/'.$manageprofile['image'].'" height="64px;"></td>
<td width="30%">
<table width="100%">
<tr>
<td><h2>Bill No '.$supplier['bill_number'].'</h2></td>
</tr>
<tr>
<td><strong>Date </strong>'.date('M-d,Y',strtotime($supplier['cudate'])).'</td>
</tr>
<tr>
<td><strong>Due Date </strong>'.date('M-d,Y',strtotime($supplier['cudate'])).'</td>
</tr>
</table>
</td>
</tr>
</table>
<hr style="border:45px solid #CCC;">
<table width="100%">
<tr>
<td>
<table width="100%">
<tr>
<td><h2>'.$manageprofile['Company_name'].'</h2></td>
</tr>
<tr>
<td>'.$manageprofile['caddress'].'</td>
</tr>
<tr>
<td>'.$manageprofile['phonenumber'].'</td>
</tr>
<tr>
<td>'.$manageprofile['recoveryemail'].'</td>
</tr>
</table>
</td>
<td valign="top"><table width="100%">
<tr>
<td><h2>Bill To</h2></td>
</tr>
<tr>
<td>'.getcustomer('name',$supplier['customer_id']).'<br>'.getcustomer('address',$supplier['customer_id']).'<br>'.getcustomer('city',$supplier['customer_id']).'<br>'.getcustomer('state',$supplier['customer_id']).'<br>'.getcustomer('pincode',$supplier['customer_id']).'</td>
</tr>
<tr>
<td>'.getcustomer('mobileno',$supplier['customer_id']).'</td>
</tr>
</table>
</td>
<td></td>
</tr>
</table>
<hr style="border:45px solid #CCC;"> <br>
             <table border="0" cellpadding="4" cellspacing="0" width="100%">
              <tr class="tabletitle">
                <td class="item"><h4>Sno</h4></td>
                <td class="Hours"><h4>Description</h4></td>
                <td class="Hours"><h4>HSN</h4></td>
                <td class="Rate"><h4>Qty</h4></td>
                <td class="Rate"><h4>Rate</h4></td>
                  <td class="Rate"><h4>Total</h4></td>
              </tr>
</table>
<hr style="border:45px solid #CCC;"> <br>
  <table border="0" cellpadding="4" cellspacing="0" width="100%">
              ';
$sno =1;
    $tot_amnt=0;
    $object_detail = $db->prepare("SELECT * FROM `online_order_deatils` WHERE `object_id`= ?");
    $object_detail->execute(array($_REQUEST['id']));


    while ($object_detaillist = $object_detail->fetch(PDO::FETCH_ASSOC)) 
    {

    $message .= '<tr class="service">
               <td class="item" width="12%"  style="border-bottom:1px solid #CCC;"><p class="itemtext">'.$sno.'</p></td>
                <td class="Hours" width="32%"  style="border-bottom:1px solid #CCC;"><p class="itemtext">'.$object_detaillist['product_name'].'</p></td>
                 <td class="Hours" width="15%"  style="border-bottom:1px solid #CCC;"><p class="itemtext">'.$object_detaillist['hsn'].'</p></td>
                <td class="Rate" width="10%"  style="border-bottom:1px solid #CCC;"><p class="itemtext">'.$object_detaillist['qty'].'</p></td>
                <td class="Rate"  style="border-bottom:1px solid #CCC;"><p class="itemtext">Rs. '.$object_detaillist['rate'].'</p></td>
                <td class="Rate"  style="border-bottom:1px solid #CCC;"><p class="itemtext">Rs. '.$object_detaillist['total'].'</p></td>
              </tr> ';
  $tot_amnt += $object_detaillist['rate'];
$sno++;                   
                          
}

$message .= '</table>
<table width="100%">
<tr>
<td width="40%"><br>';
if($supplier['gsttype']=='1') { 
       $message .= '
      <table border="0" cellpadding="0" cellspacing="0" width="100%" align="left" style="font-size:12px;">
        <tr class="tabletitle">
                <td class="item" style="padding:10px; border-bottom:1px solid #ccc;"><h4>HSN</h4></td>
                <td class="Hours" style="padding:10px;border-bottom:1px solid #ccc;"><h4>Taxable Value</h4></td>
                 <td class="Hours" style="padding:10px;border-bottom:1px solid #ccc;"><h4>CGST %</h4></td>
                  <td class="Hours" style="padding:10px;border-bottom:1px solid #ccc;"><h4>CGST Value</h4></td>
                  <td class="Hours" style="padding:10px;border-bottom:1px solid #ccc;"><h4>SGST %</h4></td>
               <td class="Hours" style="padding:10px;border-bottom:1px solid #ccc;"><h4>SGST Value</h4></td>
               
                <td class="Rate" style="padding:10px;border-bottom:1px solid #ccc;"><h4>Tot Tax Amt</h4></td>
                 </tr>';
             $sno =1;
    $tot_amnt=0;
    $object_detail = $db->prepare("SELECT * FROM `online_order_deatils` WHERE `object_id`= ?");
    $object_detail->execute(array($_REQUEST['id']));


    while ($object_detaillist = $object_detail->fetch(PDO::FETCH_ASSOC)) 
    {
   $exname=explode('-',$object_detaillist['product_name']);
   $link1 = FETCH_all("SELECT * FROM `object` WHERE `objectname`=? ", $exname['0']);
   $taxvalue=$object_detaillist['total']*($object_detaillist['gstresult']/100);
   $indtax=$object_detaillist['gstresult']/2;
    $indamt=$taxvalue/2;
    $message .= '<tr class="tabletitle">
                <td class="item" style="padding:10px;"><h4>'.$link1['hsn'].'</h4></td>
                <td class="Hours" style="padding:10px;">'.$object_detaillist['total'].'</td>
                <td class="Hours" align="center">'.$indtax.'%
               </td> <td class="Hours" align="center">'.$indamt.'
               </td> <td class="Hours" align="center">'.$indtax.'%
               </td> <td class="Hours" align="center">'.$indamt.'
               </td>
                <td class="Rate" style="padding:10px;" align="center">'.$taxvalue.'</td>
                 </tr>';
  $tot_amnt += $object_detaillist['total'];
    $tot_tax1 += $indamt;
      $tot_tax2 += $indamt;
        $tot_tax += $indamt+$indamt;
$sno++;                   
                          
}

                 $message .='<tr class="tabletitle">
                <td class="item" style="padding:10px;"><h4>Total</h4></td>
                <td class="Hours" style="padding:10px;">'.number_format(floatval($tot_amnt),2).'</td>
                 <td class="Hours" style="padding:10px;" colspan="2" align="right">'.number_format(floatval($tot_tax1),2).'</td>
                  <td class="Hours" style="padding:10px;" colspan="2" align="right">'.number_format(floatval($tot_tax2),2).'</td>
              
                 </tr></table>';
    }

$message .='</td>
<td width="60%" valign="top">
<table width="100%" align="right">
              <tr><td>&nbsp;</td></tr>
        <tr class="tabletitle" style="font-size:16px; margin-bottom:5px;">
         <td align="right" valign="top"><strong>Sub Total </strong></td>
         <td align="right" valign="top"><strong> : Rs. </strong></td>
         <td align="right" valign="top">'.number_format(floatval($supplier['sub_tot']),2).'</td>
        </tr>';
         if($supplier['discount']!='') {
$message .= '<tr class="tabletitle" style="font-size:16px;margin-bottom:5px;">
         <td align="right" valign="top"><strong>Discount </strong></td>
         <td align="right" valign="top"><strong> : Rs. </strong></td>
         <td align="right" valign="top">'.number_format(floatval($supplier['discount']),2).'</td>
        ';
        }  
if($supplier['gsttype']=='1') { 
  $message .= '<tr class="tabletitle" style="font-size:16px;margin-bottom:5px;">
         <td align="right" valign="top"><strong>GST Value </strong></td>
         <td align="right" valign="top"><strong> : Rs. </strong></td>
         <td align="right" valign="top">'.number_format(floatval($supplier['gstvalue']),2).'</td>
        ';
}
        $message .= '<tr class="tabletitle" style="font-size:16px;margin-bottom:5px;">
         <td align="right" valign="top"><strong style="color:blue; font-size:18px;">Grand Total </strong></td>
         <td align="right" valign="top"><strong style="color:blue; font-size:18px;">   : Rs. </strong></td>
         <td align="right" valign="top"  style="color:blue; font-size:18px;">'.number_format(floatval($supplier['total_amnt']),2).'</td>
        </tr><tr><td>&nbsp;</td></tr></table>
</td>
</table>';

$message .='<p><strong>Terms & Conditions</strong><br><pre style="font-size:10px;">'.$manageprofile['terms'].'</pre></p><hr><center><strong>'.$manageprofile['footer_content'].'</strong></center>';

// echo $message;

$mpdf = new \Mpdf\Mpdf();

$mpdf->SetDisplayMode('default');
$mpdf->list_indent_first_level = 0; // 1 or 0 - whether to indent the first level of a list
$filename = "test.txt";

$file = fopen($filename, "w");
fwrite($file, $message);
$mpdf->SetTitle('Sales Order Report');
$mpdf->keep_table_proportions = false;
$mpdf->shrink_this_table_to_fit = 0;
$mpdf->SetAutoPageBreak(true, 10);
$mpdf->WriteHTML(file_get_contents($filename));
$mpdf->setAutoBottomMargin = 'stretch';
//$mpdf->setHTMLFooter('<div style="text-align:center;">THANK YOU FOR YOUR ENQUIRY</div><div style="border-top: 0.1mm solid #000000;text-align:center;padding:5px 0 5px 0;"><small>'.$address.'</samll></div>');
$mpdf->Output('yourFileName.pdf', 'I');
?>
