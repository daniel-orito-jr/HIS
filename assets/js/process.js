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
                url:BASE_URL + "user/fetch_purchases/onprocess",
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