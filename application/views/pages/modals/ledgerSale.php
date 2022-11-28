<!-- Large Size -->
    <div class="modal fade" id="ledgerSale" tabindex="-1" role="dialog" data-backdrop="static">
            <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                    <h4 class="modal-title" >Ledger Sale</h4>
                </div>
                <div class="modal-body">
                    <div class="row clearfix">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="card">
                                <div class="header">
                                    <h4>
                                        6 MONTHS SALES FREQUENCY
                                    </h4>
                                </div>
                        <div class="body container-fluid">
                           <form id="search-frequency-form">
                                        <input type="hidden" name="s_date" value=""/>
                                        <input type="hidden" name="barcode" value=""/>
                                        <input type="hidden" name="dept" value=""/>
                                        <input type="hidden" name="trans" value=""/>

                                <div class="col-sm-4">
                                    <div class='input-group date'>
                                        <span class="input-group-addon">
                                            <i class="material-icons date-icon" >date_range</i>
                                        </span>
                                        <div class="form-line">
                                            <input type="text" name="monthdate" class="form-control" value="<?= $lastmonth ?>">
                                        </div>
                                        <small style="color: red"></small>
                                        
                                    </div>
                                </div>
                            </form>
                            
                            <div class="col-sm-2">
                                <button onclick="purchase1.monthpick()" type="button" class="btn bg-purple waves-effect">
                                    <span>Search <i class="material-icons">search</i></span>
                                </button>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label>Transaction Type:</label>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <select class="form-control show-tick" name="cmbtranstype"  id="cmbtranstype" onchange="purchase1.transtype()">
                                        <option value="" > All Ledger</option>
                                        <option value="Delivery" selected="selected">Deliveries</option>
                                    </select>
                                </div>
                            </div>
                             <div class="col-md-12" >
                                <div class="info-box-3 bg-teal hover-expand-effect col-md-2">
                                    <div class="content">
                                        <div class="text" ><h6 id="month1"></h6></div>
                                        <div class="number" id="qty1"></div>
                                    </div>
                                </div>
                                <div class="info-box-3 bg-green hover-expand-effect col-md-2">
                                    <div class="content">
                                        <div class="text" ><h6 id="month2"></h6></div>
                                        <div class="number" id="qty2"></div>
                                    </div>
                                </div>
                                <div class="info-box-3 bg-light-green hover-expand-effect col-md-2">
                                    <div class="content">
                                        <div class="text" ><h6 id="month3"></h6></div>
                                        <div class="number" id="qty3"></div>
                                    </div>
                                </div>
                                <div class="info-box-3 bg-lime hover-expand-effect col-md-2">
                                    <div class="content">
                                        <div class="text" ><h6 id="month4"></h6></div>
                                        <div class="number" id="qty4"></div>
                                    </div>
                                </div>
                                <div class="info-box-3 bg-light-green hover-expand-effect col-md-2">
                                    <div class="content">
                                        <div class="text" ><h6 id="month5"></h6></div>
                                        <div class="number" id="qty5"></div>
                                    </div>
                                </div>
                                <div class="info-box-3 bg-green hover-expand-effect col-md-2">
                                    <div class="content">
                                        <div class="text" ><h6 id="month6"></h6></div>
                                        <div class="number" id="qty6"></div>
                                    </div>
                                </div>
                                </div>
                            </div>
                       
                        </div>
                    </div>
                </div>
                    
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="card">
                            <div class="header">
                                <h2>
                                    Details 
                                </h2>
                                
                            </div>
                             <div class="body table-responsive">
                            <table id="ledger-table" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr style="font-size: 12px">
                                       <th>Description</th>
                                            <th>Transaction Date</th>
                                            <th>Real Cost</th>
                                            <th>Qty</th>
                                            <th>Total Amount</th>
                                            <th>Transaction Type</th>
                                            <th>Supplier</th>
                                    </tr>
                                </thead>
                            </table>
                               
                                    
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="col-md-12">
                            <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
