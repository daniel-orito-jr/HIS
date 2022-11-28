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


 function job()
    {
         var deptment=$("#dept").val();
         jobapproval.get_jobapproval(deptment);
     }
    

var jobapproval = {
    
    get_jobapproval : function(deptment){
        $('#job-approval-table').dataTable().fnDestroy();
        $('#job-approval-table tbody').empty();
        var table = $('#job-approval-table').dataTable({
            dom: 'frtip',
             scrollX:true,
//            responsive: {
//            details: {
//                    type: 'column',
//                    target: -1
//                }
//            },
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
                    targets:[1,7],
                    visible:false
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
                url:BASE_URL + "user/fetch_jobapproval/"+deptment,
                type:"POST"
            },
           
            
        });
    
        $('#job-approval-table_filter input').unbind();
        $('#job-approval-table_filter input').bind('keyup', function(e) {
            if(e.keyCode === 13) {
            table.fnFilter(this.value);	
            }
        });
    },
  
  get_selected_app : function($action)
    {
        if ($('#job-approval-table').DataTable().rows({selected:  true}).data().length == 0) {
            swal({
                title: "Oops!",
                text: "Please select a ticket.",
                type: "warning"
            });
        }else{
            var ctrl = [];
            var data = $('#job-approval-table').DataTable().rows({selected:  true}).data();
            for (var i = 0; i <data.length; i++) {
                ctrl.push(data[i][7]);
            }
            
         
          
            $.ajax({
                type: 'POST',
                url:  BASE_URL + "user/check_joborders",
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
                         jobapproval.approve_t(ctrl);
                         break;
                    case "disapprove":
                        $("#jobdisticket").modal("show");
                        break;
                    case "deferred":
                        $("#jobdefticket").modal("show");
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
                jobapproval.approve_p(ctrl);
            });
    },
    
    approve_p : function(data){
   
//        console.log(data);
//        console.log(data[5]);
        $('#job-approval-table').dataTable().fnDestroy();
        $('#job-approval-table tbody').empty();
        var table = $('#job-approval-table').dataTable({
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
                    targets:[1,7],
                    visible:false
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
                url:BASE_URL + "user/approve_joborderx",
                data: {controls : data},
                type:"POST"
            },
            initComplete: function(settings, json) {
                $('[data-toggle="popover"]').click(function(){
                    $('[data-toggle="popover"]').not(this).popover('hide'); //all but this
                });
               swal("Success","Job Order/s approved!","success");
         
            }
            
        });
         
        $('#job-approval-table_filter input').unbind();
        $('#job-approval-table_filter input').bind('keyup', function(e) {
            if(e.keyCode == 13) {
                table.fnFilter(this.value);	
            }
        });
    },
   
    disapprove_p : function(){
        var ctrl = [];
        var data = $('#job-approval-table').DataTable().rows({selected:  true}).data();
        for (var i = 0; i <data.length; i++) {
            ctrl.push(data[i][7]);
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
            $('#job-approval-table').dataTable().fnDestroy();
            $('#job-approval-table tbody').empty();
            var table = $('#job-approval-table').dataTable({
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
                        targets:[1,7],
                        visible:false
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
                    url:BASE_URL + "user/disapprove_joborderx",
                    type:"POST",
                    data: {controls : ctrl, b: $("#disapprove-joborder-form textarea[name=note]").val()}
                },
                initComplete: function(settings, json) {
                    $('[data-toggle="popover"]').click(function(){
                        $('[data-toggle="popover"]').not(this).popover('hide'); //all but this
                    });
                    $("#jobdisticket").modal("hide");
                    swal("Sucess","Ticket disapproved!","success");
                
                }

            });
            $('#job-approval-table_filter input').unbind();
            $('#job-approval-table_filter input').bind('keyup', function(e) {
                if(e.keyCode == 13) {
                table.fnFilter(this.value);	
                }
            });
        });
    },
   
   deffer : function(){
        var ctrl = [];
        var data = $('#job-approval-table').DataTable().rows({selected:  true}).data();
        for (var i = 0; i <data.length; i++) {
            ctrl.push(data[i][7]);
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
            $('#job-approval-table').dataTable().fnDestroy();
            $('#job-approval-table tbody').empty();
            var table = $('#job-approval-table').dataTable({
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
                         targets:[1,7],
                        visible:false
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
                    url:BASE_URL + "user/defer_joborderx",
                    type:"POST",
                    data: {controls : ctrl, b: $("#def-jobapproval-form textarea[name=note]").val()}
                },
                initComplete: function(settings, json) {
                    $('[data-toggle="popover"]').click(function(){
                        $('[data-toggle="popover"]').not(this).popover('hide'); //all but this
                    });
                    $("#jobdefticket").modal("hide");
                    swal("Sucess","Ticket deferred!","success");
               
                }

            });
            $('#job-approval-table_filter input').unbind();
            $('#job-approval-table_filter input').bind('keyup', function(e) {
                if(e.keyCode == 13) {
                table.fnFilter(this.value);	
                }
            });
        });
    },
   
   get_disapproved_ticket : function(){
        $('#disapproved-joborder-table').dataTable().fnDestroy();
        $('#disapproved-joborder-table tbody').empty();
        var table = $('#disapproved-joborder-table').dataTable({
            dom: 'frtip',
            responsive: true,
            processing:true,  
            serverSide:true, 
            order:[],
             pageLength: 30,
             columnDefs: [ {
                     targets:[0,7],
                     visible:false
                    }
                ],
             
            ajax:{  
                url:BASE_URL + "user/fetch_disapprovedjoborders",
                type:"POST"
            },
            
            
        });
        $('#disapproved-joborder-tablefilter input').unbind();
        $('#disapproved-joborder-table_filter input').bind('keyup', function(e) {
            if(e.keyCode == 13) {
            table.fnFilter(this.value);	
            }
        });
    },
    
     get_disapprovedjoborder_report : function(){
       
        $("#disapproved-joborder-form").submit();
    },
    
     get_csv_disapprovedjoborder_report : function(){
       
        $("#csv_disapproved-joborder-form").submit();
    },
    
    get_deferred_ticket : function(){
        $('#deferred-joborder-table').dataTable().fnDestroy();
        $('#deferred-joborder-table tbody').empty();
        var table = $('#deferred-joborder-table').dataTable({
            dom: 'frtip',
            responsive: true,
            processing:true,  
            serverSide:true, 
            order:[],
            pageLength: 30,
            columnDefs: [ {
                     targets:[0,7],
                     visible:false
                    }
                ],
            ajax:{  
                url:BASE_URL + "user/fetch_deferredjoborders",
                type:"POST"
            },
            
            
        });
        $('#deferred-joborder-table_filter input').unbind();
        $('#deferred-joborder-table_filter input').bind('keyup', function(e) {
            if(e.keyCode == 13) {
            table.fnFilter(this.value);	
            }
        });
    },
   
   get_deferredjoborder_report : function ()
   {
        $("#deferred-joborder-form").submit();
   },
   
   get_csv_deferredjoborder_report : function ()
   {
        $("#csv_deferred-joborder-form").submit();
   },
   
  
   
   search_approved_joborder : function(){
        
        var s_date = $('#approved-joborder-form input[name = start_date]');
        var error = 0;
        
//        alert(s_date.val());
        if (s_date.val() == "") {
            s_date.parents('.form-line').removeClass('error success').addClass('error');
            s_date.parents('.input-group').find('small').text('Please select a start date!');
            error++;
        }else{
            s_date.parents('.form-line').removeClass('error success').addClass('success');
            s_date.parents('.input-group').find('small').text('');
        }
        
        
        if (error === 0) {
//            alert("jiasdf");
            load_script("http://192.168.2.111:3777/drainwizv2/assets/vendors/js/responsive.js",0,0);
        }
    },
   
    load_records : function(type){
        switch(parseInt(type)){
            case 0:
                var s_date = $('#approved-joborder-form input[name = start_date]');
                $('#approved-joborder-form input[name = s_date]').val(s_date.val());
                jobapproval.get_approved_joborder_by_date();
                break;
            default:
                break;
        }
    },
   
   //approved tickets: alingling
    get_approved_joborder_by_date : function(){
       
        $('#approved-joborder-table').dataTable().fnDestroy();
        var table = $('#approved-joborder-table').dataTable({
            dom: 'frtip',
            searching: false,
            responsive: true,
            processing:true,  
            serverSide:true, 
            order:[],  
             columnDefs: [ {
                     targets:[0,7],
                     visible:false
                    }
                ],
            ajax:{  
                url:BASE_URL + "user/fetch_approved_joborder_by_date",
                type:"POST",
                data: { 
                    start_date :  $('#approved-joborder-form input[name = s_date]').val()
                   
                }
            }
        });
        $('#approved-joborder-table_filter input').unbind();
        $('#approved-joborder-table_filter input').bind('keyup', function(e) {
            if(e.keyCode == 13) {
            table.fnFilter(this.value);	
            }
        });
    },
   
   
    //approvedticket: alingling
    get_pdf_approvedjoborder_report : function(){
        start_date = $('#approved-joborder-form input[name=start_date]').val(); 
        $("#pdf_approved-joborder-form input[name=pdf_date]").val(start_date);
      
        $("#pdf_approved-joborder-form").submit();
    },
    //approvedticket: alingling
    get_csv_approvedjoborder_report : function(){
        start_date = $('#approved-joborder-form input[name=start_date]').val(); 
        $("#csv_approved-joborder-form input[name=csv_date]").val(start_date);
        $("#csv_approved-joborder-form").submit();
    },
   
   
   
   /////////////////////////////////////////////////////
   
     get_fix_assets : function(data)
{
    $('#jobapprovalinfo').modal('show');
  
   // $('#jobapprovalinfos').text(data);
 
   $('#assets-service-form input[name=id]').val(data[0]);
    $('#asset-info-table').dataTable().fnDestroy();
        var table = $('#asset-info-table').dataTable({
            dom: 'frtip',
            responsive: true,
            processing:true,  
            serverSide:true, 
            order:[],  
            ajax:{  
                url:BASE_URL + "user/get_assets_info",
                type:"POST",
                data: { 
                    ID: data
                }
            },
             initComplete : function(settings,json){
                $("#quantity").html(json["count"]).closest('.form-line').addClass('focused');
               
            }
        });
        $('#asset-info-table_filter input').unbind();
        $('#asset-info-table_filter input').bind('keyup', function(e) {
            if(e.keyCode === 13) {
            table.fnFilter(this.value); 
            }
        });
  
}
    
    }


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
    var table = $('#job-approval-table').DataTable();
    if($(this)[0].checked) 
    {
        table.rows('#job-approval-table tbody tr').select();
    }
    else
    {
        table.rows('#job-approval-table tbody tr').deselect();
    }
    
    //--------------------------------------------------------sum price
    var data = table.rows({selected:  true}).data();
    var totalPrice = 0.0; 
    for (var i = 0; i < data.length; i++) {
        totalPrice += parseFloat(trim_money(data[i][2]));
    }
    
   // $("#jobAmt").html('(₱ '+accounting.format(totalPrice,2)+')');
});

function trim_money(data){
    var res = data.split(";");
    return res[1].replace(/,/g,'').trim();
}

$('#cheque-approval-table').on('click', '.select-checkbox', function () {
    var current_row = $(this).parents('tr');//Get the current row
    if (current_row.hasClass('child')) 
    {//Check if the current row is a child row
        current_row = current_row.prev();//If it is, then point to the row before it (its 'parent')
    }
//  
    var cur_row = $('#job-approval-table').dataTable().fnGetData(current_row);
    var totalPrice = 0.0;
    
    var data = $('#job-approval-table').DataTable().rows({selected:  true}).data();
    
    if (cur_row !== null) 
    {
        $('#check-all').removeAttr('checked');
        if (data.length > 0) 
        {
            for (var i = 0; i < data.length; i++) 
            {
                totalPrice += parseFloat(trim_money(data[i][2]));
            }
            if (current_row.hasClass('selected')) 
            {
                totalPrice -= parseFloat(trim_money(cur_row[2]));
            }
            else
            {
                totalPrice += parseFloat(trim_money(cur_row[2]));
            }
        }
        else
        {
            totalPrice += parseFloat(trim_money(cur_row[2]));
        }
       // $("#chequeAmt").html('(₱ '+accounting.format(totalPrice,2)+')');
    }
});

function load_script(scriptUrl,type,subType)
{
    $.getScript(scriptUrl)
        .done(function( script, textStatus ) {
            console.log( textStatus );
            switch(parseInt(subType)){
                case 0:
                    jobapproval.load_records(type);
                    break;
               
                default:
                    break;
            }
            
        })
        .fail(function( jqxhr, settings, exception ) {
         console.log("fail to load script");
    });
    }
    
   

