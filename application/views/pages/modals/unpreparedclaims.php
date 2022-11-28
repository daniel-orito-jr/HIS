<!-- Large Size -->
<div class="modal fade" id="unpreparedclaims" tabindex="-1" role="dialog" data-backdrop="static">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header ">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                    <h4 class="modal-title" style="text-transform: uppercase;">UNPREPARED CLAIMS (<span id='aging'></span>)</h4>
                </div>
                <div class="modal-body">
                    <div class="row clearfix" id="admission">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="card">
                                <div class="body table-responsive">
                                    <form id="dashboard-onProcess-info-form"><br>
                                        <div class="col-sm-4">
                                            <div class="form-group form-float">
                                                <div class="form-line focused">
                                                    Total Amount
                                                    <input type="text" class="form-control" id="totalamt_unprep" name="totalamt_unprep" style="text-transform: uppercase;" readonly/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group form-float">
                                                <div class="form-line focused">
                                                     Total Hospital Fee
                                                     <input type="text" class="form-control" id="totalhci_unprep" name="totalhci_unprep" style="text-transform: uppercase;" readonly/>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group form-float">
                                                <div class="form-line focused">
                                                     Total Professional Fee
                                                     <input type="text" class="form-control" id="totalpf_unprep" name="totalpf_unprep" style="text-transform: uppercase;" readonly/>

                                                </div>
                                            </div>
                                        </div>
                                    </form>
<!--                                    <form id="phic-info-formx" action="<?= base_url("user/generate_phic_report") ?>" method="POST" target="_blank" id="ph">
                                        <input type="hidden" name="s_date" value=""/>
                                        <input type="hidden" name="e_date" value=""/>
                                        <input type="hidden" name="search" value=""/>
                                    </form>
                                    <a class="report-btn" href="javascript:void(0)" target="_blank" >
                                        <button onclick="dashboard.get_phic_report()" style="height: 25px" type="button" class="btn bg-pink waves-effect">
                                            <i style="margin-top: -25px;" class="material-icons">picture_as_pdf</i>
                                        </button>
                                    </a>-->
                                    <table id="dashboard-onpro-info-table" class="table table-bordered table-striped table-hover">
                                        <thead>
                                            <tr style="font-size: 12px">
                                                <th>Account Number</th>
                                                <th>Patient Name</th>
                                                <th>Admission Date</th>
                                                <th>Discharged Date</th>
                                                <th>Hospital Fee</th>
                                                <th>Professional Fee</th>
                                                <th>Membership </th>
                                                <th>Aging </th>
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
                <div class="modal-footer">
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
