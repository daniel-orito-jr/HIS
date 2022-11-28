$('body').popover({
    selector: '[data-toggle="popover"]'
});



var approved1 = {
  get_approved1 : function(){
        $('#approved-supplier-table').dataTable().fnDestroy();
        $('#approved-supplier-table tbody').empty();
        var table = $('#approved-supplier-table').dataTable({
            dom: 'frtip',
//            responsive: true,
            processing:true,  
            serverSide:true, 
            order:[],
            ajax:{  
                url:BASE_URL + "user/fetch_purchase_supplier/approved",
                type:"POST"
            },
            initComplete : function(){
                $('[data-toggle="popover"]').click(function(){
                    $('[data-toggle="popover"]').not(this).popover('hide'); //all but this
                });
                
                
            }
            
        });
        $('#approved-supplier-table_filter input').unbind();
        $('#approved-supplier-table_filter input').bind('keyup', function(e) {
            if(e.keyCode == 13) {
                table.fnFilter(this.value);	
            }
        });
    },  
};

$('#approved-supplier-table').on('click', 'td', function () 
{
    var current_row = $(this).parents('tr');//Get the current row
    if (current_row.hasClass('child')) {//Check if the current row is a child row
        current_row = current_row.prev();//If it is, then point to the row before it (its 'parent')
    }
    var data = $('#approved-supplier-table').dataTable().fnGetData(current_row);
    show_approved(data);
});

function show_approved(data)
{
    $('#supname').val(data[1]);
    $('#prdate').val(moment(data[3]).format('MMMM DD YYYY'));
    $('#prnumber').val(data[0]);
    if(data[10] === "LT")
    {
        $('#dept').val('LABORATORY');
    }
    else if(data[10] === "PH")
    {
        $('#dept').val('PHARMACY');
    }
    else if(data[10] === "CS")
    {
        $('#dept').val('CSR');
    }
    else if(data[10] === "RT")
    {
        $('#dept').val('RADIOLOGY');
    }
    else if(data[10] === "US")
    {
        $('#dept').val('ULTRASOUND');
    }
    else
    {
        $('#dept').val('DIALYSIS');
    }



$('#approved-stock-table').dataTable().fnDestroy();
        $('#approved-stock-table tbody').empty();
        var table = $('#approved-stock-table').dataTable({
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
                    targets : [6,11,12],
                    visible : false
                }
            ],
            select: {
                style:    'multi',
                selector: 'td:first-child'
            },
            processing:true, 
            scrollX:true,
            serverSide:true, 
            order:[],
            ajax:{  
                url:BASE_URL + "user/fetch_purchase_stocks_status/approved",
                type:"POST",
                 data: { 
                    pocode : data[0]
                }
            },
            initComplete : function(settings, json)
            {
                $('[data-toggle="popover"]').click(function(){
                    $('[data-toggle="popover"]').not(this).popover('hide'); //all but this
                });
                $("#stockHeader").val('₱ ' + accounting.format(json["total"]["amt"],2)).closest('.form-line').addClass('focused');
            }
        });
        $('#approved-stock-table_filter input').unbind();
        $('#approved-stock-table_filter input').bind('keyup', function(e) {
            if(e.keyCode == 13) {
            table.fnFilter(this.value);	
            }
        });


}

