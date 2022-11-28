$('.date').datetimepicker({
        format: 'YYYY-MM'
});

var chartObj; 

var monthly = {
    
    monthpick: function()
    {
         var month=$("#lastmonthpicker").val();
    
    switch(month)
    {
        case "12":
            monthly.get_monthly_transaction("12");
            $('#lastmonth').text("12");
            $('#monthrange').val("12");
         //  monthly.get_monthly_transaction_report('12');
            break;
        case "9":
            monthly.get_monthly_transaction("9");
            $('#lastmonth').text("9");
            $('#monthrange').val("9");
        //   monthly.get_monthly_transaction_report('9');
            break;
        case "6":
           monthly.get_monthly_transaction("6");
            $('#lastmonth').text("6");
            $('#monthrange').val("6");
        //  monthly.get_monthly_transaction_report('6');
            break;
        case "3":
          monthly.get_monthly_transaction("3");
            $('#lastmonth').text("3");
            $('#monthrange').val("3");
         // monthly.get_monthly_transaction_report('3');
            break;
        default:
            monthly.get_monthly_transaction("12");
            $('#lastmonth').text("12");
            $('#monthrange').val("12");
            break;
    }
    },


      get_monthly_transaction_report : function()
    {
        start_date = $('#search-monthly-form input[name=monthdate]').val(); 
        
        $("#monthly-transaction-form input[name=s_date]").val(start_date);
        $("#monthly-transaction-form input[name=rangemonth]").val();
     
        $("#monthly-transaction-form").submit();
    },
    
    get_monthly_transaction: function (month)
    {

       
            $.ajax({
                    type: 'POST',
                    url:  BASE_URL + "user/get_monthly/"+ month,
                    data: $('#search-monthly-form').serialize(),
                    dataType: 'json'
                   
                }).done(function(data1) {
                   
                    console.log(data1);
                        if (data1.status) 
                        {
                           $('#monthly-transaction-table').dataTable().fnDestroy();
                           var census_table = $('#monthly-transaction-table').DataTable({
                               dom: 'frtip',
                               pageLength:12,
                              //  responsive: true,
                                processing:true,  
                                order: [[ 0, "desc" ]],
                                scrollX:true,
                                'rowCallback': function(row, data, index){
                                     $(row).find('td:eq(1)').css('background-color', '#BBDEFB');
                                     $(row).find('td:eq(5)').css('background-color', '#C5CAE9');
                                 }
                           });
                           census_table.clear();
                           
                            if (chartObj != undefined || chartObj != null) {
                                chartObj.destroy();
                            }
                           monthly.create_chart(data1.census_monthly);
                           
                        
                        //   console.log(data1.census_monthly.length);
                           if(data1.census_monthly.length > 0)
                            {
                                
                               for (var i = 0; i < data1.census_monthly.length; i++) 
                               {
                                    var first_date = moment(data1.census_monthly[i]["datex"]).format('MMM YYYY');
                                   census_table.row.add(
                                    [
                                         first_date,
                                        '₱'+ accounting.format(data1.census_monthly[i]["total"],2) ,
                                        '₱'+ accounting.format(data1.census_monthly[i]["drugin"],2),
                                        '₱'+ accounting.format(data1.census_monthly[i]["medsplyin"],2),
                                        '₱'+ accounting.format(data1.census_monthly[i]["pharmiscin"],2),
                                        '₱'+ accounting.format(data1.census_monthly[i]["pharmacy"],2),
                                        '₱'+ accounting.format(data1.census_monthly[i]["labin"],2),
                                        '₱'+ accounting.format(data1.census_monthly[i]["radin"],2),
                                        '₱'+ accounting.format(data1.census_monthly[i]["hospin"],2),
                                        '₱'+ accounting.format(data1.census_monthly[i]["ipdayin"],2),
                                        '₱'+ accounting.format(data1.census_monthly[i]["hmoacctin"],2),
                                        '₱'+ accounting.format(data1.census_monthly[i]["pcsoacctin"],2),
                                        '₱'+ accounting.format(data1.census_monthly[i]["phicacctin"],2),
                                        '₱'+ accounting.format(data1.census_monthly[i]["opdlabin"],2),
                                        '₱'+ accounting.format(data1.census_monthly[i]["opdradin"],2),
                                        '₱'+ accounting.format(data1.census_monthly[i]["opdhospin"],2),
                                        '₱'+ accounting.format(data1.census_monthly[i]["pnacctin"],2),
                                        '₱'+ accounting.format(data1.census_monthly[i]["deliverypharin"],2),
                                        '₱'+ accounting.format(data1.census_monthly[i]["deliverylabin"],2),
                                        '₱'+ accounting.format(data1.census_monthly[i]["deliveryradin"],2),
                                        '₱'+ accounting.format(data1.census_monthly[i]["deliveryhospin"],2)
                                        
                                    ]   
                                    ).draw(false);
                                }
                            }
                            else
                            {
                                $('#monthly-transaction-table').dataTable().fnDestroy();
                                var census_table = $('#monthly-transaction-table').DataTable();
                                census_table.clear();
                            }
                        } 
                        else 
                        {
                            console.log('fail');
                        }
                    });
    },
    
    create_chart : function(data){
        var date = [],
            total = [],
            drugs = [],
            medsupply = [],
            pharmisc = [],
            laboratory = [],
            radiology = [],
            hospital = [],
            ipdpayment = [],
            hmo = [],
            pcso = [],
            phic = [],
            opdlaboratory = [],
            opdradiology = [],
            opdpayment = [],
            pnaccount = [],
            delpahrmacy = [],
            dellaboratory = [],
            delradiology = [],
            delhospital = [];
            
        for (var i = 0; i < data.length; i++) {
            date.push(data[i]["datex"]);
             total.push(data[i]["total"]);
            drugs.push(data[i]["drugin"]);
            medsupply.push(data[i]["medsplyin"]);
            pharmisc.push(data[i]["pharmiscin"]);
            laboratory.push(data[i]["labin"]);
            radiology.push(data[i]["radin"]);
            hospital.push(data[i]["hospin"]);
            ipdpayment.push(data[i]["ipdayin"]);
            hmo.push(data[i]["hmoacctin"]);
            pcso.push(data[i]["pcsoacctin"]);
            phic.push(data[i]["phicacctin"]);
            opdlaboratory.push(data[i]["opdlabin"]);
            opdradiology.push(data[i]["opdradin"]);
            opdpayment.push(data[i]["opdhospin"]);
            pnaccount.push(data[i]["pnacctin"]);
            delpahrmacy.push(data[i]["deliverypharin"]);
            dellaboratory.push(data[i]["deliverylabin"]);
            delradiology.push(data[i]["deliveryradin"]);
            delhospital.push(data[i]["deliveryradin"]);
        }
        
         
        var ctx = document.getElementById('myChart').getContext('2d');
        
         chartObj = new Chart(ctx, {
            type: 'line',
            data: {
                labels: date,
                datasets: [
                    {
                        label: "Income",
                        fill: false,
                        borderColor: 'rgb(128, 0, 0)',
                        data: total
                      
                    },
                    {
                        label: "Drugs",
                        fill: false,
                        borderColor: 'rgb(0, 204, 153)',
                        data: drugs,
                        hidden: true
                      
                    },
                    {
                        label: "Medical Supply",
                        fill: false,
                        borderColor: 'rgb(0, 153, 51)',
                        data: medsupply,
                        hidden: true
                    },
                    {
                        label: "Pharmacy Miscellaneous",
                        fill: false,
                        borderColor: 'rgb(255, 153, 51)',
                        data: pharmisc,
                        hidden: true
                    },
                    {
                        label: "Laboratory",
                        fill: false,
                        borderColor: 'rgb(51, 153, 255)',
                        data: laboratory,
                        hidden: true
                    },
                    {
                        label: "Radiology",
                        fill: false,
                        borderColor: 'rgb(255, 102, 204)',
                        data: radiology,
                        hidden: true
                    },
                    {
                        label: "Hospital",
                        fill: false,
                        borderColor: 'rgb(51, 204, 204)',
                        data: hospital,
                        hidden: true
                    },
                    {
                        label: "IPD Payment",
                        fill: false,
                        borderColor: 'rgb(51, 153, 102)',
                        data: ipdpayment,
                        hidden: true
                    },
                    {
                        label: "HMO",
                        fill: false,
                        borderColor: 'rgb(0, 51, 0)',
                        data: hmo,
                        hidden: true
                    },
                    {
                        label: "PCSO",
                        fill: false,
                        borderColor: 'rgb(0, 255, 0)',
                        data: pcso,
                        hidden: true
                    },
                    {
                        label: "PHIC",
                        fill: false,
                        borderColor: 'rgb(0, 102, 204)',
                        data: phic,
                        hidden: true
                    },
                    {
                        label: "OPD Laboratory",
                        fill: false,
                        borderColor: 'rgb(255, 0, 102)',
                        data: opdlaboratory,
                        hidden: true
                    },
                    {
                        label: "OPD Radiology",
                        fill: false,
                        borderColor: 'rgb(255, 204, 0)',
                        data: opdradiology,
                        hidden: true
                    },
                    {
                        label: "OPD Payment",
                        fill: false,
                        borderColor: 'rgb(255, 0, 0)',
                        data: opdpayment,
                        hidden: true
                    },
                    {
                        label: "PN Payment",
                        fill: false,
                        borderColor: 'rgb(204, 0, 204)',
                        data: pnaccount,
                        hidden: true
                    },
                    {
                        label: "Delivery Pharmacy",
                        fill: false,
                        borderColor: 'rgb(0, 0, 255)',
                        data: delpahrmacy,
                        hidden: true
                    },
                    {
                        label: "Delivery Laboratory",
                        fill: false,
                        borderColor: 'rgb(204, 51, 0)',
                        data: dellaboratory,
                        hidden: true
                    },
                    {
                        label: "Delivery Radiology",
                        fill: false,
                        borderColor: 'rgb(204, 153, 0)',
                        data: delradiology,
                        hidden: true
                    },
                    {
                        label: "Delivery Hospital",
                        fill: false,
                        borderColor: 'rgb(153, 0, 51)',
                        data: delhospital,
                        hidden: true
                    }
            ]
            },
           options: {
                responsive : true,
                tooltips : {
                    mode : 'index',
                    intersect : false,
                    callbacks: {
                    label: function(tooltipItem, chart) {
                            return chart.datasets[tooltipItem.datasetIndex]["label"] +  ' ₱' + accounting.format(tooltipItem.yLabel,2);
                        }
                    }
                }
            }
        });
           
    }
    
}

function load_scriptmonth(scriptUrl)
{
    $.getScript(scriptUrl)
        .done(function( script, textStatus ) {
            console.log( textStatus );
            monthly.get_monthly_transaction();
            
        })
        .fail(function( jqxhr, settings, exception ) {
         console.log("fail to load script");
    });
}