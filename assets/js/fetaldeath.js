



var fetaldeath = {
    

    get_patientlist: function ()
    {
        

        $('#fetal-cert-table').dataTable().fnDestroy();
        $('#fetal-cert-table tbody').empty();
        var table = $('#fetal-cert-table').dataTable({
             dom: 'frtip',
            processing:true,  
            serverSide:true, 
            order:[],
            pageLength:5,
            
            
            ajax:{  
                url:BASE_URL + "user/get_pats",
                type:"POST",
               
            },
           
            
        });
    
        $('#fetal-cert-table_filter input').unbind();
        $('#fetal-cert-table_filter input').bind('keyup', function(e) {
            if(e.keyCode === 13) {
            table.fnFilter(this.value);	
            }
        });
    },
    
    get_death_manner : function ()
{

    var deathmanner = $('#cmbdeathmanner').val();
    // alert(deathmanner);

    if(deathmanner === "Others")
    {
        $('#txtdeathmanner').removeAttr('disabled',true);
        $('#txtdeathmanner').focus();
        $('#txtdeathmanner').val('');
    }
    else
    {
        $( "#txtdeathmanner" ).prop( "disabled", true );
        $('#txtdeathmanner').val('N/A');

    }
},

 get_death_place: function()
{

    var deathplace = $('#cmbdeathplacex').val();
   // alert(deathplace);

    if(deathplace === "Others")
    {
        $('#txtdeathplacex').removeAttr('disabled',true);
        $('#txtdeathplacex').focus();
        $('#txtdeathplacex').val('');
    }
    else
    {
        $( "#txtdeathplacex" ).prop( "disabled", true );
        $('#txtdeathplacex').val('N/A');

    }
},
  
   get_attendant: function()
{

    var attendantx = $('#attendant').val();
   // alert(deathplace);

    if(attendantx === "Others")
    {
        $('#txtattendant').removeAttr('disabled',true);
        $('#txtattendant').focus();
        $('#txtattendant').val('');
    }
    else
    {
        $( "#txtattendant" ).prop( "disabled", true );
        $('#txtattendant').val('N/A');

    }
},
 reviewedby : function()
    {
        var doc =  $('#cofdname').val();
        $('#cofdreviewedby').val(doc);
       
    },
    
     get_corpse_disposal: function()
{
     var cmbcorpsedisposal = $('#disposal').val();
     if(cmbcorpsedisposal === "Others")
    {
        $('#txtcorpsedisposal').removeAttr('disabled',true);
        $('#txtcorpsedisposal').focus();
        $('#txtcorpsedisposal').val('');
    }
    else
    {
        $( "#txtcorpsedisposal" ).prop( "disabled", true );
        $('#txtcorpsedisposal').val('Others');

    }
    },
            
    get_birth_type: function ()
{
     var deltype = $('#dltype').val();
     if(deltype === "Others")
    {
        $('#txtbirthtype').removeAttr('disabled',true);
        $('#txtbirthtype').focus();
        $('#txtbirthtype').val('');
    }
    else
    {
        $( "#txtbirthtype" ).prop( "disabled", true );
        $('#txtbirthtype').val('Others');

    }
},

get_multiple_order: function ()
{
     var multiple = $('#dlorder').val();

     if(multiple === "Others")
    {
        $('#txtmultiplebirth').removeAttr('disabled',true);
        $('#txtmultiplebirth').focus();
        $('#txtmultiplebirth').val('');
    }
    else
    {
        $( "#txtmultiplebirth" ).prop( "disabled", true );
         $('#txtmultiplebirth').val('Others');

    }
},

get_birth_order: function ()
{
     var birthorder = $('#birthorder').val();

     if(birthorder === "Others")
    {
        $('#txtbirthorder').removeAttr('disabled',true);
        $('#txtbirthorder').focus();
        $('#txtbirthorder').val('');
    }
    else
    {
        $( "#txtbirthorder" ).prop( "disabled", true );
         $('#txtbirthorder').val('Others');

    }
},

importdata : function()
    {
        
       
        var fname = $('#fetal-cert-form input[name=ffnInput]').val();
        var mname = $('#fetal-cert-form input[name=fmnInput]').val();
        var lname = $('#fetal-cert-form input[name=flnInput]').val();

        var placeofdeath = $('#fetal-cert-form input[name=dlPLace]').val();
        var cemetery = $('#cemeteryaddr').val();   
        
        var attend = $("input[name='cofdattended']:checked").val();
         
         alert(attend);
         
        if(attend === "attended")
            {
                $("#optionsattend").prop('checked', 'checked');
                
            }
        else 
            {
                $("#optionsunattend").prop('checked','checked');
            }
         var cause = $('#fetal-cert-form input[name=acause]').val();     

        var currentMonth = moment(new Date).format('MMMM');
        var currentYear = moment(new Date).format('YYYY');
        var currentDay = moment(new Date).format('Do');
 
        var reviewedby = $('#fetal-cert-form input[name=cofdreviewedby]').val();     
        
        $('#fetal-cert-form input[name=txtaffdiedname]').val(fname+' '+mname+' '+lname);
        $('#fetal-cert-form input[name=txtaffdiedaddr]').val(placeofdeath);
        $('#fetal-cert-form input[name=affburiedadd]').val(cemetery);
        $('#fetal-cert-form input[name=txtaffcod]').val(cause);
        $('#fetal-cert-form input[name=txtaffmonth]').val(currentMonth);
        $('#fetal-cert-form input[name=txtaffday]').val(currentDay);
        $('#fetal-cert-form input[name=txtaffyear]').val(currentYear);
        $('#fetal-cert-form input[name=affattendedby]').val(reviewedby);
      
        
    },
    
    get_pat_details : function(data){
        
    
        $.ajax({
        type: 'POST',
        url:  BASE_URL + "user/get_details",
        data: {caseno : data[0]},
        dataType: 'json'
        }).done(function(data) {
            console.log(data);
            if (data.status) 
            {
                 swal("Success!","Imported!","success");
//                console.log(data.details["fname"]);
                $('#fetal-cert-form input[name=txtcaseno]').val(data.details["caseno"]);
                $('#fetal-cert-form input[name=ffnInput]').val(data.details["fname"]);
                $('#fetal-cert-form input[name=fmnInput]').val(data.details["mname"]);
                $('#fetal-cert-form input[name=flnInput]').val(data.details["lname"]);
                
               
                switch(data.details["sex"]){
                    case "Female":
                        $("#optionFemale").prop( "selected", 'true' );
                        break;
                    case "Male":
                        $("#optionMale").prop( "selected", 'true' );
                        break;
                    case "Undetermined":
                        $("#optionUnder").prop( "selected", 'true' );
                        break;
                }
                
                var fname = $('#fetal-cert-form input[name=txtfname]').val();
                var mname = $('#fetal-cert-form input[name=txtmname]').val();
                var lname = $('#fetal-cert-form input[name=txtlname]').val();
                $('#fetal-cert-form input[name=txtemabalmedpatient]').val(fname+' '+mname+' '+lname);
                  $('#fetal-cert-form input[name=txtdeathimmediatecause]').val(data.cause["diagnosis"]);
                  $('#fetal-cert-form input[name=txtdeathantecedentcause]').val(data.cause["diagnosis"]);
                  $('#fetal-cert-form input[name=txtdeathunderlyingcause]').val(data.cause["diagnosis"]);
                  $('#fetal-cert-form input[name=txtdeathsigcondition]').val(data.cause["diagnosis"]);
            } 
            else 
            {
                swal("Fail!","Fail to add record.","error");
            }
        });
    },
    
    cancel : function()
    {
         $('#fetal-cert-form input[type="text"]').each(function(){
            this.value = "";
              swal("Success!","Cancelled!","success");
            });
    },
    
    validate_form : function(){
     
//          fetaldeath.add_death_info();
        var itemcount = 0;
        var totalDivCount= $('#fetal-cert-form input[type="text"]').length;
         console.log(totalDivCount);
        $('#fetal-cert-form input[type="text"]').each(function(){
            if(this.value === "")
            {
                $("#fetal-cert-form input[name="+this.name+"]").parents(".form-line").addClass("focused").addClass("error");
            }
            else
            {
                itemcount++;
                $("#fetal-cert-form input[name="+this.name+"]").parents(".form-line").addClass("focused").addClass("success");
            }
        });

       console.log(itemcount);
        if(itemcount === totalDivCount-15 || itemcount ===totalDivCount)
        {
            fetaldeath.add_death_info();
        }
        else
        {
            swal(
                    'Incomplete Form',
                    'Please complete all the required information! Input "N/A" if not applicable! Thank you!',
                    'error' 
                    );
        }
    },
    
    add_death_info : function(){
        
       
        $.ajax({
        type: 'POST',
        url:  BASE_URL + "user/add_fetal_death_info",
        data: $('#fetal-cert-form').serialize(),
        dataType: 'json'
        }).done(function(data) {
            console.log(data);
            if (data.status) 
            {
                $('#fetal-cert-form input[type="text"]').each(function(){
            this.value = "";

            });
            
            $('#fetal-cert-form textarea').each(function(){
            this.value = "";

            });
            
                swal({
                  title: "Success",
                  text: "New Record Added!",
                  type: "success",
                  showCancelButton: false,
                  confirmButtonClass: "btn-success",
                  confirmButtonText: "Generate Report!",
                  closeOnConfirm: true
                },
                function(){
                var casenox =  $('#fetal-cert-form input[name=txtcaseno]').val();
                    window.open(BASE_URL + "user/fetal_death_certificate_report/"+casenox,'_blank');
                });
            } 
            else 
            {
                swal("Fail!","Fail to add record.","error");
            }
        });
    },
    
  
    

}    
  
$('#fetal-cert-table').on('dblclick', 'td', function () {
    var current_row = $(this).parents('tr');//Get the current row
    if (current_row.hasClass('child')) {//Check if the current row is a child row
        current_row = current_row.prev();//If it is, then point to the row before it (its 'parent')
    }
    
    var data = $('#fetal-cert-table').dataTable().fnGetData(current_row);
    
    fetaldeath.get_pat_details(data);


     
    
});

