<!-- Large Size -->
<div class="modal fade" id="onProcessinfo" tabindex="-1" role="dialog" data-backdrop="static">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-cyan">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                    <label class="modal-title" id="aging" style="text-transform: uppercase;"></label> (<span id="totalpat"></span>)
                </div>
                <div class="modal-body">
                    <form id="onProcess-info-form"><br>
                        <div class="col-sm-4">
                            <div class="form-group form-float">
                                <div class="form-line focused">
                                     Total Amount
                                      <input type="text" class="form-control" id="tatolamt" name="tatolamt" style="text-transform: uppercase;"/>
                                     <!-- /*<h4  id="tatolamt" style="text-transform: uppercase;"></h4>*/ -->
                                   <!--  -->
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group form-float">
                                <div class="form-line focused">
                                     Total Hospital Fee
                                     <input type="text" class="form-control" id="totalhci" name="totalhci" style="text-transform: uppercase;" readonly/>
                                   
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group form-float">
                                <div class="form-line focused">
                                     Total Professional Fee
                                     <input type="text" class="form-control" id="totalpf" name="totalpf" style="text-transform: uppercase;" readonly/>
                                   
                                </div>
                            </div>
                        </div>
                    </form>
                       
                        
                        <div class="row clearfix">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="card">
                                    <div class="body table-responsive">
                                        <form id="on-process-form" action="<?= base_url("user/generate_onProcess_patients_report") ?>" method="POST" target="_blank">
                                            <input type="hidden" name="s_date"/>
                                            <input type="hidden" name="agingx"/>
                                            <a class="reports-btn" href="javascript:void(0)" target="_blank">
                                                <button onclick="phic.generate_onprocess_aging_report()" style="height: 25px" type="button" class="btn bg-pink waves-effect">
                                                <i style="margin-top: -25px;" class="material-icons">picture_as_pdf</i>
                                                </button>
                                            </a>   
                                        </form>
                                        <table id="onProcess-info-table" class="table table-bordered table-striped table-hover">
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
