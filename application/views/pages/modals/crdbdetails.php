<!-- Large Size -->
    <div class="modal fade" id="crdbdetails" tabindex="-1" role="dialog" data-backdrop="static">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-green">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                    <h4 class="modal-title" id="ss">Ticket Details</h4>
                </div>
                <div class="modal-body">
                    <form id="credit-debit-form"><br>
                        <input type="hidden" name="control" value="">
                        <div class="row clearfix">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="card">
                                    <div class="body table-responsive">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    Total Debit:
                                                    <input type="text" class="form-control" name="totaldebit"  readonly="readonly"/>
                                                </div>
                                            </div>
                                        </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <div class="form-line">
                                        Total Credit:
                                        <input type="text" class="form-control" name="totalcredit"  readonly="readonly"/>
                                    </div>
                                </div>
                            </div>
<!--                            <button type="button" onclick="purchase.get_selected_app()" class="btn bg-green waves-effect">Approve</button>
                            <button type="button" onclick="purchase.get_selected_dis()" class="btn bg-red waves-effect">Disapprove</button>
                            <button type="button" onclick="purchase.get_selected_def()" class="btn bg-blue waves-effect">Deffer</button>-->
                            <table id="credit-debit-table" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <input type="text" class="form-control hidden" name="ticketcode"  readonly="readonly"/>
                                    <tr style="font-size: 12px">
                                        
                                        <th>COA</th>
                                        <th>TITLE</th>
                                        <th>DEBIT</th>
                                        <th>CREDIT</th>
                                       
                                    </tr>
                                </thead>
                            </table>
                        </div>
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
                           <button type="button" class="btn btn-link waves-effect" onclick="voucher.dismisscr()" >CLOSE</button>
                    </div>
                    
                    
                </div>
            </div>
        </div>
    </div>

