<body class="theme-cyan">
     <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2 style="text-transform: uppercase;">
                    Cheque Monitoring
                </h2>
            </div>
            
             <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        
                            <div class="header bg-cyan" style="text-transform:uppercase;">
                                <h2>
                                    Cheque Monitoring &nbsp;&nbsp;<span id="chequeAmts" class="hidden"></span>
                                <!--<small>You can use different animation class. We used Animation.css which link is <a href="https://daneden.github.io/animate.css/" target="_blank">https://daneden.github.io/animate.css/</a></small>-->
                                </h2>
                            </div>
                       
                         
                        <div class="body table-responsive">
                                            
                            <table id="cheque-monitor-table" class="table table-bordered table-striped table-hover hidden" >
                                <thead>
                                    <tr >
                                        
                                        <th>Payee</th>
                                        <th>Amount</th>
                                        <th>Check Date</th>
                                        <th>Explanation</th>
                                        <th>Date</th>
                                        <th>TICKETREF</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            
            
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header bg-cyan" style="text-transform:uppercase;">
                            <h2>
                                Ongoing Transaction as of Date&nbsp;&nbsp;<span id="chequeAmt"></span>
                                <!--<small>You can use different animation class. We used Animation.css which link is <a href="https://daneden.github.io/animate.css/" target="_blank">https://daneden.github.io/animate.css/</a></small>-->
                            </h2>
                        </div>
                        <div class="body table-responsive">

                            <table id="cheque-monitoring-table" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr >
                                        <!--<th><input type="checkbox" id="check-all" class="filled-in chk-col-blue" /><label style="margin-right: -100px; margin-bottom: -10px" for="check-all"></label></th>-->
                                        <th>Payee</th>
                                        <th>Amount</th>
                                        <th>Check Date</th>
                                        <th>Explanation</th>
                                        <th>Date</th>
                                        <th>TICKETREF</th>
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
<?php $this->load->view('pages/modals/monitorticket'); ?>
 

<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function () {

        monitor.get_chequemonitor();
        monitor.get_all_cheque();
        
       var sidemenu = $('#voucher-2');
        sidemenu.removeClass().addClass('active');
        sidemenu.parents("li").removeClass().addClass('active');

    
   
});
</script>
