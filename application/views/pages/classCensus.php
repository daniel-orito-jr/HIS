<body class="theme-cyan">
     <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2 style="text-transform: uppercase;">
                    Px Classification & Disposition
                </h2>
            </div>

            <div class="row clearfix">
                 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header bg-cyan">
                            <h2 style="color:white;">
                                Covered Date
                            </h2>
                        </div>
                        <div class="body container-fluid">
                           
                            
                             <form id="search-class-form"  method="POST" >
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
                                <button onclick="user.search_class_census()" type="button" class="btn bg-purple waves-effect">
                                    <span>Search <i class="material-icons">search</i></span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
 

            <!--patient classifiaction table-->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header bg-cyan">
                            <h2 style="color:white; text-transform: uppercase;">
                                Patient Classification <span class="class-total"></span>
                                    <div class="col-sm-4" style="float:right;">
                                        <form id="search-doctorx-form">
                                            <select class="form-control show-tick" data-live-search="true" id="doclist" name="doclist" onchange="user.search_doctors()">
                                                <option value="All:All">All Doctors</option>
                                                    <?php
                                                    for($i=0;$i<count($doctors);$i++)
                                                    {
                                                        echo "<option value='".$doctors[$i]["docrefno"].":".$doctors[$i]["docname"]."'>".$doctors[$i]["docname"]."</option>";
                                                    }
                                                    ?>
                                            </select>
                                        </form>
                                    </div>
                            </h2>

                        </div>
                        <div class="body table-responsive">
                            <form id="px-classification-form" action="<?= base_url("user/generate_class_report") ?>" method="POST" target="_blank">
                                <input type="hidden" name="s_date" value=""/>
                                <input type="hidden" name="e_date" value=""/>
                                <input type="hidden" name="dokie" value=""/>
                                <input type="hidden" name="dokiename" value=""/>
                            </form>
                            <a class="report-btn" href="javascript:void(0)" target="_blank">
                                <button onclick="user.get_class_report()" style="height: 25px" type="button" class="btn bg-pink waves-effect">
                                    <i style="margin-top: -25px;" class="material-icons">picture_as_pdf</i>
                                </button>
                            </a>

                            <table id="px-classification-table" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr style="font-size: 12px">
                                        <th>Classification</th>
                                        <th>Counts</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header bg-cyan">
                            <h2 style="color:white;">
                                PATIENT DISPOSITION <span class="dispo-total"></span>
                                 <div class="col-sm-4" style="float:right;">
                                        <form id="search-doctorx_disposition-form">
                                            <select class="form-control show-tick" data-live-search="true" id="doclist_dispo" name="doclist_dispo" onchange="user.search_doctors_dispo()">
                                                <option value="All:All">All Doctors</option>
                                                    <?php
                                                    for($i=0;$i<count($doctors);$i++)
                                                    {
                                                        echo "<option value='".$doctors[$i]["docrefno"].":".$doctors[$i]["docname"]."'>".$doctors[$i]["docname"]."</option>";
                                                    }
                                                    ?>
                                            </select>
                                        </form>
                                    </div>
                            </h2>

                        </div>
                        <div class="body table-responsive">
                            <form id="px-disposition-form" action="<?= base_url("user/generate_dispo_report") ?>" method="POST" target="_blank">
                                <input type="hidden" name="s_date" value=""/>
                                <input type="hidden" name="e_date" value=""/>
                                <input type="hidden" name="dokie" value=""/>
                                <input type="hidden" name="dokiename" value=""/>
                            </form>
                            <a class="report-btn" href="javascript:void(0)" target="_blank">
                                <button onclick="user.get_dispo_report()" style="height: 25px" type="button" class="btn bg-pink waves-effect">
                                    <i style="margin-top: -25px;" class="material-icons">picture_as_pdf</i>
                                </button>
                            </a>

                            <table id="px-disposition-table" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr style="font-size: 12px">
                                        <th>Disposition</th>
                                        <th>Counts</th>
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
<?php $this->load->view('pages/modals/classificationinformation'); ?>
<?php $this->load->view('pages/modals/dispoinfo'); ?>

<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function () {
    var sidemenu = $('#census-3');
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
