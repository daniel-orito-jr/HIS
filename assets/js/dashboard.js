$(function () {
    unpreparedclaims();
    getPendingClaims();
    getSentClaims();
    getPHARoftheMonth();
    getAdmitDischargeDaily();
    getTotalAccPHICAR();
    getPaymentForTheMonth();
    getProfitLoss();
    fetchCostCenter();
    getExpenses();
    getPxType();
    getTotalIncome();
    loadingModal();
});

function loadingModal() {
    swal({
        title: "Please wait!",
        text: "Fetching of data is still ongoing.",
        imageUrl: BASE_URL + "assets/img/medical_loading.gif",
        imageSize: '300x200',
        showCancelButton: false,
        showConfirmButton: false
    });
    $(document).ajaxStop(function () {
        swal.close();
    });
}

var px_table = $('#px-table').DataTable({
    dom: 'frtip',
    responsive: true
});
//
//var c = $('#disad-table').dataTable({
//    dom : 't'
//});

var d = $('#census-table').dataTable({
    dom: 'tp',
    order: [[0, "desc"]]
//    columnDefs: [ 
//        {
//            orderable: false,
//            targets:   0,
//            width: "3%"
//        }
//    ]

});


var dashboard = {
    get_all_patients: function () {
        $('#philhealth-table').dataTable().fnDestroy();
        var table = $('#philhealth-table').dataTable({
            dom: 'frtip',
            processing: true,
            serverSide: true,
            responsive: true,
            order: [],
            ajax: {
                url: BASE_URL + "user/fetch_philhealth_patients",
                type: "POST",
                data: {
                    start_date: $('#search-pat-form input[name=start_date]').val(),
                    end_date: $('#search-pat-form input[name=end_date]').val()
                }
            }
        });

        $('#philhealth-table_filter input').unbind();
        $('#philhealth-table_filter input').bind('keyup', function (e) {
            if (e.keyCode == 13) {
                table.fnFilter(this.value);
            }
        });
    },

    show_patients: function (data) {

        $('#eachd-patients-form input[name=s_date]').val(data[0]);
        $('#eachd-info-table').dataTable().fnDestroy();
        var table = $('#eachd-info-table').dataTable({
            dom: 'frtip',
            responsive: true,
            processing: true,
            serverSide: true,
            order: [],
            ajax: {
                url: BASE_URL + "user/fetch_each_day_census",
                type: "POST",
                data: {
                    date: data[0]
                }
            }
        });
        $('#eachd-info-table_filter input').unbind();
        $('#eachd-info-table_filter input').bind('keyup', function (e) {
            if (e.keyCode === 13) {
                table.fnFilter(this.value);
            }
        });
    },

    phic: function (id) {

        $('#philhealthpatients').modal("show");

        if (id === 1)
        {
            $(".report-btn").show();
            $(".report-btns").hide();

            $('#ph').html("PHILHEALTH PATIENTS");

            $('#phic-info-table').dataTable().fnDestroy();
            var table = $('#phic-info-table').dataTable({
                dom: 'frtip',
                responsive: true,
                processing: true,
                serverSide: true,
                order: [],
                ajax: {
                    url: BASE_URL + "user/fetch_admitted_phic_day_patients",
                    type: "POST",

                }
            });
            $('#phic-info-table_filter input').unbind();
            $('#phic-info-table_filter input').bind('keyup', function (e) {
                if (e.keyCode === 13) {
                    table.fnFilter(this.value);
                }
            });
        } else
        {
            $(".report-btn").hide();
            $(".report-btns").show();
            $('#ph').html("NON-PHILHEALTH PATIENTS");
            $('#phic-info-table').dataTable().fnDestroy();
            var table = $('#phic-info-table').dataTable({
                dom: 'frtip',
                responsive: true,
                processing: true,
                serverSide: true,
                order: [],
                ajax: {
                    url: BASE_URL + "user/fetch_admitted_non_phic_day_patients",
                    type: "POST",

                }
            });
            $('#phic-info-table_filter input').unbind();
            $('#phic-info-table_filter input').bind('keyup', function (e) {
                if (e.keyCode === 13) {
                    table.fnFilter(this.value);
                }
            });
        }
    },

    totalpatients: function ()
    {

        $('#totalpatients').modal("show");
        $('#tpatient').html("TOTAL ADMITTED PATIENTS");
        $('#total-patient-info-table').dataTable().fnDestroy();
        var table = $('#total-patient-info-table').dataTable({
            dom: 'frtip',
            responsive: true,
            processing: true,
            serverSide: true,
            order: [],
            ajax: {
                url: BASE_URL + "user/fetch_total_admitted_day_patients",
                type: "POST",

            }
        });
        $('#total-patient-info-table_filter input').unbind();
        $('#total-patient-info-table_filter input').bind('keyup', function (e) {
            if (e.keyCode === 13) {
                table.fnFilter(this.value);
            }
        });
    },

    totalaccphicAR: function ()
    {
        $('#totalaccuphicar').modal("show");
        var datexx = $('#search-totalaccphicar-form input[name=start_date]').val();
        if (datexx == "")
        {
            var d = new Date(),
                    mm = (d.getMonth() < 10 ? '0' : '') + (d.getMonth() + 1);
            yy = d.getFullYear();
            $('#search-totalaccphicar-form input[name=start_date]').val(yy + "-" + mm);
            datexx = yy + "-" + mm;
        }

        $('#total-accumulated-PHICAR-table').dataTable().fnDestroy();
        var table = $('#total-accumulated-PHICAR-table').dataTable({
            dom: 'frtip',
//            responsive: true,
            processing: true,
            serverSide: true,
            order: [],
            ajax: {
                url: BASE_URL + "user/fetch_total_accumulated_PHICAR",
                type: "POST",
                data: {month: datexx}
            },
            initComplete: function (settings, json) {

//                alert(json["totalx"]["hcifee"]);
                $("#totalhospfee").html(accounting.format(json["totalx"]["hcifee"], 2));
                $("#totalproffee").html(accounting.format(json["totalx"]["profee"], 2));
//                $("#totalpf_unprep").val('₱ ' + accounting.format(json["total"]["proff"],2)).closest('.form-line').addClass('focused');
//                $("#totalamt_unprep").val('₱ ' + accounting.format(json["total"]["totalamount"],2)).closest('.form-line').addClass('focused');
////             
//                $(".report-btn").show();

            }
        });
        $('#total-accumulated-PHICAR-table_filter input').unbind();
        $('#total-accumulated-PHICAR-table_filter input').bind('keyup', function (e) {
            if (e.keyCode === 13) {
                table.fnFilter(this.value);
            }
        });
    },

    monthlyphilhealthpayments: function ()
    {
        $('#monthlyphilhealthpayments').modal("show");
        var datexx = $('#search-monthlyphilhealthpayments-form input[name=start_date]').val();
        if (datexx == "")
        {
            var d = new Date(),
                    mm = (d.getMonth() < 10 ? '0' : '') + (d.getMonth() + 1);
            yy = d.getFullYear();
            $('#search-monthlyphilhealthpayments-form input[name=start_date]').val(yy + "-" + mm);
            datexx = yy + "-" + mm;
        }

        $('#monthlyphilhealthpayments-table').dataTable().fnDestroy();
        var table = $('#monthlyphilhealthpayments-table').dataTable({
            dom: 'frtip',
//            responsive: true,
            processing: true,
            serverSide: true,
            order: [],
            ajax: {
                url: BASE_URL + "Dashboard/fetch_monthlyphilhealthpayments",
                type: "POST",
                data: {month: datexx}
            },
            initComplete: function (settings, json) {

//                alert(json["totalx"]["hcifee"]);
                $("#totalhospfeex").html(accounting.format(json["totalx"]["hcifee"], 2));
                $("#totalproffeex").html(accounting.format(json["totalx"]["profee"], 2));
//                $("#totalpf_unprep").val('₱ ' + accounting.format(json["total"]["proff"],2)).closest('.form-line').addClass('focused');
//                $("#totalamt_unprep").val('₱ ' + accounting.format(json["total"]["totalamount"],2)).closest('.form-line').addClass('focused');
////             
//                $(".report-btn").show();

            }
        });
        $('#monthlyphilhealthpayments-table_filter input').unbind();
        $('#monthlyphilhealthpayments-table_filter input').bind('keyup', function (e) {
            if (e.keyCode === 13) {
                table.fnFilter(this.value);
            }
        });
    },

    totalonprocess: function ()
    {
        $('#onProcessDashboard').modal("show");
        $('#opdash').html("TOTAL ADMITTED PATIENTS");
        $('#onProcessdash-info-table').dataTable().fnDestroy();
        var table = $('#onProcessdash-info-table').dataTable({
            dom: 'frtip',
            responsive: true,
            processing: true,
            serverSide: true,
            order: [],
            ajax: {
                url: BASE_URL + "user/fetch_onProcess_patients_all",
                type: "POST",

            }
        });
        $('#onProcessdash-info-table_filter input').unbind();
        $('#onProcessdash-info-table_filter input').bind('keyup', function (e) {
            if (e.keyCode === 13) {
                table.fnFilter(this.value);
            }
        });
    },

    get_phic_report: function () {

        $("#phic-info-form").submit();
    },
    get_non_phic_report: function () {

        $("#nonphic-info-form").submit();
    },
    get_total_patients_report: function () {

        $("#total-patient-info-form").submit();
    },

    get_admitted_patients_report: function ()
    {
        $("#admitted-patients-form").submit();
    },

    get_discharged_patients_report: function ()
    {
        $("#discharged-patients-form").submit();
    },

    get_eachd_patients_report: function ()
    {
        $("#eachd-patients-form").submit();
    },

    unpreparedclaims: function (age)
    {
        $('#unpreparedclaims').modal('show');
        if (age == 1)
        {
            $('#aging').text('1 - 30 DAYS');
            $('.modal-header').removeClass('bg-deep-orange');
            $('.modal-footer').removeClass('bg-deep-orange');
            $('.modal-header').removeClass('bg-amber');
            $('.modal-footer').removeClass('bg-amber');
            $('.modal-header').removeClass('bg-orange');
            $('.modal-footer').removeClass('bg-orange');
            $('.modal-header').addClass('bg-green');
            $('.modal-footer').addClass('bg-green');

        } else if (age == 2)
        {
            $('#aging').text('31 - 45 DAYS');
            $('.modal-header').removeClass('bg-deep-orange');
            $('.modal-footer').removeClass('bg-deep-orange');
            $('.modal-header').removeClass('bg-green');
            $('.modal-footer').removeClass('bg-green');
            $('.modal-header').removeClass('bg-orange');
            $('.modal-footer').removeClass('bg-orange');
            $('.modal-header').addClass('bg-amber');
            $('.modal-footer').addClass('bg-amber');

        } else if (age == 3)
        {
            $('#aging').text('46 - 60 DAYS');
            $('.modal-header').removeClass('bg-deep-orange');
            $('.modal-footer').removeClass('bg-deep-orange');
            $('.modal-header').removeClass('bg-green');
            $('.modal-footer').removeClass('bg-green');
            $('.modal-header').removeClass('bg-amber');
            $('.modal-footer').removeClass('bg-amber');
            $('.modal-header').addClass('bg-orange');
            $('.modal-footer').addClass('bg-orange');

        } else
        {
            $('#aging').text('61 DAYS ABOVE');
            $('.modal-header').removeClass('orange');
            $('.modal-footer').removeClass('orange');
            $('.modal-header').removeClass('bg-green');
            $('.modal-footer').removeClass('bg-green');
            $('.modal-header').removeClass('bg-amber');
            $('.modal-footer').removeClass('bg-amber');
            $('.modal-header').addClass('bg-deep-orange');
            $('.modal-footer').addClass('bg-deep-orange');

        }
        $('#dashboard-onpro-info-table').dataTable().fnDestroy();
        var table = $('#dashboard-onpro-info-table').dataTable({
            dom: 'frtip',
            responsive: true,
            processing: true,
            serverSide: true,
            order: [],
            ajax: {
                url: BASE_URL + "user/fetch_dashboard_onpro_info",
                type: "POST",
                data: {age: age}

            },
            initComplete: function (settings, json) {
                $("#totalhci_unprep").val('₱ ' + accounting.format(json["total"]["hospp"], 2)).closest('.form-line').addClass('focused');
                $("#totalpf_unprep").val('₱ ' + accounting.format(json["total"]["proff"], 2)).closest('.form-line').addClass('focused');
                $("#totalamt_unprep").val('₱ ' + accounting.format(json["total"]["totalamount"], 2)).closest('.form-line').addClass('focused');
//             
                $(".report-btn").show();

            }
        });
        $('#dashboard-onpro-info-table_filter input').unbind();
        $('#dashboard-onpro-info-table_filter input').bind('keyup', function (e) {
            if (e.keyCode === 13) {
                table.fnFilter(this.value);
            }
        });
    },

    pendingclaims: function (age)
    {
        $('#pendingclaims').modal('show');
        if (age == 1)
        {
            $('#pendingage').text('1 - 30 DAYS');
            $('.modal-header').removeClass('bg-deep-orange');
            $('.modal-footer').removeClass('bg-deep-orange');
            $('.modal-header').removeClass('bg-amber');
            $('.modal-footer').removeClass('bg-amber');
            $('.modal-header').removeClass('bg-orange');
            $('.modal-footer').removeClass('bg-orange');
            $('.modal-header').addClass('bg-green');
            $('.modal-footer').addClass('bg-green');

        } else if (age == 2)
        {
            $('#pendingage').text('31 - 45 DAYS');
            $('.modal-header').removeClass('bg-deep-orange');
            $('.modal-footer').removeClass('bg-deep-orange');
            $('.modal-header').removeClass('bg-green');
            $('.modal-footer').removeClass('bg-green');
            $('.modal-header').removeClass('bg-orange');
            $('.modal-footer').removeClass('bg-orange');
            $('.modal-header').addClass('bg-amber');
            $('.modal-footer').addClass('bg-amber');
        } else if (age == 3)
        {
            $('#pendingage').text('46 - 60 DAYS');
            $('.modal-header').removeClass('bg-deep-orange');
            $('.modal-footer').removeClass('bg-deep-orange');
            $('.modal-header').removeClass('bg-green');
            $('.modal-footer').removeClass('bg-green');
            $('.modal-header').removeClass('bg-amber');
            $('.modal-footer').removeClass('bg-amber');
            $('.modal-header').addClass('bg-orange');
            $('.modal-footer').addClass('bg-orange');
        } else
        {
            $('#pendingage').text('61 DAYS ABOVE');
            $('.modal-header').removeClass('orange');
            $('.modal-footer').removeClass('orange');
            $('.modal-header').removeClass('bg-green');
            $('.modal-footer').removeClass('bg-green');
            $('.modal-header').removeClass('bg-amber');
            $('.modal-footer').removeClass('bg-amber');
            $('.modal-header').addClass('bg-deep-orange');
            $('.modal-footer').addClass('bg-deep-orange');
        }
        $('#dashboard-non-transmit-table').dataTable().fnDestroy();
        var table = $('#dashboard-non-transmit-table').dataTable({
            dom: 'frtip',
            responsive: true,
            processing: true,
            serverSide: true,
            order: [],
            ajax: {
                url: BASE_URL + "user/fetch_dashboard_nontransmit_info",
                type: "POST",
                data: {age: age}

            },
        });
        $('#dashboard-non-transmit-table_filter input').unbind();
        $('#dashboard-non-transmit-table_filter input').bind('keyup', function (e) {
            if (e.keyCode === 13) {
                table.fnFilter(this.value);
            }
        });
    },

    eclaimstat: function (statx)
    {
        $('#eclaimstat').modal('show');
        var sentEclaimsDate = $("#sentEclaimsDate").val();
        var datexx = moment(sentEclaimsDate).format('LL');
        if (statx == 1)
        {
            $('#eclaimstatx').text('SENT ECLAIMS FOR ' + datexx);
            $('.modal-header').removeClass('bg-blue');
            $('.modal-footer').removeClass('bg-blue');
            $('.modal-header').removeClass('bg-amber');
            $('.modal-footer').removeClass('bg-amber');
            $('.modal-header').removeClass('bg-red');
            $('.modal-footer').removeClass('bg-red');
            $('.modal-header').removeClass('bg-light-green');
            $('.modal-footer').removeClass('bg-light-green');
            $('.modal-header').removeClass('bg-green');
            $('.modal-footer').removeClass('bg-green');
            $('.modal-header').addClass('bg-cyan');
            $('.modal-footer').addClass('bg-cyan');
            var stat = "send";

        } else if (statx == 2)
        {
            $('#eclaimstatx').text('IN PROCESS' + datexx);
            $('.modal-header').removeClass('bg-cyan');
            $('.modal-footer').removeClass('bg-cyan');
            $('.modal-header').removeClass('bg-amber');
            $('.modal-footer').removeClass('bg-amber');
            $('.modal-header').removeClass('bg-red');
            $('.modal-footer').removeClass('bg-red');
            $('.modal-header').removeClass('bg-light-green');
            $('.modal-footer').removeClass('bg-light-green');
            $('.modal-header').removeClass('bg-green');
            $('.modal-footer').removeClass('bg-green');
            $('.modal-header').addClass('bg-blue');
            $('.modal-footer').addClass('bg-blue');
            var stat = "IN PROCESS";
        } else if (statx == 3)
        {
            $('#eclaimstatx').text('RTH' + datexx);
            $('.modal-header').removeClass('bg-cyan');
            $('.modal-footer').removeClass('bg-cyan');
            $('.modal-header').removeClass('bg-blue');
            $('.modal-footer').removeClass('bg-blue');
            $('.modal-header').removeClass('bg-red');
            $('.modal-footer').removeClass('bg-red');
            $('.modal-header').removeClass('bg-light-green');
            $('.modal-footer').removeClass('bg-light-green');
            $('.modal-header').removeClass('bg-green');
            $('.modal-footer').removeClass('bg-green');
            $('.modal-header').addClass('bg-amber');
            $('.modal-footer').addClass('bg-amber');
            var stat = "RTH";
        } else if (statx == 4)
        {
            $('#eclaimstatx').text('DENIED' + datexx);
            $('.modal-header').removeClass('bg-cyan');
            $('.modal-footer').removeClass('bg-cyan');
            $('.modal-header').removeClass('bg-blue');
            $('.modal-footer').removeClass('bg-blue');
            $('.modal-header').removeClass('bg-amber');
            $('.modal-footer').removeClass('bg-amber');
            $('.modal-header').removeClass('bg-light-green');
            $('.modal-footer').removeClass('bg-light-green');
            $('.modal-header').removeClass('bg-green');
            $('.modal-footer').removeClass('bg-green');
            $('.modal-header').addClass('bg-red');
            $('.modal-footer').addClass('bg-red');
            var stat = "DENIED";
        } else if (statx == 5)
        {
            $('#eclaimstatx').text('WITH VOUCHER' + datexx);
            $('.modal-header').removeClass('bg-cyan');
            $('.modal-footer').removeClass('bg-cyan');
            $('.modal-header').removeClass('bg-blue');
            $('.modal-footer').removeClass('bg-blue');
            $('.modal-header').removeClass('bg-amber');
            $('.modal-footer').removeClass('bg-amber');
            $('.modal-header').removeClass('bg-red');
            $('.modal-footer').removeClass('bg-red');
            $('.modal-header').removeClass('bg-green');
            $('.modal-footer').removeClass('bg-green');
            $('.modal-header').addClass('bg-light-green');
            $('.modal-footer').addClass('bg-light-green');
            var stat = "WITH VOUCHER";
        } else
        {
            $('#eclaimstatx').text('WITH CHEQUE' + datexx);
            $('.modal-header').removeClass('bg-cyan');
            $('.modal-footer').removeClass('bg-cyan');
            $('.modal-header').removeClass('bg-blue');
            $('.modal-footer').removeClass('bg-blue');
            $('.modal-header').removeClass('bg-amber');
            $('.modal-footer').removeClass('bg-amber');
            $('.modal-header').removeClass('bg-red');
            $('.modal-footer').removeClass('bg-red');
            $('.modal-header').removeClass('bg-light-green');
            $('.modal-footer').removeClass('bg-light-green');
            $('.modal-header').addClass('bg-green');
            $('.modal-footer').addClass('bg-green');
            var stat = "WITH CHEQUE";
        }
        $('#dashboard-eclaim-stat-table').dataTable().fnDestroy();
        var table = $('#dashboard-eclaim-stat-table').dataTable({
            dom: 'frtip',
//            responsive: true,
            processing: true,
            serverSide: true,
            order: [],
            scrollX: true,
            ajax: {
                url: BASE_URL + "user/fetch_dashboard_eclaimstat_patients",
                type: "POST",
                data: {stat: stat,sentEclaimsDate:sentEclaimsDate}

            },
        });
        $('#dashboard-eclaim-stat-table_filter input').unbind();
        $('#dashboard-eclaim-stat-table_filter input').bind('keyup', function (e) {
            if (e.keyCode === 13) {
                table.fnFilter(this.value);
            }
        });
    }
};

$('#census-table').on('click', 'td', function () {
    var current_row = $(this).parents('tr');//Get the current row
    if (current_row.hasClass('child')) {//Check if the current row is a child row
        current_row = current_row.prev();//If it is, then point to the row before it (its 'parent')
    }
    var data = $('#census-table').dataTable().fnGetData(current_row);

//    console.log(data[0]);
    dashboard.show_patients(data);
    $("#eachDayPatCensus").modal("show");
});


function unpreparedclaims() {
    $.ajax({
        type: 'POST',
        url: BASE_URL + "Dashboard/getUnpreparedClaims",
        dataType: 'json'
    }).done(function (data) {
//        console.log(data);
        if (data.status)
        {
            $('#day1').text(accounting.format(data.getUnpreparedClaims['first']));
            $('#day31').text(accounting.format(data.getUnpreparedClaims['second']));
            $('#day46').text(accounting.format(data.getUnpreparedClaims['third']));
            $('#day61').text(accounting.format(data.getUnpreparedClaims['fourth']));
        } else
        {
            swal("Fail!", "Fail to add record.", "error");
        }
    });
}

function getPendingClaims() {
    $.ajax({
        type: 'POST',
        url: BASE_URL + "Dashboard/getPendingClaims",
        dataType: 'json'
    }).done(function (data) {
//        console.log(data);
        if (data.status)
        {
            $('#nontransmitted1').text(accounting.format(data.getPendingClaims['nontransmitted1']));
            $('#nontransmitted2').text(accounting.format(data.getPendingClaims['nontransmitted2']));
            $('#nontransmitted3').text(accounting.format(data.getPendingClaims['nontransmitted3']));
            $('#nontransmitted4').text(accounting.format(data.getPendingClaims['nontransmitted4']));
//                alert(data.getUnpreparedClaims['fourth']);

        } else
        {
            swal("Fail!", "Fail to add record.", "error");
        }
    });
}

function getSentClaims() {
    var sentEclaimsDate = $("#sentEclaimsDate").val();
    console.log();
    $.ajax({
        type: 'POST',
        url: BASE_URL + "Dashboard/getSentClaims",
        data: {sentEclaimsDate: sentEclaimsDate},
        dataType: 'json'
    }).done(function (data) {
//        console.log(data);
        if (data.status)
        {
            $('#monthly').text(accounting.format(data.getSentClaims['monthly']));
            $('#inprocess').text(accounting.format(data.getSentClaims['inprocess']));
            $('#returnx').text(accounting.format(data.getSentClaims['returnx']));
            $('#denied').text(accounting.format(data.getSentClaims['denied']));
            $('#voucher').text(accounting.format(data.getSentClaims['voucher']));
            $('#wcheque').text(accounting.format(data.getSentClaims['wcheque']));

        } else
        {
            swal("Fail!", "Fail to add record.", "error");
        }
    });
}

function getPHARoftheMonth() {
    $.ajax({
        type: 'POST',
        url: BASE_URL + "Dashboard/getPHARoftheMonth",
        dataType: 'json'
    }).done(function (data) {
//        console.log(data);
        if (data.status)
        {
            $('#monthlyAR').text(accounting.format(data.getPHARoftheMonth['totalamt'], 2));
        } else
        {
            swal("Fail!", "Fail to add record.", "error");
        }
    });
}

function getTotalAccPHICAR() {
    $.ajax({
        type: 'POST',
        url: BASE_URL + "Dashboard/getTotalAccPHICAR",
        dataType: 'json'
    }).done(function (data) {
//        console.log(data);
        if (data.status)
        {
            $('#accuPHAR').text(accounting.format(data.getTotalAccPHICAR['totalamt'], 2));
        } else
        {
            swal("Fail!", "Fail to add record.", "error");
        }
    });
}

function getPaymentForTheMonth() {
    $.ajax({
        type: 'POST',
        url: BASE_URL + "Dashboard/getPaymentForTheMonth",
        dataType: 'json'
    }).done(function (data) {
//        console.log(data);
        if (data.status)
        {
            $('#paymentForTheMonth').text(accounting.format(data.getPaymentForTheMonth['totalamount'], 2));
        } else
        {
            swal("Fail!", "Fail to add record.", "error");
        }
    });
}

function getAdmitDischargeDaily() {
    loadingModal();
    var admitDischaDate = $("#admitDischaDate").val();
    $.ajax({
        type: 'POST',
        url: BASE_URL + "Dashboard/getAdmitDischargeDaily",
        data: {admitDischaDate: admitDischaDate},
        dataType: 'json'
    }).done(function (data1) {
        if (data1.status) {
            $('#disad-table').dataTable().fnClearTable();
            $('#disad-table').dataTable().fnDraw();
            $('#disad-table').dataTable().fnDestroy();
            var totalAdmission = parseInt(data1.getAdmitDischargeDaily["admittedPHIC"]) + parseInt(data1.getAdmitDischargeDaily["admittedNonPHIC"]);
            var totaldischarges = parseInt(data1.getAdmitDischargeDaily["dischargedPHIC"]) + parseInt(data1.getAdmitDischargeDaily["dischargedNonPHIC"]);
            $('#disad-table').append(
                    '<tr>\n\
                            <td>Admissions</td>\n\
                           <td>' + data1.getAdmitDischargeDaily["admittedPHIC"] + '</td> \n\
                           <td>' + data1.getAdmitDischargeDaily["admittedNonPHIC"] + '</td> \n\
                           <td>' + totalAdmission + '</td></tr>'
                    );
            $('#disad-table').append(
                    '<tr>\n\
                            <td>Discharges</td>\n\
                           <td>' + data1.getAdmitDischargeDaily["dischargedPHIC"] + '</td> \n\
                           <td>' + data1.getAdmitDischargeDaily["dischargedNonPHIC"] + '</td> \n\
                           <td>' + totaldischarges + '</td></tr>'
                    );
        } else {
            console.log('fail');
        }
    });
}

function getProfitLoss()
{
    var month = $('#profitLossDate').val();
    var costcenter = $('#cmbcostCenter').val();

    $.ajax({
        type: 'POST',
        url: BASE_URL + "Dashboard/getProfitandLoss",
        data: {month: month, costcenter: costcenter},
        dataType: 'json'
    }).done(function (data1) {
//            console.log(data1);
        if (data1.status) {

            var getProfit = (data1.getProfitandLoss["getProfit"] == null) ? '0.00' : data1.getProfitandLoss["getProfit"];
            var getLoss = (data1.getProfitandLoss["getLoss"] == null) ? '0.00' : data1.getProfitandLoss["getLoss"];
            var tot = parseFloat(getProfit) + parseFloat(getLoss);
            $('#profitTotal').html("₱ " + accounting.format(getProfit, 2));
            $('#lossTotal').html("₱ " + accounting.format(getLoss, 2));

            if (tot == '0.00') {
                $("#expensesDiv").addClass('hidden', true);
                $("#expensesDiv_Nodata").removeClass('hidden', true);
            } else {
                $("#expensesDiv").removeClass('hidden', true);
                $("#expensesDiv_Nodata").addClass('hidden', true);
                getChartJs(getProfit, getLoss);
            }
        } else {
            console.log('fail');
        }
    });
}

function fetchCostCenter()
{
    $.ajax
            ({
                type: 'POST',
                url: BASE_URL + "Dashboard/fetchCostCenter",
                dataType: 'json'
            }).done(function (data) {
        if (data.status)
        {
            $('#cmbcostCenter').empty();
            $('#cmbcostCenter').append('<option value="">- All -</option>').attr("selected", "selected");
            for (var i = 0; i < data.fetchCostCenter.length; i++)
            {
                $('#cmbcostCenter').append('<option value="' + data.fetchCostCenter[i]['COSTCNTRCODE'] + '">' + data.fetchCostCenter[i]['COSTCNTRNAME'] + '</option>');
            }
            $("#cmbcostCenter").selectpicker("refresh");
        }
    });
}

function getChartJs(getProfit, getLoss)
{
//    $('#totalPatient').html(accounting.format(totalPatient));
//    var ipdPercentage = accounting.format((getIPD/totalPatient)*100,2);
//    var opdPercentage = accounting.format((getOPD/totalPatient)*100,2);



    var data = [
        {data: [[0, getProfit]], color: "rgba(0, 188, 212, 0.8)", testId: 30, isBar: true},
        {data: [[1, getLoss]], color: "rgba(233, 30, 99, 0.8)", testId: 31, isBar: true},
    ];

    var plot = $.plot("#profitloss_chart", data, {
        bars: {
            show: true,
            align: 'center',
            barWidth: 0.5
        },
        lines: {
            show: true,
            lineWidth: 0.1,
            fill: false
        },
        grid: {
            clickable: true,
            hoverable: true,
            autoHighlight: true
        },
        xaxis: {
            ticks: [[0, 'Profit'], [1, 'Loss']]
        },
        yaxis: {

        },
        legend: {
            container: '#legend'
        }
    });

    $("#profitloss_chart").bind("plotclick", function (event, pos, item) {

        if (item != null && item.series.isBar) {

            var name = item.series.xaxis.ticks[item.datapoint[0]].label;
            var value = item.datapoint[1];
            $('#profitloss').modal('show');
            $('#profitLossTitle').html(name.toUpperCase());
            var months = ["January", "February", "March", "April", "May", "June",
                "July", "August", "September", "October", "November", "December"];

            var monthNumber = $('#profitLossDate').val().split("-");
            var selectedMonthName = months[monthNumber[1] - 1];

            $('#profitDate').html(selectedMonthName + " " + monthNumber[0]);

            $('#profitTotalx').html("₱ " + accounting.format(value, 2));
            getProfitOrLoss(name.toUpperCase(), $('#profitLossDate').val(), $('#cmbcostCenter').val());
//             alert("Name" + name);
//             alert("item.series.color" + item.series.color);
//             alert("value" + value);
//             alert("item.series.testId" + item.series.testId);
        }
    });

}

function getProfitOrLoss(type, month, costcenter) {

    $('#profit-loss-table').dataTable().fnDestroy();
    var table = $('#profit-loss-table').dataTable({
        dom: 'frtip',
        processing: true,
        serverSide: true,
        order: [],
        ajax: {
            url: BASE_URL + "Dashboard/getProfitOrLoss",
            type: "POST",
            data: {
                type: type,
                month: month,
                costcenter: costcenter
            }
        }
    });

    $('#profit-loss-table_filter input').unbind();
    $('#profit-loss-table_filter input').bind('keyup', function (e) {
        if (e.keyCode == 13) {
            table.fnFilter(this.value);
        }
    });
}

function getExpenses()
{
    $.ajax({
        type: 'POST',
        url: BASE_URL + "Dashboard/getExpenses",
        data: {month: $('#expenseDate').val()},
        dataType: 'json'
    }).done(function (data1) {
//            console.log(data1);
        if (data1.status) {
            var otherExpenses = 0.00;
            var totalExpenses = 0.00;

            var firstExpenses = data1.getExpenses[0]["coadscr"];
            var firstExpensesAmt = (data1.getExpenses[0]["debitxx"] == null) ? '0.00' : data1.getExpenses[0]["debitxx"];
            var secondExpenses = data1.getExpenses[1]["coadscr"];
            var secondExpensesAmt = (data1.getExpenses[1]["debitxx"] == null) ? '0.00' : data1.getExpenses[1]["debitxx"];
            var thirdExpenses = data1.getExpenses[2]["coadscr"];
            var thirdExpensesAmt = (data1.getExpenses[2]["debitxx"] == null) ? '0.00' : data1.getExpenses[2]["debitxx"];
            var fourthExpenses = data1.getExpenses[3]["coadscr"];
            var fourthExpensesAmt = (data1.getExpenses[3]["debitxx"] == null) ? '0.00' : data1.getExpenses[3]["debitxx"];
            var fifthExpenses = data1.getExpenses[4]["coadscr"];
            var fifthExpensesAmt = (data1.getExpenses[4]["debitxx"] == null) ? '0.00' : data1.getExpenses[4]["debitxx"];
            for (var total = 0; total < data1.getExpenses.length; total++)
            {
                totalExpenses += parseFloat(data1.getExpenses[total]["debitxx"], 10);
            }
            for (var i = 5; i < data1.getExpenses.length; i++)
            {
                if (data1.getExpenses[i]['debitxx'] !== '0.00')
                {
                    otherExpenses += parseFloat(data1.getExpenses[i]["debitxx"], 2);
                }
            }

            $('#totalExpenses').html(accounting.format(totalExpenses, 2));
            $("#expensesDiv").removeClass('hidden', true);
            $("#expensesDiv_Nodata").addClass('hidden', true);
            getChartExpenses(firstExpenses, firstExpensesAmt, secondExpenses, secondExpensesAmt, thirdExpenses, thirdExpensesAmt, fourthExpenses, fourthExpensesAmt, fifthExpenses, fifthExpensesAmt, otherExpenses, totalExpenses)
//                    new Chart(document.getElementById("pie_chart").getContext("2d"), 
//                    );
        } else {
            console.log('fail');

            $('#totalExpenses').html('0.00');
            $("#expensesDiv").addClass('hidden', true);
            $("#expensesDiv_Nodata").removeClass('hidden', true);
        }
    });
}

function getChartExpenses(firstExpenses, firstExpensesAmt, secondExpenses, secondExpensesAmt, thirdExpenses, thirdExpensesAmt, fourthExpenses, fourthExpensesAmt, fifthExpenses, fifthExpensesAmt, otherExpenses, totalExpenses)
{
    var firstExpensesAmtPercentage = accounting.format((firstExpensesAmt / totalExpenses) * 100, 2);
    var secondExpensesAmtPercentage = accounting.format((secondExpensesAmt / totalExpenses) * 100, 2);
    var thirdExpensesAmtPercentage = accounting.format((thirdExpensesAmt / totalExpenses) * 100, 2);
    var fourthExpensesAmtPercentage = accounting.format((fourthExpensesAmt / totalExpenses) * 100, 2);
    var fifthExpensesAmtPercentage = accounting.format((fifthExpensesAmt / totalExpenses) * 100, 2);
    var otherExpensesPercentage = accounting.format((otherExpenses / totalExpenses) * 100, 2);
    $('#firstEa').html("₱ " + accounting.format(firstExpensesAmt, 2) + " (" + accounting.format(firstExpensesAmtPercentage, 2) + "%)");
    $('#secondEa').html("₱ " + accounting.format(secondExpensesAmt, 2) + " (" + accounting.format(secondExpensesAmtPercentage, 2) + "%)");
    $('#thirdEa').html("₱ " + accounting.format(thirdExpensesAmt, 2) + " (" + accounting.format(thirdExpensesAmtPercentage, 2) + "%)");
    $('#fourthEa').html("₱ " + accounting.format(fourthExpensesAmt, 2) + " (" + accounting.format(fourthExpensesAmtPercentage, 2) + "%)");
    $('#fifthEa').html("₱ " + accounting.format(fifthExpensesAmt, 2) + " (" + accounting.format(fifthExpensesAmtPercentage, 2) + "%)");
    $('#othersEa').html("₱ " + accounting.format(otherExpenses, 2) + " (" + accounting.format(otherExpensesPercentage, 2) + "%)");
    $('#firstEn').html(firstExpenses);
    $('#secondEn').html(secondExpenses);
    $('#thirdEn').html(thirdExpenses);
    $('#fourthEn').html(fourthExpenses);
    $('#fifthEn').html(fifthExpenses);
    $('#othersEn').html('Others');
    var donutData = [
        {label: firstExpenses, data: firstExpensesAmt, color: '#F91B05'},
        {label: secondExpenses, data: secondExpensesAmt, color: '#F99505'},
        {label: thirdExpenses, data: thirdExpensesAmt, color: '#05F910'},
        {label: fourthExpenses, data: fourthExpensesAmt, color: '#05A0F9'},
        {label: fifthExpenses, data: fifthExpensesAmt, color: '#8605F9'},
        {label: 'Others', data: otherExpenses, color: '#F905C5'},
    ]
    $.plot('#genderChart', donutData, {
        series: {
            canvas: true,
            pie: {
                show: true,
                radius: 1,
                innerRadius: 0.5,
                label: {
                    show: false,
                    radius: 2 / 3,
//            formatter: function (label, series) {
//  			return '<div style="font-size:8pt;text-align:center;padding:2px; color: white;">' + label + '<br/><b>' + series.data[0][1] + '</b> <i class="fa fa-fw fa-users"></i><br>'+Math.round(series.percent)+'%</div>';
//		},
                    threshold: 0.1
                }

            }
        },
        legend: {
            show: false
        }
    })
}

function labelFormatter(label, series) {
    return '<div style="font-size:13px; text-align:center; padding:2px; color: black; font-weight: 600;">'
            + label
            + '<br>'
            + series.percent + ' <i class="fa fa-fw fa-users"></i></div>'
}

function getPxType()
{
    $.ajax({
        type: 'POST',
        url: BASE_URL + "Dashboard/getPxType",
        data: {month: $('#pxtypeDate').val()},
        dataType: 'json'
    }).done(function (data1) {
//            console.log(data1);
        if (data1.status) {

            var getIPD = (data1.getPxType["getIPD"] == null) ? '0' : data1.getPxType["getIPD"];
            var getOPD = (data1.getPxType["getOPD"] == null) ? '0' : data1.getPxType["getOPD"];
            var totalPatient = parseInt(getIPD) + parseInt(getOPD);

            $('#totalPatient').html(accounting.format(totalPatient));
            var ipdPercentage = accounting.format((getIPD / totalPatient) * 100, 2);
            var opdPercentage = accounting.format((getOPD / totalPatient) * 100, 2);
            $('#ipdTotal').html(accounting.format(getIPD) + " (" + ipdPercentage + "%)");
            $('#opdTotal').html(accounting.format(getOPD) + " (" + opdPercentage + "%)");

            if (totalPatient == '0') {
                $("#pxtypeDiv").addClass('hidden', true);
                $("#pxtypeDiv_Nodata").removeClass('hidden', true);
            } else {

                $("#pxtypeDiv").removeClass('hidden', true);
                $("#pxtypeDiv_Nodata").addClass('hidden', true);
                getChartPxType(getIPD, getOPD, totalPatient, totalPatient);
            }
        } else {
            console.log('fail');
        }
    });
}

function getChartPxType(getIPD, getOPD, totalPatient)
{
    var data = [
        {data: [[0, getIPD]], color: "rgba(0, 188, 212, 0.8)", testId: 30, isBar: true},
        {data: [[1, getOPD]], color: "rgba(233, 30, 99, 0.8)", testId: 31, isBar: true},
    ];

    var plot = $.plot("#pxtype_chart", data, {
        bars: {
            show: true,
            align: 'center',
            barWidth: 0.5
        },
        lines: {
            show: true,
            lineWidth: 0.1,
            fill: false
        },
        grid: {
            clickable: true,
            hoverable: true,
            autoHighlight: true
        },
        xaxis: {
            ticks: [[0, 'IPD'], [1, 'OPD']]
        },
        legend: {
            container: '#legend'
        }
    });

    $("#pxtype_chart").bind("plotclick", function (event, pos, item) {

        if (item != null && item.series.isBar) {

            var name = item.series.xaxis.ticks[item.datapoint[0]].label;
            var value = item.datapoint[1];
        }
    });
}


function getTotalIncome()
{
    $.ajax({
        type: 'POST',
        url: BASE_URL + "Dashboard/getTotalIncome",
        data: {month: $('#totalIncomeDate').val()},
        dataType: 'json'
    }).done(function (data1) {
        if (data1.status) {
//                var otherIncome = 0.00;
            var totalIncome = 0.00;
            var DrugsMeds = (data1.getTotalIncome["drugin"] == null) ? 0.00 : data1.getTotalIncome["drugin"];
            var MedicalSupply = (data1.getTotalIncome["medsplyin"] == null) ? 0.00 : data1.getTotalIncome["medsplyin"];
            var PharmacyMisc = (data1.getTotalIncome["pharmiscin"] == null) ? 0.00 : data1.getTotalIncome["pharmiscin"];
            var Laboratory = (data1.getTotalIncome["labin"] == null) ? 0.00 : data1.getTotalIncome["labin"];
            var Radiology = (data1.getTotalIncome["radin"] == null) ? 0.00 : data1.getTotalIncome["radin"];
            var Hospital = (data1.getTotalIncome["hospin"] == null) ? 0.00 : data1.getTotalIncome["hospin"];
            var otherIncome = (data1.getTotalIncome['otherincome'] == null) ? 0.00 : data1.getTotalIncome["otherincome"];

            totalIncome = parseFloat(DrugsMeds) +
                    parseFloat(MedicalSupply) +
                    parseFloat(PharmacyMisc) +
                    parseFloat(Laboratory) +
                    parseFloat(Radiology) +
                    parseFloat(Hospital) +
                    parseFloat(otherIncome);
            $('#totalIncome').html(accounting.format(totalIncome, 2));
            if (accounting.format(totalIncome, 2) == '0.00') {
                $("#chartTotalIncome").addClass('hidden', true);
                $("#chartTotalIncome_Nodata").removeClass('hidden', true);
            } else {

                $("#chartTotalIncome").removeClass('hidden', true);
                $("#chartTotalIncome_Nodata").addClass('hidden', true);
                getChartTotalIncome(DrugsMeds, MedicalSupply, PharmacyMisc, Laboratory, Radiology, Hospital, otherIncome, totalIncome);
            }
        } else {
            console.log('fail');
        }
    });
}

function getChartTotalIncome(DrugsMeds, MedicalSupply, PharmacyMisc, Laboratory, Radiology, Hospital, otherIncome, totalIncome)
{
    var DMPercentage = accounting.format((DrugsMeds / totalIncome) * 100, 2);
    var MSPercentage = accounting.format((MedicalSupply / totalIncome) * 100, 2);
    var PMPercentage = accounting.format((PharmacyMisc / totalIncome) * 100, 2);
    var LPercentage = accounting.format((Laboratory / totalIncome) * 100, 2);
    var RPercentage = accounting.format((Laboratory / totalIncome) * 100, 2);
    var HPercentage = accounting.format((Hospital / totalIncome) * 100, 2);
    var OIPercentage = accounting.format((otherIncome / totalIncome) * 100, 2);
    $('#drugsmedsA').html("₱ " + accounting.format(DrugsMeds, 2) + " (" + DMPercentage + "%)");
    $('#medsplyA').html("₱ " + accounting.format(MedicalSupply, 2) + " (" + MSPercentage + "%)");
    $('#pharmiscA').html("₱ " + accounting.format(PharmacyMisc, 2) + " (" + PMPercentage + "%)");
    $('#labA').html("₱ " + accounting.format(Laboratory, 2) + " (" + LPercentage + "%)");
    $('#radA').html("₱ " + accounting.format(Radiology, 2) + " (" + RPercentage + "%)");
    $('#hospA').html("₱ " + accounting.format(Hospital, 2) + " (" + HPercentage + "%)");
    $('#otherIncomeA').html("₱ " + accounting.format(otherIncome, 2) + " (" + OIPercentage + "%)");
    $('#drugsmedsN').html('Drugs and Medicines');
    $('#medsplyN').html('Medical Supply');
    $('#pharmiscN').html('Pharmacy Miscellaneous');
    $('#labN').html('Laboratory');
    $('#radN').html('Radiology');
    $('#hospN').html('Hospital');
    $('#otherIncomeN').html('Others');
    var donutData = [
        {label: 'Drugs and Medicines', data: DrugsMeds, color: '#F91B05'},
        {label: 'Medical Supply', data: MedicalSupply, color: '#F99505'},
        {label: 'Pharmacy Miscellaneous', data: PharmacyMisc, color: '#05F910'},
        {label: 'Laboratory', data: Laboratory, color: '#05A0F9'},
        {label: 'Radiology', data: Radiology, color: '#8605F9'},
        {label: 'Hospital', data: Hospital, color: '#F905C5'},
        {label: 'Others', data: otherIncome, color: '#4B103E'},
    ]
    $.plot('#totalincome_chart', donutData, {
        series: {
            canvas: true,
            pie: {
                show: true,
                radius: 1,
                innerRadius: 0.5,
                label: {
                    show: false,
                    radius: 2 / 3,
//            formatter: function (label, series) {
//  			return '<div style="font-size:8pt;text-align:center;padding:2px; color: white;">' + label + '<br/><b>' + series.data[0][1] + '</b> <i class="fa fa-fw fa-users"></i><br>'+Math.round(series.percent)+'%</div>';
//		},
                    threshold: 0.1
                }

            }
        },
        legend: {
            show: false
        }
    })
}


