<body class="theme-cyan">
     <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <ol class="breadcrumb breadcrumb-col-cyan">
                    <li><a href="javascript:void(0);">User Management</a></li>
                </ol>
            </div>
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <!--<button type="button" class="btn btn-default waves-effect m-r-20" data-toggle="modal" data-target="#largeModal">MODAL - LARGE SIZE</button>-->
                    <button type="button" class="btn btn-primary waves-effect" data-toggle="modal" data-target="#addUser">
                        <i class="material-icons">playlist_add</i>
                        <span>Add User</span>
                    </button>
                </div>
            </div>
            <br>
            <!--doctors table-->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                All users 
                            </h2>
<!--                            <ul class="header-dropdown m-r--5">
                                <li class="dropdown">
                                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                        <i class="material-icons">more_vert</i>
                                    </a>
                                    <ul class="dropdown-menu pull-right">
                                        <li><a href="javascript:void(0);">Action</a></li>
                                        <li><a href="javascript:void(0);">Another action</a></li>
                                        <li><a href="javascript:void(0);">Something else here</a></li>
                                    </ul>
                                </li>
                            </ul>-->
                        </div>
                        <div class="body table-responsive">
                            <form id="doctor-form" action="<?= base_url("user/generate_doc_report") ?>" method="POST" target="_blank">
                                <input type="hidden" name="search" value=""/>
                            </form>
                            <a class="report-btn" href="javascript:void(0)" target="_blank">
                                <button onclick="user.get_doc_report()" style="height: 25px" type="button" class="btn bg-pink waves-effect">
                                    <i style="margin-top: -25px;" class="material-icons">picture_as_pdf</i>
                                </button>
                            </a>
                            <!--<a class="report-btn" href="javascript:void(0)" target="_blank"><button onclick="user.get_doc_report()">Preview Pdf</button></a>-->
                            <table id="users-table" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr style="font-size: 12px">
                                        <th>Name</th>
                                        <th>Username</th>
                                        <th>Type</th>
                                        <th>Actions</th>
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
<?php $this->load->view('pages/modals/addUser'); ?>

<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function () {
    var sidemenu = $('#menu-user-management');
    sidemenu.removeClass().addClass('active');
});
</script>
