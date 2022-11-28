<body class="theme-cyan">
     <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2 style="text-transform: uppercase;">
                   Sales Monitoring
                </h2>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="header bg-cyan" style="text-transform:uppercase;">
                            <h2>
                                LABORATORY: Sales Monitoring
                            </h2>
                            
                        </div>
                        <div class="body">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs tab-nav-right" role="tablist">
                                <li role="presentation" class="active" id="home1"><a href="#home" data-toggle="tab">INVENTORY SET</a></li>
                                <li role="presentation" id="profile1"><a href="#profile">SUMMARIZED INVENTORY</a></li>
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane fade in active" id="home">
                                    <div class="body table-responsive">
                                        <form id="lab-sales-form" action="<?= base_url("user/generate_sales_monitoring_report/laboratory") ?>" method="POST" target="_blank">
                                            <a class="reports-btn" href="javascript:void(0)" target="_blank">
                                                <button  style="height: 25px" type="button" onclick="laboratorysales.generate_sales_monitoring_report()" class="btn bg-pink waves-effect">
                                                    <i style="margin-top: -25px;" class="material-icons">picture_as_pdf</i>
                                                </button>
                                            </a> 
                                        </form>
                                        <table id="lab-sales-table" class="table table-bordered table-striped table-hover" style="font-size: 11px;">
                                            <thead>
                                                <tr>
                                                    <th><center>Batch</center></th>
                                                    <th><center>Start</center></th>
                                                    <th><center>End</center></th>
                                                    <th><center>Month/Year</center></th>
                                                    <th><center>Created By</center></th>
                                                    <th><center>DONE</center></th>
                                                </tr>
                                            </thead>
                                            
                                        </table>
                                    </div>
                                </div>
                                <div role="tabpanel" class="tab-pane fade" id="profile">
                                    <b>Inventory Count for <span id="monthyear"></span></b>
                                    <div class="body table-responsive">
                                        <form id="lab-summarized-form" action="<?= base_url("user/generate_sales_summarized_report") ?>" method="POST" target="_blank">
                                            <input type="hidden" id="batch" name="batch"/>
                                            <input type="hidden" id="indate" name="indate"/>
                                            <input type="hidden" id="outdate" name="outdate"/>
                                            <a class="reports-btn" href="javascript:void(0)" target="_blank">
                                                <button  style="height: 25px" type="button" onclick="laboratorysales.generate_sales_summarized_report()" class="btn bg-pink waves-effect">
                                                    <i style="margin-top: -25px;" class="material-icons">picture_as_pdf</i>
                                                </button>
                                            </a> 
                                        </form>
                                        <table id="lab-summarized-table" class="table table-bordered table-striped table-hover" style="font-size: 11px;">
                                            <thead>
                                                <tr>
                                                    <th><center>TEST</center></th>
                                                    <th><center>TOTAL QTY</center></th>
                                                    <th><center>TOTAL AMOUNT</center></th>
                                                    <th><center>OPD QTY</center></th>
                                                    <th><center>IPD QTY</center></th>
                                                    <th><center>ADD-ON TOTAL</center></th>
                                                    <th><center>RETAIL</center></th>
                                                    <th><center>CODE</center></th>
                                                    <th><center>FORM</center></th>
                                                    <th><center>PROD ID</center></th>
                                                    <th><center>STARTDATE</center></th>
                                                    <th><center>ENDDATE</center></th>
                                                </tr>
                                            </thead>
                                            <tbody style="text-align:right;">
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                
                                
                            </div>
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
<?php $this->load->view('pages/modals/labsales_group'); ?>

<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function () {
    load_inventorymonitoring_script("http://192.168.2.111:3777/drainwizv2/assets/vendors/js/responsive.js");
      var sidemenu = $('#inventory-lab-sales');
    sidemenu.removeClass().addClass('active');
    sidemenu.parents("li").removeClass().addClass('active');
   
});
</script>














