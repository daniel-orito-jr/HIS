<body class="theme-cyan">
     <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2 style="text-transform: uppercase;">
                   Obstetrical Procedures
                </h2>
            </div>
            
        
        <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header bg-cyan" style="text-transform:uppercase;">
                            <h2>
                                Obstetrical Procedures
                            </h2>
                        </div>

                               
                        <div class="body table-responsive">
                            <table id="Obstetrical-Procedures-table" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr >
                                        <th rowspan="2"><input type="checkbox" id="check-all" class="filled-in chk-col-blue" /><label style="margin-right: -100px; margin-bottom: -10px" for="check-all"></label></th>
                                        <th rowspan="2"><center>CATEGORY</center></th>
                                        <th rowspan="2"><center>DIAGNOSIS</center></th>
                                        <th colspan="2"><center>TOTAL</center></th>
                                    </tr>
                                    <tr>
                                        <th class="align-middle"><center>NHIP</center></th>
                                        <th ><center>NON-NHIP</center></th>
                                         <th></th>
                                     </tr>
                                 </thead>
                             </table>
                         </div>
                     </div>
                 </div>
             </div>
             <div class="row clearfix">
                 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                      
                        <div class="body container-fluid">
                            <form id="merge-obstetrics-form">
                                <input type="hidden" name="s_date" value=""/>
                                <input type="hidden" name="e_date" value=""/>
                                <div class="col-sm-4">
                                    <div class='input-group '>
                                        <span class="input-group-addon">
                                            <i class="material-icons"  >description</i>
                                        </span>
                                        <div class="form-line">
                                            <input type='text'   name="confinename" class="form-control" >
                                            <input type='hidden' name="confinenhip" class="form-control" id="nhip">
                                            <input type='hidden' name="confinenon" class="form-control" id="non">
                                            <input type='hidden' name="total" class="form-control" id="totalpat">

                                         
                                        </div>
                                        <small style="color: red"></small>
                                        
                                    </div>
                                </div>
                            </form>
                            
                            <div class="col-sm-2">
                                <button onclick="obstetric.mergeconfine()" type="button" class="btn bg-purple waves-effect btn-block "  id="merging">
                                    <span>Merge <i class="material-icons">merge_type</i></span>
                                </button>
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

<?php $this->load->view('pages/modals/fetchLoader'); ?>
<?php $this->load->view('pages/modals/expounddiag'); ?>

<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function () {
   
    var sidemenu = $('#mandatory-8');
    sidemenu.removeClass().addClass('active');
    sidemenu.parents("li").removeClass().addClass('active');
   
    obstetric.get_Obstetrical_Procedures();
  
});
</script>











