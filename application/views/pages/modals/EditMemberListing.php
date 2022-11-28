<!-- Large Size -->
    <div class="modal fade" id="edit_member_modal" tabindex="-1" role="dialog" data-backdrop="static">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-cyan">
                    <h4 class="modal-title" id="largeModalLabel">Edit Member Info</h4>
                </div>
                <div class="modal-body">
                    <form id="member-form"><br>
                        <input type="hidden" id="txtid" name="txtid" class="form-control">
                        <div class="row"> 
                            <div class="col-sm-4">
                                <label class="form-label">Pin</label>
                                <input type="text" id="txtpin" name="txtpin" class="form-control">
                            </div>
                            <div class="col-sm-4">
                                <label class="form-label">Card No.</label>
                                <input type="text" id="txtcardno" name="txtcardno" class="form-control">
                            </div>
                            <div class="col-sm-4">
                                <label class="form-label">Date of Membership</label>
                                <input type="date" id="txtdate" name="txtdate" class="form-control">
                            </div>
                        </div>
                        <div class="row"> 
                            <div class="col-sm-6">
                                <label class="form-label">Name</label>
                                <input type="text" id="txtname" name="txtname" class="form-control">
                            </div>
                            <div class="col-sm-6">
                                <label class="form-label">Email Address</label>
                                <input type="text" id="txtemail" name="txtemail" class="form-control">
                            </div>
                        </div>
                         <div class="row"> 
                            <div class="col-sm-4">
                                <label class="form-label">Birthday</label>
                                <input type="date" id="txtbday" name="txtbday" class="form-control">
                            </div>
                            <div class="col-sm-2">
                                <label class="form-label">Gender</label>
                                <select name="gender" class="form-control">
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                    </select>
                            </div>
                            <div class="col-sm-6">
                                <label class="form-label">Address</label>
                                <input type="text" id="txtAddress" name="txtAddress" class="form-control">
                            </div>
                        </div>
                         <div class="row"> 
                            <div class="col-sm-6">
                                <label class="form-label">Mobile Number</label>
                                <input type="text" id="txtmobileno" name="txtmobileno" class="form-control">
                            </div>
                            <div class="col-sm-6">
                                <label class="form-label">Zone</label>
                                <input type="text" id="txtzone" name="txtzone" class="form-control" onclick="openZoneList();" readonly>
                            </div>
                        </div>
                         <div class="row"> 
                            <div class="col-sm-6">
                                <label class="form-label">Stocks</label>
                                <input type="number" id="txtstocks" name="txtstocks" class="form-control">
                            </div>
                            <div class="col-sm-6">
                                <label class="form-label">Values</label>
                                <input type="text" id="txtvalues" name="txtvalues" class="form-control" >
                            </div>
                        </div>
                         <div class="row"> 
                             <div id="zonedivlist" class="col-lg-12 col-md-12 col-sm-12 col-xs-12" hidden>
                                <table id="zonelisttable" class="table table-bordered table-striped" style="width: 100%">
                                        <thead class="bg-cyan">
                                            <tr>
                                                <th>Zone</th>
                                                <th>Description</th>
                                            </tr>
                                        </thead>
                                    </table> 
                           
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
                            <button type="button" onclick="saveMemberChnages()" class="btn btn-link waves-effect">SAVE</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>