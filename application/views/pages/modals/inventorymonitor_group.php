<!-- Large Size -->
<div class="modal fade" id="inventorymonitor_group" tabindex="-1" role="dialog" data-backdrop="static">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-cyan">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                    <h4 class="modal-title" id="groupname" style="text-transform: uppercase;"> </h4>as of <span id="month"></span>&nbsp;<span id="year"></span>
                </div>
                <div class="modal-body">
                    
                        <div class="row clearfix" id="admission">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="card">
                                    <div class="body table-responsive">
                                        <form id="hmolist-patients-form" action="<?= base_url("user/generate_phic_report") ?>" method="POST" target="_blank" id="ph">
                                            <input type="hidden" name="s_date" id="s_date" value=""/>
                                            <input type="hidden" name="e_date" value=""/>
                                            <input type="hidden" name="search" value=""/>
                                        </form>
                                        <a class="report-btn" href="javascript:void(0)" target="_blank" >
                                            <button onclick="dashboard.get_phic_report()" style="height: 25px" type="button" class="btn bg-pink waves-effect">
                                                <i style="margin-top: -25px;" class="material-icons">picture_as_pdf</i>
                                            </button>
                                        </a>
                                      
                                       
                                       
                                        <table id="inventorymonitor-group-table" class="table table-bordered table-striped table-hover" style="font-size:11px;">
                                            <thead style="font-weight:bold;">
                                                <tr >
                                                    <td rowspan="2" valign="middle">PRODUCT</td>
                                                    <td rowspan="2" valign="middle">COST</td>
                                                    <td colspan="2"><center>BEGINNING</center></td>
                                                    <td colspan="2"><center>PURCHASES</center></td>
                                                    <td colspan="2"><center>ADJUSTMENTS</center></td>
                                                    <td colspan="2"><center>SALES</center></td>
                                                    <td colspan="2"><center>ENDING</center></td>
                                                </tr>
                                                <tr>
                                                    <td><center>QUANTITY</center></td>
                                                    <td><center>COST</center></td>
                                                    <td><center>QUANTITY</center></td>
                                                    <td><center>COST</center></td>
                                                    <td><center>QUANTITY</center></td>
                                                    <td><center>COST</center></td>
                                                    <td><center>QUANTITY</center></td>
                                                    <td><center>COST</center></td>
                                                    <td><center>QUANTITY</center></td>
                                                    <td><center>COST</center></td>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    
                        <div class="row">
                            <div class="col-xs-9 p-t-5"></div>
                           
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
