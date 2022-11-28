<!-- Large Size -->
<div class="modal fade" id="inputsupervisoraccountmodal" tabindex="-1" role="dialog" data-backdrop="static">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-cyan">
                <h4 class="modal-title" id="ss">Supervisor credentials required!</h4>
            </div>
            <div class="modal-body">
                <!--                <div class="col-sm-12 col-lg-12">
                                    <h4>Input supervisor account to proceed.</h4>
                                </div>-->
                <input type="hidden" id="sendtype" value="">
                <input type="hidden" name="control" value="">
                <div class="col-sm-12">
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="text" id="supervisorusername" name="supervisorusername" class="form-control">
                            <label class="form-label">Supervisor Username</label>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="password" id="supervisorpassword" name="supervisorpassword" class="form-control">
                            <label class="form-label">Supervisor Password</label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-9 p-t-5"></div>
                </div>
            </div>

        </div>
        <div class="modal-footer bg-cyan">
            <!--<button type="button" class="btn btn-link waves-effect">SAVE CHANGES</button>-->
            <div class="col-md-12">
                <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CANCEL</button>
                <button type="button" onclick="checkSupervisorAccountToProceedSending($('#sendtype').val());" class="btn btn-link waves-effect">PROCEED</button>
            </div>
        </div>
    </div>
</div>
