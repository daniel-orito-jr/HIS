<body class="theme-cyan">
     <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <ol class="breadcrumb breadcrumb-col-cyan">
                    <li>Reports</li>
                    <li>DOH Annual Hospital Statistical Report</li>
                    <li>III. Hospital Operations</li>
                    <li class="active">Staffing Pattern</li>
                </ol>
            </div>
            <div class="row clearfix">
                 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                D. STAFFING PATTERN(Total Staff Complement)
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
                                                    <th rowspan="2" style="vertical-align : middle;text-align:center;">Profession/Position/Designation</th>
                                                    <th rowspan="2" style="vertical-align : middle;text-align:center;">Specialty Board Certified</th>
                                                    <th colspan="2" style="vertical-align : middle;text-align:center;">Total staff working full-time (at least 40 hours/week)</th>
                                                    <th colspan="2" style="vertical-align : middle;text-align:center;">Total staff working part-time (at least 20 hours/week)</th>
                                                    <th rowspan="2" style="vertical-align : middle;text-align:center;">Active Rotating or Visiting/ Affiliate (For Private Facilities)</th>
                                                    <th rowspan="2" style="vertical-align : middle;text-align:center;">Outsourced</th>
                                                    <th rowspan="2" style="vertical-align : middle;text-align:center;">Total</th>
                                                </tr>
                                                <tr>
                                                    <th style="vertical-align : middle;text-align:center;">Number of permanent full time staff</th>
                                                    <th style="vertical-align : middle;text-align:center;">Number of contractual full time staff</th>
                                                    <th style="vertical-align : middle;text-align:center;">Number of permanent part time staff</th>
                                                    <th style="vertical-align : middle;text-align:center;">Number of contractual part time staff</th>
                                                </tr>
                                            </thead>
                                            <tbody style="font-size: 12px">
                                                <tr>
                                                    <td colspan="9"><b>A. Medical</b></td>
                                                </tr>
                                                <tr>
                                                    <td>&nbsp;&nbsp;1. Consultants</td>
                                                    <?php for($i=0;$i<8;$i++)
                                                    {
                                                       echo "<td></td>"; 
                                                    }?>
                                                </tr>
                                                <tr>
                                                    <td>&nbsp;&nbsp;&nbsp;&nbsp;1.1 Internal Medicine</td>
                                                    <?php for($i=0;$i<8;$i++)
                                                    {
                                                       echo "<td></td>"; 
                                                    }?>
                                                </tr>
                                                <tr>
                                                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;a. Generalist</td>
                                                    <?php for($i=0;$i<8;$i++)
                                                    {
                                                       echo "<td></td>"; 
                                                    }?>
                                                </tr>
                                                <tr>
                                                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;b. Cardiologist</td>
                                                    <?php for($i=0;$i<8;$i++)
                                                    {
                                                       echo "<td></td>"; 
                                                    }?>
                                                </tr>
                                                <tr>
                                                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;c. Endocrinologist</td>
                                                    <?php for($i=0;$i<8;$i++)
                                                    {
                                                       echo "<td></td>"; 
                                                    }?>
                                                </tr>
                                                <tr>
                                                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;d. Gastro-Enterologist</td>
                                                    <?php for($i=0;$i<8;$i++)
                                                    {
                                                       echo "<td></td>"; 
                                                    }?>
                                                </tr>
                                                <tr>
                                                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;e. Pulmonologist</td>
                                                    <?php for($i=0;$i<8;$i++)
                                                    {
                                                       echo "<td></td>"; 
                                                    }?>
                                                </tr>
                                                <tr>
                                                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;f. Nephrologist</td>
                                                    <?php for($i=0;$i<8;$i++)
                                                    {
                                                       echo "<td></td>"; 
                                                    }?>
                                                </tr>
                                                <tr>
                                                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;g. Neurologist</td>
                                                    <?php for($i=0;$i<8;$i++)
                                                    {
                                                       echo "<td></td>"; 
                                                    }?>
                                                </tr>
                                                <tr>
                                                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1.2. Obstetrics/ Gynecology (and sub-specialty)</td>
                                                    <?php for($i=0;$i<8;$i++)
                                                    {
                                                       echo "<td></td>"; 
                                                    }?>
                                                </tr>
                                                <tr>
                                                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1.3. Pediatrics (and sub-specialty)</td>
                                                    <?php for($i=0;$i<8;$i++)
                                                    {
                                                       echo "<td></td>"; 
                                                    }?>
                                                </tr>
                                                <tr>
                                                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1.4. Surgery (and sub-specialty)</td>
                                                    <?php for($i=0;$i<8;$i++)
                                                    {
                                                       echo "<td></td>"; 
                                                    }?>
                                                </tr>
                                                <tr>
                                                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1.5. Anesthesiologist</td>
                                                    <?php for($i=0;$i<8;$i++)
                                                    {
                                                       echo "<td></td>"; 
                                                    }?>
                                                </tr>
                                                <tr>
                                                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1.6. Radiologist</td>
                                                    <?php for($i=0;$i<8;$i++)
                                                    {
                                                       echo "<td></td>"; 
                                                    }?>
                                                </tr>
                                                <tr>
                                                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1.7. Pathologist</td>
                                                    <?php for($i=0;$i<8;$i++)
                                                    {
                                                       echo "<td></td>"; 
                                                    }?>
                                                </tr>
                                                <tr>
                                                    <td>&nbsp;&nbsp;2. Post-Graduate Fellows (Indicate specialty/ subspecialty</td>
                                                    <?php for($i=0;$i<8;$i++)
                                                    {
                                                       echo "<td></td>"; 
                                                    }?>
                                                </tr>
                                                <tr>
                                                    <td>&nbsp;&nbsp;3. Residents</td>
                                                    <?php for($i=0;$i<8;$i++)
                                                    {
                                                       echo "<td></td>"; 
                                                    }?>
                                                </tr>
                                                <tr>
                                                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;3.1. Internal Medicine</td>
                                                    <?php for($i=0;$i<8;$i++)
                                                    {
                                                       echo "<td></td>"; 
                                                    }?>
                                                </tr>
                                                <tr>
                                                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;3.2. Obstetrics-Gynecology</td>
                                                    <?php for($i=0;$i<8;$i++)
                                                    {
                                                       echo "<td></td>"; 
                                                    }?>
                                                </tr>
                                                <tr>
                                                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;3.3. Pediatrics</td>
                                                    <?php for($i=0;$i<8;$i++)
                                                    {
                                                       echo "<td></td>"; 
                                                    }?>
                                                </tr>
                                                <tr>
                                                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;3.4. Surgery</td>
                                                    <?php for($i=0;$i<8;$i++)
                                                    {
                                                       echo "<td></td>"; 
                                                    }?>
                                                </tr>
                                                <tr style="font-weight: bold;">
                                                    <td>SUB-TOTAL</td>
                                                    <?php for($i=0;$i<8;$i++)
                                                    {
                                                       echo "<td></td>"; 
                                                    }?>
                                                </tr>
                                                <!------->
                                                <tr>
                                                    <td colspan="9"><b>B. Allied Medical</b></td>
                                                </tr>
                                                <tr>
                                                    <td>&nbsp;&nbsp;1. Nurses</td>
                                                    <?php for($i=0;$i<8;$i++)
                                                    {
                                                       echo "<td></td>"; 
                                                    }?>
                                                </tr>
                                                <tr>
                                                    <td>&nbsp;&nbsp;2. Midwives</td>
                                                    <?php for($i=0;$i<8;$i++)
                                                    {
                                                       echo "<td></td>"; 
                                                    }?>
                                                </tr>
                                                <tr>
                                                    <td>&nbsp;&nbsp;3. Nursing Aides</td>
                                                    <?php for($i=0;$i<8;$i++)
                                                    {
                                                       echo "<td></td>"; 
                                                    }?>
                                                </tr>
                                                <tr>
                                                    <td>&nbsp;&nbsp;4. Nutritionist</td>
                                                    <?php for($i=0;$i<8;$i++)
                                                    {
                                                       echo "<td></td>"; 
                                                    }?>
                                                </tr>
                                                <tr>
                                                    <td>&nbsp;&nbsp;5. Physical Therapist</td>
                                                    <?php for($i=0;$i<8;$i++)
                                                    {
                                                       echo "<td></td>"; 
                                                    }?>
                                                </tr>
                                                <tr>
                                                    <td>&nbsp;&nbsp;6. Pharmacists</td>
                                                    <?php for($i=0;$i<8;$i++)
                                                    {
                                                       echo "<td></td>"; 
                                                    }?>
                                                </tr>
                                                <tr>
                                                    <td>&nbsp;&nbsp;7. Medical Technologist</td>
                                                    <?php for($i=0;$i<8;$i++)
                                                    {
                                                       echo "<td></td>"; 
                                                    }?>
                                                </tr>
                                                <tr>
                                                    <td>&nbsp;&nbsp;8. Laboratory Technician</td>
                                                    <?php for($i=0;$i<8;$i++)
                                                    {
                                                       echo "<td></td>"; 
                                                    }?>
                                                </tr>
                                                <tr>
                                                    <td>&nbsp;&nbsp;9. X-Ray Technologist/ X-Ray Technician</td>
                                                    <?php for($i=0;$i<8;$i++)
                                                    {
                                                       echo "<td></td>"; 
                                                    }?>
                                                </tr>
                                                <tr>
                                                    <td>&nbsp;&nbsp;10. Medical Equipment Technician</td>
                                                    <?php for($i=0;$i<8;$i++)
                                                    {
                                                       echo "<td></td>"; 
                                                    }?>
                                                </tr>
                                                <tr>
                                                    <td>&nbsp;&nbsp;11. Social Worker</td>
                                                    <?php for($i=0;$i<8;$i++)
                                                    {
                                                       echo "<td></td>"; 
                                                    }?>
                                                </tr>
                                                <tr>
                                                    <td>&nbsp;&nbsp;12. Medical Records Officer/ Hospital Health Information Officer</td>
                                                    <?php for($i=0;$i<8;$i++)
                                                    {
                                                       echo "<td></td>"; 
                                                    }?>
                                                </tr>
                                                <tr style="font-weight: bold;">
                                                    <td>SUB-TOTAL</td>
                                                    <?php for($i=0;$i<8;$i++)
                                                    {
                                                       echo "<td></td>"; 
                                                    }?>
                                                </tr>
                                                <!------>
                                                <tr>
                                                    <td colspan="9"><b>C. Non-Medical</b></td>
                                                </tr>
                                                <tr>
                                                    <td>&nbsp;&nbsp;1. Chief Administrative Officer</td>
                                                    <?php for($i=0;$i<8;$i++)
                                                    {
                                                       echo "<td></td>"; 
                                                    }?>
                                                </tr>
                                                <tr>
                                                    <td>&nbsp;&nbsp;2. Accountant</td>
                                                    <?php for($i=0;$i<8;$i++)
                                                    {
                                                       echo "<td></td>"; 
                                                    }?>
                                                </tr>
                                                <tr>
                                                    <td>&nbsp;&nbsp;3. Budget Officer</td>
                                                    <?php for($i=0;$i<8;$i++)
                                                    {
                                                       echo "<td></td>"; 
                                                    }?>
                                                </tr>
                                                <tr>
                                                    <td>&nbsp;&nbsp;4. Cashier</td>
                                                    <?php for($i=0;$i<8;$i++)
                                                    {
                                                       echo "<td></td>"; 
                                                    }?>
                                                </tr>
                                                <tr>
                                                    <td>&nbsp;&nbsp;5. Clerk</td>
                                                    <?php for($i=0;$i<8;$i++)
                                                    {
                                                       echo "<td></td>"; 
                                                    }?>
                                                </tr>
                                                <tr>
                                                    <td>&nbsp;&nbsp;6. Engineer</td>
                                                    <?php for($i=0;$i<8;$i++)
                                                    {
                                                       echo "<td></td>"; 
                                                    }?>
                                                </tr>
                                                <tr>
                                                    <td>&nbsp;&nbsp;7. Driver</td>
                                                    <?php for($i=0;$i<8;$i++)
                                                    {
                                                       echo "<td></td>"; 
                                                    }?>
                                                </tr>
                                                <tr>
                                                    <td>&nbsp;&nbsp;8. General Support Staff</td>
                                                    <?php for($i=0;$i<8;$i++)
                                                    {
                                                       echo "<td></td>"; 
                                                    }?>
                                                </tr>
                                                <tr>
                                                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Janitorial</td>
                                                    <?php for($i=0;$i<8;$i++)
                                                    {
                                                       echo "<td></td>"; 
                                                    }?>
                                                </tr>
                                                <tr>
                                                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Maintenance</td>
                                                    <?php for($i=0;$i<8;$i++)
                                                    {
                                                       echo "<td></td>"; 
                                                    }?>
                                                </tr>
                                                <tr>
                                                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Security</td>
                                                    <?php for($i=0;$i<8;$i++)
                                                    {
                                                       echo "<td></td>"; 
                                                    }?>
                                                </tr>
                                                <tr style="font-weight: bold;">
                                                    <td>SUB-TOTAL</td>
                                                    <?php for($i=0;$i<8;$i++)
                                                    {
                                                       echo "<td></td>"; 
                                                    }?>
                                                </tr>
                                                <tr style="font-weight: bold;">
                                                    <td>GRAND TOTAL</td>
                                                    <?php for($i=0;$i<8;$i++)
                                                    {
                                                       echo "<td></td>"; 
                                                    }?>
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
   var sidemenu = $('#DOH-4');
    sidemenu.removeClass().addClass('active');
    sidemenu.parents("li").removeClass().addClass('active');

});
</script>