<body class="theme-cyan">
     <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2 style="text-transform: uppercase;">
                   AR Payment Recording
                </h2>
            </div>
            <div class="row clearfix">
                 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        
                        <div class="body container-fluid">
                            <form id="search-hmo-payment-form"  method="POST" >
                               <input type="hidden" name="s_date" value=""/>
                               
                                <div class="col-sm-4">
                                    <label>APV Date</label>
                                    <div class='input-group date'>
                                        <span class="input-group-addon">
                                            <i class="material-icons date-icon" >date_range</i>
                                        </span>
                                        <div class="form-line">
                                            <input type='text' name="start_date" class="form-control" value="<?= $cur_date ?>">
                                             <!--<input type="text" class="datepicker form-control" placeholder="Please choose a date...">-->
                                        </div>
                                        <small style="color: red"></small>
                                        
                                    </div>
                                </div>
                               <div class="col-sm-4">
                                    <label>APV Number</label>
                                    <div class='input-group'>
                                        <span class="input-group-addon">
                                            <i class="material-icons date-icon" >date_range</i>
                                        </span>
                                        <div class="form-line">
                                            <input type='text' name="txtapv" class="form-control" >
                                        </div>
                                        <small style="color: red"></small>
                                        
                                    </div>
                                </div>

                            </form>
                            
                            <div class="col-sm-4">
                                <br>
                                <button onclick="hmolist.search_hmo_list()" type="button" class="btn bg-purple waves-effect">
                                    <span>Search <i class="material-icons">search</i></span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                               AR Payment Recording
                                <!--<small>You can use different animation class. We used Animation.css which link is <a href="https://daneden.github.io/animate.css/" target="_blank">https://daneden.github.io/animate.css/</a></small>-->
                            </h2>
                        </div>

                        <div class="body table-responsive">
                            <form id="hmo-payment-form" action="<?= base_url("user/generate_daily_census_report") ?>" method="POST" target="_blank">
                                  <input type="hidden" name="s_date" value=""/>
                                <a class="reports-btn" href="javascript:void(0)" target="_blank">
                                    <button onclick="mandadaily.get_mandatory_daily_census_report()" style="height: 25px" type="button" class="btn bg-pink waves-effect">
                                        <i style="margin-top: -25px;" class="material-icons">picture_as_pdf</i>
                                    </button>
                                </a>
                            </form>
                            <br>
                            <table id="hmo-payment-table" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Px Name of Unpaid Accounts</th>
                                        <th>Acct No.</th>
                                        <th>Claimed Date</th>
                                        <th>Claimed</th>
                                        <th>HCI Claimed</th>
                                        <th>PF Claimed</th>
                                        <th>Total Claimed</th>
                                        <th>AR Aging</th>
                                        <th>Sex</th>
                                        <th>Age</th>
                                        <th>Days Claimed</th>
                                        <th>Admission</th>
                                        <th>Discharge Date</th>
                                        <th>Birthday</th>
                                        <th>Death</th>
                                        <th>Pin Code</th>
                                        <th>Case Code</th>
                                        <th>Claim Type</th>
                                        <th>Claimed Amt</th>
                                        <th>Updated</th>
                                        <th>Recorded</th>
                                        <th>Type</th>
                                        <th>Reference</th>
                                        <th>Acct Code</th>
                                        <th>Acct No.</th>
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
<?php $this->load->view('pages/modals/hmolist_patients'); ?>

<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function () {
   var sidemenu = $('#hmo-11-5');
    sidemenu.removeClass().addClass('active');
    sidemenu.parents("li").removeClass().addClass('active');
    hmolist.get_hmolist();
   // load_script("http://192.168.2.111:3777/drainwizv2/assets/vendors/js/responsive.js",3,0);
    
   // var d = new DateTime();
   //  mandadaily.get_daily_census(d);

    
});
</script>









