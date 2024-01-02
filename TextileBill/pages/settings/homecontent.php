<?php
$thispageid = 3;
include ('../../config/config.inc.php');
$dynamic = '1';
$datatable2 = '1';

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
            Home Content
            <small>Manage Home Content</small>
        </h1>
        <ol class="breadcrumb">
            <li><a data-toggle="control-sidebar" href="#"><i class="fa fa-gears"></i> Settings</a></li>
            <li><a href="#"><i class="fa fa-th-large"></i> Home Content</a></li>

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
                                    <th style="text-align: left" width="25%" >Title1</th>                                  
                                    <th style="text-align: left" width="25%" >Title2</th>
                                    <th style="text-align: left" width="25%" >Title3</th>
                              
                                    <th width="10%" data-sortable="false" align="center"  style="text-align: center; padding-right:0; padding-left: 0;">Edit</th>
                                </tr>
                            </thead>
                            <?php
                            $ndepart = $db->prepare("SELECT * FROM `homecontent`");
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
                                            <td style="text-align: left"><?php echo $fdepart['title1']; ?></td>
                                            <td style="text-align: left"><?php echo $fdepart['title2']; ?></td>                                     
                                            <td style="text-align: left"><?php echo $fdepart['title3']; ?></td>                                     
                                            <td align="center" ><i class="fa fa-edit" onclick="javascript:editthis('<?php echo $fdepart['hcid']; ?>');" style="cursor:pointer;"></i></td>
                                        </tr>
                                        <?php
                                        $i++;
                                    }
                                    ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="4">&nbsp;</th>
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
        window.location.href = '<?php echo $sitename; ?>settings/' + a + '/edithomecontent.htm';
    }
</script>
<script>
    jQuery('#example1').ddTableFilter();
</script>
<?php
include ('../../require/footer.php');
?>