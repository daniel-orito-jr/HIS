<!-- Large Size -->
<div class="modal fade" id="totalpatients" tabindex="-1" role="dialog" data-backdrop="static">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-cyan">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                    <h4 class="modal-title" id="tpatient" style="text-transform: uppercase;"></h4>
                </div>
                <div class="modal-body">
                    
                        <div class="row clearfix" id="admission">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="card">
                                    <div class="body table-responsive">
                                        <form id="total-patient-info-form" action="<?= base_url("user/generate_total_patients_report") ?>" method="POST" target="_blank" id="ph">
                                            <input type="hidden" name="s_date" value=""/>
                                            <input type="hidden" name="e_date" value=""/>
                                            <input type="hidden" name="search" value=""/>
                                        </form>
                                        <a class="report-total" href="javascript:void(0)" target="_blank" >
                                            <button onclick="dashboard.get_total_patients_report()" style="height: 25px" type="button" class="btn bg-pink waves-effect">
                                                <i style="margin-top: -25px;" class="material-icons">picture_as_pdf</i>
                                            </button>
                                        </a>
                                        <table id="total-patient-info-table" class="table table-bordered table-striped table-hover">
                                            <thead>

                                                <tr style="font-size: 12px">

                                                    <th>Patient Name</th>
                                                    <th>Admission Date</th>
                                                    <th>Patient Classification</th>
                                                    <th>Age</th>
                                                    <th>Birthday</th>
                                                    <th>Room</th>
                                                    <th>Doctor</th>
                                                    <th>Philhealth Membership</th>
                                                    <th>Admitted by</th>
                                             

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
