//var c = $('#surg-table').dataTable({
//    dom : 't',
//    order: [[ 0, "asc" ]]
//});

//$('#surg-table input').unbind();
//$('#surg-table input').bind('keyup', function(e) {
//    if(e.keyCode == 13) {
//        c.fnFilter(this.value);	
//    }
//});


var surgical = {
    get_r_surgical : function(){
        
        $('#surgical-proc-table').dataTable().fnDestroy();
        $('#surgical-proc-table tbody').empty();
        var table = $('#surgical-proc-table').dataTable({
            dom: 'frtip',
            responsive: true,
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
                    targets : [7],
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
                url:BASE_URL + "user/fetch_un_surgical",
                type:"POST"
            }
//            initComplete : function(){
//                $('[data-toggle="popover"]').click(function(){
//                    $('[data-toggle="popover"]').not(this).popover('hide'); //all but this
//                });
//            }
            
        });
        $('#purchases-table_filter input').unbind();
        $('#purchases-table_filter input').bind('keyup', function(e) {
            if(e.keyCode == 13) {
            table.fnFilter(this.value);	
            }
        });
    },
    
    search_surgicals : function(){
        var yearnow = (new Date()).getFullYear();
        var monthnow = (new Date()).getMonth();

        var getmonth = (new Date(s_date.val())).getMonth();
        var getyear = (new Date(s_date.val())).getFullYear();

        if(monthnow+yearnow === getmonth+getyear)
        {
             $('#btnEdit').removeClass('hidden');
            //alert("Equal");
        }
        else
        {
             $('#btnEdit').addClass('hidden');
            //alert("Not Equal");
        }

        
        $('#surg-table').dataTable().fnDestroy();
        $('#surg-table tbody').empty();
        var table = $('#surg-table').dataTable({
            dom: 'frtip',
            responsive: true,
//            responsive: {
//            details: {
//                    type: 'column',
//                    target: -1
//                }
//            },
            pageLength: 30,
//            columnDefs: [ {
//                className: 'control',
//                orderable: false,
//                targets:   -1,
//                width: "3%"
//            },
//                {
//                    orderable: false,
//                    className: 'select-checkbox',
//                    targets:   0,
//                    width: "3%"
//                },
//                {
//                    targets : [7],
//                    visible : false
//                }
//            ],
//            select: {
//                style:    'multi',
//                selector: 'td:first-child'
//            },
            processing:true,  
            serverSide:true, 
            order:[],
            ajax:{  
                url:BASE_URL + "user/fetch_surgical",
                type:"POST",
                data :{datex : $("#search-surgical-form input[name=start_date]").val()}
            }
//            initComplete : function(){
//                $('[data-toggle="popover"]').click(function(){
//                    $('[data-toggle="popover"]').not(this).popover('hide'); //all but this
//                });
//            }
            
        });
        $('#purchases-table_filter input').unbind();
        $('#purchases-table_filter input').bind('keyup', function(e) {
            if(e.keyCode == 13) {
            table.fnFilter(this.value);	
            }
        });
    },
    
    get_surgicals : function(){
        $('#surg-table').dataTable().fnDestroy();
        $('#surg-table tbody').empty();
        var table = $('#surg-table').dataTable({
            dom: 'frtip',
            responsive: true,
//            responsive: {
//            details: {
//                    type: 'column',
//                    target: -1
//                }
//            },
            pageLength: 30,
//            columnDefs: [ {
//                className: 'control',
//                orderable: false,
//                targets:   -1,
//                width: "3%"
//            },
//                {
//                    orderable: false,
//                    className: 'select-checkbox',
//                    targets:   0,
//                    width: "3%"
//                },
//                {
//                    targets : [7],
//                    visible : false
//                }
//            ],
//            select: {
//                style:    'multi',
//                selector: 'td:first-child'
//            },
            processing:true,  
            serverSide:true, 
            order:[],
            ajax:{  
                url:BASE_URL + "user/fetch_surgical",
                type:"POST",
                data :{datex : $("#search-surgical-form input[name=start_date]").val()}
            }
//            initComplete : function(){
//                $('[data-toggle="popover"]').click(function(){
//                    $('[data-toggle="popover"]').not(this).popover('hide'); //all but this
//                });
//            }
            
        });
        $('#purchases-table_filter input').unbind();
        $('#purchases-table_filter input').bind('keyup', function(e) {
            if(e.keyCode == 13) {
            table.fnFilter(this.value);	
            }
        });
  },


  //alingling

       search_surgical_output : function(){
        var s_date = $('#search-surgical-form input[name = start_date]');
        var error = 0;

        if (s_date.val() == "") {
            s_date.parents('.form-line').removeClass('error success').addClass('error');
            s_date.parents('.input-group').find('small').text('Please select a month!');
            error++;
        }else{
            s_date.parents('.form-line').removeClass('error success').addClass('success');
            s_date.parents('.input-group').find('small').text('');
        }
        
      
        
//        if (error === 0) {
//
//            var yearnow = (new Date()).getFullYear();
//            var monthnow = (new Date()).getMonth();
//
//            var getmonth = (new Date(s_date.val())).getMonth();
//            var getyear = (new Date(s_date.val())).getFullYear();
//
//            if(monthnow+yearnow === getmonth+getyear)
//            {
//                 $('#btnEdit').removeClass('hidden');
//                //alert("Equal");
//            }
//            else
//            {
//                 $('#btnEdit').addClass('hidden');
//                //alert("Not Equal");
//            }
//
//           
//       }
        surgical.get_final_surgical_output();
    },

    get_surgical_output_merge : function(){
        $('#surgical-proc-table').dataTable().fnDestroy();
        $('#surgical-proc-table tbody').empty();
        var table = $('#surgical-proc-table').dataTable({
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
                targets: -1,
                data: null,
                defaultContent: "<button type='button' class='btn btn-success' onclick='user.under_development()'>Unmerge</button>",
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
            
            
            ajax:{  
                url:BASE_URL + "user/fetch_surgical_merge",
                type:"POST"
            },
           
            
        });
    
        $('#surgical-proc-table_filter input').unbind();
        $('#surgical-proc-table_filter input').bind('keyup', function(e) {
            if(e.keyCode === 13) {
            table.fnFilter(this.value); 
            }
        });

  },

    mergesurgical : function(){
   
   if ($('#surgical-proc-table').DataTable().rows({selected:  true}).data().length == 0) {
            swal({
                title: "Oops!",
                text: "Please select a diagnosis.",
                type: "warning"
            });
        }else{
            var ctrl = [];
            var data = $('#surgical-proc-table').DataTable().rows({selected:  true}).data();
            for (var i = 0; i <data.length; i++) {
                ctrl.push(data[i][2]);
            }
            swal({
            title: "Merge Surgical Output?",
            text: "You cannot undo this action!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#4CAF50",
            confirmButtonText: "Yes, merge it!",
            cancelButtonText: "No",
            closeOnConfirm: false
            }, function () {
                surgical.add_groupname(ctrl);
            });
        }
 
    },

     add_groupname : function(data){

   
        $('#surgical-proc-table').dataTable().fnDestroy();
        $('#surgical-proc-table tbody').empty();
        var table = $('#surgical-proc-table').dataTable({
            dom: 'frtip',
             scrollX:true,
            pageLength: 30,
            columnDefs: [ 
                {
                   targets: -1,
            data: null,
            defaultContent: "<button type='button' class='btn btn-success' onclick='user.under_development()'>Unmerge</button>",
                width: "3%"
                },
                {
                    orderable: false,
                    className: 'select-checkbox',
                    targets:   0,
                    width: "3%"
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
                url:BASE_URL + "user/merge_surgical_output",
                data: {
                    controls : data,
                    surgicalname : $('#merge-surgical-form input[name=surgicalname]').val(), 
                    surgicalnhip : $('#merge-surgical-form input[name=surgicalnhip]').val(),
                    surgicalnon : $('#merge-surgical-form input[name=surgicalnon]').val(),
                    total : $('#merge-surgical-form input[name=total]').val()
                },
                type:"POST"
            },
            initComplete: function(settings, json) {
              
                swal("Success","Merged successfully!","success");
         
            }
            
        });
         
        $('#surgical-proc-table_filter input').unbind();
        $('#surgical-proc-table_filter input').bind('keyup', function(e) {
            if(e.keyCode == 13) {
                table.fnFilter(this.value); 
            }
        });
        
       
    },

    get_final_surgical_output : function(){
        start_date = $('#search-surgical-form input[name=start_date]').val(); 
        $('#surg-table').dataTable().fnDestroy();
        $('#surg-table tbody').empty();
        var table = $('#surg-table').dataTable({
            dom: 'frt',
            pageLength: 10,
            processing:true,  
            serverSide:true, 
            ordering:false,
            ajax:{  
                url:BASE_URL + "user/fetch_final_surgical_output",
                type:"POST",
                data: {s_date: start_date},
            },
        });
    
        $('#surg-table_filter input').unbind();
        $('#surg-table_filter input').bind('keyup', function(e) {
            if(e.keyCode === 13) {
            table.fnFilter(this.value); 
            }
        });
    },
};


$("#check-all").on("change",function(){
    var table = $('#surgical-proc-table').DataTable();
    if($(this)[0].checked) {
        table.rows('#surgical-proc-table tbody tr').select();
        
    }else{
        table.rows('#surgical-proc-table tbody tr').deselect();
    }
    
    //--------------------------------------------------------sum price
    var data = table.rows({selected:  true}).data();
    var totalnhip = 0.0; 
    var totalnon = 0.0
    var totalpat = 0;
    for (var i = 0; i < data.length; i++) {
        totalnhip += parseInt(data[i][3]);
        totalnon += parseInt(data[i][4]);
        totalpat = totalnhip + totalnon;
    }
   
    $('#nhip').val(totalnhip);
    $('#non').val(totalnon);
     $('#totalpat').val(totalpat);
   // $("#jobAmt").html('(₱ '+accounting.format(totalPrice,2)+')');
});

$('#surgical-proc-table').on('click', '.select-checkbox', function () {
    var current_row = $(this).parents('tr');//Get the current row
    if (current_row.hasClass('child')) {//Check if the current row is a child row
        current_row = current_row.prev();//If it is, then point to the row before it (its 'parent')
    }
//  
    var cur_row = $('#surgical-proc-table').dataTable().fnGetData(current_row);
    var totalnhip = 0;
    var totalnon = 0;
    var totalpat = 0;
    
    var data = $('#surgical-proc-table').DataTable().rows({selected:  true}).data();
    
    if (cur_row !== null) {

        $('#check-all').removeAttr('checked');
        if (data.length > 0) {
            for (var i = 0; i < data.length; i++) {
                totalnhip += parseInt(data[i][3]);
                totalnon += parseInt(data[i][4]);
                totalpat = totalnhip + totalnon;
            }
            if (current_row.hasClass('selected')) {
                totalnhip -= parseInt(cur_row[3]);
                totalnon  -= parseInt(cur_row[4]);
                totalpat = totalnhip + totalnon;
            }else{
                totalnhip += parseInt(cur_row[3]);
                totalnon  += parseInt(cur_row[4]);
                totalpat = totalnhip + totalnon;
            }
        }else{
        totalnhip += parseInt(cur_row[3]);
        totalnon  += parseInt(cur_row[4]);
        totalpat = totalnhip + totalnon;
   
        }
        
        $('#nhip').val(totalnhip);
        $('#non').val(totalnon);
        $('#totalpat').val(totalpat);
       
    }
});

