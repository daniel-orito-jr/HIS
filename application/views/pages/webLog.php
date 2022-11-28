<body class="theme-cyan">
    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2 style="text-transform: uppercase;">
                    Web Activity Log
                </h2>
            </div>
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                Activity Log
                            </h2>
                        </div>
                        <div class="body table-responsive">
<!--                            <form id="px-disposition-form" action="<?= base_url("user/generate_dispo_report") ?>" method="POST" target="_blank">
                                <input type="hidden" name="s_date" value=""/>
                                <input type="hidden" name="e_date" value=""/>
                                <input type="hidden" name="search" value=""/>
                            </form>
                            <a class="report-btn" href="javascript:void(0)" target="_blank">
                                <button onclick="user.get_dispo_report()" style="height: 25px" type="button" class="btn bg-pink waves-effect">
                                    <i style="margin-top: -25px;" class="material-icons">picture_as_pdf</i>
                                </button>
                            </a>-->
                            <!--<a class="report-btn" href="javascript:void(0)" target="_blank"><button onclick="user.get_class_report()">Preview Pdf</button></a>-->
                            <table id="log-table" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr style="font-size: 12px">
                                        <th>Loger Name</th>
                                        <th>Activity</th>
                                        <th>Log Date</th>
                                        <th>Device Type</th>
                                        <th>Device Os</th>
                                        <th>Browser</th>
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

<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function () {
        var sidemenu = $('#menu-7-0');
        sidemenu.removeClass().addClass('active');
        sidemenu.parents("li").removeClass().addClass('active');

    });
</script>
