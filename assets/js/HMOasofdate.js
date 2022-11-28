$(".report-btn").hide();
var table = $('#hmo-asofdate-table').DataTable({
    dom: 'frtip',
  //  responsive: true
});

$('.date').datetimepicker({
        format: 'YYYY-MM-DD'
});


var hmo = {
    get_hmo_asof_date : function(hmolist){
        start_date = $('#search-hmo-asofdate-form input[name=start_date]').val(); 
         end_date = $('#search-hmo-asofdate-form input[name=end_date]').val(); 
         
        $("#search-hmo-asofdate-form input[name=s_date]").val(start_date);
        $("#search-hmo-asofdate-form input[name=e_date]").val(end_date);
//        alert($("#search-hmo-asofdate-form input[name=s_date]").val());
//        alert(hmolist);
        $('#hmo-asofdate-table').dataTable().fnDestroy();
        var table = $('#hmo-asofdate-table').dataTable({
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
                url:BASE_URL + "user/fetch_hmo_asofdate_patients",
                type:"POST",
                 data: {start_date: $("#search-hmo-asofdate-form input[name=s_date]").val(), 
                        end_date: $("#search-hmo-asofdate-form input[name=e_date]").val(), 
                        hmocode: hmolist}
//                data: { 
//                    start_date : $('#search-transmittal-form input[name=start_date]').val(), 
//                }
            },
            initComplete : function(settings, json){
                $("#total-data input[name=totalhosp]").val('₱ ' + accounting.format(json["total"]["hosphmo"],2)).closest('.form-line').addClass('focused');
                $("#total-data input[name=totalpf]").val('₱ ' + accounting.format(json["total"]["pfhmo"],2)).closest('.form-line').addClass('focused');
              
            }
        });
        $('#hmo-asofdate-table_filter input').unbind();
        $('#hmo-asofdate-table_filter input').bind('keyup', function(e) {
            if(e.keyCode == 13) {
                table.fnFilter(this.value);	
            }
        });
    },
   
    
    search_hmo_asofdate : function(){
        var s_date = $('#search-hmo-asofdate-form input[name = start_date]');
        var e_date = $('#search-hmo-asofdate-form input[name = end_date]');
        var error = 0;
        
        if (s_date.val() == "") {
            s_date.parents('.form-line').removeClass('error success').addClass('error');
            s_date.parents('.input-group').find('small').text('Please select a start date!');
            error++;
        }else{
            s_date.parents('.form-line').removeClass('error success').addClass('success');
            s_date.parents('.input-group').find('small').text('');
        }
        
        if (e_date.val() == "") {
            e_date.parents('.form-line').removeClass('error success').addClass('error');
            e_date.parents('.input-group').find('small').text('Please select an end date!');
            error++;
        }else{
            e_date.parents('.form-line').removeClass('error success').addClass('success');
            e_date.parents('.input-group').find('small').text('');
        }
        
        if (error === 0) {
             var hmolist = $('#hmolist').val();
            var hmocodex = hmolist.split(':');
      
            hmo.get_hmo_asof_date(hmocodex[0]);
           
        }
    },
    
    generate_hmoasofdate_report : function(){
        
        start_date = $('#search-hmo-asofdate-form input[name=start_date]').val(); 
        end_date = $('#search-hmo-asofdate-form input[name=end_date]').val(); 
        hospitalfee = $('#totalhosp').val();
        proffee = $('#totalpf').val();
    
        var hmolist = $('#hmolist').val();
        var hmocodex = hmolist.split(':');
        
        $("#hmo-asofdate-form input[name=start_date]").val(start_date);
        $("#hmo-asofdate-form input[name=end_date]").val(end_date);
        $("#hmo-asofdate-form input[name=hmocodex]").val(hmocodex[0]);
        $("#hmo-asofdate-form input[name=hmonamex]").val(hmocodex[1]);
        $("#hmo-asofdate-form input[name=hospital]").val(hospitalfee);
        $("#hmo-asofdate-form input[name=proffee]").val(proffee);
         
        $("#hmo-asofdate-form").submit();
       
    },
    
    search_hmo : function()
    {
        var hmolist = $('#hmolist').val();
        var hmocodex = hmolist.split(':');
        hmo.get_hmo_asof_date(hmocodex[0]);

    }
    

};

function load_hmoasofdate_script(scriptUrl)
{
    $.getScript(scriptUrl)
        .done(function( script, textStatus ) {
              console.log( textStatus );
            var hmolist = $('#hmolist').val();
            var hmocodex = hmolist.split(':');
           hmo .get_hmo_asof_date(hmocodex[0]);
            
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


$('#hmo-asofdate-table').on('click', 'td', function () {
    
      
          var current_row = $(this).parents('tr');//Get the current row
    if (current_row.hasClass('child')) {//Check if the current row is a child row
        current_row = current_row.prev();//If it is, then point to the row before it (its 'parent')
    }
    var data = $('#hmo-asofdate-table').dataTable().fnGetData(current_row);
    show_hmo(data);
    $("#patientshmo").modal("show");
      
 
});

function show_hmo(data)
{
    $('#pxname').html(data[2]);
   
     $('#patients-hmo-table').dataTable().fnDestroy();
        var table = $('#patients-hmo-table').dataTable({
            dom: 'frtip',
            responsive: true,
            processing:true,  
            serverSide:true, 
            order:[],  
            ajax:{  
                url:BASE_URL + "user/fetch_patients_hmo",
                type:"POST",
                data: { 
                    casecode: data[0]
                }
            }
        });
        $('#patients-hmo-table_filter input').unbind();
        $('#patients-hmo-table_filter input').bind('keyup', function(e) {
            if(e.keyCode === 13) {
            table.fnFilter(this.value);	
            }
        });
}









