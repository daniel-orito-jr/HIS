

$('.datex').datetimepicker({
        format: 'YYYY-MM'
});

var confinex = {


get_common_confinement_causes : function(){



        start_date = $('#search-confinement-causes-form input[name=start_date]').val(); 
        $("#search-confinement-causes-form input[name=s_date]").val(start_date);


        $('#common_Confinement-causes-table').dataTable().fnDestroy();
        $('#common_Confinement-causes-table tbody').empty();
        var table = $('#common_Confinement-causes-table').dataTable({
            dom: 'frt',
            

            pageLength: 10,
            processing:true,  
            serverSide:true, 
            order:[],
            
            
            ajax:{  
                url:BASE_URL + "user/fetch_common_confinement_causes",
                type:"POST",
                data: {s_date: $("#search-confinement-causes-form input[name=s_date]").val()},
            },
           
            
        });
    
        $('#common_Confinement-causes-table_filter input').unbind();
        $('#common_Confinement-causes-table_filter input').bind('keyup', function(e) {
            if(e.keyCode === 13) {
            table.fnFilter(this.value); 
            }
        });
    },


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

            var yearnow = (new Date()).getFullYear();
            var monthnow = (new Date()).getMonth();

            var getmonth = (new Date(s_date.val())).getMonth();
            var getyear = (new Date(s_date.val())).getFullYear();

            if(monthnow+yearnow === getmonth+getyear)
            {
                 $('#btnEdit').removeClass('hidden');
             }
            else
            {
                 $('#btnEdit').addClass('hidden');
            }

            confine.get_common_confinement_causes();
       }
    },

    
    get_confinement_causes : function(){


            

        $('#Confinement-causes-table').dataTable().fnDestroy();
        $('#Confinement-causes-table tbody').empty();
        var table = $('#Confinement-causes-table').dataTable({
            dom: 'frtip',
             scrollX:true,
//            responsive: {
//            details: {
//                    type: 'column',
//                    target: -1
//                }
//            },
            pageLength: 30,
            columnDefs: [ {
                targets: -1,
                data: null,
                 // defaultContent: "<button type='button' class='btn btn-success' onclick='confine.unmerge()' id='unmerge'>Unmerge</button>",
              defaultContent: "<button type='button' class='btn btn-success' id='unmerge'>Unmerge</button>",
                width: "3%"
                
                
            },
                {
                    orderable: false,
                    className: 'select-checkbox',
                    targets:   0,
                    width: "3%"
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
                url:BASE_URL + "user/fetch_confinement_causes",
                type:"POST"
            },
           
            
        });
    
        $('#Confinement-causes-table_filter input').unbind();
        $('#Confinement-causes-table_filter input').bind('keyup', function(e) {
            if(e.keyCode === 13) {
            table.fnFilter(this.value); 
            }
        });

    },
    
    
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
                ctrl.push(data[i][2]);
            }
            swal({
            title: "Merge Confinement Causes?",
            text: "You cannot undo this action!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#4CAF50",
            confirmButtonText: "Yes, merge it!",
            cancelButtonText: "No",
            closeOnConfirm: false
            }, function () {
                confine.add_groupname(ctrl);
            });
        }
 
    },

    add_groupname : function(data){

   
        $('#Confinement-causes-table').dataTable().fnDestroy();
        $('#Confinement-causes-table tbody').empty();
        var table = $('#Confinement-causes-table').dataTable({
            dom: 'frtip',
             scrollX:true,
            pageLength: 30,
            columnDefs: [ 
                {
                   targets: -1,
            data: null,
              defaultContent: "<button type='button' class='btn btn-success' id='unmerge'>Unmerge</button>",
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
                url:BASE_URL + "user/merge_confinement",
                data: {
                    controls : data,
                    confinename : $('#merge-confinement-form input[name=confinename]').val(), 
                    confinenhip : $('#merge-confinement-form input[name=confinenhip]').val(),
                    confinenon : $('#merge-confinement-form input[name=confinenon]').val(),
                    total : $('#merge-confinement-form input[name=total]').val()
                },
                type:"POST"
            },
            initComplete: function(settings, json) {
              
                swal("Success","Merged successfully!","success");
         
            }
            
        });
         
        $('#Confinement-causes-table_filter input').unbind();
        $('#Confinement-causes-table_filter input').bind('keyup', function(e) {
            if(e.keyCode == 13) {
                table.fnFilter(this.value); 
            }
        });
        
       
    },

    addnewcategory: function()
    {
        $('#newcategory').removeClass('hidden');
        $('#newcategory').fadeIn('slow');
        $('#hidecategory').removeClass('hidden');
        $('#btnAdd').addClass('hidden');
        $('#diaglist').addClass('hidden');
    },

    hidecat : function ()
    {
          $('#newcategory').addClass('hidden');
        $('#hidecategory').addClass('hidden');
        $('#btnAdd').removeClass('hidden');
        $('#diaglist').removeClass('hidden');
    }

   
    
   
    
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

$('#Confinement-causes-table').on('click', '.select-checkbox', function () {
    var current_row = $(this).parents('tr');//Get the current row
    if (current_row.hasClass('child')) {//Check if the current row is a child row
        current_row = current_row.prev();//If it is, then point to the row before it (its 'parent')
    }
//  
    var cur_row = $('#Confinement-causes-table').dataTable().fnGetData(current_row);
    var totalnhip = 0;
    var totalnon = 0;
    var totalpat = 0;
    
    var data = $('#Confinement-causes-table').DataTable().rows({selected:  true}).data();
    
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



$('#Confinement-causes-table').on('click', '#unmerge', function () {
     $('#expounddiag').modal('show');
     // alert("hello");
    var current_row = $(this).parents('tr');//Get the current row
    if (current_row.hasClass('child')) {//Check if the current row is a child row
        current_row = current_row.prev();//If it is, then point to the row before it (its 'parent')
    }
//  
    var cur_row = $('#Confinement-causes-table').dataTable().fnGetData(current_row);

    if (cur_row !== null) {
        $('#expound').text(cur_row[2]);
    }
});



//  $('#Confinement-causes-table').on('click', 'button', function () {
//     var current_row = $(this).parents('tr');//Get the current row
//     if (current_row.hasClass('child')) {//Check if the current row is a child row
//         current_row = current_row.prev();//If it is, then point to the row before it (its 'parent')
//     }
// //  
//     var cur_row = $('#Confinement-causes-table').dataTable().fnGetData(current_row);


    
//     if (cur_row !== null) {

//         $('.select-checkbox').removeAttr('checked');
//         $('#expounddiag').modal('show');
//         $('#expound').text(cur_row[2])
   
       
//     }
// });


var count = 0;
function addtoqueue    () 
{
    var diagll = 'diagl';
    var diag = '';

    var newcat = $('#newcat').val();
    if(newcat !== "")
    {
        diag = newcat;
    }
    else
    {
        diag = $('#diagnosis').val();
    }
    

   $('#diagnosislist').append("<li  class='col-md-12' id='"+diagll+count+"'><span class='col-md-8' id='"+diagll+count+"'>"+diag+"</span><span class='col-md-4'><button type='button' onclick='removefromqueue("+count+")' class='btn bg-red btn-xs waves-effect' data-toggle='tooltip' data-placement='bottom' title='Remove from Queue' ><i class='material-icons'>remove</i></button></span><hr></li>");

    $('#newcat').val("");
    count++;    
}
 
function removefromqueue(xx)
{
    var d = '#diagl' + xx;
    $(d).addClass('hidden');
}

var output= "";
function savecat()
{
     var a = [];
     $('#diagnosislist li').each(function(){
        var z = $(this).text().split(' ');

        for(i = 0; i < z.length; i++)
        {
            if(i > 0)
            {
                output += '' + z[i-1]+" ";
            }
        }
        a.push(output.trim());
        output = '';
    });

           console.log(a);

           swal({
            title: "Unmerge Confinement Causes?",
            text: "You cannot undo this action!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#4CAF50",
            confirmButtonText: "Yes, unmerge it!",
            cancelButtonText: "No",
            closeOnConfirm: false
            }, function () {
                confine.add_groupname(ctrl);
            });
}



