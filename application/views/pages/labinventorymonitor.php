<body class="theme-cyan">
     <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2 style="text-transform: uppercase;">
                   Inventory Monitoring
                </h2>
            </div>
            <div class="row clearfix">
                 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header bg-cyan" style="text-transform:uppercase;">
                            <label >Covered Date </label>
                          
                        </div>
                        <div class="body container-fluid">
                            <form id="search-lab-inventory-form"  method="POST" >
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
                                
                            </form>
                            
                          
                            
                             <div class="col-sm-4">
                                 <button onclick="laboratory.search_inventory_monitoring()" type="button" class="btn bg-purple waves-effect">
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
                                Laboratory: Reagents Monitoring
                            </h2>
                            
                        </div>
                        <div class="body table-responsive">
                            <form id="lab-inventory-form" action="<?= base_url("user/generate_inventory_monitoring_report/laboratory") ?>" method="POST" target="_blank">
                                <input type="hidden" name="start_date" value=""/>
                                <input type="hidden" name ="beginning" value=""/>
                                <input type="hidden" name ="sales" value=""/>
                                <input type="hidden" name ="ending" value=""/>
                                <a class="reports-btn" href="javascript:void(0)" target="_blank">
                                    <button  style="height: 25px" type="button" onclick="laboratory.generate_inventory_monitoring_report()" class="btn bg-pink waves-effect">
                                        <i style="margin-top: -25px;" class="material-icons">picture_as_pdf</i>
                                    </button>
                                </a>   
                            </form>
                           <form id="total-data" >
                                <div style="margin-top: 10px" class="col-sm-12">
                                    <div class="col-sm-2">
                                        <div class="form-group form-float">
                                            <label>Total: </label>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="text" name="totalbeginning" id="totalbeginning" class="form-control" readonly="readonly" style="font-weight:bold;">
                                                <label class="form-label">BEGINNING</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="text" name="totalsales" id="totalsales" class="form-control" readonly="readonly" style="font-weight:bold;">
                                                <label class="form-label">SALES</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="text" name="totalending" id="totalending" class="form-control" readonly="readonly" style="font-weight:bold;">
                                                <label class="form-label">ENDING TOTAL</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <table id="lab-inventory-table" class="table table-bordered table-striped table-hover" style="font-size: 11px;">
                                <thead >
                               
                                    <tr >
                                   
                                        <th rowspan="2" valign="middle">PARTICULARS</th>
                                        <th rowspan="2" valign="middle">COST</th>
                                        <th colspan="2"><center>BEGINNING</center></th>
                                        <th colspan="2"><center>PURCHASES</center></th>
                                        <th colspan="2"><center>ADJUSTMENTS</center></th>
                                        <th colspan="2"><center>SALES</center></th>
                                        <th colspan="2"><center>ENDING</center></th>
                                    </tr>
                               
                                    <tr >
                                     
                                        <th><center>QUANTITY</center></th>
                                        <th><center>COST</center></th>
                                        <th><center>QUANTITY</center></th>
                                        <th><center>COST</center></th>
                                        <th><center>QUANTITY</center></th>
                                        <th><center>COST</center></th>
                                        <th><center>QUANTITY</center></th>
                                        <th><center>COST</center></th>
                                        <th><center>QUANTITY</center></th>
                                        <th><center>COST</center></th>
                               
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
<?php $this->load->view('pages/modals/inventorymonitor_group'); ?>

<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function () {
    load_inventorymonitoring_script("http://192.168.2.111:3777/drainwizv2/assets/vendors/js/responsive.js");
      var sidemenu = $('#inventory-lab-reagents');
    sidemenu.removeClass().addClass('active');
    sidemenu.parents("li").removeClass().addClass('active');
   
});
</script>














