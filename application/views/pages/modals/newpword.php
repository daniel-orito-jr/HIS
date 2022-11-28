<!-- Large Size -->
    <div class="modal fade" id="newpword" tabindex="-1" role="dialog" data-backdrop="static">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header bg-green">
                    <h4 class="modal-title" id="ss"><i class="material-icons">lock</i>Change Password</h4>
                </div>
                <div class="modal-body">
                    <form id="first-modify-accnt-form"><br>
                        <input type="hidden" id="idx" name="idx"/>
                        <input type="hidden" id="docuser" name="docuser"/>
                        <div class="col-sm-12">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="password" name="pword" class="form-control">
                                    <label class="form-label">New Password</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="password" name="pwordconf" class="form-control">
                                    <label class="form-label">Retype Password</label>
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
                            <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                            <button type="button" onclick="user.first_modify_accnt()" class="btn btn-link waves-effect">SAVE</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script type="text/javascript">
document.addEventListener('DOMContentLoaded', function () {
  var input = document.getElementById("newpword");
  input.addEventListener("keyup", function(event) {
      event.preventDefault();
      if (event.keyCode === 13) {
         $('#newpword').modal('hide');
         location.reload();
//          document.getElementById("myBtn").click();
      }
  });
});
</script>