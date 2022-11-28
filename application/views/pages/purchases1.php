<body class="theme-cyan">
    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2 style="text-transform: uppercase;">
                    PURCHASE REQUEST MANAGEMENT
                </h2>
            </div>
            <div class="row clearfix">
                <div class="col-md-4" id="supplier">
                    <div class="card">
                        <div class="header bg-cyan" style="text-transform:uppercase;">
                            <p>SUPPLIER </p>
                        </div>
                        <div class="body table-responsive">
                            <table id="stock-supplier-table" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr style="font-size: 12px">
                                        <th>PR Number</th>
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
                <div class="col-md-8 hidden" id="stocks">
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
                                        <label>TOTAL</label>
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
                            <?php if (intval($this->session->userdata('prapprover')) === 1) { ?>
                                <button type="button" onclick="purchase1.get_selected_app()" class="btn bg-green waves-effect">Approve</button>
                                <button type="button" onclick="purchase1.get_selected_dis()" class="btn bg-red waves-effect">Disapprove</button>
                                <button type="button" onclick="purchase1.get_selected_def()" class="btn bg-blue waves-effect">Defer</button>
                            <?php } ?>
                            <table class="table table-striped table-header-rotated" id="stock-table">
                                <thead style="font-size:12px;">
                                    <tr>
                                        <th><input type="checkbox" id="check-all-stocks" class="filled-in chk-col-blue" /><label style="margin-right: -100px; margin-bottom: -10px" for="check-all-stocks"></label></th>
                                        <th class="rotate-45"><div><span>Approve</span></div></th>
                                        <th class="rotate-45"><div><span>Disapprove</span></div></th>
                                        <th class="rotate-45"><div><span>Defer</span></div></th>
                                        <th class="rotate-45"><div><span>Stock Name</span></div></th>
                                        <th class="rotate-45"><div><span>Qty</span></div></th>
                                        <th class="rotate-45"><div><span>Packing</span></div></th>
                                        <th class="rotate-45"><div><span>Unit Price</span></div></th>
                                        <th class="rotate-45"><div><span>Total</span></div></th>
                                        <th class="rotate-45"><div><span>Balance</span></div></th>
                                        <th class="rotate-45"><div><span>Note</span></div></th>
                                        <th class="rotate-45"><div><span>Ledger</span></div></th>
                                        <th class="rotate-45"><div><span>Trans Code</span></div></th>
                                        <th class="rotate-45"><div><span>PO Code</span></div></th>
                                        <th class="rotate-45"><div><span>Updated</span></div></th>
                                        <th class="rotate-45"><div><span>PO No.</span></div></th>
                                        <th class="rotate-45"><div><span>PO Series</span></div></th>
                                        <th class="rotate-45"><div><span>Code</span></div></th>
                                        <th class="rotate-45"><div><span>Control</span></div></th>
                                        <th class="rotate-45"><div><span>Approved</span></div></th>
                                        <th class="rotate-45"><div><span>Disapproved</span></div></th>
                                        <th class="rotate-45"><div><span>Deferred</span></div></th>
                                    </tr>
                                </thead>
                            </table>
                            <button type="button" onclick="purchase1.proceedtopo()" class="btn bg-blue waves-effect hidden" id="proceed_to_po">Proceed to Purchase Order <i class="material-icons">arrow_forward</i></button>
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
<?php $this->load->view('pages/modals/dispurchase'); ?>
<?php $this->load->view('pages/modals/defpurchase'); ?>
<?php $this->load->view('pages/modals/ledgerSale'); ?>
<?php $this->load->view('pages/modals/changepurqty'); ?>

<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function () {
        purchase1.supplier();
        var sidemenu = $('#purchase-req-1');
        sidemenu.removeClass().addClass('active');
        sidemenu.parents("li").removeClass().addClass('active');
    });
</script>
