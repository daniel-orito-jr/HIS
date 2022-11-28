<body class="theme-cyan">
     <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <ol class="breadcrumb breadcrumb-col-cyan">
                    <li><a href="javascript:void(0);"> Mandatory Monthly Hospital Report</a></li>
                    <li class="active">Most common causes of Confinement</li>
                </ol>
            </div>
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                D. Most Common Causes of Confinement
                            </h2>
                        </div>
                        <div class="body table-responsive">
                            <div>
                                <button  type="button" class="btn bg-purple waves-effect " onclick="confine.preview_table_confinement()"  >
                                    <span><i class="material-icons">remove_red_eye</i> Preview </span>
                                    </button>
                                </div>
                            <br>
                            <div>
                                Month: <b><u><?= $monthx ?></u></b>
                                <input type="hidden" id="txtmonth" name="txtmonth" value="<?= $monthxx ?>"/>
                            </div>
                            <table id="Confinement-causes-table" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" id="check-all" class="filled-in chk-col-blue" /><label style="margin-right: -100px; margin-bottom: -10px" for="check-all"></label></th>
                                        <th>DIAGNOSIS &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                        <th>ACCOUNT NUMBER </th>
                                        <th>PATIENT NAME</th>
                                        <th>DISCHARGE DATE</th>
                                        <th>MEMBERSHIP</th>
                                        <th>ID</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row clearfix" id="divadd" hidden>
                 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                      
                        <div class="body container-fluid">
                            <button onclick="confine.mergeconfine()" type="button" class="btn bg-purple waves-effect btn-block " id="adddiagname"  >
                                    <span>Merge <i class="material-icons">merge_type</i></span>
                                </button>
                             
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
<?php $this->load->view('pages/modals/expounddiag'); ?>
<?php $this->load->view('pages/modals/diagl'); ?>
<?php $this->load->view('pages/modals/confinelist'); ?>

<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function () {
   
   var sidemenu = $('#mandatory-5');
    sidemenu.removeClass().addClass('active');
    sidemenu.parents("li").removeClass().addClass('active');
    confine.get_confinement_causes();
  
});
</script>











