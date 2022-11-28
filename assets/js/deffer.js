$('body').popover({
    selector: '[data-toggle="popover"]'
});


var process = {
  get_onprocess : function(){
        $('#process-table').dataTable().fnDestroy();
        $('#process-table tbody').empty();
        var table = $('#process-table').dataTable({
            dom: 'frtip',
            responsive: true,
            processing:true,  
            serverSide:true, 
            order:[],
            ajax:{  
                url:BASE_URL + "user/fetch_purchases/deffer",
                type:"POST"
            },
            initComplete : function(){
                $('[data-toggle="popover"]').click(function(){
                    $('[data-toggle="popover"]').not(this).popover('hide'); //all but this
                });
            }
            
        });
        $('#process-table_filter input').unbind();
        $('#process-table_filter input').bind('keyup', function(e) {
            if(e.keyCode == 13) {
                table.fnFilter(this.value);	
            }
        });
    },  
};

var deferred = {
  get_deferred : function(){
        $('#deferred-table').dataTable().fnDestroy();
        $('#deferred-table tbody').empty();
        var table = $('#deferred-table').dataTable({
            dom: 'frtip',
            responsive: true,
            processing:true,  
            serverSide:true, 
            order:[],
            ajax:{  
                url:BASE_URL + "user/fetch_purchases/deffer",
                type:"POST"
            },
            initComplete : function(){
                $('[data-toggle="popover"]').click(function(){
                    $('[data-toggle="popover"]').not(this).popover('hide'); //all but this
                });
            }
            
        });
        $('#deferred-table_filter input').unbind();
        $('#deferred-table_filter input').bind('keyup', function(e) {
            if(e.keyCode == 13) {
                table.fnFilter(this.value);	
            }
        });
    },  
};

var approve = {
  get_approve : function(){
      
       $('#approved-table').dataTable().fnDestroy();
        $('#approved-table tbody').empty();
        var table = $('#approved-table').dataTable({
            dom: 'frtip',
            responsive: true,
            processing:true,  
            serverSide:true, 
            order:[],
            ajax:{  
                url:BASE_URL + "user/fetch_purchases/approve",
                type:"POST"
            },
            initComplete : function(){
                $('[data-toggle="popover"]').click(function(){
                    $('[data-toggle="popover"]').not(this).popover('hide'); //all but this
                });
            }
            
        });
        $('#approved-table_filter input').unbind();
        $('#approved-table_filter input').bind('keyup', function(e) {
            if(e.keyCode == 13) {
                table.fnFilter(this.value);	
            }
        });

   
        },
};

var disapprove = {
  get_disapprove : function(){
      
       $('#disapproved-table').dataTable().fnDestroy();
        $('#disapproved-table tbody').empty();
        var table = $('#disapproved-table').dataTable({
            dom: 'frtip',
            responsive: true,
            processing:true,  
            serverSide:true, 
            order:[],
            ajax:{  
                url:BASE_URL + "user/fetch_purchases/disaprove",
                type:"POST"
            },
            initComplete : function(){
                $('[data-toggle="popover"]').click(function(){
                    $('[data-toggle="popover"]').not(this).popover('hide'); //all but this
                });
            }
            
        });
        $('#disapproved-table_filter input').unbind();
        $('#disapproved-table_filter input').bind('keyup', function(e) {
            if(e.keyCode == 13) {
                table.fnFilter(this.value);	
            }
        });

   
        },
};