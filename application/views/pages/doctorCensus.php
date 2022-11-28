<body class="theme-cyan">
     <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2 style="text-transform: uppercase;">
                    Doctor's patients
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
                            <form id="search-doctor-form">
                                 <input type="hidden" name="s_date" value=""/>
                                <input type="hidden" name="e_date" value=""/>
                                <div class="col-sm-4">
                                    <div class='input-group date'>
                                        <span class="input-group-addon">
                                            <i class="material-icons date-icon" >date_range</i>
                                        </span>
                                        <div class="form-line">
                                            <input type='text' name="start_date" class="form-control" value="<?= $cur_date ?>">
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
                                            <input type="text" name="end_date" class="form-control" value="<?= $cur_date ?>">
                                        </div>
                                         <small style="color: red"></small>
                                    </div>
                                </div>
                            </form>
                            
                            <div class="col-sm-4">
                                <button onclick="user.search_doctor_census()" type="button" class="btn bg-purple waves-effect">
                                    <span>Search <i class="material-icons">search</i></span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!--doctors table-->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header bg-cyan" style="text-transform:uppercase;">
                           <h2>
                                Patient Classification <span class="class-total"></span>
                                    <div class="col-sm-4" style="float:right;">
                                        <form id="search-doctorx-form">
                                            <select class="form-control show-tick" data-live-search="true" id="expertlist" name="expertlist" onchange="user.search_expertise()">
                                                <option value="All">All Doctors</option>
                                                    <?php
                                                    for($i=0;$i<count($expertise);$i++)
                                                    {
                                                        echo "<option value='".$expertise[$i]["expertise"]."'>".$expertise[$i]["expertise"]."</option>";
                                                    }
                                                    ?>
                                            </select>
                                        </form>
                                    </div>
                            </h2>
                        </div>
                        <div class="body table-responsive">
                            <form id="doctor-form" action="<?= base_url("user/generate_doc_report") ?>" method="POST" target="_blank">
                                <input type="hidden" name="s_date" value=""/>
                                <input type="hidden" name="e_date" value=""/>
                                <input type="hidden" name="search" value=""/>
                                <input type="hidden" name="exp" value=""/>
                            </form>
                            <a class="report-btn" href="javascript:void(0)" target="_blank">
                                <button onclick="user.get_doc_report()" style="height: 25px" type="button" class="btn bg-pink waves-effect">
                                    <i style="margin-top: -25px;" class="material-icons">picture_as_pdf</i>
                                </button>
                            </a>
                            <!--<a class="report-btn" href="javascript:void(0)" target="_blank"><button onclick="user.get_doc_report()">Preview Pdf</button></a>-->
                            <table id="doctor-table" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr style="font-size: 12px">
                                        <th>Doctors Ref No</th>
                                        <th>Name &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                        <th>Expertise</th>
                                        <th>PHIC</th>
                                        <th>Non-PHIC</th>
                                        <th>Total Patient</th>
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
<?php $this->load->view('pages/modals/doctorspatient'); ?>

<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function () {
    var sidemenu = $('#census-2');
    sidemenu.removeClass().addClass('active');
    sidemenu.parents("li").removeClass().addClass('active');
    
    $(".dtp-btn-ok").click(function(){
        var s_date = $('#search-record-form input[name = start_date]');
        var e_date = $('#search-record-form input[name = end_date]');

//        var id = $(this).parents('.dtp').attr('id');
//        alert(id);
//    //    alert($('#test').attr('id'));

        (s_date.val() != "" && e_date.val() != "") ? user.get_records() : false;
    });
});
</script>
