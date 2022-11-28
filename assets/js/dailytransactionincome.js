$('.date').datetimepicker({
        format: 'YYYY-MM-DD'
});

var oTable = $('#daily-transaction-table').DataTable({ 
   
});

var daily = {
    get_daily_transaction: function ()
    {

       
            $.ajax({
                    type: 'POST',
                    url:  BASE_URL + "user/get_daily",
                    data: $('#search-daily-form').serialize(),
                    dataType: 'json'
                   
                }).done(function(data1) {
                   
                    console.log(data1);
                        if (data1.status) 
                        {
                           $('#daily-transaction-table').dataTable().fnDestroy();
                           var census_table = $('#daily-transaction-table').DataTable({
                               dom: 'frtip',
                               // responsive: true,
                                processing:true, 
                                order: [[ 0, "desc" ]],
                                scrollX:true,
                                'rowCallback': function(row, data, index){
                                     $(row).find('td:eq(1)').css('background-color', '#BBDEFB');
                                     $(row).find('td:eq(5)').css('background-color', '#C5CAE9');
                                 }
                                
                            });
                           census_table.clear();
                           daily.create_chart(data1.census_daily);
                           if(data1.census_daily.length > 0)
                            {
                               for (var i = 0; i < data1.census_daily.length; i++) 
                               {
                                   var first_date = moment(data1.census_daily[i]["datex"]).format('ddd, MMM DD YYYY');
                                   census_table.row.add(
                                    [
                                        
                                        first_date,
                                        '₱'+ accounting.format(data1.census_daily[i]["total"],2) ,
                                        '₱ '+ accounting.format(data1.census_daily[i]["drugs"],2),
                                        '₱'+ accounting.format(data1.census_daily[i]["medsply"],2),
                                        '₱'+ accounting.format(data1.census_daily[i]["pharmisc"],2),
                                        '<p style="color:green;">₱'+ accounting.format(data1.census_daily[i]["pharmacy"],2)+ '</p>',
                                        '₱'+ accounting.format(data1.census_daily[i]["lab"],2),
                                        '₱'+ accounting.format(data1.census_daily[i]["rad"],2),
                                        '₱'+ accounting.format(data1.census_daily[i]["hosp"],2),
                                        '₱'+ accounting.format(data1.census_daily[i]["ipdpay"],2),
                                        '₱'+ accounting.format(data1.census_daily[i]["hmoacct"],2),
                                        '₱'+ accounting.format(data1.census_daily[i]["pcsoacct"],2),
                                        '₱'+ accounting.format(data1.census_daily[i]["phicacct"],2),
                                        '₱'+ accounting.format(data1.census_daily[i]["opdlab"],2),
                                        '₱'+ accounting.format(data1.census_daily[i]["opdrad"],2),
                                        '₱'+ accounting.format(data1.census_daily[i]["opdhosp"],2),
                                        '₱'+ accounting.format(data1.census_daily[i]["pnacct"],2),
                                        '₱'+ accounting.format(data1.census_daily[i]["deliveryphar"],2),
                                        '₱'+ accounting.format(data1.census_daily[i]["deliverylab"],2),
                                        '₱'+ accounting.format(data1.census_daily[i]["deliveryrad"],2),
                                        '₱'+ accounting.format(data1.census_daily[i]["deliveryhosp"],2)
                                        
                                    ]   
                                    ).draw(false);
                                }
                            }
                            else
                            {
                                $('#daily-transaction-table').dataTable().fnDestroy();
                                var census_table = $('#daily-transaction-table').DataTable();
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
            pharmacy = [],
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
            date.push(moment(data[i]["datex"]).format('ddd,MMM DD YYYY'));
            total.push(data[i]["total"]);
            drugs.push(data[i]["drugs"]);
            medsupply.push(data[i]["medsply"]);
            pharmisc.push(data[i]["pharmisc"]);
            pharmacy.push(data[i]["pharmacy"]);
            laboratory.push(data[i]["lab"]);
            radiology.push(data[i]["rad"]);
            hospital.push(data[i]["hosp"]);
            ipdpayment.push(data[i]["ipdpay"]);
            hmo.push(data[i]["hmoacct"]);
            pcso.push(data[i]["pcsoacct"]);
            phic.push(data[i]["phicacct"]);
            opdlaboratory.push(data[i]["opdlab"]);
            opdradiology.push(data[i]["opdrad"]);
            opdpayment.push(data[i]["opdhosp"]);
            pnaccount.push(data[i]["pnacct"]);
            delpahrmacy.push(data[i]["deliveryphar"]);
            dellaboratory.push(data[i]["deliverylab"]);
            delradiology.push(data[i]["deliveryrad"]);
            delhospital.push(data[i]["deliveryhosp"]);
        }
        
        var ctx = document.getElementById('myChart').getContext('2d');
        var chart = new Chart(ctx, {
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
                        label: "Drugs and Meds",
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
                        label: "Pharmacy",
                        fill: false,
                        borderColor: 'rgb(102, 204, 255)',
                        data: pharmacy,
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
                            return chart.datasets[tooltipItem.datasetIndex]["label"] +  ': ₱' + accounting.format(tooltipItem.yLabel,2);
                        }
                    }
                }
            }
        });
    },
    
       get_daily_transaction_report : function()
    {
        start_date = $('#search-daily-form input[name=dating]').val(); 
        $("#daily-transaction-form input[name=s_date]").val(start_date);
        $("#daily-transaction-form").submit();
    }
    
}

function load_scripting(scriptUrl)
{
    $.getScript(scriptUrl)
        .done(function( script, textStatus ) {
            console.log( textStatus );
            daily.get_daily_transaction();
            
        })
        .fail(function( jqxhr, settings, exception ) {
         console.log("fail to load script");
    });
}

