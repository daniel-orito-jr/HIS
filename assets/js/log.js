$('#log-table').dataTable().fnDestroy();

var table = $('#log-table').dataTable({
    dom: 'ftp',
    responsive: true,
    processing:true,  
    serverSide:true, 
    pageLength: 20,
    order:[],  
    ajax:{  
        url:BASE_URL + "user/fetch_log",
        type:"POST"
    }
});
    
    
$('#px-classification-table_filter input').unbind();
$('#px-classification-table_filter input').bind('keyup', function(e) {
    if(e.keyCode == 13) {
    table.fnFilter(this.value);	
}
});