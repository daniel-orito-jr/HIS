<!-- Large Size -->
    <div class="modal fade" id="addUser" tabindex="-1" role="dialog" data-backdrop="static">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-cyan">
                    <h4 class="modal-title" id="largeModalLabel">Add New User</h4>
                </div>
                <div class="modal-body">
                    <form id="add-user-form"><br>
                        <div class="col-sm-12">
                            <div class="form-group form-float">
                                <div class="form-line" style="padding-top: 10px">
                                    <select name="usertype" class="form-control show-tick" data-live-search="true">
                                        <option style="display: none">-- user type --</option>
                                        <option value="1">User</option>
                                        <option value="255">Admin</option>
                                    </select>
                                    <label class="form-label">User Type</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" name="username" class="form-control">
                                    <label class="form-label">Username</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="password" name="pass" class="form-control">
                                    <label class="form-label">Password</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="password" name="passconf" class="form-control">
                                    <label class="form-label">Confirm Password</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" name="contactno" class="form-control">
                                    <label class="form-label">Contact No.</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-9 p-t-5"></div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer bg-cyan">
                    <div class="col-md-12">
                        <div class="col-md-6" >
                            <button style="float: left" type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                        </div>
                        <div class="col-md-6">
                            <button type="button" onclick="users.add_user()" class="btn btn-link waves-effect">SAVE</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>