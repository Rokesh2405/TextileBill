<?php
include ('../../config/config.inc.php');
$ptotamount=0;
$stotamount=0;
if (isset($_REQUEST['purchase'])) {
if (isset($_REQUEST['datef'])) {
    $sdate=$_REQUEST['datef'].'-01';
    $edate=$_REQUEST['datef'].'-31';
    // echo $sdate."<br>";
    // echo $edate."<br>";
    // SELECT * FROM `purchase` WHERE date>="2019-03-01" and date<="2019-03-31" 
    $id=0;
    $sname='';
    $pquantity='';
    $amount='';
    $pamount='';
    $objid='';
    $sid='';
    $ptotquan=0;
    echo "<style>
    td{
        font-weight:600px;
    }
    </style>";
    echo "<table>
    <tr> 
    <th style='width:50px;'>S.ID</th>
    <th style='width:200px;'>supplier name</th>
    <th style='width:150px;'>PURCHASE Quantity</th>
    <th>AMOUNT</th>
    </tr>
    "; 
$purchaselist1 = pFETCH("SELECT id,supplierid,sum(amount) as totamount FROM `purchase` WHERE `date`>=? and `date`<=? GROUP BY `supplierid`",$sdate,$edate);
    while ($objectfetch1 = $purchaselist1->fetch(PDO::FETCH_ASSOC)) {
  $id++;
  $amount=$objectfetch1['totamount'];
  $ptotamount=$ptotamount+$objectfetch1['totamount'];
    $objid=$objectfetch1['id']; 
    $sid=$objectfetch1['supplierid'];
        $purchaselis1t = pFETCH("SELECT * FROM `purchase_object_detail` WHERE `object_id`=?",$objid); 
        while ($objectfetc1h = $purchaselis1t->fetch(PDO::FETCH_ASSOC)) {
        $pquantity=$pquantity+$objectfetc1h['pquantity'];
        
        }
        $ptotquan=$ptotquan+$pquantity; 
          $purchaselis1t1 = pFETCH("SELECT * FROM `supplier` WHERE `id`=?",$sid); 
        while ($objectfetc1h1 = $purchaselis1t1->fetch(PDO::FETCH_ASSOC)) {
            $sname=$objectfetc1h1['suppliername'];
        }

    echo "<tr>"; 
            echo "<td>".$id."</td>";
            echo "<td>".$sname."</td>";
            echo "<td>".$pquantity."</td>";
            echo "<td>".$amount."</td>";
            echo "</tr>";    
    
        }
     
    echo "<tr>
    <td></td>
    <td><b>Total Purchase Quantity</b></td>
    <td><b>".$ptotquan."</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Total Amount </b></td>
    
    <td><b>".$ptotamount."</b></td>
    </tr>";
    echo "</table>";

}
}
if (isset($_REQUEST['sales'])) {
if (isset($_REQUEST['datef'])) {
    $sdate=$_REQUEST['datef'].'-01';
    $edate=$_REQUEST['datef'].'-31';
    // echo $sdate."<br>";
    // echo $edate."<br>";
    // 
    $id1=0;
    $squantity='';
    $samount='';
    $stotquan=0;
    echo "<table>
    <tr> 
    <th style='width:50px;'>S.ID</th>
    <th style='width:200px;'>SALES NAME</th>
    <th style='width:150px;'>SALES Quantity</th>
    <th style='width:150px;'>AMOUNT</th>
    </tr>
    "; 
    $purchaselist1 = pFETCH("SELECT id,supplierid,sum(amount) as totamount FROM `sales` WHERE `date`>=? and `date`<=? GROUP BY `supplierid`",$sdate,$edate);
    while ($objectfetch1 = $purchaselist1->fetch(PDO::FETCH_ASSOC)) {
  $id++;
  $samount=$objectfetch1['totamount'];
  $stotamount=$stotamount+$objectfetch1['totamount'];
    $objid=$objectfetch1['id']; 
    $sname=$objectfetch1['supplierid'];
        $purchaselis1t = pFETCH("SELECT * FROM `sales_object_detail` WHERE `object_id`=?",$objid); 
        while ($objectfetc1h = $purchaselis1t->fetch(PDO::FETCH_ASSOC)) {
        $squantity=$pquantity+$objectfetc1h['squantity'];
        
        }
        $stotquan=$stotquan+$squantity; 
        

    echo "<tr>"; 
            echo "<td>".$id."</td>";
            echo "<td>".$sname."</td>";
            echo "<td>".$squantity."</td>";
            echo "<td>".$samount."</td>";
            echo "</tr>";    
    
        }
    echo "<tr>
    <td></td>
    <td><b>Total Sales Quantity</b></td>
    <td><b>".$stotquan."</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Total Amount </b></td>
    
    <td><b>".$stotamount."</b></td>
    </tr>";
    echo "</table>";

}
}
?>
<!-- 
$purchaselist = pFETCH("SELECT * FROM `purchase` WHERE `date`>=? and `date`<=?",$sdate,$edate);
    while ($objectfetch = $purchaselist->fetch(PDO::FETCH_ASSOC)) {
  
        $ptotamount=$ptotamount+$objectfetch['amount']; 
        
        $purchaselist1 = pFETCH("SELECT * FROM `purchase_object_detail` WHERE `object_id`=?",$objectfetch['id']); 
        while ($objectfetch1 = $purchaselist1->fetch(PDO::FETCH_ASSOC)) {

        $purchaselist11 = pFETCH("SELECT * FROM `silverobject` WHERE `id`=?",$objectfetch1['object']);
        
        $pquantity=$objectfetch1['pquantity']; 
        $ptotquan=$ptotquan+$objectfetch1['pquantity'];
        while ($objectfetch11 = $purchaselist11->fetch(PDO::FETCH_ASSOC)) {
                $id++;
            echo "<tr>"; 
            echo "<td>".$id."</td>";
            echo "<td>".$objectfetch11['objectname']."</td>";
            echo "<td>".$pquantity."</td>";
            echo "<td>".$amount."</td>"; 
            echo "</tr>";
        }
    
        }
        
        
    } 
    echo "<tr>
    <td></td>
    <td><b>Total Purchase Quantity</b></td>
    <td><b>".$ptotquan."</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Total Amount </b></td>
    
    <td><b>".$ptotamount."</b></td>
    </tr>";
    echo "</table>"; -->