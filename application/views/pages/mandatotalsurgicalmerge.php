<body class="theme-cyan">
    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2 style="text-transform: uppercase;">
                    Total Surgical Sterilization
                </h2>
            </div>


            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header bg-cyan" style="text-transform:uppercase;">
                            <h2>
                                <span style="color:red;"> E.1.  </span> Total Surgical Sterilization
                            </h2>
                        </div>


                        <div class="body table-responsive">
                            <div>
                                <button  type="button" class="btn bg-purple waves-effect " onclick="totalsurg.preview_table()"  >
                                    <span><i class="material-icons">remove_red_eye</i> Preview </span>
                                </button>
                            </div>
                            <br>
                            <div>
                                Month: <b><u><?= $monthx ?></u></b>
                                <input type="hidden" id="txtmonth" name="txtmonth" value="<?= $monthxx ?>"/>
                            </div>

                            <table id="total-surgical-merge-table" class="table table-bordered table-striped table-hover">
                                <thead style="text-align: center;">
                                    <tr>
                                        <th><input type="checkbox" id="check-all" class="filled-in chk-col-blue" /><label style="margin-right: -100px; margin-bottom: -10px" for="check-all"></label></th>
                                        <th>CATEGORY</th>
                                        <th>DIAGNOSIS</th>
                                        <th>ACCOUNT NUMBER</th>
                                        <th>PATIENT NAME</th>
                                        <th>DISCHARGE DATE</th>
                                        <th>MEMBERSHIP</th>
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

                        <div class="body container-fluid">


                            <div class="col-sm-3">
                                <!--                                 <form id="merge-total-surgical-form">
                                
                                                                    <input type='hidden' name="confinenhip" class="form-control" id="nhip">
                                                                    <input type='hidden' name="confinenon" class="form-control" id="non">
                                                                    <input type='hidden' name="total" class="form-control" id="totalpat">
                                                                </form>-->
                                <button onclick="totalsurg.merge_bilateral()" type="button" class="btn bg-purple waves-effect btn-block "  >
                                    BILATERAL TUBAL LIGATION 
                                </button>

                            </div>
                            <div class="col-sm-3">

                                <button onclick="totalsurg.merge_vasectomy()" type="button" class="btn bg-purple waves-effect btn-block "  id="merging" >
                                    VASECTOMY 
                                </button>
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
<?php $this->load->view('pages/modals/expounddiag'); ?>

<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function () {

        var sidemenu = $('#mandatory-7');
        sidemenu.removeClass().addClass('active');
        sidemenu.parents("li").removeClass().addClass('active');

        totalsurg.get_total_surgical_merge();

    });
</script>











