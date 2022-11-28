<body class="theme-cyan">
    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2 style="text-transform: uppercase;">
                    Room Occupational Statistics
                </h2>
            </div>
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                Covered Date
                            </h2>
                        </div>
                        <div class="body container-fluid">

                            <form id="search-ros-form">
                                <input type="hidden" name="s_date" value=""/>
                                <div class="col-sm-4">
                                    <div class='input-group date'>
                                        <span class="input-group-addon">
                                            <i class="material-icons date-icon" >date_range</i>
                                        </span>
                                        <div class="form-line">
                                            <input type='text' name="date" class="form-control" placeholder="Ex: 2017-01-01">
                                        </div>
                                        <small style="color: red"></small>

                                    </div>
                                </div>
                            </form>


                            <div class="col-sm-2">
                                <button onclick="user.search_ros_census()" type="button" class="btn bg-purple waves-effect">
                                    <span>Search <i class="material-icons">search</i></span>
                                </button>
                            </div>

                            <div class="col-sm-6">
                                <div class="card" style="background-color: #FFEBEE; color: red">
                                    <div style="padding: 7px" class="header">
                                        <strong style="color: red">
                                            Note:
                                        </strong>
                                    </div>
                                    <div style="padding: 7px; color: red" class="body container-fluid">
                                        Table shows only records <strong>5 days</strong> before including the date you've selected. 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                Occupational Records
                                <!--<small>You can use different animation class. We used Animation.css which link is <a href="https://daneden.github.io/animate.css/" target="_blank">https://daneden.github.io/animate.css/</a></small>-->
                            </h2>
                        </div>
                        <div class="body">
                            <div class="row clearfix">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <!-- Nav tabs -->
                                    <ul class="nav nav-tabs tab-nav-right" role="tablist">
                                        <li id="day1-tab" role="presentation" class="active"><a href="#home_animation_1" data-toggle="tab">Day 1</a></li>
                                        <li id="day2-tab" role="presentation"><a href="#profile_animation_1" data-toggle="tab">Day 2</a></li>
                                        <li id="day3-tab" role="presentation"><a href="#messages_animation_1" data-toggle="tab">Day 3</a></li>
                                        <li id="day4-tab" role="presentation"><a href="#settings_animation_1" data-toggle="tab">Day 4</a></li>
                                        <li id="day5-tab" role="presentation"><a href="#day5_animation_1" data-toggle="tab">Day 5</a></li>
                                    </ul>

                                    <!-- Tab panes -->
                                    <div class="tab-content">
                                        <div role="tabpanel" class="tab-pane animated active" id="home_animation_1">
                                            <div class="body table-responsive">
                                                <table id="ros1-table" class="table table-bordered table-striped table-hover">
                                                    <thead>
                                                        <tr style="font-size: 12px">
                                                            <th>Room No.</th>
                                                            <th>Occupied Beds</th>
                                                            <th>No. of Beds</th>
                                                            <th>Occupancy Rate</th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                        <div role="tabpanel" class="tab-pane animated" id="profile_animation_1">
                                            <div class="body table-responsive">
                                                <table id="ros2-table" class="table table-bordered table-striped table-hover">
                                                    <thead>
                                                        <tr style="font-size: 12px">
                                                            <th>Room No.</th>
                                                            <th>Occupied Beds</th>
                                                            <th>No. of Beds</th>
                                                            <th>Occupancy Rate</th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                        <div role="tabpanel" class="tab-pane animated" id="messages_animation_1">
                                            <div class="body table-responsive">
                                                <table id="ros3-table" class="table table-bordered table-striped table-hover">
                                                    <thead>
                                                        <tr style="font-size: 12px">
                                                            <th>Room No.</th>
                                                            <th>Occupied Beds</th>
                                                            <th>No. of Beds</th>
                                                            <th>Occupancy Rate</th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                        <div role="tabpanel" class="tab-pane animated" id="settings_animation_1">
                                            <div class="body table-responsive">
                                                <table id="ros4-table" class="table table-bordered table-striped table-hover">
                                                    <thead>
                                                        <tr style="font-size: 12px">
                                                            <th>Room No.</th>
                                                            <th>Occupied Beds</th>
                                                            <th>No. of Beds</th>
                                                            <th>Occupancy Rate</th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                        <div role="tabpanel" class="tab-pane animated" id="day5_animation_1">
                                            <div class="body table-responsive">
                                                <table id="ros5-table" class="table table-bordered table-striped table-hover">
                                                    <thead>
                                                        <tr style="font-size: 12px">
                                                            <th>Room No.</th>
                                                            <th>Occupied Beds</th>
                                                            <th>No. of Beds</th>
                                                            <th>Occupancy Rate</th>
                                                        </tr>
                                                    </thead>
                                                </table>
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

<?php $this->load->view('pages/modals/fetchLoader'); ?>

<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function () {
        var sidemenu = $('#menu-0-6');
        sidemenu.removeClass().addClass('active');
        sidemenu.parents("li").removeClass().addClass('active');


//    function show_calendar(){
//        $('.datepicker').focus().focus();
//    }
//

//
//    
//    
//    $('.date-icon').click(function(){
//        $('.date').bootstrapMaterialDatePicker({
//            format: 'MMMM DD YYYY',
//            clearButton: true,
//            weekStart: 1,
//            time: false
//        });
//        $('.date').focus().focus();
//    });


        $(".dtp-btn-ok").click(function () {
            var s_date = $('#search-record-form input[name = start_date]');
            var e_date = $('#search-record-form input[name = end_date]');

//        var id = $(this).parents('.dtp').attr('id');
//        alert(id);
//    //    alert($('#test').attr('id'));

            (s_date.val() != "" && e_date.val() != "") ? user.get_records() : false;
        });
    });
</script>
