<body class="theme-cyan">
     <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <ol class="breadcrumb breadcrumb-col-cyan">
                    <li><a href="javascript:void(0);">Purchases</a></li>
                    <li class="active">Disapproved</li>
                </ol>
            </div>
            
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                Purchase Records: Disapproved
                                <!--<small>You can use different animation class. We used Animation.css which link is <a href="https://daneden.github.io/animate.css/" target="_blank">https://daneden.github.io/animate.css/</a></small>-->
                            </h2>
                        </div>
                        <div class="body table-responsive">
                            <table id="disapproved-table" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr style="font-size: 12px">
                                         <th>Item Description</th>
                                        <th>Date</th>
                                        <th>Cost</th>
                                        <th>Quantity</th>
                                       
                                        <th>Total Cost</th>
                                        <th>Note</th>
                                    </tr>
                                </thead>
                            </table>
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
        disapprove.get_disapprove();
        var sidemenu = $('#purchase-req-5');
        sidemenu.removeClass().addClass('active');
        sidemenu.parents("li").removeClass().addClass('active');
});
</script>
