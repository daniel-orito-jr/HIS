<body class="theme-cyan">
    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2 style="text-transform: uppercase;">
                    Fix Asset Monitoring
                </h2>
            </div>
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header bg-cyan" style="text-transform:uppercase;">
                            <h2>
                                Assets 
                            </h2>
                        </div>
                        <div class="body table-responsive">
                            <form id="assets-form" action="<?= base_url("user/generate_assets_report") ?>" method="POST" target="_blank">
                                <input type="hidden" name="search" value=""/>
                            </form>
                            <a class="report-btn" href="javascript:void(0)" target="_blank">
                                <button onclick="fixasset.get_assets_report()" style="height: 25px" type="button" class="btn bg-pink waves-effect">
                                    <i style="margin-top: -25px;" class="material-icons">picture_as_pdf</i>
                                </button>
                            </a>
                            <!--<a class="report-btn" href="javascript:void(0)" target="_blank"><button onclick="user.get_doc_report()">Preview Pdf</button></a>-->
                            <table id="assets-table" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr style="font-size: 12px">
                                        <th>ID</th>
                                        <th>Category</th>
                                        <th>Type</th>
                                        <th>Department</th>
                                        <th>Manufacturer</th>
                                        <th>Supplier</th>
                                        <th>Quantity</th>
                                        <th>Purchase Date</th>
                                        <th>Status</th>
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
<?php $this->load->view('pages/modals/assetinfo'); ?>

<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function () {
//    load_transmittal_script("http://192.168.2.111:3777/drainwizv2/assets/vendors/js/responsive.js");
        var sidemenu = $('#asset-1');
        sidemenu.removeClass().addClass('active');
        sidemenu.parents("li").removeClass().addClass('active');
//    historylog.get_history_log();

        load_fixasset_script("http://192.168.2.111:3777/drainwizv2/assets/vendors/js/responsive.js", 0, 3);
    });
</script>