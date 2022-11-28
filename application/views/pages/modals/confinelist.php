<!-- Large Size -->
<div class="modal fade" id="confinelist" tabindex="-1" role="dialog" data-backdrop="static">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-cyan">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title"> LGNOSIS</h4>
                    &#9656;<small id="diag"></small>
                </div>
                <div class="modal-body">
                    <div class="row clearfix" id="admission">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="card">
                                <div class="body table-responsive">
                                    <table id="px-diagnosis-table" class="table table-bordered table-striped table-hover">
                                        <thead>
                                            <tr style="font-size: 12px">
                                                <th>*</th>
                                                <th>ID</th>
                                                <th>Refno</th>
                                                <th>Cause of Confinement</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-cyan">
                    <div class="col-md-12">
                           <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function () {

        confine.get_diag_list();
});
</script>
