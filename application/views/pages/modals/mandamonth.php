<!-- Large Size -->
    <div class="modal fade" id="mandamonth" tabindex="-1" role="dialog" data-backdrop="static">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header bg-green">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                    <h4 class="modal-title" id="ss">Philhealth Monthly Report</h4>
                </div>
                <div class="modal-body">
                    <form id="search-monthly-report-form"  method="POST" >
                               
                               
                               
                                    <div class='input-group datex'>
                                        <span class="input-group-addon">
                                            <i class="material-icons date-icon" >date_range</i>
                                        </span>
                                        <div class="form-line">
                                            <input type='text' name="start_date" class="form-control" value="<?= $cur_date ?>">
                                        </div>
                                        <small style="color: red"></small>
                                        
                                    </div>
                            

                            </form>
                </div>
                <div class="modal-footer bg-green">
                    <!--<button type="button" class="btn btn-link waves-effect">SAVE CHANGES</button>-->
                    <div class="col-md-12">
                            <!-- <button type="button" class="btn btn-link waves-effect" onclick="voucher.dismissdef()" >CLOSE</but -->
                            <form id="search-report-form" action="<?= base_url("user/mandatoryreport_report") ?>" method="POST" target="_blank">
                                 <input type="hidden" name="s_date" value=""/>
                                   <button type="button" onclick="mandamonthly.search_manda_report()" class="btn btn-link waves-effect">Generate Report</button>
                              <!--   <button  style="height: 25px" type="button" class="btn bg-green waves-effect">
                                       Generate Report
                                    </button> -->
                              <!--   <a class="reports-btn" href="javascript:void(0)" target="_blank">
                                   
                                </a>    -->
                          
                            </form>
                          
                        
                    </div>
                    
                    
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function () {
//        purchase.load_s("http://192.168.2.111:3777/drainwizv2/assets/vendors/js/responsive.js");
        

   
});
</script>
