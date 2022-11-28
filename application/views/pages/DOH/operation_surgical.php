<body class="theme-cyan">
     <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <ol class="breadcrumb breadcrumb-col-cyan">
                    <li>Reports</li>
                    <li>DOH Annual Hospital Statistical Report</li>
                    <li>II. Hospital Operations</li>
                    <li class="active">E. Surgical Operations</li>
                </ol>
            </div>
            <div class="row clearfix">
                 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                               E. SURGICAL OPERATIONS
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
                                    <small>1. Major Operation refers to surgical procedures requiring anesthesia/ spinal anesthesia to be performed in an operating theatre. (The definition of a major operation shall be based on the definitions of the different cutting specialties.)</small><br>
                                    <small>2. Minor Operation refers to surgical procedures requiring only local anesthesia/ no OR needed, example suturing.</small>
                                    <div class="body table-responsive">
                                        <div class="body table-responsive">
                                            <table id="return-table" class="table table-bordered table-striped table-hover">
                                                <thead>
                                                    <tr>
                                                        <th><center>10 Leading Major Operations (excluding Caesarian Sections)</center></th>
                                                        <th><center>Number</center></th>
                                                        <th><center>ICD-10 Code (Individual)</center></th>
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
                                            <hr>
                                            <table id="return-table" class="table table-bordered table-striped table-hover">
                                                <thead>
                                                    <tr>
                                                        <th><center>10 Leading Minor Operations</center></th>
                                                        <th><center>Number</center></th>
                                                        <th><center>ICD-10 Code (Individual)</center></th>
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
   var sidemenu = $('#DOH-3-5');
    sidemenu.removeClass().addClass('active');
    sidemenu.parents("li").removeClass().addClass('active');
});
</script>