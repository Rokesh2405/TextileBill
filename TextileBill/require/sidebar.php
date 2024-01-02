<aside class="main-sidebar">
<section class="sidebar" onmouseover="toggleSidebar()" onmouseout="toggleSidebar()">
<ul class="sidebar-menu">
<li class="header">MAIN NAVIGATION</li>
<li class="treeview <?php echo $tree1; ?>">
<a href="<?php echo $sitename; ?>">
<i class="fa fa-dashboard"></i> <span>Dashboard</span>
</a>
</li>
<?php if ($_SESSION['UID'] == '1') { ?>
<li class="treeview-menu menu-open" id="ul_18" style="display:block;">
<a href="#">
<i class="fa fa-asterisk"></i>
<span>Masters</span>
<span class="label label-success pull-right" id="span_18">6</span>
</a>
<ul class="treeview-menu">

<li <?php echo $smenuitem11; ?> id="li_11">
<a href="<?php echo $sitename; ?>master/hotelusers.htm">
<i class="fa fa-circle-o"></i>User Mgmt 
</a>
</li>
<li <?php echo $smenuitem118; ?> id="li_118">
<a href="<?php echo $sitename; ?>master/categories.htm">
<i class="fa fa-circle-o"></i>Category Mgmt 
</a>
</li>
<li <?php echo $smenuitem119; ?> id="li_119">
<a href="<?php echo $sitename; ?>master/subcategory.htm">
<i class="fa fa-circle-o"></i>Subcategory Mgmt 
</a>
</li>

<li <?php echo $smenuitem120; ?> id="li_120">
<a href="<?php echo $sitename; ?>master/units.htm">
<i class="fa fa-circle-o"></i>Units Mgmt 
</a>
</li>
<li <?php echo $smenuitem119; ?> id="li_122">
<a href="<?php echo $sitename; ?>master/ordertype.htm">
<i class="fa fa-circle-o"></i>Order Type Mgmt 
</a>
</li>
<li <?php echo $smenuitem119; ?> id="li_123">
<a href="<?php echo $sitename; ?>master/paymentmode.htm">
<i class="fa fa-circle-o"></i>Payment Mode Mgmt 
</a>
</li>
<li <?php echo $smenuitem128; ?> id="li_128">
<a href="<?php echo $sitename; ?>pages/process/supplier.php">
<i class="fa fa-circle-o"></i>Suppliers Mgmt 
</a>
</li>
<li <?php echo $smenuitem155; ?> id="li_155">
<a href="<?php echo $sitename; ?>/master/customer.htm">
<i class="fa fa-circle-o"></i>Customers Mgmt 
</a>
</li>
<!-- <li <?php echo $smenuitem155; ?> id="li_156">
<a href="<?php echo $sitename; ?>/master/salesman.htm">
<i class="fa fa-circle-o"></i>Salesman Mgmt 
</a>
</li> -->
<li <?php echo $smenuitem10; ?> id="li_10">
<a href="<?php echo $sitename; ?>master/brands.htm">
<i class="fa fa-circle-o"></i>Brand Mgmt 
</a>
</li>
<li <?php echo $smenuitem10; ?> id="li_10">
<a href="<?php echo $sitename; ?>master/style.htm">
<i class="fa fa-circle-o"></i>Style Mgmt 
</a>
</li>
<li <?php echo $smenuitem10; ?> id="li_10">
<a href="<?php echo $sitename; ?>master/pattern.htm">
<i class="fa fa-circle-o"></i>Pattern Mgmt 
</a>
</li>
<li <?php echo $smenuitem10; ?> id="li_10">
<a href="<?php echo $sitename; ?>master/object.htm">
<i class="fa fa-circle-o"></i>Products Mgmt 
</a>
</li>
<!--<li <?php echo $smenuitem10; ?> id="li_10">
<a href="<?php echo $sitename; ?>master/beat.htm">
<i class="fa fa-circle-o"></i>Beat Mgmt 
</a>
</li>
<li <?php echo $smenuitem10; ?> id="li_10">
<a href="<?php echo $sitename; ?>master/beatsalesman.htm">
<i class="fa fa-circle-o"></i>Salesman Beat Mgmt 
</a>
</li>
 <li <?php echo $smenuitem12; ?> id="li_12">
<a href="<?php echo $sitename; ?>master/return.htm">
<i class="fa fa-circle-o"></i>Return Mgmt 
</a>
</li> -->
<!--  <li <?php echo $smenuitem21; ?> id="li_21">
<a href="<?php echo $sitename; ?>master/addreturnview.htm">
<i class="fa fa-circle-o"></i>Return View 
</a>
</li> -->
<!-- <li <?php echo $smenuitem13; ?> id="li_13">
<a href="<?php echo $sitename; ?>master/bankstatus.htm">
<i class="fa fa-circle-o"></i>Bank Status Mgmt 
</a>
</li> -->
<!--  <li <?php echo $smenuitem14; ?> id="li_14">
<a href="<?php echo $sitename; ?>master/addpawnview.htm">
<i class="fa fa-circle-o"></i>Pawn View
</a>
</li> -->
<!--                <li <?php echo $smenuitem23; ?> id="li_23">
<a href="<?php echo $sitename; ?>master/bankpawn.htm">
<i class="fa fa-circle-o"></i>Bank Pawn
</a>
</li>-->
<!--  <li <?php echo $smenuitem22; ?> id="li_22">
<a href="<?php echo $sitename; ?>master/addbankreturn.htm">
<i class="fa fa-circle-o"></i>Bank Return 
</a>
</li> -->
<!-- <li <?php echo $smenuitem23; ?> id="li_23">
<a href="<?php echo $sitename; ?>master/addbankpawn.htm">
<i class="fa fa-circle-o"></i>Bank pawn 
</a>
</li> -->
<!-- <li <?php echo $smenuitem34; ?> id="li_34">
<a href="<?php echo $sitename; ?>master/bankpawnview.htm">
<i class="fa fa-circle-o"></i>Bank pawn view
</a>
</li> -->
<!-- <li <?php echo $smenuitem35; ?> id="li_35">
<a href="<?php echo $sitename; ?>master/bankreturnview.htm">
<i class="fa fa-circle-o"></i>Bank return view 
</a>
</li> -->

</ul>
</li>
<li class="treeview <?php echo $tree3; ?>" id="ul_3">
<a href="#">
<i class="fa fa-money"></i>
<span>Sales</span>
<span class="label label-warning pull-right">3</span>
</a>
<ul class="treeview-menu">


<!--<li <?php echo $smenuitem10; ?> id="li_10">
<a href="<?php echo $sitename; ?>pages/sales/purchase.htm">
<i class="fa fa-circle-o"></i>Sales Products Purchase Mgmt
</a>
</li>-->




<!-- <li <?php echo $smenuitem28; ?> id="li_28">
<a href="<?php echo $sitename; ?>pages/process/storeorder.php">
<i class="fa fa-circle-o"></i>Store Order 
</a>
</li>-->
<!-- <li <?php echo $smenuitem44; ?> id="li_44">
<a href="<?php echo $sitename; ?>/bill/create_invoice.php">
<i class="fa fa-circle-o"></i>Stock Details
</a>
</li>
-->
<li <?php echo $smenuitem44; ?> id="li_44">
<a href="<?php echo $sitename; ?>pages/process/addsales.php">
<i class="fa fa-circle-o"></i>Sales
</a>
</li>
<!-- <li <?php echo $smenuitem45; ?> id="li_45">
<a href="<?php echo $sitename; ?>pages/process/sales_order.php">
<i class="fa fa-circle-o"></i>Sales
</a>
</li> -->
<li <?php echo $smenuitem46; ?> id="li_46">
<a href="<?php echo $sitename; ?>pages/process/addsales_return.php">
<i class="fa fa-circle-o"></i>Sales Return
</a>
</li>

</ul>
</li>
<li class="treeview <?php echo $tree46; ?>" id="ul_46">
<a href="#">
<i class="fa fa-money"></i>
<span>Purchase</span>
<span class="label label-warning pull-right" id="span_4">4</span>
</a>
<ul class="treeview-menu   menu-open">
	<li <?php echo $smenuitem3; ?> id="li_3">
<a href="<?php echo $sitename; ?>process/addpurchase.htm">
<i class="fa fa-circle-o"></i>Purchase
</a>
</li>
<li <?php echo $smenuitem1; ?> id="li_1">
<a href="<?php echo $sitename; ?>process/addpurchase_order.htm">
<i class="fa fa-circle-o"></i>Purchase Order
</a>
</li>
<li <?php echo $smenuitem2; ?> id="li_2">
<a href="<?php echo $sitename; ?>process/addpurchase_return.htm">
<i class="fa fa-circle-o"></i>Purchase Return
</a>
</li>



</ul>
</li>
<li class="treeview <?php echo $tree4; ?>" id="ul_4">
<a href="#">
<i class="fa fa-money"></i>
<span>Expense</span>
<span class="label label-warning pull-right" id="span_4">4</span>
</a>
<ul class="treeview-menu">
<li <?php echo $smenuitem144; ?> id="li_144">
<a href="<?php echo $sitename; ?>master/expense_type.htm">
<i class="fa fa-circle-o"></i>Create Type 
</a>
</li>
<li <?php echo $smenuitem228; ?> id="li_228">
<a href="<?php echo $sitename; ?>master/adddaily_expense.htm">
<i class="fa fa-circle-o"></i>Daily Expense 
</a>
</li>



</ul>
</li>

<li class="treeview <?php echo $tree5; ?>" id="ul_5">
<a href="#">
<i class="fa fa-money"></i>
<span>Inventory</span>
<span class="label label-warning pull-right" id="span_5">1</span>
</a>
<ul class="treeview-menu">
<!--  <li <?php echo $smenuitem2; ?> id="li_2">
<a href="<?php echo $sitename; ?>pages/master/object1.php">
<i class="fa fa-circle-o"></i>Stock Products
</a>
</li> -->
<!-- <li <?php echo $smenuitem111; ?> id="li_111">
<a href="<?php echo $sitename; ?>pages/process/purchase.php">
<i class="fa fa-circle-o"></i>Purchase 
</a>
</li> -->
<!-- <li <?php echo $smenuitem218; ?> id="li_218">
<a href="<?php echo $sitename; ?>pages/process/stock_usage.php">
<i class="fa fa-circle-o"></i>Stock Usage
</a>
</li> -->
<li <?php echo $smenuitem219; ?> id="li_219">
<a href="<?php echo $sitename; ?>pages/process/stock_details.php">
<i class="fa fa-circle-o"></i>Stock Details
</a>
</li>
<!-- <li <?php echo $smenuitem21; ?> id="li_21">
<a href="<?php echo $sitename; ?>pages/master/object1.php">
<i class="fa fa-circle-o"></i>Current Stock
</a>
</li>
<li <?php echo $smenuitem22; ?> id="li_22">
<a href="<?php echo $sitename; ?>pages/master/object1.php">
<i class="fa fa-circle-o"></i>Return Stock
</a>
</li> -->




</ul>
</li>
<li class="treeview <?php echo $tree11; ?>" id="ul_11">
<a href="#">
<i class="fa fa-money"></i>
<span>Payment</span>
<span class="label label-warning pull-right" id="span_11">4</span>
</a>
<ul class="treeview-menu   menu-open">
<li <?php echo $smenuitem1; ?> id="li_1">
<a href="<?php echo $sitename; ?>pages/process/credit_payment.php">
<i class="fa fa-circle-o"></i>Payment Details
</a>
</li>

<li <?php echo $smenuitem2; ?> id="li_2">
<a href="<?php echo $sitename; ?>pages/process/receipt_payment.php">
<i class="fa fa-circle-o"></i>Receipt Details
</a>
</li>
</ul>
</li>
<li class="treeview <?php echo $tree31; ?>" id="ul_31">
<a href="#">
<i class="fa fa-money"></i>
<span>Barcode Print</span>
<span class="label label-warning pull-right" id="span_31">1</span>
</a>
<ul class="treeview-menu">
<li <?php echo $smenuitem28; ?> id="li_28">
<a href="<?php echo $sitename; ?>pages/process/barcode_print.php">
<i class="fa fa-circle-o"></i>Barcode Print
</a>
</li>
</ul>
</li>

<li class="treeview <?php echo $tree31; ?>" id="ul_31">
<a href="#">
<i class="fa fa-money"></i>
<span>Reports</span>
<span class="label label-warning pull-right" id="span_31">4</span>
</a>
<ul class="treeview-menu">
<li <?php echo $smenuitem28; ?> id="li_28">
<a href="<?php echo $sitename; ?>pages/process/sales_report.php">
<i class="fa fa-circle-o"></i>Sales Reports 
</a>
</li>
<li <?php echo $smenuitem4114; ?> id="li_4114">
<a href="<?php echo $sitename; ?>pages/process/stock_report.php">
<i class="fa fa-circle-o"></i>Stock Reports
</a>
</li>
<li <?php echo $smenuitem26; ?> id="li_26">
<a href="<?php echo $sitename; ?>pages/process/purchase_report.php">
<i class="fa fa-circle-o"></i>Purchase Reports 
</a>
</li>
<li <?php echo $smenuitem28; ?> id="li_28">
<a href="<?php echo $sitename; ?>pages/process/payment_report.php">
<i class="fa fa-circle-o"></i>Payment Reports
</a>
</li>
<li <?php echo $smenuitem27; ?> id="li_27">
<a href="<?php echo $sitename; ?>pages/process/expense_report.php">
<i class="fa fa-circle-o"></i>Expense Reports 
</a>
</li>

<li <?php echo $smenuitem27; ?> id="li_28">
<a href="<?php echo $sitename; ?>pages/process/expense_report.php">
<i class="fa fa-circle-o"></i>Sales Return Reports 
</a>
</li>
<li <?php echo $smenuitem27; ?> id="li_29">
<a href="<?php echo $sitename; ?>pages/process/expense_report.php">
<i class="fa fa-circle-o"></i>Purchase Return Reports 
</a>
</li>
<!-- <li <?php echo $smenuitem27; ?> id="li_30">
<a href="<?php echo $sitename; ?>pages/process/expense_report.php">
<i class="fa fa-circle-o"></i>Outstanding Reports 
</a>
</li> -->
<!-- <li <?php echo $smenuitem27; ?> id="li_31">
<a href="<?php echo $sitename; ?>pages/process/beatwise_report.php">
<i class="fa fa-circle-o"></i>Beat Wise Reports 
</a>
</li> -->

</ul>
</li>
<li class="treeview <?php echo $tree4; ?>" id="ul_41">
<a href="#">
<i class="fa fa-money"></i>
<span>Settings</span>
<span class="label label-warning pull-right" id="span_41">1</span>
</a>
<ul class="treeview-menu">
<li <?php echo $smenuitem1441; ?> id="li_1441">
<a href="<?php echo $sitename; ?>master/salesprint_settings.htm">
<i class="fa fa-circle-o"></i>Sales Print Settings
</a>
</li>
<li <?php echo $smenuitem1441; ?> id="li_1441">
<a href="<?php echo $sitename; ?>master/gst.htm">
<i class="fa fa-circle-o"></i>GST
</a>
</li>
<li <?php echo $smenuitem1441; ?> id="li_1442">
<a href="<?php echo $sitename; ?>master/barcode_settings.htm">
<i class="fa fa-circle-o"></i>Barcode Print Settings
</a>
</li>
</ul>
</li>

<?php } else { ?>
<li class="treeview <?php echo $tree1; ?>">
<a href="<?php echo $sitename; ?>pages/process/addsales.php">
<i class="fa fa-money"></i> <span>Sales Order</span>
</a>
</li> 
<li class="treeview <?php echo $tree1; ?>">
<a href="<?php echo $sitename; ?>pages/process/receipt_payment.php">
<i class="fa fa-money"></i> <span>Receipt Details</span>
</a>
</li> 
<li class="treeview <?php echo $tree1; ?>">
<a href="<?php echo $sitename; ?>pages/process/stock_report.php">
<i class="fa fa-money"></i> <span>Stock Report</span>
</a>
</li> 
<li class="treeview <?php echo $tree1; ?>">
<a href="<?php echo $sitename; ?>pages/process/sales_report.php">
<i class="fa fa-money"></i> <span>Sales Report</span>
</a>
</li> 
<li <?php echo $smenuitem27; ?> id="li_31">
<a href="<?php echo $sitename; ?>pages/process/beatwise_report.php">
<i class="fa fa-circle-o"></i>Beat Wise Reports 
</a>
</li>
<li class="treeview <?php echo $tree1; ?>">
<a href="<?php echo $sitename; ?>logout.php">
<i class="fa fa-lock"></i> <span>Logout</span>
</a>
</li> 
<?php } ?>


</ul>
</section>
<!-- /.sidebar -->
</aside>
