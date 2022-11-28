$('.date').datetimepicker({
        format: 'YYYY-MM-DD'
});

$('body').popover({
    selector: '[data-toggle="popover"]'
});

$('body').on('click', function (e) {
    $('[data-toggle="popover"]').each(function () {
        //the 'is' for buttons that trigger popups
        //the 'has' for icons within a button that triggers a popup
        if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
            $(this).popover('hide');
        }
    });
});

var voucher = {
    
    get_chequeapproval : function(){
        $('#cheque-approval-table').dataTable().fnDestroy();
        $('#cheque-approval-table tbody').empty();
        var table = $('#cheque-approval-table').dataTable({
            dom: 'frtip',
             
            responsive: {
            details: {
                    type: 'column',
                    target: -1
                }
            },
            pageLength: 30,
            columnDefs: [ {
                className: 'control',
                orderable: false,
                targets:   -1,
                width: "3%"
                
                
            },
                {
                    orderable: false,
                    className: 'select-checkbox',
                    targets:   0,
                    width: "3%"
                },
                {
                    targets : 6,
                    visible : false
                }
            ],
       
            select: {
                style:    'multi',
                selector: 'td:first-child'
            },
            
            
            
            processing:true,  
            serverSide:true, 
            order:[],
            
            
            ajax:{  
                url:BASE_URL + "user/fetch_chequeapproval",
                type:"POST"
            },
           
            
        });
    
        $('#cheque-approval-table_filter input').unbind();
        $('#cheque-approval-table_filter input').bind('keyup', function(e) {
            if(e.keyCode === 13) {
            table.fnFilter(this.value);	
            }
        });
    },
    
    
    
    
    
    
    
    //
    
    get_ticketdetails : function(id){
        
        $.ajax({
                type: 'POST',
                url:  BASE_URL + "user/checkapproveticket1",
                data: {ids:id},
                dataType: 'json'
                    }).done(function(data1) {
                        console.log(data1);
                        if (data1.status) {
                          console.log('success');
                          
                          var action ='';
                          if(data1.ticketapproved["APRVDONE"]==='1')            {action = "approved";}
                          else if (data1.ticketapproved["RETURNTICKET"]==='1')  {action = "disapproved";}
                          else{action = "deferred";}
                            swal({
                            title: "Ooops!!",
                            text: "Ticket was already "+action+" by "+ data1.ticketapproved["APPROVED"] + " earlier at "+data1.ticketapproved["APRVDATETIME"]+"!" ,
                            type: "warning"
                    }, function() {
                        location.reload();});

                         } else {
                             
                             $('#ticketdetails').modal("show");
                             
                            $.ajax({
                                type: 'POST',
                                url:  BASE_URL + "user/get_ticketdetails",
                                data: {ids:id},
                                dataType: 'json'
                            }).done(function(data1) {
                                console.log(data1);
                                if (data1.status) {
                                    console.log('success');
                                    
                                $('#ticket-details-form input[name=ticketref]').val(data1.ticketdetail["TICKETREF"]);
                                $('#dis-ticket-form input[name=disticketref]').val(data1.ticketdetail["TICKETREF"]);
                                $('#defer-ticket-form input[name=disticketref]').val(data1.ticketdetail["TICKETREF"]);
                                $('#credit-debit-form input[name=ticketcode]').val(data1.ticketdetail["TICKETCODE"]);
                                $('#ticket-details-form input[name=ticketcode]').val(data1.ticketdetail["TICKETCODE"]);
                
                                var ticketdate = moment(data1.ticketdetail["TICKETDATE"]).format('LL');
                                $('#ticket-details-form input[name=ticketdate]').val(ticketdate);
                   
                                var checkamt = accounting.format(data1.ticketdetail["CHEQUEAMT"],2);
                   
                                $('#ticket-details-form input[name=payee]').val(data1.ticketdetail["PAYEE"]);
                                $('#ticket-details-form input[name=checkamt]').val('₱ '+ checkamt);
                                $('#ticket-details-form input[name=checkname]').val(data1.ticketdetail["CHEQUENAME"]);
                                $('#ticket-details-form textarea[name=explanation]').val(data1.ticketdetail["EXPLANATION"]);
                                var prepdate = moment(data1.ticketdetail["PREPDATETIME"]).format('LLL');
                                var checkdate = moment(data1.ticketdetail["CHKDATETIME"]).format('LLL');
            
                                $('#ticket-details-form input[name=prepdatetime]').val(prepdate);
                                $('#ticket-details-form input[name=checkdatetime]').val(checkdate);
                                $('#ticket-details-form input[name=checknote]').val(data1.ticketdetail["note"]);
                            } 
                            else 
                            {
                                console.log('fail');
                            }
                        });
                    }
                });
        
        ///
       
    },
    
    get_ticketdetail : function(id){
        
        $('#ticketdetails').modal("show");
                             
        $.ajax({
            type: 'POST',
            url:  BASE_URL + "user/get_ticketdetails",
            data: {ids:id},
            dataType: 'json'
            }).done(function(data1) 
            {
                console.log(data1);
                if (data1.status) 
                {
                    console.log('success');
                                
                    $('#ticket-details-form input[name=ticketref]').val(data1.ticketdetail["TICKETREF"]);
                    $('#dis-ticket-form input[name=disticketref]').val(data1.ticketdetail["TICKETREF"]);
                    $('#defer-ticket-form input[name=disticketref]').val(data1.ticketdetail["TICKETREF"]);
                    $('#credit-debit-form input[name=ticketcode]').val(data1.ticketdetail["TICKETCODE"]);
                    $('#ticket-details-form input[name=ticketcode]').val(data1.ticketdetail["TICKETCODE"]);
                
                    var ticketdate = moment(data1.ticketdetail["TICKETDATE"]).format('LL');
                    $('#ticket-details-form input[name=ticketdate]').val(ticketdate);
                    var checkamt = accounting.format(data1.ticketdetail["CHEQUEAMT"],2);
                    $('#ticket-details-form input[name=payee]').val(data1.ticketdetail["PAYEE"]);
                    $('#ticket-details-form input[name=checkamt]').val('₱ '+ checkamt);
                    $('#ticket-details-form input[name=checkname]').val(data1.ticketdetail["CHEQUENAME"]);
                    $('#ticket-details-form textarea[name=explanation]').val(data1.ticketdetail["EXPLANATION"]);
                    var prepdate = moment(data1.ticketdetail["PREPDATETIME"]).format('LLL');
                    var checkdate = moment(data1.ticketdetail["CHKDATETIME"]).format('LLL');
                    $('#ticket-details-form input[name=prepdatetime]').val(prepdate);
                    $('#ticket-details-form input[name=checkdatetime]').val(checkdate);
                    $('#ticket-details-form input[name=checknote]').val(data1.ticketdetail["note"]);
                } 
                else 
                {
                    console.log('fail');
                }
            });
    },
   
   
   approve_ticket : function()
   {
       swal({
                            title: "Approve Ticket?",
                            text: "You cannot undo this action!",
                            type: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#4CAF50",
                            confirmButtonText: "Yes, approve it!",
                            cancelButtonText: "No",
                            closeOnConfirm: false
                        }, function () {
                            $.ajax({
                                type: 'POST',
                                url:  BASE_URL + "user/approveticket",
                                data: $('#ticket-details-form').serialize(),
                                dataType: 'json'
                            }).done(function(data1) {
                                console.log(data1);
                                if (data1.status) {
                                    console.log('success');
                                    swal({
                                        title: "Success!",
                                        text: "Ticket approved successfully!",
                                        type: "success"
                                    }, function() {
                                        location.reload();});
                                } else {
                                    console.log('fail');
                                }
                            });
                        });
   },
    
    
    approveticket : function()
    {
       
        $.ajax({
            type: 'POST',
            url:  BASE_URL + "user/checkapproveticket",
            data: $('#ticket-details-form').serialize(),
            dataType: 'json'
                }).done(function(data1) {
                    console.log(data1);
                    if (data1.status) 
                    {
                        console.log('success');
                         var action ='';
                        if(data1.ticketapproved["APRVDONE"]==='1')            {action = "approved";}
                        else if (data1.ticketapproved["RETURNTICKET"]==='1')  {action = "disapproved";}
                        else{action = "deferred";}
                        swal({
                            title: "Ooops!!",
                            text: "Ticket was already "+action+" by "+ data1.ticketapproved["APPROVED"] + " earlier at "+data1.ticketapproved["APRVDATETIME"]+"!" ,
                            type: "warning"
                        }, function() {
                        location.reload();});
                    } else {
                        swal({
                            title: "Approve Ticket?",
                            text: "You cannot undo this action!",
                            type: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#4CAF50",
                            confirmButtonText: "Yes, approve it!",
                            cancelButtonText: "No",
                            closeOnConfirm: false
                        }, function () {
                            $.ajax({
                                type: 'POST',
                                url:  BASE_URL + "user/approveticket",
                                data: $('#ticket-details-form').serialize(),
                                dataType: 'json'
                            }).done(function(data1) {
                                console.log(data1);
                                if (data1.status) {
                                    console.log('success');
                                    swal({
                                        title: "Success!",
                                        text: "Ticket approved successfully!",
                                        type: "success"
                                    }, function() {
                                        location.reload();});
                                } else {
                                    console.log('fail');
                                }
                            });
                        });
                    }
                });
    },
    
    disapprove_ticket : function ()
    {
        $("#disapproveticket").modal("show");
    },
    
    disapproveticket : function()
    {
            $.ajax({
                type: 'POST',
                url:  BASE_URL + "user/checkapproveticket",
                data: $('#ticket-details-form').serialize(),
                dataType: 'json'
                    }).done(function(data1) {
                        console.log(data1);
                        if (data1.status) {
                          console.log('success');
                           var action ='';
                          if(data1.ticketapproved["APRVDONE"]==='1')            {action = "approved";}
                          else if (data1.ticketapproved["RETURNTICKET"]==='1')  {action = "disapproved";}
                          else{action = "deferred";}
                            swal({
                            title: "Ooops!!",
                            text: "Ticket was already "+action+" by "+ data1.ticketapproved["APPROVED"] + " earlier at "+data1.ticketapproved["APRVDATETIME"]+"!" ,
                            type: "warning"
                    }, function() {
                        location.reload();});
                } else {
                    $("#disapproveticket").modal("show");
                   
                }
            });
        
    },
    
    disapprove_t : function ()
    {
         swal({
                        title: "Disapprove Ticket?",
                        text: "You cannot undo this action!",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#F44336",
                        confirmButtonText: "Yes, disapprove it!",
                        cancelButtonText: "No",
                        closeOnConfirm: false
                    }, function () {
                        swal.close();
                        voucher.disapprove();
                    });
    },
    
    disapprove : function()
    {
        $.ajax({
                        type: 'POST',
                        url:  BASE_URL + "user/disapproveticket",
                        data: $('#dis-ticket-form').serialize(),
                        dataType: 'json'
                    }).done(function(data1) {
                        console.log(data1);
                        if (data1.status) {
                          console.log('success');
                            swal({
                            title: "Success!",
                            text: "Ticket disapproved successfully!",
                            type: "success"
                    }, function() {
                        location.reload();});

                         } else {
                            console.log('fail');
                        }
                    });
    },
    
    dismiss : function()
    {
         $("#disapproveticket").modal("hide");
    },
     dismissdef : function()
    {
         $("#deferticket").modal("hide");
    },
    
    dismisscr : function()
    {
         $("#crdbdetails").modal("hide");
    },
    
    defer_ticket : function()
    {
         $("#deferticket").modal("show");
    },
    
    deferred : function()
    {
        $.ajax({
                type: 'POST',
                url:  BASE_URL + "user/checkapproveticket",
                data: $('#ticket-details-form').serialize(),
                dataType: 'json'
                    }).done(function(data1) {
                        console.log(data1);
                        if (data1.status) {
                          console.log('success');
                           var action ='';
                          if(data1.ticketapproved["APRVDONE"]==='1')            {action = "approved";}
                          else if (data1.ticketapproved["RETURNTICKET"]==='1')  {action = "disapproved";}
                          else{action = "deferred";}
                            swal({
                            title: "Ooops!!",
                            text: "Ticket was already "+action+" by "+ data1.ticketapproved["APPROVED"] + " earlier at "+data1.ticketapproved["APRVDATETIME"]+"!" ,
                            type: "warning"
                    }, function() {
                        location.reload();});
                } else {
                     $("#deferticket").modal("show");
                    
                }
            });
        
    },
    
    deferticket_t : function ()
    {
      swal({
                        title: "Defer Ticket?",
                        text: "You cannot undo this action!",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#FF9800",
                        confirmButtonText: "Yes, defer it!",
                        cancelButtonText: "No",
                        closeOnConfirm: false
                    }, function () {
                        swal.close();
                       
                        voucher.deferticket();
                    });  
    },
    deferticket : function()
    {
        $.ajax({
                        type: 'POST',
                        url:  BASE_URL + "user/deferticket",
                        data: $('#defer-ticket-form').serialize(),
                        dataType: 'json'
                    }).done(function(data1) {
                        console.log(data1);
                        if (data1.status) {
                          console.log('success');
                            swal({
                            title: "Success!",
                            text: "Ticket deferred successfully!",
                            type: "success"
                    }, function() {
                        location.reload();});

                         } else {
                            console.log('fail');
                        }
                    });
    },
    
    get_disapproved_ticket : function(){
        $('#disapproved-ticket-table').dataTable().fnDestroy();
        $('#disapproved-ticket-table tbody').empty();
        var table = $('#disapproved-ticket-table').dataTable({
            dom: 'frtip',
            responsive: true,
            processing:true,  
            serverSide:true, 
            order:[],
             pageLength: 30,
            ajax:{  
                url:BASE_URL + "user/fetch_disapprovedticket",
                type:"POST"
            },
            
            
        });
        $('#disapproved-ticket-table_filter input').unbind();
        $('#disapproved-ticket-table_filter input').bind('keyup', function(e) {
            if(e.keyCode == 13) {
            table.fnFilter(this.value);	
            }
        });
    },
    
    get_deferred_ticket : function(){
        $('#deferred-ticket-table').dataTable().fnDestroy();
        $('#deferred-ticket-table tbody').empty();
        var table = $('#deferred-ticket-table').dataTable({
            dom: 'frtip',
            responsive: true,
            processing:true,  
            serverSide:true, 
            order:[],
             pageLength: 30,
            ajax:{  
                url:BASE_URL + "user/fetch_deferredticket",
                type:"POST"
            },
            
            
        });
        $('#deferred-ticket-table_filter input').unbind();
        $('#deferred-ticket-table_filter input').bind('keyup', function(e) {
            if(e.keyCode == 13) {
            table.fnFilter(this.value);	
            }
        });
    },
    
    
    get_approved_ticket : function(){
        $('#approved-ticket-table').dataTable().fnDestroy();
        $('#approved-ticket-table tbody').empty();
        var table = $('#approved-ticket-table').dataTable({
            dom: 'frtip',
            searching:false,
            responsive: true,
            processing:true,  
            serverSide:true, 
            order:[],
             pageLength: 30,
            ajax:{  
                url:BASE_URL + "user/fetch_approvedticket",
                type:"POST"
            },
            
            
        });
        $('#approved-ticket-table_filter input').unbind();
        $('#approved-ticket-table_filter input').bind('keyup', function(e) {
            if(e.keyCode == 13) {
            table.fnFilter(this.value);	
            }
        });
    },
    
    get_credit_debit_details : function(){
        var code = $("#credit-debit-form input[name=ticketcode]").val();
        $('#credit-debit-table').dataTable().fnDestroy();
        $('#credit-debit-table tbody').empty();
        var table = $('#credit-debit-table').dataTable({
            dom: 'frtip',
            responsive: true,
            processing:true,  
            serverSide:true, 
            order:[],
            ajax:{  
                url:BASE_URL + "user/fetch_credit_debit_details/"+code,
                type:"POST"
            },
            initComplete : function(settings, json){
                $("#credit-debit-form input[name=totaldebit]").val('₱ '+ accounting.format(json["total"]["debit"],2)).closest('.form-line').addClass('focused');
                $("#credit-debit-form input[name=totalcredit]").val('₱ '+ accounting.format(json["total"]["credit"],2)).closest('.form-line').addClass('focused');
            }
        });
        $('#credit-debit-table_filter input').unbind();
        $('#credit-debit-tablee_filter input').bind('keyup', function(e) {
            if(e.keyCode == 13) {
            table.fnFilter(this.value);	
            }
        });
    },
    
    get_selected_app : function($action)
    {
        if ($('#cheque-approval-table').DataTable().rows({selected:  true}).data().length == 0) {
            swal({
                title: "Oops!",
                text: "Please select a ticket.",
                type: "warning"
            });
        }else{
            var ctrl = [];
            var data = $('#cheque-approval-table').DataTable().rows({selected:  true}).data();
            for (var i = 0; i <data.length; i++) {
                ctrl.push(data[i][6]);
            }
          
            $.ajax({
                type: 'POST',
                url:  BASE_URL + "user/check_ticket",
                data: {controls : ctrl},
                dataType: 'json'
                }).done(function(data1) {
                console.log(data1);
                if (data1.status) {
                console.log('success');
                for (var i = 0; i < data1.count; i++)
                {
                   
                    swal({
                    title: "Oopps!!!",
                    text:  data1.count+" of your choice has been decided! Do you want to refresh the page?",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#4CAF50",
                    confirmButtonText: "Yes, refresh it!",
                    cancelButtonText: "No",
                    closeOnConfirm: false
                    }, function () {
                       location.reload();
                    });
                }
            } 
            else 
            {
                console.log($action);
                switch ($action)
                {
                    case "approve":
                         voucher.approve_t(ctrl);
                         break;
                    case "disapprove":
                        $("#disticket").modal("show");
                        break;
                    case "deferred":
                        $("#defticket").modal("show");
                        break;
                }
                console.log("Save");
               
            }
        });
            
        }
    },
    
    approve_t : function (ctrl)
    {
        swal({
            title: "Approve Ticket?",
            text: "You cannot undo this action!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#4CAF50",
            confirmButtonText: "Yes, approve it!",
            cancelButtonText: "No",
            closeOnConfirm: false
            }, function () {
                voucher.approve_p(ctrl);
            });
    },
    
    approve_p : function(data){
//        console.log(data);
//        console.log(data[5]);
        $('#cheque-approval-table').dataTable().fnDestroy();
        $('#cheque-approval-table tbody').empty();
        var table = $('#cheque-approval-table').dataTable({
            dom: 'frtip',
            responsive: {
            details: {
                    type: 'column',
                    target: -1
                }
            },
            pageLength:30,
            columnDefs: [ {
                className: 'control',
                orderable: false,
                targets:   -1,
                width: "3%"
            },
                {
                    orderable: false,
                    className: 'select-checkbox',
                    targets:   0,
                    width: "3%"
                },
                {
                    targets : 6,
                    visible : false
                }
            ],
            select: {
                style:    'multi',
                selector: 'td:first-child'
            },
            processing:true,  
            serverSide:true, 
            order:[],    
            ajax:{  
                url:BASE_URL + "user/app_ticket",
                data: {controls : data},
                type:"POST"
            },
            initComplete: function(settings, json) {
                $('[data-toggle="popover"]').click(function(){
                    $('[data-toggle="popover"]').not(this).popover('hide'); //all but this
                });
               swal("Success","Ticket/s approved!","success");
            }
            
        });
         
        $('#cheque-approval-table_filter input').unbind();
        $('#cheque-approval-table_filter input').bind('keyup', function(e) {
            if(e.keyCode == 13) {
                table.fnFilter(this.value);	
            }
        });
    },
    
    
    get_selected_dis : function(){
        if ($('#cheque-approval-table').DataTable().rows({selected:  true}).data().length == 0) {
            swal({
                title: "Oops!",
                text: "Please select ticket/s for disapproval.",
                type: "warning"
            });
        }else{
            $("#disticket").modal("show");
        }
    },
    
    disapprove_p : function(){
        var ctrl = [];
        var data = $('#cheque-approval-table').DataTable().rows({selected:  true}).data();
        for (var i = 0; i <data.length; i++) {
            ctrl.push(data[i][6]);
        }
        
        swal({
            title: "Disapprove Ticket?",
            text: "You cannot undo this action!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#F44336",
            confirmButtonText: "Yes, disapprove it!",
            cancelButtonText: "No",
            closeOnConfirm: false
        }, function () {
            $('#cheque-approval-table').dataTable().fnDestroy();
            $('#cheque-approval-table tbody').empty();
            var table = $('#cheque-approval-table').dataTable({
                dom: 'frtip',
                responsive: {
                details: {
                        type: 'column',
                        target: -1
                    }
                },
                pageLength:30,
                columnDefs: [ {
                    className: 'control',
                    orderable: false,
                    targets:   -1,
                    width: "3%"
                },
                
                    {
                        orderable: false,
                        className: 'select-checkbox',
                        targets:   0,
                        width: "3%"
                    },
                    {
                        targets : 6,
                        visible : false
                    }
                ],
                select: {
                    style:    'multi',
                    selector: 'td:first-child'
                },
                processing:true,  
                serverSide:true, 
                order:[],   
                ajax:{  
                    url:BASE_URL + "user/dis_ticket",
                    type:"POST",
                    data: {controls : ctrl, b: $("#disapprove-ticket-form textarea[name=note]").val()}
                },
                initComplete: function(settings, json) {
                    $('[data-toggle="popover"]').click(function(){
                        $('[data-toggle="popover"]').not(this).popover('hide'); //all but this
                    });
                    $("#disticket").modal("hide");
                    swal("Sucess","Ticket disapproved!","success");
                  location.reload();
                }

            });
            $('#cheque-approval-table_filter input').unbind();
            $('#cheque-approval-table_filter input').bind('keyup', function(e) {
                if(e.keyCode == 13) {
                table.fnFilter(this.value);	
                }
            });
        });
    },
    
    
    get_selected_def : function(){
        if ($('#cheque-approval-table').DataTable().rows({selected:  true}).data().length == 0) {
            swal({
                title: "Oops!",
                text: "Please select ticket/s for deferral.",
                type: "warning"
            });
        }else{
            $("#defticket").modal("show");
        }
    },
    
    deffer : function(){
        var ctrl = [];
        var data = $('#cheque-approval-table').DataTable().rows({selected:  true}).data();
        for (var i = 0; i <data.length; i++) {
            ctrl.push(data[i][6]);
        }
        
        swal({
            title: "Defer Ticket?",
            text: "You cannot undo this action!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#FF9800",
            confirmButtonText: "Yes, defer it!",
            cancelButtonText: "No",
            closeOnConfirm: false
        }, function () {
            $('#cheque-approval-table').dataTable().fnDestroy();
            $('#cheque-approval-table tbody').empty();
            var table = $('#cheque-approval-table').dataTable({
                dom: 'frtip',
                responsive: {
                details: {
                        type: 'column',
                        target: -1
                    }
                },
                pageLength:30,
                columnDefs: [ {
                    className: 'control',
                    orderable: false,
                    targets:   -1,
                    width: "3%"
                },
                    {
                        orderable: false,
                        className: 'select-checkbox',
                        targets:   0,
                        width: "3%"
                    },
                    {
                        targets : 6,
                        visible : false
                    }
                ],
                select: {
                    style:    'multi',
                    selector: 'td:first-child'
                },
                processing:true,  
                serverSide:true, 
                order:[],   
                ajax:{  
                    url:BASE_URL + "user/def_ticket",
                    type:"POST",
                    data: {controls : ctrl, b: $("#def-ticket-form textarea[name=note]").val()}
                },
                initComplete: function(settings, json) {
                    $('[data-toggle="popover"]').click(function(){
                        $('[data-toggle="popover"]').not(this).popover('hide'); //all but this
                    });
                    $("#defticket").modal("hide");
                    swal("Sucess","Ticket deferred!","success");
                  location.reload();
                }

            });
            $('#cheque-approval-table_filter input').unbind();
            $('#cheque-approval-table_filter input').bind('keyup', function(e) {
                if(e.keyCode == 13) {
                table.fnFilter(this.value);	
                }
            });
        });
    },
    
    
    
    }

$(".report-btn").hide();
/* 
     * 
     * 
$(".report-btn").hide();
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//
$("#check-all").on("change",function(){
    var table = $('#cheque-approval-table').DataTable();
    if($(this)[0].checked) {
        table.rows('#cheque-approval-table tbody tr').select();
        
    }else{
        table.rows('#cheque-approval-table tbody tr').deselect();
    }
    
    //--------------------------------------------------------sum price
    var data = table.rows({selected:  true}).data();
    var totalPrice = 0.0; 
    for (var i = 0; i < data.length; i++) {
        totalPrice += parseFloat(trim_money(data[i][2]));
    }
    
    $("#chequeAmt").html('(₱ '+accounting.format(totalPrice,2)+')');
});

function trim_money(data){
    var res = data.split(";");
    return res[1].replace(/,/g,'').trim();
}

$('#cheque-approval-table').on('click', '.select-checkbox', function () {
    var current_row = $(this).parents('tr');//Get the current row
    if (current_row.hasClass('child')) {//Check if the current row is a child row
        current_row = current_row.prev();//If it is, then point to the row before it (its 'parent')
    }
//  
    var cur_row = $('#cheque-approval-table').dataTable().fnGetData(current_row);
    var totalPrice = 0.0;
    
    var data = $('#cheque-approval-table').DataTable().rows({selected:  true}).data();
    
    if (cur_row != null) {
        $('#check-all').removeAttr('checked');
        if (data.length > 0) {
            for (var i = 0; i < data.length; i++) {
                totalPrice += parseFloat(trim_money(data[i][2]));
            }
            if (current_row.hasClass('selected')) {
                totalPrice -= parseFloat(trim_money(cur_row[2]));
            }else{
                totalPrice += parseFloat(trim_money(cur_row[2]));
            }
        }else{
            totalPrice += parseFloat(trim_money(cur_row[2]));
        }
        $("#chequeAmt").html('(₱ '+accounting.format(totalPrice,2)+')');
    }
});
