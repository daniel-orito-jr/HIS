<!-- Large Size -->
<div class="modal fade" id="payrolldetails" tabindex="-1" role="dialog" data-backdrop="static">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-green">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                    <h4 class="modal-title" style="text-transform: uppercase;">PAYROLL DETAILS</h4>
                </div>
                <div class="modal-body">
                    <div class="row clearfix" id="admission">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="card">
                                <div class="body table-responsive">
                                    <form id="dashboard-onProcess-info-form"><br>
                                        <div class="col-sm-3">
                                            <div class="form-group form-float">
                                                <div class="form-line focused">
                                                    Batch No:
                                                    <input type="text" class="form-control" id="batch" name="batch" style="text-transform: uppercase;" readonly/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group form-float">
                                                <div class="form-line focused">
                                                     Payroll Period:
                                                     <input type="text" class="form-control" id="payperiod" name="payperiod" style="text-transform: uppercase;" readonly/>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group form-float">
                                                <div class="form-line focused">
                                                     Number of Days:
                                                     <input type="text" class="form-control" id="paydays" name="paydays" style="text-transform: uppercase;" readonly/>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group form-float">
                                                <div class="form-line focused">
                                                    NET:
                                                     <input type="text" class="form-control" id="netpay" name="netpay" style="text-transform: uppercase;" readonly/>

                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                   <form id="payroll-summary-form" action="<?= base_url("user/generate_payroll_summary_report") ?>" method="POST" target="_blank">
                                    <input type="hidden" id="batchno" name="batchno" />
                                    </form>
                            
                                <a class="payroll-button" href="javascript:void(0)" target="_blank">
                                    <button onclick="payroll.get_payroll_summary_report()" style="height: 25px" type="button" class="btn bg-pink waves-effect">
                                        <i style="margin-top: -25px;" class="material-icons">picture_as_pdf</i>
                                    </button>
                                </a>
                                    
                                    
                                    <table id="payroll-details-table" class="table table-striped table-bordered" style="width:100%;">
                                        <thead style="background-color:#00ce68;color:white;">
                                            <tr style="font-size: 12px">
                                                <th rowspan="2">DEPARTMENT</th>
                                                <th rowspan="2">EMPLOYEE NUMBER</th>
                                                <th rowspan="2">EMPLOYEE NAME</th>
                                                <th rowspan="2">SALARY GRADE</th>
                                                <th rowspan="2">BASIC PAY</th>
                                                <th rowspan="2">INCENTIVES</th>
                                                <th rowspan="2" style="background-color:#BBDEFB">GROSS</th>
                                                <th colspan="5"><center>LESS</center></th>
                                                <th rowspan="2" style="background-color:#C5CAE9">NET</th>
                                            </tr>
                                            <tr style="font-size: 12px">
                                                <th>SSS</th>
                                                <th>PhilHealth</th>
                                                <th>PAG-IBIG</th>
                                                <th>TAX</th>
                                                <th>ABSENT & UNDERTIME</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                        <tfoot>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-9 p-t-5"></div>
                    </div>
                </div>
                <div class="modal-footer bg-green">
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
