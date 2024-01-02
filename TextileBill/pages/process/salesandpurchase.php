<?php
$menu = "8,8,30";
$thispageid = 10;
include ('../../config/config.inc.php');
$dynamic = '1';
$datatable = '1';
include ('../../require/header.php');

$_SESSION['driver'] = '';
if (isset($_REQUEST['delete']) || isset($_REQUEST['delete_x'])) {
    $chk = $_REQUEST['chk'];
    $chk = implode('.', $chk);
    $msg = delobject($chk);
}
?>
<script type="text/javascript" >
    function validcheck(name)
    {
        var chObj = document.getElementsByName(name);
        var result = false;
        for (var i = 0; i < chObj.length; i++) {
            if (chObj[i].checked) {
                result = true;
                break;
            }
        }
        if (!result) {
            return false;
        } else {
            return true;
        }
    }

    function checkdelete(name)
    {
        if (validcheck(name) == true)
        {
            if (confirm("Do you want to delete the Object(s)"))
            {
                return true;
            }
            else
            {
                return false;
            }
        }
        else if (validcheck(name) == false)
        {
            alert("Select the check box whom you want to delete.");
            return false;
        }
    }

</script>
<script type="text/javascript">
    function checkall(objForm) {
        len = objForm.elements.length;
        var i = 0;
        for (i = 0; i < len; i++) {
            if (objForm.elements[i].type == 'checkbox') {
                objForm.elements[i].checked = objForm.check_all.checked;
            }
        }
    }
</script>
<style type="text/css">
    .row { margin:0;}
    #normalexamples tbody tr td:nth-child(2),  tbody tr td:nth-child(6),tbody tr td:nth-child(7),tbody tr td:nth-child(8),tbody tr td:nth-child(9) {
        text-align:left;
        font-size: 19px;
    }
    #normalexamples tbody tr td:nth-child(3),  tbody tr td:nth-child(4) {
        text-align:center;
        font-size: 19px;
    }
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Silver
            <small>Sales and Purchase</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $sitename; ?>"><i class="fa fa-dashboard"></i>Dashboard</a></li>
            <li><a href="#"><i class="fa fa-asterisk"></i>Master(s)</a></li>
            <li class="active"><a href="#"><i class="fa fa-circle-o"></i>Silver Object Mgmt</a></li>            
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">List of Sales and Purchase</h3>
            </div><!-- /.box-header -->
            <div class="box-body">
                <?php echo $msg; ?>
                <form name="form1" method="post" action="">
                    <div class="table-responsive">
                        
                       <center><h2 style="text-transform: uppercase;font-weight: 600;">Silver Sales and Purchase</h2> </center>
                       <div style="margin-left: 25%;">
                        <span style="font-weight: 600;font-size: 18px;">SELECT MONTH:</span>
                           <select id="month" style="width: 120px;height: 33px;border-color: green;border-width: 2px;font-weight: bold;">
                            <option value='' style="font-weight: bold;">SELECT MONTH</option>
                            <option value='01' style="font-weight: bold;">JANAURY</option>
                            <option value='02' style="font-weight: bold;">FEBRUARY</option>
                            <option value='03' style="font-weight: bold;">MARCH</option>
                            <option value='04' style="font-weight: bold;">APRIL</option>
                            <option value='05' style="font-weight: bold;">MAY</option>
                            <option value='06' style="font-weight: bold;">JUNE</option>
                            <option value='07' style="font-weight: bold;">JULY</option>
                            <option value='08' style="font-weight: bold;">AUGUST</option>
                            <option value='09' style="font-weight: bold;">SEPTEMBER</option>
                            <option value='10' style="font-weight: bold;">OCTOBER</option>
                            <option value='11' style="font-weight: bold;">NOVEMBER</option>
                            <option value='12' style="font-weight: bold;">DECEMBER</option>
                           </select>
                            <span style="font-weight: 600;font-size: 18px;">ENTER YEAR:</span><input type="text" name="year" id="year" style="border-color: green;font-weight: bold;font-size: 20px;width: 80px;">
                           

                       </div>
                       <div class="row">
                           <div class="col-md-6" >
                               
                               <h3 style="margin-left: 30%;font-weight: 600;">PURCHASE</h3>
                               <div id="purchase" style="box-shadow: 5px 0 5px -5px #333;">
                                 
                               </div>

                           </div>

                           <div class="col-md-6">
                               <h3 style="margin-left: 40%;font-weight: 600;">SALES</h3>
                               
                               <div id="sales" style="box-shadow: -5px 0 5px -5px #333;">
                               
                               </div>
                           </div>
                       </div>
                     
                    </div>
                </form>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script type="text/javascript">
$("#year").keyup(function(){
    var month=$("#month").val();
    var year=$("#year").val();

    var datef=year+'-'+month;
    
        $.ajax({
        type: "POST",
        url: 'ajax_pagesp.php',
        data: { 'datef': datef , 'purchase':'purcha'},
        success: function(data)
        {
            // alert(data);
            $("#purchase").html(data);
        }
    });  
        $.ajax({
        type: "POST",
        url: 'ajax_pagesp.php',
        data: { 'datef': datef,'sales':'sal' },
        success: function(data)
        {
            // alert(data);
            $("#sales").html(data);
        }
    });  
      
    });    

$("#month").change(function(){
    // alert('Raja');
    var month=$("#month").val();
    var year=$("#year").val();

    var datef=year+'-'+month;
    
        $.ajax({
        type: "POST",
        url: 'ajax_pagesp.php',
        data: { 'datef': datef , 'purchase':'purcha'},
        success: function(data)
        {
            // alert(data);
            $("#purchase").html(data);
        }
    });  
        $.ajax({
        type: "POST",
        url: 'ajax_pagesp.php',
        data: { 'datef': datef,'sales':'sal' },
        success: function(data)
        {
            // alert(data);
            $("#sales").html(data);
        }
    });  
      
    });    
</script>
<?php
include ('../../require/footer.php');
?>  
