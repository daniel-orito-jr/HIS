<!-- Large Size -->
<div class="modal fade" id="totalaccuphicar" tabindex="-1" role="dialog" data-backdrop="static">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-cyan">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                    <h4 class="modal-title" style="text-transform: uppercase;">TOTAL ACCUMULATED PHILHEALTH AR</h4>
                </div>
                <div class="modal-body">
                    <form id="search-totalaccphicar-form">
                    <div class="row clearfix">
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label>Choose Month:</label>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class='input-group date'>
                                    <span class="input-group-addon">
                                       <i class="material-icons date-icon" >date_range</i>
                                    </span>
                                    <div class="form-line">
                                        <input type='month' name="start_date" class="form-control" value="<?= $cur_date ?>" onchange="dashboard.totalaccphicAR()">
                                    </div>
                                    <small style="color: red"></small>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                 <button onclick="dashboard.totalaccphicAR()" type="button" class="btn bg-purple waves-effect">
                                    <span>Search <i class="material-icons">search</i></span>
                                </button>
                            </div>
                        </div>
                    </div>
                    </form>
                    <div class="row clearfix">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="card">
                                <div class="body table-responsive">
                                    <label>TOTAL:</label>
                                    <span>&#9678; &nbsp;Hospital Fee: ₱&nbsp;<label id="totalhospfee">0.00</label>&nbsp;&nbsp;|&nbsp;&nbsp; &#9678; &nbsp; Professional Fee: ₱&nbsp;<label id="totalproffee">0.00</label></span>
                                    <table id="total-accumulated-PHICAR-table" class="table table-bordered table-striped table-hover">
                                        <thead>
                                            <tr style="font-size: 12px">
                                                <th>Claim Series Number</th>
                                                <th>Patient Name</th>
                                                <th>Hospital Fee</th>
                                                <th>Professional Fee</th>
                                                <th>Discharge Date</th>
                                                <th>Process Date</th>
                                                <th data-toggle="tooltip" data-placement="top" title="Today - Process Date">Aging </th>
                                                <th>Status</th>
                                                <th>Submit Date</th>
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
