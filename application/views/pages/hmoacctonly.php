<body class="theme-cyan">
     <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2 style="text-transform: uppercase;">
                    HMO Accounts Only
                </h2>
            </div>
            <div class="row clearfix">
                 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header bg-cyan" style="text-transform:uppercase;">
                            <label style="font-size: 15px;">Covered Date </label><small> (by Discharged Date) </small>
                      
                        </div>
                        <div class="body container-fluid">
                            <form id="search-hmo-acct-form"  method="POST" >
                               <input type="hidden" name="s_date" value=""/>
                                <input type="hidden" name="e_date" value=""/>
                                <div class="col-sm-4">
                                    <div class='input-group date'>
                                        <span class="input-group-addon">
                                            <i class="material-icons date-icon" >date_range</i>
                                        </span>
                                        <div class="form-line">
                                            <input type='text' name="start_date" class="form-control" value="<?= $cur_date ?>">
                                        </div>
                                        <small style="color: red"></small>
                                        
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="input-group date">
                                        <span class="input-group-addon">
                                            <i class="material-icons date-icon">date_range</i>
                                        </span>
                                        <div class="form-line">
                                            <input type="text" name="end_date" class="form-control" value="<?= $cur_date ?>">
                                        </div>
                                         <small style="color: red"></small>
                                    </div>
                                </div>
                            </form>
                            
                          
                            
                             <div class="col-sm-4">
                                 <button onclick="hmoacct.search_hmo_acct()" type="button" class="btn bg-purple waves-effect">
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
                        <div class="header bg-cyan" style="text-transform:uppercase;">
                            <h2>
                                HMO Accounts Only
                                <div class="col-sm-4" style="float:right;">
                            <select class="form-control show-tick" data-live-search="true" id="hmolist" name="hmolist" onchange="hmoacct.search_hmo_acct()">
                                    <option value="All:All">All</option>
                                    <?php
                                        for($i=0;$i<count($hmo);$i++)
                                            {
                                                echo "<option value='".$hmo[$i]["hmorefno"].":".$hmo[$i]["hmoname"]."'>".$hmo[$i]["hmoname"]."</option>";
                                            }
                                    ?>
                                </select>
                              </div>
                            </h2>
                            
                        </div>
                        <div class="body table-responsive">
                            
                            
                           
                        <form id="hmo-acct-form" action="<?= base_url("user/generate_HMO_acct_report") ?>" method="POST" target="_blank">
                                <input type="hidden" name="start_date" value=""/>
                                <input type="hidden" name="end_date" value=""/>
                                <input type="hidden" name ="hmocodex" value=""/>
                                <input type="hidden" name ="hmonamex" value=""/>
                                <input type="hidden" name ="hospital" value=""/>
                                <input type="hidden" name ="proffee" value=""/>
                                <a class="reports-btn" href="javascript:void(0)" target="_blank">
                                    <button  style="height: 25px" type="button" onclick="hmoacct.generate_hmoacct_report()" class="btn bg-pink waves-effect">
                                        <i style="margin-top: -25px;" class="material-icons">picture_as_pdf</i>
                                    </button>
                                </a>   
                            </form>
                           <form id="total-data">
                                <div style="margin-top: 10px" class="col-sm-6">
                                    <div class="col-sm-2">
                                        <div class="form-group form-float">
                                            <label>Total: </label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="text" name="totalhosp" id="totalhosp" class="form-control" readonly="readonly" style="font-weight:bold;">
                                                <label class="form-label">Hospital</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="text" name="totalpf" id="totalpf" class="form-control" readonly="readonly" style="font-weight:bold;">
                                                <label class="form-label">Professional Fee</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <table id="hmo-acct-table" class="table table-bordered table-striped table-hover">
                                <thead >
                                    <tr style="font-size: 12px;" >
                                        <th>Casecode</th>
                                        <th><center>Type</center></th>
                                        <th><center>Name</center></th>
                                        <th><center>Discharge Date</center></th>
                                        <th><center>HMO</center></th>
                                        <th colspan="2"><center>HMO</center></th>
                                    
                                    </tr>
                                    <tr style="font-size: 12px;">
                                        <th colspan="5"></th>
                                        <th>Hospital</th>
                                        <th>Professional Fee </th>
                                   
                               
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
<?php $this->load->view('pages/modals/transmitinfo'); ?>
<?php $this->load->view('pages/modals/patientshmo'); ?>

<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function () {
    load_hmoacctonly_script("http://192.168.2.111:3777/drainwizv2/assets/vendors/js/responsive.js");
    var sidemenu = $('#hmo-ar-1');
    sidemenu.removeClass().addClass('active');
    sidemenu.parents("li").removeClass().addClass('active');
   
});
</script>











