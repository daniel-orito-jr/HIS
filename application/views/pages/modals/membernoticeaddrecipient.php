<!-- Large Size -->
<div class="modal fade" id="membernoticeaddrecipient" tabindex="-1" role="dialog" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-cyan" style="color:white;" >
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="modalTitle" style="text-transform: uppercase;"></h4>
            </div>
            <div class="modal-body">
                <input type="hidden" id="txtnoticedatetimeR">
                <input type="hidden" id="txtnoticeplaceR">
                <input type="hidden" id="txtnoticeagendaR">
                <input type="hidden" id="txttemplate">
                <input type="hidden" id="txtregistrationtimeR">
                <input type="hidden" id="txtnoticecontactpersonR">
                <input type="hidden" id="txtnoticecontactnumberR">
                <input type="hidden" id="txtnoticereasonofcancellationR">
                <input type="hidden" id="rowcountxx"/>

                <div class="row clearfix" id="admission">
                    <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
                        <p><strong>Add Recipient</strong></p>
                        <select class="form-control show-tick" data-live-search="true" id="cmbaddRecipient" name="cmbaddRecipient" onchange="cmbAddrecipient()">
                            <option value="AreaZone">Area Zone</option>
                            <option value="Individual">Individual</option>
                            <option value="ALL">ALL</option>
                        </select>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <br>
                            <div id="individual" class="hidden">
                                <table id="individual-table" class="table table-bordered table-striped table-hover" style="width:100%;">
                                    <thead>
                                        <tr style="font-size: 12px">
                                            <th>Card No</th>
                                            <th>Name</th>
                                            <th>*</th>
                                        </tr>
                                    </thead>
                                </table>
                                <br>
                                <strong><small>Numbers of Entries: <u><span  id="numrows"></span ></u></small></strong>
                            </div>
                            <div id="AreaZone">
                                <table id="AreaZone-table" class="table table-bordered table-striped table-hover" style="width:100%;">
                                    <thead class="bg-cyan">
                                        <tr style="font-size: 12px">
                                            <th>Area Zone</th>
                                            <th>*</th>
                                        </tr>
                                    </thead>
                                </table>
                                <br>
                                <strong><small>Numbers of Entries: <u><span  id="numrowsAreaZone"></span ></u></small></strong>
                            </div>
                            <div id="Barangay" class="hidden">
                                <table id="Barangay-table" class="table table-bordered table-striped table-hover" style="width:100%;">
                                    <thead>
                                        <tr style="font-size: 12px">
                                            <th>Barangay</th>
                                            <th>*</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                            <div id="all" class="hidden">
                                <table id="all-table" class="table table-bordered table-striped table-hover" style="width:100%;">
                                    <thead>
                                        <tr style="font-size: 12px">
                                            <th>Individual</th>
                                            <th>*</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12"></div>
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <p><i class="material-icons">drafts</i><strong> FINAL RECIPIENTS</strong>&nbsp;<small style="color: #ff8b8e;">(If row color is red, unsent announcements)</small></p>
                        <table id="finalrecipient-table" class="table table-bordered table-striped table-hover" style="width:100%;">
                            <thead >
                                <tr style="font-size: 12px">
                                    <th>*</th>
                                    <th>Card No</th>
                                    <th>Name</th>
                                    <th>Address</th>
                                    <th>Mobile Number</th>
                                    <th>Email Address</th>
                                    <th>Zone</th>
                                    <th>Sent</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-9 p-t-5"></div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="row clearfix">
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <button type="button" class="btn bg-blue waves-effect btn-block" onclick="validateRecipients(); $('#sendtype').val('txtmessage');">
                            <i class="material-icons">email</i>
                            <span>SEND TEXT</span>
                        </button>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <button type="button" class="btn bg-green waves-effect btn-block" onclick="validateRecipients(); $('#sendtype').val('email');">
                            <i class="material-icons">send</i>
                            <span>SEND EMAIL</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



