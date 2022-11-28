<body class="theme-cyan">
     <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2 style="text-transform: uppercase;">
                    Cheque Approval
                </h2>
            </div>
            
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header bg-cyan" style="text-transform:uppercase;">
                            <h2>
                                Cheque Approval&nbsp;&nbsp;<span id="chequeAmt"></span>
                                <!--<small>You can use different animation class. We used Animation.css which link is <a href="https://daneden.github.io/animate.css/" target="_blank">https://daneden.github.io/animate.css/</a></small>-->
                            </h2>
                        </div>
                        <div class="body table-responsive">
<?php if($this->session->userdata('approver')=== '1')
{ ?>
                            <button type="button" onclick="voucher.get_selected_app('approve')" class="btn bg-green waves-effect">Approve</button>
                           <button type="button" onclick="voucher.get_selected_app('disapprove')" class="btn bg-red waves-effect">Disapprove</button>
                            <button type="button" onclick="voucher.get_selected_app('deferred')" class="btn bg-orange waves-effect">Defer</button>
<?php }
else {
    
}?>
                            <table id="cheque-approval-table" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr >
                                        <th><input type="checkbox" id="check-all" class="filled-in chk-col-blue" /><label style="margin-right: -100px; margin-bottom: -10px" for="check-all"></label></th>
                                        <th>Payee</th>
                                        <th>Amount</th>
                                        <th>Check Date</th>
                                        <th>Explanation</th>
                                        <th>Date</th>
                                        <th>TICKETREF</th>
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
                                Disapproved Ticket
                                <!--<small>You can use different animation class. We used Animation.css which link is <a href="https://daneden.github.io/animate.css/" target="_blank">https://daneden.github.io/animate.css/</a></small>-->
                            </h2>
                        </div>
                        <div class="body table-responsive">
                            <form id="disapproved-ticket-form" action="<?= base_url("user/generate_disapprovedticket_report") ?>" method="POST" target="_blank">
                                <a class="reports-btn" href="javascript:void(0)" target="_blank">
                                    <button onclick="user.get_disapprovedticket_report()" style="height: 25px" type="button" class="btn bg-pink waves-effect">
                                        <i style="margin-top: -25px;" class="material-icons">picture_as_pdf</i>
                                    </button>
                                </a>   
                            </form>
                             <form id="csv_disapproved-ticket-form" action="<?= base_url("user/generate_csv_disapprovedticket_report") ?>" method="POST" target="_blank">
                                <a class="reports-btn" href="javascript:void(0)" target="_blank">
                                    <button onclick="user.get_csv_disapprovedticket_report()" style="margin-top:-45px;margin-left:50px;height: 25px" type="button" class="btn bg-pink waves-effect">
                                        <i style="margin-top: -25px;" class="material-icons">library_books</i>
                                    </button>
                                </a>   
                            </form>
                            <table id="disapproved-ticket-table" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr style="font-size: 12px">
                                        
                                        <th>Disapproval Date</th>
                                        <th>Payee</th>
                                        <th>Amount</th>
                                        <th>Explanation</th>
                                        <th>Date</th>
                                        <th>Note</th>
                                       
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
                                <!--<small>You can use different animation class. We used Animation.css which link is <a href="https://daneden.github.io/animate.css/" target="_blank">https://daneden.github.io/animate.css/</a></small>-->
                            </h2>
                        </div>
                        <div class="body table-responsive">
                            <form id="deferred-ticket-form" action="<?= base_url("user/generate_deferredticket_report") ?>" method="POST" target="_blank">
                                <a class="reports-btn" href="javascript:void(0)" target="_blank">
                                    <button onclick="user.get_deferredticket_report()" style="height: 25px" type="button" class="btn bg-pink waves-effect">
                                        <i style="margin-top: -25px;" class="material-icons">picture_as_pdf</i>
                                    </button>
                                </a>   
                            </form>
                            <form id="csv_deferred-ticket-form" action="<?= base_url("user/generate_csv_deferredticket_report") ?>" method="POST" target="_blank">
                                <a class="reports-btn" href="javascript:void(0)" target="_blank">
                                    <button onclick="user.get_csv_deferredticket_report()" style="margin-top:-45px;margin-left:50px;height: 25px" type="button" class="btn bg-pink waves-effect">
                                        <i style="margin-top: -25px;" class="material-icons">library_books</i>
                                    </button>
                                </a>   
                            </form>
                            <table id="deferred-ticket-table" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr style="font-size: 12px">
                                        <th>Deferral Date</th>
                                        <th>Payee</th>
                                        <th>Amount</th>
                                        <th>Explanation</th>
                                        <th>Date</th>
                                        <th>Note</th>
                                        
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
                                <!--<small>You can use different animation class. We used Animation.css which link is <a href="https://daneden.github.io/animate.css/" target="_blank">https://daneden.github.io/animate.css/</a></small>-->
                            </h2>
                        </div>
                        <div class="body container-fluid">
                            <div class="col-sm-6 ">
                                <form id="pdf_approved-ticket-form" action="<?= base_url("user/generate_approvedticket_report") ?>" method="POST" target="_blank">       
                                <input type="hidden" name="pdf_date" value=""/>
                                    <a class="reports-btn" href="javascript:void(0)" target="_blank">
                                <button onclick="user.get_pdf_approvedticket_report()" style="height: 25px" type="button" class="btn bg-pink waves-effect">
                                    <i style="margin-top: -25px;" class="material-icons">picture_as_pdf</i>
                                </button>
                               </a> 
                                </form>
                                <form id="cs_approved-ticket-form" action="<?= base_url("user/generate_csv_approvedticket_report") ?>" method="POST" target="_blank">       
                               <input type="hidden" name="csv_date" value=""/>
                                    <a class="reports-btn" href="javascript:void(0)" target="_blank">
                                <button onclick="user.get_csv_approvedticket_report()" style="margin-top:-45px;margin-left:50px;height: 25px" type="button" class="btn bg-pink waves-effect">
                                    <i style="margin-top: -25px;" class="material-icons">library_books</i>
                                </button>
                               </a> 
                                </form>
                            </div>
                           
                     <form id="approved-ticket-form"  method="POST" target="_blank">       
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
                                <button onclick="user.search_approved_ticket()" type="button" class="btn bg-purple waves-effect">
                                    <span>Search <i class="material-icons">search</i></span>
                                </button>
                            </div>
                     </form>
                        </div>
                        <div class="body table-responsive" >
                            <table id="approved-ticket-table" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr style="font-size: 12px">
                                       
                                        <th>Date</th>
                                        <th>Payee</th>
                                        <th>Amount</th>
                                        <th>Explanation</th>
                                        <th>Note</th>
                                        <th>Prepared</th>
                                        <th>Checked</th>
                                        <th>Approved</th>
                                        
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
<?php $this->load->view('pages/modals/ticketdetails'); ?>
<?php $this->load->view('pages/modals/disapproveticket'); ?>
<?php $this->load->view('pages/modals/deferticket'); ?>
<?php $this->load->view('pages/modals/disticket'); ?>
<?php $this->load->view('pages/modals/defticket'); ?>

<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function () {
//        purchase.load_s("http://192.168.2.111:3777/drainwizv2/assets/vendors/js/responsive.js");
        voucher.get_chequeapproval();
        voucher.get_disapproved_ticket();
        voucher.get_deferred_ticket();
        voucher.get_approved_ticket();
        var sidemenu = $('#voucher-1');
        sidemenu.removeClass().addClass('active');
        sidemenu.parents("li").removeClass().addClass('active');

    
   
});
</script>
