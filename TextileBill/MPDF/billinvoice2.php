<?php
require_once 'vendor/autoload.php'; 
include ('../config/config.inc.php');

$supplier = FETCH_all("SELECT * FROM `online_order` WHERE `id`=?", $_REQUEST['id']);
$manageprofile = FETCH_all("SELECT * FROM `manageprofile` WHERE `pid`=?", 1);

$message = '
<table width="100%" border="0" cellpadding="0" cellspacing="0">
<tr>
<td align="center"><h2>Tax Invoice</h2></td>

</tr>
</table>

<table width="100%" style="font-size:12px;">
<tr>
<td valign="top" width="30%"> 
<p><strong>From</strong></p>
<p><strong>'.$manageprofile['Company_name'].'</strong></p>
<p>'.$manageprofile['caddress'].'</p>
<p>Ph:'.$manageprofile['phonenumber'].'</p>
<p>GSTIN No: 33BAEP318H1ZL</p>
<p>FSSAINO: 12421012003363</p>
<p>GST State: TAMIL NADU

</td>';
if($supplier['customer_id']=='') { 
$message.='<td valign="top" width="30%">
<p><strong>To</strong></p>
<p><strong>'.$manageprofile['Company_name'].'<strong></p>
<p>'.$manageprofile['caddress'].'</p>
<p>Ph: '.$manageprofile['phonenumber'].'</p>
<p>GSTIN No: 33BAEP318H1ZL</p>
<p>FSSAINO: 12421012003363</p>
<p>GST State: TAMIL NADU
</td>';
} else {
$message.='<td valign="top" width="30%"><p><strong>To</strong></p>
<p><strong>Shipping Address</strong><br>'.getcustomer('name',$supplier['customer_id']).'<br>'.getcustomer('address',$supplier['customer_id']).'<br>'.getcustomer('city',$supplier['customer_id']).'<br>'.getcustomer('state',$supplier['customer_id']).'<p>GSTIN No: 33BAEP318H1ZL</p>
<p>FSSAINO: 12421012003363</p>
<p>GST State: TAMIL NADU</td>';
 } 
$message.='<td valign="top" width="40%">
<table width="100%">
<tr>
<td>Inv No</td>
<td> : </td>
<td>NIOCR'.$supplier['bill_number'].'</td>
</tr>
<tr>
<td>Date</td>
<td> : </td>
<td>'.date('d/m/Y',strtotime($supplier['date'])).'</td>
</tr>
<tr>
<td>SM Name</td>
<td> : </td>
<td>'.getsalesman('name',$supplier['salesman']).'</td>
</tr>
<tr>
<td>Area Name</td>
<td> : </td>
<td>'.getcustomer('city',$supplier['customer_id']).'</td>
</tr>
<tr>
<td>Cust Phone No</td>
<td> : </td>
<td>'.getcustomer('mobileno',$supplier['customer_id']).'</td>
</tr>
<tr>
<td>Shipping Date</td>
<td> : </td>
<td>'.date('d/m/Y').'</td>
</tr>
<tr>
<td>Place Of Supply</td>
<td> : </td>
<td>'.getcustomer('state',$supplier['customer_id']).'</td>
</tr>
</table>
</td>
</tr>
</table>

<hr style="border:5px solid #CCC; padding:0px; margin:0px;">
             <table border="0" cellpadding="0" cellspacing="0" width="100%" style="font-size:12px;">
              <tr>
                <td width="8%"><h4>Sno</h4></td>
                <td width="15%"><h4>HSN Code</h4></td>
                <td width="22%"><h4>Description</h4></td>
                <td width="10%"><h4>Qty</h4></td>
                <td width="12%"><h4>Rate</h4></td>
                <td width="20%"><h4>Taxable Value</h4></td>
                  <td width="15%"><h4>Amount</h4></td>
              </tr>
</table>
<hr style="border:5px solid #CCC; padding:0px; margin:0px;">
  <table border="0" cellpadding="0" cellspacing="0" width="100%" style="font-size:13px;">
   ';
$sno =1;
    $tot_amnt=0;
    $object_detail = $db->prepare("SELECT * FROM `online_order_deatils` WHERE `object_id`= ?");
    $object_detail->execute(array($_REQUEST['id']));


    while ($object_detaillist = $object_detail->fetch(PDO::FETCH_ASSOC)) 
    {
    $gstvalue=$object_detaillist['total']*($object_detaillist['gstresult']/100);
$totqty+=$object_detaillist['qty'];
$totrate+=$object_detaillist['rate'];
$tottax+=$gstvalue;
$totamt+=$object_detaillist['total'];

    $message .= '<tr class="service">
               <td class="item" width="8%"  style="border-bottom:1px solid #CCC;"><p class="itemtext">'.$sno.'</p></td>
               <td class="Hours" width="15%"  style="border-bottom:1px solid #CCC;"><p class="itemtext">'.$object_detaillist['hsn'].'</p></td>
                <td class="Hours" width="22%"  style="border-bottom:1px solid #CCC;"><p class="itemtext">'.$object_detaillist['product_name'].'</p></td>
                 
                <td class="Rate" width="10%"  style="border-bottom:1px solid #CCC;"><p class="itemtext">'.$object_detaillist['qty'].'</p></td>
                <td class="Rate"  width="15%" style="border-bottom:1px solid #CCC;"><p class="itemtext">Rs. '.number_format(floatval($object_detaillist['rate']),2).'</p></td>
                 <td class="Rate"   width="20%" style="border-bottom:1px solid #CCC;"><p class="itemtext">Rs. '.$gstvalue.'</p></td>
                <td class="Rate"  width="15%" style="border-bottom:1px solid #CCC;"><p class="itemtext">Rs. '.number_format(floatval($object_detaillist['total']),2).'</p></td>
              </tr> ';
  $tot_amnt += $object_detaillist['rate'];
$sno++;                   
                          
}

$message .= '
<tr>
<td colspan="3" align="right">Total</td>
<td>'.$totqty.'</td>
<td>Rs.'.number_format(floatval($totrate),2).'</td>
<td>Rs.'.$tottax.'</td>
<td>Rs.'.number_format(floatval($totamt),2).'</td>
</tr>
</table>
<hr style="border:45px solid #CCC; padding:0px; margin:0px;">
<table width="100%"  style="font-size:12px;">
<tr>
<td width="10%">&nbsp;</td>
<td width="90%" valign="top" align="right">
<table width="100%" align="right">
              <tr>
         <td align="right" valign="top">Gross Taxable Amount</td>
         <td align="right" valign="top"> : Rs. </td>
         <td align="right" valign="top">'.number_format(floatval($tottax),2).'</td>
        </tr>
        <tr>
         <td align="right" valign="top">Invoice Value</td>
         <td align="right" valign="top">: Rs. </td>
         <td align="right" valign="top">'.number_format(floatval($supplier['sub_tot']),2).'</td>
        </tr>';
         if($supplier['discount']!='') {
$message .= '<tr class="tabletitle" style="font-size:12px;margin-bottom:5px;">
         <td align="right" valign="top">Disc Amt(-)</td>
         <td align="right" valign="top">: Rs. </td>
         <td align="right" valign="top">'.number_format(floatval($supplier['discount']),2).'</td>
        ';
        }  

        $message .= '<tr>
         <td align="right" valign="top"><strong>Net Amount For TCS</strong></td>
         <td align="right" valign="top"><strong>   : Rs. </strong></td>
         <td align="right" valign="top"><strong>'.number_format(floatval($supplier['total_amnt']),2).'</strong></td>
        </tr><tr>
         <td align="right" valign="top"><strong>Round Off</strong></td>
         <td align="right" valign="top"><strong>   : Rs. </strong></td>
         <td align="right" valign="top"><strong>'.number_format(floatval($supplier['total_amnt']),2).'</strong></td>
        </tr><tr>
         <td align="right" valign="top"><strong>Net Payable</strong></td>
         <td align="right" valign="top"><strong>   : Rs. </strong></td>
         <td align="right" valign="top"><strong>'.number_format(floatval($supplier['total_amnt']),2).'</strong></td>
        </tr></table>
</td></tr>
</table>
';

//$message .='<p><strong>Terms & Conditions</strong><br><pre style="font-size:10px;">'.$manageprofile['terms'].'</pre></p><hr><center><strong>'.$manageprofile['footer_content'].'</strong></center>';

// echo $message;

//$mpdf = new mPDF();
//$mpdf=new mPDF('utf-8', 'A4', 0, '', 0, 0, 0, 0, 0, 'L');
// $mpdf=new mPDF('c', 'A5-L', 0, '', 5, 5, 0, 0, 0);
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
// $mpdf->setHTMLFooter('<table width="100%" style="font-size:12px;">
//     <tr>
//     <td colspan="2"><hr></td>
//     </tr>
// <tr>
// <td valign="top">
// <p>In Words : '.ucfirst(getIndianCurrency($supplier['total_amnt'])).'</p>
// <p>Declaration: </p>
// <p><strong>(E & O.E)</strong></p>
// </td>
// <td align="right" valign="top"><strong>For : SRI AGENCY - MADURAI</strong></td>
// </tr>
// </table>');
$mpdf->Output('yourFileName.pdf', 'I');
?>
