<!-- Large Size -->
    <div class="modal fade" id="deferticket" tabindex="-1" role="dialog" data-backdrop="static">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header bg-orange">
                    <h4 class="modal-title" id="ss">Note of Deferral</h4>
                </div>
                <div class="modal-body">
                    <form id="defer-ticket-form"><br>
                        <input type="hidden" name="control" value="">
                        <div class="col-sm-12">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" class="form-control hidden" name="disticketref" placeholder="col-sm-3" readonly="readonly"/>
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
                <div class="modal-footer bg-orange">
                    <!--<button type="button" class="btn btn-link waves-effect">SAVE CHANGES</button>-->
                    <div class="col-md-12">
                            <button type="button" class="btn btn-link waves-effect" onclick="voucher.dismissdef()" >CLOSE</button>
                            <button type="button" onclick="voucher.deferticket_t()" class="btn btn-link waves-effect">SAVE</button>
                        
                    </div>
                    
                    
                </div>
            </div>
        </div>
    </div>