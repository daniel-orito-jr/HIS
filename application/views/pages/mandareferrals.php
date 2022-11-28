<body class="theme-cyan">
    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2 style="text-transform: uppercase;">
                    Referrals
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
                            <form id="search-referrals-form"  method="POST" >
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
                                <button onclick="refer.search_referral_census()" type="button" class="btn bg-purple waves-effect">
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
                                H. Referrals
                            </h2>
                        </div>
                        <div class="body table-responsive">
                            <table id="referrals-table" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr >
                                        <th rowspan="2"><center>Most Common Reasons for Referral</center></th>
                                <th colspan="2"><center>No. of Patient Referred</center></th>
                                </tr>
                                <tr>
                                    <th class="align-middle"><center>NHIP</center></th>
                                <th ><center>NON-NHIP</center></th>


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

        var sidemenu = $('#mandatory-10');
        sidemenu.removeClass().addClass('active');
        sidemenu.parents("li").removeClass().addClass('active');

        refer.get_referrals();

    });
</script>











