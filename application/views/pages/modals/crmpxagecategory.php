<!-- Large Size -->
<div class="modal fade" id="crmpxagecategory" tabindex="-1" role="dialog" data-backdrop="static">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-cyan">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="titleid_pxagexcrm" style="text-transform: uppercase;"></h4>
                    <input type="hidden" id="daterequestagecateparam">
                    <input type="hidden" id="agecategoryagecateparam">
                    <input type="hidden" id="patienttypeagecateparam">
                    <input type="hidden" id="othersnamesagecateparam">
                </div>
                <div class="modal-body">
                    <div class="row clearfix d-none">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <form id="generate-patient-listing-viaagecate-data-sheet-form" action="<?= base_url("Dashboard/PatientListingViaAgeCategoryGeneratedData") ?>" method="POST" target="_blank" >
                                <input type="hidden" name="hiddenname_daterequest">
                                <input type="hidden" name="hiddenname_agecatename">
                                <input type="hidden" name="hiddenname_patienttype">
                            </form>
                        </div>
                    </div>
                    <div class="row clearfix" id="admission">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="card">
                                <div class="body table-responsive">
                                    <button onclick="generatePatientListingAgeCategoryParameter()" style="margin-left:0px;height: 25px" type="button" class="btn bg-pink waves-effect">
                                        <i style="margin-top: -25px;" class="material-icons">picture_as_pdf</i>
                                    </button>
                                    <br><br>
                                    <table id="agecateg-patient-table" class="table table-bordered table-striped table-hover">
                                        <thead>
                                            <tr style="font-size: 12px">
                                                <th id="table-head-no">No</th>
                                                <th id="table-head-name">Patient&nbsp;&nbsp;&nbsp;Name</th>
                                                <th id="table-head-action">Admission&nbsp;&nbsp;&nbsp;Date</th>
                                                <th id="table-head-action">Patient&nbsp;&nbsp;&nbsp;Classification</th>
                                                <th id="table-head-action">Age</th>
                                                <th id="table-head-action">Birthday</th>
                                                <th id="table-head-adrsprov">Address</th>
                                                <th id="table-head-name">Room</th>
                                                <th id="table-head-name">Doctor</th>
                                                <th id="table-head-action">Philhealth&nbsp;&nbsp;&nbsp;Membership</th>
                                                <th id="table-head-action">Admitted&nbsp;&nbsp;&nbsp;by</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="modal-footer bg-cyan">
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
