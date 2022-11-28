<!-- Large Size -->
    <div class="modal fade" id="expounddiag" tabindex="-1" role="dialog" data-backdrop="static">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-green">
                    <h4 class="modal-title" id="expound">Expound Diagnosis</h4>
                </div>
                <div class="modal-body">
                    <form id="expound-diagnosis-form"><br>
                        <input type="hidden" name="control" value="">
                        <div class="col-md-12">
                         <div class="col-sm-1 hidden" id="hidecategory">
                            <span><button type="button" class="btn btn-default btn-circle waves-effect waves-green waves-circle waves-float " data-toggle="tooltip" data-placement="bottom" title="Hide" onclick="confine.hidecat()" >
                                        <i class="material-icons">remove</i>
                                    </button></span>
                        </div>
                        <div class="col-sm-6 hidden" id="newcategory">

                            <div class="form-group form-float">
                                <div class="form-line">
                                     <input type="text" name="newCat" class="form-control" id = "newcat"/>
                                    <label class="form-label">New Category</label>
                                </div>
                            </div>
                        </div>
                        <br>
                      
                        <div class="col-sm-1" id="btnAdd">
                            <span><button type="button" class="btn btn-default btn-circle waves-effect waves-green waves-circle waves-float " data-toggle="tooltip" data-placement="bottom" title="New Category" onclick="confine.addnewcategory()">
                                        <i class="material-icons">add</i>
                                    </button></span>
                        </div>
                    
                            <div class="col-sm-6" id="diaglist">
                            <div class="form-group form-float">
                               <span><select class="form-control show-tick" id="diagnosis" >
                                    <?php
                                        for($i=0;$i<count($diagnosis);$i++)
                                            {
                                                echo "<option value='".$diagnosis[$i]["causeofconfinement"]."'>".$diagnosis[$i]["causeofconfinement"]."</option>";
                                            }
                                    ?>
                                   
                                </select></span>

                            </div>
                        </div>
                            <div class="col-sm-2">
                            <span><button type="button" class="btn btn-default btn-circle waves-effect waves-green waves-circle waves-float pull-right" data-toggle="tooltip" data-placement="bottom" title="Add to Queue" onclick="addtoqueue()" id="btnqueue">
                                        <i class="material-icons">check</i>
                                    </button></span>
                        </div>
                        </div>
                        
                        
                        
                            <div class="row">
                            <div class="col-xs-9 p-t-5">
                                <ol id="diagnosislist">
                                    
                                </ol>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer bg-green">
                    <!--<button type="button" class="btn btn-link waves-effect">SAVE CHANGES</button>-->
                    <div class="col-md-12">
                            <button type="button" class="btn btn-link waves-effect waves-green" data-dismiss="modal">CLOSE</button>
                            <button type="button" onclick="savecat()" class="btn btn-link waves-effect waves-green">UNMERGE</button>
                    </div>
                    
                    
                </div>
            </div>
        </div>
    </div>