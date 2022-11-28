$('.date').datetimepicker({
        format: 'YYYY-MM'
});

var purchase1 = 
{
    supplier : function()
    {
        $('#stock-supplier-table').dataTable().fnDestroy();
        $('#stock-supplier-table tbody').empty();
        var table = $('#stock-supplier-table').dataTable({
            dom: 'frtip',
            pageLength: 10,
            processing:true,  
            serverSide:true, 
            order:[],
            ajax:{  
                url:BASE_URL + "user/fetch_purchase_supplier/fapproval",
                type:"POST",
            },
            
            initComplete : function(){}
            
        });
        $('#stock-supplier-table_filter input').unbind();
        $('#stock-supplier-table_filter input').bind('keyup', function(e) {
            if(e.keyCode == 13) {
            table.fnFilter(this.value);	
            }
        });
    },
    approvee : function(control)
    {
        var prnumber = $('#prnumber').val();
        
       $('#stock-table').dataTable().fnDestroy();
        $('#stock-table tbody').empty();
        var table = $('#stock-table').dataTable({
            dom: 'frtip',
            pageLength: 10,
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
                       targets : [12,13,14,15,16,17,18,19,20,21],
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
                url:BASE_URL + "user/app_stocks",
                type:"POST",
                 data: { 
                    control : control, pocode : prnumber
                }
            },
            
            createdRow : function( row, datax, dataIndex){
                    if( datax[19] ===  "1")
                    {
                        $(row).css('background-color','#D5F5E3');
                    }
                    
                    if( datax[20] ===  "1")
                    {
                        $(row).css('background-color','#F5B7B1');
                    }
                    
                    if( datax[21] ===  "1")
                    {
                        $(row).css('background-color','#F5CBA7  '); 
                    }
            },
            
            initComplete : function(){}
            
        });
        $('#stock-table_filter input').unbind();
        $('#stock-table_filter input').bind('keyup', function(e) {
            if(e.keyCode == 13) {
            table.fnFilter(this.value);	
            }
        });
    },
    
    get_dis_stocks : function(control)
    {
        var pr = $('#prnumber').val();
        $('#cc').val(control);
        $('#pr').val(pr);
        $('#note').val('');
        $('#disapprove_all').addClass('hidden');
        $('#purchase-stock').removeClass('hidden');
        $("#disPurchase").modal("show");
    },
    
    disapprovee : function()
    {
//        alert("Hello");
        var control = $('#cc').val();
        var prnumber = $('#pr').val();
        var note = $('#note').val();
        
       $('#stock-table').dataTable().fnDestroy();
        $('#stock-table tbody').empty();
        var table = $('#stock-table').dataTable({
            dom: 'frtip',
            pageLength: 10,
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
                       targets : [12,13,14,15,16,17,18,19,20,21],
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
                url:BASE_URL + "user/disapp_stocks",
                type:"POST",
                 data: { 
                    control : control, pocode : prnumber, note: note
                }
            },
            
            createdRow : function( row, datax, dataIndex){
                  if( datax[19] ===  "1")
                    {
                        $(row).css('background-color','#D5F5E3');
                    }
                    
                    if( datax[20] ===  "1")
                    {
                        $(row).css('background-color','#F5B7B1');
                    }
                    
                    if( datax[21] ===  "1")
                    {
                        $(row).css('background-color','#F5CBA7  '); 
                    }
            },
            
            initComplete : function(){  
                $("#disPurchase").modal("hide");
                swal("Sucess","Purchase disapproved!","success");
                

            }
            
        });
        $('#stock-table_filter input').unbind();
        $('#stock-table_filter input').bind('keyup', function(e) {
            if(e.keyCode == 13) {
            table.fnFilter(this.value);	
            }
        });
    },
    
    get_def_stocks : function(control)
    {
        var pr = $('#prnumber').val();
        $('#ccd').val(control);
        $('#prd').val(pr);
        $('#noted').val('');
        $('#defer_all').addClass('hidden');
        $('#def-supplier').removeClass('hidden');
        $("#defPurchase").modal("show");
    },
    
    deferree : function()
    {
        var control = $('#ccd').val();
        var prnumber = $('#prd').val();
        var noted = $('#noted').val();
        
       $('#stock-table').dataTable().fnDestroy();
        $('#stock-table tbody').empty();
        var table = $('#stock-table').dataTable({
            dom: 'frtip',
//            responsive: {
//            details: {
//                    type: 'column',
//                    target: -1
//                }
//            },
            pageLength: 10,
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
                       targets : [12,13,14,15,16,17,18,19,20,21],
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
                url:BASE_URL + "user/defapp_stocks",
                type:"POST",
                 data: { 
                    control : control, pocode : prnumber, noted: noted
                }
            },
            
            createdRow : function( row, datax, dataIndex){
                    if( datax[19] ===  "1")
                    {
                        $(row).css('background-color','#D5F5E3');
                    }
                    
                    if( datax[20] ===  "1")
                    {
                        $(row).css('background-color','#F5B7B1');
                    }
                    
                    if( datax[21] ===  "1")
                    {
                        $(row).css('background-color','#F5CBA7  '); 
                    }
            },
            
            initComplete : function(){  
                $("#defPurchase").modal("hide");
                swal("Sucess","Purchase deferred!","success");
                

            }
            
        });
        $('#stock-table_filter input').unbind();
        $('#stock-table_filter input').bind('keyup', function(e) {
            if(e.keyCode == 13) {
            table.fnFilter(this.value);	
            }
        });
    },
    
    proceedtopo : function()
    {
        var prnumber = $('#prnumber').val();
        var dept = $('#dept').val();
        var prdate = $('#prdate').val();
        var supplier = $('#supname').val();
        $.ajax({
        type: 'POST',
        url:  BASE_URL + "user/proceed_to_po",
        data: {pocode : prnumber,dept:dept},
        dataType: 'json'
        }).done(function(data) {
            console.log(data);
            if (data.status) 
            {
                swal({
                    title: "Proceed to Purchase Order?",
                    text: "You have " + data.noact.length + " pending purchase(s) to review.",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#4CAF50",
                    confirmButtonText: "Proceed anyway",
                    cancelButtonText: "Cancel",
                    closeOnConfirm: false
                }, function () {
                    var ctrl = [];
                    for (var i = 0; i <data.noact.length; i++) 
                    {
                        ctrl.push(data.noact[i]['control']);
                    }
                    
                    purchase1.proceed_po(ctrl,prnumber,data.prmobile.mobileno,prdate,supplier,dept);
                });
               
//                 swal("Success!","Imported!","success");

            } 
            else 
            {
                swal({
                    title: "Proceed to Purchase Order?",
                    text: "You won't be able to revert this!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#4CAF50",
                    confirmButtonText: "Proceed anyway",
                    cancelButtonText: "Cancel",
                    closeOnConfirm: false
                }, function () {
                 
                   purchase1.update_prmaster(prnumber,dept,prdate,supplier);
                });
                
            }
        });
    },
    
    proceed_po : function(ctrl,prnumber,mobileno,prdate,supplier,dept)
    {
       
        $.ajax({
        type: 'POST',
        url:  BASE_URL + "user/proceed_po",
        data: {control:ctrl, prnumber:prnumber,prmobile:mobileno,prdate:prdate,supplier:supplier,dept:dept},
        dataType: 'json'
        }).done(function(data) 
        {
            console.log(data);
            if (data.status) 
            {
               
                swal("Success!","Proceed to Purchase Order successfully!","success");
                 location.reload();
            } 
            else 
            {
                swal("Fail!","Failed to proceed to PO.","error");
            }
        });
    },
    
    update_prmaster : function(prnumber,dept,prdate,supplier)
    {
        $.ajax({
        type: 'POST',
        url:  BASE_URL + "user/update_prmaster",
        data: {prnumber:prnumber,dept:dept,prdate:prdate,supplier:supplier},
        dataType: 'json'
        }).done(function(data) 
        {
            console.log(data);
            if (data.status) 
            {
                swal("Success!","Proceed to Purchase Order successfully!","success");
                location.reload();
            } 
            else 
            {
                swal("Fail!","Failed to proceed to PO.","error");
            }
        });
    },
    
    show_ledger : function()
    {
        var barcode = $('#search-frequency-form input[name=barcode]').val();
        var dept = $('#search-frequency-form input[name=dept]').val();
        var transtype = $('#search-frequency-form input[name=trans]').val();
        var monthdate = $('#search-frequency-form input[name=monthdate]').val();

        $('#ledger-table').dataTable().fnDestroy();
        $('#ledger-table tbody').empty();
        var table = $('#ledger-table').dataTable({
            dom: 'frtip',
            pageLength: 30,
             oLanguage: {
                sProcessing: 
                        swal({
                        title: "Fetching data...",
                        text: "Please wait!",
                        imageUrl:  BASE_URL +"assets/img/loading2.gif",
                        showCancelButton: false,
                        showConfirmButton: false
                      })
                }, 
            serverSide:true, 
            order:[],    
            ajax:{  
                url:BASE_URL + "user/fetch_ledger1",
                type:"POST",
                dataType: 'json',
                data: {bcode:barcode,dept:dept,transtype:transtype,monthdate:monthdate}
            },
            initComplete : function(settings, json){
                swal.close();
                
                for(i=1;i<7;i++)
                {
                   
                     $("#month"+i).text(moment(json["total"]["frequency"][i-1]["datex"]).format('MMMM YYYY'));
                      if(json['total']['frequency'][i-1]['qty'] === null)
                    {
                      $("#qty"+i).text('0.00');
                    }
                    else
                    {
                        $("#qty"+i).text(parseInt(json['total']['frequency'][i-1]['qty']));
                    }

                }
            }
        });
        
        $('#ledger-table_filter input').unbind();
        $('#ledger-table_filter input').bind('keyup', function(e) {
            if(e.keyCode == 13) {
                table.fnFilter(this.value);	
            }
        });
    },
    
    
    monthpick : function()
    {
        var s_date = $('#search-frequency-form input[name = monthdate]');
        var error = 0;
        
        if (s_date.val() == "") {
            s_date.parents('.form-line').removeClass('error success').addClass('error');
            s_date.parents('.input-group').find('small').text('Please select a date!');
            error++;
        }else{
            s_date.parents('.form-line').removeClass('error success').addClass('success');
            s_date.parents('.input-group').find('small').text('');
        }
        
        if (error === 0) {
            purchase1.show_ledger();
        }
    },
    
    transtype : function ()
    {
        if($('#cmbtranstype').val() == "Delivery")
        {
             $('#search-frequency-form input[name=trans]').val("Delivery");
        }
        else
        {
            $('#search-frequency-form input[name=trans]').val("All");
        }
        purchase1.show_ledger();
    },
    
    get_selected_app : function()
    {
        if ($('#stock-table').DataTable().rows({selected:  true}).data().length == 0) {
            swal({
                title: "Oops!",
                text: "Please select purchase/s for approval.",
                type: "warning"
            });
        }else{
            var ctrl = [];
            var data = $('#stock-table').DataTable().rows({selected:  true}).data();
            for (var i = 0; i <data.length; i++) {
                ctrl.push(data[i][18]);
            
            }
        
//        alert(ctrl);
            
            swal({
            title: "Approve Purchase?",
            text: "You cannot undo this action!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#4CAF50",
            confirmButtonText: "Yes, approve it!",
            cancelButtonText: "No",
            closeOnConfirm: false
            }, function () {
                purchase1.approve_p(ctrl);
            });
        }
    },
    
    approve_p : function(data){
        var prnumber = $('#prnumber').val();
        $('#stock-table').dataTable().fnDestroy();
        $('#stock-table tbody').empty();
        var table = $('#stock-table').dataTable({
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
                    targets : [12,13,14,15,16,17,18,19,20,21],
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
                url:BASE_URL + "user/app_purchase_all",
                data: {controls : data,pocode:prnumber},
                type:"POST"
            },
            createdRow : function( row, datax, dataIndex){
                   if( datax[19] ===  "1")
                    {
                        $(row).css('background-color','#D5F5E3');
                    }
                    
                    if( datax[20] ===  "1")
                    {
                        $(row).css('background-color','#F5B7B1');
                    }
                    
                    if( datax[21] ===  "1")
                    {
                        $(row).css('background-color','#F5CBA7  '); 
                    }
            },
            initComplete: function(settings, json) {
                $('[data-toggle="popover"]').click(function(){
                    $('[data-toggle="popover"]').not(this).popover('hide'); //all but this
                });
                swal("Success","Purchase approved!","success");
            }
            
        });
        $('#stock-table_filter input').unbind();
        $('#stock-table_filter input').bind('keyup', function(e) {
            if(e.keyCode == 13) {
                table.fnFilter(this.value);	
            }
        });
    },
    
    get_selected_dis : function(){
        if ($('#stock-table').DataTable().rows({selected:  true}).data().length == 0) {
            swal({
                title: "Oops!",
                text: "Please select purchase/s for disapproval.",
                type: "warning"
            });
        }else{
            $('#disapprove_all').removeClass('hidden');
            $('#purchase-stock').addClass('hidden');
            $("#disPurchase").modal("show");
        }
    },
    
    disapprove_p : function(){
        var ctrl = [];
        var data = $('#stock-table').DataTable().rows({selected:  true}).data();
        for (var i = 0; i <data.length; i++) {
            ctrl.push(data[i][18]);
        }
        
        var prnumber = $('#prnumber').val();
        swal({
            title: "Disapprove Purchase?",
            text: "You cannot undo this action!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#F44336",
            confirmButtonText: "Yes, disapprove it!",
            cancelButtonText: "No",
            closeOnConfirm: false
        }, function () {
            $('#stock-table').dataTable().fnDestroy();
            $('#stock-table tbody').empty();
            var table = $('#stock-table').dataTable({
                dom: 'frtip',
                responsive: {
                details: {
                        type: 'column',
                        target: -1
                    }
                },
                pageLength: 30,
                columnDefs: [ 
                    {
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
                        targets : [12,13,14,15,16,17,18,19,20,21],
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
                    url:BASE_URL + "user/dis_purchase_all",
                    type:"POST",
                    data: {controls : ctrl, b: $("#dis-purchase-form textarea[name=note]").val(), pocode:prnumber}
                },
                createdRow : function( row, datax, dataIndex){
                   if( datax[19] ===  "1")
                    {
                        $(row).css('background-color','#D5F5E3');
                    }
                    
                    if( datax[20] ===  "1")
                    {
                        $(row).css('background-color','#F5B7B1');
                    }
                    
                    if( datax[21] ===  "1")
                    {
                        $(row).css('background-color','#F5CBA7  '); 
                    }
            },
                initComplete: function(settings, json) {
                    $('[data-toggle="popover"]').click(function(){
                        $('[data-toggle="popover"]').not(this).popover('hide'); //all but this
                    });
                    $('#note').val('');
                    $("#disPurchase").modal("hide");
                    
                    swal("Sucess","Purchase disapproved!","success");
                }

            });
            $('#stock-table_filter input').unbind();
            $('#stock-table_filter input').bind('keyup', function(e) {
                if(e.keyCode == 13) {
                table.fnFilter(this.value);	
                }
            });
        });
    },
    
    get_selected_def : function(){
        if ($('#stock-table').DataTable().rows({selected:  true}).data().length == 0) {
            swal({
                title: "Oops!",
                text: "Please select purchase/s for defferal.",
                type: "warning"
            });
        }else{
            $('#defer_all').removeClass('hidden');
            $('#def-supplier').addClass('hidden');
            $("#defPurchase").modal("show");
        }
    },
    
    deffer : function(){
        var ctrl = [];
        var data = $('#stock-table').DataTable().rows({selected:  true}).data();
        for (var i = 0; i <data.length; i++) {
            ctrl.push(data[i][18]);
        }
        
        var prnumber = $('#prnumber').val();
        swal({
            title: "Deffer Purchase?",
            text: "You cannot undo this action!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#F44336",
            confirmButtonText: "Yes, deffer it!",
            cancelButtonText: "No",
            closeOnConfirm: false
        }, function () {
            $('#stock-table').dataTable().fnDestroy();
            $('#stock-table tbody').empty();
            var table = $('#stock-table').dataTable({
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
                       targets : [12,13,14,15,16,17,18,19,20,21],
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
                    url:BASE_URL + "user/def_purchase_all",
                    type:"POST",
                    data: {controls : ctrl, b: $("#def-purchase-form textarea[name=noted]").val(),pocode:prnumber}
                },
                createdRow : function( row, datax, dataIndex){
                   if( datax[19] ===  "1")
                    {
                        $(row).css('background-color','#D5F5E3');
                    }
                    
                    if( datax[20] ===  "1")
                    {
                        $(row).css('background-color','#F5B7B1');
                    }
                    
                    if( datax[21] ===  "1")
                    {
                        $(row).css('background-color','#F5CBA7  '); 
                    }
            },
                initComplete: function(settings, json) {
                    $('[data-toggle="popover"]').click(function(){
                        $('[data-toggle="popover"]').not(this).popover('hide'); //all but this
                    });
                    $('#noted').val('');
                    $("#defPurchase").modal("hide");
                    swal("Sucess","Purchase deffered!","success");
                }

            });
            $('#stock-table_filter input').unbind();
            $('#stock-table_filter input').bind('keyup', function(e) {
                if(e.keyCode == 13) {
                table.fnFilter(this.value);	
                }
            });
        });
    },
    
    
    
}

$('#stock-supplier-table').on('click', 'td', function () 
{
    var current_row = $(this).parents('tr');//Get the current row
    if (current_row.hasClass('child')) {//Check if the current row is a child row
        current_row = current_row.prev();//If it is, then point to the row before it (its 'parent')
    }
    var data = $('#stock-supplier-table').dataTable().fnGetData(current_row); 
 
    if(data == null)
    {
        swal("Error","No record found!","error");
    }
    else
    {
        
        show_forapproval(data);
    }
    
});

function show_forapproval(data)
{
    $('#stocks').removeClass('hidden');
    $('#supname').val(data[1]);
    $('#prdate').val(moment(data[3]).format('MMMM DD, YYYY'));
    $('#prnumber').val(data[0]);
    if(data[10] == "LT")
    {
        $('#dept').val('LABORATORY');
    }
    else if(data[10] == "PH")
    {
        $('#dept').val('PHARMACY');
    }
    else if(data[10] == "CS")
    {
        $('#dept').val('CSR');
    }
    else if(data[10] == "RT")
    {
        $('#dept').val('RADIOLOGY');
    }
    else if(data[10] == "US")
    {
        $('#dept').val('ULTRASOUND');
    }
    else
    {
        $('#dept').val('DIALYSIS');
    }
    
    $('#stockHeader').val(accounting.formatMoney(trim_money(data[2])));
    

    $('#stock-table').dataTable().fnDestroy();
        $('#stock-table tbody').empty();
        var table = $('#stock-table').dataTable({
            dom: 'frtip',
//            responsive: {
//            details: {
//                    type: 'column',
//                    target: -1
//                }
//            },
            pageLength: 10,
            columnDefs: [ 
                {
                    targets : [12,13,14,15,16,17,18,19,20,21],
                    visible : false
                },
                
                {
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
                
            ],
            select: {
                style:    'multi',
                selector: 'td:first-child'
            },
            processing:true,  
            serverSide:true, 
            order:[],
            scrollX:true,
            ajax:{  
                url:BASE_URL + "user/fetch_purchase_stocks",
                type:"POST",
                 data: { 
                    pocode : data[0]
                }
            },
            
            createdRow : function( row, datax, dataIndex){
                   if( datax[19] ===  "1")
                    {
                        $(row).css('background-color','#D5F5E3');
                    }
                    
                    if( datax[20] ===  "1")
                    {
                        $(row).css('background-color','#F5B7B1');
                    }
                    
                    if( datax[21] ===  "1")
                    {
                        $(row).css('background-color','#F5CBA7  '); 
                    }
                    
                    if(datax[21] !== "")
                    {
                        $('#proceed_to_po').removeClass('hidden');
                    }
                    
                    if(datax[21] === "")
                    {
                       
                    }
                 
            },
            
            initComplete : function(settings,json)
            {
          
               if(json['count'] == 0)
               {
                    $('#proceed_to_po').addClass('hidden');
                     swal("Error","No record found!","error");
               }
               else
               {
                   $('#proceed_to_po').removeClass('hidden');
               }
               
            }
            
        });
        $('#stock-table_filter input').unbind();
        $('#stock-table_filter input').bind('keyup', function(e) {
            if(e.keyCode == 13) {
            table.fnFilter(this.value);	
            }
        });
    }

$("#check-all").on("change",function(){
    var table = $('#stock-supplier-table').DataTable();
    if($(this)[0].checked) {
        table.rows('#stock-supplier-table tbody tr').select();
        
    }else{
        table.rows('#stock-supplier-table tbody tr').deselect();
    }
    
    //--------------------------------------------------------sum price
    var data = table.rows({selected:  true}).data();
    var totalPrice = 0.0; 
    for (var i = 0; i < data.length; i++) {
        totalPrice += parseFloat(trim_money(data[i][2]));
    }
    
    var table = $('#stock-table').DataTable();
    table.rows('#stock-table tbody tr').deselect();
    $("#purHeader").html('(₱ '+accounting.format(totalPrice,2)+')');
});



$('#stock-supplier-table').on('click', '.select-checkbox', function () {
    var current_row = $(this).parents('tr');//Get the current row
    if (current_row.hasClass('child')) {//Check if the current row is a child row
        current_row = current_row.prev();//If it is, then point to the row before it (its 'parent')
    }
    
    var cur_row = $('#stock-supplier-table').dataTable().fnGetData(current_row);
    var totalPrice = 0.0;
    
    var data = $('#stock-supplier-table').DataTable().rows({selected:  true}).data();
    
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
        $('#check-all-stocks').removeAttr('checked');
        $("#purHeader").html('(₱ '+accounting.format(totalPrice,2)+')');
    }
});

$('#stock-supplier-table').on( 'draw.dt', function () {
    $("#purHeader").html('(₱ 0.00)');
    $('#check-all').removeAttr('checked');
} );

$("#check-all-stocks").on("change",function(){
    var table = $('#stock-table').DataTable();
    if($(this)[0].checked) {
        table.rows('#stock-table tbody tr').select();
        
    }else{
        table.rows('#stock-table tbody tr').deselect();
    }
    
    //--------------------------------------------------------sum price
    var data = table.rows({selected:  true}).data();
    var totalPrice = 0.0; 
    for (var i = 0; i < data.length; i++) {
        totalPrice += parseFloat(data[i][5]);
    }
   var table = $('#stock-supplier-table').DataTable();
    table.rows('#stock-supplier-table tbody tr').deselect();
    $('#check-all').removeAttr('checked');
    $("#stockHeader").html('(₱ '+accounting.format(totalPrice,2)+')');
});

function trim_money(data){
    var res = data.split(";");
    return res[1].replace(/,/g,'').trim();
}

$('#stock-table').on('click', '.select-checkbox', function () {
    var current_row = $(this).parents('tr');//Get the current row
    if (current_row.hasClass('child')) {//Check if the current row is a child row
        current_row = current_row.prev();//If it is, then point to the row before it (its 'parent')
    }
    
    var cur_row = $('#stock-table').dataTable().fnGetData(current_row);
    var totalPrice = 0.0;
    
    var data = $('#stock-table').DataTable().rows({selected:  true}).data();
    
    if (cur_row != null) {
        $('#check-all-stocks').removeAttr('checked');
        if (data.length > 0) {
            for (var i = 0; i < data.length; i++) {
                totalPrice += parseFloat(data[i][5]);
            }
            if (current_row.hasClass('selected')) {
                totalPrice -= parseFloat(cur_row[5]);
            }else{
                totalPrice += parseFloat(cur_row[5]);
            }
        }else{
            totalPrice += parseFloat(cur_row[5]);
        }
        $("#stockHeader").html('(₱ '+accounting.format(totalPrice,2)+')');
    }
});

$('#stock-table').on( 'draw.dt', function () {
    $("#stockHeader").html('(₱ 0.00)');
    $('#check-all-stocks').removeAttr('checked');
} );

$('#stock-table').on('click', '.ledger-btn', function () 
{
    var barcode = $(this).attr("id");
    var bar = barcode.split(':');
    $('#search-frequency-form input[name=barcode]').val(bar[0]);
    $('#search-frequency-form input[name=dept]').val(bar[1]);
    $('#ledgerSale').modal('show');
    $('#search-frequency-form input[name=trans]').val("Delivery");
    purchase1.show_ledger();
//    purchase1.show_ledger($(this).attr("id"));
    
});
