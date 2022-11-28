<body class="theme-cyan">
    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2 style="text-transform: uppercase;">
                    Members Management
                </h2>
            </div>
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header bg-cyan">
                            <h2><strong>ANNOUNCEMENTS</strong></h2>
                        </div>
                        <div class="body">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs" role="tablist">
                                <li role="presentation" id="all-announcements" class="active">
                                    <a href="#home_with_icon_title" data-toggle="tab" onclick="clickAllAnnouncements()">
                                        <i class="material-icons">view_list</i> All Announcements
                                    </a>
                                </li>
                                <li role="presentation" id="send-announcements" >
                                    <a href="#profile_with_icon_title" data-toggle="tab" >
                                        <i class="material-icons">send</i> Send Announcements
                                    </a>
                                </li>

                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane fade in active" id="home_with_icon_title">
                                    <div class="row clearfix">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="body table-responsive">
                                                <table id="announcements-list-table" class="table table-bordered table-striped table-hover" style="white-space: nowrap;">
                                                    <thead class="bg-cyan">
                                                        <tr>
                                                            <th>Reference Number</th>
                                                            <th>Template</th>
                                                            <th>Subject</th>
                                                            <th>Date</th>
                                                            <th>Venue</th>
                                                            <th>No. of Recipients</th>
                                                            <th>Status</th>
                                                            <th>View Details</th>
                                                            <th>Status</th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <!--                                    
<div class="table-responsive"  style="padding-left:10px;border:solid red;">
                                    
                                    </div>-->
                                </div>
                                <div role="tabpanel" class="tab-pane fade" id="profile_with_icon_title">
                                    <div class="row clearfix">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12" >

                                                <label style="margin-top:10px;"><strong> • Announcements Template:</strong></label>
                                            </div>
                                            <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12" >
                                                <select class="form-control show-tick" data-live-search="true" id="announcement_temp" name="announcement_temp" onchange="changeAnnouncementTemplate()">
                                                    <option value="Annual">Notice of Annual General Members Meeting</option>
                                                    <option value="BM">Board Meeting</option>
                                                    <option value="MC">Meeting Cancellation</option>
                                                </select>
                                            </div>
                                            <br>

                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12" style="height:1000px;">
                                                <iframe src="<?= base_url("MembersMgmt/generate_announcement") ?>" id="templatex" style="border:none;height:100%;width:100%;"></iframe>
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12" style="height:1000px;">
                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                    <h4><strong>INFORMATION:</strong></h4>
                                                    <br>
                                                    <div class="switch">
                                                        <span>SEND MAIL ALSO TO CC</span>
                                                        <br>
                                                        <label>NO<input id="sendmailtocc" type="checkbox" checked=""><span class="lever"></span>YES</label>
                                                    </div>
                                                    <br>
                                                    <!--<hr>-->
                                                    <p><strong>REFERENCE NUMBER:</strong></p>
                                                    <input type="text" class="form-control" id="txtnoticerefno" name="txtnoticerefno"  />
                                                    <small id="txtnoticerefnoerror" style="color:red;"></small>
                                                    <br>
                                                    <p><strong>SUBJECT:</strong></p>
                                                    <input type="text" class="form-control" id="txtnoticesubject" name="txtnoticesubject"  />
                                                    <small id="txtnoticesubjecterror" style="color:red;"></small>
                                                    <br>
                                                    <p><strong>DATE:</strong></p>
                                                    <input type="date" class="form-control" id="txtnoticedate" name="txtnoticedate"   />
                                                    <small id="txtnoticedateerror" style="color:red;"></small>
                                                    <br>
                                                    <div id="txtnoticetimediv">
                                                        <p><strong>TIME:</strong></p>
                                                        <input type="time" class="form-control" id="txtnoticetime" name="txtnoticetime"  />
                                                        <small id="txtnoticetimeerror" style="color:red;"></small>
                                                        <br>
                                                    </div>
                                                    <div id="txtregistrationtimediv">
                                                        <p><strong>REGISTRATION TIME:</strong></p>
                                                        <input type="time" class="form-control" id="txtregistrationtime" name="txtregistrationtime"   />
                                                        <small id="txtregistrationtimeerror" style="color:red;"></small>
                                                        <br>
                                                    </div>

                                                    <div id="txtnoticeplacediv">
                                                        <p><strong>PLACE:</strong></p>
                                                        <textarea rows="3" style="width:100%;" id="txtnoticeplace" name="txtnoticeplace"></textarea>
                                                        <small id="txtnoticeplaceerror" style="color:red;"></small>
                                                        <br>
                                                    </div>
                                                    <div id="txtnoticeagendadiv" class="hidden">
                                                        <p><strong>AGENDA:</strong></p>
                                                        <textarea rows="5" style="width:100%;" id="txtnoticeagenda" name="txtnoticeagenda"></textarea>
                                                        <small id="txtnoticeagendaerror" style="color:red;"></small>
                                                        <br>
                                                    </div>
                                                    <div id="txtnoticecontactpersondiv" class="hidden">
                                                        <p><strong>CONTACT PERSON:</strong></p>
                                                        <input type="text" class="form-control" id="txtnoticecontactperson" name="txtnoticecontactperson"  />
                                                        <small id="txtnoticecontactpersonerror" style="color:red;"></small>
                                                        <br>
                                                    </div>
                                                    <div id="txtnoticecontactnumberdiv" class="hidden">
                                                        <p><strong>CONTACT NUMBER:</strong></p>
                                                        <input type="number" class="form-control" id="txtnoticecontactnumber" name="txtnoticecontactnumber"  />
                                                        <small id="txtnoticecontactnumbererror" style="color:red;"></small>
                                                        <br>
                                                    </div>
                                                    <div id="txtnoticereasonofcancellationdiv" class="hidden">
                                                        <p><strong>REASON OF CANCELLATION:</strong></p>
                                                        <textarea rows="5" style="width:100%;" id="txtnoticereasonofcancellation" name="txtnoticereasonofcancellation"></textarea>
                                                        <small id="txtnoticereasonofcancellationerror" style="color:red;"></small>
                                                    </div>

                                                    <hr>
                                                    <div class="switch hidden" id="toggleUpdate">
                                                        <br>
                                                        <label><small>Add Recipient Only</small><input id="addorresend" type="checkbox"><span class="lever"></span><small>Resend Announcement</small></label><br>
                                                    </div>
                                                    <br>
                                                    <button type="button" class="btn bg-cyan waves-effect btn-block" id="addrecipient" onclick="checkAnnouncementIfExists('1')">
                                                        <i class="material-icons">add</i>
                                                        <span>ADD RECIPIENT</span>
                                                    </button>
                                                    <button type="button" class="btn bg-cyan waves-effect btn-block hidden" id="viewrecipient" onclick="viewRecipient()">
                                                        <i class="material-icons">pageview</i>
                                                        <span>VIEW RECIPIENTS</span>
                                                    </button>
                                                    <button type="button" class="btn bg-green waves-effect btn-block" id="btnSave" onclick="checkAnnouncementIfExists('2')">
                                                        <i class="material-icons">save</i>
                                                        <span>SAVE</span>
                                                    </button>
                                                    <!--                                        <button type="button" class="btn bg-green waves-effect btn-block" onclick="sendAnnouncement()">
                                                                                                <i class="material-icons">send</i>
                                                                                                <span>SEND</span>
                                                                                            </button>-->
                                                    <!--                                        <button type="button" class="btn bg-green waves-effect btn-block" onclick="$('#inputsupervisoraccountmodal').modal('show');">
                                                                                                <i class="material-icons">send</i>
                                                                                                <span>SEND BOARD MEETING</span>
                                                                                            </button>-->

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <footer style="margin-bottom: 10px;">
        <div>
            <center>Powered by <img src="<?= base_url('assets/img/logo.png'); ?>" width="15" height="15"/> <a href="https://www.mydrainwiz.com/">DRAiNWIZ</a>.</center>
        </div>
        <div class="clearfix"></div>
    </footer>


</body>
<?php $this->load->view('pages/modals/membernoticeaddrecipient'); ?>
<?php $this->load->view('pages/modals/inputsupervisoraccount') ?>
<?php $this->load->view('pages/modals/membernoticeviewecipient') ?>


<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function ()
    {
        var sidemenu = $('#membersmgmt-2');
        sidemenu.removeClass().addClass('active');
        sidemenu.parents("li").removeClass().addClass('active');
    });
</script>