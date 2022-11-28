<body class="theme-cyan">
    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2 style="text-transform: uppercase;">
                    AR/AP SUMMARY ACCOUNT AGING
                </h2>
            </div>
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <form id="search-arapsummary-form"  method="POST" >
                            <div class="col-sm-4">
                                <div class='input-group'>

                                    <span class="input-group-addon">
                                        Month Cover: &nbsp;

                                    </span>
                                    <div class="form-line">
                                        <!--<input type='text' name="start_date" class="form-control" value="<?= $cur_date ?>" onchange="" >-->
                                        <input type="month" class="form-control form-control-sm"  id="start_date" name="start_date" value="<?= date('Y-m') ?>" onchange="summaryacctaging.acctngagingx()"/>
                                    </div>
                                    <small style="color: red"></small>

                                </div>
                            </div>
                        </form>
                        <div class="body container-fluid">
                            <div class="col-md-12">
                                <div class="col-md-4">
                                    <p>
                                        <b>Grouping</b>
                                    </p>
                                    <select class="form-control show-tick" data-live-search="true" id="cmbgrouping" onchange="summaryacctaging.grouping()">
                                        <option value="AR" selected>Accounts Receivable</option>
                                        <option value="AP">Accounts Payable</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <p>
                                        <b>Account Titles</b>
                                    </p>
                                    <select class="form-control show-tick" data-live-search="true" id="cmbaccttitle" onchange="summaryacctaging.acctngagingx()">

                                    </select>
                                </div>
                                <div class="col-md-4 hidden">
                                    <p>
                                        <b>Grouped by Aging</b>
                                    </p>
                                    <input name="group1" type="radio" id="radio_1" checked />
                                    <label for="radio_1">Selective Account</label> &nbsp;&nbsp;
                                    <input name="group1" type="radio" id="radio_2" />
                                    <label for="radio_2">ALL Account</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row clearfix hidden" id="tbl-acctaging">
                <div class="col-md-12" >
                    <div class="card">
                        <div class="header">
                            <div class="row clearfix" >
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Total At Risk</label>
                                        <div class="form-line">
                                            <b><input type="text" class="form-control text-success"   id="txttotalatrisk" readonly/></b>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Total Current</label>
                                        <div class="form-line">
                                            <b><input type="text" class="form-control text-success"  id="txttotalcurrent" readonly/></b>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Total 1-30 Days</label>
                                        <div class="form-line">
                                            <b><input type="text" class="form-control text-success"  id="txttotal130days" readonly/></b>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Total 31-45 Days</label>
                                        <div class="form-line">
                                            <b><input type="text" class="form-control text-success" id="txttotal3145days" readonly/></b>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Total 46-60 Days</label>
                                        <div class="form-line">
                                            <b><input type="text" class="form-control text-success"  id="txttotal4660days" readonly/></b>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Total 61-90 Days</label>
                                        <div class="form-line">
                                            <b><input type="text" class="form-control text-success"  id="txttotal6190days" readonly/></b>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Total 91-120 Days</label>
                                        <div class="form-line">
                                            <b><input type="text" class="form-control text-success"  id="txttotal91120days" readonly/></b>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Total 120 Days Above</label>
                                        <div class="form-line">
                                            <b><input type="text" class="form-control text-success"  id="txttotal120daysabove" readonly/></b>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="body table-responsive" >
                            <input type="checkbox"  class="filled-in" id="showzero"  onchange="summaryacctaging.checkboxx()"/>
                            <label for="showzero">Show Zero Balance Accounts</label>
                            <table class="table table-striped table-header-rotated" id="acctngaging-table" style="width:100%; white-space: nowrap;">
                                <thead style="font-size:12px;background-color:#007d72;color:white;">
                                    <tr>
                                        <th><center>Item</center></th>
                                <th><center>COA Name</center></th>
                                <th><center>Account</center></th>
                                <th><center>Type</center></th>
                                <th><center>Balance</center></th>
                                <th><center>Number of Days</center></th>
                                <th><center>Current</center></th>
                                <th><center>1-30</center></th>
                                <th><center>31-45</center></th>
                                <th><center>46-60</center></th>
                                <th><center>61-90</center></th>
                                <th><center>91-120</center></th>
                                <th><center>120 days above</center></th>
                                <th><center>Updated By</center></th>
                                <th><center>Updated Date</center></th>
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
        summaryacctaging.grouping();
        summaryacctaging.acctngagingx();
        var sidemenu = $('#armonitoring-1');
        sidemenu.removeClass().addClass('active');
        sidemenu.parents("li").removeClass().addClass('active');
    });
</script>
