
$('.datex').datetimepicker({
        format: 'YYYY-MM'
});

var obstetric = 
{
    get_Obstetrical_Procedures : function()
    {
        $('#Obstetrical-Procedures-table').dataTable().fnDestroy();
        $('#Obstetrical-Procedures-table tbody').empty();
        var table = $('#Obstetrical-Procedures-table').dataTable({
            dom: 'frtip',
             scrollX:true,
                columnDefs: [ {
                    targets: -1,
                    data: null,
                    defaultContent: "<button class='btn-success' onclick='obstetric.ex()'>Click!</button>",
                    width: "3%"},
                {
                    orderable: false,
                    className: 'select-checkbox',
                    targets:   0,
                    width: "3%"
                },
                {
                    targets:   [1,2,3,4],
                    width: "10%"
                },
            ],
            select: {
                style:    'multi',
                selector: 'td:first-child'
            },
            processing:true,  
            serverSide:true, 
            order:[],
            ajax:{  
                url:BASE_URL + "user/fetch_obstetric_procedure",
                type:"POST"
            },
        });
    
        $('#Obstetrical-Procedures-table_filter input').unbind();
        $('#Obstetrical-Procedures-table_filter input').bind('keyup', function(e) {
            if(e.keyCode === 13) {
            table.fnFilter(this.value); 
            }
        });

    },


search_obstetrical_procedures : function(){
        var s_date = $('#search-obstetrical-form input[name = start_date]');
        var error = 0;

        if (s_date.val() == "") {
            s_date.parents('.form-line').removeClass('error success').addClass('error');
            s_date.parents('.input-group').find('small').text('Please select a month!');
            error++;
        }else{
            s_date.parents('.form-line').removeClass('error success').addClass('success');
            s_date.parents('.input-group').find('small').text('');
        }
        
           window.location.href =  BASE_URL + "user/mandaobstetric/"+s_date.val();
       
    },


    get_Obstetrical_Procedures_top : function()
    {
        start_date = $("#search-obstetrical-form input[name=start_date]").val(); 
        $("#search-obstetrical-form input[name=s_date]").val(start_date);
        s_date =   $("#search-obstetrical-form input[name=s_date]").val();

         $.ajax({
            type: 'POST',
            url:  BASE_URL + "user/get_ob/"+s_date,
            data: {s_date: $("#search-obstetrical-form input[name=s_date]").val()},
                   dataType: 'json'
        }).done(function(data) {
            if (data.status) {
                 console.log('success');
                    $('#top-ob-table').dataTable().fnDestroy();
                    var top_obprocedure = $('#top-ob-table').DataTable({

                        dom:"t",
                        ordering:false
                    });

                    top_obprocedure.clear();
                    if(data.obprocedure.length !== 0)
                     {
                         top_obprocedure.row.add([
                            '<td><span style="color:red;">F.1.</span>TOTAL NUMBER OF DELIVERIES (NSD plus CAESARIAN SECTION)</td>',
                            data.obprocedure["nhip"],
                            data.obprocedure["non"]
                        ]).draw(false);
                    }else
                    {
                         top_obprocedure.row.add([
                            '<td><span style="color:red;">F.1.</span>TOTAL NUMBER OF DELIVERIES (NSD plus CAESARIAN SECTION)</td>',
                            '0',
                            '0'
                        ]).draw(false);
                     }
                     
                    if(data.cs.length !== 0)
                    {
                        top_obprocedure.row.add([
                            ' <td  ><span style="color:red;">F.2.</span>TOTAL NUMBER OF CAESARIAN CASES</td>',
                            data.cs["nhip"],
                            data.cs["non"]
                        ]).draw(false);
                    }else
                    {
                        top_obprocedure.row.add([
                            ' <td  ><span style="color:red;">F.2.</span>TOTAL NUMBER OF CAESARIAN CASES</td>',
                            '0',
                            '0'
                        ]).draw(false);
                    }
                    
                    top_obprocedure.row.add([
                        '&nbsp; &nbsp; &nbsp; &#9632; INDICATIONS FOR CS:',
                        '',
                        '']).draw(false);
                    
                    if(data.indication.length > 0)
                    {
                        for (var i = 0; i <= data.indication.length; i++) {
                            top_obprocedure.row.add([
                                (i+1)+'. &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;' + data.indication[i]["indicationcause"],
                                data.indication[i]["nhip"],
                                data.indication[i]["nonnhip"]
                            ]).draw(false);
                        }
                     }
                     else
                     {
                        top_obprocedure.row.add([
                            '<center>No records found</center>',
                            '',
                            ''
                        ]).draw(false);
                    }
                }
                else
                {
                    console.log('failed');
                }
            });
        },


    //secondary page
    
    
     mergeconfine : function(){
   
   if ($('#Obstetrical-Procedures-table').DataTable().rows({selected:  true}).data().length == 0) {
            swal({
                title: "Oops!",
                text: "Please select a ticket.",
                type: "warning"
            });
        }
        else if ( $('#merge-obstetrics-form input[name=confinename]').val() === ''){
            swal({
                title: "Oops!",
                text: "Please write the diagnosis name.",
                type: "warning"
            });

        }
            else{
            var ctrl = [];
            var data = $('#Obstetrical-Procedures-table').DataTable().rows({selected:  true}).data();
            for (var i = 0; i <data.length; i++) {
                ctrl.push(data[i][2]);
            }
            swal({
            title: "Merge Obstetrical Procedures?",
            text: "You cannot undo this action!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#4CAF50",
            confirmButtonText: "Yes, merge it!",
            cancelButtonText: "No",
            closeOnConfirm: false
            }, function () {
                obstetric.add_groupname(ctrl);
            });
        }
 
    },

    add_groupname : function(data){


   
        $('#Obstetrical-Procedures-table').dataTable().fnDestroy();
        $('#Obstetrical-Procedures-table tbody').empty();
        var table = $('#Obstetrical-Procedures-table').dataTable({
            dom: 'frtip',
             scrollX:true,
            pageLength: 30,
            columnDefs: [ 
                {
                   targets: -1,
            data: null,
            defaultContent: "<button class='btn-success' onclick='obstetric.ex()'>Click!</button>",
                width: "3%"
                },
                {
                    orderable: false,
                    className: 'select-checkbox',
                    targets:   0,
                    width: "3%"
                }
                
            ],
       
            select: {
                style:    'multi',
                selector: 'td:first-child'
            },
            
            
            
            processing:true,  
            serverSide:true, 
            order:[],
            ajax:{  
                url:BASE_URL + "user/merge_obprocedure",
                data: {
                    diagnosis : data,
                    confinename : $('#merge-obstetrics-form input[name=confinename]').val(), 
                    confinenhip : $('#merge-obstetrics-form input[name=confinenhip]').val(),
                    confinenon  : $('#merge-obstetrics-form input[name=confinenon]').val(),
                    total       : $('#merge-obstetrics-form input[name=total]').val()
                },
                type:"POST"
            },
            initComplete: function(settings, json) {
              
                swal("Success","Merged successfully!","success");
         
            }
            
        });
         
        $('#Obstetrical-Procedures-table_filter input').unbind();
        $('#Obstetrical-Procedures-table_filter input').bind('keyup', function(e) {
            if(e.keyCode == 13) {
                table.fnFilter(this.value); 
            }
        });
        
       
    },    
    }

$("#check-all").on("change",function(){
    var table = $('#Obstetrical-Procedures-table').DataTable();
    if($(this)[0].checked) {
        table.rows('#Obstetrical-Procedures-table tbody tr').select();
        
    }else{
        table.rows('#Obstetrical-Procedures-table tbody tr').deselect();
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

$('#Obstetrical-Procedures-table').on('click', '.select-checkbox', function () {
    var current_row = $(this).parents('tr');//Get the current row
    if (current_row.hasClass('child')) {//Check if the current row is a child row
        current_row = current_row.prev();//If it is, then point to the row before it (its 'parent')
    }
//  
    var cur_row = $('#Obstetrical-Procedures-table').dataTable().fnGetData(current_row);
    var totalnhip = 0;
    var totalnon = 0;
    var totalpat = 0;
    
    var data = $('#Obstetrical-Procedures-table').DataTable().rows({selected:  true}).data();
    
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




 $('#Obstetrical-Procedures-table').on('click', 'button', function () {
    var current_row = $(this).parents('tr');//Get the current row
    if (current_row.hasClass('child')) {//Check if the current row is a child row
        current_row = current_row.prev();//If it is, then point to the row before it (its 'parent')
    }
//  
    var cur_row = $('#Obstetrical-Procedures-table').dataTable().fnGetData(current_row);


    
    if (cur_row !== null) {

        $('.select-checkbox').removeAttr('checked');
        $('#expounddiag').modal('show');
        $('#expound').text(cur_row[2])
   
       
    }
});

