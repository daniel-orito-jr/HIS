
var table = $('#assets-table').DataTable({
    dom: 'frtip',
    responsive: true
});

$('.date').datetimepicker({
        format: 'YYYY-MM-DD'
});

var fixasset = {
    get_fixasset : function(){
        $('#assets-table').dataTable().fnDestroy();
        var table = $('#assets-table').dataTable({
            dom: 'frtip',
            responsive: true,
            processing:true,  
            serverSide:true, 
            order:[],  
            ajax:{  
                url:BASE_URL + "user/get_assets",
                type:"POST",
            
            },
            initComplete : function(settings, json){
              $("#quantity").html(json["count"])
            }
        });
        $('#assets-table_filter input').unbind();
        $('#assets-table_filter input').bind('keyup', function(e) {
            if(e.keyCode == 13) {
                table.fnFilter(this.value);	
            }
        });
    },
    
    get_assets_report : function()
    {
        $("#assets-form").submit();
    },
    
    get_assets_info_report : function()
    {
      $('#assets-service-form input[name=search]').val();
        $("#assets-service-form").submit();
    }
};

function load_fixasset_script(scriptUrl)
{
    $.getScript(scriptUrl)
        .done(function( script, textStatus ) {
//            console.log( textStatus );
            fixasset.get_fixasset();
           
            
        })
        .fail(function( jqxhr, settings, exception ) {
         console.log("fail to load script");
    });
}

$('#assets-table').on('click','td', function()
{
    var row = $(this).closest('tr');
    var data = $('#assets-table').dataTable().fnGetData(row);
    get_fix_assets(data);
//    alert("Hello");
    $('#assetinfo').modal("show");
  
});

function get_fix_assets(data)
{
  
    $('#assetinfos').text(data[1]+": "+data[2]);
 
   $('#assets-service-form input[name=id]').val(data[0]);
    $('#asset-info-table').dataTable().fnDestroy();
        var table = $('#asset-info-table').dataTable({
            dom: 'frtip',
            responsive: true,
            processing:true,  
            serverSide:true, 
            order:[],  
            ajax:{  
                url:BASE_URL + "user/get_assets_info",
                type:"POST",
                data: { 
                    ID: data[0]
                }
            },
             initComplete : function(settings,json){
                $("#quantity").html(json["count"]).closest('.form-line').addClass('focused');
               
            }
        });
        $('#asset-info-table_filter input').unbind();
        $('#asset-info-table_filter input').bind('keyup', function(e) {
            if(e.keyCode === 13) {
            table.fnFilter(this.value);	
            }
        });
  
}