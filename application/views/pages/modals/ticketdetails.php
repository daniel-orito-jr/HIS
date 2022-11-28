<!-- Large Size -->
    <div class="modal fade" id="ticketdetails" tabindex="-1" role="dialog" data-backdrop="static">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-cyan">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                    <h4 class="modal-title" id="ss">Ticket Details</h4>
                </div>
                <div class="modal-body">
                    <form id="ticket-details-form"><br>
                        <input type="hidden" name="control" value="">
                        <div class="col-sm-12">
                            <div class="form-group form-float">
                                
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <input type="text" class="form-control hidden" name="ticketref"  readonly="readonly"/>
                                        <input type="text" class="form-control" name="ticketdate"  readonly="readonly"/>
                                        <input type="text" class="form-control" name="ticketcode"  readonly="readonly"/>
                                    </div>
                                    <div class="form-group">
                                        
                                            
                                        
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="form-line">
                                            Payee:
                                            <input type="text" class="form-control" name="payee"  readonly="readonly"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="form-line">
                                            Amount:
                                            
                                            <input type="text" class="form-control" name="checkamt"  readonly="readonly"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <div class="form-line">
                                            Cheque Details:
                                            <input type="text" class="form-control" name="checkname"  readonly="readonly"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="form-line">
                                            Explanation:
                                            <textarea rows="5" name="explanation" class="form-control no-resize" readonly="readonly"></textarea>
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="form-line">
                                            Prepared Date:
                                            <input type="text" class="form-control" name="prepdatetime"  readonly="readonly"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="form-line">
                                            Check Date:
                                            <input type="text" class="form-control" name="checkdatetime"  readonly="readonly"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <div class="form-line">
                                            Note:
                                            <input type="text" style="color:red;" class="form-control" name="checknote"  readonly="readonly"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                        <div class="row">
                            <div class="col-xs-9 p-t-5"></div>
                            <div class="col-md-6 pull-left">
                           <button type="button" data-toggle="modal" data-target="#crdbdetails"  onclick = "voucher.get_credit_debit_details()" class="btn bg-green waves-effect pull-left">Ticket Details</button>
<!--                            <button type="button" onclick="voucher.disapproveticket()" class="btn bg-red waves-effect">Disapprove</button>
                            <button type="button" onclick="voucher.deferred()" class="btn bg-blue waves-effect">Defer</button>-->
                    </div>
                        </div>
                    </form>
                    
                </div>
                
                <div class="modal-footer bg-cyan">
                    <?php if($this->session->userdata('approver')=== '1')
{ ?>
                    <!--<button type="button" class="btn btn-link waves-effect">SAVE CHANGES</button>-->
                    <div class="col-md-12">
                           <button type="button" onclick="voucher.approve_ticket()" class="btn bg-green waves-effect">Approve</button>
                            <button type="button" onclick="voucher.disapprove_ticket()" class="btn bg-red waves-effect">Disapprove</button>
                            <button type="button" onclick="voucher.defer_ticket()" class="btn bg-orange waves-effect">Defer</button>
                    </div>
             <?php }
else {
    
}?>       
                    
                </div>
            </div>
        </div>
    </div>

<?php $this->load->view('pages/modals/crdbdetails'); ?>