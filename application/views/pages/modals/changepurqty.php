<!-- Large Size -->
    <div class="modal fade" id="changepurqty" tabindex="-1" role="dialog" data-backdrop="static">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header bg-green">
                    <h4 class="modal-title" >Change Quantity</h4>
                </div>
                <div class="modal-body">
                    <form id="change-quantity-form"><br>
                        <input type="hidden" name="control" value="">
                        <div class="col-sm-12">
                            <h6 id="itemname"></h6>
                            <p>Actual: <span id="aqty"></span></p>
                            <br>
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="hidden" name="idx" class="form-control">
                                    <input type="text" name="newqty" class="form-control">
                                    <label class="form-label">New Quantity</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-9 p-t-5"></div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer bg-green">
                    <!--<button type="button" class="btn btn-link waves-effect">SAVE CHANGES</button>-->
                    <div class="col-md-12">
                            <button type="button" class="btn btn-link waves-effect" data-dismiss="modal" >CLOSE</button>
                            <button type="button" onclick="purchase.newquantity()" class="btn btn-link waves-effect">SAVE</button>
                        
                    </div>
                    
                    
                </div>
            </div>
        </div>
    </div>