var management = {
    fetch_users : function(){
        $('#user-table').dataTable().fnDestroy();
        var dataTable = $('#user-table').dataTable({  
                dom: 'frtip',
                processing:true,  
                serverSide:true, 
                responsive: true,
                order:[],  
                ajax:{  
                    url:BASE_URL + "pages/fetch_users",  
                    type:"POST"
                },
                columnDefs: [
                    {
                        targets: [ 5,6 ],
                        visible: false
                    }
                ]
            });
            
        $('#user-table_filter input').unbind();
        $('#user-table_filter input').bind('keyup', function(e) {
            if(e.keyCode == 13) {
            dataTable.fnFilter(this.value);	
            }
        });
    },
    
    update_user : function(){
        $.ajax({
            type: 'POST',
            url:  BASE_URL + "pages/up_user",
            data: $('#update-user-form').serialize(),
            dataType: 'json'
        }).done(function(data) {
            console.log(data);
            if (data.status) {
                users.fetch_users();
                $("#updateUser").modal("hide");
                swal("Success!", "User updated!", "success");
            } else {
                var form_branch = $('#update-user-form select[name=branch]');
                var form_utype = $('#update-user-form select[name=usertype]');
                var form_uname = $('#update-user-form input[name=username]');
                var form_contact = $('#update-user-form input[name=contactno]');
                
                if (data.error_branch) {
                    form_branch.parents('.form-line').removeClass('error success').addClass('error focused');
                    form_branch.parents('.form-group').find('label').html(data.error_branch).css("color","red");
                }else{
                    form_branch.parents('.form-line').removeClass('error success').addClass('success focused');
                    form_branch.parents('.form-group').find('label').html('<p>Branch Name</p>').css("color","");
                }
               
                if (data.error_utype) {
                    form_utype.parents('.form-line').removeClass('error success').addClass('error focused');
                    form_utype.parents('.form-group').find('label').html(data.error_utype).css("color","red");
                }else{
                    form_utype.parents('.form-line').removeClass('error success').addClass('success focused');
                    form_utype.parents('.form-group').find('label').html('<p>User Type</p>').css("color","");
                }
                
                if (data.error_uname) {
                    form_uname.parents('.form-line').removeClass('error success').addClass('error focused');
                    form_uname.parents('.form-group').find('label').html(data.error_uname).css("color","red");
                }else{
                    form_uname.parents('.form-line').removeClass('error success').addClass('success focused');
                    form_uname.parents('.form-group').find('label').html('<p>Username</p>').css("color","");
                }
//                error_contactno

                if (data.error_contactno) {
                    form_contact.parents('.form-line').removeClass('error success').addClass('error focused');
                    form_contact.parents('.form-group').find('label').html(data.error_contactno).css("color","red");
                }else{
                    form_contact.parents('.form-line').removeClass('error success').addClass('success focused');
                    form_contact.parents('.form-group').find('label').html('<p>Contact No.</p>').css("color","");
                }
            }
        });
    },
    
    add_user : function(){
        $.ajax({
            type: 'POST',
            url:  BASE_URL + "pages/add_user",
            data: $('#add-user-form').serialize(),
            dataType: 'json'
        }).done(function(data) {
            console.log(data);
            if (data.status) {
                users.fetch_users();
                $("#addUser").modal("hide");
                swal("Success!", "New User added!", "success");
            } else {
                var form_branch = $('#add-user-form select[name=branch]');
                var form_utype = $('#add-user-form select[name=usertype]');
                var form_uname = $('#add-user-form input[name=username]');
                var form_pass = $('#add-user-form input[name=pass]');
                var form_passconf = $('#add-user-form input[name=passconf]');
                var form_contact = $('#add-user-form input[name=contactno]');
                
                if (data.error_branch) {
                    form_branch.parents('.form-line').removeClass('error success').addClass('error focused');
                    form_branch.parents('.form-group').find('label').html(data.error_branch).css("color","red");
                }else{
                    form_branch.parents('.form-line').removeClass('error success').addClass('success focused');
                    form_branch.parents('.form-group').find('label').html('<p>Branch Name</p>').css("color","");
                }
               
                if (data.error_utype) {
                    form_utype.parents('.form-line').removeClass('error success').addClass('error focused');
                    form_utype.parents('.form-group').find('label').html(data.error_utype).css("color","red");
                }else{
                    form_utype.parents('.form-line').removeClass('error success').addClass('success focused');
                    form_utype.parents('.form-group').find('label').html('<p>User Type</p>').css("color","");
                }
                
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
                
                if (data.error_passconf) {
                    form_passconf.parents('.form-line').removeClass('error success').addClass('error focused');
                    form_passconf.parents('.form-group').find('label').html(data.error_passconf).css("color","red");
                }else{
                    form_passconf.parents('.form-line').removeClass('error success').addClass('success focused');
                    form_passconf.parents('.form-group').find('label').html('<p>Password Confirmation</p>').css("color","");
                }
//                error_contactno

                if (data.error_contactno) {
                    form_contact.parents('.form-line').removeClass('error success').addClass('error focused');
                    form_contact.parents('.form-group').find('label').html(data.error_contactno).css("color","red");
                }else{
                    form_contact.parents('.form-line').removeClass('error success').addClass('success focused');
                    form_contact.parents('.form-group').find('label').html('<p>Contact No.</p>').css("color","");
                }
            }
        });
    },
    
    show_update_user : function(data){
        var form_branch = $('#update-user-form select[name=branch]');
        var form_utype = $('#update-user-form select[name=usertype]');
        var form_uname = $('#update-user-form input[name=username]');
//        var form_pass = $('#add-user-form input[name=pass]');
//        var form_passconf = $('#add-user-form input[name=passconf]');
        var form_contact = $('#update-user-form input[name=contactno]');
        var i = $('#update-user-form input[name=temp_id]');
        
        form_branch.selectpicker('val', data[5]);
        var type = (data[3] === "admin") ? 255 : 1;
        form_utype.selectpicker('val', type);
//        $("#add-user-form select[name=branch]");
        
//        $('#update-branch-form input[name=code]').val(code);
        form_branch.parents('.form-line').removeClass('error success').addClass('success focused');
        form_utype.parents('.form-line').removeClass('error success').addClass('success focused');
        form_uname.val(data[0]).parents('.form-line').removeClass('error success').addClass('success focused');
        form_contact.val(data[1]).parents('.form-line').removeClass('error success').addClass('success focused');
        i.val(data[6]);
        $("#updateUser").modal("show");
    },
    
    tttt : function(){
        alert($("#add-user-form select[name=usertype]").val());
    }
    
};

$('#user-table').on('click', '.btn-update-branch', function () {
        var row = $(this).closest('tr');
        var data = $('#user-table').dataTable().fnGetData(row);
        users.show_update_user(data);
});


$('#addUser').on('hidden.bs.modal', function () {
    $('#add-user-form')[0].reset();
    var form_branch = $('#add-user-form select[name=branch]');
    var form_utype = $('#add-user-form select[name=usertype]');
    var form_uname = $('#add-user-form input[name=username]');
    var form_pass = $('#add-user-form input[name=pass]');
    var form_passconf = $('#add-user-form input[name=passconf]');
    var form_contact = $('#add-user-form input[name=contactno]');
    
    
    form_branch.parents('.form-line').removeClass('error success').addClass('focused');
    form_branch.parents('.form-group').find('label').html('<p>Branch Name</p>').css("color","");
    
//    form_utype.parents('.form-line').removeClass('focused');
    form_utype.parents('.form-line').removeClass('error success').addClass('focused');
    form_utype.parents('.form-group').find('label').html('<p>User Type</p>').css("color","");
    
    form_uname.parents('.form-line').removeClass('focused');
    form_uname.parents('.form-group').find('label').html('<p>Username</p>').css("color","");
    
    form_pass.parents('.form-line').removeClass('focused');
    form_pass.parents('.form-group').find('label').html('<p>Password</p>').css("color","");
    
    form_passconf.parents('.form-line').removeClass('focused');
    form_passconf.parents('.form-group').find('label').html('<p>Password Confirmation</p>').css("color","");
    
    form_contact.parents('.form-line').removeClass('focused');
    form_contact.parents('.form-group').find('label').html('<p>Contact No.</p>').css("color","");
});

$('#updateUser').on('hidden.bs.modal', function () {
    $('#update-user-form')[0].reset();
    var form_branch = $('#update-user-form select[name=branch]');
    var form_utype = $('#update-user-form select[name=usertype]');
    var form_uname = $('#update-user-form input[name=username]');
    var form_contact = $('#update-user-form input[name=contactno]');
    
    
    form_branch.parents('.form-line').removeClass('error success').addClass('focused');
    form_branch.parents('.form-group').find('label').html('<p>Branch Name</p>').css("color","");
    
//    form_utype.parents('.form-line').removeClass('focused');
    form_utype.parents('.form-line').removeClass('error success').addClass('focused');
    form_utype.parents('.form-group').find('label').html('<p>User Type</p>').css("color","");
    
    form_uname.parents('.form-line').removeClass('focused');
    form_uname.parents('.form-group').find('label').html('<p>Username</p>').css("color","");
    
    form_contact.parents('.form-line').removeClass('focused');
    form_contact.parents('.form-group').find('label').html('<p>Contact No.</p>').css("color","");
});
