<!-- Large Size -->
    <div class="modal fade" id="accntSetting" tabindex="-1" role="dialog" data-backdrop="static">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-cyan">
                    <h4 class="modal-title" id="ss">Account Settings</h4>
                </div>
                <div class="modal-body">
                    <form id="modify-accnt-form"><br>
                        <input type="hidden" name="control" value="">
                        <div class="col-sm-12">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" name="username" class="form-control">
                                    <label class="form-label">New Username</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="password" name="oldpass" class="form-control">
                                    <label class="form-label">Old Password</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="password" name="pass" class="form-control">
                                    <label class="form-label">New Password</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="password" name="passconf" class="form-control">
                                    <label class="form-label">Retype Password</label>
                                </div>
                            </div>
                        </div>
                            <div class="row">
                                <div class="col-xs-9 p-t-5"></div>
                            </div>
                        </form>
                    </div>
                    
                </div>
                <div class="modal-footer bg-cyan">
                    <!--<button type="button" class="btn btn-link waves-effect">SAVE CHANGES</button>-->
                    <div class="col-md-12">
                            <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                            <button type="button" onclick="user.modify_accnt()" class="btn btn-link waves-effect">SAVE</button>
                    </div>
                </div>
            </div>
        </div>
