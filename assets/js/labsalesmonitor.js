
var table = $('#ph-inventory-table').DataTable({
    dom: 'frtip',
  //  responsive: true
});

$('.date').datetimepicker({
        format: 'YYYY-MM'
});


var laboratorysales = {
    get_sales_monitoring : function(){
       
        $('#lab-sales-table').dataTable().fnDestroy();
        var table = $('#lab-sales-table').dataTable({
            dom: 'frtip',
          //  responsive: true,
          pageLength:10,
          pagination: true,
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
                url:BASE_URL + "user/fetch_lab_sales_monitoring",
                type:"POST",
                 data: {start_date: $("#search-lab-sales-form input[name=s_date]").val()}
            },
            initComplete : function(settings, json){
//              
            }
        });
        $('#lab-sales-table_filter input').unbind();
        $('#lab-sales-table_filter input').bind('keyup', function(e) {
            if(e.keyCode == 13) {
                table.fnFilter(this.value);	
            }
        });
    },
   
    
    search_inventory_monitoring : function(){
  
        var s_date = $('#search-lab-sales-form input[name=start_date]');
        var error = 0;
        
        if (s_date.val() === "") {
            s_date.parents('.form-line').removeClass('error success').addClass('error');
            s_date.parents('.input-group').find('small').text('Please select a start date!');
            error++;
        }else{
            s_date.parents('.form-line').removeClass('error success').addClass('success');
            s_date.parents('.input-group').find('small').text('');
        }
        if (error === 0) {
        laboratorysales.get_sales_monitoring();
           
        }
    },
    
    generate_sales_monitoring_report : function()
    {
        $("#lab-sales-form").submit();
    },
     generate_sales_summarized_report : function()
    {
        $("#lab-summarized-form input[name=batch]").val();
        $("#lab-summarized-form input[name=indate]").val();
        $("#lab-summarized-form input[name=outdate]").val();
        $("#lab-summarized-form").submit();
    },
    
     generate_sales_lab_group_report : function()
    {
        $("#lab-sales-group-form input[name=prodid]").val();
        $("#lab-sales-group-form input[name=startdate]").val();
        $("#lab-sales-group-form input[name=enddate]").val();
        $("#lab-sales-group-form input[name=groupnamex]").val();
        $("#lab-sales-group-form").submit();
    }
    
   
    

};

function load_inventorymonitoring_script(scriptUrl)
{
    $.getScript(scriptUrl)
        .done(function( script, textStatus ) {
              console.log( textStatus );
           laboratorysales.get_sales_monitoring();
//            
        })
        .fail(function( jqxhr, settings, exception ) {
         console.log("fail to load script");
    });
}



$('#lab-sales-table').on('click', 'td', function () 
{
    var current_row = $(this).parents('tr');//Get the current row
    if (current_row.hasClass('child')) {//Check if the current row is a child row
        current_row = current_row.prev();//If it is, then point to the row before it (its 'parent')
    }
    var data = $('#lab-sales-table').dataTable().fnGetData(current_row);
  
    $('#profile').attr('data-toggle','tab');
    $('#home').removeClass('active');
    $('#home').removeClass('in');
    $('#profile').addClass('in');
    $('#profile').addClass('active');
    $('#home1').removeClass('active');
    $('#profile1').addClass('active');
    show_inventory(data);
//    $("#labsales_group").modal("show");
      
 
});

function show_inventory(data)
{

    $('#monthyear').html(data[3]);
    $('#batch').val(data[0]);
    $('#indate').val(data[1]);
    $('#outdate').val(data[2]);
    
    
    
     $('#lab-summarized-table').dataTable().fnDestroy();
        var table = $('#lab-summarized-table').dataTable({
            dom: 'frti',
            paging:false,
            processing:true,  
            serverSide:true, 
            order:[],  
            columnDefs: [
                    {
                       targets:[7,8,9,10,11],
                        visible:false
                    }
                    ],
            ajax:{  
                url:BASE_URL + "user/fetch_lab_sales_summarized",
                type:"POST",
                data: { 
                    batch: data[0],
                    indate: data[1],
                    outdate: data[2]
                }
            },
            initComplete : function(settings, json)
            {
              
                $('#lab-summarized-table tbody') // select table tbody
                .prepend('<tr style="background-color:green;color:white;"/>') // prepend table row
                .children('tr:first') // select row we just created
                .append(' <th style="text-align:right;">TOTAL</th>'+
                                                    '<th style="text-align:right;">'+ json["total"]["qty"]+'</th>'+
                                                    '<th style="text-align:right;">₱ '+ accounting.format(json["total"]["totalamount"],2)+'</th>'+
                                                   '<th style="text-align:right;">'+ json["total"]["opdqty"]+'</th>'+
                                                    '<th style="text-align:right;">'+ json["total"]["ipdqty"]+'</th>'+
                                                    '<th style="text-align:right;"> ₱ '+ accounting.format(json["total"]["addonprice"],2)+'</th>'+
                                                    '<th></th>') // append four table cells to the row we created
//                
            }
        });
        $('#lab-summarized-table_filter input').unbind();
        $('#lab-summarized-table_filter input').bind('keyup', function(e) {
            if(e.keyCode === 13) {
            table.fnFilter(this.value);	
            }
        });
}

$('#lab-summarized-table').on('click', 'td', function () 
{
    var current_row = $(this).parents('tr');//Get the current row
    if (current_row.hasClass('child')) {//Check if the current row is a child row
        current_row = current_row.prev();//If it is, then point to the row before it (its 'parent')
    }
    var data = $('#lab-summarized-table').dataTable().fnGetData(current_row);
  
  
    show_detailed(data);
    $("#labsales_group").modal("show");
      
 
});

function show_detailed(data)
{
    var month = moment(data[10]).format('MMMM YYYY');

    $('#groupname').html(data[0]);
    $('#groupnamex').val(data[0]);
    $('#datexx').html(month);
    $('#prodid').val(data[9]);
    $('#startdate').val(data[10]);
    $('#enddate').val(data[11]);
    
    
     $('#lab-sales-group-table').dataTable().fnDestroy();
        var table = $('#lab-sales-group-table').dataTable({
            dom: 'frti',
            paging:false,
            processing:true,  
            serverSide:true, 
            order:[],  
            columnDefs: [
                    {
                        targets:[13],
                        visible:false
                    }
                    ],
            ajax:{  
                url:BASE_URL + "user/fetch_lab_sales_detailed",
                type:"POST",
                data: { 
                    prodid: data[9],
                    startdate: data[10],
                    enddate: data[11]
                }
            },
            initComplete : function(settings, json)
            {
                $('#lab-sales-group-table tbody') // select table tbody
                .prepend('<tr style="background-color:green;color:white;"/>') // prepend table row
                .children('tr:first') // select row we just created
                .append(' <th style="text-align:right;" colspan="2">TOTAL</th>'+
                        '<th style="text-align:right;">₱ '+ accounting.format(json["total"]["addonrate"],2)+'</th>'+
                        '<th style="text-align:right;"> ₱ '+ accounting.format(json["total"]["totalamt"],2)+'</th>'+
                        '<th></th>'+
                        '<th></th>'+
                        '<th></th>'+
                        '<th></th>'+
                        '<th></th>'+
                        '<th></th>'+
                        '<th></th>'+
                        '<th></th>'+
                        '<th></th>') // append four table cells to the row we created
//                
            }
        });
        $('#lab-sales-group-table_filter input').unbind();
        $('#lab-sales-group-table_filter input').bind('keyup', function(e) {
            if(e.keyCode === 13) {
            table.fnFilter(this.value);	
            }
        });
}









