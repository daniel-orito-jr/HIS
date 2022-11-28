
$('.date').datetimepicker({
        format: 'YYYY-MM'
});

////
var hmopayment = {
    

    search_hmo_list : function(){
        var s_date = $('#search-hmolist-form input[name = start_date]');
        var error = 0;

        if (s_date.val() == "") {
            s_date.parents('.form-line').removeClass('error success').addClass('error');
            s_date.parents('.input-group').find('small').text('Please select a month!');
            error++;
        }else{
            s_date.parents('.form-line').removeClass('error success').addClass('success');
            s_date.parents('.input-group').find('small').text('');
        }
        
      
        
        if (error === 0) {
            hmolist.get_hmolist();
       }
    },

    get_hmopatient: function ()
    {
        start_date = $('#search-hmolist-form input[name=start_date]').val(); 
        $("#search-hmolist-form input[name=s_date]").val(start_date);

         $('#hmo-payment-table').dataTable().fnDestroy();
        $('#hmo-payment-table tbody').empty();
        var table = $('#hmo-payment-table').dataTable({
            dom: 'frtip',
            processing:true,  
            serverSide:true, 
            order:[],
            columnDefs: [
                    {
                        targets:[0],
                        visible:false
                    }
                    ],
            
            
            ajax:{  
                url:BASE_URL + "user/get_hmopatient",
                type:"POST",
                data: {start_date: $("#search-hmolist-form input[name=s_date]").val()}
            },
           
            
        });
    
        $('#hmo-payment-table_filter input').unbind();
        $('#hmo-payment-table_filter input').bind('keyup', function(e) {
            if(e.keyCode === 13) {
            table.fnFilter(this.value);	
            }
        });
    },
  



}    
  
    $('#hmo-list-table').on('click', 'td', function () {
    
      
          var current_row = $(this).parents('tr');//Get the current row
    if (current_row.hasClass('child')) {//Check if the current row is a child row
        current_row = current_row.prev();//If it is, then point to the row before it (its 'parent')
    }
    var data = $('#hmo-list-table').dataTable().fnGetData(current_row);
   var start_date = $('#search-hmolist-form input[name=start_date]').val(); 
    show_hmo_list(data,start_date);
    $("#hmolist_patients").modal("show");
      
 
});

function show_hmo_list(data,start_date)
{
    $('#hmoname').html(data[1]);
    $('#s_date').val(start_date);
//     alert(data[0]);
//   alert(start_date);
  
     $('#hmolist-patients-table').dataTable().fnDestroy();
        var table = $('#hmolist-patients-table').dataTable({
            dom: 'frtip',
            responsive: true,
            processing:true,  
            serverSide:true, 
            order:[],  
            ajax:{  
                url:BASE_URL + "user/get_hmolist_patients",
                type:"POST",
                data: { 
                    hmocode: data[0],
                    s_date: start_date
                }
            }
        });
        $('#hmolist-patients-table_filter input').unbind();
        $('#hmolist-patients-table_filter input').bind('keyup', function(e) {
            if(e.keyCode === 13) {
            table.fnFilter(this.value);	
            }
        });
}