<nav class="navbar">
    <div class="container-fluid">
        <div class="navbar-header">
            <a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false"></a>
            <a href="javascript:void(0);" class="bars"></a>
            <a class="navbar-brand " href="<?= base_url('user/dashboard') ?>" style="text-transform:uppercase;"><?= $hosp_name['compname'] ?></a>
            
        </div>
        <div class="collapse navbar-collapse" id="navbar-collapse">
            <ul class="nav navbar-nav navbar-right">
                <!-- Call Search -->
                <li><a  href="<?= base_url('user/sign_out'); ?>" class="js-search" data-close="true"><i class="material-icons">input</i> </a></li>
                <li><a  href="<?= base_url('user/sign_out'); ?>" class="js-search" data-close="true" >LOG OUT</a></li>
            </ul>
        </div>
    </div>
</nav>