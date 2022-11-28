<body class="theme-cyan">
     <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <ol class="breadcrumb breadcrumb-col-cyan">
                    <li><a href="javascript:void(0);">Purchases</a></li>
                    <li class="active">For Approval</li>
                </ol>
            </div>
            
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                Purchase Records &nbsp;&nbsp;<span id="purHeader">(₱ 0.00)</span>
                            </h2>
                        </div>
                        <div class="body table-responsive">
                            <?php if (intval($this->session->userdata('prapprover')) === 1) { ?>
                                <button type="button" onclick="purchase.get_selected_app()" class="btn bg-green waves-effect">Approve</button>
                                <button type="button" onclick="purchase.get_selected_dis()" class="btn bg-red waves-effect">Disapprove</button>
                                <button type="button" onclick="purchase.get_selected_def()" class="btn bg-blue waves-effect">Defer</button>
                            <?php } ?>
                             
                            <table id="purchases-table" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr style="font-size: 12px">
                                        <th><input type="checkbox" id="check-all" class="filled-in chk-col-blue" /><label style="margin-right: -100px; margin-bottom: -10px" for="check-all"></label></th>
                                        <th>Item Description</th>
                                        <th>Request Date</th>
                                        <th>Unit Cost</th>
                                        <th>Quantity</th>
                                        <th>Total Cost</th>
                                        <th>Ledger</th>
                                        <th>ctrl</th>
                                        <th></th>
                                    </tr>
                                </thead>
                            </table>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>

<?php $this->load->view('pages/modals/fetchLoader'); ?>
<?php $this->load->view('pages/modals/dispurchase'); ?>
<?php $this->load->view('pages/modals/defpurchase'); ?>
<?php $this->load->view('pages/modals/ledgerSale'); ?>
<?php $this->load->view('pages/modals/changepurqty'); ?>

<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function () {
        purchase.get_forapproval();
        var sidemenu = $('#purchase-req-1');
        sidemenu.removeClass().addClass('active');
        sidemenu.parents("li").removeClass().addClass('active');
});
</script>
