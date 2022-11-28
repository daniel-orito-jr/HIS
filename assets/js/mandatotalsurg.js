

$('.datex').datetimepicker({
        format: 'YYYY-MM'
});

var totalsurg = {

    //GAMIT KAROOOOOON
    search_total_surgical : function()
    {
        var s_date = $('#search-total-surgical-form input[name = start_date]');
        var error = 0;

        if (s_date.val() === "") {
            s_date.parents('.form-line').removeClass('error success').addClass('error');
            s_date.parents('.input-group').find('small').text('Please select a month!');
            error++;
        }else{
            s_date.parents('.form-line').removeClass('error success').addClass('success');
            s_date.parents('.input-group').find('small').text('');
        }
        
        if(error === 0)
        {
            window.location.href =  BASE_URL + "user/mandatotalsurgical/"+s_date.val(); 
        }
        
    },

    //GAMIT KAROOOOON
    edit_total_surgical : function()
    {
        var s_date = $('#search-total-surgical-form input[name = start_date]');
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
           window.location.href =  BASE_URL + "user/mandatotalsurgicalmerge/"+s_date.val(); 
        }
    },
    
    preview_table : function()
    {
        var s_date = $('#txtmonth').val();

           window.location.href =  BASE_URL + "user/mandatotalsurgical/"+s_date; 
    },
    
    //GAMIT KAROOOON
    get_total_surgical_merge : function(){
        $('#total-surgical-merge-table').dataTable().fnDestroy();
        $('#total-surgical-merge-table tbody').empty();
        var table = $('#total-surgical-merge-table').dataTable({
            dom: 'frtip',
            scrollX:true,
            pageLength: 30,
            columnDefs: [ 
            {
                orderable: false,
                className: 'select-checkbox',
                targets:   0,
                width: "3%"
            }],
            select: 
            {
                style:    'multi',
                selector: 'td:first-child'
            },
            processing:true,  
            serverSide:true, 
            order:[],
            ajax:{  
                url:BASE_URL + "user/fetch_total_surgical_merge",
                type:"POST",
                data: {s_date:$('#txtmonth').val()}
            },
            createdRow : function(row, data, dataIndex)
            {
                if (data[1] === "BILATERAL TUBAL LIGATION")
                {
                    $(row).css('background-color', '#BBFB98');
                }
                else if (data[1] === "VASECTOMY")
                {
                    $(row).css('background-color', '#FE9391');
                }
                else
                {
                    $(row).css('background-color', '#C4FCF6');
                }
            },
        });
    
        $('#total-surgical-merge-table_filter input').unbind();
        $('#total-surgical-merge-table_filter input').bind('keyup', function(e) {
            if(e.keyCode === 13) {
            table.fnFilter(this.value); 
            }
        });

    },
    
    //GAMIT KAROOOON
     merge_bilateral : function(){
   
        if ($('#total-surgical-merge-table').DataTable().rows({selected:  true}).data().length == 0) {
            swal({
                title: "Oops!",
                text: "Please select a diagnosis.",
                type: "warning"
            });
        }else{
            var ctrl = [];
            var data = $('#total-surgical-merge-table').DataTable().rows({selected:  true}).data();
            for (var i = 0; i <data.length; i++) {
                ctrl.push(data[i][3]);
            }
             if (data.length === 1)
            {
                $t = "this is";
            }
            else
            {
                $t = "these are";
            }
        
            alert(ctrl);

            swal({
                title: "Are you sure " + $t + " \n BILATERAL TUBAL LIGATION?",
                text: "You cannot undo this action!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#4CAF50",
                confirmButtonText: "Yes, I am sure!",
                cancelButtonText: "No",
                closeOnConfirm: false
                }, function () {
                totalsurg.add_groupname(ctrl,'BILATERAL TUBAL LIGATION');
            });
        }
 
    },

        //GAMIT KAROOOON
    merge_vasectomy : function(){
        if ($('#total-surgical-merge-table').DataTable().rows({selected:  true}).data().length == 0) {
            swal({
                title: "Oops!",
                text: "Please select a diagnosis.",
                type: "warning"
            });
        }else{
            var ctrl = [];
            var data = $('#total-surgical-merge-table').DataTable().rows({selected:  true}).data();
            for (var i = 0; i <data.length; i++) {
                 ctrl.push(data[i][3]);
            }

            if (data.length === 1)
            {
                $t = "this is";
            }
            else
            {
                $t = "these are";
            }

            swal({title: "Are you sure " + $t + "\n VASECTOMY?",
            text: "You cannot undo this action!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#4CAF50",
            confirmButtonText: "Yes, I am sure!",
            cancelButtonText: "No",
            closeOnConfirm: false
            }, function () {
                totalsurg.add_groupname(ctrl,'VASECTOMY');
            });

        }
 
    },

    //GAMIT KARROOOOOON
    add_groupname : function(ctrl,category)
    {
        $.ajax({
                type: 'POST',
                url:  BASE_URL + "user/merge_total_surgical",
                data: {controls : ctrl,category:category},
                dataType: 'json'
                }).done(function(data1) {
                console.log(data1);
                if (data1.status) 
                {
                    console.log('success');
                    totalsurg.get_total_surgical_merge();
                    swal.close();
                    $("#check-all").removeAttr("checked");
                } 
                else 
                {
                    swal("Error","Error in saving. Please try again!","error");
                }
        });
    },
}

$("#check-all").on("change",function(){
    var table = $('#total-surgical-merge-table').DataTable();
    if($(this)[0].checked) {
        table.rows('#total-surgical-merge-table tbody tr').select();
        
    }else{
        table.rows('#total-surgical-merge-table tbody tr').deselect();
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

$('#total-surgical-merge-table').on('click', '.select-checkbox', function () {
    var current_row = $(this).parents('tr');//Get the current row
    if (current_row.hasClass('child')) {//Check if the current row is a child row
        current_row = current_row.prev();//If it is, then point to the row before it (its 'parent')
    }
//  
    var cur_row = $('#total-surgical-merge-table').dataTable().fnGetData(current_row);
    var totalnhip = 0;
    var totalnon = 0;
    var totalpat = 0;
    
    var data = $('#total-surgical-merge-table').DataTable().rows({selected:  true}).data();
    
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







