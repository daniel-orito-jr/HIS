var user = {
    validateError : function(error){
        var has_error = false;
        if (error !== undefined && error !== "") {
            has_error = true;
        }
        return has_error;
    },
    
    validate_log_in : function(){
        var uname = $('#sign-in-form input[name=username]');
        var pass = $('#sign-in-form input[name=password]');
        var error = 0;
        
        if (uname.val() === "") {
            uname.parents('.form-line').removeClass('error success').addClass('error');
            uname.parents('.input-group').find('label').text('Please insert username!');
            error++;
        }else{
            uname.parents('.form-line').removeClass('error success').addClass('success');
            uname.parents('.input-group').find('label').text('');
        }
        
        if (!pass.val()) {
            pass.parents('.form-line').removeClass('error success').addClass('error');
            pass.parents('.input-group').find('label').text('Please insert password!');
            error++;
        }else{
            pass.parents('.form-line').removeClass('error success').addClass('success');
            pass.parents('.input-group').find('label').text('');
        }
//        
        if (error == 0) {
            user.login();
        
        }
    },
    
    modify_password : function (passx,usernamex)
    {
           $.ajax({
            type: 'POST',
            url:  BASE_URL + "user/update_password",
            data: {pass:passx,username:usernamex},
            dataType: 'json'
        }).done(function(data) {
       
            
            if (data.status) {
             
                swal({
                    title: "Password Modified!",
                    text: "Please log in again with your updated acount.",
                    type: "success"
                }, function() {
                    window.location.href =  BASE_URL + "user/sign_out";
                });
            } else {
                  swal("error","Error in updating password! Please try again!","error");
            }
        });

    },
    
    check_pass_validity : function(lastupdate,username,medicalphic,adminsys)
    {
        var upd = moment(lastupdate).format('l');
        var now = moment().format('l');
 
    
        var date1 = new Date(upd);
        var date2 = new Date(now);
        var timeDiff = Math.abs(date2.getTime() - date1.getTime());
        var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24)); 
       

        if(diffDays > 15)
        {
      
            swal({
            title: "",
            text: "Your password is more than 15 days already.\n\
                    Your account is in high risk and may compromise your security. \n \n\
                    Would you like to change your password now?",
            type: "warning",
            showCancelButton: true,
            confirmButtonText: "No",
            cancelButtonText: "Yes",
            closeOnConfirm: false,
            closeOnCancel: false,
        },
          function(isConfirm) {
            if (isConfirm) {
                alert(adminsys);
                if(medicalphic === '1' && adminsys !== '1')
                {
                    window.location.href =  BASE_URL + "user/mandadailycensus";  
                }
                else
                {
                    window.location.href =  BASE_URL + "Dashboard";  
                }
         
//                     
          
            } else {
              
                swal.close();
                $('#newpword').modal('show');
            
                
            }
        });
    }
    else
    {
        window.location.href =  BASE_URL + "Dashboard";  
    }
    },
    first_modify_accnt : function ()
    {
        var form_pass = $('#first-modify-accnt-form input[name=pword]').val();
        var form_passconf = $('#first-modify-accnt-form input[name=pwordconf]').val();
         
            
        if(form_pass === form_passconf)
        {
            $.ajax({
            type: 'POST',
            url:  BASE_URL + "user/update_pword",
            data: $('#first-modify-accnt-form').serialize(),
            dataType: 'json'
        }).done(function(data) {
           
            
            if (data.status) {
                $("#newpword").modal("hide");
                swal({
                    title: "Account Modified!",
                    text: "Please log in again with your updated acount.",
                    type: "success"
                }, function() {
                    window.location.href =  BASE_URL + "user/sign_out";
                });
            } else {
                
                swal({
                    title: "Error!",
                    text: "Error in saving your password. Please try again!",
                    type: "error"
                });
                
            }
        });
        }
        else
        {
             swal({
                    title: "Password Error!",
                    text:  "Password and Confirm password don't match.",
                    type: "warning"
                });
        }
//        
    },
    
    login : function(){
//        alert('asdfd');
        $.ajax({
            type: 'POST',
            url:  BASE_URL + "user/sign_in",
            data: $('#sign-in-form').serialize(),
            dataType: 'json'   
        }).done(function(data) {
//            console.log(data);
            if (data.status) {
                user.check_pass_validity(data.user['updated'],data.user['EmpID'],data.user['medicalphic'],data.user['Adminsys']);
            } else {
                var form_username = $('#sign-in-form input[name=username]');
                var form_password = $('#sign-in-form input[name=password]');
                if (data.error_acct) {
                    form_username.parents('.form-line').removeClass('error success').addClass('error');
                    form_username.parents('.input-group').find('label').text('Account does not exist!');
                    
                    form_password.parents('.form-line').removeClass('error success').addClass('error');
                    form_password.parents('.form-line').find('small').text('');
                }else{
                    if (data.error_access) {
                        form_username.parents('.form-line').removeClass('error success').addClass('error');
                        form_username.parents('.input-group').find('label').text('Access denied!');

                        form_password.parents('.form-line').removeClass('error success').addClass('error');
                        form_password.parents('.form-line').find('small').text('');
                    }else{
                        form_username.parents('.form-line').removeClass('error success').addClass('success');
                        form_username.parents('.input-group').find('label').text('');

                        if (data.error_pass) {
                            form_password.parents('.form-line').removeClass('error success').addClass('error');
                            form_password.parents('.input-group').find('label').text('Password in incorrect!');
                        }else{
                            form_password.parents('.form-line').removeClass('error success').addClass('success');
                            form_password.parents('.input-group').find('label').text('');
                        }
                    }
                }
            }
        });
    },
    
    search_phic_census : function(){
        var s_date = $('#search-phic-form input[name = start_date]');
        var e_date = $('#search-phic-form input[name = end_date]');
        var error = 0;
        
//        alert(s_date.val());
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
            load_script("http://192.168.2.111:3777/drainwizv2/assets/vendors/js/responsive.js",0,0);
        }
    },
    
    search_ipd_census : function(){
        var s_date = $('#search-patType-form input[name = start_date]');
        var e_date = $('#search-patType-form input[name = end_date]');
        var error = 0;
        
//        alert(s_date.val());
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
            load_script("http://192.168.2.111:3777/drainwizv2/assets/vendors/js/responsive.js",1,0);
        }
    },
    
    search_doctor_census : function(){
        var s_date = $('#search-doctor-form input[name = start_date]');
        var e_date = $('#search-doctor-form input[name = end_date]');
        var error = 0;
        
//        alert(s_date.val());
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
            load_script("http://192.168.2.111:3777/drainwizv2/assets/vendors/js/responsive.js",2,0);
        }
    },
    
    search_pat_census : function(){
        var s_date = $('#search-pat-form input[name = start_date]');
        var e_date = $('#search-pat-form input[name = end_date]');
        var error = 0;
        
//        alert(s_date.val());
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
//            alert("jiasdf");
            load_script("http://192.168.2.111:3777/drainwizv2/assets/vendors/js/responsive.js",3,0);
        }
    },
    
    search_class_census : function(){
        var s_date = $('#search-class-form input[name = start_date]');
        var e_date = $('#search-class-form input[name = end_date]');
        var error = 0;
        
//        alert(s_date.val());
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
//            alert("jiasdf");
            load_script("http://192.168.2.111:3777/drainwizv2/assets/vendors/js/responsive.js",4,0);
        }
    },
    
    search_approved_ticket : function(){
        
        var s_date = $('#approved-ticket-form input[name = start_date]');
        var error = 0;
        
//        alert(s_date.val());
        if (s_date.val() == "") {
            s_date.parents('.form-line').removeClass('error success').addClass('error');
            s_date.parents('.input-group').find('small').text('Please select a start date!');
            error++;
        }else{
            s_date.parents('.form-line').removeClass('error success').addClass('success');
            s_date.parents('.input-group').find('small').text('');
        }
        
        
        if (error === 0) {
//            alert("jiasdf");
            load_script("http://192.168.2.111:3777/drainwizv2/assets/vendors/js/responsive.js",8,0);
        }
    },
    
    search_adpat_census : function(){
        var s_date = $('#search-adpat-form input[name = start_date]');
        var e_date = $('#search-adpat-form input[name = end_date]');
        var error = 0;
        
        $('#diss2').addClass('hidden');
        $('#diss').removeClass('hidden');
        $('#add2').addClass('hidden');
        $('#add').removeClass('hidden');

        
//        alert(s_date.val());
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
//            alert("jiasdf");
            load_script("http://192.168.2.111:3777/drainwizv2/assets/vendors/js/responsive.js",5,0);
        }
    },
    
    search_ros_census : function(){
        var s_date = $('#search-ros-form input[name = date]');
        var error = 0;
        
//        alert(s_date.val());
        if (s_date.val() == "") {
            s_date.parents('.form-line').removeClass('error success').addClass('error');
            s_date.parents('.input-group').find('small').text('Please select a start date!');
            error++;
        }else{
            s_date.parents('.form-line').removeClass('error success').addClass('success');
            s_date.parents('.input-group').find('small').text('');
        }
        
        if (error === 0) {
//            alert("jiasdf");
            load_script("http://192.168.2.111:3777/drainwizv2/assets/vendors/js/responsive.js",6,0);
        }
    },
    
    search_records : function(type){
        var s_date = $('#search-record-form input[name = start_date]');
        var e_date = $('#search-record-form input[name = end_date]');
        var error = 0;
        
//        alert(s_date.val());
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
            load_script("http://192.168.2.111:3777/drainwizv2/assets/vendors/js/responsive.js",type,0);
            
        }
        

    },
    
    load_records : function(type){
        
        
        $('#largeModal').modal('show');
        $(".report-btn").show();
        
        switch(parseInt(type)){
            case 0:
                var s_date = $('#search-phic-form input[name = start_date]');
                var e_date = $('#search-phic-form input[name = end_date]');
                
                user.get_census_add();
                user.get_census_dis();
                
                $('#search-phic-form input[name = s_date]').val(s_date.val());
                $('#search-phic-form input[name = e_date]').val(e_date.val());    
                break;
            case 1: 
                var s_date = $('#search-patType-form input[name = start_date]');
                var e_date = $('#search-patType-form input[name = end_date]');
                
                user.get_ipd_patients();
                user.get_opd_patients();
                
                $('#search-patType-form input[name = s_date]').val(s_date.val());
                $('#search-patType-form input[name = e_date]').val(e_date.val()); 
                break;
            case 2: 
                var s_date = $('#search-doctor-form input[name = start_date]');
                var e_date = $('#search-doctor-form input[name = end_date]');
                 
                
                 var expertlist = $('#expertlist').val();
               
                user.get_doctors(expertlist);
                
                $('#search-doctor-form input[name = s_date]').val(s_date.val());
                $('#search-doctor-form input[name = e_date]').val(e_date.val());   
                break;
            case 3:
                user.get_all_patients();
                break;
            case 4:
                var s_date = $('#search-class-form input[name = start_date]');
                var e_date = $('#search-class-form input[name = end_date]');
                
                $('#search-class-form input[name = s_date]').val(s_date.val());
                $('#search-class-form input[name = e_date]').val(e_date.val()); 
                
                var doclist = $('#doclist').val();
                var doccodex = doclist.split(':');
                
                var doclistx = $('#doclist_dispo').val();
                var doccodexx = doclistx.split(':');
                
                user.get_patients_classification(doccodex[0]);
                user.get_patients_disposition(doccodexx[0]);
                break;
            case 5: 
                var s_date = $('#search-adpat-form input[name = start_date]');
                var e_date = $('#search-adpat-form input[name = end_date]');
                
                user.get_patients();
                user.get_dis_patients();
                
                $('#search-adpat-form input[name = s_date]').val(s_date.val());
                $('#search-adpat-form input[name = e_date]').val(e_date.val()); 
                break;
            case 6: 
                var s_date = $('#search-ros-form input[name = date]');
                
                user.get_ros_census();
                break;
            case 7:
                user.get_expenses();
                break;
            case 8:
                var s_date = $('#approved-ticket-form input[name = start_date]');
                user.get_approved_ticket_by_date();
                $('#approved-ticket-form input[name = s_date]').val(s_date.val());
                
                break;
            default:
                break;
        }

        $('#largeModal').modal('hide');
    },
    
    under_development : function(){
        swal({
            title: "Sorry!",
            text: "This page is under development.",
            imageUrl: BASE_URL +"assets/img/development.png"
        });
    },
    
    show_date: function(){
        var d = new Date();
        var strDate = d.getFullYear() + "/" + (d.getMonth()+1) + "/" + d.getDate();
        alert(strDate);
    },
    
    search_proofsheets : function (){
        var s_date = $('#search-proofsheet-form input[name = start_date]');
        var e_date = $('#search-proofsheet-form input[name = end_date]');
        var error = 0;
        
        if (s_date.val() == "") {
            s_date.parents('.form-line').removeClass('error success').addClass('error');
            s_date.parents('.input-group').find('small').text('Please select a start date!');
            error++;
        }else{
            if (!s_date.inputmask("isComplete")){
                console.log('Please complte start date.');
                s_date.parents('.form-line').removeClass('error success').addClass('error');
                s_date.parents('.input-group').find('small').text('Incomplete start date!');
                error++;
            }else{
                s_date.parents('.form-line').removeClass('error success').addClass('success');
                s_date.parents('.input-group').find('small').text('');
            }
        }
        
        if (e_date.val() == "") {
            e_date.parents('.form-line').removeClass('error success').addClass('error');
            e_date.parents('.input-group').find('small').text('Please select an end date!');
            error++;
        }else{
            if (!s_date.inputmask("isComplete")){
                console.log('Please complte end date.');
                e_date.parents('.form-line').removeClass('error success').addClass('error');
                e_date.parents('.input-group').find('small').text('Incomplete end date!');
                error++;
            }else{
                e_date.parents('.form-line').removeClass('error success').addClass('success');
                e_date.parents('.input-group').find('small').text('');
            }
        }
        
        if(s_date.val() > e_date.val())
        {
            swal('Error',"Invalid date range",'error');
            error++;
        }
        
        if (error == 0) {
            load_script("http://192.168.2.111:3777/drainwizv2/assets/vendors/js/responsive.js",0,1);
            chart.proofsheet_chart();
        }
    },
    
    get_proofsheets : function(){
        var s_date = $('#search-proofsheet-form input[name = start_date]');
        var e_date = $('#search-proofsheet-form input[name = end_date]');
        $('#largeModal').modal('show');
        
        $.ajax({
            type: 'POST',
            url:  BASE_URL + "user/get_proofsheet",
            data: $('#search-proofsheet-form').serialize(),
            dataType: 'json'
        }).done(function(data) {
//            console.log(data);
            if (data.status) {
                $('#search-proofsheet-form input[name = s_date]').val(data.s_date); 
                $('#search-proofsheet-form input[name = e_date]').val(data.e_date);
                user.load_proofsheets(data);
                
                $('#largeModal').modal('hide');
            } else {
                $('#largeModal').modal('hide');
                if (user.validateError(data.error_s_date)) {
                    s_date.parents('.form-line').removeClass('error success').addClass('error');
                    s_date.parents('.input-group').find('small').html(data.error_s_date);
                }
                
                if (user.validateError(data.error_e_date)) {
                    e_date.parents('.form-line').removeClass('error success').addClass('error');
                    e_date.parents('.input-group').find('small').html(data.error_e_date);
                }
            }
        });
    },
    
    load_proofsheets : function(){
        var s_date = $('#search-proofsheet-form input[name = start_date]');
        var e_date = $('#search-proofsheet-form input[name = end_date]');
        $('#search-proofsheet-form input[name = s_date]').val(s_date.val()); 
        $('#search-proofsheet-form input[name = e_date]').val(e_date.val());
        cash_table = $("#proofsheet-table");
        date_table = $("#date-proofsheet-table");
        $('#largeModal').modal('show');
        $(".report-btn").show();
        user.fetch_proofsheets(cash_table,0);
        user.fetch_proofsheets(date_table,1);
        $('#largeModal').modal('hide');
    },
    
    get_details : function(datex,cashierx){
        $('#largeModal').modal('show');
        $.ajax({
            type: 'POST',
            url:  BASE_URL + "user/get_proofsheet_details/"+0,
            data: {date: datex, cashier: cashierx},
            dataType: 'json'
        }).done(function(data) {
//            console.log(data);
            if (data.status) {
                $('#proofDetails').modal('show');
                $('#proofDetails').find('small').html('Date: ' + datex + '<br>Cashier: ' + cashierx);
                user.load_proof_details(data);
                $('#largeModal').modal('hide');
            } else {
                $('#largeModal').modal('hide');
                swal("error","Error fetching details","error");
            }
        });
    },
    
    get_d_proof_details : function(datex){
//        alert(datex);
        $('#largeModal').modal('show');
        $.ajax({
            type: 'POST',
            url:  BASE_URL + "user/get_proofsheet_details/"+1,
            data: {date: datex},
            dataType: 'json'
        }).done(function(data) {
//            console.log(data);
            if (data.status) {
                $('#proofDetails').modal('show');
                $('#proofDetails').find('small').html('Date: ' + datex);
                user.load_proof_details(data);
                $('#largeModal').modal('hide');
            } else {
                $('#largeModal').modal('hide');
                swal("error","Error fetching details","error");
            }
        });
    },
    
    load_proof_details : function(data){
        var proof_details_table = $('#proofsheet-details-table').DataTable();
        proof_details_table.clear().draw();
        var cred = 0;
        var deb = 0;
        var coa = "";
        var dcr = "";
        
        for (var i = 0; i < data.proof_details.length; i++) {
            cred += parseFloat(data.proof_details[i]['credit']);
            deb += parseFloat(data.proof_details[i]['debit']);
            
        }
        proof_details_table.row.add([
            "",
             "<b><p style='color:green;'> TOTAL </p></b>",
            "<b><p style='color:green;'>"+accounting.format(deb,2)+"</p></b>",
            "<b><p style='color:green;'>"+accounting.format(cred,2)+"</p></b>",
            
        ]).draw(false);
        for (var i = 0; i < data.proof_details.length; i++) {
            if(data.proof_details[i]['coadscr'] === "" || data.proof_details[i]['coadscr'] === null)
            {
                if(data.proof_details[i]['coadscr'] === null)
                {
                    dcr = "";
                }
                else
                {
                    dcr = data.proof_details[i]['coadscr'];
                }
                if(data.proof_details[i]['coa'] === null)
                {
                    coa = "";
                }
                else
                {
                    coa = data.proof_details[i]['coa'];
                }
                proof_details_table.row.add([
                "<b><p style='color:red;'>"+coa+"</p></b>",
                "<b><p style='color:red;'>"+dcr+"</p></b>",
                "<b><p style='color:red;'>"+data.proof_details[i]['debit'].toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,")+"</p></b>",
                "<b><p style='color:red;'>"+data.proof_details[i]['credit'].toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,")+"</p></b>",
                ]).draw(false);
            }
            else
            {
            proof_details_table.row.add([
                data.proof_details[i]['coa'],
                data.proof_details[i]['coadscr'],
                data.proof_details[i]['debit'].toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"),
                data.proof_details[i]['credit'].toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,")
                
                
            ]).draw(false);
            }
        }
    },
    
    search_patients : function(){
        var s_date = $('#search-patients-form input[name = start_date]');
        var e_date = $('#search-patients-form input[name = end_date]');
        var error = 0;
        
        if (s_date.val() == "") {
            s_date.parents('.form-line').removeClass('error success').addClass('error');
            s_date.parents('.input-group').find('small').text('Please select a start date!');
            error++;
        }else{
            if (!s_date.inputmask("isComplete")){
                console.log('Please complte start date.');
                s_date.parents('.form-line').removeClass('error success').addClass('error');
                s_date.parents('.input-group').find('small').text('Incomplete start date!');
                error++;
            }else{
                s_date.parents('.form-line').removeClass('error success').addClass('success');
                s_date.parents('.input-group').find('small').text('');
            }
        }
        
        if (e_date.val() == "") {
            e_date.parents('.form-line').removeClass('error success').addClass('error');
            e_date.parents('.input-group').find('small').text('Please select an end date!');
            error++;
        }else{
            if (!s_date.inputmask("isComplete")){
                console.log('Please complte end date.');
                e_date.parents('.form-line').removeClass('error success').addClass('error');
                e_date.parents('.input-group').find('small').text('Incomplete end date!');
                error++;
            }else{
                e_date.parents('.form-line').removeClass('error success').addClass('success');
                e_date.parents('.input-group').find('small').text('');
            }
        }
        
        if (error == 0) {
            user.get_all_patients();
            
        }
    },
    
    get_all_pat : function(){

        
        var s_date = $('#search-patients-form input[name = start_date]');
        var e_date = $('#search-patients-form input[name = end_date]');
//        $('#largeModal').modal('show');
        
        $.ajax({
            type: 'POST',
            url:  BASE_URL + "user/get_patients",
            data: $('#search-patients-form').serialize(),
            dataType: 'json'
        }).done(function(data) {
//            console.log(data);
            
            var limit = 500;
            var a_loop = data.a_count/limit;
            var d_loop = data.d_count/limit;
            
            a_loop = (a_loop%1 !== 0) ?  parseInt(a_loop)+1 : parseInt(a_loop);
            d_loop = (d_loop%1 !== 0) ?  parseInt(d_loop)+1 : parseInt(d_loop);
            
            var loop_a = true;
            var a_offset = 1;
            
            var patients_table = $('#all-patient-table').DataTable();
            patients_table.clear().draw();
            
            var getdata_a = setInterval(function() {
//                console.log("offset "+a_offset);
//                console.log("loop left "+d_loop);
                
////                while(loop_a){
                    if(d_loop !== 0){
                        var t = user.get_patients(data,1,a_offset);
                        
                        if(t.success()){
                            t.success(function (data) {
                                user.load_patients(data,patients_table);
//                                console.log('sooooo');
                                d_loop--;
                                a_offset += 500;
                            });
                        }
                    }else{
                         clearInterval(getdata_a);
                    alert("done");
                    }
//                    
////                    if (a_loop === 0) {
////                        loop_a = false;
////                    }
////                }
//                
//
            }, 1000);
            
            
//            var offset = 1;
//            var getdata_a = setInterval(function() {
//                console.log(offset);
//                a++;
//
//                if (a == 10) {
//                    clearInterval(getdata_a);
//                }
//
//            }, 1000);
//            
//             var getdata_d = setInterval(function() {
//                console.log(offset);
//                a++;
//
//                if (a == 10) {
//                    clearInterval(getdata_d);
//                }
//
//            }, 1000);
//            
            
//            if (data.status) {
//                $('#search-patients-form input[name = s_date]').val(data.s_date); 
//                $('#search-patients-form input[name = e_date]').val(data.e_date);
//                user.load_patients(data);
//                
//                $('#largeModal').modal('hide');
//            } else {
//                $('#largeModal').modal('hide');
//                if (user.validateError(data.error_s_date)) {
//                    s_date.parents('.form-line').removeClass('error success').addClass('error');
//                    s_date.parents('.input-group').find('small').html(data.error_s_date);
//                }
//                
//                if (user.validateError(data.error_e_date)) {
//                    e_date.parents('.form-line').removeClass('error success').addClass('error');
//                    e_date.parents('.input-group').find('small').html(data.error_e_date);
//                }
//                
//            }
        });
    },
    
    get_patients : function(){
        
        var datex =  $('#search-adpat-form input[name=start_date]').val();
        $('#admit').html(moment(datex).format('LL'));
        $('#admitted-table').dataTable().fnDestroy();
        var dataTable = $('#admitted-table').dataTable({  
            dom: 'frtip',
            processing:true,  
            serverSide:true, 
            responsive: true,
            order:[],  
            ajax:{  
                url:BASE_URL + "user/fetch_patients/" + 0, 
                type: 'POST',
//                data: $('#search-record-form').serialize()
                data: { 
                    start_date : $('#search-adpat-form input[name=start_date]').val(), 
                    end_date : $('#search-adpat-form input[name=end_date]').val()
                }
            } 
        });
        
        $('#admitted-table_filter input').unbind();
        $('#admitted-table_filter input').bind('keyup', function(e) {
            if(e.keyCode == 13) {
            dataTable.fnFilter(this.value);	
            }
        });
    },
    
    get_dis_ad_summary: function ()
    {
        $.ajax({
            type: 'POST',
            url:  BASE_URL + "user/get_dis_ad_summary",
            dataType: 'json'
        }).done(function(data1) 
        {
//            console.log(data1);
            if (data1.status) 
            {
                $('#summary-disadd-table').dataTable().fnDestroy();
                var summary_disadd_table = $('#summary-disadd-table').DataTable({
                    paging:false,
                    searching:false,
                    processing:true, 
                    order: [[ 0, "desc" ]],
                    info:false,
                    columnDefs: [
                    {
                        targets:[0],
                        visible:false
                    }
                    ],
                });
                
                summary_disadd_table.clear();
               
                if(data1.disad_summary.length > 0)
                    {
                       for (var i = 0; i < data1.disad_summary.length; i++) 
                       {
                           var first_date = moment(data1.disad_summary[i]["datexx"]).format('MMMM YYYY');
                           summary_disadd_table.row.add(
                            [
//                      
                                data1.disad_summary[i]["datexx"],
                                first_date,
                                data1.disad_summary[i]["phicad"] ,
                                data1.disad_summary[i]["nonad"],
                                data1.disad_summary[i]["phicdis"] ,
                                data1.disad_summary[i]["nondis"]
                                
                            ]   
                            ).draw(false);
                        }
                    }
                    else
                    {
                        $('#summary-disadd-table').dataTable().fnDestroy();
                        var summary_disadd_table = $('#summary-disadd-table').DataTable();
                        summary_disadd_table.clear();
                    }
                } 
                else 
                {
                    console.log('fail');
                }
            });
    },
   
    
    get_doctors : function(expertise){
        $('#doctor-table').dataTable().fnDestroy();
        var dataTable = $('#doctor-table').dataTable({  
                dom: 'frtip',
                processing:true,  
                serverSide:true, 
//                responsive: true,
                 columnDefs: [
                    {
                        targets:[0],
                        visible:false
                    }
                    ],
                order:[],  
                ajax:{  
                    url:BASE_URL + "user/fetch_doctors",  
                    type:"POST",
                    data: { 
                        start_date : $('#search-doctor-form input[name=start_date]').val(), 
                        end_date : $('#search-doctor-form input[name=end_date]').val(),
                        expert:expertise
                        
                    }
                }
            });
            
        $('#doctor-table_filter input').unbind();
        $('#doctor-table_filter input').bind('keyup', function(e) {
            if(e.keyCode == 13) {
            dataTable.fnFilter(this.value);	
            }
        });
    },
    
    search_expertise : function()
    {
         var expertlist = $('#expertlist').val();
    
         user.get_doctors(expertlist);
    },
    
    get_dis_patients : function(){
        $('#discharged-table').dataTable().fnDestroy();
        var dataTable = $('#discharged-table').dataTable({  
                dom: 'frtip',
                processing:true,  
                serverSide:true, 
                responsive: true,
                order:[],  
                ajax:{  
                    url:BASE_URL + "user/fetch_patients/" + 1,
                    type:"POST",
                    data: { 
                        start_date : $('#search-adpat-form input[name=start_date]').val(), 
                        end_date : $('#search-adpat-form input[name=end_date]').val()
                    }
                } 
            });
            
        $('#discharged-table_filter input').unbind();
        $('#discharged-table_filter input').bind('keyup', function(e) {
            if(e.keyCode == 13) {
            dataTable.fnFilter(this.value);	
            }
        });
    },
    
    get_ipd_patients : function(){
        $('#dis-adm-table').dataTable().fnDestroy();
        var table = $('#dis-adm-table').dataTable({
            dom: 'frtip',
            processing:true,  
            serverSide:true, 
            responsive: true,
            order:[],  
            ajax:{  
                url:BASE_URL + "user/fetch_ipd_patients",
                type:"POST",
                data: { 
                    start_date : $('#search-patType-form input[name=start_date]').val(), 
                    end_date : $('#search-patType-form input[name=end_date]').val()
                }
            } 
        });
        
        $('#dis-adm-table_filter input').unbind();
        $('#dis-adm-table_filter input').bind('keyup', function(e) {
            if(e.keyCode == 13) {
            table.fnFilter(this.value);	
            }
        });
    },
    
    get_opd_patients : function(){
        $('#opd-table').dataTable().fnDestroy();
        var table = $('#opd-table').dataTable({
             dom: 'frtip',
            processing:true,  
            serverSide:true, 
            responsive: true,
            order:[],  
            ajax:{  
                url:BASE_URL + "user/fetch_opd_patients",
                type:"POST",
                data: { 
                    start_date : $('#search-patType-form input[name=start_date]').val(), 
                    end_date : $('#search-patType-form input[name=end_date]').val()
                }
            } 
        });
        $('#opd-table').dataTable().fnAdjustColumnSizing();
        
        $('#opd-table_filter input').unbind();
        $('#opd-table_filter input').bind('keyup', function(e) {
            if(e.keyCode == 13) {
            table.fnFilter(this.value);	
            }
        });
    },
    
    get_all_patients : function(){
        $('#px-table').dataTable().fnDestroy();
        var table = $('#px-table').dataTable({
            dom: 'frtip',
            processing:true,  
            serverSide:true, 
            responsive: true,
            order:[],  
            ajax:{  
                url:BASE_URL + "user/fetch_all_patients",
                type:"POST",
                data: { 
                    start_date : $('#search-pat-form input[name=start_date]').val(), 
                    end_date : $('#search-pat-form input[name=end_date]').val()
                }
            } 
        });
        
        $('#px-table_filter input').unbind();
        $('#px-table_filter input').bind('keyup', function(e) {
            if(e.keyCode == 13) {
            table.fnFilter(this.value);	
            }
        });
    },
    
    get_patients_classification : function(doccodex){
        
          start_date = $('#search-class-form input[name=start_date]').val(); 
         end_date = $('#search-class-form input[name=end_date]').val(); 
         
        $("#search-class-form input[name=s_date]").val(start_date);
        $("#search-class-form input[name=e_date]").val(end_date);
        
        $('#px-classification-table').dataTable().fnDestroy();
        var table = $('#px-classification-table').dataTable({
            dom: 'frtip',
           
            processing:true,  
            serverSide:true, 
            order:[],  
            ajax:{  
                url:BASE_URL + "user/fetch_classifications",
                type:"POST",
                data: { 
                    start_date : $('#search-class-form input[name=s_date]').val(), 
                    end_date : $('#search-class-form input[name=e_date]').val(),
                    doccode: doccodex
                }
            }
        });
        $('#px-classification-table_filter input').unbind();
        $('#px-classification-table_filter input').bind('keyup', function(e) {
            if(e.keyCode == 13) {
            table.fnFilter(this.value);	
            }
        });
    },
    
    search_doctors : function()
    {
         var doclist = $('#doclist').val();
        var doccodex = doclist.split(':');
        user.get_patients_classification(doccodex[0]);
    },
    
    
    //disposition: alingling
    
    get_patients_disposition : function(doccodex){
        $('#px-disposition-table').dataTable().fnDestroy();
        var table = $('#px-disposition-table').dataTable({
            dom: 'frtip',
            
            processing:true,  
            serverSide:true, 
            order:[],  
            ajax:{  
                url:BASE_URL + "user/fetch_disposition",
                type:"POST",
                data: { 
                    start_date : $('#search-class-form input[name=start_date]').val(), 
                    end_date : $('#search-class-form input[name=end_date]').val(),
                    doccode : doccodex
                }
            }
        });
        $('#px-disposition-table_filter input').unbind();
        $('#px-disposition-table_filter input').bind('keyup', function(e) {
            if(e.keyCode == 13) {
            table.fnFilter(this.value);	
            }
        });
    },
    
      search_doctors_dispo : function()
    {
         var doclist_dispo = $('#doclist_dispo').val();
        var doccodex = doclist_dispo.split(':');
        user.get_patients_disposition(doccodex[0]);
    },
    
    //disposition
    
    //approved tickets: alingling
    get_approved_ticket_by_date : function(){
       
        $('#approved-ticket-table').dataTable().fnDestroy();
        var table = $('#approved-ticket-table').dataTable({
            dom: 'frtip',
            searching: false,
            responsive: true,
            processing:true,  
            serverSide:true, 
            order:[],  
            ajax:{  
                url:BASE_URL + "user/fetch_approved_ticket_by_date",
                type:"POST",
                data: { 
                    start_date : $('#approved-ticket-form input[name=start_date]').val()
                   
                }
            }
        });
        $('#approved-ticket-table_filter input').unbind();
        $('#approved-ticket-table_filter input').bind('keyup', function(e) {
            if(e.keyCode == 13) {
            table.fnFilter(this.value);	
            }
        });
    },
    
    //
    
    get_expenses : function(){
        
        $('#expenses-table').dataTable().fnDestroy();
        var table = $('#expenses-table').dataTable({
            dom: 'frtip',
            responsive: true,
            processing:true,  
            serverSide:true, 
//            "createdRow": function ( row, data, index ) {
//                console.log(data[5]);
//                alert(typeof data[5]);
////                if (parseFloat(data) <= 0.0) {
////                    $('td', row).eq(5).css({'color' : 'red'});
////                }
//            },
            order:[],  
            ajax:({  
                url:BASE_URL + "user/fetch_expenses",
                type:"POST"
            }),
            drawCallback: function() {
//                $('[data-toggle="popover"]').popover();
//                table.$('[data-toggle="popover"]').popover().click(function(e) {
//                    alert("hi");
//                });
            } 
        });
        
        $('#expenses-table_filter input').unbind();
        $('#expenses-table_filter input').bind('keyup', function(e) {
            if(e.keyCode == 13) {
            table.fnFilter(this.value);	
            }
        });
        
        
    },
    
    get_ros_census : function(){
        $.ajax({
            type: 'POST',
            url:  BASE_URL + "user/fetch_ros",
            data: $('#search-ros-form').serialize(),
            dataType: 'json'
        }).done(function(data) {
//            console.log(data);
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
    
    get_census_add : function(){
        $.ajax({
            type: 'POST',
            url:  BASE_URL + "user/fetch_census/"+0,
            data: $('#search-phic-form').serialize(),
            dataType: 'json'
        }).done(function(data) {
//            console.log(data);
            if (data.status) {
//                $('#sales-report').DataTable()
//   .columns.adjust()
//   .responsive.recalc();
//#phic-
                var phic_table = $('#phic-table').DataTable();
//                phic_table.destroy().draw();
                var phic = 0;
                var nphic = 0;

                phic_table.clear();   
                for (var i = 0; i < data.px_records.length; i++) {
                    if (data.px_records[i]['phicmembr'] == "Non-NHIP") {
                        nphic++;
                    }else{
                        phic++;
                    }
                }
                
                phic_table.row.add([phic,nphic,data.px_records.length]).draw(false);
            } else {
                console.log("fail get census");
            }
        });
    },
    
    get_census_dis : function(){
        $.ajax({
            type: 'POST',
            url:  BASE_URL + "user/fetch_census/"+1,
            data: $('#search-phic-form').serialize(),
            dataType: 'json'
        }).done(function(data) {
//            console.log(data);
            if (data.status) {
//                $('#sales-report').DataTable()
//   .columns.adjust()
//   .responsive.recalc();
//#phic-
                var phic_table = $('#phic-dis-table').DataTable();
//                phic_table.destroy().draw();
                var phic = 0;
                var nphic = 0;

                phic_table.clear();   
                for (var i = 0; i < data.px_records.length; i++) {
                    if (data.px_records[i]['phicmembr'] == "Non-NHIP") {
                        nphic++;
                    }else{
                        phic++;
                    }
                }
                
                phic_table.row.add([phic,nphic,data.px_records.length]).draw(false);
            } else {
                console.log("Failed to get census");
            }
        });
    },
    
    load_patients : function(data,patients_table){
        var btn = '<button type="button" class="btn-details btn bg-teal waves-effect"><i class="material-icons">details</i></button>';
        
        for (var i = 0; i < data.patients.length; i++) {
            patients_table.row.add([
                data.patients[i]['name'],
                data.patients[i]['admitdate']+"/"+data.patients[i]['admittime'],
                data.patients[i]['dischadate']+"/"+data.patients[i]['dischatime'],
                btn
            ]).draw(false);
        }
    },
    
    get_add_patients : function(){
        $("#dailyNews").dataTable().fnDestroy();
        var dataTable = $('#user_data').DataTable({  
           processing:true,  
           serverSide:true,  
           responsive: true,
           order:[],  
           ajax:{  
                url:  BASE_URL + "user/get_patients/"+0,
                data: $('#search-patients-form').serialize(),
                type: "POST"  
           },  
           columnDefs:[  
                {  
                     targets:[0, 3, 4],  
                     orderable:false,  
                }
           ] 
      });  
    },
    
    fetch_proofsheets : function(table,type){
        table.dataTable().fnDestroy();
        var xtable = table.dataTable({
            dom: 'frtip',
            processing:true,  
            serverSide:true, 
            responsive: true,
            order:[],  
            ajax:{  
                url:BASE_URL + "user/fetch_proofsheets/" + type,
                type:"POST",
                data: { 
                    start_date : $('#search-proofsheet-form input[name=start_date]').val(), 
                    end_date : $('#search-proofsheet-form input[name=end_date]').val()
                },
              
                
                
            } 
        });
        
        
        switch(table.attr("id")){
            case "date-proofsheet-table":
                $('#date-proofsheet-table_filter input').unbind();
                $('#date-proofsheet-table_filter input').bind('keyup', function(e) {
                    if(e.keyCode == 13) {
                        xtable.fnFilter(this.value);	
                    }
                });
                break;
            case "proofsheet-table":
                $('#proofsheet-table_filter input').unbind();
                $('#proofsheet-table_filter input').bind('keyup', function(e) {
                    if(e.keyCode == 13) {
                        xtable.fnFilter(this.value);	
                    }
                });
                break;
            default:
                break;
        }
        
//        $('#date-proofsheet-table_filter input').unbind();
//        $('#date-proofsheet-table_filter input').bind('keyup', function(e) {
//            if(e.keyCode == 13) {
//            xtable.fnFilter(this.value);	
//            }
//        });
//        
//        $('#proofsheet-table_filter input').unbind();
//        $('#proofsheet-table_filter input').bind('keyup', function(e) {
//            if(e.keyCode == 13) {
//            xtable.fnFilter(this.value);	
//            }
//        });
    },
    
    get_expenses_report : function(){
        s_data = $('#expenses-table_filter input').val();
        
        $("#expenses-form input[name=search]").val(s_data);
        $("#expenses-form").submit();
    },
    
    get_ipd_report : function(){
        start_date = $('#search-patType-form input[name=s_date]').val(); 
        end_date = $('#search-patType-form input[name=e_date]').val();
        s_data = $('#dis-adm-table_filter input').val();
        
        $("#ipd-form input[name=s_date]").val(start_date);
        $("#ipd-form input[name=e_date]").val(end_date);
        $("#ipd-form input[name=search]").val(s_data);
        $("#ipd-form").submit();
    },
    
    get_opd_report : function(){
        start_date = $('#search-patType-form input[name=s_date]').val(); 
        end_date = $('#search-patType-form input[name=e_date]').val();
        s_data = $('#opd-table_filter input').val();
        
        $("#opd-form input[name=s_date]").val(start_date);
        $("#opd-form input[name=e_date]").val(end_date);
        $("#opd-form input[name=search]").val(s_data);
        $("#opd-form").submit();
    },
    
    get_doc_report : function(){
        start_date = $('#search-doctor-form input[name=s_date]').val(); 
        end_date = $('#search-doctor-form input[name=e_date]').val();
        s_data = $('#doctor-table_filter input').val();
        expert = $('#expertlist').val();
        
        $("#doctor-form input[name=s_date]").val(start_date);
        $("#doctor-form input[name=e_date]").val(end_date);
        $("#doctor-form input[name=search]").val(s_data);
        $("#doctor-form input[name=exp]").val(expert);
        $("#doctor-form").submit();
    },
    
    get_px_report : function(){
        s_data = $('#px-table_filter input').val();
        $("#px-form input[name=search]").val(s_data);
        $("#px-form").submit();
    },
    
    get_class_report : function(){
        start_date = $('#search-class-form input[name=s_date]').val(); 
        end_date = $('#search-class-form input[name=e_date]').val();
        var doclist = $('#doclist').val();
        var doccodex = doclist.split(':');
      
        $("#px-classification-form input[name=s_date]").val(start_date);
        $("#px-classification-form input[name=e_date]").val(end_date);
        $("#px-classification-form input[name=dokie]").val(doccodex[0]);
        $("#px-classification-form input[name=dokiename]").val(doccodex[1]);
        $("#px-classification-form").submit();
    },
    
    //approvedticket: alingling
    get_pdf_approvedticket_report : function(){
        start_date = $('#approved-ticket-form input[name=start_date]').val(); 
        $("#pdf_approved-ticket-form input[name=pdf_date]").val(start_date);
      
        $("#pdf_approved-ticket-form").submit();
    },
    //approvedticket: alingling
    get_csv_approvedticket_report : function(){
        start_date = $('#approved-ticket-form input[name=start_date]').val(); 
        $("#cs_approved-ticket-form input[name=csv_date]").val(start_date);
        $("#cs_approved-ticket-form").submit();
    },
    get_deferredticket_report : function(){
       
        $("#deferred-ticket-form").submit();
    },
    
    get_disapprovedticket_report : function(){
       
        $("#disapproved-ticket-form").submit();
    },
    get_csv_disapprovedticket_report : function(){
       
        $("#csv_disapproved-ticket-form").submit();
    },
    get_csv_deferredticket_report : function(){
       
        $("#csv_deferred-ticket-form").submit();
    },
   
    
    //dispositin:alingling
    
    get_dispo_report : function(){
        
        start_date = $('#search-class-form input[name=s_date]').val(); 
        end_date = $('#search-class-form input[name=e_date]').val();
        var doclist = $('#doclist_dispo').val();
        var doccodex = doclist.split(':');
      
        $("#px-disposition-form input[name=s_date]").val(start_date);
        $("#px-disposition-form input[name=e_date]").val(end_date);
        $("#px-disposition-form input[name=dokie]").val(doccodex[0]);
        $("#px-disposition-form input[name=dokiename]").val(doccodex[1]);
        $("#px-disposition-form").submit();
        
     
    },
    //

    //classification information:alingling
    
    generate_class_info_report : function(){
  
        $('#class-info-form input[name=datex]').val();
        $('#class-info-form input[name=e_date]').val();
        $('#class-info-form input[name=classification]').val(); 
        $("#class-info-form input[name=dokie]").val();
        $("#class-info-form input[name=dokiename]").val();
        $("#class-info-form").submit();
    },
    //

    //disposition information:alingling
    
    generate_dispo_info_report : function(){
  
        $("#disposition-info-form input[name=datex]").val();
        $('#disposition-info-form input[name=e_date]').val();
        $('#disposition-info-form input[name=disposition]').val(); 
        $("#disposition-info-form input[name=dokie]").val();
        $("#disposition-info-form input[name=dokiename]").val();
        $("#disposition-info-form").submit();
    },
    //
    
      generate_doctors_patients_report : function(){
  
        $("#doctors-patient-form input[name=datex]").val();
        $('#doctors-patient-form input[name=e_date]').val();
        $("#doctors-patient-form input[name=dokie]").val();
        $("#doctors-patient-form input[name=dokiename]").val();
        $("#doctors-patient-form").submit();
    },
    //

    
    get_pat_report : function(type){
        start_date = $('#search-adpat-form input[name=s_date]').val(); 
        
        
        if (type === 0) {
            $("#admitted-form input[name=s_date]").val(start_date);
            $("#admitted-form").submit();
        }else if (type === 0){
            $("#discharged-form input[name=s_date]").val(start_date);
            $("#discharged-form").submit();
        }else if (type === 3){
            $("#admitted-form2 input[name=s_date]").val();
            $("#admitted-form2").submit();
        }else{
            $("#discharged-form2 input[name=s_date]").val();
            $("#discharged-form2").submit();
        }
    },
    
    get_d_proofsheet_report : function(type){
        start_date = $('#search-proofsheet-form input[name=s_date]').val(); 
        end_date = $('#search-proofsheet-form input[name=e_date]').val();
       
        
        if (type === 1) {
            s_data = $('#date-proofsheet-table_filter input').val();
            $("#date-proofsheet-form input[name=s_date]").val(start_date);
            $("#date-proofsheet-form input[name=e_date]").val(end_date);
            $("#date-proofsheet-form input[name=search]").val(s_data);
            $("#date-proofsheet-form").submit();
        }else{
            s_data = $('#proofsheet-table_filter input').val();
            $("#proofsheet-form input[name=s_date]").val(start_date);
            $("#proofsheet-form input[name=e_date]").val(end_date);
            $("#proofsheet-form input[name=search]").val(s_data);
            $("#proofsheet-form").submit();
        }
    },
    
    get_phic : function(){
        
    },
    show_set : function(){
        $("#accntSetting").modal("show");
    },
    
    modify_accnt : function(){
        
        $.ajax({
            type: 'POST',
            url:  BASE_URL + "user/update_account",
            data: $('#modify-accnt-form').serialize(),
            dataType: 'json'
        }).done(function(data) {
            var form_uname = $('#modify-accnt-form input[name=username]');
            var form_pass = $('#modify-accnt-form input[name=pass]');
            var form_passconf = $('#modify-accnt-form input[name=passconf]');
             var form_oldpass = $('#modify-accnt-form input[name=oldpass]');
            
            if (data.status) {
                $("#accntSetting").modal("hide");
                swal({
                    title: "Account Modified!",
                    text: "Please log in again with your updated acount.",
                    type: "success"
                }, function() {
                    window.location.href =  BASE_URL + "user/sign_out";
                });
            } else {
                if (data.error_uname) {
                    form_uname.parents('.form-line').removeClass('error success').addClass('error focused');
                    form_uname.parents('.form-group').find('label').html(data.error_uname).css("color","red");
                }else{
                    form_uname.parents('.form-line').removeClass('error success').addClass('success focused');
                    form_uname.parents('.form-group').find('label').html('<p>Username</p>').css("color","");
                }

                if (data.error_pass) {
                    form_pass.parents('.form-line').removeClass('error success').addClass('error focused');
                    form_pass.parents('.form-group').find('label').html(data.error_pass).css("color","red");
                }else{
                    form_pass.parents('.form-line').removeClass('error success').addClass('success focused');
                    form_pass.parents('.form-group').find('label').html('<p>Password</p>').css("color","");
                }
                
                if (data.error_oldpass) {
                    form_oldpass.parents('.form-line').removeClass('error success').addClass('error focused');
                    form_oldpass.parents('.form-group').find('label').html(data.error_oldpass).css("color","red");
                }else{
                    form_oldpass.parents('.form-line').removeClass('error success').addClass('success focused');
                    form_oldpass.parents('.form-group').find('label').html('<p>Password</p>').css("color","");
                }
                
                if (data.error_passconf) {
                    form_passconf.parents('.form-line').removeClass('error success').addClass('error focused');
                    form_passconf.parents('.form-group').find('label').html(data.error_passconf).css("color","red");
                }else{
                    form_passconf.parents('.form-line').removeClass('error success').addClass('success focused');
                    form_passconf.parents('.form-group').find('label').html('<p>Password Confirmation</p>').css("color","");
                }
            }
        });
    }
    
};

//-----------enter key on log in
$('#sign-in-form input').bind("enterKey",function(e){
   user.validate_log_in();
});

$('#sign-in-form input').keyup(function(e){
    if(e.keyCode == 13)
    {
        $(this).trigger("enterKey");
    }
});

$('#proofsheet-table').on('click', '.btn-details', function () {
    var currentRow = $(this).closest("tr");
    //do something with values in td's
    var date = currentRow.find("td").eq(0).text();
    var cashier = currentRow.find("td").eq(1).text();
    
    user.get_details(date,cashier);
    //and so on
});

    
//$(document).on("dblclick", "#proofsheet-table tr", function(e) {
////    alert('hi');
//var currentRow = $(this).closest("tr");
//        //do something with values in td's
//        var date = currentRow.find("td").eq(3).text();
//        var cashier = currentRow.find("td").eq(1).text();
//        alert(date);
//});

$('#date-proofsheet-table').on('click', '.btn-details', function () {
    var currentRow = $(this).closest("tr");
    //do something with values in td's
    var date = currentRow.find("td").eq(0).text();
    user.get_d_proof_details(date);
    //and so on
});

function load_script(scriptUrl,type,subType)
{
    $.getScript(scriptUrl)
        .done(function( script, textStatus ) {
//            console.log( textStatus );
            switch(parseInt(subType)){
                case 0:
                    user.load_records(type);
                    break;
                case 1: 
                    user.load_proofsheets();
                    break;
                case 3:
                    $('#largeModal').modal('show');
                    $(".report-btn").show();
                    user.get_expenses();
                    $('#largeModal').modal('hide');
                    break;
                default:
                    break;
            }
            
        })
        .fail(function( jqxhr, settings, exception ) {
         console.log("fail to load script");
    });
}

function load_css(cssUrl)
{
    $('<link rel="stylesheet" type="text/css" href="'+cssUrl+'" >')
   .appendTo("head");
}



$('#px-classification-table').on('click','td', function()
{
    var row = $(this).closest('tr');
    var data = $('#px-classification-table').dataTable().fnGetData(row);
    get_classification_patients(data);
    $('#classificationinformation').modal("show");
  
});

function get_classification_patients(px)
{
   // $('#classification-info-form input[name=classification]').val(px[0]);
   start_date = $('#search-class-form input[name=start_date]').val();
   end_date = $('#search-class-form input[name=end_date]').val();
    $('#ss').text(px[0]);
    $('#datex').val(start_date);
    $('#e_date').val(end_date);
    $('#classification').val(px[0]);
    
    doctor = $('#search-doctorx-form select[name=doclist]').val();
    doctorx = doctor.split(':');
    $('#dokie').val(doctorx[0]);
     $('#dokiename').val(doctorx[1]);
   


    $('#classification-info-table').dataTable().fnDestroy();
        var table = $('#classification-info-table').dataTable({
            dom: 'frtip',
           
            processing:true,  
            serverSide:true, 
            order:[],  
            ajax:{  
                url:BASE_URL + "user/fetch_classifications_patients",
                type:"POST",
                data: { 
                    start_date : $('#search-class-form input[name=start_date]').val(), 
                    end_date : $('#search-class-form input[name=end_date]').val(),
                    classification: px[0],
                    doccode: doctorx[0]
                }
            }
        });
        $('#classification-info-table_filter input').unbind();
        $('#classification-info-table_filter input').bind('keyup', function(e) {
            if(e.keyCode == 13) {
            table.fnFilter(this.value);	
            }
        });
  
}


$('#px-disposition-table').on('click','td', function()
{
    var row = $(this).closest('tr');
    var data = $('#px-disposition-table').dataTable().fnGetData(row);
    get_dispo_patients(data);
    $('#dispoinfo').modal("show");
    
  
});

function get_dispo_patients(px)
{
   
   start_date = $('#search-class-form input[name=start_date]').val();
   end_date = $('#search-class-form input[name=end_date]').val();

    $('#disposition-info-form input[name=datex]').val(start_date);
    $('#disposition-info-form input[name=e_date]').val(end_date);
    $('#disposition-info-form input[name=disposition]').val(px[0]);
    $('#dispo').text(px[0]);
    doctor = $('#search-doctorx_disposition-form select[name=doclist_dispo]').val();
  
    doctorx = doctor.split(':');
     $('#disposition-info-form input[name=dokie]').val(doctorx[0]);
       $('#disposition-info-form input[name=dokiename]').val(doctorx[1]);

    
    
    $('#dispo-info-table').dataTable().fnDestroy();
        var table = $('#dispo-info-table').dataTable({
            dom: 'frtip',
           
            processing:true,  
            serverSide:true, 
            order:[],  
            ajax:{  
                url:BASE_URL + "user/fetch_dispo_patients",
                type:"POST",
                data: { 
                start_date : $('#search-class-form input[name=start_date]').val(), 
                    end_date : $('#search-class-form input[name=end_date]').val(),
                    classification: px[0],
                    doccode: doctorx[0]
                }
            }
        });
        $('#dispo-info-table_filter input').unbind();
        $('#dispo-info-table_filter input').bind('keyup', function(e) {
            if(e.keyCode == 13) {
            table.fnFilter(this.value);	
            }
        });
  
}

$('#onpro-table').on('click','td', function()
{
    var row = $(this).closest('tr');
    var data = $('#onpro-table').dataTable().fnGetData(row);
    get_onProcess_patients(data);
    $('#onProcessinfo').modal("show");
  
});

function get_onProcess_patients(px)
{
   // $('#onProcess-info-form input[name=tatolamt]').text();
   $('#aging').html(px[1]);
   
   $('#totalpat').html(px[2]);

   $('#on-process-form input[name=agingx]').val(px[0]);
   
    

   
    $('#onProcess-info-table').dataTable().fnDestroy();
        var table = $('#onProcess-info-table').dataTable({
            dom: 'frtip',
            responsive: true,
            processing:true,  
            serverSide:true, 
            order:[],  
            ajax:{  
                url:BASE_URL + "user/fetch_onProcess_patients",
                type:"POST",
                data: { 
                    start_date : $('#search-onpro-form input[name=start_date]').val(), 
                    aging : $('#aging').text()
                }
            },
            initComplete : function(settings, json){
                $("#totalhci").val('₱ ' + accounting.format(json["total"]["hospp"],2)).closest('.form-line').addClass('focused');
                $("#totalpf").val('₱ ' + accounting.format(json["total"]["proff"],2)).closest('.form-line').addClass('focused');
                var hospp = parseFloat(json["total"]["hospp"]) + parseFloat(json["total"]["proff"]);
                $("#tatolamt").val('₱ ' + accounting.format(hospp,2)).closest('.form-line').addClass('focused');
            

                $(".report-btn").show();
              
            }
        });
        $('#onProcess-info-table_filter input').unbind();
        $('#onProcess-info-table_filter input').bind('keyup', function(e) {
            if(e.keyCode === 13) {
            table.fnFilter(this.value);	
            }
        });
  
}
//get transmitted patients
$('#transmittal-table').on('click','td', function()
{
    var row = $(this).closest('tr');
    var data = $('#transmittal-table').dataTable().fnGetData(row);
    get_transmitted_patients(data);
    $('#transmitinfo').modal("show");
  
});

function get_transmitted_patients(px)
{
   // $('#onProcess-info-form input[name=tatolamt]').text();
    $('#ss').html(px[0]);
   $('#tatolamt').html(px[2]);
   

   
    $('#transmit-info-table').dataTable().fnDestroy();
        var table = $('#transmit-info-table').dataTable({
            dom: 'frtip',
            responsive: true,
            processing:true,  
            serverSide:true, 
            order:[],  
            ajax:{  
                url:BASE_URL + "user/fetch_transmitted_patients",
                type:"POST",
                data: { 
                    start_date : $('#search-transmittal-form input[name=start_date]').val(), 
                    aging : $('#ss').text()
                    
                }
            }
        });
        $('#transmit-info-table_filter input').unbind();
        $('#transmit-info-table_filter input').bind('keyup', function(e) {
            if(e.keyCode === 13) {
            table.fnFilter(this.value);	
            }
        });
  
}
//get payment_aging_to_transmittal patients: alingling

$('#paymentaging-table').on('click','td', function()
{
    var row = $(this).closest('tr');
    var data = $('#paymentaging-table').dataTable().fnGetData(row);
    get_payment_transmittal(data);
    $('#payment_transmittal').modal("show");
  
});

function get_payment_transmittal(px)
{
   // $('#onProcess-info-form input[name=tatolamt]').text();
    $('#ss').html(px[0]);

   $('#tatolamt').html(px[2]);

   
    $('#payment_transmittal-info-table').dataTable().fnDestroy();
        var table = $('#payment_transmittal-info-table').dataTable({
            dom: 'frtip',
            responsive: true,
            processing:true,  
            serverSide:true, 
            order:[],  
            ajax:{  
                url:BASE_URL + "user/fetch_payment_transmittal_patients",
                type:"POST",
                data: { 
                    start_date : $('#search-payment-form input[name=start_date]').val(), 
                    aging : $('#ss').text()
                    
                }
            }
        });
        $('#payment_transmittal-info-table_filter input').unbind();
        $('#payment_transmittal-info-table_filter input').bind('keyup', function(e) {
            if(e.keyCode === 13) {
            table.fnFilter(this.value);	
            }
        });
  
}
//get payment_aging_to_discharge patients: alingling

$('#paymentdischarge-table').on('click','td', function()
{
    var row = $(this).closest('tr');
    var data = $('#paymentdischarge-table').dataTable().fnGetData(row);
    get_payment_discharge(data);
    $('#payment_discharge').modal("show");
  
});

function get_payment_discharge(px)
{
   // $('#onProcess-info-form input[name=tatolamt]').text();
    $('#ss').html(px[0]);
   $('#totalamt').html(px[2]);

   
    $('#payment_discharge-info-table').dataTable().fnDestroy();
        var table = $('#payment_discharge-info-table').dataTable({
            dom: 'frtip',
            responsive: true,
            processing:true,  
            serverSide:true, 
            order:[],  
            ajax:{  
                url:BASE_URL + "user/fetch_payment_discharge_patients",
                type:"POST",
                data: { 
                    start_date : $('#search-payment-form input[name=start_date]').val(), 
                    aging : $('#ss').text()
                    
                }
            }
        });
        $('#payment_discharge-info-table_filter input').unbind();
        $('#payment_discharge-info-table_filter input').bind('keyup', function(e) {
            if(e.keyCode === 13) {
            table.fnFilter(this.value);	
            }
        });
  
}


//get patients of the day: alingling

$('#disad-table').on('click','td', function()
{
    var row = $(this).closest('tr');
    var data = $('#disad-table').dataTable().fnGetData(row);
    var admitDischaDate = $("#admitDischaDate").val();
    
    get_add_dis_day(data,admitDischaDate);
    $('#admittedpatientday').modal("show");
  
});

function get_add_dis_day(px,admitDischaDate)
{
   // $('#onProcess-info-form input[name=tatolamt]').text();
   
    $('#ss').html(px[0]);
   $('#tatolamt').html(px[3]);
 
if (px[0] === "Admissions")
{
    $("#admitDischaDatex").val(admitDischaDate);
    $('#admission').removeClass("hidden");
    $('#discharged').addClass("hidden");
   
    $('#admitted-info-table').dataTable().fnDestroy();
        var table = $('#admitted-info-table').dataTable({
            dom: 'frtip',
            responsive: true,
            processing:true,  
            serverSide:true, 
            order:[],  
            ajax:{  
                url:BASE_URL + "user/fetch_admitted_day_patients",
                type:"POST",
                data:{admitDischaDate:admitDischaDate}
               
            }
        });
        $('#admitted-info-table_filter input').unbind();
        $('#admitted-info-table_filter input').bind('keyup', function(e) {
            if(e.keyCode === 13) {
            table.fnFilter(this.value);	
            }
        });
    }
    else
    {
        $('#admission').addClass("hidden");
        $('#discharged').removeClass("hidden");
        $("#admitDischaDatexx").val(admitDischaDate);
        
        $('#discharged-info-table').dataTable().fnDestroy();
        var table = $('#discharged-info-table').dataTable({
            dom: 'frtip',
            responsive: true,
            processing:true,  
            serverSide:true, 
            order:[],  
            ajax:{  
                url:BASE_URL + "user/fetch_discharged_day_patients",
                type:"POST",
                data:{admitDischaDate:admitDischaDate}
               
            }
        });
        $('#discharged-info-table_filter input').unbind();
        $('#discharged-info-table_filter input').bind('keyup', function(e) {
            if(e.keyCode === 13) {
            table.fnFilter(this.value);	
            }
        });
    }
}
//

$('#accntSetting').on('hidden.bs.modal', function () {
    $('#modify-accnt-form')[0].reset();
    var form_uname = $('#modify-accnt-form input[name=username]');
    var form_pass = $('#modify-accnt-form input[name=pass]');
    var form_passconf = $('#modify-accnt-form input[name=passconf]');
    
    form_uname.parents('.form-line').removeClass('error success focused');
    form_uname.parents('.form-group').find('label').html('<p>Username</p>').css("color","");

    form_pass.parents('.form-line').removeClass('error success focused');
    form_pass.parents('.form-group').find('label').html('<p>Password</p>').css("color","");

    form_passconf.parents('.form-line').removeClass('error success focused');
    form_passconf.parents('.form-group').find('label').html('<p>Password Confirmation</p>').css("color","");
});


$('#px-classification-table').on( 'draw.dt', function () {
    
    var wwww = $('#px-classification-table').DataTable();
    var data = wwww.rows().data();
//                
    if (data.length != 0) {
        var total = 0;
        for (var i = 0; i < data.length; i++) {
            
            total += parseInt(data[i][1]);
        }
        $(".class-total").html('(<b>'+total+'</b>)');
    }else{
        $(".class-total").html('');
    }
} );

$('#px-disposition-table').on( 'draw.dt', function () {
    
    var wwww = $('#px-disposition-table').DataTable();
    var data = wwww.rows().data();
//                
    if (data.length != 0) {
        var total = 0;
        for (var i = 0; i < data.length; i++) {
            
            total += parseInt(data[i][1]);
        }
        $(".dispo-total").html('(<b>'+total+'</b>)');
    }else{
        $(".dispo-total").html('');
    }
} );


$('#doctor-table').on('click','td', function()
{
    var row = $(this).closest('tr');
    var data = $('#doctor-table').dataTable().fnGetData(row);
    get_doctors_patients(data);
    $('#doctorspatient').modal("show");
  
});

function get_doctors_patients(px)
{
   // $('#classification-info-form input[name=classification]').val(px[0]);
   start_date = $('#search-doctor-form input[name=start_date]').val();
   end_date = $('#search-doctor-form input[name=end_date]').val();
    $('#docname').text(px[1]);
    $('#datex').val(start_date);
    $('#e_date').val(end_date);
//    $('#classification').val(px[0]);
//    
//    doctor = $('#search-doctorx-form select[name=doclist]').val();
//    doctorx = doctor.split(':');
    $('#dokie').val(px[0]);
     $('#dokiename').val(px[1]);
   


    $('#doctors-patient-table').dataTable().fnDestroy();
        var table = $('#doctors-patient-table').dataTable({
            dom: 'frtip',
         
            processing:true,  
            serverSide:true, 
            order:[],  
            ajax:{  
                url:BASE_URL + "user/fetch_doctors_patients",
                type:"POST",
                data: { 
                    start_date : $('#doctors-patient-form input[name=datex]').val(), 
                    end_date : $('#doctors-patient-form input[name=e_date]').val(),
//                    classification: px[0],
                    doccode: px[0]
                }
            }
        });
        $('#doctors-patient-table_filter input').unbind();
        $('#doctors-patient-table_filter input').bind('keyup', function(e) {
            if(e.keyCode == 13) {
            table.fnFilter(this.value);	
            }
        });
  
}

$('#summary-disadd-table').on('click','td', function()
{
    var row = $(this).closest('tr');
    var data = $('#summary-disadd-table').dataTable().fnGetData(row);
    get_disadd_summary(data);
//    $('#doctorspatient').modal("show");
  
});

function get_disadd_summary(data)
{
    $('#admit').html(moment(data[0]).format('MMMM YYYY'));
    $('#discharge').html(moment(data[0]).format('MMMM YYYY'));
    $('#diss').addClass('hidden');
    $('#diss2').removeClass('hidden');
    $('#admitted-form2 input[name=s_date]').val(data[0]);
    $('#add').addClass('hidden');
    $('#add2').removeClass('hidden');
    $('#discharged-form2 input[name=s_date]').val(data[0]);
  
    $('#admitted-table').dataTable().fnDestroy();
        var table = $('#admitted-table').dataTable({
            dom: 'frtip',
         
            processing:true,  
            serverSide:true, 
            order:[],  
            ajax:{  
                url:BASE_URL + "user/fetch_patients_month/" + 0,
                type:"POST",
                data: { 
                    start_date : data[0]
                }
            }
        });
        $('#admitted-table_filter input').unbind();
        $('#admitted-table_filter input').bind('keyup', function(e) {
            if(e.keyCode == 13) {
            table.fnFilter(this.value);	
            }
        });
        
        
        //discharges
        $('#discharged-table').dataTable().fnDestroy();
        var table = $('#discharged-table').dataTable({
            dom: 'frtip',
         
            processing:true,  
            serverSide:true, 
            order:[],  
            ajax:{  
                url:BASE_URL + "user/fetch_patients_month/" + 1,
                type:"POST",
                data: { 
                    start_date : data[0]
                }
            }
        });
        $('#discharged-table_filter input').unbind();
        $('#discharged-table_filter input').bind('keyup', function(e) {
            if(e.keyCode == 13) {
            table.fnFilter(this.value);	
            }
        });
  
}

//Chart.plugins.register({
//   afterDatasetsDraw: function(chart) {
//      if (chart.tooltip._active && chart.tooltip._active.length) {
//         var activePoint = chart.tooltip._active[0],
//            ctx = chart.ctx,
//            y_axis = chart.scales['y-axis-0'],
//            x = activePoint.tooltipPosition().x,
//            topY = y_axis.top,
//            bottomY = y_axis.bottom;
//         // draw line
//         ctx.save();
//         ctx.beginPath();
//         ctx.moveTo(x, topY);
//         ctx.lineTo(x, bottomY);
//         ctx.lineWidth = 2;
//         ctx.strokeStyle = '#07C';
//         ctx.stroke();
//         ctx.restore();
//      }
//   }
//});






















