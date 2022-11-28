<body class="theme-cyan">
     <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <ol class="breadcrumb breadcrumb-col-cyan">
                    <li>Reports</li>
                    <li>DOH Annual Hospital Statistical Report</li>
                    <li>II. Hospital Operations</li>
                    <li>B. Discharges</li>
                    <li class="active">Edit Final Diagnosis</li>
                </ol>
            </div>
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="body">
                            <div class="row clearfix">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <p style="text-transform:uppercase;"><b>&#9724; <?= $diagnosis ?></b></p>
                                    <form id="ten-causes-morbidity-form">
                                        <input type="text" id="txtyear" value="<?= $datexx ?>" hidden/>
                                        <input type="text" id="txtdiag" value="<?= $diagnosis ?>" hidden/>
                                    </form>
                                    <hr>
                                    <button  type="button" class="btn bg-purple waves-effect " onclick="doh_discharges.preview_table_ten_morbidity()"  >
                                        <span><i class="material-icons">remove_red_eye</i> Preview </span>
                                    </button>
                                    <div class="body table-responsive">
                                        <table id="inpatient-finaldiag-table" class="table table-bordered table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>Edit</th>
                                                <th>FINAL DIAGNOSIS &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                                <th>ICD10 </th>
                                                <th>ACCOUNT NUMBER </th>
                                                <th>PATIENT NAME</th>
                                                <th>GENDER</th>
                                                <th>AGE</th>
                                                <th>ADMISSION DATE</th>
                                                <th>DISCHARGE DATE</th>
                                                <th>MEMBERSHIP</th>
                                                <th>NURSE IN CHARGE</th>
                                                <th>DATE</th>
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
        </div>
    </section>
</body>

<?php $this->load->view('pages/modals/fetchLoader'); ?>
<?php $this->load->view('pages/DOH/modal/change_finaldiag'); ?>

<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function () {
   var sidemenu = $('#DOH-3-2');
    sidemenu.removeClass().addClass('active');
    sidemenu.parents("li").removeClass().addClass('active');
//     $('#type-service-table').dataTable({
//            dom: 'frtip',
//            processing:true, 
//            scrollX: true
//        });

doh_discharges.show_inpatients_finaldiagnosis();
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