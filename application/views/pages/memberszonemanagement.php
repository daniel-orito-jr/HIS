<body class="theme-cyan">
    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2 style="text-transform: uppercase;">
                   Zone Management
                </h2>
            </div>
            <div class="row clearfix">
                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                    <div class="card">
                        <div class="header bg-cyan">
                            <h2><strong>All Zones</strong></h2><br>
                            
                        </div>
                        <div class="body" >
                           <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" >
                            <div class="body table-responsive">
                                    <table id="zone-listing-table" class="table table-bordered table-striped table-hover" >
                                        <thead class="bg-cyan">
                                            <tr>
                                                <th>Action</th>
                                                <th>Zone</th>
                                                <th>Description</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                                
                                
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                    <div class="card">
                        <div class="header bg-cyan">
                            <h2><strong>Add Zone</strong></h2><br>
                            
                        </div>
                        <div class="body" >
                           <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" >
                            <div class="col-lg-4 col-md-6 col-sm-6 col-xs-6" >
                                <p><strong>Zone:</strong>   
                                        <input type="text" class="form-control" id="txtZone" name="txtZone"  />
                                        <small id="txtZoneError" style="color:red;"></small>
                                      
                                </div>
                            <div class="col-lg-8 col-md-6 col-sm-6 col-xs-6" >
                                <p><strong>Description:</strong>   
                                         <textarea rows="3" style="width:100%;" id="txtZoneDesc" name="txtZoneDesc"></textarea>
                                        <small id="txtZoneDescError" style="color:red;"></small>
                                      
                                </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" >
                                     <button id="btn_zone_save" type="button" class="btn bg-green waves-effect btn-block" onclick="saveZone()">
                                            <i class="material-icons">save</i>
                                            <span>SAVE</span>
                                        </button>
                                    <input type="hidden" class="form-control" id="txtid" name="txtid"  />
                                     <button id="btn_zone_update" type="button" class="btn bg-blue waves-effect btn-block hidden" onclick="saveZoneChanges()">
                                            <i class="material-icons">edit</i>
                                            <span>Update</span>
                                        </button>
                                </div>
                            </div>
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
<?php $this->load->view('pages/modals/membernoticeaddrecipient'); ?>
<?php $this->load->view('pages/modals/inputsupervisoraccount') ?>
<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function ()
    {
        var sidemenu = $('#membersmgmt-3');
        sidemenu.removeClass().addClass('active');
        sidemenu.parents("li").removeClass().addClass('active');
    });
</script>