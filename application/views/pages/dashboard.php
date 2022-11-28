<body class="theme-cyan">
    <section class="content" id="dashmain">
        <div class="container-fluid" >
            <div class="block-header" >
                <h3>DASHBOARD</h3>
            </div>
            <div class="row clearfix" >
                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12"  >
                    <div class="info-box bg-light-green hover-expand-effect" onclick="dashboard.phic(1)">
                        <div class="icon" >
                            <i class="material-icons">people</i>
                        </div>
                        <div class="content">
                            <div class="text">Philhealth</div>
                            <div class="number count-to" data-from="0" data-to="<?= $census["nhip"] ?>" data-speed="1000" data-fresh-interval="20"></div>
                        </div>

                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                    <div class="info-box bg-green hover-expand-effect" onclick="dashboard.phic(0)">
                        <div class="icon">
                            <i class="material-icons">people</i>
                        </div>
                        <div class="content">
                            <div class="text">Non - Philhealth</div>
                            <div class="number count-to" data-from="0" data-to="<?= $census["non"] ?>" data-speed="1000" data-fresh-interval="20"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                    <div class="info-box bg-teal hover-expand-effect" onclick="dashboard.totalpatients()">
                        <div class="icon">
                            <i class="material-icons">people</i>
                        </div>
                        <div class="content">
                            <div class="text">TOTAL PATIENTS</div>
                            <div class="number count-to" data-from="0" data-to="<?= $census["nhip"] + $census["non"] ?>" data-speed="1000" data-fresh-interval="20"></div>
                        </div>
                    </div>
                </div>
                <?php if ($this->session->userdata('admin') === '1') {
                    ?>   
                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                        <div style="background-color: #FFCA28" class="info-box hover-expand-effect">
                            <div class="icon">
                                <i class="material-icons">people</i>
                            </div>
                            <div class="content">
                                <div class="text">PhilHealth AR for the Month</div>
                                <div class="number" data-fresh-interval="20" id="monthlyAR"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                        <div style="background-color: #FFC107" class="info-box hover-expand-effect" onclick="dashboard.totalaccphicAR()">
                            <div class="icon">
                                <i class="material-icons">people</i>
                            </div>
                            <div class="content">
                                <div class="text">Total Accumulated PhilHealth AR</div>
                                <div class="number " data-fresh-interval="20" id="accuPHAR"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                        <div style="background-color: #FFB300" class="info-box hover-expand-effect" onclick="dashboard.monthlyphilhealthpayments()">
                            <div class="icon">
                                <i class="material-icons">people</i>
                            </div>
                            <div class="content">
                                <div class="text">Philhealth Payments for the Month</div>
                                <div class="number " data-fresh-interval="20" id="paymentForTheMonth"></div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <div class="row clearfix">
                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header bg-cyan" >
                            <h2 style="color:white;text-transform:uppercase;">PATIENT TYPE</h2>
                        </div>
                        <div class="body">
                            <div class="row">
                                <div class="col-md-12"  >
                                    <div class='input-group'>
                                        <span class="input-group-addon">
                                            Month Cover: &nbsp;
                                        </span>
                                        <div class="form-line">
                                            <input type="month" class="form-control form-control-sm"  id="pxtypeDate" name="pxtypeDate" value="<?= $lastmonth ?>" onchange="getPxType()"/>
                                        </div>
                                        <small style="color: red"></small>
                                    </div>
                                    <label>Total: </label> <b><u> <span id="totalPatient"></span> Patient(s)</u></b>
                                </div>
                                <div class="col-md-12"  >
                                    <label style="color:rgba(0, 188, 212, 0.8);">&#9635; IPD: <u><span id="ipdTotal"></span></u></label> | 
                                    <label style="color:rgba(233, 30, 99, 0.8);">&#9635; OPD: <u><span id="opdTotal"></span></u></label>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 hidden" id='pxtypeDiv' >
                                    <div id="legend"></div>
                                    <div id="pxtype_chart" class="flot-chart" style="height: 270px;"></div>
                                    <!--<canvas id="pxtype_chart" height="350"></canvas>-->
                                </div>
                                <div class='col-lg-12 col-md-12 col-sm-12 col-xs-12' id='pxtypeDiv_Nodata' style='height: 270px;'>
                                    <h4><center>NO DATA.<br> Please choose another month.</center></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header bg-cyan">
                            <h2 style="color:white;text-transform:uppercase;">TOTAL INCOME</h2>
                        </div>
                        <div class="body">
                            <div class="row">
                                <div class="col-md-12"  >
                                    <div class='input-group'>
                                        <span class="input-group-addon">
                                            Month Cover: &nbsp;
                                        </span>
                                        <div class="form-line">
                                            <input type="month" class="form-control form-control-sm"  id="totalIncomeDate" name="totalIncomeDate" value="<?= $lastmonth ?>" onchange="getTotalIncome()"/>
                                        </div>
                                        <small style="color: red"></small>
                                    </div>

                                    <label>Total: </label> <b><u>₱ <span id="totalIncome"></span></u></b>
                                </div>
                                <div class='col-lg-12 col-md-12 col-sm-12 col-xs-12 hidden' id='chartTotalIncome' >
                                    <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12" >
                                        <div id="totalincome_chart" style="height: 250px;"></div>
                                    </div>
                                    <div class="col-md-4 col-sm-12"  >
                                        <label style="color:#F91B05;">&#9635;</label>  <b><span id="drugsmedsA"></span></b><br><small id="drugsmedsN"></small>
                                        <br>
                                        <label style="color:#F99505;">&#9635;</label>  <b><span id="medsplyA"></span></b><br><small id="medsplyN"></small>
                                        <br>
                                        <label style="color:#05F910;">&#9635;</label>  <b><span id="pharmiscA"></span></b><br><small id="pharmiscN"></small>
                                        <br>
                                        <label style="color:#05A0F9;">&#9635;</label>  <b><span id="labA"></span></b><br><small id="labN"></small>
                                        <br>
                                        <label style="color:#8605F9;">&#9635;</label>  <b><span id="radA"></span></b><br><small id="radN"></small>
                                        <br>
                                        <label style="color:#F905C5;">&#9635;</label>  <b><span id="hospA"></span></b><br><small id="hospN"></small>
                                        <br>
                                        <label style="color:#4B103E;">&#9635;</label>  <b><span id="otherIncomeA"></span></b><br><small id="otherIncomeN"></small>
                                        <br>
                                    </div>
                                </div>
                                <div class='col-lg-12 col-md-12 col-sm-12 col-xs-12' id='chartTotalIncome_Nodata' style='height: 250px;'>
                                    <h4><center>NO DATA.<br> Please choose another month.</center></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row clearfix">
                <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header bg-cyan">
                            <h2 style="color:white;text-transform:uppercase;">EXPENSES</h2>
                        </div>
                        <div class="body">
                            <div class="row">
                                <div class="col-md-12"  >
                                    <div class='input-group'>
                                        <span class="input-group-addon">
                                            Month Cover: &nbsp;
                                        </span>
                                        <div class="form-line">
                                            <input type="month" class="form-control form-control-sm"  id="expenseDate" name="expenseDate" value="<?= $lastmonth ?>" onchange="getExpenses()"/>
                                        </div>
                                        <small style="color: red"></small>
                                    </div>

                                    <label>Total: </label> <b><u>₱ <span id="totalExpenses"></span></u></b>
                                </div>
                                <div class='col-lg-12 col-md-12 col-sm-12 col-xs-12 hidden' id='expensesDiv' style='height: 270px;'>
                                    <div class="col-md-8"  >
                                        <div id="genderChart" style="height: 250px;"></div>
                                    </div>
                                    <div class="col-md-4 col-sm-12"  >
                                        <label style="color:#F91B05;">&#9635;</label>  <b><span id="firstEa"></span></b><br><small id="firstEn"></small>
                                        <br>
                                        <label style="color:#F99505;">&#9635;</label>  <b><span id="secondEa"></span></b><br><small id="secondEn"></small>
                                        <br>
                                        <label style="color:#05F910;">&#9635;</label>  <b><span id="thirdEa"></span></b><br><small id="thirdEn"></small>
                                        <br>
                                        <label style="color:#05A0F9;">&#9635;</label>  <b><span id="fourthEa"></span></b><br><small id="fourthEn"></small>
                                        <br>
                                        <label style="color:#8605F9;">&#9635;</label>  <b><span id="fifthEa"></span></b><br><small id="fifthEn"></small>
                                        <br>
                                        <label style="color:#F905C5;">&#9635;</label>  <b><span id="othersEa"></span></b><br><small id="othersEn"></small>
                                        <br>
                                    </div>
                                </div>
                                <div class='col-lg-12 col-md-12 col-sm-12 col-xs-12' id='expensesDiv_Nodata' style='height: 270px;'>
                                    <h4><center>NO DATA.<br> Please choose another month.</center></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header bg-cyan">
                            <h2 style="color:white;text-transform:uppercase;">PROFIT AND LOSS</h2>
                        </div>
                        <div class="body">
                            <div class="row">
                                <div class="col-md-12"  >
                                    <div class='input-group'>
                                        <span class="input-group-addon">
                                            Month Cover: &nbsp;
                                        </span>
                                        <div class="form-line">
                                            <input type="month" class="form-control form-control-sm"  id="profitLossDate" name="profitLossDate" value="<?= $lastmonth ?>" onchange="getProfitLoss()"/>
                                        </div>
                                        <small style="color: red"></small>
                                    </div>
                                    <div class='input-group'>
                                        <span class="input-group-addon">
                                            Cost Center: &nbsp;
                                        </span>
                                        <div class="form-line">
                                            <select class="form-control show-tick" data-live-search="true" id="cmbcostCenter" name="cmbcostCenter" onchange="getProfitLoss()">
                                                <option value="">All</option>
                                                <?php
                                                for ($i = 0; $i < count($doctors); $i++) {
                                                    echo "<option value='" . $doctors[$i]["docrefno"] . ":" . $doctors[$i]["docname"] . "'>" . $doctors[$i]["docname"] . "</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <small style="color: red"></small>
                                    </div>
                                </div>

                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"  >
                                    <center>
                                        <label style="color:rgba(0, 188, 212, 0.8);">&#9635; Profit: <u><span id="profitTotal"></span></u></label> <br> 
                                        <label style="color:rgba(233, 30, 99, 0.8);">&#9635; Loss: <u><span id="lossTotal"></span></u></label>
                                    </center>
                                </div>
                                <div class='col-lg-12 col-md-12 col-sm-12 col-xs-12 hidden' id='profitLoss'>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"  >
                                        <div id="profitloss_chart" class="flot-chart"  style="height: 150px;"></div>
                                         <!--<canvas id="bar_chart" height="350"></canvas>-->
                                    </div>
                                </div>
                                <div class='col-lg-12 col-md-12 col-sm-12 col-xs-12' id='profitLoss_Nodata' style='height: 150px;'>
                                    <h4><center>NO DATA.<br> Please choose another month.</center></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- #END# Bar Chart -->
            </div>
            <!-- #END# Pie Chart -->
            <div class="row clearfix">
                <div class="col-md-12">
                    <div class="card">
                        <div class="header bg-cyan">
                            <h2 style="color:white;text-transform:uppercase;">
                                UNPREPARED ECLAIMS
                            </h2>
                        </div>
                        <div class="body table-responsive">
                            <div class="row">
                                <div class="col-md-3"  >
                                    <div class="info-box bg-green hover-expand-effect" onclick="dashboard.unpreparedclaims(1)">
                                        <div class="icon" >
                                            <i class="material-icons">people</i>
                                        </div>
                                        <div class="content">
                                            <div class="text">1 - 30 DAYS</div>
                                            <div class="number "  data-speed="1000" data-fresh-interval="20" id="day1"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3"  >
                                    <div class="info-box bg-amber hover-expand-effect" onclick="dashboard.unpreparedclaims(2)">
                                        <div class="icon" >
                                            <i class="material-icons">people</i>
                                        </div>
                                        <div class="content">
                                            <div class="text">31 - 45 DAYS</div>
                                            <div class="number "  data-speed="1000" data-fresh-interval="20" id="day31"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3"  >
                                    <div class="info-box bg-orange hover-expand-effect" onclick="dashboard.unpreparedclaims(3)">
                                        <div class="icon" >
                                            <i class="material-icons">people</i>
                                        </div>
                                        <div class="content">
                                            <div class="text">46 - 60 DAYS</div>
                                            <div class="number "  data-speed="1000" data-fresh-interval="20" id="day46"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3"  >
                                    <div class="info-box bg-deep-orange hover-expand-effect" onclick="dashboard.unpreparedclaims(4)">
                                        <div class="icon" >
                                            <i class="material-icons">people</i>
                                        </div>
                                        <div class="content">
                                            <div class="text">61 DAYS ABOVE</div>
                                            <div class="number "  data-speed="1000" data-fresh-interval="20" id="day61"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row clearfix">
                <div class="col-md-12">
                    <div class="card">
                        <div class="header bg-cyan">
                            <h2 style="color:white;text-transform:uppercase;">
                                NON-TRANSMITTED ECLAIMS
                            </h2>
                        </div>
                        <div class="body table-responsive">
                            <div class="row">
                                <div class="col-md-3"  >
                                    <div class="info-box bg-green hover-expand-effect" onclick="dashboard.pendingclaims(1)">
                                        <div class="icon" >
                                            <i class="material-icons">people</i>
                                        </div>
                                        <div class="content">
                                            <div class="text">1 - 30 DAYS</div>
                                            <div class="number "  data-speed="1000" data-fresh-interval="20" id="nontransmitted1"></div>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-md-3"  >
                                    <div class="info-box bg-amber hover-expand-effect" onclick="dashboard.pendingclaims(2)">
                                        <div class="icon" >
                                            <i class="material-icons">people</i>
                                        </div>
                                        <div class="content">
                                            <div class="text">31 - 45 DAYS</div>
                                            <div class="number "  data-speed="1000" data-fresh-interval="20" id="nontransmitted2"></div>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-md-3"  >
                                    <div class="info-box bg-orange hover-expand-effect" onclick="dashboard.pendingclaims(3)">
                                        <div class="icon" >
                                            <i class="material-icons">people</i>
                                        </div>
                                        <div class="content">
                                            <div class="text">46 - 60 DAYS</div>
                                            <div class="number "  data-speed="1000" data-fresh-interval="20" id="nontransmitted3"></div>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-md-3"  >
                                    <div class="info-box bg-deep-orange hover-expand-effect" onclick="dashboard.pendingclaims(4)">
                                        <div class="icon" >
                                            <i class="material-icons">people</i>
                                        </div>
                                        <div class="content">
                                            <div class="text">61 DAYS ABOVE</div>
                                            <div class="number "  data-speed="1000" data-fresh-interval="20" id="nontransmitted4"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row clearfix">
                <div class="col-md-12">
                    <div class="card">
                        <div class="header bg-cyan">
                            <h2 style="color:white;text-transform:uppercase;">
                                ECLAIMS STATUS (TRANSMITTED)
                            </h2>
                        </div>
                        <div class="body table-responsive">
                            <div class="row">
                                <div class="col-md-12"  >
                                    <div class='input-group'>
                                        <span class="input-group-addon">
                                            Month Cover: &nbsp;
                                        </span>
                                        <div class="form-line">
                                            <input type="month" class="form-control form-control-sm"  id="sentEclaimsDate" name="sentEclaimsDate" value="<?= $lastmonth ?>" onchange="getSentClaims()"/>
                                        </div>
                                        <small style="color: red"></small>
                                    </div>
                                </div>
                                <div class="col-md-4"  >
                                    <div class="info-box bg-cyan hover-expand-effect" onclick="dashboard.eclaimstat(1)">
                                        <div class="icon" >
                                            <i class="material-icons">people</i>
                                        </div>
                                        <div class="content">
                                            <div class="text">Sent eClaims for the Month</div>
                                            <div class="number "  data-speed="1000" data-fresh-interval="20" id="monthly"></div>
                                            <!--<div class="number"></div>-->
                                        </div>

                                    </div>
                                </div>
                                <div class="col-md-4"  >
                                    <div class="info-box bg-blue hover-expand-effect" onclick="dashboard.eclaimstat(2)">
                                        <div class="icon" >
                                            <i class="material-icons">people</i>
                                        </div>
                                        <div class="content">
                                            <div class="text">IN PROCESS STATUS</div>
                                            <div class="number "  data-speed="1000" data-fresh-interval="20" id="inprocess"></div>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-md-4"  >
                                    <div class="info-box bg-amber hover-expand-effect" onclick="dashboard.eclaimstat(3)">
                                        <div class="icon" >
                                            <i class="material-icons">people</i>
                                        </div>
                                        <div class="content">
                                            <div class="text">RTH STATUS</div>
                                            <div class="number "  data-speed="1000" data-fresh-interval="20" id="returnx"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4"  >
                                    <div class="info-box bg-red hover-expand-effect" onclick="dashboard.eclaimstat(4)">
                                        <div class="icon" >
                                            <i class="material-icons">people</i>
                                        </div>
                                        <div class="content">
                                            <div class="text">DENIED STATUS</div>
                                            <div class="number "  data-speed="1000" data-fresh-interval="20" id="denied"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4"  >
                                    <div class="info-box bg-light-green hover-expand-effect" onclick="dashboard.eclaimstat(5)">
                                        <div class="icon" >
                                            <i class="material-icons">people</i>
                                        </div>
                                        <div class="content">
                                            <div class="text">WITH VOUCHER STATUS</div>
                                            <div class="number "  data-speed="1000" data-fresh-interval="20" id="voucher"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="info-box bg-green hover-expand-effect" onclick="dashboard.eclaimstat(6)">
                                        <div class="icon">
                                            <i class="material-icons">people</i>
                                        </div>
                                        <div class="content">
                                            <div class="text">WITH CHEQUE STATUS</div>
                                            <div class="number "  data-speed="1000" data-fresh-interval="20" id="wcheque"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header bg-cyan">
                            <h2 style="color:white;text-transform:uppercase;">
                                Admissions/Discharges of the Day
                            </h2>
                        </div>
                        <div class="body table-responsive">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class='input-group'>
                                        <span class="input-group-addon">
                                            Month Cover: &nbsp;
                                        </span>
                                        <div class="form-line">
                                            <input type="date" class="form-control form-control-sm"  id="admitDischaDate" name="admitDischaDate" value="<?= $yesss ?>" onchange="getAdmitDischargeDaily()"/>
                                        </div>
                                        <small style="color: red"></small>
                                    </div>
                                    <label>Total: </label> <b><u> <span id="totalPatient"></span> Patient(s)</u></b>
                                </div>
                                <div class="col-md-12">
                                    <table class="table table-bordered table-hover" id="disad-table">
                                        <thead>
                                            <tr>
                                                <th>TYPE</th>
                                                <th><center>PHIC</center></th>
                                        <th><center>NON-PHIC</center></th>
                                        <th><center>TOTAL</center></th>
                                        </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row clearfix hidden" id="philhealth">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header bg-cyan">
                            <h2 style="color:white;text-transform:uppercase;">
                                Philhealth Patients
                            </h2>
                        </div>
                        <div class="body table-responsive">
                            <form id="px-form" action="<?= base_url("user/generate_px_report") ?>" method="POST" target="_blank">
                                <input type="hidden" name="search" value=""/>
                            </form>
                            <a class="report-btn" href="javascript:void(0)" target="_blank">
                                <button onclick="user.get_px_report()" style="height: 25px" type="button" class="btn bg-pink waves-effect">
                                    <i style="margin-top: -25px;" class="material-icons">picture_as_pdf</i>
                                </button>
                            </a>
                            <!--<a class="report-btn" href="javascript:void(0)" target="_blank"><button onclick="user.get_px_report()">Preview Pdf</button></a>-->
                            <table id="philhealth-table" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr style="font-size: 12px">
                                        <th>Patient Name</th>
                                        <th>Admission Date</th>
                                        <th>Patient Classification</th>
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
                            <h2 style="color:white;text-transform:uppercase;">
                                Patients Census
                            </h2>
                        </div>
                        <div class="body">
                            <div class="chart-container" style="position: relative;margin: auto;height: 50vh;width: 70vw;">
                                <canvas id="myChart"></canvas>
                            </div>
                        </div> 
                    </div>
                </div>
            </div>
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header bg-cyan">
                            <h2 style="color:white;text-transform:uppercase;">
                                Census for the last 30 days
                            </h2>
                        </div>
                        <div class="body table-responsive">

                            <table id="census-table" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr style="font-size: 12px">
                                        <th>Date &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                        <th>PHIC</th>
                                        <th>NON</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php for ($i = 0; $i < count($census_month); $i++) { ?>
                                        <tr>
                                            <td><?= $census_month[$i]["datex"] ?></td> 
                                            <td><?= $census_month[$i]["nhip"] ?></td> 
                                            <td><?= $census_month[$i]["non"] ?></td> 
                                            <td><?= $census_month[$i]["totalx"] ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header bg-cyan">
                            <h2 style="color:white;text-transform:uppercase;">
                                Monthly Census
                            </h2>
                        </div>
                        <div class="body">
                            <div class="chart-container" style="position: relative;margin: auto;height: 50vh;width: 70vw;">
                                <canvas id="myMChart"></canvas>
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

<?php $this->load->view('pages/modals/admittedpatientday'); ?>
<?php $this->load->view('pages/modals/eachDayPatCensus'); ?>
<?php $this->load->view('pages/modals/philhealthpatients'); ?>
<?php $this->load->view('pages/modals/totalpatients'); ?>
<?php $this->load->view('pages/modals/unpreparedclaims'); ?>
<?php $this->load->view('pages/modals/pendingclaims'); ?>
<?php $this->load->view('pages/modals/eclaimstat'); ?>
<?php $this->load->view('pages/modals/totalaccuphicar'); ?>
<?php $this->load->view('pages/modals/monthlyphilhealthpayments'); ?>
<?php $this->load->view('pages/modals/profitloss'); ?>

<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function () {
        $('.count-to').countTo();
        $('#menu-dashboard').removeClass().addClass('active');

        load_script("http://192.168.2.111:3777/drainwizv2/assets/vendors/js/responsive.js", 3, 0);


//    
        chart.create_chart();
        chart.monthly_census_chart();


    });
</script>