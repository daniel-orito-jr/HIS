<body class="theme-cyan">
     <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <ol class="breadcrumb breadcrumb-col-cyan">
                    <li>Reports</li>
                    <li>DOH Annual Hospital Statistical Report</li>
                    <li>II. Hospital Operations</li>
                    <li class="active">C. Deaths</li>
                </ol>
            </div>
            <div class="row clearfix">
                 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                               C. DEATHS
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
                                    <p>For each category of death listed below, please report the total number of deaths.</p>
                                    <div class="body table-responsive">
                                        <table id="return-table" class="table table-bordered table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Types of deaths</th>
                                                    <th>Number</th>
                                                </tr>
                                            </thead>
                                            <tbody style="font-size: 12px">
                                                <tr>
                                                    <td>Total deaths</td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td>Total number of inpatient deaths</td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td>&#9632; Total deaths < 48 hours</td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td>&#9632; Total deaths &#8805; hours</td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td>Total number of emergency room deaths</td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td>Total number of cases declared 'dead on arrival'</td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td>Total number of stillbirths</td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td>Total number of neonatal deaths</td>
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
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h5>
                                1. Gross Death Rate = <u><span id="mbor" ></span>%</u>
                            </h5>
                        </div>
                        <div class="body table-responsive">
                            <table id="daily-census-table" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <td rowspan="2" style="vertical-align : middle;text-align:center;"><center>Gross Death Rate = </center></td>
                                        <td colspan="3"><center>Total Deaths (including newborn for a given period) ()
                                                        </center>
                                        </td>
                                        <td rowspan="2" style="vertical-align : middle;text-align:center;"><center>x 100</center></td>
                                    </tr>
                                    <tr>
                                        <td style="border-top: dotted black;"><center> Total Discharges and Deaths for the same period ()
                                                                            </center></td>
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
                        <div class="header">
                            <h5>
                                2. Net Death Rate = <u><span id="mbor" ></span>%</u>
                            </h5>
                        </div>
                        <div class="body table-responsive">
                            <table id="daily-census-table" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <td rowspan="2" style="vertical-align : middle;text-align:center;"><center>Net Death Rate = </center></td>
                                        <td colspan="3"><center>Total Deaths (including newborn for a given period) - death < 48 hours for the period ()
                                                        </center>
                                        </td>
                                        <td rowspan="2" style="vertical-align : middle;text-align:center;"><center>x 100</center></td>
                                    </tr>
                                    <tr>
                                        <td style="border-top: dotted black;"><center> Total Discharges (including deaths and newborn) - death < 48 hours for the period ()
                                                                            </center></td>
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
                        <div class="header">
                            <h5>
                                Ten Leading Causes of Mortality/Deaths and Total Number of Mortality/Deaths.
                            </h5>
                        </div>
                        <div class="body table-responsive">
                            <table id="return-table" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Cause of Morbidity/Illness/Injury</th>
                                        <th>Number</th>
                                        <th>ICD-10 Code (Individual)</th>
                                    </tr>
                                </thead>
                                <tbody style="font-size: 12px">
                                    <?php for($i=1;$i<=10;$i++)
                                    {
                                        echo "<tr>
                                               <td>".$i."</td>
                                                <td></td>
                                                <td></td>
                                               </tr>";
                                    }?>

                                </tbody>
                            </table>
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
                                    <p><b>Kindly accomplish the "Ten Leading Causes of Mortality/Deaths Disaggregated as to Age and Sex" in the table below.</b></p>
                                    <div class="body table-responsive">
                                        <table id="return-table" class="table table-bordered table-striped table-hover" >
                                            <thead style="font-size:12px;">
                                                <tr style="vertical-align : middle;text-align:center;">
                                                    <th rowspan="2" style="vertical-align : middle;text-align:center;">Cause of Death (Underlying)</th>
                                                    <th colspan="34" style="vertical-align : middle;text-align:center;">Age Distribution of Patients</th>
                                                    <th rowspan="3" style="vertical-align : middle;text-align:center;">Total</th>
                                                    <th rowspan="3" style="vertical-align : middle;text-align:center;">ICD-10 CODE/TABULAR LIST</th>
                                                </tr>
                                                <tr>
                                                    <th colspan="2">Under 1</th>
                                                    <th colspan="2">1-4</th>
                                                    <th colspan="2">5-9</th>
                                                    <th colspan="2">10-14</th>
                                                    <th colspan="2">15-19</th>
                                                    <th colspan="2">20-24</th>
                                                    <th colspan="2">25-29</th>
                                                    <th colspan="2">30-34</th>
                                                    <th colspan="2">35-39</th>
                                                    <th colspan="2">40-44</th>
                                                    <th colspan="2">45-49</th>
                                                    <th colspan="2">50-54</th>
                                                    <th colspan="2">55-59</th>
                                                    <th colspan="2">60-64</th>
                                                    <th colspan="2">65-69</th>
                                                    <th colspan="2">70 & over</th>
                                                    <th colspan="2">Subtotal</th>
                                                </tr>
                                                <tr >
                                                    <th>Spell out. Do not abbreviate.</th>
                                                    <?php for($i=0;$i<=16;$i++)
                                                    {
                                                       echo "<th>M</th>"; 
                                                       echo "<th>F</th>"; 
                                                    }?>
                                                    
                                                </tr>
                                            </thead>
                                            <tbody style="font-size: 12px">
                                                <?php for($i=1;$i<=10;$i++)
                                                {
                                                    echo "<tr>";
                                                        echo "<td>".$i."</td>";
                                                        for($z=0;$z<36;$z++)
                                                        {
                                                            echo "<td></td>";
                                                        }
                                                    echo "</tr>";
                                                }?>

                                            </tbody>
                                        </table>
                                    </div>
                                    <hr>
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
   var sidemenu = $('#DOH-3-3');
    sidemenu.removeClass().addClass('active');
    sidemenu.parents("li").removeClass().addClass('active');
//     $('#type-service-table').dataTable({
//            dom: 'frtip',
//            processing:true, 
//            scrollX: true
//        });
$('#type-service-table').DataTable({
      'paging'      : true,
      'lengthChange': true,
      'searching'   : true,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : true,
      'scrollX'     : true,
    })
});
</script>