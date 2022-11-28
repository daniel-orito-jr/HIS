<body class="theme-cyan">
     <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2 style="text-transform: uppercase;">
                    PURCHASES
                </h2>
            </div>
            <div class="row clearfix">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="header bg-orange">
                            <div class="row clearfix">
                                <div class="col-xs-12 col-sm-6 ">
                                    <h2>Purchase Records: Deferred</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row clearfix">
                <div class="col-md-4">
                    <div class="card">
                        <div class="header bg-cyan" >
                            <h2 style="color:white;text-transform:uppercase;">SUPPLIER</h2>
                        </div>
                        <div class="body table-responsive">
                            
                            <table id="deferred-supplier-table" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr style="font-size: 12px">
                                        <th>PO Number</th>
                                        <th>Supplier</th>
                                        <th>PO Amount</th>
                                        <th>PO Date</th>
                                        <th>Terms</th>
                                        <th>Checked</th>
                                        <th>Noted</th>
                                        <th>Recommend</th>
                                        <th>Updated</th>
                                        <th>PO No.</th>
                                        <th>Department</th>
                                        <th>Approved</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- Task Info -->
                <div class="col-md-8">
                    <div class="card">
                        <div class="header">
                            <div class="row clearfix">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>SUPPLIER</label>
                                        <div class="form-line">
                                            <input type="text" class="form-control" id="supname" style="color:green;"  readonly/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row clearfix">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>TOTAL AMOUNT:</label>
                                        <div class="form-line">
                                            <b><input type="text" class="form-control text-success" style="color:green;" id="stockHeader" readonly/></b>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>PR Date</label>
                                        <div class="form-line">
                                            <input type="text" class="form-control text-success" style="color:green;"  id="prdate" readonly/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>P.R. Number</label>
                                        <div class="form-line">
                                            <input type="text" class="form-control text-success" style="color:green;" id="prnumber" readonly/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Department</label>
                                        <div class="form-line">
                                            <input type="text" class="form-control text-success" style="color:green;" id="dept" readonly/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="body table-responsive">
                            
                            <table id="deferred-stock-table" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr style="font-size: 12px">
                                        
                                        <!--<th><input type="checkbox" id="check-all-stocks" class="filled-in chk-col-blue" /><label style="margin-right: -100px; margin-bottom: -10px" for="check-all-stocks"></label></th>-->
                                        <th>Stock Name</th>
                                        <th>Qty</th>
                                        <th>Packing</th>
                                        <th>Unit Price</th>
                                        <th>Total</th>
                                        <th>Balance</th>
                                        <th>Note</th>
                                        <th>Trans Code</th>
                                        <th>PO Code</th>
                                        <th>Updated</th>
                                        <th>PO No.</th>
                                        <th>PO Series</th>
                                        <th>Code</th>
                                        <th>Control</th>
                                        
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>   
        </div>
    </section>
    <footer style="margin-bottom: 10px;">
         <div>
             <center>Powered by <img src="<?= base_url('assets/img/logo.png'); ?>" width="15" height="15"/> <a href="https://www.mydrainwiz.com/">DRAiNWIZ</a>.</center>
         </div>
         <div class="clearfix"></div>
     </footer>
</body>

<?php $this->load->view('pages/modals/fetchLoader'); ?>

<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function () {
        deferred1.get_deferred1();
        var sidemenu = $('#purchase-req-4');
        sidemenu.removeClass().addClass('active');
        sidemenu.parents("li").removeClass().addClass('active');
});
</script>
