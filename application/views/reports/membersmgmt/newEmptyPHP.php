<!Doctype HTML>
<html>
<body class="theme-cyan">
    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2 style="text-transform: uppercase;">
                    Members Management
                </h2>
            </div>
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header bg-cyan">
                            <h2><strong>
                                    Members List
                                </strong></h2>
                        </div>
                        <div class="row clearfix" style="padding-left:20px;padding-right:20px">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                                    <br>
                                    <label>Covered Month:</label>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class='input-group' style="padding-left:10px;padding-right:10px;padding-top:0px;">
                                            <div class="form-line">
                                                <input type="month" class="form-control form-control-sm"  id="monthid_coveredDate" name="monthname_coveredDate" value="<?= $lastmonth ?>" >
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12"></div>
                            </div>
                            
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <hr>
                                <div class="body table-responsive">
                                    <table id="member-listing-table" class="table table-bordered table-striped table-hover" >
                                        <thead class="bg-cyan">
                                            <tr>
                                                <th>PIN</th>
                                                <th>Card No</th>
                                                <th>Name</th>
                                                <th>Stocks</th>
                                                <th>Value</th>
                                                <th>Date of Membership</th>
                                                <th>Birthday</th>
                                                <th>Gender</th>
                                                <th>Address</th>
                                                <th>Mobile Number</th>
                                                <th>Email Address</th>
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
    </section>
    <footer style="margin-bottom: 10px;">
        <div>
            <center>Powered by <img src="<?= base_url('assets/img/logo.png'); ?>" width="15" height="15"/> <a href="https://www.mydrainwiz.com/">DRAiNWIZ</a>.</center>
        </div>
        <div class="clearfix"></div>
    </footer>

</body>

<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function ()
    {
            var sidemenu = $('#membersmgmt-1');
    sidemenu.removeClass().addClass('active');
    sidemenu.parents("li").removeClass().addClass('active');
    });
</script>
</html>