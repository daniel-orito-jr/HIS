<body class="theme-cyan">
    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2 style="text-transform: uppercase;">
                    Patients Records
                </h2>
            </div>
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header bg-cyan" style="text-transform:uppercase;">
                            <h2>
                                Covered Date
                            </h2>
                        </div>
                        <div class="body container-fluid">
                            <form id="search-patients-form">
                                <input type="hidden" name="s_date" value=""/>
                                <input type="hidden" name="e_date" value=""/>
                                <div class="col-sm-4">
                                    <div class='input-group date'>
                                        <span class="input-group-addon">
                                            <i class="material-icons date-icon" >date_range</i>
                                        </span>
                                        <div class="form-line">
                                            <input type='text' name="start_date" class="form-control" placeholder="Ex: 2017-01-01">
                                        </div>
                                        <small style="color: red"></small>

                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="input-group date">
                                        <span class="input-group-addon">
                                            <i class="material-icons date-icon">date_range</i>
                                        </span>
                                        <div class="form-line">
                                            <input type="text" name="end_date" class="form-control" placeholder="Ex: 2017-01-01">
                                        </div>
                                        <small style="color: red"></small>
                                    </div>
                                </div>
                            </form>

                            <div class="col-sm-4">
                                <button onclick="user.search_patients()" type="button" class="btn bg-purple waves-effect">
                                    <span>Search <i class="material-icons">search</i></span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br>

            <!--date table-->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header bg-cyan" style="text-transform:uppercase;">
                            <h2>

                            </h2>
                        </div>
                        <div class="body table-responsive">
                            <table id="add-patient-table" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr style="font-size: 12px">
                                        <th>Name</th>
                                        <th>Admitted Date/Time</th>
                                        <th>Discharge Date/Time</th>
                                        <th>Details</th>
                                    </tr>
                                </thead>
                            </table>
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
<?php $this->load->view('pages/modals/fetchLoader'); ?>

<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function () {
        $('#menu-patients').removeClass().addClass('active');

        var a = 500;
        var b = 1500;
        var c = b / a;

        if (c % 1 === 0) {
            console.log(c);
            console.log("whole number");
        } else {

            console.log(parseInt(c) + 1);
            console.log("not whole number");
        }

//    $('.datepicker').datepicker().on(hide, function(e) {
//        alert("close");
//    });

//    $('.datepicker').bootstrapMaterialDatePicker({
//        format: 'MMMM DD YYYY',
//        clearButton: true,
//        weekStart: 1,
//        time: false
//    });


//    $(".dtp-btn-ok").click(function(){
//        var s_date = $('#search-proofsheet-form input[name = start_date]');
//        var e_date = $('#search-proofsheet-form input[name = end_date]');
//
////        var id = $(this).parents('.dtp').attr('id');
////        alert(id);
////    //    alert($('#test').attr('id'));
//
//        (s_date.val() != "" && e_date.val() != "") ? user.get_proofsheets() : false;
//    });
    });
</script>