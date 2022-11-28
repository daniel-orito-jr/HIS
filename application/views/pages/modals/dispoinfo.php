<!-- Large Size -->
    <div class="modal fade" id="dispoinfo" tabindex="-1" role="dialog" data-backdrop="static">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-cyan">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                    <h4 class="modal-title" id="dispo" style="text-transform: uppercase;"></h4>
                </div>
                <div class="modal-body">
                    <form id="dispo-info-form"><br>
                        <input type="hidden" name="control" value="">
                       </form>
                        
                        <div class="row clearfix">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="card">
                                    <div class="body table-responsive">
                                         <form id="disposition-info-form" action="<?= base_url("user/generate_dispo_info_report") ?>" method="POST" target="_blank" >
                                            <input type="hidden" name="datex" id="datex" value=""/>
                                            <input type="hidden" name="e_date" id="e_date" value=""/>
                                            <input type="hidden" name="disposition" id="classification" value=""/>
                                            <input type="hidden" name="dokie" id="dokie" value=""/>
                                            <input type="hidden" name="dokiename" id="dokiename" value=""/>
                                        </form>
                                        <a class="report-dispo-info" href="javascript:void(0)" target="_blank" >
                                            <button onclick="user.generate_dispo_info_report()" style="height: 25px" type="button" class="btn bg-pink waves-effect">
                                                <i style="margin-top: -25px;" class="material-icons">picture_as_pdf</i>
                                            </button>
                                        </a>
                                        <table id="dispo-info-table" class="table table-bordered table-striped table-hover">
                                            <thead>

                                                <tr style="font-size: 12px">

                                                    <th>Patient Name</th>
                                                    <th>Admission Date
                                                    <th>Discharge Date</th>
                                                    <th>Doctor</th>

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
//        purchase.load_s("http://192.168.2.111:3777/drainwizv2/assets/vendors/js/responsive.js");
       
        var sidemenu = $('#census-3');
        sidemenu.removeClass().addClass('active');
        sidemenu.parents("li").removeClass().addClass('active');
});
</script>
