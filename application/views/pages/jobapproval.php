<body class="theme-cyan">
     <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2 style="text-transform: uppercase;">
                   Job Order Approval
                </h2>
            </div>
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header bg-cyan" style="text-transform:uppercase;">
                            <h2>
                                Job Order Approval&nbsp;&nbsp;<span id="jobAmt"></span>
                                <!--<small>You can use different animation class. We used Animation.css which link is <a href="https://daneden.github.io/animate.css/" target="_blank">https://daneden.github.io/animate.css/</a></small>-->
                            </h2>
                        </div>
                        <br>
 <div class="col-md-12">
                            <?php if($this->session->userdata('approver')=== '1')
                            { ?>
                            <button type="button" onclick="jobapproval.get_selected_app('approve')" class="btn bg-green waves-effect">Approve</button>
                           <button type="button" onclick="jobapproval.get_selected_app('disapprove')" class="btn bg-red waves-effect">Disapprove</button>
                            <button type="button" onclick="jobapproval.get_selected_app('deferred')" class="btn bg-orange waves-effect">Defer</button>
<?php }
else {
    
}?>
                            </div>
                        <div class="body table-responsive">
                           
                        <div class="col-md-4">
                                <select class="form-control show-tick" id="dept" onchange="job()">
                                    <option value="All">All</option>
                                    <?php
                                        for($i=0;$i<count($dept);$i++)
                                            {
                                                echo "<option value='".$dept[$i]["Department"]."'>".$dept[$i]["Department"]."</option>";
                                            }
                                    ?>
                                </select>
                            </div>
                            <table id="job-approval-table" class="table table-bordered table-striped table-hover">
                                
                                <thead>
                                    <tr >
                                        <th><input type="checkbox" id="check-all" class="filled-in chk-col-blue" /><label style="margin-right: -100px; margin-bottom: -10px" for="check-all"></label></th>
                                        <th>Control Number</th>
                                        <th>Request Date</th>
                                        <th>Type</th>
                                        <th>Department</th>
                                        <th>Complaint</th>
                                        <th>Details</th>
                                        <th>Request ID </th>
                                        <th></th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            
            <!------- Disapproved table ---->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header bg-cyan" style="text-transform:uppercase;">
                            <h2>
                                Disapproved Job Orders
                                
                            </h2>
                        </div>
                        <div class="body table-responsive">
                            <form id="disapproved-joborder-form" action="<?= base_url("user/generate_disapprovedjoborder_report") ?>" method="POST" target="_blank">
                                <a class="reports-btn" href="javascript:void(0)" target="_blank">
                                    <button onclick="jobapproval.get_disapprovedjoborder_report()" style="height: 25px" type="button" class="btn bg-pink waves-effect">
                                        <i style="margin-top: -25px;" class="material-icons">picture_as_pdf</i>
                                    </button>
                                </a>   
                            </form>
                             <form id="csv_disapproved-joborder-form" action="<?= base_url("user/generate_csv_disapprovedjoborder_report") ?>" method="POST" target="_blank">
                                <a class="reports-btn" href="javascript:void(0)" target="_blank">
                                    <button onclick="jobapproval.get_csv_disapprovedjoborder_report()" style="margin-top:-45px;margin-left:50px;height: 25px" type="button" class="btn bg-pink waves-effect">
                                        <i style="margin-top: -25px;" class="material-icons">library_books</i>
                                    </button>
                                </a>   
                            </form>
                            <table id="disapproved-joborder-table" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr style="font-size: 12px">
                                         <th>Control Number</th>
                                         <th>Disapproval Date </th>
                                        <th>Request Date</th>
                                        <th>Type</th>
                                        <th>Department</th>
                                        <th>Complaint</th>
                                        <th>Details</th>
                                        <th>Request ID </th>
                                   
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            
            <!------Deferred Ticket------>
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header bg-cyan" style="text-transform:uppercase;">
                            <h2>
                                Deferred Ticket
                                
                            </h2>
                        </div>
                        <div class="body table-responsive">
                            <form id="deferred-joborder-form" action="<?= base_url("user/generate_deferredjoborder_report") ?>" method="POST" target="_blank">
                                <a class="reports-btn" href="javascript:void(0)" target="_blank">
                                    <button onclick="jobapproval.get_deferredjoborder_report()" style="height: 25px" type="button" class="btn bg-pink waves-effect">
                                        <i style="margin-top: -25px;" class="material-icons">picture_as_pdf</i>
                                    </button>
                                </a>   
                            </form>
                            <form id="csv_deferred-joborder-form" action="<?= base_url("user/generate_csv_deferredjoborder_report") ?>" method="POST" target="_blank">
                                <a class="reports-btn" href="javascript:void(0)" target="_blank">
                                    <button onclick="jobapproval.get_csv_deferredjoborder_report()" style="margin-top:-45px;margin-left:50px;height: 25px" type="button" class="btn bg-pink waves-effect">
                                        <i style="margin-top: -25px;" class="material-icons">library_books</i>
                                    </button>
                                </a>   
                            </form>
                            <table id="deferred-joborder-table" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr style="font-size: 12px">
                                        <th>Control Number</th>
                                         <th>Deferral Date </th>
                                        <th>Request Date</th>
                                        <th>Type</th>
                                        <th>Department</th>
                                        <th>Complaint</th>
                                        <th>Details</th>
                                        <th>Request ID </th>
                                        
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            
            <!----- approved tickets---->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                 
                    <div class="card">
                        <div class="header bg-cyan" style="text-transform:uppercase;">
                            <h2>
                                Approved Ticket for the Day
                                
                            </h2>
                        </div>
                        <div class="body container-fluid">
                            <div class="col-sm-6 ">
                                <form id="pdf_approved-joborder-form" action="<?= base_url("user/generate_approvedjoborder_bydate_report") ?>" method="POST" target="_blank">       
                                <input type="hidden" name="pdf_date" value=""/>
                                    <a class="reports-btn" href="javascript:void(0)" target="_blank">
                                <button onclick="jobapproval.get_pdf_approvedjoborder_report()" style="height: 25px" type="button" class="btn bg-pink waves-effect">
                                    <i style="margin-top: -25px;" class="material-icons">picture_as_pdf</i>
                                </button>
                               </a> 
                                </form>
                                <form id="csv_approved-joborder-form" action="<?= base_url("user/generate_csv_approvedjoborder_bydate_report") ?>" method="POST" target="_blank">       
                               <input type="hidden" name="csv_date" value=""/>
                                    <a class="reports-btn" href="javascript:void(0)" target="_blank">
                                <button onclick="jobapproval.get_csv_approvedjoborder_report()" style="margin-top:-45px;margin-left:50px;height: 25px" type="button" class="btn bg-pink waves-effect">
                                    <i style="margin-top: -25px;" class="material-icons">library_books</i>
                                </button>
                               </a> 
                                </form>
                            </div>
                           
                     <form id="approved-joborder-form"  method="POST" target="_blank">       
                             <input type="hidden" name="s_date" value=""/>
                            <div class="col-sm-3 ">
                                <div class='input-group '>
                                    <span class="input-group-addon">
                                        <i class="material-icons date-icon" >date_range</i>
                                    </span>
                                    <div class="form-line">
                                        <input type='date' name="start_date" class="form-control" value="<?= $cur_date ?>" >
                                    </div>
                                    <small style="color: red"></small>
                                </div>
                            </div>
                             <div class="col-sm-3">
                                <button onclick="jobapproval.search_approved_joborder()" type="button" class="btn bg-purple waves-effect">
                                    <span>Search <i class="material-icons">search</i></span>
                                </button>
                            </div>
                     </form>
                        </div>
                        <div class="body table-responsive" >
                            <table id="approved-joborder-table" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr style="font-size: 12px">
                                       
                                       <th>Control Number</th>
                                         <th>Approved Date </th>
                                        <th>Request Date</th>
                                        <th>Type</th>
                                        <th>Department</th>
                                        <th>Complaint</th>
                                        <th>Details</th>
                                        <th>Request ID </th>
                                        
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
<?php $this->load->view('pages/modals/jobapprovalinfo'); ?>
<?php $this->load->view('pages/modals/jobdisticket'); ?>
<?php $this->load->view('pages/modals/jobdefticket'); ?>

<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function () {
//        purchase.load_s("http://192.168.2.111:3777/drainwizv2/assets/vendors/js/responsive.js");
        var dept = "All";
        jobapproval.get_jobapproval(dept);
        jobapproval.get_disapproved_ticket();
        jobapproval.get_deferred_ticket();
        jobapproval.get_approved_joborder_by_date();
        var sidemenu = $('#asset-jo-1');
        sidemenu.removeClass().addClass('active');
        sidemenu.parents("li").removeClass().addClass('active');

    
   
});
</script>
