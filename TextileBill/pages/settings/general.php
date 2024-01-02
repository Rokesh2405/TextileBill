<?php
//$menu="2,3";
$thispageid = 2;
include ('../../config/config.inc.php');
$dynamic = '1';
include ('../../require/header.php');
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

</script>
<style type="text/css">
    .row { margin:0;}
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            General Settings
            <small>Manage General Settings</small>
        </h1>
        <ol class="breadcrumb">
            <li><a data-toggle="control-sidebar" href="#"><i class="fa fa-gears"></i> Settings</a></li>
            <li><a href="#"><i class="fa fa-gear"></i> General Settings</a></li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">

        <div class="box">

            <div class="box-body">
                <?php echo $msg; ?>
                <form name="form1" method="post" action="">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th style="text-align: left" width="5%"> Id</th>
                                    <th style="text-align: left" width="40%" >Home Content1</th>
                                    <th style="text-align: left" width="45%" >Home Content2</th>
                                    <th width="10%" data-sortable="false" align="center"  style="text-align: center; padding-right:0; padding-left: 0;">Edit</th>
                                </tr>
                            </thead>
                            <?php
                            $ndepart = $db->prepare("SELECT * FROM `generalsettings` ");
                            $ndepart->execute();
                            if ($ndepart > 0) {
                                ?>
                                <tbody>
                                    <?php
                                    $i = '1';
                                    while ($fdepart = $ndepart->fetch()) {
                                        ?>
                                        <tr>
                                            <td style="text-align: left"><?php echo $i; ?></td>
                                            <td style="text-align: left"><?php echo $fdepart['homecontent1']; ?></td>
                                            <td style="text-align: left"><?php echo $fdepart['homecontent2']; ?></td>
                                            <td align="center" ><i class="fa fa-edit" onclick="javascript:editthis('<?php echo $fdepart['generalid']; ?>');" style="cursor:pointer;"> Edit</i></td>
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
        window.location.href = '<?php echo $sitename; ?>settings/' + a + '/editgeneral.htm';
    }
</script>
<script>
    jQuery('#example1').ddTableFilter();
</script>
<?php
include ('../../require/footer.php');
?>