
$('.datex').datetimepicker({
        format: 'YYYY'
});

var doh_discharges = {

search_discharges : function(){
        var s_date = $('#search-discharges-form input[name = start_date]');
        var error = 0;

        if (s_date.val() == "") {
            s_date.parents('.form-line').removeClass('error success').addClass('error');
            s_date.parents('.input-group').find('small').text('Please select a month!');
            error++;
        }else{
            s_date.parents('.form-line').removeClass('error success').addClass('success');
            s_date.parents('.input-group').find('small').text('');
        }
        if(error === 0)
        {
          window.location.href =  BASE_URL + "user/operation_discharges/"+s_date.val();  
        }

           
       },
       
fetch_cause_morbidity: function ()
    {
        var start_datex = $('#search-discharges-form input[name=start_date]').val(); 
        
        $('#cause-morbidity-table').dataTable().fnDestroy();
        $('#cause-morbidity-table tbody').empty();
        var table = $('#cause-morbidity-table').dataTable({
            dom: 'frtip',
            processing:true,  
            serverSide:true, 
            order:[],
            ajax:{  
                url:BASE_URL + "user/fetch_cause_morbidity",
                type:"POST",
                data: {start_date: start_datex}
            },
           
            
        });
    
        $('#cause-morbidity-table_filter input').unbind();
        $('#cause-morbidity-table_filter input').bind('keyup', function(e) {
            if(e.keyCode === 13) {
            table.fnFilter(this.value);	
            }
        });
    },
    
    fetch_cause_morbidity_leading: function ()
    {
        var start_datex = $('#search-discharges-form input[name=start_date]').val(); 
        
        $('#cause_10_morbidity_table').dataTable().fnDestroy();
        $('#cause_10_morbidity_table tbody').empty();
        var table = $('#cause_10_morbidity_table').dataTable({
            dom: 'frtip',
            processing:true,  
            serverSide:true, 
            order:[],
            ajax:{  
                url:BASE_URL + "user/fetch_cause_morbidity_leading",
                type:"POST",
                data: {start_date: start_datex}
            },
           
            
        });
    
        $('#cause_10_morbidity_table_filter input').unbind();
        $('#cause_10_morbidity_table_filter input').bind('keyup', function(e) {
            if(e.keyCode === 13) {
            table.fnFilter(this.value);	
            }
        });
    },
    
    show_inpatients_finaldiagnosis : function()
    {
        var txtyear = $('#txtyear').val();
        var txtdiag = $('#txtdiag').val();
        $('#inpatient-finaldiag-table').dataTable().fnDestroy();
        var table = $('#inpatient-finaldiag-table').dataTable({
            dom: 'frtip',
            responsive: true,
            processing:true,  
            serverSide:true, 
            order:[],  
            ajax:{  
                url:BASE_URL + "user/fetch_inpatients_finaldiagnosis",
                type:"POST",
                data: { 
                    finaldiag :txtdiag,year: txtyear
                }
            },
        });
        $('#inpatient-finaldiag-table_filter input').unbind();
        $('#inpatient-finaldiag-table_filter input').bind('keyup', function(e) {
            if(e.keyCode === 13) {
            table.fnFilter(this.value);	
            }
        });
    },
    
    preview_table_ten_morbidity : function()
    {
        var s_date = $('#txtyear').val();
        window.location.href =  BASE_URL + "user/operation_discharges/"+s_date; 
       
    }, 
    
    fetch_icdcode : function()
    {
        $('#phicicdcode').modal('show');
        $('#icd-code-table').dataTable().fnDestroy();
        var table = $('#icd-code-table').dataTable({
            dom: 'frtip',
            responsive: true,
            processing:true,  
            serverSide:true, 
            order:[],  
            ajax:{  
                url:BASE_URL + "user/fetch_icdcode",
                type:"POST"
            },
        });
        $('#icd-code-table_filter input').unbind();
        $('#icd-code-table_filter input').bind('keyup', function(e) {
            if(e.keyCode === 13) {
            table.fnFilter(this.value);	
            }
        });
    },
    
    change_finaldiag: function(caseno)
    {
        $('#inpatient-finaldiag-table').on('click', 'td', function () 
        {
            var current_row = $(this).parents('tr');//Get the current row
            if (current_row.hasClass('child')) {//Check if the current row is a child row
                current_row = current_row.prev();//If it is, then point to the row before it (its 'parent')
            }
            var data = $('#inpatient-finaldiag-table').dataTable().fnGetData(current_row);
            $('#change_finaldiag').modal('show');
            $('#pxname').html(data[4]);
            $('#pxdiag').val(data[1]);
            $('#txticd').val(data[2]);
            $('#txtid').val(caseno);

        });
    },
    
    update_finaldiag: function()
    {
        var idx = $('#txtid').val();
        var icdx = $('#txticd').val();
        var diagx = $('#pxdiag').val();
        
        swal({
            title: "Are you sure?",
            text: "Your will not be able to undo this!",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "Yes, update it!",
            closeOnConfirm: false
        },
        function(){
            $.ajax({
                type: 'POST',
                url:  BASE_URL + "user/update_finaldiagnosis",
                data: {id : idx,icd:icdx,diag:diagx},
                dataType: 'json'
            }).done(function(data1) {
                if (data1.status) 
                {
                    swal("Success","Final Diagnosis updated successfully","success");
                    $('#change_finaldiag').modal('hide');
                    doh_discharges.show_inpatients_finaldiagnosis();
                } 
                else
                {
                    swal("Error","Error in saving. Please try again!","error");
                }
            });
        });
    },
    
    print_operation_discharges_report : function()
    {
        var s_date = $("#search-discharges-form input[name=start_date]").val();
        $("#print-operation-discharges-form input[name=s_datex]").val(s_date);
        $("#print-operation-discharges-form").submit();
    },
}

$('#cause-morbidity-table').on('click', 'td', function () 
{
    var current_row = $(this).parents('tr');//Get the current row
    if (current_row.hasClass('child')) {//Check if the current row is a child row
        current_row = current_row.prev();//If it is, then point to the row before it (its 'parent')
    }
    var data = $('#cause-morbidity-table').dataTable().fnGetData(current_row);
    var s_date = $('#search-discharges-form input[name = start_date]').val();
//    show_inpatients_finaldiagnosis(data,s_date);
//    show_inprocess(data,datexx);
//    $("#phicinprocess_modal").modal("show");
    var fd = data[0];

     location.href= BASE_URL +'user/edit_finaldiagnosis?fd=' + fd +'&dx=' + s_date;
 
});

$('#icd-code-table').on('click', 'td', function () 
{
    var current_row = $(this).parents('tr');//Get the current row
    if (current_row.hasClass('child')) {//Check if the current row is a child row
        current_row = current_row.prev();//If it is, then point to the row before it (its 'parent')
    }
    var data = $('#icd-code-table').dataTable().fnGetData(current_row);
    $('#pxdiag').val(data[1]);
    $('#txticd').val(data[0]);
    $('#phicicdcode').modal('hide');
});




