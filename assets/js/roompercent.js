$(".report-btn").hide();


$('.date').datetimepicker({
        format: 'YYYY-MM-DD'
});


var percentroom = {
    get_roompercentage : function(){
     
     
        $.ajax({
                    type: 'POST',
                    url:  BASE_URL + "user/get_ward",
                    data: $('#room-percent-form').serialize(),
                    dataType: 'json'
                }).done(function(data1) {
                    console.log(data1);
                        if (data1.status) {
                            $('#room-percentage-table').dataTable().fnDestroy();
                            var room_percent_table = $('#room-percentage-table').DataTable({
                                 dom         : 'frti',
                                 responsive  : true,
                                 autoWidth   : true,
                                paging      : true,
                                lengthChange: false,
                                searching   : true,
                                ordering    : false,
                                info        : false,
                                
                    });
                    
                    var totalpatients = parseInt(data1.census);
                    var allbeds = parseInt(data1.ward[0]["Beds"]) +  parseInt(data1.private[0]["Beds"]) +  parseInt(data1.suite[0]["Beds"]);
                    var percentage = (parseInt(totalpatients)/parseInt(allbeds)) * parseInt(100);
                     $('#hospoccurate').html(parseFloat(percentage).toFixed(2) + '%');
                    
                            room_percent_table.clear();
                            
                            if(data1.ward.length >= 0)
                                {
                                for (var i = 0; i < data1.ward.length; i++) {
                                    room_percent_table.row.add(
                                        [
                                            '<p> Ward </p>',
                                            data1.ward[0]["Beds"],
                                            data1.ward[0]["totalbed"],
                                            parseFloat(data1.ward[0]["percentage"]).toFixed(2) + '%'
                                  
                                        ] 
                                    )
                                    room_percent_table.row.add(
                                        [
                                            '<p> Private </p>',
                                            data1.private[0]["Beds"],
                                            data1.private[0]["totalbed"],
                                            parseFloat(data1.private[0]["percentage"]).toFixed(2) + '%'
                                        ]  
                                    )
                                    
                                    room_percent_table.row.add(
                                        [
                                            '<p> Suite Room </p>',
                                            data1.suite[0]["Beds"],
                                            data1.suite[0]["totalbed"],
                                            parseFloat(data1.suite[0]["percentage"]).toFixed(2) + '%'
                                        ]  
                                    )
                                    .draw(false);
                                } 
                            }
                            else 
                            {
                            console.log('fail');
                            }
                    }
    });
    },
    
    search_room_percentage : function(){
        
        var s_date = $('#room-percent-form input[name = start_date]');
        var error = 0;
        
        if (s_date.val() == "") {
            s_date.parents('.form-line').removeClass('error success').addClass('error');
            s_date.parents('.input-group').find('small').text('Please select a start date!');
            error++;
        }else{
            s_date.parents('.form-line').removeClass('error success').addClass('success');
            s_date.parents('.input-group').find('small').text('');
        }
        
        if (error === 0) {
            load_room_percentage_script("http://192.168.2.111:3777/drainwizv2/assets/vendors/js/responsive.js");
        }
    },
    
    generate_room_percent_report : function(){
        start_date = $('#room-percent-form input[name=start_date]').val(); 
        s_data = $('#room-percent-form_filter input').val();
        
        $("#room-percent-form input[name=s_date]").val(start_date);
        $("#room-percent-form input[name=search]").val(s_data);
        $("#room-percent-form").submit();
    },
    get_ros_census : function(){
        $.ajax({
            type: 'POST',
            url:  BASE_URL + "user/fetch_ros",
            data: $('#room-percent-form').serialize(),
            dataType: 'json'
        }).done(function(data) {
            console.log(data);
            if (data.status) {
//                $('#sales-report').DataTable()
//   .columns.adjust()
//   .responsive.recalc();
                var ros1_table = $('#ros1-table').DataTable();
                var ros2_table = $('#ros2-table').DataTable();
                var ros3_table = $('#ros3-table').DataTable();
                var ros4_table = $('#ros4-table').DataTable();
                var ros5_table = $('#ros5-table').DataTable();
//                phic_table.destroy().draw();
//                var phic = 0;
//                var nphic = 0;

                ros1_table.clear().draw();   
                ros2_table.clear().draw(); 
                ros3_table.clear().draw(); 
                ros4_table.clear().draw(); 
                ros5_table.clear().draw(); 
                
                for (var i = 0; i < data.rooms.length; i++) {
                    switch(i){
                        case 0:
                            for (var j = 0; j < data.rooms[i].length; j++) {
                                $('#day1-tab a').text(moment(data.rooms[i][j]['mydate']).format("MMM DD, YYYY"));
                                ros1_table.row.add([data.rooms[i][j]['roomno'],data.rooms[i][j]['total'],data.rooms[i][j]['totalbed'],parseFloat(data.rooms[i][j]['percentage']).toFixed(2)+'%']).draw(false);
                            }
                            break;
                        case 1:
                            for (var j = 0; j < data.rooms[i].length; j++) {
                                $('#day2-tab a').text(moment(data.rooms[i][j]['mydate']).format("MMM DD, YYYY"));
                                ros2_table.row.add([data.rooms[i][j]['roomno'],data.rooms[i][j]['total'],data.rooms[i][j]['totalbed'],parseFloat(data.rooms[i][j]['percentage']).toFixed(2)+'%']).draw(false);
                            }
                            break;
                        case 2:
                            for (var j = 0; j < data.rooms[i].length; j++) {
                                $('#day3-tab a').text(moment(data.rooms[i][j]['mydate']).format("MMM DD, YYYY"));
                                ros3_table.row.add([data.rooms[i][j]['roomno'],data.rooms[i][j]['total'],data.rooms[i][j]['totalbed'],parseFloat(data.rooms[i][j]['percentage']).toFixed(2)+'%']).draw(false);
                            }
                            break;
                        case 3:
                            for (var j = 0; j < data.rooms[i].length; j++) {
                                $('#day4-tab a').text(moment(data.rooms[i][j]['mydate']).format("MMM DD, YYYY"));
                                ros4_table.row.add([data.rooms[i][j]['roomno'],data.rooms[i][j]['total'],data.rooms[i][j]['totalbed'],parseFloat(data.rooms[i][j]['percentage']).toFixed(2)+'%']).draw(false);
                            }
                            break;
                        case 4:
                            for (var j = 0; j < data.rooms[i].length; j++) {
                                $('#day5-tab a').text(moment(data.rooms[i][j]['mydate']).format("MMM DD, YYYY"));
                                ros5_table.row.add([data.rooms[i][j]['roomno'],data.rooms[i][j]['total'],data.rooms[i][j]['totalbed'],parseFloat(data.rooms[i][j]['percentage']).toFixed(2)+'%']).draw(false);
                            }
                            break;
                        default:
                            break;
                    }
//                    if (data.px_records[i]['phicmembr'] == "Non-NHIP") {
//                        nphic++;
//                    }else{
//                        phic++;
//                    }
                }
                
                
            } else {
                console.log("fail get ros census");
            }
        });
    },
};

function load_room_percentage_script(scriptUrl)
{
    $.getScript(scriptUrl)
        .done(function( script, textStatus ) {
            percentroom.get_roompercentage();
                percentroom.get_ros_census();
            
        })
        .fail(function( jqxhr, settings, exception ) {
         console.log("fail to load script");
    });
}



















