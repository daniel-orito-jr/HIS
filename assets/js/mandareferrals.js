$('.datex').datetimepicker({
        format: 'YYYY-MM'
});


var refer = {
    get_referrals : function(){
        $('#referrals-table').dataTable().fnDestroy();
        $('#referrals-table tbody').empty();
        var table = $('#referrals-table').dataTable({
            dom: '',
            columnDefs: [ {
                targets:   0,
                width: "75%"
                }],
            processing:true,  
            serverSide:true, 
            order:[],
            ajax:{  
                url:BASE_URL + "user/fetch_referrals",
                type:"POST",
                data: {start_date:$('#search-referrals-form input[name=start_date]').val()}
            },
        });
        $('#referrals-table_filter input').unbind();
        $('#referrals-table_filter input').bind('keyup', function(e) {
            if(e.keyCode === 13) {
            table.fnFilter(this.value); 
            }
        });
    },

    search_referral_census : function(){
        var s_date = $('#search-referrals-form input[name = start_date]');
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
            refer.get_referrals();
       }
    },
}

