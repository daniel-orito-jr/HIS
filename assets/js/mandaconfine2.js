$('.datex').datetimepicker({
        format: 'YYYY-MM'
});
    output = "";
var confine = {
    
    search_confinement_causes : function(){
        var s_date = $('#search-confinement-causes-form input[name = start_date]');
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

            confine.get_most_common_confine_list();
       }
    },
    
     get_most_common_confine_list : function()
    {
        var s_date = $('#search-confinement-causes-form input[name = start_date]').val();
        $('#common_Confinement-causes-table').dataTable().fnDestroy();
        $('#common_Confinement-causes-table tbody').empty();
        var table = $('#common_Confinement-causes-table').dataTable({
            dom: 'frtip',
            pageLength: 10,
            processing:true,  
            serverSide:true, 
            ordering:false,
            ajax:{  
                url:BASE_URL + "user/fetch_common_confinement_causes",
                type:"POST",
                data:{s_date:s_date}
            },
           
        });
    
        $('#common_Confinement-causes-table_filter input').unbind();
        $('#common_Confinement-causes-table_filter input').bind('keyup', function(e) {
            if(e.keyCode === 13) {
            table.fnFilter(this.value); 
            }
        });
    },
//GAMIT KAROOOON
    editlink: function()
    {
        var s_date = $('#search-confinement-causes-form input[name = start_date]');
        var error = 0;

        if (s_date.val() == "") {
            s_date.parents('.form-line').removeClass('error success').addClass('error');
            s_date.parents('.input-group').find('small').text('Please select a month!');
            error++;
        }else{
            s_date.parents('.form-line').removeClass('error success').addClass('success');
            s_date.parents('.input-group').find('small').text('');
        }
        
        if(error == 0)
        {
           window.location.href =  BASE_URL + "user/confinemerge/"+s_date.val(); 
        }
        
    },
    //GAMIT KAROOOOON
    get_confinement_causes : function(){
        
        $('#Confinement-causes-table').dataTable().fnDestroy();
        $('#Confinement-causes-table tbody').empty();
        var table = $('#Confinement-causes-table').dataTable({
            dom: 'frtip',
            scrollX:true,
            pageLength: 30,
            columnDefs: [ 
            {
                orderable: false,
                className: 'select-checkbox',
                targets:   0,
                width: "3%"
            },
            {
                targets:[6],
                visible:false
            }
        ],
            select: 
            {
                style:    'multi',
                selector: 'td:first-child'
            },
            processing:true,  
            serverSide:true, 
            order:[],
            ajax:{  
                url:BASE_URL + "user/fetch_confinement_causes",
                type:"POST",
                data: {s_date:$('#txtmonth').val()}
            },
            
            initComplete: function(settings, json) {
              
                $('#divadd').removeAttr("hidden");
         
            }
           
        });
    
        $('#Confinement-causes-table_filter input').unbind();
        $('#Confinement-causes-table_filter input').bind('keyup', function(e) {
            if(e.keyCode === 13) {
            table.fnFilter(this.value); 
            }
        });
        
       

    },

    //GAMIT KAROOOON
    mergeconfine : function(){
       
        if ($('#Confinement-causes-table').DataTable().rows({selected:  true}).data().length == 0) {
            swal({
                title: "Oops!",
                text: "Please select a diagnosis.",
                type: "warning"
            });
        }else{
            var ctrl = [];
            var data = $('#Confinement-causes-table').DataTable().rows({selected:  true}).data();
            for (var i = 0; i <data.length; i++) {
                 ctrl.push(data[i][6]);
            }
            $('#diagl').modal('show');
            $('#ctrls').val(ctrl);
        }
    },

    
//GAMIT KAROOOON
    add_groupname : function(ctrl,category)
    {
        $.ajax({
            type: 'POST',
            url:  BASE_URL + "user/merge_confinement",
            data: {controls : ctrl,refno:category[0],cause:category[1]},
            dataType: 'json'
        }).done(function(data1) {
            console.log(data1);
            if (data1.status) 
            {
                confine.get_confinement_causes();
                $("#check-all").removeAttr("checked");
                swal("Success","Successful in saving!","success");
                $('#diagl').modal('hide');
            } 
            else
            {
                swal("Error","Error in saving. Please try again!","error");
            }
        });
    },
    
    preview_table_confinement : function()
    {
         var s_date = $('#txtmonth').val();

           window.location.href =  BASE_URL + "user/mandaconfine/"+s_date; 
    }, 
    
    get_diag_list : function()
    {
        $('#diagnosis-list-table').dataTable().fnDestroy();
        $('#diagnosis-list-table tbody').empty();
        var table = $('#diagnosis-list-table').dataTable({
            dom: 'frtip',
            pageLength: 10,
            processing:true,  
            serverSide:true, 
            order:[],
            ajax:{  
                url:BASE_URL + "user/fetch_diagnosis_list",
                type:"POST",
            },
           
        });
    
        $('#diagnosis-list-table_filter input').unbind();
        $('#diagnosis-list-table_filter input').bind('keyup', function(e) {
            if(e.keyCode === 13) {
            table.fnFilter(this.value); 
            }
        });
    },
    
    removefromqueue : function(id)
    {
        swal({
                title: "Are you sure to remove this confinement cause?",
                text: "You cannot undo this action!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#4CAF50",
                confirmButtonText: "Yes, I am sure!",
                cancelButtonText: "No",
                closeOnConfirm: false
                }, function () {
                $.ajax({
                    type: 'POST',
                    url:  BASE_URL + "user/removediagnosis",
                    data: {id : id},
                    dataType: 'json'
                }).done(function(data1) {
                    console.log(data1);
                    if (data1.status) 
                    {
                        swal("Success","Diagnosis deleted successfully!","success");
                        $('#px-diagnosis-table').DataTable().ajax.reload();
                    } 
                    else
                    {
                        swal("Error","Error in saving. Please try again!","error");
                    }
                });
            });
    },
    
   

}





$("#check-all").on("change",function(){
    var table = $('#Confinement-causes-table').DataTable();
    if($(this)[0].checked) {
        table.rows('#Confinement-causes-table tbody tr').select();
        
    }else{
        table.rows('#Confinement-causes-table tbody tr').deselect();
    }
    
    //--------------------------------------------------------sum price
    var data = table.rows({selected:  true}).data();
});

$('#Confinement-causes-table').on('click', '.select-checkbox', function () {
    var current_row = $(this).parents('tr');//Get the current row
    if (current_row.hasClass('child')) {//Check if the current row is a child row
        current_row = current_row.prev();//If it is, then point to the row before it (its 'parent')
    }
//  
    var cur_row = $('#Confinement-causes-table').dataTable().fnGetData(current_row);
    var data = $('#Confinement-causes-table').DataTable().rows({selected:  true}).data();

});

$('#diagnosis-list-table').on('click', 'td', function () {
    
      
    var current_row = $(this).parents('tr');//Get the current row
    if (current_row.hasClass('child')) {//Check if the current row is a child row
        current_row = current_row.prev();//If it is, then point to the row before it (its 'parent')
    }
    var data = $('#diagnosis-list-table').dataTable().fnGetData(current_row);
    var control = $('#ctrls').val();
    var ctrl = control.split(",");
    var ctrlx = [];
        for (var i = 0; i <ctrl.length; i++) 
        {   ctrlx.push(ctrl[i]);    }
        
        confine.add_groupname(ctrlx,data);
});

$('#Confinement-causes-table').delegate('tr td:nth-child(2)', 'click', function() {
    var current_row = $(this).parents('tr');//Get the current row
    if (current_row.hasClass('child')) {//Check if the current row is a child row
        current_row = current_row.prev();//If it is, then point to the row before it (its 'parent')
    }
    var data = $('#Confinement-causes-table').dataTable().fnGetData(current_row);
    px_diaglist(data);
//    var control = $('#ctrls').val();
//    var ctrl = control.split(",");
//    var ctrlx = [];
//        for (var i = 0; i <ctrl.length; i++) 
//        {   ctrlx.push(ctrl[i]);    }
//        
//        confine.add_groupname(ctrlx,data);
});

function px_diaglist(data)
{
    $('#confinelist').modal('show');
    $('.modal-title').html(data[3]);
    $('#diag').html(data[1]);
    
    
     $('#px-diagnosis-table').dataTable().fnDestroy();
        var table = $('#px-diagnosis-table').dataTable({
            dom: 'frtip',
            processing:true,  
            serverSide:true, 
            order:[],  
            columnDefs: [
            {
                targets:[1],
                visible:false
            }
        ],
            ajax:{  
                url:BASE_URL + "user/fetch_px_diagnosis",
                type:"POST",
                data: { 
                    caseno : data[2],s_date: $('#txtmonth').val()
                }
            }
        });
        $('#px-diagnosis-table_filter input').unbind();
        $('#px-diagnosis-table_filter input').bind('keyup', function(e) {
            if(e.keyCode === 13) {
            table.fnFilter(this.value);	
            }
        });
}










