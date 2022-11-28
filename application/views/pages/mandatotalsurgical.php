<body class="theme-cyan">
     <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2 style="text-transform: uppercase;">
                    Total Surgical Sterilization
                </h2>
            </div>
            
           <div class="row clearfix">
                 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header bg-cyan" style="text-transform:uppercase;">
                            <h2>
                                Covered Month
                            </h2>
                        </div>
                        <div class="body container-fluid">
                            <form id="search-total-surgical-form"  method="POST" >
                                <input type="hidden" name="s_date" value=""/>
                               
                                <div class="col-sm-4">
                                    <div class='input-group datex'>
                                        <span class="input-group-addon">
                                            <i class="material-icons date-icon" >date_range</i>
                                        </span>
                                        <div class="form-line">
                                            <input type='text' name="start_date" class="form-control" value="<?= $monthx ?>">
                                        </div>
                                        <small style="color: red"></small>
                                        
                                    </div>
                                </div>

                            </form>
                            
                            <div class="col-sm-4">
                                <button onclick="totalsurg.search_total_surgical()" type="button" class="btn bg-purple waves-effect">
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
                        <div class="header bg-cyan" style="text-transform:uppercase;">
                            <h2>
                                <span style="color:red;"> E.1.  </span> Total Surgical Sterilization
                            </h2>
                        </div>                             
                        <div class="body table-responsive">
                            <button  type="button" class="btn bg-purple waves-effect " onclick="totalsurg.edit_total_surgical()"  >
                                <span>Edit <i class="material-icons">mode_edit</i></span>
                            </button>
                           
                          <hr style="clear: both;border-style: none;" >
                            <table id="total-surgical-table" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th rowspan="2"><center>SURGICAL STERILIZATION PROCEDURE</center></th>
                                        <th colspan="2"><center>NO. OF PATIENTS</center></th>
                                    </tr>
                                    <tr>
                                        <th class="align-middle"><center>NHIP</center></th>
                                        <th ><center>NON-NHIP</center></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>BILATERAL TUBAL LIGATION</td>
                                        <td><?php if($bilateral["nhip"] > 0){ echo $bilateral["nhip"];} else { echo "0";} ?></td>
                                        <td><?php if($bilateral["non"] > 0){ echo $bilateral["non"];} else { echo "0";} ?></td>
                                    </tr>
                                    <tr>
                                        <td>VASECTOMY</td>
                                        <td><?php if($vasectomy["nhip"] > 0){ echo $vasectomy["nhip"];} else { echo "0";} ?></td>
                                        <td><?php if($vasectomy["non"] > 0){ echo $vasectomy["non"];} else { echo "0";} ?></td>
                                    </tr>
                                    <tr>
                                        <td>ALL</td>
                                        <td><?php if($allnhip > 0){ echo $allnhip;} else { echo "0";} ?></td>
                                        <td><?php if($allnon > 0){ echo $allnon;} else { echo "0";} ?></td>
                                    </tr>
                                </tbody>
                                
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
<?php $this->load->view('pages/modals/transmitinfo'); ?>

<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function () {
   
   var sidemenu = $('#mandatory-7');
    sidemenu.removeClass().addClass('active');
    sidemenu.parents("li").removeClass().addClass('active');
   
//      totalsurg.get_total_surgical();
  
});
</script>











