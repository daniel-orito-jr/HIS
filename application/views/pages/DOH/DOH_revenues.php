<body class="theme-cyan">
     <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <ol class="breadcrumb breadcrumb-col-cyan">
                    <li>Reports</li>
                    <li>DOH Annual Hospital Statistical Report</li>
                    <li>III. Hospital Operations</li>
                    <li class="active">Revenues</li>
                </ol>
            </div>
            <div class="row clearfix">
                 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                               V. REVENUES
                                <small>Please report the total revenue this facility collected last year. This includes all monetary resources acquired by this facility from all sources, and for all purposes.</small>
                            </h2>
                        </div>
                        <div class="body container-fluid">
                            <form id="search-daily-form"  method="POST" >
                               <input type="hidden" name="s_date" value=""/>
                               <div class="col-sm-4">
                                    <div class='input-group date'>
                                        <span class="input-group-addon">
                                            <i class="material-icons date-icon">date_range</i>
                                        </span>
                                        <div class="form-line">
                                            <input type='text' name="start_date" class="form-control" value="<?= $cur_date ?>">
                                        </div>
                                        <small style="color: red"></small>
                                        
                                    </div>
                                </div>
                            </form>
                            <div class="col-sm-4">
                                <button onclick="mandadaily.search_daily_census()" type="button" class="btn bg-purple waves-effect">
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
                        <div class="body">
                            <div class="row clearfix">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="body table-responsive">
                                        <table id="return-table" class="table table-bordered table-striped table-hover">
                                            <thead style="font-size:12px;">
                                                <tr>
                                                    <th>Revenues</th>
                                                    <th>Amount in Pesos</th>
                                                </tr>
                                            </thead>
                                            <tbody style="font-size: 12px">
                                                <tr>
                                                    <td>Total amount of money received from the Department of Health</td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td>Total amount of money received from the local government.</td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td>Total amount of money received from donor agencies (for example JICA, USAID, and others)</td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td>Total amount of money received from private organizations (donations from businesses, NGOs, etc.)</td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td>Total amount of money received from Phil Health.</td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td>Total amount of money received from direct patient/out-of-pocket charges/fees</td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td>Total amount of money received from reimbursement from private insurance/HMOs</td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td>Total amount of money received from other sources (PDAF, PCSO, etc.)</td>
                                                    <td></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>

<?php $this->load->view('pages/modals/fetchLoader'); ?>

<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function () {
   var sidemenu = $('#DOH-6');
    sidemenu.removeClass().addClass('active');
    sidemenu.parents("li").removeClass().addClass('active');

});
</script>