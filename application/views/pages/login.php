<body class="login-page" style="background-image:url('<?= base_url('assets/img/back.jpg'); ?>'); background-attachment: fixed;
 background-position: center;
 background-repeat: no-repeat;
 background-size: cover;">
    <div class="login-box">
        <div class="logo"  style="color: white;
             text-shadow: 1px 1px 2px black, 0 0 25px blue, 0 0 5px black;">
            <h1><center><b><?= $hosp_name['compname'] ?></b></center></h1>
            <center> HOSPITAL MANAGEMENT INFORMATION SYSTEM </center>
        </div>
         <div class="card" style="border: 1px solid #3d8dc1;
              padding: 10px;
              box-shadow: 5px 10px 8px #3d8dc1;">
             <div class="body">
                 <form id="sign-in-form">
                     <div class="input-group">
                         <span class="input-group-addon">
                             <i class="material-icons">person</i>
                         </span>
                         <div class="form-line">
                            <input type="text" class="form-control" name="username" placeholder="Username" required autofocus>
                        </div>
                        <label class="error"></label>
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">lock</i>
                        </span>
                        <div class="form-line">
                            <input type="password" class="form-control" name="password" placeholder="Password" required>
                        </div>
                        <label class="error"></label>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-xs-12">
                            <button class="btn btn-block bg-blue waves-effect btn-lg" type="button" onclick="user.validate_log_in()">SIGN IN</button>
                        </div>
                    </div>
                </form>
                <hr>
                <center>  
                    <a href="http://www.mydrainwiz.com" target="_blank" style="color: white" > <img src="<?= base_url("assets/img/logo.png") ?>" alt="logo"  width="40" height="40"> </a> 
                    <a href="https://www.facebook.com/drainwiz/" target="_blank" style="color: white" ><img src="<?= base_url("assets/img/likeus.png") ?>" alt="logo" width="40" height="40"></a>
                    <br> <small>Copyright © 2019 Drainwiz. Version 09.03.<br> All rights reserved.</small>
                </center>
            </div>
        </div>
    </div>
</body>
<?php $this->load->view('pages/modals/changepassword'); ?>
<?php $this->load->view('pages/modals/newpword'); ?>

<?php
    $sess = $this->session->flashdata('action');
    if ($sess === 'xp') {
        $this->session->sess_destroy();
    }
?>

<script type="text/javascript">
document.addEventListener('DOMContentLoaded', function () {
    var a = <?= json_encode($this->session->flashdata('action')) ?>;
    if (a == 'xp') {
        swal("Hello!","You have been idle for several minutes, the system logged you out automatically.","warning");
    }
});
</script>