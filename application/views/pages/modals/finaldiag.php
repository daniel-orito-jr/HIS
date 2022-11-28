<!-- Large Size -->
<div class="modal fade" id="finaldiag" tabindex="-1" role="dialog" data-backdrop="static">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-green">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                    <h4 class="modal-title"> <p id='patientname'></p></h4>
                </div>
                <div class="modal-body">
                     <h5><span>Diagnosis:</span>&nbsp;<span id="fdiagnosis"></span> </h5>
                        <input type='hidden'   name="confinename" class="form-control" readonly="readonly" id="confinename">
                   
                   
                    <div class="row clearfix" id="admission">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="card">
                                    <div class="body table-responsive">
                                    
                                        <table id="f-diagnosis-table" class="table table-bordered table-striped table-hover">
                                            <thead>

                                                <tr style="font-size: 12px">
                                                    <th>Final Diagnosis</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>
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

 // confine.get_f_diagnosis();
});
</script>
