<!-- Large Size -->
<div class="modal fade" id="labsales_group" tabindex="-1" role="dialog" data-backdrop="static">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-cyan">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                    <h4 class="modal-title" id="groupname" style="text-transform: uppercase;"> </h4>as of <span id="datexx"></span>
                </div>
                <div class="modal-body">
                    
                        <div class="row clearfix" id="admission">
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="body table-responsive">
                                        <form id="lab-sales-group-form" action="<?= base_url("user/generate_lab_sales_detailed_group_report") ?>" method="POST" target="_blank" id="ph">
                                            <input type="hidden" name="prodid"     id="prodid" value=""/>
                                            <input type="hidden" name="startdate"  id="startdate" value=""/>
                                            <input type="hidden" name="enddate"    id="enddate" value=""/>
                                            <input type="hidden" name="groupnamex" id="groupnamex" value=""/>
                                        </form>
                                        <a class="report-btn" href="javascript:void(0)" target="_blank" >
                                            <button onclick="laboratorysales.generate_sales_lab_group_report()" style="height: 25px" type="button" class="btn bg-pink waves-effect">
                                                <i style="margin-top: -25px;" class="material-icons">picture_as_pdf</i>
                                            </button>
                                        </a>
                                        
                                        <table id="lab-sales-group-table" class="table table-bordered table-striped table-hover" style="font-size:11px;">
                                            <thead style="font-weight:bold;">
                                                <tr>
                                                    <th><center>Patient Name</center></th>
                                                    <th><center>Transaction</center></th>
                                                    <th><center>Add-on</center></th>
                                                    <th><center>Total Amt</center></th>
                                                    <th><center>Type</center></th>
                                                    <th><center>Trans. D/T</center></th>
                                                    <th><center>Req. No.</center></th>
                                                    <th><center>Report No.</center></th>
                                                    <th><center>Trans. No.</center></th>
                                                    <th><center>Status</center></th>
                                                    <th><center>Med. Tech.</center></th>
                                                    <th><center>Requested by</center></th>
                                                    <th><center>Recorded by</center></th>
                                                    <th><center>Prod ID</center></th>
                                        
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                   
                    
                </div>
                
                <div class="modal-footer bg-cyan">
                    
                    <!--<button type="button" class="btn btn-link waves-effect">SAVE CHANGES</button>-->
                    <div class="col-md-12">
                           <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                    </div>
                    
                    
                </div>
            </div>
        </div>
    </div>
<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function () {
});
</script>
