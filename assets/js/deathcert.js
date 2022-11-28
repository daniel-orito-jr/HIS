



var deathcert = {
    

    get_patientlist: function ()
    {
        

         $('#death-cert-table').dataTable().fnDestroy();
        $('#death-cert-table tbody').empty();
        var table = $('#death-cert-table').dataTable({
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
    
        $('#death-cert-table_filter input').unbind();
        $('#death-cert-table_filter input').bind('keyup', function(e) {
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
        var doc =  $('#txtdeathcertname').val();
        $('#txtdeathcertrevby').val(doc);
       
    },
    
     get_corpse_disposal: function()
{
     var cmbcorpsedisposal = $('#cmbcorpsedisposal').val();
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
     var birthtype = $('#cmbbirthtype').val();
     if(birthtype === "Others")
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

get_birth_order: function ()
{
     var birthorder = $('#cmbmultiplebirth').val();
     if(birthorder === "Others")
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

importdata : function()
    {
        
       
        var fname = $('#death-cert-form input[name=txtfname]').val();
        var mname = $('#death-cert-form input[name=txtmname]').val();
        var lname = $('#death-cert-form input[name=txtlname]').val();
        var death = $('#death-cert-form input[name=txtdeathdate]').val();
//        var expiredStr =death[1]+ "-" + death[2] + "-" + death[0]  ;
        var placeofdeath = $('#death-cert-form input[name=txtdeathplace]').val();
        var cemetery = $('#txtcemeteryname').val();   
        
        var attend = $("input[name='attended']:checked").val();
         
        if(attend === "attended")
            {
                $("#optionsattend").attr('checked', 'checked');
                
            }
        else 
            {
                $("#optionsunattend").attr('checked','checked');
            }
         var cause = $('#death-cert-form input[name=txtdeathimmediatecause]').val();     

    var currentMonth = moment(new Date).format('MMMM');
    var currentYear = moment(new Date).format('YYYY');
    var currentDay = moment(new Date).format('Do');
 
        var reviewedby = $('#death-cert-form input[name=txtdeathcertrevby]').val();     
        
        $('#death-cert-form input[name=txtaffdiedname]').val(fname+' '+mname+' '+lname);
        $('#death-cert-form input[name=txtaffdieddate]').val(death);
        $('#death-cert-form input[name=txtaffdiedaddr]').val(placeofdeath);
        $('#death-cert-form input[name=affburiedadd]').val(cemetery);
        $('#death-cert-form input[name=txtaffcod]').val(cause);
        $('#death-cert-form input[name=txtaffmonth]').val(currentMonth);
        $('#death-cert-form input[name=txtaffday]').val(currentDay);
        $('#death-cert-form input[name=txtaffyear]').val(currentYear);
        $('#death-cert-form input[name=affattendedby]').val(reviewedby);
      
        
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
                $('#death-cert-form input[name=txtcaseno]').val(data.details["caseno"]);
                $('#death-cert-form input[name=txtfname]').val(data.details["fname"]);
                $('#death-cert-form input[name=txtmname]').val(data.details["mname"]);
                $('#death-cert-form input[name=txtlname]').val(data.details["lname"]);
                
               
                switch(data.details["sex"]){
                    case "Female":
//                        $('#optionFemale').attr("checked",true);
                        $("#optionFemale").prop( "selected", 'true' );
//                        $("#cmbgender").val("Female");
                       
                        
                       
                        break;
                    case "Male":
//                        $('#optionMale').attr("checked",true);
                        $("#optionMale").prop( "selected", 'true' );
//                        $("#optionMale").val("Male");
//                          $("#cmbgender").val("Male");
                       
                        break;
                }
             
                var civil = data.details["civilstatus"].toUpperCase();
//                alert(civil);
                if( civil === "SINGLE")
                {
                    $("#optionSingle").prop( "selected", true );
                }
                else if(civil === "MARRIED")
                {
                     $("#optionMarried").prop( "selected", true );
                }
                else if(civil === "WIDOW")
                {
                    $("#optionWidow").prop( "selected", true );
                }
                else if(civil === "WIDOW/ER")
                {
                    $("#optionWidower").prop( "selected", true );
                }
                else if(civil === "ANNULLED")
                {
                    $("#optionAnnulled").prop( "selected", true );
                }
                else
                {
                    $("#optionDivorced").prop( "selected", true );
                }
                
//                var bday = data.details["bday"].split("-");
                var bdayStr = moment(data.details["bday"]).format("dddd D MMM  YYYY"); 
                $('#death-cert-form input[name=txtbirthdate]').val(bdayStr);
                
                
//                var bdayStr =bday[0]+ "-" + bday[1] + "-" + bday[2]  ;
                
                
//                var death = data.details["expireddate"].split("-");
                var expiredStr = moment(data.details["expireddate"]).format("dddd D MMM  YYYY")
//                var expiredStr =death[0]+ "-" + death[1] + "-" + death[2]  ;
                $('#death-cert-form input[name=txtdeathdate]').val(expiredStr);
                $('#death-cert-form input[name=txtdeathtime]').val(data.details["expiredtime"]);
                
               
                $('#death-cert-form input[name=txtdeathplace]').val(data.profile["compname"]+','+data.profile["compadrs"]+','+data.profile["compcity"]+','+data.profile["compprovince"]);
                $('#death-cert-form input[name=txtcitizenship]').val(data.details["nationality"]);
                $('#death-cert-form input[name=txtresidence]').val(data.details["adrs"]+','+data.details["brgy"]+','+data.details["cityadd"]+','+data.details["provadd"]);
                $('#death-cert-form input[name=txtreligion]').val(data.details["religion"]);
                
                //
                var bday = data.details["bday"].split("-");
                var bdayStrx =bday[0]+ "-" + bday[1] + "-" + bday[2]  ;
                var mdate = bdayStrx;
                var yearThen = parseInt(mdate.substring(0,4), 10);
                var monthThen = parseInt(mdate.substring(5,7), 10);
                var dayThen = parseInt(mdate.substring(8,10), 10);

                var death = data.details["expireddate"].split("-");
                var expiredStr =death[0]+ "-" + death[1] + "-" + death[2]  ; 
               var ddate = expiredStr;
                var dyearThen = parseInt(ddate.substring(0,4), 10);
                var dmonthThen = parseInt(ddate.substring(5,7), 10);
                var ddayThen = parseInt(ddate.substring(8,10), 10);

                var today = new Date(dyearThen, dmonthThen-1, ddayThen);
                var birthday = new Date(yearThen, monthThen-1, dayThen);

                var differenceInMilisecond = today.valueOf() - birthday.valueOf();

                var year_age = Math.floor(differenceInMilisecond / 31536000000);
                var day_age = Math.floor((differenceInMilisecond % 31536000000) / 86400000);

//                if ((today.getMonth() === birthday.getMonth()) && (today.getDate() === birthday.getDate())) {
//                    alert("Happy B'day!!!");
//                }

                var month_age = Math.floor(day_age/30);

                day_age = day_age % 30;

                if (isNaN(year_age) || isNaN(month_age) || isNaN(day_age)) {
               
                }
                else {
                  
                  if(year_age > 1)
                  {
                      $('#death-cert-form input[name=txtageyears]').val(year_age);
                      $('#death-cert-form input[name=txtmonths]').val('0');
                      $('#death-cert-form input[name=txtdays]').val('0');
                      $('#death-cert-form input[name=txthours]').val('0');
                      $('#death-cert-form input[name=txtminsec]').val('0');
                  }
                  else
                  {
                      $('#death-cert-form input[name=txtageyears]').val('0');
                      $('#death-cert-form input[name=txtmonths]').val(month_age);
                      $('#death-cert-form input[name=txtdays]').val(day_age);
                      $('#death-cert-form input[name=txthours]').val('0');
                      $('#death-cert-form input[name=txtminsec]').val('0');
               
                  }
              }
            var fname = $('#death-cert-form input[name=txtfname]').val();
            var mname = $('#death-cert-form input[name=txtmname]').val();
            var lname = $('#death-cert-form input[name=txtlname]').val();
            $('#death-cert-form input[name=txtemabalmedpatient]').val(fname+' '+mname+' '+lname);
              $('#death-cert-form input[name=txtdeathimmediatecause]').val(data.cause["diagnosis"]);
              $('#death-cert-form input[name=txtdeathantecedentcause]').val(data.cause["diagnosis"]);
              $('#death-cert-form input[name=txtdeathunderlyingcause]').val(data.cause["diagnosis"]);
              $('#death-cert-form input[name=txtdeathsigcondition]').val(data.cause["diagnosis"]);
             

            } 
            else 
            {
                swal("Fail!","Fail to add record.","error");
            }
        });
    },
    
    cancel : function()
    {
         $('#death-cert-form input[type="text"]').each(function(){
            this.value = "";
              swal("Success!","Cancelled!","success");
            });
            
        
    },
    
    validate_form : function(){
        var itemcount = 0;
        var totalDivCount= $('#death-cert-form input[type="text"]').length;
        
        $('#death-cert-form input[type="text"]').each(function(){
            if(this.value === "")
            {
                $("#death-cert-form input[name="+this.name+"]").parents(".form-line").addClass("focused").addClass("error");
            }
            else
            {
                itemcount++;
                $("#death-cert-form input[name="+this.name+"]").parents(".form-line").addClass("focused").addClass("success");
            }
        });

       console.log(itemcount);
        if(itemcount === totalDivCount-15 || itemcount ===totalDivCount)
        {
            deathcert.add_death_info();
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
        url:  BASE_URL + "user/add_death_info",
        data: $('#death-cert-form').serialize(),
        dataType: 'json'
        }).done(function(data) {
            console.log(data);
            if (data.status) 
            {
                $('#death-cert-form input[type="text"]').each(function(){
            this.value = "";

            });
            
            $('#death-cert-form textarea').each(function(){
            this.value = "";

            });
//                swal("Success!","New Record Added","success");
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
//                  swal("Deleted!", "Your imaginary file has been deleted.", "success");
//                        $.ajax({
//                        type: 'POST',
//                            url:  BASE_URL + "controls/death_certificate_report",
//                        
//                            }).done(function(data)
//                            {
//                                 swal("Success!","Report Generated","success");
//                            });
                var casenox =  $('#death-cert-form input[name=txtcaseno]').val();
                    window.open(BASE_URL + "user/death_certificate_report/"+casenox,'_blank');

        
                });
            } 
            else 
            {
                swal("Fail!","Fail to add record.","error");
            }
        });
    },
    
    getval : function()
    {
        
    }



}    
  
$('#death-cert-table').on('dblclick', 'td', function () {
    var current_row = $(this).parents('tr');//Get the current row
    if (current_row.hasClass('child')) {//Check if the current row is a child row
        current_row = current_row.prev();//If it is, then point to the row before it (its 'parent')
    }
    
    var data = $('#death-cert-table').dataTable().fnGetData(current_row);
    
    deathcert.get_pat_details(data);


     
    
});

