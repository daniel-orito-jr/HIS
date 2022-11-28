$(function () {
//    $('#membersmgmt-1').removeClass().addClass('active');
    $('.date').datetimepicker({
        format: 'YYYY-MM'
    });
    fetchMembersList();
    fetchZoneList();
    fetchAllAnnouncements();

});
var membercardno = [];


function fetchMembersList() {
    var mem = $("#membermonth").val();
    var membermonth = '';
    if ($('#viewAllMembers').prop("checked") == true) {
        membermonth = "All";
    } else if ($('#viewAllMembers').prop("checked") == false) {
        membermonth = mem;
    }


    $('#member-listing-table').dataTable().fnDestroy();
    var table = $('#member-listing-table').dataTable({
//        dom: 'frtip',
        responsive: true,
        processing: true,
        serverSide: true,
        order: [],
        scrollY: "400px",
        sScrollX: "100%",
        ajax: {
            url: BASE_URL + "MembersMgmt/fetchMembersList",
            type: "POST",
            data: {membermonth: membermonth}
        },
        createdRow: function (row, datax, dataIndex) {
//            if (datax[6] !== "")
//            {
//                $(row).css('background-color', '#B7F6A6');
//            } else
//            {
//                $(row).css('background-color', '#CDD5CB');
//            }
        },
        initComplete: function (settings, json) {

        }
    });
    $('#member-listing-table_filter input').unbind();
    $('#member-listing-table_filter input').bind('keyup', function (e) {
        if (e.keyCode == 13) {
            table.fnFilter(this.value);
        }
    });
}
function fetchZoneList() {

    $('#zone-listing-table').dataTable().fnDestroy();
    var table = $('#zone-listing-table').dataTable({
//        dom: 'frtip',
        responsive: true,
        processing: true,
        serverSide: true,
        order: [],
        scrollY: "400px",
        sScrollX: "100%",
        ajax: {
            url: BASE_URL + "MembersMgmt/fetchZoneList",
            type: "POST",
        },

    });
    $('#zone-listing-table_filter input').unbind();
    $('#zone-listing-table_filter input').bind('keyup', function (e) {
        if (e.keyCode == 13) {
            table.fnFilter(this.value);
        }
    });
}
function fetchListOfZone() {

    $('#zonelisttable').dataTable().fnDestroy();
    var table = $('#zonelisttable').dataTable({
//        dom: 'frtip',
         processing: true,
        serverSide: true,
        responsive: false,
        scrollx: true,
        order: [],
        ajax: {
            url: BASE_URL + "MembersMgmt/fetchListOfZones",
            type: "POST",
        },

    });
    $('#zonelisttable_filter input').unbind();
    $('#zonelisttable_filter input').bind('keyup', function (e) {
        if (e.keyCode == 13) {
            table.fnFilter(this.value);
        }
    });
}

function addRecipient() {
    var error = 0;
    var txtnoticesubject = $("#txtnoticesubject").val();
    var txtnoticerefno = $("#txtnoticerefno").val();
    var txtnoticedate = $("#txtnoticedate").val();
    var txtnoticetime = $("#txtnoticetime").val();
    var txtnoticeplace = $("#txtnoticeplace").val();
    var txtnoticeagenda = $("#txtnoticeagenda").val();
    var txtregistrationtime = $("#txtregistrationtime").val();
    var txtnoticecontactperson = $("#txtnoticecontactperson").val();
    var txtnoticecontactnumber = $("#txtnoticecontactnumber").val();
    var txtnoticereasonofcancellation = $("#txtnoticereasonofcancellation").val();
    var announcement_temp = $("#announcement_temp").val();

    if (txtnoticerefno === "") {
        $("#txtnoticerefno").attr('style', 'border:solid red');
        error++;
    } else {
        $("#txtnoticerefno").removeAttr('style', true);
    }
    if (txtnoticedate === "") {
        $("#txtnoticedate").attr('style', 'border:solid red');
        error++;
    } else {
        $("#txtnoticedate").removeAttr('style', true);
    }
    if (txtnoticesubject === "") {
        $("#txtnoticesubject").attr('style', 'border:solid red');
        error++;
    } else {
        $("#txtnoticesubject").removeAttr('style', true);
    }
    if (txtnoticetime === "") {
        $("#txtnoticetime").attr('style', 'border:solid red');
        error++;
    } else {
        $("#txtnoticetime").removeAttr('style', true);
    }


    if (announcement_temp === "Annual") {


        if (txtregistrationtime === "") {
            $("#txtregistrationtime").attr('style', 'border:solid red');
            $("#txtregistrationtimeR").val(txtregistrationtime);
            error++;
        } else {
            $("#txtregistrationtime").removeAttr('style', true);
        }

        if (txtnoticeplace === "") {
            $("#txtnoticeplace").attr('style', 'border:solid red');
            error++;
        } else {
            $("#txtnoticeplace").removeAttr('style', true);
            $("#txtnoticeplaceR").val(txtnoticeplace);
        }
    }
    if (announcement_temp === "BM") {
        if (txtnoticeplace === "") {
            $("#txtnoticeplace").attr('style', 'border:solid red');
            error++;
        } else {
            $("#txtnoticeplace").removeAttr('style', true);
            $("#txtnoticeplaceR").val(txtnoticeplace);
        }

        if (txtnoticeagenda === "") {
            $("#txtnoticeagenda").attr('style', 'border:solid red');
            error++;
        } else {
            $("#txtnoticeagenda").removeAttr('style', true);
            $("#txtnoticeagendaR").val(txtnoticeagenda);
        }
    }
    if (announcement_temp === "MC") {
        if (txtnoticecontactperson === "") {
            $("#txtnoticecontactperson").attr('style', 'border:solid red');
            error++;
        } else {
            $("#txtnoticecontactperson").removeAttr('style', true);
            $("#txtnoticecontactpersonR").val(txtnoticecontactperson);
        }

        if (txtnoticecontactnumber === "") {
            $("#txtnoticecontactnumber").attr('style', 'border:solid red');
            error++;
        } else {
            $("#txtnoticecontactnumber").removeAttr('style', true);
            $("#txtnoticecontactnumberR").val(txtnoticecontactnumber);
        }

        if (txtnoticereasonofcancellation === "") {
            $("#txtnoticereasonofcancellation").attr('style', 'border:solid red');
            error++;
        } else {
            $("#txtnoticereasonofcancellation").removeAttr('style', true);
            $("#txtnoticereasonofcancellationR").val(txtnoticereasonofcancellation);
        }
    }


    if (error == 0) {
        $("#modalTitle").html(txtnoticerefno + ": " + txtnoticesubject);
        $("#txttemplate").val(announcement_temp);
        $("#txtnoticedatetimeR").val(txtnoticedate + " " + txtnoticetime);
        $("#membernoticeaddrecipient").modal('show');
        fetchFinalRecipient();
        if ($('#addorresend').prop("checked") == true) {
            updateAnnouncement(txtnoticesubject, announcement_temp, txtnoticerefno, txtnoticedate, txtnoticetime, txtnoticeplace, txtnoticeagenda,
                    txtregistrationtime, txtnoticecontactperson, txtnoticecontactnumber, txtnoticereasonofcancellation);
        }
    }

}

function updateAnnouncement(txtnoticesubject, announcement_temp, txtnoticerefno, txtnoticedate, txtnoticetime, txtnoticeplace, txtnoticeagenda,
        txtregistrationtime, txtnoticecontactperson, txtnoticecontactnumber, txtnoticereasonofcancellation) {

    var meetingdate = txtnoticedate + " " + txtnoticetime;
    $.ajax({
        type: 'POST',
        url: BASE_URL + "MembersMgmt/updateAnnouncement",
        data: {referenceno: txtnoticerefno, template: announcement_temp, subject: txtnoticesubject, meetingdate: meetingdate, location: txtnoticeplace,
            agenda: txtnoticeagenda, registrationtime: txtregistrationtime, contactperson: txtnoticecontactperson, contactno: txtnoticecontactnumber,
            reasonofcancellation: txtnoticereasonofcancellation},
        dataType: 'json'
    }).done(function (data) {
        if (data.status) {
            fetchFinalRecipient();
//            fetchRecipient_All();
//            submitStaffingPattern(professiondesignation);
        } else {
            swal("Unsuccessful!", "Error in saving! Please try again.", "error");
        }
    });
}

function fetchFinalRecipient() {
    var modalTitle = $("#modalTitle").html();
    var noticerefno = modalTitle.split(":");
    $('#finalrecipient-table').dataTable().fnDestroy();
    var table = $('#finalrecipient-table').dataTable({
//        dom: 'frti',
        responsive: true,
        processing: true,
        serverSide: true,
        paging: false,
        info: true,
        lengthChange: false,
        order: [],
        sScrollX: "100%",
        scrollY: "300px",
        columnDefs: [
            {
                targets: [7],
                visible: false
            }
        ],
        ajax: {
            url: BASE_URL + "MembersMgmt/fetchFinalRecipients",
            type: "POST",
            data: {noticerefno: noticerefno[0]}
        },
        createdRow: function (row, datax, dataIndex) {
         
            if (datax[7] !== '1')
            {
                $(row).css('background', 'linear-gradient(to right, #ff8b8e 0%, #ffffff 116%)');
            }

        },
        initComplete: function (settings, json) {
            membercardno = [];
            for (var i = 0; i < json['total'].length; i++) {
                membercardno.push(json['total'][i]['cardno']);
            }
            $("#rowcountxx").val(membercardno.length);
            var cmbAddrecipient = $('#cmbaddRecipient').val();
            if (cmbAddrecipient == "ALL") {
                fetchRecipient_All();
            } else if (cmbAddrecipient == "Barangay") {

            } else if (cmbAddrecipient == "AreaZone") {
                fetchAreaZone();
            } else {
                fetchRecipient_All();
            }
        }
    });
    $('#finalrecipient-table_filter input').unbind();
    $('#finalrecipient-table_filter input').bind('keyup', function (e) {
        if (e.keyCode == 13) {
            table.fnFilter(this.value);
        }
    });
}

function fetchRecipient_All() {
    var membercardnox = $('#rowcountxx').val();

    var modalTitle = $("#modalTitle").html();
    var noticerefno = modalTitle.split(":");
    $('#individual-table').dataTable().fnDestroy();

    var table = $('#individual-table').dataTable({
//        dom: 'frtip',
        responsive: true,
        processing: true,
        serverSide: true,
        info: false,
        paging: false,
        order: [],
        sScrollX: "100%",
        scrollY: "250px",
        ajax: {
            url: BASE_URL + "MembersMgmt/fetchRecipient_All",
            type: "POST",
            data: {noticerefno: noticerefno[0], membercardno: membercardnox},

        },
        createdRow: function (row, datax, dataIndex) {

            for (var i = 0; i < membercardno.length; i++) {
                if (membercardno[i] == datax[0])
                {
//                    $(row).addClass('selected', true);
//                    $(row).css('background-color','red');
                    $(row).hide();
//                    table.$('tr.selected').removeClass('selected');
//                    $(this).addClass('selected');
                }
            }
        },
        initComplete: function (settings, json) {

            $("#numrows").html(json['recordsTotal']);

//            table.row('.selected').remove().draw(false);
//            $("#individual-table").find("tr.selected").remove();
//            rowcount = $('#all-table tbody tr').length - 1;
//
//        alert(json['totalrow']);
        }
    });
    $('#individual-table_filter input').unbind();
    $('#individual-table_filter input').bind('keyup', function (e) {
        if (e.keyCode == 13) {
            table.fnFilter(this.value);
        }
    });
//     var tablex = $('#all-table').DataTable();
//    tablex.rows('.selected').remove().draw();
//     
}

function addRecipientInfo(membercardno, name, address, cityadd, cellphone, emailadd, zone) {

    var modalTitle = $("#modalTitle").html();
    var modalTitle = $("#modalTitle").html().split(":");
    var noticerefno = modalTitle[0];
    var subject = modalTitle[1];
    var txtnoticedatetimeR = $("#txtnoticedatetimeR").val();
    var txtnoticeplaceR = $("#txtnoticeplaceR").val();
    var txtnoticeagendaR = $("#txtnoticeagendaR").val();
    var txttemplate = $("#txttemplate").val();
    var addressx = address + " " + cityadd;
    var txtregistrationtimeR = $("#txtregistrationtimeR").val();
    var txtnoticecontactpersonR = $("#txtnoticecontactpersonR").val();
    var txtnoticecontactnumberR = $("#txtnoticecontactnumberR").val();
    var txtnoticereasonofcancellationR = $("#txtnoticereasonofcancellationR").val();




    $.ajax({
        type: 'POST',
        url: BASE_URL + "MembersMgmt/saveRecipient",
        data: {referenceno: noticerefno, template: txttemplate, subject: subject, meetingdate: txtnoticedatetimeR, location: txtnoticeplaceR,
            agenda: txtnoticeagendaR, cardno: membercardno, name: name, address: addressx, emailadd: emailadd, mobileno: cellphone, zone: zone,
            registrationtime: txtregistrationtimeR, contactperson: txtnoticecontactpersonR, contactno: txtnoticecontactnumberR,
            reasonofcancellation: txtnoticereasonofcancellationR},
        dataType: 'json'
    }).done(function (data) {
        if (data.status) {
            fetchFinalRecipient();
//            fetchRecipient_All();
//            submitStaffingPattern(professiondesignation);
        } else {
            swal("Unsuccessful!", "Error in saving! Please try again.", "error");
        }
    });
}

function deleteRecipientInfo(id) {
    $.ajax({
        type: 'POST',
        url: BASE_URL + "MembersMgmt/removeFinalRecipient",
        data: {id: id},
        dataType: 'json'
    }).done(function (data) {
        if (data.status) {
            fetchFinalRecipient();
            fetchRecipient_All();
//            submitStaffingPattern(professiondesignation);
        } else {
            swal("Unsuccessful!", "Error in deleting! Please try again.", "error");
        }
    });
}

function changeAnnouncementTemplate() {
    //Clear all the error fields
    clearErrorField('txtnoticerefnoerror', 'txtnoticerefno');
    clearErrorField('txtnoticesubjecterror', 'txtnoticesubject');
    clearErrorField('txtnoticedateerror', 'txtnoticedate');
    clearErrorField('txtregistrationtimeerror', 'txtregistrationtime');
    clearErrorField('txtnoticetimeerror', 'txtnoticetime');
    clearErrorField('txtnoticeplaceerror', 'txtnoticeplace');
    clearErrorField('txtnoticeagendaerror', 'txtnoticeagenda');
    clearErrorField('txtnoticecontactpersonerror', 'txtnoticecontactperson');
    clearErrorField('txtnoticecontactnumbererror', 'txtnoticecontactnumber');
    clearErrorField('txtnoticereasonofcancellationerror', 'txtnoticereasonofcancellation');

    if ($('#announcement_temp').val() == 'Annual') {
        $('#templatex').attr('src', BASE_URL + 'MembersMgmt/generate_announcement');
        $('#txtnoticecontactpersondiv').addClass('hidden');
        $('#txtnoticecontactnumberdiv').addClass('hidden');
        $('#txtnoticereasonofcancellationdiv').addClass('hidden');
        $('#txtregistrationtimediv').removeClass('hidden');
        $('#txtnoticeagendadiv').addClass('hidden');
        $('#txtnoticeplacediv').removeClass('hidden');
        $('#txtnoticetimediv').removeClass('hidden');
    } else if ($('#announcement_temp').val() == 'BM') {
        $('#templatex').attr('src', BASE_URL + 'MembersMgmt/GenerateBoardMeetingAnnouncement');
        $('#txtnoticecontactpersondiv').addClass('hidden');
        $('#txtnoticecontactnumberdiv').addClass('hidden');
        $('#txtnoticereasonofcancellationdiv').addClass('hidden');
        $('#txtregistrationtimediv').addClass('hidden');
        $('#txtnoticeagendadiv').removeClass('hidden');
        $('#txtnoticeplacediv').removeClass('hidden');
        $('#txtnoticetimediv').removeClass('hidden');
    } else {
        $('#templatex').attr('src', BASE_URL + 'MembersMgmt/generate_cancellation_anouncement');
        $('#txtnoticecontactpersondiv').removeClass('hidden');
        $('#txtnoticecontactnumberdiv').removeClass('hidden');
        $('#txtnoticereasonofcancellationdiv').removeClass('hidden');
        $('#txtregistrationtimediv').addClass('hidden');
        $('#txtnoticeagendadiv').addClass('hidden');
        $('#txtnoticeplacediv').addClass('hidden');
        $('#txtnoticetimediv').addClass('hidden');
    }
}

function sendAnnouncement() {
    $.ajax({
        type: 'POST',
        url: BASE_URL + "User/Testing_send",
        dataType: 'json'
    });
}

function checkSupervisorAccountToProceedSending(type) {
    var txtTemplate = $('#txttemplate').val();
    var username = $('#supervisorusername').val();
    var password = $('#supervisorpassword').val();
    $.ajax({
        type: 'POST',
        data: {
            username: username,
            password: password
        },
        dataType: 'json',
        url: BASE_URL + 'MembersMgmt/CheckSupervisorAccount'
    }).done(function (result) {
        if (result) {

            if (type == 'txtmessage') {
                if (txtTemplate == 'Annual') {
                    sendTextMessage('MembersMgmt/SendAnnualMeetingTextMessage');
                } else if (txtTemplate == 'BM') {
                    sendTextMessage('MembersMgmt/SendBoardMeetingTextMessage');
                } else {
                    sendTextMessage('MembersMgmt/SendMeetingCancellationTextMessage');
                }
            } else {
                if (txtTemplate == 'Annual') {
                    sendMeeting('MembersMgmt/SendAnnualMeetingEmail');
                } else if (txtTemplate == 'BM') {
                    sendMeeting('MembersMgmt/SendBoardMeetingEmail');
                } else {
                    sendMeeting('MembersMgmt/SendMeetingCancellationEmail');
                }
            }

        } else {
            swal({
                title: "Error!",
                text: "Incorrect Username/Password",
                type: "error",
                allowOutsideClick: false
            });
        }
    });
}

function sendTextMessage(url) {

    var noticeRefNo = $('#txtnoticerefno').val();
    var noticeSubject = $('#txtnoticesubject').val();
    var noticeDate = $('#txtnoticedate').val();
    var noticeTime = $('#txtnoticetime').val();
    var noticePlace = $('#txtnoticeplace').val();
    var noticeAgenda = $('#txtnoticeagenda').val();
    var registrationTime = $('#txtregistrationtime').val();
    var noticeContactPerson = $('#txtnoticecontactperson').val();
    var noticeContactNumber = $('#txtnoticecontactnumber').val();
    var noticeReasonOfCancellation = $('#txtnoticereasonofcancellation').val();

    swal({
        title: 'Sending message please wait.',
        text: 'This may take awhile, Please wait.',
        imageUrl: BASE_URL + "assets/img/medical_loading.gif",
        imageSize: '300x200',
        animation: false,
        showConfirmButton: false,
        allowOutsideClick: false
    });

    $.ajax({
        type: 'POST',
        data: {
            noticeRefNo: noticeRefNo,
            noticeSubject: noticeSubject,
            noticeDate: noticeDate,
            noticeTime: noticeTime,
            noticePlace: noticePlace,
            noticeAgenda: noticeAgenda,
            registrationTime: registrationTime,
            noticeContactPerson: noticeContactPerson,
            noticeContactNumber: noticeContactNumber,
            noticeReasonOfCancellation: noticeReasonOfCancellation
        },
        dataType: 'json',
        url: BASE_URL + url
    }).done(function (result) {
        if (result.errors == 'messagelengtherror') {
            swal({title: "Information", text: "Message is too long, please make it short (160 letters only).", type: "error"});
        } else {
            if (result.status == false) {
                checkFieldValidations(result.errors.txtnoticerefno, 'txtnoticerefnoerror', 'txtnoticerefno');
                checkFieldValidations(result.errors.txtnoticesubject, 'txtnoticesubjecterror', 'txtnoticesubject');
                checkFieldValidations(result.errors.txtnoticedate, 'txtnoticedateerror', 'txtnoticedate');
                if (result.meetingtype == 'Annual') {
                    checkFieldValidations(result.errors.txtnoticetime, 'txtnoticetimeerror', 'txtnoticetime');
                    checkFieldValidations(result.errors.txtnoticeplace, 'txtnoticeplaceerror', 'txtnoticeplace');
                    checkFieldValidations(result.errors.txtregistrationtime, 'txtregistrationtimeerror', 'txtregistrationtime');
                } else if (result.meetingtype == 'BM') {
                    checkFieldValidations(result.errors.txtnoticetime, 'txtnoticetimeerror', 'txtnoticetime');
                    checkFieldValidations(result.errors.txtnoticeplace, 'txtnoticeplaceerror', 'txtnoticeplace');
                    checkFieldValidations(result.errors.txtnoticeagenda, 'txtnoticeagendaerror', 'txtnoticeagenda');
                } else if (result.meetingtype == 'MC') {
                    checkFieldValidations(result.errors.txtnoticecontactperson, 'txtnoticecontactpersonerror', 'txtnoticecontactperson');
                    checkFieldValidations(result.errors.txtnoticecontactnumber, 'txtnoticecontactnumbererror', 'txtnoticecontactnumber');
                    checkFieldValidations(result.errors.txtnoticereasonofcancellation, 'txtnoticereasonofcancellationerror', 'txtnoticereasonofcancellation');
                }

                swal({
                    title: "Information!",
                    text: "Ops! Something is wrong with your inputs. Please check again the fields!",
                    type: "error",
                    allowOutsideClick: false

                });
            } else {
                swal({title: "Success", text: "Message successfully sent.", type: "success"},
                        function ()
                        {
                            location.reload();
                        });

            }
        }
    });

}

function validateRecipients() {
    var noticeRefNo = $('#txtnoticerefno').val();
    $.ajax({
        type: 'POST',
        data: {
            noticeRefNo: noticeRefNo
        },
        dataType: 'json',
        url: BASE_URL + 'MembersMgmt/GetAllRecipients'
    }).done(function (result) {

        if (result.recipientserror == true) {
            swal({
                title: "Information!",
                text: "Ops! No recipients added. Please add recipients to proceed!",
                type: "error",
                allowOutsideClick: false

            });
        } else {
            $('#inputsupervisoraccountmodal').modal('show');
        }
    });
}

function sendMeeting(url) {
    var sendMailIsChecked = false;

    if ($('#sendmailtocc').prop("checked") == true) {
        sendMailIsChecked = true;
    } else if ($('#sendmailtocc').prop("checked") == false) {
        sendMailIsChecked = false;
    }

    var noticeRefNo = $('#txtnoticerefno').val();
    var noticeSubject = $('#txtnoticesubject').val();
    var noticeDate = $('#txtnoticedate').val();
    var noticeTime = $('#txtnoticetime').val();
    var noticePlace = $('#txtnoticeplace').val();
    var noticeAgenda = $('#txtnoticeagenda').val();
    var registrationTime = $('#txtregistrationtime').val();
    var noticeContactPerson = $('#txtnoticecontactperson').val();
    var noticeContactNumber = $('#txtnoticecontactnumber').val();
    var noticeReasonOfCancellation = $('#txtnoticereasonofcancellation').val();

    swal({
        title: 'Sending email please wait.',
        text: 'This may take awhile, Please wait.',
        imageUrl: BASE_URL + "assets/img/medical_loading.gif",
        imageSize: '300x200',
        animation: false,
        showConfirmButton: false,
        allowOutsideClick: false
    });

    $.ajax({
        type: 'POST',
        data: {
            noticeRefNo: noticeRefNo,
            noticeSubject: noticeSubject,
            noticeDate: noticeDate,
            noticeTime: noticeTime,
            noticePlace: noticePlace,
            noticeAgenda: noticeAgenda,
            registrationTime: registrationTime,
            noticeContactPerson: noticeContactPerson,
            noticeContactNumber: noticeContactNumber,
            noticeReasonOfCancellation: noticeReasonOfCancellation,
            sendMailIsChecked: sendMailIsChecked
        },
        dataType: 'json',
        url: BASE_URL + url
    }).done(function (result) {

        if (result.status == true) {
            swal({
                title: "Success!",
                text: "Email successfully sent! Thank you",
                type: "success",
                allowOutsideClick: false

            }, function () {
                location.reload();
            });
        } else if (result.status == false) {
            checkFieldValidations(result.errors.txtnoticerefno, 'txtnoticerefnoerror', 'txtnoticerefno');
            checkFieldValidations(result.errors.txtnoticesubject, 'txtnoticesubjecterror', 'txtnoticesubject');
            checkFieldValidations(result.errors.txtnoticedate, 'txtnoticedateerror', 'txtnoticedate');
            if (result.meetingtype == 'Annual') {
                checkFieldValidations(result.errors.txtnoticetime, 'txtnoticetimeerror', 'txtnoticetime');
                checkFieldValidations(result.errors.txtnoticeplace, 'txtnoticeplaceerror', 'txtnoticeplace');
                checkFieldValidations(result.errors.txtregistrationtime, 'txtregistrationtimeerror', 'txtregistrationtime');
            } else if (result.meetingtype == 'BM') {
                checkFieldValidations(result.errors.txtnoticetime, 'txtnoticetimeerror', 'txtnoticetime');
                checkFieldValidations(result.errors.txtnoticeplace, 'txtnoticeplaceerror', 'txtnoticeplace');
                checkFieldValidations(result.errors.txtnoticeagenda, 'txtnoticeagendaerror', 'txtnoticeagenda');
            } else if (result.meetingtype == 'MC') {
                checkFieldValidations(result.errors.txtnoticecontactperson, 'txtnoticecontactpersonerror', 'txtnoticecontactperson');
                checkFieldValidations(result.errors.txtnoticecontactnumber, 'txtnoticecontactnumbererror', 'txtnoticecontactnumber');
                checkFieldValidations(result.errors.txtnoticereasonofcancellation, 'txtnoticereasonofcancellationerror', 'txtnoticereasonofcancellation');
            }

            swal({
                title: "Information!",
                text: "Ops! Something is wrong with your inputs. Please check again the fields!",
                type: "error",
                allowOutsideClick: false

            });
        } else if (result.recipientserror == true) {
            swal({
                title: "Information!",
                text: "Ops! No recipients added. Please add recipients to proceed!",
                type: "error",
                allowOutsideClick: false

            });
        }
    });
}

function cmbAddrecipient() {
    var cmbAddrecipient = $('#cmbaddRecipient').val();
    if (cmbAddrecipient == "ALL") {
        $('#all').addClass('hidden', true);
        $('#Barangay').addClass('hidden', true);
        $('#AreaZone').addClass('hidden', true);
        $('#individual').removeClass('hidden', true);
//        fetchFinalRecipient();
        AddAllMembers();
    } else if (cmbAddrecipient == "Barangay") {
        $('#all').addClass('hidden', true);
        $('#Barangay').removeClass('hidden', true);
        $('#AreaZone').addClass('hidden', true);
        $('#individual').addClass('hidden', true);
        fetchFinalRecipient();
    } else if (cmbAddrecipient == "AreaZone") {
        $('#all').addClass('hidden', true);
        $('#Barangay').addClass('hidden', true);
        $('#AreaZone').removeClass('hidden', true);
        $('#individual').addClass('hidden', true);
        fetchFinalRecipient();
    } else {
        $('#all').addClass('hidden', true);
        $('#Barangay').addClass('hidden', true);
        $('#AreaZone').addClass('hidden', true);
        $('#individual').removeClass('hidden', true);
        fetchFinalRecipient();
    }
}

function fetchAreaZone() {
    var modalTitle = $("#modalTitle").html();
    var noticerefno = modalTitle.split(":");
    $('#AreaZone-table').dataTable().fnDestroy();
    var table = $('#AreaZone-table').dataTable({
//        dom: 'frti',
        responsive: true,
        processing: true,
        serverSide: true,
        paging: false,
        info: false,
        lengthChange: false,
        order: [],
        sScrollX: "100%",
        scrollY: "250px",
        ajax: {
            url: BASE_URL + "MembersMgmt/fetchAreaZone",
            type: "POST",
        },
        createdRow: function (row, datax, dataIndex) {},
        initComplete: function (settings, json) {
            $("#numrowsAreaZone").html(json['recordsTotal']);
        }
    });
    $('#AreaZone-table_filter input').unbind();
    $('#AreaZone-table_filter input').bind('keyup', function (e) {
        if (e.keyCode == 13) {
            table.fnFilter(this.value);
        }
    });
}

function addRecipient_AreaZone(zone) {
    $.ajax({
        type: 'POST',
        url: BASE_URL + "MembersMgmt/getRecipientPerAreaZone",
        data: {zone: zone},
        dataType: 'json'
    }).done(function (data) {
        if (data.status) {
            for (var i = 0; i < data.getRecipientPerAreaZone.length; i++) {
                addRecipientInfo(data.getRecipientPerAreaZone[i]['membercardno'],
                        data.getRecipientPerAreaZone[i]['name'],
                        data.getRecipientPerAreaZone[i]['address'],
                        data.getRecipientPerAreaZone[i]['cityadd'],
                        data.getRecipientPerAreaZone[i]['cellphone'],
                        data.getRecipientPerAreaZone[i]['emailadd'],
                        data.getRecipientPerAreaZone[i]['zone']);
            }
            fetchFinalRecipient();
            swal('Success', 'Zone ' + zone + " is selected successfully", 'success');
//            fetchRecipient_All();
//            submitStaffingPattern(professiondesignation);
        } else {
            swal("Unsuccessful!", "Error in saving! Please try again.", "error");
        }
    });
}

function AddAllMembers() {
    swal({
        title: "Select All Members?",
        text: "This may take a while.",
        imageUrl: BASE_URL + "assets/img/select.png",
        showCancelButton: true,
        confirmButtonColor: "#5cb85c",
        confirmButtonText: "YES",
        cancelButtonText: "No",
        closeOnConfirm: false,
        closeOnCancel: true,
        allowEnterKey: false,
    }, function (isConfirm) {
        if (isConfirm) {
            $.ajax({
                type: 'POST',
                url: BASE_URL + "MembersMgmt/AddAllMembers",
                dataType: 'json'
            }).done(function (data) {
                if (data.status) {
                    for (var i = 0; i < data.AddAllMembers.length; i++) {
                        addRecipientInfo(data.AddAllMembers[i]['membercardno'],
                                data.AddAllMembers[i]['name'],
                                data.AddAllMembers[i]['address'],
                                data.AddAllMembers[i]['cityadd'],
                                data.AddAllMembers[i]['cellphone'],
                                data.AddAllMembers[i]['emailadd'],
                                data.AddAllMembers[i]['zone']);
                    }
                    fetchFinalRecipient();
                    swal('Success', 'All members are selected successfully', 'success');
                } else {
                    swal("Unsuccessful!", "Error in saving! Please try again.", "error");
                }
            });

            var xhr = new XMLHttpRequest();
            if (xhr.status < 200)
            {
                swal({
                    title: "Sending Text Message...",
                    text: "Please wait! We are still sending the message.Thank you!",
                    imageUrl: BASE_URL + "assets/img/medical_loading.gif",
                    showCancelButton: false,
                    showConfirmButton: false
                })
            }
        } else {
            swal.close();
//                        
        }
    });

//    
}

function saveZone() {
    $.ajax({
        type: 'POST',
        url: BASE_URL + "MembersMgmt/SavedZone",
        data: {zone: $('#txtZone').val(),
            desc: $('#txtZoneDesc').val()},
        dataType: 'json'
    }).done(function (data) {
        if (data.status == true) {
            swal('Saved', "Successfully Saved", 'success');
            fetchZoneList();
            $('#txtZone').val('');
            $('#txtZoneDesc').val('');
        } else {
            swal("Unsuccessful!", "Error in saving! Please try again.", "error");
        }
    });
}
function deleteZone(id) {
    $.ajax({
        type: 'POST',
        url: BASE_URL + "MembersMgmt/DeleteZone",
        data: {id: id},
        dataType: 'json'
    }).done(function (data) {
        if (data.status) {
            swal('Deleted', "Successfully Deleted", 'success');
            fetchZoneList();
        } else {
            swal("Unsuccessful!", "Error in deleting! Please try again.", "error");
        }
    });
}
function deleteMember(id) {
    $.ajax({
        type: 'POST',
        url: BASE_URL + "MembersMgmt/DeleteMember",
        data: {id: id},
        dataType: 'json'
    }).done(function (data) {
        if (data.status) {
            swal('Deleted', "Successfully Deleted", 'success');
            fetchMembersList();
        } else {
            swal("Unsuccessful!", "Error in deleting! Please try again.", "error");
        }
    });
}
function editZone(id, zone, desc) {
    $('#txtZone').val(zone);
    $('#txtid').val(id);
    $('#txtZoneDesc').val(desc);
    $('#btn_zone_update').removeClass('hidden');
    $('#btn_zone_update').addClass('show');
    $('#btn_zone_save').addClass('hidden');

}

function editMember(id, pin, cardno, name, stocks, value, membershipdate, bday, sex, address, city, mobileno, emailadd, zone) {
    $('#edit_member_modal').modal('show');
    $('#txtid').val(id);
    $('#txtpin').val(pin);
    $('#txtcardno').val(cardno);
    $('#txtdate').val(membershipdate);
    $('#txtname').val(name);
    $('#txtemail').val(emailadd);
    $('#txtbday').val(bday);
    $('#gender').val(sex);
    $('#txtAddress').val(address);
    $('#txtmobileno').val(mobileno);
    $('#txtzone').val(zone);
    $('#txtstocks').val(stocks);
    $('#txtvalues').val(value   );
   
  
    fetchListOfZone();

}
function openZoneList(){
        $('#zonedivlist').removeAttr('hidden', true);
        selectZone();
}



function selectZone() {
    $('#zonelisttable tbody').on('click', 'tr', function () {
        if ($(this).hasClass('bg-blue')) {
            $(this).removeClass('bg-blue');

        } else {
            $('#zonelisttable').dataTable().$('tr.bg-blue').removeClass('bg-blue');
            $(this).addClass('bg-blue');

            var data = $('#zonelisttable').DataTable().row('.bg-blue').data();
                 $('#txtzone').val(data[0]);
                  $('#zonedivlist').attr('hidden', true);
   
        }
    });

}


function saveMemberChnages() {

    $.ajax({
        type: 'POST',
        url: BASE_URL + "MembersMgmt/EditMember",
        data: $('#member-form').serialize(),
        dataType: 'json'
    }).done(function (data) {
        if (data.status) {
            swal('Updated', "Successfully Updated", 'success');
             $('#edit_member_modal').modal('hide'); 
             fetchMembersList();
    } else {
            swal("Unsuccessful!", "Error in updating! Please try again.", "error");
        }
    });
}


function saveZoneChanges() {

    $.ajax({
        type: 'POST',
        url: BASE_URL + "MembersMgmt/EditZone",
        data: {
            id: $('#txtid').val(),
            zone: $('#txtZone').val(),
            desc: $('#txtZoneDesc').val()
        },
        dataType: 'json'
    }).done(function (data) {
        if (data.status) {
            swal('Updated', "Successfully Updated", 'success');
            $('#btn_zone_update').removeClass('show');
            $('#btn_zone_update').addClass('hidden');
            $('#btn_zone_save').removeClass('hidden');
            $('#btn_zone_save').addClass('show');
            fetchZoneList();
            $('#txtZone').val('');
            $('#txtZoneDesc').val('');
        } else {
            swal("Unsuccessful!", "Error in updating! Please try again.", "error");
        }
    });
}

function fetchAllAnnouncements() {

    $('#announcements-list-table').dataTable().fnDestroy();
    var table = $('#announcements-list-table').dataTable({
//        dom: 'frti',
        responsive: true,
        processing: true,
        serverSide: true,
//        paging: false,
        info: true,
        pageLength: 10,
//        lengthChange: false,
        columnDefs: [
            {
                targets: [8],
                visible: false
            }
        ],
        order: [],
        sScrollX: true,
        ajax: {
            url: BASE_URL + "MembersMgmt/fetchAllAnnouncements",
            type: "POST",
        },
        createdRow: function (row, datax, dataIndex) {
            if (datax[8] == 1)
            {
                $(row).css('background', 'linear-gradient(to right, #ff8b8e 0%, #ffffff 116%)');
            }
        },
        initComplete: function (settings, json) {}
    });
    $('#announcements-list-table_filter input').unbind();
    $('#announcements-list-table_filter input').bind('keyup', function (e) {
        if (e.keyCode == 13) {
            table.fnFilter(this.value);
        }
    });
}

function setInactive(referenceno) {
    swal({
        title: "Set this announcement to Inactive?",
        text: "You can no longer edit this announcement",
        imageUrl: BASE_URL + "assets/img/inactive.jpg",
        showCancelButton: true,
        confirmButtonColor: "#5cb85c",
        confirmButtonText: "YES",
        cancelButtonText: "No",
        closeOnConfirm: false,
        closeOnCancel: true,
        allowEnterKey: false,
    }, function (isConfirm) {
        if (isConfirm) {
            $.ajax({
                type: 'POST',
                url: BASE_URL + "MembersMgmt/setInactive",
                data: {referenceno: referenceno},
                dataType: 'json'
            }).done(function (data) {
                if (data.status) {

                    fetchAllAnnouncements();
                    swal('Success', 'This announcement is already set to INACTIVE', 'success');
                } else {
                    swal("Unsuccessful!", "Error in saving! Please try again.", "error");
                }
            });

        } else {
            swal.close();
//                        
        }
    });
}

function viewDetails(referenceno, status) {
//    alert(status);
    $("#all-announcements").removeClass('active', true);
    $("#send-announcements").addClass('active', true);
    $("#home_with_icon_title").removeClass('in active', true);
    $("#profile_with_icon_title").addClass('in active', true);
    $("#txtnoticerefno").attr('readonly', true);
    if (status == 1) {
        $("#txtnoticesubject").attr('readonly', true);
        $("#txtnoticedate").attr('readonly', true);
        $("#txtnoticeplace").attr('readonly', true);
        $("#txtnoticeagenda").attr('readonly', true);
        $("#addrecipient").addClass('hidden', true);
        $("#txtnoticetime").attr('readonly', true);
        $("#txtregistrationtime").attr('readonly', true);
        $('#txtnoticecontactperson').attr('readonly', true);
        $('#txtnoticecontactnumber').attr('readonly', true);
        $('#txtnoticereasonofcancellation').attr('readonly', true);
        //        
        $("#viewrecipient").removeClass('hidden', true);
        $("#btnSave").addClass('hidden', true);
        $("#announcement_temp").prop('disabled', true);
        $("#toggleUpdate").addClass('hidden', true);
    } else {
        $("#txtnoticesubject").removeAttr('readonly', true);
        $("#txtnoticedate").removeAttr('readonly', true);
        $("#txtnoticeplace").removeAttr('readonly', true);
        $("#txtnoticeagenda").removeAttr('readonly', true);
        $("#addrecipient").removeClass('hidden', true);
        $("#txtnoticetime").removeAttr('readonly', true);
        $("#txtregistrationtime").removeAttr('readonly', true);
        $('#txtnoticecontactperson').removeAttr('readonly', true);
        $('#txtnoticecontactnumber').removeAttr('readonly', true);
        $('#txtnoticereasonofcancellation').removeAttr('readonly', true);

        $("#viewrecipient").addClass('hidden', true);
        $("#addrecipient").attr('onclick', 'addRecipient()');
        $("#btnSave").removeClass('hidden', true);
        $("#announcement_temp").removeAttr('disabled', true);
        $("#toggleUpdate").removeClass('hidden', true);
    }

    $.ajax({
        type: 'POST',
        url: BASE_URL + "MembersMgmt/viewDetailsByReferenceNo",
        data: {referenceno: referenceno},
        dataType: 'json'
    }).done(function (data) {
        if (data.status == true) {
//            $(".switch").addClass('hidden',true);
            $("#announcement_temp").val(data.viewDetailsByReferenceNo['template']).trigger('change');
            $("#txtnoticerefno").val(data.viewDetailsByReferenceNo['referenceno']);
            $("#txtnoticesubject").val(data.viewDetailsByReferenceNo['subject']);
            var meetingdate = data.viewDetailsByReferenceNo['meetingdate'].split(" ");
            var meetingtime = meetingdate[1].split(":");
            $("#txtnoticedate").val(meetingdate[0]);
            $("#txtnoticetime").val(meetingtime[0] + ":" + meetingtime[1]);
            $("#txtnoticeplace").val(data.viewDetailsByReferenceNo['location']);


            if (data.viewDetailsByReferenceNo['template'] === "Annual") {
                var registrationtime = data.viewDetailsByReferenceNo['registrationtime'].split(":");
                $("#txtregistrationtime").val(registrationtime[0] + ":" + registrationtime[1]);
                $("#txtnoticeplace").val(data.viewDetailsByReferenceNo['location']);
            }
//
            if (data.viewDetailsByReferenceNo['template'] === "BM") {
                $("#txtnoticeagenda").val(data.viewDetailsByReferenceNo['agenda']);
                $("#txtnoticeplace").val(data.viewDetailsByReferenceNo['location']);
            }
//
            if (data.viewDetailsByReferenceNo['template'] === "MC") {
                $('#txtnoticecontactperson').val(data.viewDetailsByReferenceNo['contactperson']);
                $('#txtnoticecontactnumber').val(data.viewDetailsByReferenceNo['contactno']);
                $('#txtnoticereasonofcancellation').val(data.viewDetailsByReferenceNo['reasonofcancellation']);
            }


//           

        } else {
            swal("Unsuccessful!", "Error in updating! Please try again.", "error");
        }
    });
}
/**
 * Check every field if the inputs are correct.
 * @param {type} resultError = error result from the controller
 * @param {type} errorfield = error na field
 * @param {type} field = specified input field
 * @version 2019-01-29
 * @author LJ Roa
 */
function checkFieldValidations(resultError, errorfield, field) {
    if (resultError != '') { //If has error
        $('#' + errorfield).empty();
        $('#' + errorfield).append(resultError).removeAttr('hidden');
        $('#' + field).css('border-color', 'red');
    } else { //if no errors
        $('#' + errorfield).attr('hidden', true);
        $('#' + field).removeAttr('style');
        $('#txtnoticeagenda').css('width', '100%');
        $('#txtnoticeplace').css('width', '100%');
        $('#txtnoticereasonofcancellation').css('width', '100%');
    }
}

function clearErrorField(errorfield, field) {
    $('#' + errorfield).attr('hidden', true);
    $('#' + field).removeAttr('style');
    $('#txtnoticeagenda').css('width', '100%');
    $('#txtnoticeplace').css('width', '100%');
    $('#txtnoticereasonofcancellation').css('width', '100%');
}

function viewRecipient() {
    var txtnoticesubject = $("#txtnoticesubject").val();
    var txtnoticerefno = $("#txtnoticerefno").val();

    $("#modalTitlex").html(txtnoticerefno + ": " + txtnoticesubject);

    $("#membernoticeviewecipient").modal('show');
    fetchFinalRecipientforViewing();
}


function fetchFinalRecipientforViewing() {
    var modalTitle = $("#modalTitlex").html();
    var noticerefno = modalTitle.split(":");
    $('#view-finalrecipient-table').dataTable().fnDestroy();
    var table = $('#view-finalrecipient-table').dataTable({
//        dom: 'frti',
        responsive: true,
        processing: true,
        serverSide: true,
        paging: true,
        info: true,

        order: [],
//        sScrollX: true,
        columnDefs: [
            {
                targets: [0, 7],
                visible: false
            }
        ],
        ajax: {
            url: BASE_URL + "MembersMgmt/fetchFinalRecipients",
            type: "POST",
            data: {noticerefno: noticerefno[0]}
        },
        createdRow: function (row, datax, dataIndex) {
            if (datax[7] !== 1)
            {
                $(row).css('background', 'linear-gradient(to right, #ff8b8e 0%, #ffffff 116%)');
            }
        },
        initComplete: function (settings, json) {}
    });
    $('#view-finalrecipient-table_filter input').unbind();
    $('#view-finalrecipient-table_filter input').bind('keyup', function (e) {
        if (e.keyCode == 13) {
            table.fnFilter(this.value);
        }
    });
}

function clickAllAnnouncements() {
    location.reload();
}

function checkAnnouncementIfExists(type) {
    var error = 0;
    var announcement_temp = $("#announcement_temp").val();
    var txtnoticesubject = $("#txtnoticesubject").val();
    var txtnoticedate = $("#txtnoticedate").val();
    var txtnoticetime = $("#txtnoticetime").val();
    var meetingdate = txtnoticedate + " " + txtnoticetime;
    var txtregistrationtime = $("#txtregistrationtime").val();
    var txtnoticeplace = $("#txtnoticeplace").val();
    var txtnoticeagenda = $("#txtnoticeagenda").val();
    var txtnoticecontactperson = $("#txtnoticecontactperson").val();
    var txtnoticecontactnumber = $("#txtnoticecontactnumber").val();
    var txtnoticereasonofcancellation = $("#txtnoticereasonofcancellation").val();
    var txtnoticerefno = $("#txtnoticerefno").val();

    if (txtnoticerefno === "") {
        $("#txtnoticerefno").attr('style', 'border:solid red');
        error++;
    } else {
        $("#txtnoticerefno").removeAttr('style', true);
    }
    if (txtnoticedate === "") {
        $("#txtnoticedate").attr('style', 'border:solid red');
        error++;
    } else {
        $("#txtnoticedate").removeAttr('style', true);
    }
    if (txtnoticesubject === "") {
        $("#txtnoticesubject").attr('style', 'border:solid red');
        error++;
    } else {
        $("#txtnoticesubject").removeAttr('style', true);
    }
    if (txtnoticetime === "") {
        $("#txtnoticetime").attr('style', 'border:solid red');
        error++;
    } else {
        $("#txtnoticetime").removeAttr('style', true);
    }


    if (announcement_temp === "Annual") {
        if (txtregistrationtime === "") {
            $("#txtregistrationtime").attr('style', 'border:solid red');
            error++;
        } else {
            $("#txtregistrationtime").removeAttr('style', true);
        }

        if (txtnoticeplace === "") {
            $("#txtnoticeplace").attr('style', 'border:solid red');
            error++;
        } else {
            $("#txtnoticeplace").removeAttr('style', true);
        }
    }
    if (announcement_temp === "BM") {
        if (txtnoticeplace === "") {
            $("#txtnoticeplace").attr('style', 'border:solid red');
            error++;
        } else {
            $("#txtnoticeplace").removeAttr('style', true);
        }

        if (txtnoticeagenda === "") {
            $("#txtnoticeagenda").attr('style', 'border:solid red');
            error++;
        } else {
            $("#txtnoticeagenda").removeAttr('style', true);
        }
    }
    if (announcement_temp === "MC") {
        if (txtnoticecontactperson === "") {
            $("#txtnoticecontactperson").attr('style', 'border:solid red');
            error++;
        } else {
            $("#txtnoticecontactperson").removeAttr('style', true);
        }

        if (txtnoticecontactnumber === "") {
            $("#txtnoticecontactnumber").attr('style', 'border:solid red');
            error++;
        } else {
            $("#txtnoticecontactnumber").removeAttr('style', true);
        }

        if (txtnoticereasonofcancellation === "") {
            $("#txtnoticereasonofcancellation").attr('style', 'border:solid red');
            error++;
        } else {
            $("#txtnoticereasonofcancellation").removeAttr('style', true);
        }
    }

    if (error === 0) {
        $.ajax({
            type: 'POST',
            url: BASE_URL + "MembersMgmt/viewDetailsByReferenceNo",
            data: {referenceno: txtnoticerefno},
            dataType: 'json'
        }).done(function (data) {
            if (data.status) {
                swal('Duplicate Reference Number', 'Reference Number is already used. Please input another.', 'error');
            } else {
                if (type === 2) {
                    saveAnnouncement();
                } else {
                    addRecipient();
                }
            }
        });
    }
}

function saveAnnouncement() {
    var announcement_temp = $("#announcement_temp").val();
    var txtnoticerefno = $("#txtnoticerefno").val();
    var txtnoticesubject = $("#txtnoticesubject").val();
    var txtnoticedate = $("#txtnoticedate").val();
    var txtnoticetime = $("#txtnoticetime").val();
    var meetingdate = txtnoticedate + " " + txtnoticetime;
    var txtregistrationtime = $("#txtregistrationtime").val();
    var txtnoticeplace = $("#txtnoticeplace").val();
    var txtnoticeagenda = $("#txtnoticeagenda").val();
    var txtnoticecontactperson = $("#txtnoticecontactperson").val();
    var txtnoticecontactnumber = $("#txtnoticecontactnumber").val();
    var txtnoticereasonofcancellation = $("#txtnoticereasonofcancellation").val();


    $.ajax({
        type: 'POST',
        url: BASE_URL + "MembersMgmt/saveAnnouncement",
        data: {referenceno: txtnoticerefno,
            template: announcement_temp,
            subject: txtnoticesubject,
            meetingdate: meetingdate,
            location: txtnoticeplace,
            agenda: txtnoticeagenda,
            registrationtime: txtregistrationtime,
            contactperson: txtnoticecontactperson,
            contactno: txtnoticecontactnumber,
            reasonofcancellation: txtnoticereasonofcancellation},
        dataType: 'json'
    }).done(function (data) {
        if (data.status) {
            swal('Success', 'Announcement is saved successfully', 'success');
//            fetchFinalRecipient();
//            fetchRecipient_All();
//            submitStaffingPattern(professiondesignation);
        } else {
            swal("Unsuccessful!", "Error in saving! Please try again.", "error");
        }
    });
}