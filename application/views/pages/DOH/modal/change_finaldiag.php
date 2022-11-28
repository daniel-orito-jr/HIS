<div class="modal fade" id="change_finaldiag" tabindex="-1" role="dialog" data-backdrop="static">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header bg-cyan">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                    </button>
                    <h4>EDIT FINAL DIAGNOSIS</h4>
                </div>
                
                <div class="modal-body">
                    <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h4 id="pxname"></h4></div>
                            <input type="text" id="txtid" hidden/>
                        <div class="body">
                            <div class="col-md-12">
                                <button type="button" class="btn btn-success waves-effect" onclick="doh_discharges.fetch_icdcode()">
                                    <i class="material-icons">file_download</i>
                                    <span>IMPORT CODE</span>
                                </button>
                            </div>
                            <form>
                                <label>ICD Code</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" id="txticd" class="form-control">
                                    </div>
                                </div>
                                <label>Diagnosis</label>
                                <div class="form-group">
                                        <div class="form-line">
                                            <textarea rows="4" class="form-control no-resize" id="pxdiag"></textarea>
                                        </div>
                                    </div>

                                
                                <br>
                                <button type="button" class="btn btn-primary m-t-15 waves-effect" onclick="doh_discharges.update_finaldiag()">UPDATE</button>
                            </form>
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
<?php $this->load->view('pages/DOH/modal/phicicdcode'); ?>

<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function () {
});
</script>