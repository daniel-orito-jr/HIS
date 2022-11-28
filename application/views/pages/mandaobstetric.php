<body class="theme-cyan">
    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2 style="text-transform: uppercase;">
                    Obstetrical Procedures
                </h2>
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
                            <form id="search-obstetrical-form"  method="POST" >
                                <input type="hidden" name="s_date" value="<?= $cur_date ?>"/>

                                <div class="col-sm-4">
                                    <div class='input-group datex'>
                                        <span class="input-group-addon">
                                            <i class="material-icons date-icon" >date_range</i>
                                        </span>
                                        <div class="form-line">
                                            <input type='text' name="start_date" class="form-control" value="<?= $monthx ?>">
                                        </div>
                                        <small style="color: red"></small>

                                    </div>
                                </div>

                            </form>

                            <div class="col-sm-4">
                                <button onclick="obstetric.search_obstetrical_procedures()" type="button" class="btn bg-purple waves-effect">
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
                            <h2>
                                F. Obstetrical Procedures
                            </h2>
                        </div>
                        <div class="body table-responsive">
<!--                            <a href="<?= base_url('user/mandaobstetricmerge') ?>" target="_blank" id="btnEdit" >
                                <button  type="button" class="btn bg-purple waves-effect ">
                                    <span>Edit <i class="material-icons">mode_edit</i></span>
                                </button>
                            </a>
                            <hr>-->
                            <table id="top-ob-table" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr >
                                        <th rowspan="2"><center>Obstetrical Procedure</center></th>
                                <th colspan="2"><center>No. of Patients</center></th>
                                </tr>
                                <tr>
                                    <th class="align-middle"><center>NHIP</center></th>
                                <th ><center>NON-NHIP</center></th>
                                </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><span style="color:red;">F.1.</span>TOTAL NUMBER OF DELIVERIES (NSD plus CAESARIAN SECTION)</td>
                                        <td><center><?php if ($obprocedure['nhip'] > 0) {
    echo $obprocedure['nhip'];
} else {
    echo "0";
} ?></center></td>
                                <td><center><?php if ($obprocedure['non'] > 0) {
    echo $obprocedure['non'];
} else {
    echo "0";
} ?></center></td>
                                </tr>
                                <tr>
                                    <td  ><span style="color:red;">F.2.</span>TOTAL NUMBER OF CAESARIAN CASES</td>
                                    <td><center><?php if ($cs['nhip'] > 0) {
    echo $cs['nhip'];
} else {
    echo "0";
} ?></center></td>
                                <td><center><?php if ($cs['non'] > 0) {
                                    echo $cs['non'];
                                } else {
                                    echo "0";
                                } ?></center></td>
                                </tr>
                                <tr>

                                    <td >&nbsp; &nbsp; &nbsp; &#9632; INDICATION FOR CS:</td>
                                    <td></td>
                                    <td></td>
                                </tr>

<?php
if (count($indication) !== 0) {
    $count = 0;
    foreach ($indication as $indication) {
        $count++;
        ?>
                                        <tr>
                                            <td>&nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; <b> <?= $count ?>.</b> <?= $indication["categdiag"] ?></td> 
                                            <td ><center><?= $indication["nhip"] ?></center></td> 
                                        <td ><center><?= $indication["non"] ?></center></td> 
                                        </tr>
        <?php
    }
} else {
    ?>
                                    <tr>
                                        <td colspan="4"><center>No records found</center></td>
                                    </tr>
<?php } ?>
                                </tbody>


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
<?php $this->load->view('pages/modals/transmitinfo'); ?>

<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function () {
        // load_room_percentage_script("http://192.168.2.111:3777/drainwizv2/assets/vendors/js/responsive.js");
        var sidemenu = $('#mandatory-8');
        sidemenu.removeClass().addClass('active');
        sidemenu.parents("li").removeClass().addClass('active');




    });
</script>











