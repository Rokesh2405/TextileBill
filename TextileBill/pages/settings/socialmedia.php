<?php
$thispageid = 7;
include ('../../config/config.inc.php');
$dynamic = '1';
//$datepicker = '1';
$datatable = '1';

include ('../../require/header.php');


?>

<style type="text/css">
    .row { margin:0;}
    
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Social Media 
            <small>Manage Social Media</small>
        </h1>
        <ol class="breadcrumb">
            <li><a data-toggle="control-sidebar"  href="#"><i class="fa fa-gears"></i> Settings</a></li>
            <li><a href="#"><i class="fa fa-gear"></i> Social Media</a></li>
            
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="box">
            <div class="box-header">
              
            </div>
            <div class="box-body">
                <?php echo $msg; ?>
                <form name="form1" method="post" action="">
                    <div class="table-responsive">
                        
                        <table id="normalexamples" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th style="text-align: center;" width="5%" >S.id</th>
                                    <th width="75%">Social Media </th>                                       
                                    <th style="text-align: center" width="10%"  >Status</th>
                                    <th width="10%" data-sortable="false" align="center"  style="text-align: center; padding-right:0; padding-left: 0;">Edit</th>
                                    
                                </tr>
                            </thead>
                           
                            <?php
                            $ndepart = $db->prepare("SELECT * FROM `socialmedia` where `status`='1' ");
                            $ndepart->execute();
                            if ($ndepart > 0) {
                                ?>
                                <tbody>
                                    <?php
                                    $i = '1';
                                    while ($fdepart = $ndepart->fetch()) {
                                        ?>
                                        <tr>
                                            <td style="text-align: center;"><?php echo $i; ?></td>
                                            <td style="text-align: left"><?php echo $fdepart['sname']; ?></td>
                                            <td style="text-align: center"><?php if($fdepart['status']=='1'){ echo 'Active'; } else { echo 'Inactive'; } ?></td>
                                            <td align="center" ><i class="fa fa-edit" onclick="javascript:editthis('<?php echo $fdepart['sid']; ?>');" style="cursor:pointer;"></i></td>
                                        </tr>
                                        <?php
                                        $i++;
                                    }
                                    ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="5">&nbsp;</th>
                                    </tr>
                                </tfoot>
                            <?php } ?>
                        </table>
                    </div>
                </form>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
<script type="text/javascript">
    function editthis(a)
    {
        var sid = a;
        window.location.href = '<?php echo $sitename; ?>settings/' + a + '/editsocialmedia.htm';
    }
</script>
<script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
<!--<script>
    jQuery('#example1').ddTableFilter();
</script>-->
<?php
include ('../../require/footer.php');
?>

