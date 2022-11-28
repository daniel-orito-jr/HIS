<body class="theme-cyan">
    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2 style="text-transform: uppercase;">
                     Philhealth Accounts
                </h2>
            </div>
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header bg-cyan" style="text-transform:uppercase;">
                            <h2>
                                PENDING CLAIMS
                            </h2>
                        </div>
                        <div class="body table-responsive">
                            <form id="total-pending-claim-form" action="<?= base_url("user/get_pending_claims_report") ?>" method="POST" target="_blank">
                                <a class="reports-btn" href="javascript:void(0)" target="_blank">
                                    <button onclick="pendingclaims.generate_pending_claim_report()" style="height: 25px" type="button" class="btn bg-pink waves-effect">
                                        <i style="margin-top: -25px;" class="material-icons">picture_as_pdf</i>
                                    </button>
                                </a>   
                            </form>
                            <table id="pending-claims-table" class="table table-bordered table-striped table-hover">
                                <thead >
                                    <tr style="font-size: 12px">
                                        <th>Batch No </th>
                                        <th>Patient Name</th>
                                        <th>Process Date</th>
                                        <th>Claim Number</th>
                                        <th>HCI Case Number</th>
                                        <th>Age (Days)</th>
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
<?php $this->load->view('pages/modals/phicinprocess_modal'); ?>

<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function () {
//    load_transmittal_script("http://192.168.2.111:3777/drainwizv2/assets/vendors/js/responsive.js");
        var sidemenu = $('#ph-accounts-5');
        sidemenu.removeClass().addClass('active');
        sidemenu.parents("li").removeClass().addClass('active');
        pendingclaims.get_pending_claims();

    });
</script>