<body class="theme-cyan">
     <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2 style="text-transform: uppercase;">
                    Expenses
                </h2>
            </div>
            <?php if(doubleval($totaldebit) <= 0.0){ ?>
            <div class="alert" style="background-color: #FFEBEE">
                <strong style="color: red">Total Balance : <?= '&#8369;'.number_format($totaldebit,2); ?></strong>
            </div>
            <?php }else{?>
            <div class="alert" style="background-color: #C8E6C9">
                <strong style="color: green">Total Balance : <?= '&#8369;'.number_format($totaldebit,2); ?></strong>
            </div>
            <?php }?>
            
            <!--doctors table-->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header bg-cyan" style="text-transform:uppercase;">
                            <h2>
                                Expenses 
                            </h2>
                        </div>
                        <div class="body table-responsive">
                            <form id="expenses-form" action="<?= base_url("user/generate_exp_report") ?>" method="POST" target="_blank">
                                <input type="hidden" name="search" value=""/>
                            </form>
                            <a class="report-btn" href="javascript:void(0)" target="_blank">
                                <button onclick="user.get_expenses_report()" style="height: 25px" type="button" class="btn bg-pink waves-effect">
                                    <i style="margin-top: -25px;" class="material-icons">picture_as_pdf</i>
                                </button>
                            </a>
                            <!--<a class="report-btn" href="javascript:void(0)" target="_blank"><button onclick="user.get_doc_report()">Preview Pdf</button></a>-->
                            <table id="expenses-table" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr style="font-size: 12px">
                                        <th>Date/Time &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                        <th>Expense Group</th>
                                        <th>Amount</th>
                                        <th>Debit</th>
                                        <th>Credit</th>
                                        <th>Balance</th>
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
    $('#menu-expenses').removeClass().addClass('active');
    
    load_script("http://192.168.2.111:3777/drainwizv2/assets/vendors/js/responsive.js",0,3);
    
    
    
    $('[data-toggle="popover"]').popover();
});
</script>
