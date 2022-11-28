<body class="theme-cyan">
    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2 style="text-transform: uppercase;">
                    Quality Assurance Indicator
                </h2>
            </div>

            <!--patient classifiaction table-->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header bg-cyan" style="text-transform:uppercase;">
                            <h2>
                                <b> B. QUALITY ASSURANCE INDICATOR</b>
                            </h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header bg-cyan" style="text-transform:uppercase;">
                            <h2>
                                Covered Month
                            </h2>
                        </div>
                        <div class="body container-fluid">
                            <form id="search-quality-form"  method="POST" >
                                <input type="hidden" name="s_date" value=""/>

                                <div class="col-sm-4">
                                    <div class='input-group datex'>
                                        <span class="input-group-addon">
                                            <i class="material-icons date-icon" >date_range</i>
                                        </span>
                                        <div class="form-line">
                                            <input type='text' name="start_date" class="form-control" value="<?= $cur_date ?>">
                                        </div>
                                        <small style="color: red"></small>

                                    </div>
                                </div>

                            </form>

                            <div class="col-sm-4">
                                <button onclick="quality.search_quality_census()" type="button" class="btn bg-purple waves-effect">
                                    <span>Search <i class="material-icons">search</i></span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header bg-cyan" style="text-transform:uppercase;">
                            <h4>
                                1. Monthly Bed Occupancy Rate (MBOR) = <u><span id="mbor" ><?= $mbor ?></span>%</u>
                            </h4>
                        </div>
                        <div class="body table-responsive">
                            <table id="daily-census-table" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <td rowspan="2" class="align-middle"><center>MBOR</center></td>
                                <td colspan="3"><center>Total of NHIP Census plus Total of Non-NHIP Census 
                                    (<b><span id="px" ><?= $px ?></span></b>)
                                </center>
                                </td>
                                <td rowspan="2"><center>x 100</center></td>
                                </tr>
                                <tr>
                                    <td style="border-top: dotted black;"><center>Number of Days per Month Indicated multiplied by Number of DOH Authorized Beds ( <b><span id="dd" ><?= $dd ?></span> * <span id="DOHauthorizedbed" ><?= $DOHauthorizedbed ?></span></b>)
                                </center></td>
                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 2 -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header bg-cyan" style="text-transform:uppercase;">
                            <h4>
                                2. Monthly NHIP Beneficiary Occupancy Rate (MNHIBOR) = <u><span id="MNHIBOR" ><?= $MNHIBOR ?></span>%</u>
                            </h4>
                        </div>
                        <div class="body table-responsive">
                            <table id="daily-census-table" class="table table-bordered table-striped table-hover">
                                <thead>

                                    <tr>
                                        <td rowspan="2" class="align-middle"><center>MNHIBOR</center></td>
                                <td colspan="3"><center>Total of NHIP Census  (<b><span id="phic" ><?= $phic ?></span></b>)</center></td>

                                <td rowspan="2"><center>x 100</center></td>
                                </tr>
                                <tr>
                                    <td style="border-top: dotted black;"><center>Number of Days per Month Indicated multiplied by Number of PHIC Accredited Beds ( <b><span id="dae" ><?= $dd ?></span> * <span id="authorizedbed" ><?= $authorizedbed ?></span></b>)</center></td>
                                </tr>
                                </thead>
                            </table>
                        </div>


                    </div>
                </div>
            </div>

            <!-- 3 -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header bg-cyan" style="text-transform:uppercase;">
                            <h4>
                                3. Average Length of Stay per NHIP Patient (ALSP) = <u><span id="alspp" ><?= $alspp ?></span>%</u>
                            </h4>
                        </div>
                        <div class="body table-responsive">
                            <table id="daily-census-table" class="table table-bordered table-striped table-hover">
                                <thead>

                                    <tr>
                                        <td rowspan="2" class="align-middle"><center>ALSP</center></td>
                                <td colspan="3"><center> Total of NHIP Census (<b><span id="phicc" ><?= $phic ?></span></b>)</center></td>


                                </tr>
                                <tr>
                                    <td style="border-top: dotted black;"><center>Total of NHIP Discharges (<b><span id="dispat" ><?= $dispat ?></span></b>)</center></td>
                                </tr>
                                </thead>
                            </table>
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
<?php $this->load->view('pages/modals/transmitinfo'); ?>

<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function () {
        //load_room_percentage_script("http://192.168.2.111:3777/drainwizv2/assets/vendors/js/responsive.js");
        var sidemenu = $('#mandatory-3');
        sidemenu.removeClass().addClass('active');
        sidemenu.parents("li").removeClass().addClass('active');




    });
</script>











