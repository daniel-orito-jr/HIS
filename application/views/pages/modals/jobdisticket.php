<!-- Large Size -->
    <div class="modal fade" id="jobdisticket" tabindex="-1" role="dialog" data-backdrop="static">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-red">
                    <h4 class="modal-title" id="ss">Note of Disapproval for all selected items</h4>
                </div>
                <div class="modal-body">
                    <form id="disapprove-joborder-form"><br>
                        <input type="hidden" name="control" value="">
                        <div class="col-sm-12">
                            <div class="form-group form-float">
                                <div class="form-line">
                                     <textarea rows="3" name="note" class="form-control no-resize"></textarea>
                                    <label class="form-label">Note</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-9 p-t-5"></div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer bg-red">
                    <!--<button type="button" class="btn btn-link waves-effect">SAVE CHANGES</button>-->
                    <div class="col-md-12">
                            <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                            <button type="button" onclick="jobapproval.disapprove_p()" class="btn btn-link waves-effect">SAVE</button>
                        
                    </div>
                    
                    
                </div>
            </div>
        </div>
    </div>