<!-- Large Size -->
    <div class="modal fade" id="disPurchase" tabindex="-1" role="dialog" data-backdrop="static">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-red">
                    <h4 class="modal-title" id="ss">Note of Disapproval</h4>
                </div>
                <div class="modal-body">
                    <form id="dis-purchase-form"><br>
                        <input type="hidden" name="cc" id="cc">
                        <input type="hidden" name="pr" id="pr">
                        <div class="col-sm-12">
                            <div class="form-group form-float">
                                <div class="form-line">
                                     <textarea rows="3" name="note" class="form-control no-resize" id="note"></textarea>
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
                            <!--<button type="button" onclick="purchase1.disapprove_p()" class="btn btn-link waves-effect" id="purchase-supplier">SAVE</button>-->
                            <button type="button" onclick="purchase1.disapprovee()" class="btn btn-link waves-effect hidden" id="purchase-stock">SAVE</button>
                            <button type="button" onclick="purchase1.disapprove_p()" class="btn btn-link waves-effect hidden" id="disapprove_all">SAVE</button>
                    </div>
                    
                    
                </div>
            </div>
        </div>
    </div>