$(".report-btn").hide();
var table = $('#ph-inventory-table').DataTable({
    dom: 'frtip',
  //  responsive: true
});

$('.date').datetimepicker({
        format: 'YYYY-MM'
});


var pharmacy = {
    get_inventory_monitoring : function(){
        start_date = $('#search-ph-inventory-form input[name=start_date]').val(); 
        end_date   = $('#search-ph-inventory-form input[name=end_date]').val(); 
         
        $("#search-ph-inventory-form input[name=s_date]").val(start_date);
        $("#search-ph-inventory-form input[name=e_date]").val(end_date);
//        alert($("#search-hmo-asofdate-form input[name=s_date]").val());
//        alert(hmolist);
        $('#ph-inventory-table').dataTable().fnDestroy();
        var table = $('#ph-inventory-table').dataTable({
            dom: 'frtip',
          //  responsive: true,
          pageLength:10,
          pagination: true,
            processing:true,  
            serverSide:true, 
            order:[],  
           
            ajax:{  
                url:BASE_URL + "user/fetch_inventory_monitoring",
                type:"POST",
                 data: {start_date: $("#search-ph-inventory-form input[name=s_date]").val() 
//                        end_date: $("#search-ph-inventory-form input[name=e_date]").val()
                    }
//                data: { 
//                    start_date : $('#search-transmittal-form input[name=start_date]').val(), 
//                }
            },
            initComplete : function(settings, json){
                $("#total-data input[name=totalbeginning]").val('₱ ' + accounting.format(json["total"]["beginning"],2)).closest('.form-line').addClass('focused');
                $("#total-data input[name=totalsales]").val('₱ ' + accounting.format(json["total"]["sales"],2)).closest('.form-line').addClass('focused');
                $("#total-data input[name=totalending]").val('₱ ' + accounting.format(json["total"]["ending"],2)).closest('.form-line').addClass('focused');
              
            }
        });
        $('#ph-inventory-table_filter input').unbind();
        $('#ph-inventory-table_filter input').bind('keyup', function(e) {
            if(e.keyCode == 13) {
                table.fnFilter(this.value);	
            }
        });
    },
   
    
    search_inventory_monitoring : function(){
  
        var s_date = $('#search-ph-inventory-form input[name=start_date]');
        var e_date = $('#search-ph-inventory-form input[name=end_date]');
        var error = 0;
        
        if (s_date.val() === "") {
            s_date.parents('.form-line').removeClass('error success').addClass('error');
            s_date.parents('.input-group').find('small').text('Please select a start date!');
            error++;
        }else{
            s_date.parents('.form-line').removeClass('error success').addClass('success');
            s_date.parents('.input-group').find('small').text('');
        }
        
//        if (e_date.val() == "") {
//            e_date.parents('.form-line').removeClass('error success').addClass('error');
//            e_date.parents('.input-group').find('small').text('Please select an end date!');
//            error++;
//        }else{
//            e_date.parents('.form-line').removeClass('error success').addClass('success');
//            e_date.parents('.input-group').find('small').text('');
//        }
        
        if (error === 0) {
//             var hmolist = $('#hmolist').val();
//        var hmocodex = hmolist.split(':');
//      
//            hmo.get_hmo_asof_date(hmocodex[0]);
        pharmacy.get_inventory_monitoring();
           
        }
    },
    
    generate_inventory_monitoring_report : function(){
        
        start_date  = $('#search-ph-inventory-form input[name=start_date]').val(); 
        beginning   = $('#totalbeginning').val();
        totalsales  = $('#totalsales').val();
        totalending = $('#totalending').val();
  
        $("#ph-inventory-form input[name=start_date]").val(start_date);
        $("#ph-inventory-form input[name=beginning]").val(beginning);
        $("#ph-inventory-form input[name=sales]").val(totalsales);
        $("#ph-inventory-form input[name=ending]").val(totalending);
        $("#ph-inventory-form").submit();
       
    }
    
   
    

};

function load_inventorymonitoring_script(scriptUrl)
{
    $.getScript(scriptUrl)
        .done(function( script, textStatus ) {
              console.log( textStatus );
//            var hmolist = $('#hmolist').val();
//            var hmocodex = hmolist.split(':');
//           hmo .get_hmo_asof_date(hmocodex[0]);
           pharmacy.get_inventory_monitoring();
//            
        })
        .fail(function( jqxhr, settings, exception ) {
         console.log("fail to load script");
    });
}
//
//$('#transmittal-table').on('dblclick', 'td', function () {
////    alert("asdfasdf");
//    var current_row = $(this).parents('tr');//Get the current row
//    if (current_row.hasClass('child')) {//Check if the current row is a child row
//        current_row = current_row.prev();//If it is, then point to the row before it (its 'parent')
//    }
//    var data = $('#transmittal-table').dataTable().fnGetData(current_row);
//////    row.css("background","#FF5722");
////
////    $("#dis-purchase-form input[name=control]").val(data[5]);
////    $("#disPurchase").modal("show");
//
//    console.log(data);
//});


$('#ph-inventory-table').on('click', 'td', function () {
    
      
          var current_row = $(this).parents('tr');//Get the current row
    if (current_row.hasClass('child')) {//Check if the current row is a child row
        current_row = current_row.prev();//If it is, then point to the row before it (its 'parent')
    }
    var data = $('#ph-inventory-table').dataTable().fnGetData(current_row);
    var start_date = $('#search-ph-inventory-form input[name=start_date]').val(); 
    show_inventory(data,start_date);
    $("#inventorymonitor_group").modal("show");
      
 
});

function show_inventory(data,startdate)
{
    $('#groupname').html(data[0]);
     $('#s_date').val(start_date);
     
    var currentMonth = moment(new Date(start_date)).format('MMMM');
    var currentYear = moment(new Date(start_date)).format('YYYY');
    
     $('#month').html(currentMonth);
      $('#year').html(currentYear);
     
    
  
   
     $('#inventorymonitor-group-table').dataTable().fnDestroy();
        var table = $('#inventorymonitor-group-table').dataTable({
            dom: 'frtip',
      
            processing:true,  
            serverSide:true, 
            order:[],  
            ajax:{  
                url:BASE_URL + "user/fetch_groupname_info",
                type:"POST",
                data: { 
                    groupname: data[0],
                    s_date: start_date
                }
            }
        });
        $('#inventorymonitor-group-table_filter input').unbind();
        $('#inventorymonitor-group-table_filter input').bind('keyup', function(e) {
            if(e.keyCode === 13) {
            table.fnFilter(this.value);	
            }
        });
}









