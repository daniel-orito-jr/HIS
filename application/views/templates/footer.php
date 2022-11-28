<!-- Page Loader -->
<footer>
    <div class="page-loader-wrapper">
        <div class="loader">
            <div class="preloader">
                <div class="spinner-layer pl-cyan">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>
            </div>
            <p>Please wait...</p>
        </div>
    </div>
</footer>

<?php $this->load->view('pages/modals/accntSetting'); ?>

<?php foreach ($js as $data){ ?>
    <script src="<?= base_url($data);?>"></script>
<?php  } ?>
        
<script src="<?= base_url('assets/vendors/js/jquery.idle.min.js');?>"></script>
<script src="<?= base_url('assets/js/idleko.min.js');?>"></script>
<script src="<?= base_url('assets/js/mandatorymonthlyreport.js');?>"></script>
