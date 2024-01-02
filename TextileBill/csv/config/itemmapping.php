
<div id="ItemMapModal" class="modal fade" role="itemmapmodal">
    <div class="modal-dialog modal-lg">
        <form name="Item_map_form" method="post">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Item Mapping</h4>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table id="normalexamples2" class="table table-bordered table-striped">
                            <thead>
                                <tr align="center">
                                    <th style="width:5%">S.No.</th>
                                    <th style="width:10%">Item Code</th>
                                    <th style="width:20%">Item Names</th>
                                    <th style="width:5%">Qty</th>
                                    <th style="width:5%">UOM</th>
                                    <th style="width:15%">Supplier</th>
                                    <th style="width:10%">Click to Map</th>
                                </tr>
                            </thead>
                            <tbody id="customFields2">

                            </tbody>                            
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="saveAutoItemMap" disabled="disabled" class="text-left btn btn-success disabled imsave">Auto Map</button>
                    <button type="submit" name="saveItemMap" disabled="disabled" class="btn btn-success disabled imsave" onclick="return checksupselc();">Save</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>
<div id="ItemMapSuppModal" class="modal fade" role="itemmapmodal">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Item Mapping - Select Supplier</h4>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table id="itemmapsupp" class="table table-bordered table-striped">
                        <thead>
                            <tr align="center">
                                <th style="width:5%">Sid</th>
                                <th style="width:20%">Company Name</th>
                                <th style="width:20%">Contact Person</th>
                                <th style="width:30%" class="no-sort">Supplier Rate</th>
                                <th style="width:10%" class="no-sort">Last Updated</th>
                                <th style="width:5%" class="no-sort">Action</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>                            
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button"class="btn btn-success" data-dismiss="modal" onclick="selectsupp()">Select</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div id="ItemRFQModal" class="modal fade" role="itemmapmodal">
    <form method="post" name="rfqform" onsubmit="return chkselcrfq();">
        <div class="modal-dialog modal-lg">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Send/Create RFQ - Select Supplier</h4>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table id="" class="table table-bordered table-striped">
                            <thead>
                                <tr align="center">
                                    <th style="width:5%">Sid</th>
                                    <th style="width:20%">Company Name</th>
                                    <th style="width:20%">Supplier Code</th>
                                    <th style="width:20%">Contact Person</th>
                                    <th style="width:2%"><input name="check_all" id="check_all1" value="1"  type="checkbox" /></th>
                                </tr>
                            </thead>
                            <tbody id="customFields3">

                            </tbody>                            
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="CreateRFQ" disabled="disabled" class="btn btn-info disabled rfqbtns">Create RFQ</button>
                    <button type="submit" name="SendRFQ" disabled="disabled" class="btn btn-success disabled rfqbtns">Send RFQ - Mail</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </form>
</div>
