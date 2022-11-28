var interval;
var thisDate;
var thisData;

var pxgenderchart = null;
var citymunpx_table = null;
var provincepx_table = null;
var roomratepx_table = null;
var agecateg_table = null;
var sexcateg_table = null;
var insurancepx_table = null;

var InpatientGenderCategory = "";
var InpatientAgexxxCategory = "";
var InpatientCityMuCategory = "";
var InpatientProvinCategory = "";
var InpatientInsuraCategory = "";
var InpatientRoomocCategory = "";
var InpatientVolumeCategory = "";

var SelectedMonthYear = "";
var SelectedPxtypexxx = "";

var TotalPatientCitymun = 0;

$(function () 
{
    "use strict";
    getInpatientOverAllStatistics();
});


function getInpatientOverAllStatistics()
{
    $('#totalPatientViaGender').html("");
    $('#totalPatientViaAge').html("");
    $('#totalPatientViaCityMun').html("");
    $('#totalPatientViaProvince').html("");
    $('#totalPatientViaInsurance').html("");
    $('#totalPatientViaRoomOccupancyRate').html("");
    $('#totalPatientViaRequestVolume').html("");
    
    swal
    ({
        title: "Please wait!",
        text: "Fetching of data is still ongoing.",
        imageUrl:  BASE_URL +"assets/img/medical_loading.gif",
        imageSize: '300x200',
        showCancelButton: false,
        showConfirmButton: false,
        allowEscapeKey : false,
        allowOutsideClick: false
    });

    interval = setInterval(function()
    {
        var gender = $('#totalPatientViaGender').html();
        var agexxx = $('#totalPatientViaAge').html();
        var citymn = $('#totalPatientViaCityMun').html();
        var provin = $('#totalPatientViaProvince').html();
        var roomoc = $('#totalPatientViaRoomOccupancyRate').html();
        var volreq = $('#totalPatientViaRequestVolume').html();

        if(gender !== ""  && agexxx !== "" && citymn !== "" && provin !== "" && roomoc !== "" && volreq !== "")
        {
            swal.close();
            
            setTimeout(function() 
            {   
                clearInterval(interval);
            });
        }
    }, 5000);
    
    SelectedMonthYear = "";
    SelectedPxtypexxx = "";
    
    var monthyear = $('#monthid_coveredDate').val();
    var pxtype = $('#selectid_patienttype').val();
    
    SelectedMonthYear = SelectedMonthYear + monthyear;
    SelectedPxtypexxx = SelectedPxtypexxx + pxtype;

    getInpatientGenderCategory(monthyear,pxtype);
    getInpatientAgexxxCategory(monthyear,pxtype);
    getInpatientCityMunCategory(monthyear,pxtype);
    getInpatientProvinceCategory(monthyear,pxtype);
    getInpatientInsuranceCategory(monthyear,pxtype);
    getInpatientRoomOccupancyRate(monthyear,pxtype);
    getInpatientVolumeRequestCategory(monthyear);
}

function getInpatientGenderCategory(monthyear,pxtype)
{
    $.ajax
    ({
        type: 'POST',
        url:  BASE_URL + "Dashboard/getInpatientGender",
        data: 
        {
            monthyearx:monthyear,
            pxtypex:pxtype
        },
        dataType: 'json'
    })
    .done(function(data1) 
    {
        if (data1.status) 
        {
            var getmale = data1.getinpatientgender["getMALE"];
            var getfemale = data1.getinpatientgender["getFEMALE"];
            var totalPatient = parseInt(data1.getinpatientgender["getMALE"]) + parseInt(data1.getinpatientgender["getFEMALE"]);
            
            $('#totalPatientViaGender').html(accounting.format(totalPatient) + " Patient(s)");
            
            var MALEPercentage = accounting.format((getmale/totalPatient)*100,2);
            var FEMAPercentage = accounting.format((getfemale/totalPatient)*100,2);
            
            var MalePercentRoundedOff = Math.round(MALEPercentage);
            var FemaPercentRoundedOff = Math.round(FEMAPercentage);

            $('#MALETotal').html(accounting.format(getmale) + " (" + MalePercentRoundedOff + "%)");
            $('#FEMALETotal').html(accounting.format(getfemale) + " (" + FemaPercentRoundedOff + "%)");

            if(accounting.format(getmale) === "0" && accounting.format(getfemale) === "0")
            {
                disableInpatientGenderChart();
            }
            else
            {
                
                getChartForInpatientGender(MalePercentRoundedOff, FemaPercentRoundedOff);
            }
        }
        else
        {
            console.log('fail');
        }
    });
}

function getInpatientAgexxxCategory(monthyear,pxtype)
{
    $.ajax
    ({
        type: 'POST',
        url:  BASE_URL + "Dashboard/getInpatientAge",
        data: 
        {
            monthyearx:monthyear,
            pxtypex:pxtype
        },
        dataType: 'json'
    })
    .done(function(data2) 
    {
        if (data2.status) 
        {
            var getInfant = data2.getinpatientage["getInfant"];
            var getChild = data2.getinpatientage["getChild"];
            var getYouth = data2.getinpatientage["getYouth"];
            var getAdult = data2.getinpatientage["getAdult"];
            var getSenior = data2.getinpatientage["getSenior"];

            var totalPatient = parseInt(data2.getinpatientage["getInfant"]) + 
                               parseInt(data2.getinpatientage["getChild"]) +
                               parseInt(data2.getinpatientage["getYouth"]) +
                               parseInt(data2.getinpatientage["getAdult"]) +
                               parseInt(data2.getinpatientage["getSenior"]);
                       
            $('#totalPatientViaAge').html(accounting.format(totalPatient) + " Patient(s)");
            
            var InfantPercentage = accounting.format((getInfant/totalPatient)*100,2);
            var ChildxPercentage = accounting.format((getChild/totalPatient)*100,2);
            var YouthxPercentage = accounting.format((getYouth/totalPatient)*100,2);
            var AdultxPercentage = accounting.format((getAdult/totalPatient)*100,2);
            var SeniorPercentage = accounting.format((getSenior/totalPatient)*100,2);
            
            var acctformInfant = accounting.format(getInfant);
            var acctformChildx = accounting.format(getChild);
            var acctformYouthx = accounting.format(getYouth);
            var acctformAdultx = accounting.format(getAdult);
            var acctformSenior = accounting.format(getSenior);

            $('#InfantTotal').html(acctformInfant + " (" + InfantPercentage + "%)");
            $('#ChildTotal').html(acctformChildx + " (" + ChildxPercentage + "%)");
            $('#YouthTotal').html(acctformYouthx + " (" + YouthxPercentage + "%)");
            $('#AdultTotal').html(acctformAdultx + " (" + AdultxPercentage + "%)");
            $('#SeniorTotal').html(acctformSenior + " (" + SeniorPercentage + "%)");
            
            var agecanvas = $('#inpatient_stat_age_category_pie_chart');
            var agecontext = agecanvas.get(0).getContext("2d");

            if(acctformInfant === "0" && acctformChildx === "0" && acctformYouthx === "0" && acctformAdultx === "0" && acctformSenior === "0")
            {
                if(window.bar !== undefined) 
                window.bar.destroy(); 
                window.bar = new Chart(agecontext, disableInpatientAgeChart());
            }
            else
            {
                if(window.bar !== undefined)
                window.bar.destroy(); 
                var agechart = window.bar = new Chart(agecontext, getChartForInpatientAge(InfantPercentage, ChildxPercentage, YouthxPercentage, AdultxPercentage, SeniorPercentage));
                
                document.getElementById("inpatient_stat_age_category_pie_chart").onclick = function(evt)
                {   
                    var activePoints = agechart.getElementsAtEvent(evt);

                    if(activePoints.length > 0)
                    {
                        var clickedElementindex = activePoints[0]["_index"];
                        var label = agechart.data.labels[clickedElementindex];
                        var value = agechart.data.datasets[0].data[clickedElementindex];

                        var category = label.toUpperCase();

                        showAllPatientUnderAgeCateg(category);
                    }
                };
            }
        }
        else
        {
            console.log('fail');
        }
    });
}

function getInpatientCityMunCategory(monthyear,pxtype)
{
    $.ajax
    ({
        type: 'POST',
        url:  BASE_URL + "Dashboard/getInpatientCityMunicipality",
        data: 
        {
            monthyearx:monthyear,
            pxtypex: pxtype
        },
        dataType: 'json'
    })
    .done(function(data) 
    {
        if(data.status === false)
        {
            $('#totalPatientViaCityMun').html("0" + " Patient(s)");
            $('#CityAddNamexO').html('&#9635' + ' ' + 'NO DATA' + ': ');
            $('#CityAddValueO').html('0' + " (0.00%)");
            
            for (var i = 0; i < 11; i++)
            {
                $('#CityAddNamex' + i).html('&#9635' + ' ' + 'NO DATA' + ': ');
                $('#CityAddValue' + i).html('0' + " (0.00%)");
            }
            
            disableInpatientCityMunChart();
        }
        else
        {            
            var cityaddtoptentotal = 0;
            var cityaddotherstotal = 0;
            var cityaddtoptenstrng = "";
            var cityaddothersstrng = "";
            var cityaddtoptenvalue = "";
            var cityaddothersvalue = "";

            for (var cv = 0; cv < data.getinpatientcitymun.length; cv++)
            {
                cityaddtoptentotal = parseInt(cityaddtoptentotal) + parseInt(data.getinpatientcitymun[cv]['MAX_COUNT']);
                cityaddtoptenstrng = cityaddtoptenstrng + data.getinpatientcitymun[cv]['cityadd'] + "|";
                cityaddtoptenvalue = cityaddtoptenvalue + data.getinpatientcitymun[cv]['MAX_COUNT'] + "|";
            }
            
            $.ajax
            ({
                type: 'POST',
                url:  BASE_URL + "Dashboard/getInpatientCityMunicipalityOthers",
                data: 
                {
                    monthyearx:monthyear,
                    pxtypex: pxtype,
                    citynames: cityaddtoptenstrng
                },
                dataType: 'json'
            })
            .done(function(data2) 
            {
                var cityaddtotaltoptenandothers = 0;
                var cityaddstrngtoptenandothers = "";
                var cityaddvaluetoptenandothers = "";
                
                for (var cvothers = 0; cvothers < data2.getinpatientcitymunothers.length; cvothers++)
                {
                    cityaddotherstotal = parseInt(cityaddotherstotal) + parseInt(data2.getinpatientcitymunothers[cvothers]['MAX_COUNT_OTHERS']);
                    cityaddothersstrng = cityaddothersstrng + data2.getinpatientcitymunothers[cvothers]['cityadd'] + "|";
                    cityaddothersvalue = cityaddothersvalue + data2.getinpatientcitymunothers[cvothers]['MAX_COUNT_OTHERS'] + "|";
                }
                
                cityaddtotaltoptenandothers = parseInt(cityaddtoptentotal) + parseInt(cityaddotherstotal);
                cityaddstrngtoptenandothers = cityaddtoptenstrng + "|" + "OTHERS";
                cityaddvaluetoptenandothers = cityaddtoptenvalue + "|" + cityaddotherstotal;
                
                var cityaddtoptennamesstr = cityaddstrngtoptenandothers.split("|");
                var cityaddtoptennamesarr = removeIndex(cityaddtoptennamesstr,'');
                
                var cityaddtoptenvaluestr = cityaddvaluetoptenandothers.split("|");
                var cityaddtoptenvaluearr = removeIndex(cityaddtoptenvaluestr,'');
                
                $('#totalPatientViaCityMun').html(accounting.format(cityaddtotaltoptenandothers) + " Patient(s)");
                
                var cityaddvar = [];
                var maxcounter = [];
                var percentval = [];
                
                var cityaddtoptenlength = parseInt(data.getinpatientcitymun.length) + parseInt(1);                
                for (var percentcv = 0; percentcv < cityaddtoptenlength; percentcv++)
                {
                    cityaddvar[percentcv] = cityaddtoptennamesarr[percentcv];
                    maxcounter[percentcv] = cityaddtoptenvaluearr[percentcv];
                    percentval[percentcv] = accounting.format((maxcounter[percentcv]/cityaddtotaltoptenandothers)*100,2);
                }

                var citymunnamestrings = "";
                var citymunpercentagex = "";
                var citymunpercentrate = "";
                var citynameforothersx = "";

                if(cityaddtoptenlength === 2)
                {
                    citymunnamestrings = cityaddvar[0] + "|" + "NO DATA" + "|" + "NO DATA" + "|" + "NO DATA" + "|" + "NO DATA" + "|" +
                                         "NO DATA" + "|" + "NO DATA" + "|" + "NO DATA" + "|" + "NO DATA" + "|" + "NO DATA" + "|" + "OTHERS";

                    citymunpercentagex = percentval[0] + "|" + "0.00" + "|" + "0.00" + "|" + "0.00" + "|" + "0.00" + "|" +
                                         "0.00" + "|" + "0.00" + "|" + "0.00" + "|" + "0.00" + "|" + "0.00" + "|" + "0.00";

                    citymunpercentrate = maxcounter[0] + "|" + "0" + "|" + "0" + "|" + "0" + "|" + "0" + "|" +
                                         "0" + "|" + "0" + "|" + "0" + "|" + "0" + "|" + "0" + "|" + "0";   

                    for(var num1hasdatacv = 0; num1hasdatacv < 1; num1hasdatacv++ )
                    {
                        $('#CityAddValue' + num1hasdatacv).html(accounting.format(maxcounter[num1hasdatacv]) + " (" + percentval[num1hasdatacv] + "%)");
                        $('#CityAddNamex' + num1hasdatacv).html('&#9635' + " " + cityaddvar[num1hasdatacv] + ": ");
                    }

                    for(var num1nondatacv = 1; num1nondatacv < 11; num1nondatacv++ )
                    {
                        $('#CityAddValue' + num1nondatacv).html("0" + " (0.00%)");
                        $('#CityAddNamex' + num1nondatacv).html('&#9635' + " " + "NO DATA" + ": ");
                    }   
                    
                    $('#CityAddValueO').html("0" + " (0.00%)");
                    $('#CityAddNamexO').html('&#9635' + " " + "OTHERS" + ": ");
                }
                else if(cityaddtoptenlength === 3)
                {
                    citymunnamestrings = cityaddvar[0] + "|" + cityaddvar[1] + "|" + "NO DATA" + "|" + "NO DATA" + "|" + "NO DATA" + "|" +
                                         "NO DATA" + "|" + "NO DATA" + "|" + "NO DATA" + "|" + "NO DATA" + "|" + "NO DATA" + "|" + "OTHERS";

                    citymunpercentagex = percentval[0] + "|" + percentval[1] + "|" + "0.00" + "|" + "0.00" + "|" + "0.00" + "|" +
                                         "0.00" + "|" + "0.00" + "|" + "0.00" + "|" + "0.00" + "|" + "0.00" + "|" + "0.00";

                    citymunpercentrate = maxcounter[0] + "|" + maxcounter[1] + "|" + "0" + "|" + "0" + "|" + "0" + "|" +
                                         "0" + "|" + "0" + "|" + "0" + "|" + "0" + "|" + "0" + "|" + "0";

                    for(var num2hasdatacv = 0; num2hasdatacv < 2; num2hasdatacv++ )
                    {
                        $('#CityAddValue' + num2hasdatacv).html(accounting.format(maxcounter[num2hasdatacv]) + " (" + percentval[num2hasdatacv] + "%)");
                        $('#CityAddNamex' + num2hasdatacv).html('&#9635' + " " + cityaddvar[num2hasdatacv] + ": ");
                    }

                    for(var num2nondatacv = 2; num2nondatacv < 11; num2nondatacv++ )
                    {
                        $('#CityAddValue' + num2nondatacv).html("0" + " (0.00%)");
                        $('#CityAddNamex' + num2nondatacv).html('&#9635' + " " + "NO DATA" + ": ");
                    }   
                    
                    $('#CityAddValueO').html("0" + " (0.00%)");
                    $('#CityAddNamexO').html('&#9635' + " " + "OTHERS" + ": ");
                }
                else if(cityaddtoptenlength === 4)
                {
                    citymunnamestrings = cityaddvar[0] + "|" + cityaddvar[1] + "|" + cityaddvar[2] + "|" + "NO DATA" + "|" + "NO DATA" + "|" +
                                         "NO DATA" + "|" + "NO DATA" + "|" + "NO DATA" + "|" + "NO DATA" + "|" + "NO DATA" + "|" + "OTHERS";

                    citymunpercentagex = percentval[0] + "|" + percentval[1] + "|" + percentval[2] + "|" + "0.00" + "|" + "0.00" + "|" +
                                         "0.00" + "|" + "0.00" + "|" + "0.00" + "|" + "0.00" + "|" + "0.00" + "|" + "0.00";

                    citymunpercentrate = maxcounter[0] + "|" + maxcounter[1] + "|" + maxcounter[2] + "|" + "0" + "|" + "0" + "|" +
                                         "0" + "|" + "0" + "|" + "0" + "|" + "0" + "|" + "0" + "|" + "0";

                    for(var num3hasdatacv = 0; num3hasdatacv < 3; num3hasdatacv++ )
                    {
                        $('#CityAddValue' + num3hasdatacv).html(accounting.format(maxcounter[num3hasdatacv]) + " (" + percentval[num3hasdatacv] + "%)");
                        $('#CityAddNamex' + num3hasdatacv).html('&#9635' + " " + cityaddvar[num3hasdatacv] + ": ");
                    }

                    for(var num3nondatacv = 3; num3nondatacv < 11; num3nondatacv++ )
                    {
                        $('#CityAddValue' + num3nondatacv).html("0" + " (0.00%)");
                        $('#CityAddNamex' + num3nondatacv).html('&#9635' + " " + "NO DATA" + ": ");
                    }   
                    
                    $('#CityAddValueO').html("0" + " (0.00%)");
                    $('#CityAddNamexO').html('&#9635' + " " + "OTHERS" + ": ");
                }
                else if(cityaddtoptenlength === 5)
                {
                    citymunnamestrings = cityaddvar[0] + "|" + cityaddvar[1] + "|" + cityaddvar[2] + "|" + cityaddvar[3] + "|" + "NO DATA" + "|" +
                                         "NO DATA" + "|" + "NO DATA" + "|" + "NO DATA" + "|" + "NO DATA" + "|" + "NO DATA" + "|" + "OTHERS";

                    citymunpercentagex = percentval[0] + "|" + percentval[1] + "|" + percentval[2] + "|" + percentval[3] + "|" + "0.00" + "|" +
                                         "0.00" + "|" + "0.00" + "|" + "0.00" + "|" + "0.00" + "|" + "0.00" + "|" + "0.00";

                    citymunpercentrate = maxcounter[0] + "|" + maxcounter[1] + "|" + maxcounter[2] + "|" + maxcounter[3] + "|" + "0" + "|" +
                                         "0" + "|" + "0" + "|" + "0" + "|" + "0" + "|" + "0" + "|" + "0";

                    for(var num4hasdatacv = 0; num4hasdatacv < 4; num4hasdatacv++ )
                    {
                        $('#CityAddValue' + num4hasdatacv).html(accounting.format(maxcounter[num4hasdatacv]) + " (" + percentval[num4hasdatacv] + "%)");
                        $('#CityAddNamex' + num4hasdatacv).html('&#9635' + " " + cityaddvar[num4hasdatacv] + ": ");
                    }

                    for(var num4nondatacv = 4; num4nondatacv < 11; num4nondatacv++ )
                    {
                        $('#CityAddValue' + num4nondatacv).html("0" + " (0.00%)");
                        $('#CityAddNamex' + num4nondatacv).html('&#9635' + " " + "NO DATA" + ": ");
                    }      
                    
                    $('#CityAddValueO').html("0" + " (0.00%)");
                    $('#CityAddNamexO').html('&#9635' + " " + "OTHERS" + ": ");
                }
                else if(cityaddtoptenlength === 6)
                {
                    citymunnamestrings = cityaddvar[0] + "|" + cityaddvar[1] + "|" + cityaddvar[2] + "|" + cityaddvar[3] + "|" + cityaddvar[4] + "|" +
                                         "NO DATA" + "|" + "NO DATA" + "|" + "NO DATA" + "|" + "NO DATA" + "|" + "NO DATA" + "|" + "OTHERS";

                    citymunpercentagex = percentval[0] + "|" + percentval[1] + "|" + percentval[2] + "|" + percentval[3] + "|" + percentval[4] + "|" +
                                         "0.00" + "|" + "0.00" + "|" + "0.00" + "|" + "0.00" + "|" + "0.00" + "|" + "0.00";

                    citymunpercentrate = maxcounter[0] + "|" + maxcounter[1] + "|" + maxcounter[2] + "|" + maxcounter[3] + "|" + maxcounter[4] + "|" +
                                         "0" + "|" + "0" + "|" + "0" + "|" + "0" + "|" + "0" + "|" + "0";

                    for(var num5hasdatacv = 0; num5hasdatacv < 5; num5hasdatacv++ )
                    {
                        $('#CityAddValue' + num5hasdatacv).html(accounting.format(maxcounter[num5hasdatacv]) + " (" + percentval[num5hasdatacv] + "%)");
                        $('#CityAddNamex' + num5hasdatacv).html('&#9635' + " " + cityaddvar[num5hasdatacv] + ": ");
                    }

                    for(var num5nondatacv = 5; num5nondatacv < 11; num5nondatacv++ )
                    {
                        $('#CityAddValue' + num5nondatacv).html("0" + " (0.00%)");
                        $('#CityAddNamex' + num5nondatacv).html('&#9635' + " " + "NO DATA" + ": ");
                    } 
                    
                    $('#CityAddValueO').html("0" + " (0.00%)");
                    $('#CityAddNamexO').html('&#9635' + " " + "OTHERS" + ": ");
                }
                else if(cityaddtoptenlength === 7)
                {
                    citymunnamestrings = cityaddvar[0] + "|" + cityaddvar[1] + "|" + cityaddvar[2] + "|" + cityaddvar[3] + "|" + cityaddvar[4] + "|" +
                                         cityaddvar[5] + "|" + "NO DATA" + "|" + "NO DATA" + "|" + "NO DATA" + "|" + "NO DATA" + "|" + "OTHERS";

                    citymunpercentagex = percentval[0] + "|" + percentval[1] + "|" + percentval[2] + "|" + percentval[3] + "|" + percentval[4] + "|" +
                                         percentval[5] + "|" + "0.00" + "|" + "0.00" + "|" + "0.00" + "|" + "0.00" + "|" + "0.00";

                    citymunpercentrate = maxcounter[0] + "|" + maxcounter[1] + "|" + maxcounter[2] + "|" + maxcounter[3] + "|" + maxcounter[4] + "|" +
                                         maxcounter[5] + "|" + "0" + "|" + "0" + "|" + "0" + "|" + "0" + "|" + "0";

                    for(var num6hasdatacv = 0; num6hasdatacv < 6; num6hasdatacv++ )
                    {
                        $('#CityAddValue' + num6hasdatacv).html(accounting.format(maxcounter[num6hasdatacv]) + " (" + percentval[num6hasdatacv] + "%)");
                        $('#CityAddNamex' + num6hasdatacv).html('&#9635' + " " + cityaddvar[num6hasdatacv] + ": ");
                    }

                    for(var num6nondatacv = 6; num6nondatacv < 11; num6nondatacv++ )
                    {
                        $('#CityAddValue' + num6nondatacv).html("0" + " (0.00%)");
                        $('#CityAddNamex' + num6nondatacv).html('&#9635' + " " + "NO DATA" + ": ");
                    } 
                    
                    $('#CityAddValueO').html("0" + " (0.00%)");
                    $('#CityAddNamexO').html('&#9635' + " " + "OTHERS" + ": ");
                }
                else if(cityaddtoptenlength === 8)
                {
                    citymunnamestrings = cityaddvar[0] + "|" + cityaddvar[1] + "|" + cityaddvar[2] + "|" + cityaddvar[3] + "|" + cityaddvar[4] + "|" +
                                         cityaddvar[5] + "|" + cityaddvar[6] + "|" + "NO DATA" + "|" + "NO DATA" + "|" + "NO DATA" + "|" + "OTHERS";

                    citymunpercentagex = percentval[0] + "|" + percentval[1] + "|" + percentval[2] + "|" + percentval[3] + "|" + percentval[4] + "|" +
                                         percentval[5] + "|" + percentval[6] + "|" + "0.00" + "|" + "0.00" + "|" + "0.00" + "|" + "0.00";

                    citymunpercentrate = maxcounter[0] + "|" + maxcounter[1] + "|" + maxcounter[2] + "|" + maxcounter[3] + "|" + maxcounter[4] + "|" +
                                         maxcounter[5] + "|" + maxcounter[6] + "|" + "0" + "|" + "0" + "|" + "0" + "|" + "0";

                    for(var num7hasdatacv = 0; num7hasdatacv < 7; num7hasdatacv++ )
                    {
                        $('#CityAddValue' + num7hasdatacv).html(accounting.format(maxcounter[num7hasdatacv]) + " (" + percentval[num7hasdatacv] + "%)");
                        $('#CityAddNamex' + num7hasdatacv).html('&#9635' + " " + cityaddvar[num7hasdatacv] + ": ");
                    }

                    for(var num7nondatacv = 7; num7nondatacv < 11; num7nondatacv++ )
                    {
                        $('#CityAddValue' + num7nondatacv).html("0" + " (0.00%)");
                        $('#CityAddNamex' + num7nondatacv).html('&#9635' + " " + "NO DATA" + ": ");
                    } 
                    
                    $('#CityAddValueO').html("0" + " (0.00%)");
                    $('#CityAddNamexO').html('&#9635' + " " + "OTHERS" + ": ");
                }
                else if(cityaddtoptenlength === 9)
                {
                    citymunnamestrings = cityaddvar[0] + "|" + cityaddvar[1] + "|" + cityaddvar[2] + "|" + cityaddvar[3] + "|" + cityaddvar[4] + "|" +
                                         cityaddvar[5] + "|" + cityaddvar[6] + "|" + cityaddvar[7] + "|" + "NO DATA" + "|" + "NO DATA" + "|" + "OTHERS";

                    citymunpercentagex = percentval[0] + "|" + percentval[1] + "|" + percentval[2] + "|" + percentval[3] + "|" + percentval[4] + "|" +
                                         percentval[5] + "|" + percentval[6] + "|" + percentval[7] + "|" + "0.00" + "|" + "0.00" + "|" + "0.00";

                    citymunpercentrate = maxcounter[0] + "|" + maxcounter[1] + "|" + maxcounter[2] + "|" + maxcounter[3] + "|" + maxcounter[4] + "|" +
                                         maxcounter[5] + "|" + maxcounter[6] + "|" + maxcounter[7] + "|" + "0" + "|" + "0" + "|" + "0";

                    for(var num8hasdatacv = 0; num8hasdatacv < 8; num8hasdatacv++ )
                    {
                        $('#CityAddValue' + num8hasdatacv).html(accounting.format(maxcounter[num8hasdatacv]) + " (" + percentval[num8hasdatacv] + "%)");
                        $('#CityAddNamex' + num8hasdatacv).html('&#9635' + " " + cityaddvar[num8hasdatacv] + ": ");
                    }

                    for(var num8nondatacv = 8; num8nondatacv < 11; num8nondatacv++ )
                    {
                        $('#CityAddValue' + num8nondatacv).html("0" + " (0.00%)");
                        $('#CityAddNamex' + num8nondatacv).html('&#9635' + " " + "NO DATA" + ": ");
                    } 
                    
                    $('#CityAddValueO').html("0" + " (0.00%)");
                    $('#CityAddNamexO').html('&#9635' + " " + "OTHERS" + ": ");
                }
                else if(cityaddtoptenlength === 10)
                {
                    citymunnamestrings = cityaddvar[0] + "|" + cityaddvar[1] + "|" + cityaddvar[2] + "|" + cityaddvar[3] + "|" + cityaddvar[4] + "|" +
                                         cityaddvar[5] + "|" + cityaddvar[6] + "|" + cityaddvar[7] + "|" + cityaddvar[8] + "|" + "NO DATA" + "|" + "OTHERS";

                    citymunpercentagex = percentval[0] + "|" + percentval[1] + "|" + percentval[2] + "|" + percentval[3] + "|" + percentval[4] + "|" +
                                         percentval[5] + "|" + percentval[6] + "|" + percentval[7] + "|" + percentval[8] + "|" + "0.00" + "|" + "0.00";

                    citymunpercentrate = maxcounter[0] + "|" + maxcounter[1] + "|" + maxcounter[2] + "|" + maxcounter[3] + "|" + maxcounter[4] + "|" +
                                         maxcounter[5] + "|" + maxcounter[6] + "|" + maxcounter[7] + "|" + maxcounter[8] + "|" + "0" + "|" + "0";

                    for(var num9hasdatacv = 0; num9hasdatacv < 9; num9hasdatacv++ )
                    {
                        $('#CityAddValue' + num9hasdatacv).html(accounting.format(maxcounter[num9hasdatacv]) + " (" + percentval[num9hasdatacv] + "%)");
                        $('#CityAddNamex' + num9hasdatacv).html('&#9635' + " " + cityaddvar[num9hasdatacv] + ": ");
                    }

                    for(var num9nondatacv = 9; num9nondatacv < 11; num9nondatacv++ )
                    {
                        $('#CityAddValue' + num9nondatacv).html("0" + " (0.00%)");
                        $('#CityAddNamex' + num9nondatacv).html('&#9635' + " " + "NO DATA" + ": ");
                    } 
                    
                    $('#CityAddValueO').html("0" + " (0.00%)");
                    $('#CityAddNamexO').html('&#9635' + " " + "OTHERS" + ": ");
                }
                else
                {
                    citymunnamestrings = cityaddvar[0] + "|" + cityaddvar[1] + "|" + cityaddvar[2] + "|" + cityaddvar[3] + "|" + cityaddvar[4] + "|" +
                                         cityaddvar[5] + "|" + cityaddvar[6] + "|" + cityaddvar[7] + "|" + cityaddvar[8] + "|" + cityaddvar[9] + "|" + cityaddvar[10];

                    citymunpercentagex = percentval[0] + "|" + percentval[1] + "|" + percentval[2] + "|" + percentval[3] + "|" + percentval[4] + "|" +
                                         percentval[5] + "|" + percentval[6] + "|" + percentval[7] + "|" + percentval[8] + "|" + percentval[9] + "|" + percentval[10];

                    citymunpercentrate = maxcounter[0] + "|" + maxcounter[1] + "|" + maxcounter[2] + "|" + maxcounter[3] + "|" + maxcounter[4] + "|" +
                                         maxcounter[5] + "|" + maxcounter[6] + "|" + maxcounter[7] + "|" + maxcounter[8] + "|" + maxcounter[9] + "|" + maxcounter[10];  

                    citynameforothersx = cityaddvar[0] + "|" + cityaddvar[1] + "|" + cityaddvar[2] + "|" + cityaddvar[3] + "|" + cityaddvar[4] + "|" +
                                         cityaddvar[5] + "|" + cityaddvar[6] + "|" + cityaddvar[7] + "|" + cityaddvar[8] + "|" + cityaddvar[9];

                    for(var num10hasdatacv = 0; num10hasdatacv < 11; num10hasdatacv++ )
                    {
                        $('#CityAddValue' + num10hasdatacv).html(accounting.format(maxcounter[num10hasdatacv]) + " (" + percentval[num10hasdatacv] + "%)");
                        $('#CityAddNamex' + num10hasdatacv).html('&#9635' + " " + cityaddvar[num10hasdatacv] + ": ");
                        
                        $('#CityAddValueO').html(accounting.format(maxcounter[num10hasdatacv]) + " (" + percentval[num10hasdatacv] + "%)");
                        $('#CityAddNamexO').html('&#9635' + " " + "OTHERS" + ": ");
                    }                                      
                }
                
                getChartForInpatientCityMunicipality(citymunnamestrings, citymunpercentagex, monthyear, pxtype, citymunpercentrate, citynameforothersx);
                
            });
        }
    });
}

function getInpatientProvinceCategory(monthyear,pxtype)
{
    $.ajax
    ({
        type: 'POST',
        url:  BASE_URL + "Dashboard/getInpatientProvince",
        data: 
        {
            monthyearx:monthyear,
            pxtypex:pxtype
        },
        dataType: 'json'
    })
    .done(function(data) 
    {
        if(data.status === false)
        {
            $('#totalPatientViaProvince').html("0" + " Patient(s)");
            $('#ProvAddNamexO').html('&#9635' + ' ' + 'NO DATA' + ': ');
            $('#ProvAddValueO').html('0' + " (0.00%)");

            for(var num0nondatacv = 0; num0nondatacv < 10; num0nondatacv++ )
            {
                $('#ProvAddValue' + num0nondatacv).html("0" + " (0.00%)");
                $('#ProvAddNamex' + num0nondatacv).html('&#9635' + " " + "NO DATA" + ": ");
            }  
            
            disableInpatientProvinceChart();
        }
        else
        {
            var provaddtoptentotal = 0;
            var provaddotherstotal = 0;
            var provaddtoptenstrng = "";
            var provaddothersstrng = "";
            var provaddtoptenvalue = "";
            var provaddothersvalue = "";

            for (var cv = 0; cv < data.getinpatientprovince.length; cv++)
            {
                provaddtoptentotal = parseInt(provaddtoptentotal) + parseInt(data.getinpatientprovince[cv]['MAX_COUNT']);
                provaddtoptenstrng = provaddtoptenstrng + data.getinpatientprovince[cv]['provadd'] + "|";
                provaddtoptenvalue = provaddtoptenvalue + data.getinpatientprovince[cv]['MAX_COUNT'] + "|";
            }
            
            $.ajax
            ({
                type: 'POST',
                url:  BASE_URL + "Dashboard/getInpatientProvinceOthers",
                data: 
                {
                    monthyearx:monthyear,
                    pxtypex: pxtype,
                    provnames: provaddtoptenstrng
                },
                dataType: 'json'
            })
            .done(function(data2) 
            {
                var provaddtotaltoptenandothers = 0;
                var provaddstrngtoptenandothers = "";
                var provaddvaluetoptenandothers = "";
                
                for (var cvothers = 0; cvothers < data2.getinpatientprovinceothers.length; cvothers++)
                {
                    provaddotherstotal = parseInt(provaddotherstotal) + parseInt(data2.getinpatientprovinceothers[cvothers]['MAX_COUNT_OTHERS']);
                    provaddothersstrng = provaddothersstrng + data2.getinpatientprovinceothers[cvothers]['provadd'] + "|";
                    provaddothersvalue = provaddothersvalue + data2.getinpatientprovinceothers[cvothers]['MAX_COUNT_OTHERS'] + "|";
                }
                
                provaddtotaltoptenandothers = parseInt(provaddtoptentotal) + parseInt(provaddotherstotal);
                provaddstrngtoptenandothers = provaddtoptenstrng + "|" + "OTHERS";
                provaddvaluetoptenandothers = provaddtoptenvalue + "|" + provaddotherstotal;
                
                var provaddtoptennamesstr = provaddstrngtoptenandothers.split("|");
                var provaddtoptennamesarr = removeIndex(provaddtoptennamesstr,'');
                
                var provaddtoptenvaluestr = provaddvaluetoptenandothers.split("|");
                var provaddtoptenvaluearr = removeIndex(provaddtoptenvaluestr,'');
                
                $('#totalPatientViaProvince').html(accounting.format(provaddtotaltoptenandothers) + " Patient(s)");
                
                var provaddvar = [];
                var maxcounter = [];
                var percentval = [];
                
                var provaddtoptenlength = parseInt(data.getinpatientprovince.length) + parseInt(1);                
                for (var percentcv = 0; percentcv < provaddtoptenlength; percentcv++)
                {
                    provaddvar[percentcv] = provaddtoptennamesarr[percentcv];
                    maxcounter[percentcv] = provaddtoptenvaluearr[percentcv];
                    percentval[percentcv] = accounting.format((maxcounter[percentcv]/provaddtotaltoptenandothers)*100,2);
                }

                var provaddnamestrings = "";
                var provaddpercentagex = "";
                var provaddpercentrate = "";
                var provnameforothersx = "";

                if(provaddtoptenlength === 2)
                {
                    provaddnamestrings = provaddvar[0] + "|" + "NO DATA" + "|" + "NO DATA" + "|" + "NO DATA" + "|" + "NO DATA" + "|" +
                                         "NO DATA" + "|" + "NO DATA" + "|" + "NO DATA" + "|" + "NO DATA" + "|" + "NO DATA" + "|" + "OTHERS";

                    provaddpercentagex = percentval[0] + "|" + "0.00" + "|" + "0.00" + "|" + "0.00" + "|" + "0.00" + "|" +
                                         "0.00" + "|" + "0.00" + "|" + "0.00" + "|" + "0.00" + "|" + "0.00" + "|" + "0.00";

                    provaddpercentrate = maxcounter[0] + "|" + "0" + "|" + "0" + "|" + "0" + "|" + "0" + "|" +
                                         "0" + "|" + "0" + "|" + "0" + "|" + "0" + "|" + "0" + "|" + "0";   

                    for(var num1hasdatacv = 0; num1hasdatacv < 1; num1hasdatacv++ )
                    {
                        $('#ProvAddValue' + num1hasdatacv).html(accounting.format(maxcounter[num1hasdatacv]) + " (" + percentval[num1hasdatacv] + "%)");
                        $('#ProvAddNamex' + num1hasdatacv).html('&#9635' + " " + provaddvar[num1hasdatacv] + ": ");
                    }

                    for(var num1nondatacv = 1; num1nondatacv < 11; num1nondatacv++ )
                    {
                        $('#ProvAddValue' + num1nondatacv).html("0" + " (0.00%)");
                        $('#ProvAddNamex' + num1nondatacv).html('&#9635' + " " + "NO DATA" + ": ");
                    }   
                    
                    $('#ProvAddValueO').html("0" + " (0.00%)");
                    $('#ProvAddNamexO').html('&#9635' + " " + "OTHERS" + ": ");
                }
                else if(provaddtoptenlength === 3)
                {
                    provaddnamestrings = provaddvar[0] + "|" + provaddvar[1] + "|" + "NO DATA" + "|" + "NO DATA" + "|" + "NO DATA" + "|" +
                                         "NO DATA" + "|" + "NO DATA" + "|" + "NO DATA" + "|" + "NO DATA" + "|" + "NO DATA" + "|" + "OTHERS";

                    provaddpercentagex = percentval[0] + "|" + percentval[1] + "|" + "0.00" + "|" + "0.00" + "|" + "0.00" + "|" +
                                         "0.00" + "|" + "0.00" + "|" + "0.00" + "|" + "0.00" + "|" + "0.00" + "|" + "0.00";

                    provaddpercentrate = maxcounter[0] + "|" + maxcounter[1] + "|" + "0" + "|" + "0" + "|" + "0" + "|" +
                                         "0" + "|" + "0" + "|" + "0" + "|" + "0" + "|" + "0" + "|" + "0";

                    for(var num2hasdatacv = 0; num2hasdatacv < 2; num2hasdatacv++ )
                    {
                        $('#ProvAddValue' + num2hasdatacv).html(accounting.format(maxcounter[num2hasdatacv]) + " (" + percentval[num2hasdatacv] + "%)");
                        $('#ProvAddNamex' + num2hasdatacv).html('&#9635' + " " + provaddvar[num2hasdatacv] + ": ");
                    }

                    for(var num2nondatacv = 2; num2nondatacv < 11; num2nondatacv++ )
                    {
                        $('#ProvAddValue' + num2nondatacv).html("0" + " (0.00%)");
                        $('#ProvAddNamex' + num2nondatacv).html('&#9635' + " " + "NO DATA" + ": ");
                    }   
                    
                    $('#ProvAddValueO').html("0" + " (0.00%)");
                    $('#ProvAddNamexO').html('&#9635' + " " + "OTHERS" + ": ");
                }
                else if(provaddtoptenlength === 4)
                {
                    provaddnamestrings = provaddvar[0] + "|" + provaddvar[1] + "|" + provaddvar[2] + "|" + "NO DATA" + "|" + "NO DATA" + "|" +
                                         "NO DATA" + "|" + "NO DATA" + "|" + "NO DATA" + "|" + "NO DATA" + "|" + "NO DATA" + "|" + "OTHERS";

                    provaddpercentagex = percentval[0] + "|" + percentval[1] + "|" + percentval[2] + "|" + "0.00" + "|" + "0.00" + "|" +
                                         "0.00" + "|" + "0.00" + "|" + "0.00" + "|" + "0.00" + "|" + "0.00" + "|" + "0.00";

                    provaddpercentrate = maxcounter[0] + "|" + maxcounter[1] + "|" + maxcounter[2] + "|" + "0" + "|" + "0" + "|" +
                                         "0" + "|" + "0" + "|" + "0" + "|" + "0" + "|" + "0" + "|" + "0";

                    for(var num3hasdatacv = 0; num3hasdatacv < 3; num3hasdatacv++ )
                    {
                        $('#ProvAddValue' + num3hasdatacv).html(accounting.format(maxcounter[num3hasdatacv]) + " (" + percentval[num3hasdatacv] + "%)");
                        $('#ProvAddNamex' + num3hasdatacv).html('&#9635' + " " + provaddvar[num3hasdatacv] + ": ");
                    }

                    for(var num3nondatacv = 3; num3nondatacv < 11; num3nondatacv++ )
                    {
                        $('#ProvAddValue' + num3nondatacv).html("0" + " (0.00%)");
                        $('#ProvAddNamex' + num3nondatacv).html('&#9635' + " " + "NO DATA" + ": ");
                    }   
                    
                    $('#ProvAddValueO').html("0" + " (0.00%)");
                    $('#ProvAddNamexO').html('&#9635' + " " + "OTHERS" + ": ");
                }
                else if(provaddtoptenlength === 5)
                {
                    provaddnamestrings = provaddvar[0] + "|" + provaddvar[1] + "|" + provaddvar[2] + "|" + provaddvar[3] + "|" + "NO DATA" + "|" +
                                         "NO DATA" + "|" + "NO DATA" + "|" + "NO DATA" + "|" + "NO DATA" + "|" + "NO DATA" + "|" + "OTHERS";

                    provaddpercentagex = percentval[0] + "|" + percentval[1] + "|" + percentval[2] + "|" + percentval[3] + "|" + "0.00" + "|" +
                                         "0.00" + "|" + "0.00" + "|" + "0.00" + "|" + "0.00" + "|" + "0.00" + "|" + "0.00";

                    provaddpercentrate = maxcounter[0] + "|" + maxcounter[1] + "|" + maxcounter[2] + "|" + maxcounter[3] + "|" + "0" + "|" +
                                         "0" + "|" + "0" + "|" + "0" + "|" + "0" + "|" + "0" + "|" + "0";

                    for(var num4hasdatacv = 0; num4hasdatacv < 4; num4hasdatacv++ )
                    {
                        $('#ProvAddValue' + num4hasdatacv).html(accounting.format(maxcounter[num4hasdatacv]) + " (" + percentval[num4hasdatacv] + "%)");
                        $('#ProvAddNamex' + num4hasdatacv).html('&#9635' + " " + provaddvar[num4hasdatacv] + ": ");
                    }

                    for(var num4nondatacv = 4; num4nondatacv < 11; num4nondatacv++ )
                    {
                        $('#ProvAddValue' + num4nondatacv).html("0" + " (0.00%)");
                        $('#ProvAddNamex' + num4nondatacv).html('&#9635' + " " + "NO DATA" + ": ");
                    }      
                    
                    $('#ProvAddValueO').html("0" + " (0.00%)");
                    $('#ProvAddNamexO').html('&#9635' + " " + "OTHERS" + ": ");
                }
                else if(provaddtoptenlength === 6)
                {
                    provaddnamestrings = provaddvar[0] + "|" + provaddvar[1] + "|" + provaddvar[2] + "|" + provaddvar[3] + "|" + provaddvar[4] + "|" +
                                         "NO DATA" + "|" + "NO DATA" + "|" + "NO DATA" + "|" + "NO DATA" + "|" + "NO DATA" + "|" + "OTHERS";

                    provaddpercentagex = percentval[0] + "|" + percentval[1] + "|" + percentval[2] + "|" + percentval[3] + "|" + percentval[4] + "|" +
                                         "0.00" + "|" + "0.00" + "|" + "0.00" + "|" + "0.00" + "|" + "0.00" + "|" + "0.00";

                    provaddpercentrate = maxcounter[0] + "|" + maxcounter[1] + "|" + maxcounter[2] + "|" + maxcounter[3] + "|" + maxcounter[4] + "|" +
                                         "0" + "|" + "0" + "|" + "0" + "|" + "0" + "|" + "0" + "|" + "0";

                    for(var num5hasdatacv = 0; num5hasdatacv < 5; num5hasdatacv++ )
                    {
                        $('#ProvAddValue' + num5hasdatacv).html(accounting.format(maxcounter[num5hasdatacv]) + " (" + percentval[num5hasdatacv] + "%)");
                        $('#ProvAddNamex' + num5hasdatacv).html('&#9635' + " " + provaddvar[num5hasdatacv] + ": ");
                    }

                    for(var num5nondatacv = 5; num5nondatacv < 11; num5nondatacv++ )
                    {
                        $('#ProvAddValue' + num5nondatacv).html("0" + " (0.00%)");
                        $('#ProvAddNamex' + num5nondatacv).html('&#9635' + " " + "NO DATA" + ": ");
                    } 
                    
                    $('#ProvAddValueO').html("0" + " (0.00%)");
                    $('#ProvAddNamexO').html('&#9635' + " " + "OTHERS" + ": ");
                }
                else if(provaddtoptenlength === 7)
                {
                    provaddnamestrings = provaddvar[0] + "|" + provaddvar[1] + "|" + provaddvar[2] + "|" + provaddvar[3] + "|" + provaddvar[4] + "|" +
                                         provaddvar[5] + "|" + "NO DATA" + "|" + "NO DATA" + "|" + "NO DATA" + "|" + "NO DATA" + "|" + "OTHERS";

                    provaddpercentagex = percentval[0] + "|" + percentval[1] + "|" + percentval[2] + "|" + percentval[3] + "|" + percentval[4] + "|" +
                                         percentval[5] + "|" + "0.00" + "|" + "0.00" + "|" + "0.00" + "|" + "0.00" + "|" + "0.00";

                    provaddpercentrate = maxcounter[0] + "|" + maxcounter[1] + "|" + maxcounter[2] + "|" + maxcounter[3] + "|" + maxcounter[4] + "|" +
                                         maxcounter[5] + "|" + "0" + "|" + "0" + "|" + "0" + "|" + "0" + "|" + "0";

                    for(var num6hasdatacv = 0; num6hasdatacv < 6; num6hasdatacv++ )
                    {
                        $('#ProvAddValue' + num6hasdatacv).html(accounting.format(maxcounter[num6hasdatacv]) + " (" + percentval[num6hasdatacv] + "%)");
                        $('#ProvAddNamex' + num6hasdatacv).html('&#9635' + " " + provaddvar[num6hasdatacv] + ": ");
                    }

                    for(var num6nondatacv = 6; num6nondatacv < 11; num6nondatacv++ )
                    {
                        $('#ProvAddValue' + num6nondatacv).html("0" + " (0.00%)");
                        $('#ProvAddNamex' + num6nondatacv).html('&#9635' + " " + "NO DATA" + ": ");
                    } 
                    
                    $('#ProvAddValueO').html("0" + " (0.00%)");
                    $('#ProvAddNamexO').html('&#9635' + " " + "OTHERS" + ": ");
                }
                else if(provaddtoptenlength === 8)
                {
                    provaddnamestrings = provaddvar[0] + "|" + provaddvar[1] + "|" + provaddvar[2] + "|" + provaddvar[3] + "|" + provaddvar[4] + "|" +
                                         provaddvar[5] + "|" + provaddvar[6] + "|" + "NO DATA" + "|" + "NO DATA" + "|" + "NO DATA" + "|" + "OTHERS";

                    provaddpercentagex = percentval[0] + "|" + percentval[1] + "|" + percentval[2] + "|" + percentval[3] + "|" + percentval[4] + "|" +
                                         percentval[5] + "|" + percentval[6] + "|" + "0.00" + "|" + "0.00" + "|" + "0.00" + "|" + "0.00";

                    provaddpercentrate = maxcounter[0] + "|" + maxcounter[1] + "|" + maxcounter[2] + "|" + maxcounter[3] + "|" + maxcounter[4] + "|" +
                                         maxcounter[5] + "|" + maxcounter[6] + "|" + "0" + "|" + "0" + "|" + "0" + "|" + "0";

                    for(var num7hasdatacv = 0; num7hasdatacv < 7; num7hasdatacv++ )
                    {
                        $('#ProvAddValue' + num7hasdatacv).html(accounting.format(maxcounter[num7hasdatacv]) + " (" + percentval[num7hasdatacv] + "%)");
                        $('#ProvAddNamex' + num7hasdatacv).html('&#9635' + " " + provaddvar[num7hasdatacv] + ": ");
                    }

                    for(var num7nondatacv = 7; num7nondatacv < 11; num7nondatacv++ )
                    {
                        $('#ProvAddValue' + num7nondatacv).html("0" + " (0.00%)");
                        $('#ProvAddNamex' + num7nondatacv).html('&#9635' + " " + "NO DATA" + ": ");
                    } 
                    
                    $('#ProvAddValueO').html("0" + " (0.00%)");
                    $('#ProvAddNamexO').html('&#9635' + " " + "OTHERS" + ": ");
                }
                else if(provaddtoptenlength === 9)
                {
                    provaddnamestrings = provaddvar[0] + "|" + provaddvar[1] + "|" + provaddvar[2] + "|" + provaddvar[3] + "|" + provaddvar[4] + "|" +
                                         provaddvar[5] + "|" + provaddvar[6] + "|" + provaddvar[7] + "|" + "NO DATA" + "|" + "NO DATA" + "|" + "OTHERS";

                    provaddpercentagex = percentval[0] + "|" + percentval[1] + "|" + percentval[2] + "|" + percentval[3] + "|" + percentval[4] + "|" +
                                         percentval[5] + "|" + percentval[6] + "|" + percentval[7] + "|" + "0.00" + "|" + "0.00" + "|" + "0.00";

                    provaddpercentrate = maxcounter[0] + "|" + maxcounter[1] + "|" + maxcounter[2] + "|" + maxcounter[3] + "|" + maxcounter[4] + "|" +
                                         maxcounter[5] + "|" + maxcounter[6] + "|" + maxcounter[7] + "|" + "0" + "|" + "0" + "|" + "0";

                    for(var num8hasdatacv = 0; num8hasdatacv < 8; num8hasdatacv++ )
                    {
                        $('#ProvAddValue' + num8hasdatacv).html(accounting.format(maxcounter[num8hasdatacv]) + " (" + percentval[num8hasdatacv] + "%)");
                        $('#ProvAddNamex' + num8hasdatacv).html('&#9635' + " " + provaddvar[num8hasdatacv] + ": ");
                    }

                    for(var num8nondatacv = 8; num8nondatacv < 11; num8nondatacv++ )
                    {
                        $('#ProvAddValue' + num8nondatacv).html("0" + " (0.00%)");
                        $('#ProvAddNamex' + num8nondatacv).html('&#9635' + " " + "NO DATA" + ": ");
                    } 
                    
                    $('#ProvAddValueO').html("0" + " (0.00%)");
                    $('#ProvAddNamexO').html('&#9635' + " " + "OTHERS" + ": ");
                }
                else if(provaddtoptenlength === 10)
                {
                    provaddnamestrings = provaddvar[0] + "|" + provaddvar[1] + "|" + provaddvar[2] + "|" + provaddvar[3] + "|" + provaddvar[4] + "|" +
                                         provaddvar[5] + "|" + provaddvar[6] + "|" + provaddvar[7] + "|" + provaddvar[8] + "|" + "NO DATA" + "|" + "OTHERS";

                    provaddpercentagex = percentval[0] + "|" + percentval[1] + "|" + percentval[2] + "|" + percentval[3] + "|" + percentval[4] + "|" +
                                         percentval[5] + "|" + percentval[6] + "|" + percentval[7] + "|" + percentval[8] + "|" + "0.00" + "|" + "0.00";

                    provaddpercentrate = maxcounter[0] + "|" + maxcounter[1] + "|" + maxcounter[2] + "|" + maxcounter[3] + "|" + maxcounter[4] + "|" +
                                         maxcounter[5] + "|" + maxcounter[6] + "|" + maxcounter[7] + "|" + maxcounter[8] + "|" + "0" + "|" + "0";

                    for(var num9hasdatacv = 0; num9hasdatacv < 9; num9hasdatacv++ )
                    {
                        $('#ProvAddValue' + num9hasdatacv).html(accounting.format(maxcounter[num9hasdatacv]) + " (" + percentval[num9hasdatacv] + "%)");
                        $('#ProvAddNamex' + num9hasdatacv).html('&#9635' + " " + provaddvar[num9hasdatacv] + ": ");
                    }

                    for(var num9nondatacv = 9; num9nondatacv < 11; num9nondatacv++ )
                    {
                        $('#ProvAddValue' + num9nondatacv).html("0" + " (0.00%)");
                        $('#ProvAddNamex' + num9nondatacv).html('&#9635' + " " + "NO DATA" + ": ");
                    } 
                    
                    $('#ProvAddValueO').html("0" + " (0.00%)");
                    $('#ProvAddNamexO').html('&#9635' + " " + "OTHERS" + ": ");
                }
                else
                {
                    provaddnamestrings = provaddvar[0] + "|" + provaddvar[1] + "|" + provaddvar[2] + "|" + provaddvar[3] + "|" + provaddvar[4] + "|" +
                                         provaddvar[5] + "|" + provaddvar[6] + "|" + provaddvar[7] + "|" + provaddvar[8] + "|" + provaddvar[9] + "|" + provaddvar[10];

                    provaddpercentagex = percentval[0] + "|" + percentval[1] + "|" + percentval[2] + "|" + percentval[3] + "|" + percentval[4] + "|" +
                                         percentval[5] + "|" + percentval[6] + "|" + percentval[7] + "|" + percentval[8] + "|" + percentval[9] + "|" + percentval[10];

                    provaddpercentrate = maxcounter[0] + "|" + maxcounter[1] + "|" + maxcounter[2] + "|" + maxcounter[3] + "|" + maxcounter[4] + "|" +
                                         maxcounter[5] + "|" + maxcounter[6] + "|" + maxcounter[7] + "|" + maxcounter[8] + "|" + maxcounter[9] + "|" + maxcounter[10];  

                    provnameforothersx = provaddvar[0] + "|" + provaddvar[1] + "|" + provaddvar[2] + "|" + provaddvar[3] + "|" + provaddvar[4] + "|" +
                                         provaddvar[5] + "|" + provaddvar[6] + "|" + provaddvar[7] + "|" + provaddvar[8] + "|" + provaddvar[9];

                    for(var num10hasdatacv = 0; num10hasdatacv < 11; num10hasdatacv++ )
                    {
                        $('#ProvAddValue' + num10hasdatacv).html(accounting.format(maxcounter[num10hasdatacv]) + " (" + percentval[num10hasdatacv] + "%)");
                        $('#ProvAddNamex' + num10hasdatacv).html('&#9635' + " " + provaddvar[num10hasdatacv] + ": ");
                        
                        $('#ProvAddValueO').html(accounting.format(maxcounter[num10hasdatacv]) + " (" + percentval[num10hasdatacv] + "%)");
                        $('#ProvAddNamexO').html('&#9635' + " " + "OTHERS" + ": ");
                    }                                      
                }
                
                getChartForInpatientProvince(provaddnamestrings, provaddpercentagex, monthyear, pxtype, provaddpercentrate, provnameforothersx);
                
            });
        }
    });
}

function getInpatientInsuranceCategory(monthyear,pxtype)
{
    $.ajax
    ({
        type: 'POST',
        url:  BASE_URL + "Dashboard/getInpatientInsurance",
        data: 
        {
            monthyearx:monthyear,
            pxtypex:pxtype
        },
        dataType: 'json'
    })
    .done(function(data) 
    {
        if(data.status === false)
        {
            $('#totalPatientViaInsurance').html("0" + " Patient(s)");
            $('#InsuranceNamexO').html('&#9635' + ' ' + 'NO DATA' + ': ');
            $('#InsuranceValueO').html('0' + " (0.00%)");

            for(var num0nondatacv = 0; num0nondatacv < 10; num0nondatacv++ )
            {
                $('#InsuranceValue' + num0nondatacv).html("0" + " (0.00%)");
                $('#InsuranceNamex' + num0nondatacv).html('&#9635' + " " + "NO DATA" + ": ");
            }  
            
            disableInpatientInsuranceChart();
        }
        else
        {
            var hmoinsutoptentotal = 0;
            var hmoinsuotherstotal = 0;
            var hmoinsutoptenstrng = "";
            var hmoinsuothersstrng = "";
            var hmoinsutoptenvalue = "";
            var hmoinsuothersvalue = "";

            for (var cv = 0; cv < data.getinpatientinsurance.length; cv++)
            {
                hmoinsutoptentotal = parseInt(hmoinsutoptentotal) + parseInt(data.getinpatientinsurance[cv]['MAX_COUNT']);
                hmoinsutoptenstrng = hmoinsutoptenstrng + data.getinpatientinsurance[cv]['hmoname'] + "|";
                hmoinsutoptenvalue = hmoinsutoptenvalue + data.getinpatientinsurance[cv]['MAX_COUNT'] + "|";
            }

            $.ajax
            ({
                type: 'POST',
                url:  BASE_URL + "Dashboard/getInpatientInsuranceOthers",
                data: 
                {
                    monthyearx:monthyear,
                    pxtypex: pxtype,
                    hmonames: hmoinsutoptenstrng
                },
                dataType: 'json'
            })
            .done(function(data2) 
            {
                var hmoinsutotaltoptenandothers = 0;
                var hmoinsustrngtoptenandothers = "";
                var hmoinsuvaluetoptenandothers = "";
                
                for (var cvothers = 0; cvothers < data2.getinpatientinsuranceothers.length; cvothers++)
                {
                    hmoinsuotherstotal = parseInt(hmoinsuotherstotal) + parseInt(data2.getinpatientinsuranceothers[cvothers]['MAX_COUNT_OTHERS']);
                    hmoinsuothersstrng = hmoinsuothersstrng + data2.getinpatientinsuranceothers[cvothers]['hmoname'] + "|";
                    hmoinsuothersvalue = hmoinsuothersvalue + data2.getinpatientinsuranceothers[cvothers]['MAX_COUNT_OTHERS'] + "|";
                }
                
                hmoinsutotaltoptenandothers = parseInt(hmoinsutoptentotal) + parseInt(hmoinsuotherstotal);
                
                var hmoinsutoptenstrngsplit = hmoinsutoptenstrng.split("|");
                var hmoinsutoptenvaluesplit = hmoinsutoptenvalue.split("|");
            
                if(data.getinpatientinsurance[0]['hmoname'] === "")
                {
                    hmoinsustrngtoptenandothers = "NON-HMO" + "|" + 
                                                  hmoinsutoptenstrngsplit[1] + "|" +
                                                  hmoinsutoptenstrngsplit[2] + "|" +
                                                  hmoinsutoptenstrngsplit[3] + "|" +
                                                  hmoinsutoptenstrngsplit[4] + "|" +
                                                  hmoinsutoptenstrngsplit[5] + "|" +
                                                  hmoinsutoptenstrngsplit[6] + "|" +
                                                  hmoinsutoptenstrngsplit[7] + "|" +
                                                  hmoinsutoptenstrngsplit[8] + "|" +
                                                  hmoinsutoptenstrngsplit[9] + "|" +
                                                  "OTHERS";
                }
                else if(data.getinpatientinsurance[1]['hmoname'] === "")
                {
                    hmoinsustrngtoptenandothers = hmoinsutoptenstrngsplit[0] + "|" +
                                                  "NON-HMO" + "|" + 
                                                  hmoinsutoptenstrngsplit[2] + "|" +
                                                  hmoinsutoptenstrngsplit[3] + "|" +
                                                  hmoinsutoptenstrngsplit[4] + "|" +
                                                  hmoinsutoptenstrngsplit[5] + "|" +
                                                  hmoinsutoptenstrngsplit[6] + "|" +
                                                  hmoinsutoptenstrngsplit[7] + "|" +
                                                  hmoinsutoptenstrngsplit[8] + "|" +
                                                  hmoinsutoptenstrngsplit[9] + "|" +
                                                  "OTHERS";
                }
                else if(data.getinpatientinsurance[2]['hmoname'] === "")
                {
                    hmoinsustrngtoptenandothers = hmoinsutoptenstrngsplit[0] + "|" +
                                                  hmoinsutoptenstrngsplit[1] + "|" +
                                                  "NON-HMO" + "|" +
                                                  hmoinsutoptenstrngsplit[3] + "|" +
                                                  hmoinsutoptenstrngsplit[4] + "|" +
                                                  hmoinsutoptenstrngsplit[5] + "|" +
                                                  hmoinsutoptenstrngsplit[6] + "|" +
                                                  hmoinsutoptenstrngsplit[7] + "|" +
                                                  hmoinsutoptenstrngsplit[8] + "|" +
                                                  hmoinsutoptenstrngsplit[9] + "|" +
                                                  "OTHERS";
                }
                else if(data.getinpatientinsurance[3]['hmoname'] === "")
                {
                    hmoinsustrngtoptenandothers = hmoinsutoptenstrngsplit[0] + "|" +
                                                  hmoinsutoptenstrngsplit[1] + "|" +
                                                  hmoinsutoptenstrngsplit[2] + "|" +
                                                  "NON-HMO" + "|" +
                                                  hmoinsutoptenstrngsplit[4] + "|" +
                                                  hmoinsutoptenstrngsplit[5] + "|" +
                                                  hmoinsutoptenstrngsplit[6] + "|" +
                                                  hmoinsutoptenstrngsplit[7] + "|" +
                                                  hmoinsutoptenstrngsplit[8] + "|" +
                                                  hmoinsutoptenstrngsplit[9] + "|" +
                                                  "OTHERS";
                }
                else if(data.getinpatientinsurance[4]['hmoname'] === "")
                {
                    hmoinsustrngtoptenandothers = hmoinsutoptenstrngsplit[0] + "|" +
                                                  hmoinsutoptenstrngsplit[1] + "|" +
                                                  hmoinsutoptenstrngsplit[2] + "|" +
                                                  hmoinsutoptenstrngsplit[3] + "|" +
                                                  "NON-HMO" + "|" +
                                                  hmoinsutoptenstrngsplit[5] + "|" +
                                                  hmoinsutoptenstrngsplit[6] + "|" +
                                                  hmoinsutoptenstrngsplit[7] + "|" +
                                                  hmoinsutoptenstrngsplit[8] + "|" +
                                                  hmoinsutoptenstrngsplit[9] + "|" +
                                                  "OTHERS";
                }
                else if(data.getinpatientinsurance[5]['hmoname'] === "")
                {
                    hmoinsustrngtoptenandothers = hmoinsutoptenstrngsplit[0] + "|" +
                                                  hmoinsutoptenstrngsplit[1] + "|" +
                                                  hmoinsutoptenstrngsplit[2] + "|" +
                                                  hmoinsutoptenstrngsplit[3] + "|" +
                                                  hmoinsutoptenstrngsplit[4] + "|" +
                                                  "NON-HMO" + "|" +
                                                  hmoinsutoptenstrngsplit[6] + "|" +
                                                  hmoinsutoptenstrngsplit[7] + "|" +
                                                  hmoinsutoptenstrngsplit[8] + "|" +
                                                  hmoinsutoptenstrngsplit[9] + "|" +
                                                  "OTHERS";
                }
                else if(data.getinpatientinsurance[6]['hmoname'] === "")
                {
                    hmoinsustrngtoptenandothers = hmoinsutoptenstrngsplit[0] + "|" +
                                                  hmoinsutoptenstrngsplit[1] + "|" +
                                                  hmoinsutoptenstrngsplit[2] + "|" +
                                                  hmoinsutoptenstrngsplit[3] + "|" +
                                                  hmoinsutoptenstrngsplit[4] + "|" +
                                                  hmoinsutoptenstrngsplit[5] + "|" +
                                                  "NON-HMO" + "|" +
                                                  hmoinsutoptenstrngsplit[7] + "|" +
                                                  hmoinsutoptenstrngsplit[8] + "|" +
                                                  hmoinsutoptenstrngsplit[9] + "|" +
                                                  "OTHERS";
                }
                else if(data.getinpatientinsurance[7]['hmoname'] === "")
                {
                    hmoinsustrngtoptenandothers = hmoinsutoptenstrngsplit[0] + "|" +
                                                  hmoinsutoptenstrngsplit[1] + "|" +
                                                  hmoinsutoptenstrngsplit[2] + "|" +
                                                  hmoinsutoptenstrngsplit[3] + "|" +
                                                  hmoinsutoptenstrngsplit[4] + "|" +
                                                  hmoinsutoptenstrngsplit[5] + "|" +
                                                  hmoinsutoptenstrngsplit[6] + "|" +
                                                  "NON-HMO" + "|" +
                                                  hmoinsutoptenstrngsplit[8] + "|" +
                                                  hmoinsutoptenstrngsplit[9] + "|" +
                                                  "OTHERS";
                }
                else if(data.getinpatientinsurance[8]['hmoname'] === "")
                {
                    hmoinsustrngtoptenandothers = hmoinsutoptenstrngsplit[0] + "|" +
                                                  hmoinsutoptenstrngsplit[1] + "|" +
                                                  hmoinsutoptenstrngsplit[2] + "|" +
                                                  hmoinsutoptenstrngsplit[3] + "|" +
                                                  hmoinsutoptenstrngsplit[4] + "|" +
                                                  hmoinsutoptenstrngsplit[5] + "|" +
                                                  hmoinsutoptenstrngsplit[6] + "|" +
                                                  hmoinsutoptenstrngsplit[7] + "|" +
                                                  "NON-HMO" + "|" +
                                                  hmoinsutoptenstrngsplit[9] + "|" +
                                                  "OTHERS";
                }
                else
                {
                    hmoinsustrngtoptenandothers = hmoinsutoptenstrngsplit[0] + "|" +
                                                  hmoinsutoptenstrngsplit[1] + "|" +
                                                  hmoinsutoptenstrngsplit[2] + "|" +
                                                  hmoinsutoptenstrngsplit[3] + "|" +
                                                  hmoinsutoptenstrngsplit[4] + "|" +
                                                  hmoinsutoptenstrngsplit[5] + "|" +
                                                  hmoinsutoptenstrngsplit[6] + "|" +
                                                  hmoinsutoptenstrngsplit[7] + "|" +
                                                  "NON-HMO" + "|" +
                                                  hmoinsutoptenstrngsplit[9] + "|" +
                                                  "OTHERS";
                }
                
                hmoinsuvaluetoptenandothers = hmoinsutoptenvaluesplit[0] + "|" +
                                              hmoinsutoptenvaluesplit[1] + "|" +
                                              hmoinsutoptenvaluesplit[2] + "|" +
                                              hmoinsutoptenvaluesplit[3] + "|" +
                                              hmoinsutoptenvaluesplit[4] + "|" +
                                              hmoinsutoptenvaluesplit[5] + "|" +
                                              hmoinsutoptenvaluesplit[6] + "|" +
                                              hmoinsutoptenvaluesplit[7] + "|" +
                                              hmoinsutoptenvaluesplit[8] + "|" +
                                              hmoinsutoptenvaluesplit[9] + "|" +
                                              hmoinsuotherstotal;
                
                var hmoinsutoptennamesstr = hmoinsustrngtoptenandothers.split("|");
                var hmoinsutoptenvaluestr = hmoinsuvaluetoptenandothers.split("|");

                $('#totalPatientViaInsurance').html(accounting.format(hmoinsutotaltoptenandothers) + " Patient(s)");
                
                var hmoinsuvar = [];
                var maxcounter = [];
                var percentval = [];
                
                var hmoinsutoptenlength = parseInt(data.getinpatientinsurance.length) + parseInt(1);
                for (var percentcv = 0; percentcv < hmoinsutoptenlength; percentcv++)
                {
                    hmoinsuvar[percentcv] = hmoinsutoptennamesstr[percentcv];
                    maxcounter[percentcv] = hmoinsutoptenvaluestr[percentcv];
                    percentval[percentcv] = accounting.format((maxcounter[percentcv]/hmoinsutotaltoptenandothers)*100,2);
                }

                var hmoinsunamestrings = "";
                var hmoinsupercentagex = "";
                var hmoinsupercentrate = "";
                var hmoinsurforothersx = "";

                if(hmoinsutoptenlength === 2)
                {
                    hmoinsunamestrings = hmoinsuvar[0] + "|" + "NO DATA" + "|" + "NO DATA" + "|" + "NO DATA" + "|" + "NO DATA" + "|" +
                                         "NO DATA" + "|" + "NO DATA" + "|" + "NO DATA" + "|" + "NO DATA" + "|" + "NO DATA" + "|" + "OTHERS";

                    hmoinsupercentagex = percentval[0] + "|" + "0.00" + "|" + "0.00" + "|" + "0.00" + "|" + "0.00" + "|" +
                                         "0.00" + "|" + "0.00" + "|" + "0.00" + "|" + "0.00" + "|" + "0.00" + "|" + "0.00";

                    hmoinsupercentrate = maxcounter[0] + "|" + "0" + "|" + "0" + "|" + "0" + "|" + "0" + "|" +
                                         "0" + "|" + "0" + "|" + "0" + "|" + "0" + "|" + "0" + "|" + "0";   

                    for(var num1hasdatacv = 0; num1hasdatacv < 1; num1hasdatacv++ )
                    {
                        $('#InsuranceValue' + num1hasdatacv).html(accounting.format(maxcounter[num1hasdatacv]) + " (" + percentval[num1hasdatacv] + "%)");
                        $('#InsuranceNamex' + num1hasdatacv).html('&#9635' + " " + hmoinsuvar[num1hasdatacv] + ": ");
                    }

                    for(var num1nondatacv = 1; num1nondatacv < 11; num1nondatacv++ )
                    {
                        $('#InsuranceValue' + num1nondatacv).html("0" + " (0.00%)");
                        $('#InsuranceNamex' + num1nondatacv).html('&#9635' + " " + "NO DATA" + ": ");
                    }   
                    
                    $('#InsuranceValueO').html("0" + " (0.00%)");
                    $('#InsuranceNamexO').html('&#9635' + " " + "OTHERS" + ": ");
                }
                else if(hmoinsutoptenlength === 3)
                {
                    hmoinsunamestrings = hmoinsuvar[0] + "|" + hmoinsuvar[1] + "|" + "NO DATA" + "|" + "NO DATA" + "|" + "NO DATA" + "|" +
                                         "NO DATA" + "|" + "NO DATA" + "|" + "NO DATA" + "|" + "NO DATA" + "|" + "NO DATA" + "|" + "OTHERS";

                    hmoinsupercentagex = percentval[0] + "|" + percentval[1] + "|" + "0.00" + "|" + "0.00" + "|" + "0.00" + "|" +
                                         "0.00" + "|" + "0.00" + "|" + "0.00" + "|" + "0.00" + "|" + "0.00" + "|" + "0.00";

                    hmoinsupercentrate = maxcounter[0] + "|" + maxcounter[1] + "|" + "0" + "|" + "0" + "|" + "0" + "|" +
                                         "0" + "|" + "0" + "|" + "0" + "|" + "0" + "|" + "0" + "|" + "0";

                    for(var num2hasdatacv = 0; num2hasdatacv < 2; num2hasdatacv++ )
                    {
                        $('#InsuranceValue' + num2hasdatacv).html(accounting.format(maxcounter[num2hasdatacv]) + " (" + percentval[num2hasdatacv] + "%)");
                        $('#InsuranceNamex' + num2hasdatacv).html('&#9635' + " " + hmoinsuvar[num2hasdatacv] + ": ");
                    }

                    for(var num2nondatacv = 2; num2nondatacv < 11; num2nondatacv++ )
                    {
                        $('#InsuranceValue' + num2nondatacv).html("0" + " (0.00%)");
                        $('#InsuranceNamex' + num2nondatacv).html('&#9635' + " " + "NO DATA" + ": ");
                    }   
                    
                    $('#InsuranceValueO').html("0" + " (0.00%)");
                    $('#InsuranceNamexO').html('&#9635' + " " + "OTHERS" + ": ");
                }
                else if(hmoinsutoptenlength === 4)
                {
                    hmoinsunamestrings = hmoinsuvar[0] + "|" + hmoinsuvar[1] + "|" + hmoinsuvar[2] + "|" + "NO DATA" + "|" + "NO DATA" + "|" +
                                         "NO DATA" + "|" + "NO DATA" + "|" + "NO DATA" + "|" + "NO DATA" + "|" + "NO DATA" + "|" + "OTHERS";

                    hmoinsupercentagex = percentval[0] + "|" + percentval[1] + "|" + percentval[2] + "|" + "0.00" + "|" + "0.00" + "|" +
                                         "0.00" + "|" + "0.00" + "|" + "0.00" + "|" + "0.00" + "|" + "0.00" + "|" + "0.00";

                    hmoinsupercentrate = maxcounter[0] + "|" + maxcounter[1] + "|" + maxcounter[2] + "|" + "0" + "|" + "0" + "|" +
                                         "0" + "|" + "0" + "|" + "0" + "|" + "0" + "|" + "0" + "|" + "0";

                    for(var num3hasdatacv = 0; num3hasdatacv < 3; num3hasdatacv++ )
                    {
                        $('#InsuranceValue' + num3hasdatacv).html(accounting.format(maxcounter[num3hasdatacv]) + " (" + percentval[num3hasdatacv] + "%)");
                        $('#InsuranceNamex' + num3hasdatacv).html('&#9635' + " " + hmoinsuvar[num3hasdatacv] + ": ");
                    }

                    for(var num3nondatacv = 3; num3nondatacv < 11; num3nondatacv++ )
                    {
                        $('#InsuranceValue' + num3nondatacv).html("0" + " (0.00%)");
                        $('#InsuranceNamex' + num3nondatacv).html('&#9635' + " " + "NO DATA" + ": ");
                    }   
                    
                    $('#InsuranceValueO').html("0" + " (0.00%)");
                    $('#InsuranceNamexO').html('&#9635' + " " + "OTHERS" + ": ");
                }
                else if(hmoinsutoptenlength === 5)
                {
                    hmoinsunamestrings = hmoinsuvar[0] + "|" + hmoinsuvar[1] + "|" + hmoinsuvar[2] + "|" + hmoinsuvar[3] + "|" + "NO DATA" + "|" +
                                         "NO DATA" + "|" + "NO DATA" + "|" + "NO DATA" + "|" + "NO DATA" + "|" + "NO DATA" + "|" + "OTHERS";

                    hmoinsupercentagex = percentval[0] + "|" + percentval[1] + "|" + percentval[2] + "|" + percentval[3] + "|" + "0.00" + "|" +
                                         "0.00" + "|" + "0.00" + "|" + "0.00" + "|" + "0.00" + "|" + "0.00" + "|" + "0.00";

                    hmoinsupercentrate = maxcounter[0] + "|" + maxcounter[1] + "|" + maxcounter[2] + "|" + maxcounter[3] + "|" + "0" + "|" +
                                         "0" + "|" + "0" + "|" + "0" + "|" + "0" + "|" + "0" + "|" + "0";

                    for(var num4hasdatacv = 0; num4hasdatacv < 4; num4hasdatacv++ )
                    {
                        $('#InsuranceValue' + num4hasdatacv).html(accounting.format(maxcounter[num4hasdatacv]) + " (" + percentval[num4hasdatacv] + "%)");
                        $('#InsuranceNamex' + num4hasdatacv).html('&#9635' + " " + hmoinsuvar[num4hasdatacv] + ": ");
                    }

                    for(var num4nondatacv = 4; num4nondatacv < 11; num4nondatacv++ )
                    {
                        $('#InsuranceValue' + num4nondatacv).html("0" + " (0.00%)");
                        $('#InsuranceNamex' + num4nondatacv).html('&#9635' + " " + "NO DATA" + ": ");
                    }      
                    
                    $('#InsuranceValueO').html("0" + " (0.00%)");
                    $('#InsuranceNamexO').html('&#9635' + " " + "OTHERS" + ": ");
                }
                else if(hmoinsutoptenlength === 6)
                {
                    hmoinsunamestrings = hmoinsuvar[0] + "|" + hmoinsuvar[1] + "|" + hmoinsuvar[2] + "|" + hmoinsuvar[3] + "|" + hmoinsuvar[4] + "|" +
                                         "NO DATA" + "|" + "NO DATA" + "|" + "NO DATA" + "|" + "NO DATA" + "|" + "NO DATA" + "|" + "OTHERS";

                    hmoinsupercentagex = percentval[0] + "|" + percentval[1] + "|" + percentval[2] + "|" + percentval[3] + "|" + percentval[4] + "|" +
                                         "0.00" + "|" + "0.00" + "|" + "0.00" + "|" + "0.00" + "|" + "0.00" + "|" + "0.00";

                    hmoinsupercentrate = maxcounter[0] + "|" + maxcounter[1] + "|" + maxcounter[2] + "|" + maxcounter[3] + "|" + maxcounter[4] + "|" +
                                         "0" + "|" + "0" + "|" + "0" + "|" + "0" + "|" + "0" + "|" + "0";

                    for(var num5hasdatacv = 0; num5hasdatacv < 5; num5hasdatacv++ )
                    {
                        $('#InsuranceValue' + num5hasdatacv).html(accounting.format(maxcounter[num5hasdatacv]) + " (" + percentval[num5hasdatacv] + "%)");
                        $('#InsuranceNamex' + num5hasdatacv).html('&#9635' + " " + hmoinsuvar[num5hasdatacv] + ": ");
                    }

                    for(var num5nondatacv = 5; num5nondatacv < 11; num5nondatacv++ )
                    {
                        $('#InsuranceValue' + num5nondatacv).html("0" + " (0.00%)");
                        $('#InsuranceNamex' + num5nondatacv).html('&#9635' + " " + "NO DATA" + ": ");
                    } 
                    
                    $('#InsuranceValueO').html("0" + " (0.00%)");
                    $('#InsuranceNamexO').html('&#9635' + " " + "OTHERS" + ": ");
                }
                else if(hmoinsutoptenlength === 7)
                {
                    hmoinsunamestrings = hmoinsuvar[0] + "|" + hmoinsuvar[1] + "|" + hmoinsuvar[2] + "|" + hmoinsuvar[3] + "|" + hmoinsuvar[4] + "|" +
                                         hmoinsuvar[5] + "|" + "NO DATA" + "|" + "NO DATA" + "|" + "NO DATA" + "|" + "NO DATA" + "|" + "OTHERS";

                    hmoinsupercentagex = percentval[0] + "|" + percentval[1] + "|" + percentval[2] + "|" + percentval[3] + "|" + percentval[4] + "|" +
                                         percentval[5] + "|" + "0.00" + "|" + "0.00" + "|" + "0.00" + "|" + "0.00" + "|" + "0.00";

                    hmoinsupercentrate = maxcounter[0] + "|" + maxcounter[1] + "|" + maxcounter[2] + "|" + maxcounter[3] + "|" + maxcounter[4] + "|" +
                                         maxcounter[5] + "|" + "0" + "|" + "0" + "|" + "0" + "|" + "0" + "|" + "0";

                    for(var num6hasdatacv = 0; num6hasdatacv < 6; num6hasdatacv++ )
                    {
                        $('#InsuranceValue' + num6hasdatacv).html(accounting.format(maxcounter[num6hasdatacv]) + " (" + percentval[num6hasdatacv] + "%)");
                        $('#InsuranceNamex' + num6hasdatacv).html('&#9635' + " " + hmoinsuvar[num6hasdatacv] + ": ");
                    }

                    for(var num6nondatacv = 6; num6nondatacv < 11; num6nondatacv++ )
                    {
                        $('#InsuranceValue' + num6nondatacv).html("0" + " (0.00%)");
                        $('#InsuranceNamex' + num6nondatacv).html('&#9635' + " " + "NO DATA" + ": ");
                    } 
                    
                    $('#InsuranceValueO').html("0" + " (0.00%)");
                    $('#InsuranceNamexO').html('&#9635' + " " + "OTHERS" + ": ");
                }
                else if(hmoinsutoptenlength === 8)
                {
                    hmoinsunamestrings = hmoinsuvar[0] + "|" + hmoinsuvar[1] + "|" + hmoinsuvar[2] + "|" + hmoinsuvar[3] + "|" + hmoinsuvar[4] + "|" +
                                         hmoinsuvar[5] + "|" + hmoinsuvar[6] + "|" + "NO DATA" + "|" + "NO DATA" + "|" + "NO DATA" + "|" + "OTHERS";

                    hmoinsupercentagex = percentval[0] + "|" + percentval[1] + "|" + percentval[2] + "|" + percentval[3] + "|" + percentval[4] + "|" +
                                         percentval[5] + "|" + percentval[6] + "|" + "0.00" + "|" + "0.00" + "|" + "0.00" + "|" + "0.00";

                    hmoinsupercentrate = maxcounter[0] + "|" + maxcounter[1] + "|" + maxcounter[2] + "|" + maxcounter[3] + "|" + maxcounter[4] + "|" +
                                         maxcounter[5] + "|" + maxcounter[6] + "|" + "0" + "|" + "0" + "|" + "0" + "|" + "0";

                    for(var num7hasdatacv = 0; num7hasdatacv < 7; num7hasdatacv++ )
                    {
                        $('#InsuranceValue' + num7hasdatacv).html(accounting.format(maxcounter[num7hasdatacv]) + " (" + percentval[num7hasdatacv] + "%)");
                        $('#InsuranceNamex' + num7hasdatacv).html('&#9635' + " " + hmoinsuvar[num7hasdatacv] + ": ");
                    }

                    for(var num7nondatacv = 7; num7nondatacv < 11; num7nondatacv++ )
                    {
                        $('#InsuranceValue' + num7nondatacv).html("0" + " (0.00%)");
                        $('#InsuranceNamex' + num7nondatacv).html('&#9635' + " " + "NO DATA" + ": ");
                    } 
                    
                    $('#InsuranceValueO').html("0" + " (0.00%)");
                    $('#InsuranceNamexO').html('&#9635' + " " + "OTHERS" + ": ");
                }
                else if(hmoinsutoptenlength === 9)
                {
                    hmoinsunamestrings = hmoinsuvar[0] + "|" + hmoinsuvar[1] + "|" + hmoinsuvar[2] + "|" + hmoinsuvar[3] + "|" + hmoinsuvar[4] + "|" +
                                         hmoinsuvar[5] + "|" + hmoinsuvar[6] + "|" + hmoinsuvar[7] + "|" + "NO DATA" + "|" + "NO DATA" + "|" + "OTHERS";

                    hmoinsupercentagex = percentval[0] + "|" + percentval[1] + "|" + percentval[2] + "|" + percentval[3] + "|" + percentval[4] + "|" +
                                         percentval[5] + "|" + percentval[6] + "|" + percentval[7] + "|" + "0.00" + "|" + "0.00" + "|" + "0.00";

                    hmoinsupercentrate = maxcounter[0] + "|" + maxcounter[1] + "|" + maxcounter[2] + "|" + maxcounter[3] + "|" + maxcounter[4] + "|" +
                                         maxcounter[5] + "|" + maxcounter[6] + "|" + maxcounter[7] + "|" + "0" + "|" + "0" + "|" + "0";

                    for(var num8hasdatacv = 0; num8hasdatacv < 8; num8hasdatacv++ )
                    {
                        $('#InsuranceValue' + num8hasdatacv).html(accounting.format(maxcounter[num8hasdatacv]) + " (" + percentval[num8hasdatacv] + "%)");
                        $('#InsuranceNamex' + num8hasdatacv).html('&#9635' + " " + hmoinsuvar[num8hasdatacv] + ": ");
                    }

                    for(var num8nondatacv = 8; num8nondatacv < 11; num8nondatacv++ )
                    {
                        $('#InsuranceValue' + num8nondatacv).html("0" + " (0.00%)");
                        $('#InsuranceNamex' + num8nondatacv).html('&#9635' + " " + "NO DATA" + ": ");
                    } 
                    
                    $('#InsuranceValueO').html("0" + " (0.00%)");
                    $('#InsuranceNamexO').html('&#9635' + " " + "OTHERS" + ": ");
                }
                else if(hmoinsutoptenlength === 10)
                {
                    hmoinsunamestrings = hmoinsuvar[0] + "|" + hmoinsuvar[1] + "|" + hmoinsuvar[2] + "|" + hmoinsuvar[3] + "|" + hmoinsuvar[4] + "|" +
                                         hmoinsuvar[5] + "|" + hmoinsuvar[6] + "|" + hmoinsuvar[7] + "|" + hmoinsuvar[8] + "|" + "NO DATA" + "|" + "OTHERS";

                    hmoinsupercentagex = percentval[0] + "|" + percentval[1] + "|" + percentval[2] + "|" + percentval[3] + "|" + percentval[4] + "|" +
                                         percentval[5] + "|" + percentval[6] + "|" + percentval[7] + "|" + percentval[8] + "|" + "0.00" + "|" + "0.00";

                    hmoinsupercentrate = maxcounter[0] + "|" + maxcounter[1] + "|" + maxcounter[2] + "|" + maxcounter[3] + "|" + maxcounter[4] + "|" +
                                         maxcounter[5] + "|" + maxcounter[6] + "|" + maxcounter[7] + "|" + maxcounter[8] + "|" + "0" + "|" + "0";

                    for(var num9hasdatacv = 0; num9hasdatacv < 9; num9hasdatacv++ )
                    {
                        $('#InsuranceValue' + num9hasdatacv).html(accounting.format(maxcounter[num9hasdatacv]) + " (" + percentval[num9hasdatacv] + "%)");
                        $('#InsuranceNamex' + num9hasdatacv).html('&#9635' + " " + hmoinsuvar[num9hasdatacv] + ": ");
                    }

                    for(var num9nondatacv = 9; num9nondatacv < 11; num9nondatacv++ )
                    {
                        $('#InsuranceValue' + num9nondatacv).html("0" + " (0.00%)");
                        $('#InsuranceNamex' + num9nondatacv).html('&#9635' + " " + "NO DATA" + ": ");
                    } 
                    
                    $('#InsuranceValueO').html("0" + " (0.00%)");
                    $('#InsuranceNamexO').html('&#9635' + " " + "OTHERS" + ": ");
                }
                else
                {
                    hmoinsunamestrings = hmoinsuvar[0] + "|" + hmoinsuvar[1] + "|" + hmoinsuvar[2] + "|" + hmoinsuvar[3] + "|" + hmoinsuvar[4] + "|" +
                                         hmoinsuvar[5] + "|" + hmoinsuvar[6] + "|" + hmoinsuvar[7] + "|" + hmoinsuvar[8] + "|" + hmoinsuvar[9] + "|" + hmoinsuvar[10];

                    hmoinsupercentagex = percentval[0] + "|" + percentval[1] + "|" + percentval[2] + "|" + percentval[3] + "|" + percentval[4] + "|" +
                                         percentval[5] + "|" + percentval[6] + "|" + percentval[7] + "|" + percentval[8] + "|" + percentval[9] + "|" + percentval[10];

                    hmoinsupercentrate = maxcounter[0] + "|" + maxcounter[1] + "|" + maxcounter[2] + "|" + maxcounter[3] + "|" + maxcounter[4] + "|" +
                                         maxcounter[5] + "|" + maxcounter[6] + "|" + maxcounter[7] + "|" + maxcounter[8] + "|" + maxcounter[9] + "|" + maxcounter[10];  

                    hmoinsurforothersx = hmoinsuvar[0] + "|" + hmoinsuvar[1] + "|" + hmoinsuvar[2] + "|" + hmoinsuvar[3] + "|" + hmoinsuvar[4] + "|" +
                                         hmoinsuvar[5] + "|" + hmoinsuvar[6] + "|" + hmoinsuvar[7] + "|" + hmoinsuvar[8] + "|" + hmoinsuvar[9];

                    for(var num10hasdatacv = 0; num10hasdatacv < 11; num10hasdatacv++ )
                    {
                        $('#InsuranceValue' + num10hasdatacv).html(accounting.format(maxcounter[num10hasdatacv]) + " (" + percentval[num10hasdatacv] + "%)");
                        $('#InsuranceNamex' + num10hasdatacv).html('&#9635' + " " + hmoinsuvar[num10hasdatacv] + ": ");
                        
                        $('#InsuranceValueO').html(accounting.format(maxcounter[num10hasdatacv]) + " (" + percentval[num10hasdatacv] + "%)");
                        $('#InsuranceNamexO').html('&#9635' + " " + "OTHERS" + ": ");
                    }                                      
                }
                
                getChartForInpatientInsurance(hmoinsunamestrings, hmoinsupercentagex, monthyear, pxtype, hmoinsupercentrate, hmoinsurforothersx);
                
                InpatientInsuraCategory = "";
                var insurancecategory = hmoinsustrngtoptenandothers.toString() + "?" + hmoinsupercentagex.toString() + "?" + hmoinsupercentrate.toString();
                InpatientInsuraCategory = InpatientInsuraCategory + insurancecategory;    
                
            });
        }
    });
}

function getInpatientRoomOccupancyRate(monthyear,pxtype)
{
    $.ajax
    ({
        type: 'POST',
        url:  BASE_URL + "Dashboard/getInpatientRoomOccupancyRate",
        data: 
        {
            monthyearx:monthyear,
            pxtypex:pxtype
        },
        dataType: 'json'
    })
    .done(function(data) 
    {
        if(data.status === false)
        {
            $('#totalPatientViaRoomOccupancyRate').html("0" + " Patient(s)");
            $('#RoomOccRateNamexO').html('&#9635' + ' ' + 'NO DATA' + ': ');
            $('#RoomOccRateValueO').html('0' + " (0.00%)");

            for(var num0nondatacv = 0; num0nondatacv < 10; num0nondatacv++ )
            {
                $('#RoomOccRateValue' + num0nondatacv).html("0" + " (0.00%)");
                $('#RoomOccRateNamex' + num0nondatacv).html('&#9635' + " " + "NO DATA" + ": ");
            }  

            disableInpatientRoomOccupancyRateChart();
        }
        else
        {
            var RORtoptentotal = 0;
            var RORotherstotal = 0;
            var RORtoptenstrng = "";
            var RORothersstrng = "";
            var RORtoptenvalue = "";
            var RORothersvalue = "";

            for (var cv = 0; cv < data.getinpatientroomoccupancyrate.length; cv++)
            {
                RORtoptentotal = parseInt(RORtoptentotal) + parseInt(data.getinpatientroomoccupancyrate[cv]['MAX_COUNT']);
                RORtoptenstrng = RORtoptenstrng + data.getinpatientroomoccupancyrate[cv]['roomno'] + "|";
                RORtoptenvalue = RORtoptenvalue + data.getinpatientroomoccupancyrate[cv]['MAX_COUNT'] + "|";
            }
            
            $.ajax
            ({
                type: 'POST',
                url:  BASE_URL + "Dashboard/getInpatientRoomOccupancyRateOthers",
                data: 
                {
                    monthyearx:monthyear,
                    pxtypex: pxtype,
                    RORnames: RORtoptenstrng
                },
                dataType: 'json'
            })
            .done(function(data2) 
            {
                var RORtotaltoptenandothers = 0;
                var RORstrngtoptenandothers = "";
                var RORvaluetoptenandothers = "";
                
                for (var cvothers = 0; cvothers < data2.getinpatientroomrateothers.length; cvothers++)
                {
                    RORotherstotal = parseInt(RORotherstotal) + parseInt(data2.getinpatientroomrateothers[cvothers]['MAX_COUNT_OTHERS']);
                    RORothersstrng = RORothersstrng + data2.getinpatientroomrateothers[cvothers]['roomno'] + "|";
                    RORothersvalue = RORothersvalue + data2.getinpatientroomrateothers[cvothers]['MAX_COUNT_OTHERS'] + "|";
                }
                
                RORtotaltoptenandothers = parseInt(RORtoptentotal) + parseInt(RORotherstotal);
                RORstrngtoptenandothers = RORtoptenstrng + "|" + "OTHERS";
                RORvaluetoptenandothers = RORtoptenvalue + "|" + RORotherstotal;
                
                var RORtoptennamesstr = RORstrngtoptenandothers.split("|");
                var RORtoptennamesarr = removeIndex(RORtoptennamesstr,'');
                
                var RORtoptenvaluestr = RORvaluetoptenandothers.split("|");
                var RORtoptenvaluearr = removeIndex(RORtoptenvaluestr,'');
                
                $('#totalPatientViaRoomOccupancyRate').html(accounting.format(RORtotaltoptenandothers) + " Patient(s)");
                
                var roomoccvar = [];
                var maxcounter = [];
                var percentval = [];
                
                var RORtoptenlength = parseInt(data.getinpatientroomoccupancyrate.length) + parseInt(1);                
                for (var percentcv = 0; percentcv < RORtoptenlength; percentcv++)
                {
                    roomoccvar[percentcv] = RORtoptennamesarr[percentcv];
                    maxcounter[percentcv] = RORtoptenvaluearr[percentcv];
                    percentval[percentcv] = accounting.format((maxcounter[percentcv]/RORtotaltoptenandothers)*100,2);
                }

                var RORnamestrings = "";
                var RORpercentagex = "";
                var RORpercentrate = "";
                var RORforothersxx = "";

                if(RORtoptenlength === 2)
                {
                    RORnamestrings = roomoccvar[0] + "|" + "NO DATA" + "|" + "NO DATA" + "|" + "NO DATA" + "|" + "NO DATA" + "|" +
                                         "NO DATA" + "|" + "NO DATA" + "|" + "NO DATA" + "|" + "NO DATA" + "|" + "NO DATA" + "|" + "OTHERS";

                    RORpercentagex = percentval[0] + "|" + "0.00" + "|" + "0.00" + "|" + "0.00" + "|" + "0.00" + "|" +
                                         "0.00" + "|" + "0.00" + "|" + "0.00" + "|" + "0.00" + "|" + "0.00" + "|" + "0.00";

                    RORpercentrate = maxcounter[0] + "|" + "0" + "|" + "0" + "|" + "0" + "|" + "0" + "|" +
                                         "0" + "|" + "0" + "|" + "0" + "|" + "0" + "|" + "0" + "|" + "0";   

                    for(var num1hasdatacv = 0; num1hasdatacv < 1; num1hasdatacv++ )
                    {
                        $('#RoomOccRateValue' + num1hasdatacv).html(accounting.format(maxcounter[num1hasdatacv]) + " (" + percentval[num1hasdatacv] + "%)");
                        $('#RoomOccRateNamex' + num1hasdatacv).html('&#9635' + " " + roomoccvar[num1hasdatacv] + ": ");
                    }

                    for(var num1nondatacv = 1; num1nondatacv < 11; num1nondatacv++ )
                    {
                        $('#RoomOccRateValue' + num1nondatacv).html("0" + " (0.00%)");
                        $('#RoomOccRateNamex' + num1nondatacv).html('&#9635' + " " + "NO DATA" + ": ");
                    }   
                    
                    $('#RoomOccRateValueO').html("0" + " (0.00%)");
                    $('#RoomOccRateNamexO').html('&#9635' + " " + "OTHERS" + ": ");
                }
                else if(RORtoptenlength === 3)
                {
                    RORnamestrings = roomoccvar[0] + "|" + roomoccvar[1] + "|" + "NO DATA" + "|" + "NO DATA" + "|" + "NO DATA" + "|" +
                                         "NO DATA" + "|" + "NO DATA" + "|" + "NO DATA" + "|" + "NO DATA" + "|" + "NO DATA" + "|" + "OTHERS";

                    RORpercentagex = percentval[0] + "|" + percentval[1] + "|" + "0.00" + "|" + "0.00" + "|" + "0.00" + "|" +
                                         "0.00" + "|" + "0.00" + "|" + "0.00" + "|" + "0.00" + "|" + "0.00" + "|" + "0.00";

                    RORpercentrate = maxcounter[0] + "|" + maxcounter[1] + "|" + "0" + "|" + "0" + "|" + "0" + "|" +
                                         "0" + "|" + "0" + "|" + "0" + "|" + "0" + "|" + "0" + "|" + "0";

                    for(var num2hasdatacv = 0; num2hasdatacv < 2; num2hasdatacv++ )
                    {
                        $('#RoomOccRateValue' + num2hasdatacv).html(accounting.format(maxcounter[num2hasdatacv]) + " (" + percentval[num2hasdatacv] + "%)");
                        $('#RoomOccRateNamex' + num2hasdatacv).html('&#9635' + " " + roomoccvar[num2hasdatacv] + ": ");
                    }

                    for(var num2nondatacv = 2; num2nondatacv < 11; num2nondatacv++ )
                    {
                        $('#RoomOccRateValue' + num2nondatacv).html("0" + " (0.00%)");
                        $('#RoomOccRateNamex' + num2nondatacv).html('&#9635' + " " + "NO DATA" + ": ");
                    }   
                    
                    $('#RoomOccRateValueO').html("0" + " (0.00%)");
                    $('#RoomOccRateNamexO').html('&#9635' + " " + "OTHERS" + ": ");
                }
                else if(RORtoptenlength === 4)
                {
                    RORnamestrings = roomoccvar[0] + "|" + roomoccvar[1] + "|" + roomoccvar[2] + "|" + "NO DATA" + "|" + "NO DATA" + "|" +
                                         "NO DATA" + "|" + "NO DATA" + "|" + "NO DATA" + "|" + "NO DATA" + "|" + "NO DATA" + "|" + "OTHERS";

                    RORpercentagex = percentval[0] + "|" + percentval[1] + "|" + percentval[2] + "|" + "0.00" + "|" + "0.00" + "|" +
                                         "0.00" + "|" + "0.00" + "|" + "0.00" + "|" + "0.00" + "|" + "0.00" + "|" + "0.00";

                    RORpercentrate = maxcounter[0] + "|" + maxcounter[1] + "|" + maxcounter[2] + "|" + "0" + "|" + "0" + "|" +
                                         "0" + "|" + "0" + "|" + "0" + "|" + "0" + "|" + "0" + "|" + "0";

                    for(var num3hasdatacv = 0; num3hasdatacv < 3; num3hasdatacv++ )
                    {
                        $('#RoomOccRateValue' + num3hasdatacv).html(accounting.format(maxcounter[num3hasdatacv]) + " (" + percentval[num3hasdatacv] + "%)");
                        $('#RoomOccRateNamex' + num3hasdatacv).html('&#9635' + " " + roomoccvar[num3hasdatacv] + ": ");
                    }

                    for(var num3nondatacv = 3; num3nondatacv < 11; num3nondatacv++ )
                    {
                        $('#RoomOccRateValue' + num3nondatacv).html("0" + " (0.00%)");
                        $('#RoomOccRateNamex' + num3nondatacv).html('&#9635' + " " + "NO DATA" + ": ");
                    }   
                    
                    $('#RoomOccRateValueO').html("0" + " (0.00%)");
                    $('#RoomOccRateNamexO').html('&#9635' + " " + "OTHERS" + ": ");
                }
                else if(RORtoptenlength === 5)
                {
                    RORnamestrings = roomoccvar[0] + "|" + roomoccvar[1] + "|" + roomoccvar[2] + "|" + roomoccvar[3] + "|" + "NO DATA" + "|" +
                                         "NO DATA" + "|" + "NO DATA" + "|" + "NO DATA" + "|" + "NO DATA" + "|" + "NO DATA" + "|" + "OTHERS";

                    RORpercentagex = percentval[0] + "|" + percentval[1] + "|" + percentval[2] + "|" + percentval[3] + "|" + "0.00" + "|" +
                                         "0.00" + "|" + "0.00" + "|" + "0.00" + "|" + "0.00" + "|" + "0.00" + "|" + "0.00";

                    RORpercentrate = maxcounter[0] + "|" + maxcounter[1] + "|" + maxcounter[2] + "|" + maxcounter[3] + "|" + "0" + "|" +
                                         "0" + "|" + "0" + "|" + "0" + "|" + "0" + "|" + "0" + "|" + "0";

                    for(var num4hasdatacv = 0; num4hasdatacv < 4; num4hasdatacv++ )
                    {
                        $('#RoomOccRateValue' + num4hasdatacv).html(accounting.format(maxcounter[num4hasdatacv]) + " (" + percentval[num4hasdatacv] + "%)");
                        $('#RoomOccRateNamex' + num4hasdatacv).html('&#9635' + " " + roomoccvar[num4hasdatacv] + ": ");
                    }

                    for(var num4nondatacv = 4; num4nondatacv < 11; num4nondatacv++ )
                    {
                        $('#RoomOccRateValue' + num4nondatacv).html("0" + " (0.00%)");
                        $('#RoomOccRateNamex' + num4nondatacv).html('&#9635' + " " + "NO DATA" + ": ");
                    }      
                    
                    $('#RoomOccRateValueO').html("0" + " (0.00%)");
                    $('#RoomOccRateNamexO').html('&#9635' + " " + "OTHERS" + ": ");
                }
                else if(RORtoptenlength === 6)
                {
                    RORnamestrings = roomoccvar[0] + "|" + roomoccvar[1] + "|" + roomoccvar[2] + "|" + roomoccvar[3] + "|" + roomoccvar[4] + "|" +
                                         "NO DATA" + "|" + "NO DATA" + "|" + "NO DATA" + "|" + "NO DATA" + "|" + "NO DATA" + "|" + "OTHERS";

                    RORpercentagex = percentval[0] + "|" + percentval[1] + "|" + percentval[2] + "|" + percentval[3] + "|" + percentval[4] + "|" +
                                         "0.00" + "|" + "0.00" + "|" + "0.00" + "|" + "0.00" + "|" + "0.00" + "|" + "0.00";

                    RORpercentrate = maxcounter[0] + "|" + maxcounter[1] + "|" + maxcounter[2] + "|" + maxcounter[3] + "|" + maxcounter[4] + "|" +
                                         "0" + "|" + "0" + "|" + "0" + "|" + "0" + "|" + "0" + "|" + "0";

                    for(var num5hasdatacv = 0; num5hasdatacv < 5; num5hasdatacv++ )
                    {
                        $('#RoomOccRateValue' + num5hasdatacv).html(accounting.format(maxcounter[num5hasdatacv]) + " (" + percentval[num5hasdatacv] + "%)");
                        $('#RoomOccRateNamex' + num5hasdatacv).html('&#9635' + " " + roomoccvar[num5hasdatacv] + ": ");
                    }

                    for(var num5nondatacv = 5; num5nondatacv < 11; num5nondatacv++ )
                    {
                        $('#RoomOccRateValue' + num5nondatacv).html("0" + " (0.00%)");
                        $('#RoomOccRateNamex' + num5nondatacv).html('&#9635' + " " + "NO DATA" + ": ");
                    } 
                    
                    $('#RoomOccRateValueO').html("0" + " (0.00%)");
                    $('#RoomOccRateNamexO').html('&#9635' + " " + "OTHERS" + ": ");
                }
                else if(RORtoptenlength === 7)
                {
                    RORnamestrings = roomoccvar[0] + "|" + roomoccvar[1] + "|" + roomoccvar[2] + "|" + roomoccvar[3] + "|" + roomoccvar[4] + "|" +
                                         roomoccvar[5] + "|" + "NO DATA" + "|" + "NO DATA" + "|" + "NO DATA" + "|" + "NO DATA" + "|" + "OTHERS";

                    RORpercentagex = percentval[0] + "|" + percentval[1] + "|" + percentval[2] + "|" + percentval[3] + "|" + percentval[4] + "|" +
                                         percentval[5] + "|" + "0.00" + "|" + "0.00" + "|" + "0.00" + "|" + "0.00" + "|" + "0.00";

                    RORpercentrate = maxcounter[0] + "|" + maxcounter[1] + "|" + maxcounter[2] + "|" + maxcounter[3] + "|" + maxcounter[4] + "|" +
                                         maxcounter[5] + "|" + "0" + "|" + "0" + "|" + "0" + "|" + "0" + "|" + "0";

                    for(var num6hasdatacv = 0; num6hasdatacv < 6; num6hasdatacv++ )
                    {
                        $('#RoomOccRateValue' + num6hasdatacv).html(accounting.format(maxcounter[num6hasdatacv]) + " (" + percentval[num6hasdatacv] + "%)");
                        $('#RoomOccRateNamex' + num6hasdatacv).html('&#9635' + " " + roomoccvar[num6hasdatacv] + ": ");
                    }

                    for(var num6nondatacv = 6; num6nondatacv < 11; num6nondatacv++ )
                    {
                        $('#RoomOccRateValue' + num6nondatacv).html("0" + " (0.00%)");
                        $('#RoomOccRateNamex' + num6nondatacv).html('&#9635' + " " + "NO DATA" + ": ");
                    } 
                    
                    $('#RoomOccRateValueO').html("0" + " (0.00%)");
                    $('#RoomOccRateNamexO').html('&#9635' + " " + "OTHERS" + ": ");
                }
                else if(RORtoptenlength === 8)
                {
                    RORnamestrings = roomoccvar[0] + "|" + roomoccvar[1] + "|" + roomoccvar[2] + "|" + roomoccvar[3] + "|" + roomoccvar[4] + "|" +
                                         roomoccvar[5] + "|" + roomoccvar[6] + "|" + "NO DATA" + "|" + "NO DATA" + "|" + "NO DATA" + "|" + "OTHERS";

                    RORpercentagex = percentval[0] + "|" + percentval[1] + "|" + percentval[2] + "|" + percentval[3] + "|" + percentval[4] + "|" +
                                         percentval[5] + "|" + percentval[6] + "|" + "0.00" + "|" + "0.00" + "|" + "0.00" + "|" + "0.00";

                    RORpercentrate = maxcounter[0] + "|" + maxcounter[1] + "|" + maxcounter[2] + "|" + maxcounter[3] + "|" + maxcounter[4] + "|" +
                                         maxcounter[5] + "|" + maxcounter[6] + "|" + "0" + "|" + "0" + "|" + "0" + "|" + "0";

                    for(var num7hasdatacv = 0; num7hasdatacv < 7; num7hasdatacv++ )
                    {
                        $('#RoomOccRateValue' + num7hasdatacv).html(accounting.format(maxcounter[num7hasdatacv]) + " (" + percentval[num7hasdatacv] + "%)");
                        $('#RoomOccRateNamex' + num7hasdatacv).html('&#9635' + " " + roomoccvar[num7hasdatacv] + ": ");
                    }

                    for(var num7nondatacv = 7; num7nondatacv < 11; num7nondatacv++ )
                    {
                        $('#RoomOccRateValue' + num7nondatacv).html("0" + " (0.00%)");
                        $('#RoomOccRateNamex' + num7nondatacv).html('&#9635' + " " + "NO DATA" + ": ");
                    } 
                    
                    $('#RoomOccRateValueO').html("0" + " (0.00%)");
                    $('#RoomOccRateNamexO').html('&#9635' + " " + "OTHERS" + ": ");
                }
                else if(RORtoptenlength === 9)
                {
                    RORnamestrings = roomoccvar[0] + "|" + roomoccvar[1] + "|" + roomoccvar[2] + "|" + roomoccvar[3] + "|" + roomoccvar[4] + "|" +
                                         roomoccvar[5] + "|" + roomoccvar[6] + "|" + roomoccvar[7] + "|" + "NO DATA" + "|" + "NO DATA" + "|" + "OTHERS";

                    RORpercentagex = percentval[0] + "|" + percentval[1] + "|" + percentval[2] + "|" + percentval[3] + "|" + percentval[4] + "|" +
                                         percentval[5] + "|" + percentval[6] + "|" + percentval[7] + "|" + "0.00" + "|" + "0.00" + "|" + "0.00";

                    RORpercentrate = maxcounter[0] + "|" + maxcounter[1] + "|" + maxcounter[2] + "|" + maxcounter[3] + "|" + maxcounter[4] + "|" +
                                         maxcounter[5] + "|" + maxcounter[6] + "|" + maxcounter[7] + "|" + "0" + "|" + "0" + "|" + "0";

                    for(var num8hasdatacv = 0; num8hasdatacv < 8; num8hasdatacv++ )
                    {
                        $('#RoomOccRateValue' + num8hasdatacv).html(accounting.format(maxcounter[num8hasdatacv]) + " (" + percentval[num8hasdatacv] + "%)");
                        $('#RoomOccRateNamex' + num8hasdatacv).html('&#9635' + " " + roomoccvar[num8hasdatacv] + ": ");
                    }

                    for(var num8nondatacv = 8; num8nondatacv < 11; num8nondatacv++ )
                    {
                        $('#RoomOccRateValue' + num8nondatacv).html("0" + " (0.00%)");
                        $('#RoomOccRateNamex' + num8nondatacv).html('&#9635' + " " + "NO DATA" + ": ");
                    } 
                    
                    $('#RoomOccRateValueO').html("0" + " (0.00%)");
                    $('#RoomOccRateNamexO').html('&#9635' + " " + "OTHERS" + ": ");
                }
                else if(RORtoptenlength === 10)
                {
                    RORnamestrings = roomoccvar[0] + "|" + roomoccvar[1] + "|" + roomoccvar[2] + "|" + roomoccvar[3] + "|" + roomoccvar[4] + "|" +
                                         roomoccvar[5] + "|" + roomoccvar[6] + "|" + roomoccvar[7] + "|" + roomoccvar[8] + "|" + "NO DATA" + "|" + "OTHERS";

                    RORpercentagex = percentval[0] + "|" + percentval[1] + "|" + percentval[2] + "|" + percentval[3] + "|" + percentval[4] + "|" +
                                         percentval[5] + "|" + percentval[6] + "|" + percentval[7] + "|" + percentval[8] + "|" + "0.00" + "|" + "0.00";

                    RORpercentrate = maxcounter[0] + "|" + maxcounter[1] + "|" + maxcounter[2] + "|" + maxcounter[3] + "|" + maxcounter[4] + "|" +
                                         maxcounter[5] + "|" + maxcounter[6] + "|" + maxcounter[7] + "|" + maxcounter[8] + "|" + "0" + "|" + "0";

                    for(var num9hasdatacv = 0; num9hasdatacv < 9; num9hasdatacv++ )
                    {
                        $('#RoomOccRateValue' + num9hasdatacv).html(accounting.format(maxcounter[num9hasdatacv]) + " (" + percentval[num9hasdatacv] + "%)");
                        $('#RoomOccRateNamex' + num9hasdatacv).html('&#9635' + " " + roomoccvar[num9hasdatacv] + ": ");
                    }

                    for(var num9nondatacv = 9; num9nondatacv < 11; num9nondatacv++ )
                    {
                        $('#RoomOccRateValue' + num9nondatacv).html("0" + " (0.00%)");
                        $('#RoomOccRateNamex' + num9nondatacv).html('&#9635' + " " + "NO DATA" + ": ");
                    } 
                    
                    $('#RoomOccRateValueO').html("0" + " (0.00%)");
                    $('#RoomOccRateNamexO').html('&#9635' + " " + "OTHERS" + ": ");
                }
                else
                {
                    RORnamestrings = roomoccvar[0] + "|" + roomoccvar[1] + "|" + roomoccvar[2] + "|" + roomoccvar[3] + "|" + roomoccvar[4] + "|" +
                                         roomoccvar[5] + "|" + roomoccvar[6] + "|" + roomoccvar[7] + "|" + roomoccvar[8] + "|" + roomoccvar[9] + "|" + roomoccvar[10];

                    RORpercentagex = percentval[0] + "|" + percentval[1] + "|" + percentval[2] + "|" + percentval[3] + "|" + percentval[4] + "|" +
                                         percentval[5] + "|" + percentval[6] + "|" + percentval[7] + "|" + percentval[8] + "|" + percentval[9] + "|" + percentval[10];

                    RORpercentrate = maxcounter[0] + "|" + maxcounter[1] + "|" + maxcounter[2] + "|" + maxcounter[3] + "|" + maxcounter[4] + "|" +
                                         maxcounter[5] + "|" + maxcounter[6] + "|" + maxcounter[7] + "|" + maxcounter[8] + "|" + maxcounter[9] + "|" + maxcounter[10];  

                    RORforothersxx = roomoccvar[0] + "|" + roomoccvar[1] + "|" + roomoccvar[2] + "|" + roomoccvar[3] + "|" + roomoccvar[4] + "|" +
                                         roomoccvar[5] + "|" + roomoccvar[6] + "|" + roomoccvar[7] + "|" + roomoccvar[8] + "|" + roomoccvar[9];

                    for(var num10hasdatacv = 0; num10hasdatacv < 11; num10hasdatacv++ )
                    {
                        $('#RoomOccRateValue' + num10hasdatacv).html(accounting.format(maxcounter[num10hasdatacv]) + " (" + percentval[num10hasdatacv] + "%)");
                        $('#RoomOccRateNamex' + num10hasdatacv).html('&#9635' + " " + roomoccvar[num10hasdatacv] + ": ");
                        
                        $('#RoomOccRateValueO').html(accounting.format(maxcounter[num10hasdatacv]) + " (" + percentval[num10hasdatacv] + "%)");
                        $('#RoomOccRateNamexO').html('&#9635' + " " + "OTHERS" + ": ");
                    }                                      
                }
                
                getChartForInpatientRoomOccupancyRate(RORnamestrings, RORpercentagex, monthyear, pxtype, RORpercentrate, RORforothersxx);
            });
        }
    });
}

function getInpatientVolumeRequestCategory(monthyear)
{
    $.ajax
    ({
        type: 'POST',
        url:  BASE_URL + "Dashboard/getLaboratoryLedgersalesRequestVolume",
        data: 
        {
            monthyearx:monthyear
        },
        dataType: 'json'
    })
    .done(function(data) 
    {
        var GetLabRequestVolume = 0;
        var GetRadRequestVolume = 0;
        var GetPhaRequestVolume = 0;
        
        if(data.getlabrequestvolume['getLabRequestVolume'] !== null)
        {
            GetLabRequestVolume = data.getlabrequestvolume['getLabRequestVolume'];
        }
        
        if(data.getradrequestvolume['getRadRequestVolume'] !== null)
        {
            GetRadRequestVolume = data.getradrequestvolume['getRadRequestVolume'];
        }
        
        if(data.getpharequestvolume['getPhaRequestVolume'] !== null)
        {
            GetPhaRequestVolume = data.getpharequestvolume['getPhaRequestVolume'];
        }
        
        var totalRequest = parseInt(GetLabRequestVolume) + parseInt(GetRadRequestVolume) + parseInt(GetPhaRequestVolume);
        $('#totalPatientViaRequestVolume').html(accounting.format(totalRequest) + " Request(s)");
        
        var LabRequestVolume = accounting.format((GetLabRequestVolume/totalRequest)*100,2);
        var RadRequestVolume = accounting.format((GetRadRequestVolume/totalRequest)*100,2);
        var PhaRequestVolume = accounting.format((GetPhaRequestVolume/totalRequest)*100,2);
        
        $('#LabTotal').html(accounting.format(GetLabRequestVolume) + " (" + LabRequestVolume + "%)");
        $('#RadTotal').html(accounting.format(GetRadRequestVolume) + " (" + RadRequestVolume + "%)");
        $('#PhaTotal').html(accounting.format(GetPhaRequestVolume) + " (" + PhaRequestVolume + "%)");

        if(LabRequestVolume === "0.00" && RadRequestVolume === "0.00" && PhaRequestVolume === "0.00")
        {
            disableRequestVolumeChart();
        }
        else
        {
            getChartForRequestVolume(LabRequestVolume, RadRequestVolume, PhaRequestVolume);
        }
    });
    
}

function disableInpatientGenderChart()
{
    var MalePercentRoundedOff = 0.00;
    var FemaPercentRoundedOff = 0.00;
    
    InpatientGenderCategory = "";
    
    var gendercategory = MalePercentRoundedOff.toString() + "|" + FemaPercentRoundedOff.toString();
    InpatientGenderCategory = InpatientGenderCategory + gendercategory;
    
    $("#inpatient_stat_sex_category_donut_chart").empty();
    $("#inpatient_stat_sex_category_donut_chart").css
    ({
        'height': '170px',
        'width' : '170px'
    });
    
    Morris.Donut
    ({
        element: 'inpatient_stat_sex_category_donut_chart',
        data: 
        [
            {
                label: 'NO DATA',
                value: 100
            }
        ],
        colors: 
        [
            "rgba(171, 170, 169)"
        ],
        formatter: 
        function (y)
        {
            return y + '%';
        },
        labelColor: "transparent"
    });
}

function disableInpatientAgeChart()
{
    var InfantPercentage = 0.00;
    var ChildxPercentage = 0.00;
    var YouthxPercentage = 0.00;
    var AdultxPercentage = 0.00;
    var SeniorPercentage = 0.00;
    
    InpatientAgexxxCategory = "";
    
    var agecategory = InfantPercentage.toString() + "|" + 
                         ChildxPercentage.toString() + "|" + 
                         YouthxPercentage.toString() + "|" + 
                         AdultxPercentage.toString() + "|" + 
                         SeniorPercentage.toString();
                 
    InpatientAgexxxCategory = InpatientAgexxxCategory + agecategory;
    
    var config = null;
    
    config = 
    {
        type: 'pie',
        data: 
        {
            datasets: 
            [{
                data: [1000],
                backgroundColor: 
                [
                    "rgba(171, 170, 169)"
                ]
            }],
            labels: 
            [
                "MALE"
            ]
        },
        options: 
        {
            responsive: true,
            legend: false,
            tooltips: 
            {
                enabled: false,
                custom : function(tooltipModel) 
                {
                    tooltipModel.opacity = 0;
                }
            }
        }
    };
    
    return config;
}

function disableInpatientCityMunChart()
{
    var citymunnamestring = "NO DATA" + "|" + "NO DATA" + "|" +
                            "NO DATA" + "|" + "NO DATA" + "|" +
                            "NO DATA" + "|" + "NO DATA" + "|" +
                            "NO DATA" + "|" + "NO DATA" + "|" +
                            "NO DATA" + "|" + "NO DATA" + "|" +
                            "OTHERS";
    
    var citymunpercentage = "0" + "|" + "0" + "|" +
                            "0" + "|" + "0" + "|" +
                            "0" + "|" + "0" + "|" +
                            "0" + "|" + "0" + "|" +
                            "0" + "|" + "0" + "|" +
                            "0";
                    
    var citymunrealvaluex = "0" + "|" + "0" + "|" +
                            "0" + "|" + "0" + "|" +
                            "0" + "|" + "0" + "|" +
                            "0" + "|" + "0" + "|" +
                            "0" + "|" + "0" + "|" +
                            "0";
                    
    InpatientCityMuCategory = "";
    var citymuncategory = citymunnamestring.toString() + "?" + citymunpercentage.toString() + "?" + citymunrealvaluex.toString();
    InpatientCityMuCategory = InpatientCityMuCategory + citymuncategory;
    
    $("#inpatient_stat_citymun_category_bar_chart").empty();
    $("#inpatient_stat_citymun_category_bar_chart").css('background','#E1E1E1');
    
    Morris.Bar
    ({
        element: 'inpatient_stat_citymun_category_bar_chart',
        xkey: 'y',
        ykeys: ['a'],
        labels: ['PERCENTAGE: '],
        hideHover: 'always',
        axes: true,
        resize:true,
        barOpacity: 0.8,
        gridTextSize: 12,
        horizontal: true,
        stacked: true,
        data: 
        [
            { y: 'NO DATA', a: 0.00 },
            { y: 'NO DATA', a: 0.00 },
            { y: 'NO DATA', a: 0.00 },
            { y: 'NO DATA', a: 0.00 },
            { y: 'NO DATA', a: 0.00 },
            { y: 'NO DATA', a: 0.00 },
            { y: 'NO DATA', a: 0.00 },
            { y: 'NO DATA', a: 0.00 },
            { y: 'NO DATA', a: 0.00 },
            { y: 'NO DATA', a: 0.00 },
            { y: 'OTHERS', a: 0.00 }
        ]
    });
}

function disableInpatientProvinceChart()
{
    var provincenamestring = "NO DATA" + "|" + "NO DATA" + "|" +
                             "NO DATA" + "|" + "NO DATA" + "|" +
                             "NO DATA" + "|" + "NO DATA" + "|" +
                             "NO DATA" + "|" + "NO DATA" + "|" +
                             "NO DATA" + "|" + "NO DATA" + "|" +
                             "OTHERS";
    
    var provincepercentage = "0" + "|" + "0" + "|" +
                             "0" + "|" + "0" + "|" +
                             "0" + "|" + "0" + "|" +
                             "0" + "|" + "0" + "|" +
                             "0" + "|" + "0" + "|" +
                             "0";
                    
    var provincerealvaluex = "0" + "|" + "0" + "|" +
                             "0" + "|" + "0" + "|" +
                             "0" + "|" + "0" + "|" +
                             "0" + "|" + "0" + "|" +
                             "0" + "|" + "0" + "|" +
                             "0";
                    
    InpatientProvinCategory = "";
    var provincecategory = provincenamestring.toString() + "?" + provincepercentage.toString() + "?" + provincerealvaluex.toString();
    InpatientProvinCategory = InpatientProvinCategory + provincecategory;
    
    $("#inpatient_stat_province_category_bar_chart").empty();
    $("#inpatient_stat_province_category_bar_chart").css('background','#E1E1E1');
    
    Morris.Bar
    ({
        element: 'inpatient_stat_province_category_bar_chart',
        xkey: 'y',
        ykeys: ['a'],
        labels: ['PERCENTAGE: '],
        hideHover: 'always',
        axes: true,
        resize:true,
        barOpacity: 0.8,
        gridTextSize: 12,
        horizontal: true,
        stacked: true,
        data: 
        [
            { y: 'NO DATA', a: 0.00 },
            { y: 'NO DATA', a: 0.00 },
            { y: 'NO DATA', a: 0.00 },
            { y: 'NO DATA', a: 0.00 },
            { y: 'NO DATA', a: 0.00 },
            { y: 'NO DATA', a: 0.00 },
            { y: 'NO DATA', a: 0.00 },
            { y: 'NO DATA', a: 0.00 },
            { y: 'NO DATA', a: 0.00 },
            { y: 'NO DATA', a: 0.00 },
            { y: 'OTHERS', a: 0.00 }
        ]
    });
}

function disableInpatientInsuranceChart()
{
    var insurancenamestring = "NO DATA" + "|" + "NO DATA" + "|" +
                              "NO DATA" + "|" + "NO DATA" + "|" +
                              "NO DATA" + "|" + "NO DATA" + "|" +
                              "NO DATA" + "|" + "NO DATA" + "|" +
                              "NO DATA" + "|" + "NO DATA" + "|" +
                              "OTHERS";
    
    var insurancepercentage = "0" + "|" + "0" + "|" +
                              "0" + "|" + "0" + "|" +
                              "0" + "|" + "0" + "|" +
                              "0" + "|" + "0" + "|" +
                              "0" + "|" + "0" + "|" +
                              "0";
                    
    var insurancerealvaluex = "0" + "|" + "0" + "|" +
                              "0" + "|" + "0" + "|" +
                              "0" + "|" + "0" + "|" +
                              "0" + "|" + "0" + "|" +
                              "0" + "|" + "0" + "|" +
                              "0";
                    
    InpatientInsuraCategory = "";
    var insurancecategory = insurancenamestring.toString() + "?" + insurancepercentage.toString() + "?" + insurancerealvaluex.toString();
    InpatientInsuraCategory = InpatientInsuraCategory + insurancecategory;
    
    $("#inpatient_stat_insurance_category_bar_chart").empty();
    $("#inpatient_stat_insurance_category_bar_chart").css('background','#E1E1E1');
    
    Morris.Bar
    ({
        element: 'inpatient_stat_insurance_category_bar_chart',
        xkey: 'y',
        ykeys: ['a'],
        labels: ['PERCENTAGE: '],
        hideHover: 'always',
        axes: true,
        resize:true,
        barOpacity: 0.8,
        gridTextSize: 12,
        horizontal: true,
        stacked: true,
        data: 
        [
            { y: 'NO DATA', a: 0.00 },
            { y: 'NO DATA', a: 0.00 },
            { y: 'NO DATA', a: 0.00 },
            { y: 'NO DATA', a: 0.00 },
            { y: 'NO DATA', a: 0.00 },
            { y: 'NO DATA', a: 0.00 },
            { y: 'NO DATA', a: 0.00 },
            { y: 'NO DATA', a: 0.00 },
            { y: 'NO DATA', a: 0.00 },
            { y: 'NO DATA', a: 0.00 },
            { y: 'OTHERS', a: 0.00 }
        ]
    });
}

function disableInpatientRoomOccupancyRateChart()
{
    var RORnamestring = "NO DATA" + "|" + "NO DATA" + "|" +
                        "NO DATA" + "|" + "NO DATA" + "|" +
                        "NO DATA" + "|" + "NO DATA" + "|" +
                        "NO DATA" + "|" + "NO DATA" + "|" +
                        "NO DATA" + "|" + "NO DATA" + "|" +
                        "OTHERS";
    
    var RORpercentage = "0" + "|" + "0" + "|" +
                        "0" + "|" + "0" + "|" +
                        "0" + "|" + "0" + "|" +
                        "0" + "|" + "0" + "|" +
                        "0" + "|" + "0" + "|" +
                        "0";
                    
    var RORrealvaluex = "0" + "|" + "0" + "|" +
                        "0" + "|" + "0" + "|" +
                        "0" + "|" + "0" + "|" +
                        "0" + "|" + "0" + "|" +
                        "0" + "|" + "0" + "|" +
                        "0";
                    
    InpatientRoomocCategory = "";
    var RORcategory = RORnamestring.toString() + "?" + RORpercentage.toString() + "?" + RORrealvaluex.toString();
    InpatientRoomocCategory = InpatientRoomocCategory + RORcategory;
   
    $("#inpatient_stat_room_occupancy_rate_category_bar_chart").empty();
    $("#inpatient_stat_room_occupancy_rate_category_bar_chart").css('background','#E1E1E1');
    
    Morris.Bar
    ({
        element: 'inpatient_stat_room_occupancy_rate_category_bar_chart',
        xkey: 'y',
        ykeys: ['a'],
        labels: ['PERCENTAGE: '],
        hideHover: 'always',
        axes: true,
        resize:true,
        barOpacity: 0.8,
        gridTextSize: 12,
        horizontal: true,
        stacked: true,
        data: 
        [
            { y: 'NO DATA', a: 0.00 },
            { y: 'NO DATA', a: 0.00 },
            { y: 'NO DATA', a: 0.00 },
            { y: 'NO DATA', a: 0.00 },
            { y: 'NO DATA', a: 0.00 },
            { y: 'NO DATA', a: 0.00 },
            { y: 'NO DATA', a: 0.00 },
            { y: 'NO DATA', a: 0.00 },
            { y: 'NO DATA', a: 0.00 },
            { y: 'NO DATA', a: 0.00 },
            { y: 'OTHERS', a: 0.00 }
        ]
    });
}

function disableRequestVolumeChart()
{
    var VORpercentage = "0" + "|" + "0" + "|" + "0";
                    
    InpatientVolumeCategory = "";
    var VORcategory = VORpercentage.toString();
    InpatientVolumeCategory = InpatientVolumeCategory + VORcategory;
    
    $("#inpatient_stat_request_volume_category_bar_chart").empty();
    $("#inpatient_stat_request_volume_category_bar_chart").css('background','#E1E1E1');
    
    Morris.Bar
    ({
        element: 'inpatient_stat_request_volume_category_bar_chart',
        xkey: 'y',
        ykeys: ['a'],
        labels: ['PERCENTAGE '],
        axes: true,
        resize:true,
        barOpacity: 0.8,
        gridTextSize: 12,
        horizontal: true,
        stacked: true,
        data: 
        [
            { y: 'LABORATORY', a: 0.00 },
            { y: 'RADIOLOGY', a: 0.00 },
            { y: 'PHARMACY', a: 0.00 }
        ],
        barColors: function (row, series, type) 
        {
            if(row.label === 'LABORATORY')
            {
                return "rgba(70, 150, 42, 0.8)";
            }
            else if(row.label === 'RADIOLOGY')
            {
                return "rgba(62, 86, 205, 0.8)";
            }
            else
            {
                return "rgba(255, 117, 2, 0.8)";
            }
        }  
    });
}

function getChartForInpatientGender(MalePercentRoundedOff, FemaPercentRoundedOff)
{
    InpatientGenderCategory = "";
    
    var gendercategory = MalePercentRoundedOff.toString() + "|" + FemaPercentRoundedOff.toString();
    InpatientGenderCategory = InpatientGenderCategory + gendercategory;
    
    $("#inpatient_stat_sex_category_donut_chart").empty();
    $("#inpatient_stat_sex_category_donut_chart").css
    ({
        'height': '170px',
        'width' : '170px'
    });
    
    Morris.Donut
    ({
        element: 'inpatient_stat_sex_category_donut_chart',
        data: 
        [
            {
                label: 'MALE',
                value: MalePercentRoundedOff
            }, 
            {
                label: 'FEMALE',
                value: FemaPercentRoundedOff
            }
        ],
        colors: 
        [
            'rgba(0, 188, 212, 0.8)',
            'rgba(233, 30, 99, 0.8)'
        ],
        formatter: 
            function (y)
            {
                return y + '%';
            }
    }).on('click', function (i, row) 
    {  
//        row.value
//        row.label;

        var rowname = row.label;
        var category = rowname.toUpperCase();
        showAllPatientUnderSexCateg(category);
    });
}

function getChartForInpatientAge(InfantPercentage, ChildxPercentage, YouthxPercentage, AdultxPercentage, SeniorPercentage)
{
    InpatientAgexxxCategory = "";
    
    var agecategory = InfantPercentage.toString() + "|" + 
                      ChildxPercentage.toString() + "|" +
                      YouthxPercentage.toString() + "|" +
                      AdultxPercentage.toString() + "|" +
                      SeniorPercentage.toString();
                 
    InpatientAgexxxCategory = InpatientAgexxxCategory + agecategory;
    
    var configage = null;
 
    configage = 
    {
        type: 'pie',
        data: 
        {
            datasets: 
            [{
                data:
                [
                    InfantPercentage, 
                    ChildxPercentage,
                    YouthxPercentage,
                    AdultxPercentage,
                    SeniorPercentage
                ],
                backgroundColor: 
                [
                    "rgba(0, 188, 212, 0.8)",
                    "rgba(233, 30, 99, 0.8)",
                    "rgba(70, 150, 42, 0.8)",
                    "rgba(62, 86, 205, 0.8)",
                    "rgba(255, 117, 2, 0.8)"
                ]
            }],
            labels: 
            [
                "INFANT",
                "CHILD",
                "YOUTH",
                "ADULT",
                "SENIOR"
            ]
        },
        options: 
        {
            responsive: true,
            legend: false
        }
    };
    
    return configage;
}

function getChartForInpatientCityMunicipality(citymunnamestring, citymunpercentage, monthyear, pxtype, citymunpercentrate, citynameforothersx)
{
    InpatientCityMuCategory = "";
    var citymuncategory = citymunnamestring.toString() + "?" + citymunpercentage.toString() + "?" + citymunpercentrate.toString();
    InpatientCityMuCategory = InpatientCityMuCategory + citymuncategory;
    
    var splitcitynamestring = citymunnamestring.split("|");
    var citymunnamex00 = splitcitynamestring[0];
    var citymunnamex01 = splitcitynamestring[1];
    var citymunnamex02 = splitcitynamestring[2];
    var citymunnamex03 = splitcitynamestring[3];
    var citymunnamex04 = splitcitynamestring[4];
    var citymunnamex05 = splitcitynamestring[5];
    var citymunnamex06 = splitcitynamestring[6];
    var citymunnamex07 = splitcitynamestring[7];
    var citymunnamex08 = splitcitynamestring[8];
    var citymunnamex09 = splitcitynamestring[9];
    var citymunnamex10 = splitcitynamestring[10];
    
    var splitcitypercentage = citymunpercentage.split("|");
    var citymunvalue00 = splitcitypercentage[0];
    var citymunvalue01 = splitcitypercentage[1];
    var citymunvalue02 = splitcitypercentage[2];
    var citymunvalue03 = splitcitypercentage[3];
    var citymunvalue04 = splitcitypercentage[4];
    var citymunvalue05 = splitcitypercentage[5];
    var citymunvalue06 = splitcitypercentage[6];
    var citymunvalue07 = splitcitypercentage[7];
    var citymunvalue08 = splitcitypercentage[8];
    var citymunvalue09 = splitcitypercentage[9];
    var citymunvalue10 = splitcitypercentage[10];
    
    $("#inpatient_stat_citymun_category_bar_chart").empty();
    $("#inpatient_stat_citymun_category_bar_chart").css('background','#D5ECCA');
    
    Morris.Bar
    ({
        element: 'inpatient_stat_citymun_category_bar_chart',
        xkey: 'y',
        ykeys: ['a'],
        labels: ['PERCENTAGE: '],
        axes: true,
        resize:true,
        barOpacity: 0.8,
        gridTextSize: 12,
        horizontal: true,
        stacked: true,
        data: 
        [
            { y: citymunnamex00, a: citymunvalue00 },
            { y: citymunnamex01, a: citymunvalue01 },
            { y: citymunnamex02, a: citymunvalue02 },
            { y: citymunnamex03, a: citymunvalue03 },
            { y: citymunnamex04, a: citymunvalue04 },
            { y: citymunnamex05, a: citymunvalue05 },
            { y: citymunnamex06, a: citymunvalue06 },
            { y: citymunnamex07, a: citymunvalue07 },
            { y: citymunnamex08, a: citymunvalue08 },
            { y: citymunnamex09, a: citymunvalue09 },
            { y: citymunnamex10, a: citymunvalue10 }
        ],
        barColors: function (row, series, type) 
        {
            if(row.label === citymunnamex00)
            {
                return "rgba(0, 188, 212, 0.8)";
            }
            else if(row.label === citymunnamex01)
            {
                return "rgba(233, 30, 99, 0.8)";
            }
            else if(row.label === citymunnamex02)
            {
                return "rgba(70, 150, 42, 0.8)";
            }
            else if(row.label === citymunnamex03)
            {
                return "rgba(62, 86, 205, 0.8)";
            }
            else if(row.label === citymunnamex04)
            {
                return "rgba(221, 159, 5, 0.8)";
            }
            else if(row.label === citymunnamex05)
            {
                return "rgba(174, 2, 255, 0.8)";
            }
            else if(row.label === citymunnamex06)
            {
                return "rgba(129, 69, 47, 0.8)";
            }
            else if(row.label === citymunnamex07)
            {
                return "rgba(252, 2, 222, 0.8)";
            }
            else if(row.label === citymunnamex08)
            {
                return "rgba(5, 146, 221, 0.8)";
            }
            else if(row.label === citymunnamex09)
            {
                return "rgba(254, 74, 11, 0.8)";
            }
            else
            {
                return "rgba(120, 120, 1, 0.8)";
            }
        }  
    });
    
    
    $( "#inpatient_stat_citymun_category_bar_chart svg rect" ).on('click', function()
    {
        
        var barcityname = $("#inpatient_stat_citymun_category_bar_chart .morris-hover-row-label").html();
        var clicktype = "BAR TYPE";

        showAllPatientUnderMunicipality(barcityname, monthyear, pxtype, citynameforothersx, clicktype);

//            var thisDataHtml = $(".morris-hover-point").html().split(": :");
//            var thisData = thisDataHtml[1].trim();
//            alert( "Data: "+thisData+"\nDate: "+thisDate );
    });
}

function getChartForInpatientProvince(provincenamestring, provincepercentage, monthyear, pxtype, provincepercntrate, provnameforothersx)
{
    InpatientProvinCategory = "";
    var provincecategory = provincenamestring.toString() + "?" + provincepercentage.toString() + "?" + provincepercntrate.toString();
    InpatientProvinCategory = InpatientProvinCategory + provincecategory;    
    
    var splitprovnamestring = provincenamestring.split("|");
    var provincenamex00 = splitprovnamestring[0];
    var provincenamex01 = splitprovnamestring[1];
    var provincenamex02 = splitprovnamestring[2];
    var provincenamex03 = splitprovnamestring[3];
    var provincenamex04 = splitprovnamestring[4];
    var provincenamex05 = splitprovnamestring[5];
    var provincenamex06 = splitprovnamestring[6];
    var provincenamex07 = splitprovnamestring[7];
    var provincenamex08 = splitprovnamestring[8];
    var provincenamex09 = splitprovnamestring[9];
    var provincenamex10 = splitprovnamestring[10];
    
    var splitprovpercentage = provincepercentage.split("|");
    var provincevalue00 = splitprovpercentage[0];
    var provincevalue01 = splitprovpercentage[1];
    var provincevalue02 = splitprovpercentage[2];
    var provincevalue03 = splitprovpercentage[3];
    var provincevalue04 = splitprovpercentage[4];
    var provincevalue05 = splitprovpercentage[5];
    var provincevalue06 = splitprovpercentage[6];
    var provincevalue07 = splitprovpercentage[7];
    var provincevalue08 = splitprovpercentage[8];
    var provincevalue09 = splitprovpercentage[9];
    var provincevalue10 = splitprovpercentage[10];
    
    $("#inpatient_stat_province_category_bar_chart").empty();
    $("#inpatient_stat_province_category_bar_chart").css('background','#F4DEC7');
    
    Morris.Bar
    ({
        element: 'inpatient_stat_province_category_bar_chart',
        xkey: 'y',
        ykeys: ['a'],
        labels: ['PERCENTAGE: '],
        axes: true,
        resize:true,
        barOpacity: 0.8,
        gridTextSize: 12,
        horizontal: true,
        stacked: true,
        data: 
        [
            { y: provincenamex00, a: provincevalue00 },
            { y: provincenamex01, a: provincevalue01 },
            { y: provincenamex02, a: provincevalue02 },
            { y: provincenamex03, a: provincevalue03 },
            { y: provincenamex04, a: provincevalue04 },
            { y: provincenamex05, a: provincevalue05 },
            { y: provincenamex06, a: provincevalue06 },
            { y: provincenamex07, a: provincevalue07 },
            { y: provincenamex08, a: provincevalue08 },
            { y: provincenamex09, a: provincevalue09 },
            { y: provincenamex10, a: provincevalue10 }
        ],
        barColors: function (row, series, type) 
        {
            if(row.label === provincenamex00)
            {
                return "rgba(0, 188, 212, 0.8)";
            }
            else if(row.label === provincenamex01)
            {
                return "rgba(233, 30, 99, 0.8)";
            }
            else if(row.label === provincenamex02)
            {
                return "rgba(70, 150, 42, 0.8)";
            }
            else if(row.label === provincenamex03)
            {
                return "rgba(62, 86, 205, 0.8)";
            }
            else if(row.label === provincenamex04)
            {
                return "rgba(221, 159, 5, 0.8)";
            }
            else if(row.label === provincenamex05)
            {
                return "rgba(174, 2, 255, 0.8)";
            }
            else if(row.label === provincenamex06)
            {
                return "rgba(129, 69, 47, 0.8)";
            }
            else if(row.label === provincenamex07)
            {
                return "rgba(252, 2, 222, 0.8)";
            }
            else if(row.label === provincenamex08)
            {
                return "rgba(5, 146, 221, 0.8)";
            }
            else if(row.label === provincenamex09)
            {
                return "rgba(254, 74, 11, 0.8)";
            }
            else
            {
                return "rgba(120, 120, 1, 0.8)";
            }
        }  
    });

    $( "#inpatient_stat_province_category_bar_chart svg rect" ).on('click', function()
    {
        var barprovname = $("#inpatient_stat_province_category_bar_chart .morris-hover-row-label").html();
        var clicktype = "BAR TYPE";

        showAllPatientUnderProvince(barprovname, monthyear, pxtype, provnameforothersx, clicktype);
    });
}

function getChartForInpatientInsurance(insurancenamestring, insurancepercentage, monthyear, pxtype, insurancepercntrate, insuranceforothersx)
{
//    InpatientInsuraCategory = "";
//    var insurancecategory = insurancenamestring.toString() + "?" + insurancepercentage.toString() + "?" + insurancepercntrate.toString();
//    InpatientInsuraCategory = InpatientInsuraCategory + insurancecategory;    
    
    var splithmonamexstring = insurancenamestring.split("|");
    var insurancenamex00 = splithmonamexstring[0];
    var insurancenamex01 = splithmonamexstring[1];
    var insurancenamex02 = splithmonamexstring[2];
    var insurancenamex03 = splithmonamexstring[3];
    var insurancenamex04 = splithmonamexstring[4];
    var insurancenamex05 = splithmonamexstring[5];
    var insurancenamex06 = splithmonamexstring[6];
    var insurancenamex07 = splithmonamexstring[7];
    var insurancenamex08 = splithmonamexstring[8];
    var insurancenamex09 = splithmonamexstring[9];
    var insurancenamex10 = splithmonamexstring[10];
    
    var splithmoxpercentage = insurancepercentage.split("|");
    var insurancevalue00 = splithmoxpercentage[0];
    var insurancevalue01 = splithmoxpercentage[1];
    var insurancevalue02 = splithmoxpercentage[2];
    var insurancevalue03 = splithmoxpercentage[3];
    var insurancevalue04 = splithmoxpercentage[4];
    var insurancevalue05 = splithmoxpercentage[5];
    var insurancevalue06 = splithmoxpercentage[6];
    var insurancevalue07 = splithmoxpercentage[7];
    var insurancevalue08 = splithmoxpercentage[8];
    var insurancevalue09 = splithmoxpercentage[9];
    var insurancevalue10 = splithmoxpercentage[10];
    
    $("#inpatient_stat_insurance_category_bar_chart").empty();
    $("#inpatient_stat_insurance_category_bar_chart").css('background','#B6F7F4');
    
    Morris.Bar
    ({
        element: 'inpatient_stat_insurance_category_bar_chart',
        xkey: 'y',
        ykeys: ['a'],
        labels: ['PERCENTAGE: '],
        axes: true,
        resize:true,
        barOpacity: 0.8,
        gridTextSize: 12,
        horizontal: true,
        stacked: true,
        data: 
        [
            { y: insurancenamex00, a: insurancevalue00 },
            { y: insurancenamex01, a: insurancevalue01 },
            { y: insurancenamex02, a: insurancevalue02 },
            { y: insurancenamex03, a: insurancevalue03 },
            { y: insurancenamex04, a: insurancevalue04 },
            { y: insurancenamex05, a: insurancevalue05 },
            { y: insurancenamex06, a: insurancevalue06 },
            { y: insurancenamex07, a: insurancevalue07 },
            { y: insurancenamex08, a: insurancevalue08 },
            { y: insurancenamex09, a: insurancevalue09 },
            { y: insurancenamex10, a: insurancevalue10 }
        ],
        barColors: function (row, series, type) 
        {
            if(row.label === insurancenamex00)
            {
                return "rgba(0, 188, 212, 0.8)";
            }
            else if(row.label === insurancenamex01)
            {
                return "rgba(233, 30, 99, 0.8)";
            }
            else if(row.label === insurancenamex02)
            {
                return "rgba(70, 150, 42, 0.8)";
            }
            else if(row.label === insurancenamex03)
            {
                return "rgba(62, 86, 205, 0.8)";
            }
            else if(row.label === insurancenamex04)
            {
                return "rgba(221, 159, 5, 0.8)";
            }
            else if(row.label === insurancenamex05)
            {
                return "rgba(174, 2, 255, 0.8)";
            }
            else if(row.label === insurancenamex06)
            {
                return "rgba(129, 69, 47, 0.8)";
            }
            else if(row.label === insurancenamex07)
            {
                return "rgba(252, 2, 222, 0.8)";
            }
            else if(row.label === insurancenamex08)
            {
                return "rgba(5, 146, 221, 0.8)";
            }
            else if(row.label === insurancenamex09)
            {
                return "rgba(254, 74, 11, 0.8)";
            }
            else
            {
                return "rgba(120, 120, 1, 0.8)";
            }
        }  
    });

    $( "#inpatient_stat_insurance_category_bar_chart svg rect" ).on('click', function()
    {
        var barhmoname = $("#inpatient_stat_insurance_category_bar_chart .morris-hover-row-label").html();
        var clicktype = "BAR TYPE";

        showAllPatientUnderInsurance(barhmoname, monthyear, pxtype, insuranceforothersx, clicktype);
    });
}

function getSeries(event) 
{
    var rectCol = this.getAttribute("fill");    
    $(".morris-hover-point").each(function()
    {
         var labStyle = this.getAttribute("style");
         var labCol = labStyle.slice(labStyle.indexOf(":")+1);           

         if(rectCol.trim() === labCol.trim()) 
         {
             console.log("You have clicked on: "+this.textContent);          
         }
    });    
}

function getChartForInpatientRoomOccupancyRate(RORnamestring, RORpercentage, monthyear, pxtype, RORtruevaluex, RORforothersxx)
{
    InpatientRoomocCategory = "";
    var RORcategory = RORnamestring.toString() + "?" + RORpercentage.toString() + "?" + RORtruevaluex.toString();
    InpatientRoomocCategory = InpatientRoomocCategory + RORcategory;    
    
    var splitRORnamestring = RORnamestring.split("|");
    var RORnamex00 = splitRORnamestring[0];
    var RORnamex01 = splitRORnamestring[1];
    var RORnamex02 = splitRORnamestring[2];
    var RORnamex03 = splitRORnamestring[3];
    var RORnamex04 = splitRORnamestring[4];
    var RORnamex05 = splitRORnamestring[5];
    var RORnamex06 = splitRORnamestring[6];
    var RORnamex07 = splitRORnamestring[7];
    var RORnamex08 = splitRORnamestring[8];
    var RORnamex09 = splitRORnamestring[9];
    var RORnamex10 = splitRORnamestring[10];
    
    var splitRORpercentage = RORpercentage.split("|");
    var RORvalue00 = splitRORpercentage[0];
    var RORvalue01 = splitRORpercentage[1];
    var RORvalue02 = splitRORpercentage[2];
    var RORvalue03 = splitRORpercentage[3];
    var RORvalue04 = splitRORpercentage[4];
    var RORvalue05 = splitRORpercentage[5];
    var RORvalue06 = splitRORpercentage[6];
    var RORvalue07 = splitRORpercentage[7];
    var RORvalue08 = splitRORpercentage[8];
    var RORvalue09 = splitRORpercentage[9];
    var RORvalue10 = splitRORpercentage[10];

    $("#inpatient_stat_room_occupancy_rate_category_bar_chart").empty();
    $("#inpatient_stat_room_occupancy_rate_category_bar_chart").css('background','#E9CAEC');
    
    Morris.Bar
    ({
        element: 'inpatient_stat_room_occupancy_rate_category_bar_chart',
        xkey: 'y',
        ykeys: ['a'],
        labels: ['PERCENTAGE: '],
        axes: true,
        resize:true,
        barOpacity: 0.8,
        gridTextSize: 12,
        horizontal: true,
        stacked: true,
        data: 
        [
            { y: RORnamex00, a: RORvalue00 },
            { y: RORnamex01, a: RORvalue01 },
            { y: RORnamex02, a: RORvalue02 },
            { y: RORnamex03, a: RORvalue03 },
            { y: RORnamex04, a: RORvalue04 },
            { y: RORnamex05, a: RORvalue05 },
            { y: RORnamex06, a: RORvalue06 },
            { y: RORnamex07, a: RORvalue07 },
            { y: RORnamex08, a: RORvalue08 },
            { y: RORnamex09, a: RORvalue09 },
            { y: RORnamex10, a: RORvalue10 }
        ],
        barColors: function (row, series, type) 
        {
            if(row.label === RORnamex00)
            {
                return "rgba(0, 188, 212, 0.8)";
            }
            else if(row.label === RORnamex01)
            {
                return "rgba(233, 30, 99, 0.8)";
            }
            else if(row.label === RORnamex02)
            {
                return "rgba(70, 150, 42, 0.8)";
            }
            else if(row.label === RORnamex03)
            {
                return "rgba(62, 86, 205, 0.8)";
            }
            else if(row.label === RORnamex04)
            {
                return "rgba(221, 159, 5, 0.8)";
            }
            else if(row.label === RORnamex05)
            {
                return "rgba(174, 2, 255, 0.8)";
            }
            else if(row.label === RORnamex06)
            {
                return "rgba(129, 69, 47, 0.8)";
            }
            else if(row.label === RORnamex07)
            {
                return "rgba(252, 2, 222, 0.8)";
            }
            else if(row.label === RORnamex08)
            {
                return "rgba(5, 146, 221, 0.8)";
            }
            else if(row.label === RORnamex09)
            {
                return "rgba(254, 74, 11, 0.8)";
            }
            else
            {
                return "rgba(120, 120, 1, 0.8)";
            }
        }  
    });
    
    $( "#inpatient_stat_room_occupancy_rate_category_bar_chart svg rect" ).on('click', function()
    {
        var barroomname = $("#inpatient_stat_room_occupancy_rate_category_bar_chart .morris-hover-row-label").html();
        var clicktype = "BAR TYPE";
        
        showAllPatientUnderRoomrate(barroomname, monthyear, pxtype, RORforothersxx, clicktype);
    });
}

function getChartForRequestVolume(LabRequestVolume, RadRequestVolume, PhaRequestVolume)
{
    InpatientVolumeCategory = "";
    
    var VORcategory = LabRequestVolume.toString() + "|" + 
                      RadRequestVolume.toString() + "|" + 
                      PhaRequestVolume.toString();
              
    InpatientVolumeCategory = InpatientVolumeCategory + VORcategory;
    
    $("#inpatient_stat_request_volume_category_bar_chart").empty();
    
    Morris.Bar
    ({
        element: 'inpatient_stat_request_volume_category_bar_chart',
        xkey: 'y',
        ykeys: ['a'],
        labels: ['PERCENTAGE '],
        axes: true,
        resize:true,
        barOpacity: 0.8,
        gridTextSize: 12,
        horizontal: true,
        stacked: true,
        data: 
        [
            { y: 'LABORATORY', a: LabRequestVolume },
            { y: 'RADIOLOGY', a: RadRequestVolume },
            { y: 'PHARMACY', a: PhaRequestVolume }
        ],
        barColors: function (row, series, type) 
        {
            if(row.label === 'LABORATORY')
            {
                return "rgba(70, 150, 42, 0.8)";
            }
            else if(row.label === 'RADIOLOGY')
            {
                return "rgba(62, 86, 205, 0.8)";
            }
            else
            {
                return "rgba(255, 117, 2, 0.8)";
            }
        }  
    });
}

function showAllPatientUnderMunicipality(cityname, monthyear, pxtype, citynameforothersx, clicktype)
{
    $('#crmpxviamunicipal').modal("show");
    
    if(clicktype === "BAR TYPE")
    {
        var month = moment(monthyear).format("MMMM");
        var year = moment(monthyear).format("YYYY");
        var fulldate = month + " " + year;
        
        $('#titleid_pxmunicrm').html("ALL " + cityname + " PATIENT LISTING");
        $('#daterequestcitymunparam').val(fulldate);
        $('#citymunnamecitymunparam').val(cityname);
        $('#patienttypecitymunparam').val(pxtype);
        $('#othersnamescitymunparam').val(citynameforothersx);

        if(cityname === "OTHERS")
        {
            getAllInPatientAndAddItToTheTableOthers(citynameforothersx, fulldate, pxtype);
        }
        else
        {
            getAllInPatientAndAddItToTheTableTopten(cityname, fulldate, pxtype);
        }
    }
    else if(clicktype === "TXT TYPE")
    {
        var slicecityname = cityname.slice(2);
        var txtcityname = slicecityname.substr(0, slicecityname.length-2); 
            
        var selecteddate = $('#monthid_coveredDate').val();
        var month = moment(selecteddate).format("MMMM");
        var year = moment(selecteddate).format("YYYY");
        var txtfulldate = month + " " + year;
        
        var txtpxtypexx = $('#selectid_patienttype').val();

        var txtothersstring = "";
        
        for(var i = 0; i < 10; i++)
        {   
            var slicecitystring = $('#CityAddNamex' + i).text().slice(2);
            var substcitystring = slicecitystring.substr(0, slicecitystring.length-2);
            txtothersstring = txtothersstring + substcitystring + "|";
        }
        
        var txtotherstr = txtothersstring.substr(0, txtothersstring.length-1);
    
        $('#titleid_pxmunicrm').html("ALL " + txtcityname + " PATIENT LISTING");
        $('#daterequestcitymunparam').val(txtfulldate);
        $('#citymunnamecitymunparam').val(txtcityname);
        $('#patienttypecitymunparam').val(txtpxtypexx);
        $('#othersnamescitymunparam').val(txtotherstr);

        if(txtcityname === "OTHERS")
        {
            getAllInPatientAndAddItToTheTableOthers(txtotherstr, txtfulldate, txtpxtypexx);
        }
        else
        {
            getAllInPatientAndAddItToTheTableTopten(txtcityname, txtfulldate, txtpxtypexx);
        }
    }
    else
    {
        var selecteddate = $('#monthid_coveredDate').val();
        var month = moment(selecteddate).format("MMMM");
        var year = moment(selecteddate).format("YYYY");
        var txtfulldate = month + " " + year;
        
        var txtpxtypexx = $('#selectid_patienttype').val();
        var txtcityname = "ALL CITY/MUNICIPALITY";
        $('#titleid_pxmunicrm').html(txtcityname + " PATIENT LISTING");
        $('#daterequestcitymunparam').val(txtfulldate);
        $('#citymunnamecitymunparam').val(txtcityname);
        $('#patienttypecitymunparam').val(txtpxtypexx);
        $('#othersnamescitymunparam').val(txtotherstr);
        
        getAllInPatientAndAddItToTheTableTopten(txtcityname, txtfulldate, txtpxtypexx);
    }
}

function showAllPatientUnderProvince(provname, monthyear, pxtype, provnameforothersx, clicktype)
{
    $('#crmpxviaprovince').modal("show");
    
    if(clicktype === "BAR TYPE")
    {
        var month = moment(monthyear).format("MMMM");
        var year = moment(monthyear).format("YYYY");
        var fulldate = month + " " + year;
        
        $('#titleid_pxprovcrm').html("ALL " + provname + " PATIENT LISTING");
        $('#daterequestprovinceparam').val(fulldate);
        $('#provinznameprovinceparam').val(provname);
        $('#patienttypeprovinceparam').val(pxtype);
        $('#othersnamesprovinceparam').val(provnameforothersx);

        if(provname === "OTHERS")
        {
            getAllInPatientProvOtherAndAddItToTheTableOthers(provnameforothersx, fulldate, pxtype);
        }
        else
        {
            getAllInPatientProvParamAndAddItToTheTableTopten(provname, fulldate, pxtype);
        }
    }
    else if(clicktype === "TXT TYPE")
    {
        var sliceprovname = provname.slice(2);
        var txtprovname = sliceprovname.substr(0, sliceprovname.length-2); 
            
        var selecteddate = $('#monthid_coveredDate').val();
        var monthtxt = moment(selecteddate).format("MMMM");
        var yeartxt = moment(selecteddate).format("YYYY");
        var txtfulldate = monthtxt + " " + yeartxt;
        
        var txtpxtypexx = $('#selectid_patienttype').val();

        var txtothersstring = "";
        
        for(var i = 0; i < 10; i++)
        {   
            var sliceprovstring = $('#ProvAddNamex' + i).text().slice(2);
            var substprovstring = sliceprovstring.substr(0, sliceprovstring.length-2);
            txtothersstring = txtothersstring + substprovstring + "|";
        }
        
        var txtotherstr = txtothersstring.substr(0, txtothersstring.length-1);
    
        $('#titleid_pxprovcrm').html("ALL " + txtprovname + " PATIENT LISTING");
        $('#daterequestprovinceparam').val(txtfulldate);
        $('#provinznameprovinceparam').val(txtprovname);
        $('#patienttypeprovinceparam').val(txtpxtypexx);
        $('#othersnamesprovinceparam').val(txtotherstr);

        if(txtprovname === "OTHERS")
        {
            getAllInPatientProvOtherAndAddItToTheTableOthers(txtotherstr, txtfulldate, txtpxtypexx);
        }
        else
        {
            getAllInPatientProvParamAndAddItToTheTableTopten(txtprovname, txtfulldate, txtpxtypexx);
        }
    }
    else
    {
        var selecteddateall = $('#monthid_coveredDate').val();
        var monthall = moment(selecteddateall).format("MMMM");
        var yearall = moment(selecteddateall).format("YYYY");
        var txtfulldateall = monthall + " " + yearall;
        
        var txtpxtypexxall = $('#selectid_patienttype').val();
        var txtprovnameall = "ALL PROVINCE";
        $('#titleid_pxprovcrm').html(txtprovnameall + " PATIENT LISTING");
        $('#daterequestprovinceparam').val(txtfulldateall);
        $('#provinznameprovinceparam').val(txtprovnameall);
        $('#patienttypeprovinceparam').val(txtpxtypexxall);
        $('#othersnamesprovinceparam').val(txtotherstr);
        
        getAllInPatientProvParamAndAddItToTheTableTopten(txtprovnameall, txtfulldateall, txtpxtypexxall);
    }
}

function showAllPatientUnderInsurance(hmoname, monthyear, pxtype, hmonameforothersx, clicktype)
{
    $('#crmpxviainsurance').modal("show");
    
    if(clicktype === "BAR TYPE")
    {
        var hmonameforothersxsplit = hmonameforothersx.split("|");
        var hmoparamstrings = "";

        if(hmonameforothersxsplit[0] === "NON-HMO")
        {
            hmoparamstrings = "" + "|" + 
                              hmonameforothersxsplit[1] + "|" +
                              hmonameforothersxsplit[2] + "|" +
                              hmonameforothersxsplit[3] + "|" +
                              hmonameforothersxsplit[4] + "|" +
                              hmonameforothersxsplit[5] + "|" +
                              hmonameforothersxsplit[6] + "|" +
                              hmonameforothersxsplit[7] + "|" +
                              hmonameforothersxsplit[8] + "|" +
                              hmonameforothersxsplit[9];
        }
        else if(hmonameforothersxsplit[1] === "NON-HMO")
        {
            hmoparamstrings = hmonameforothersxsplit[0] + "|" + 
                              "" + "|" +
                              hmonameforothersxsplit[2] + "|" +
                              hmonameforothersxsplit[3] + "|" +
                              hmonameforothersxsplit[4] + "|" +
                              hmonameforothersxsplit[5] + "|" +
                              hmonameforothersxsplit[6] + "|" +
                              hmonameforothersxsplit[7] + "|" +
                              hmonameforothersxsplit[8] + "|" +
                              hmonameforothersxsplit[9];
        }
        else if(hmonameforothersxsplit[2] === "NON-HMO")
        {
            hmoparamstrings = hmonameforothersxsplit[0] + "|" + 
                              hmonameforothersxsplit[1] + "|" +
                              "" + "|" +
                              hmonameforothersxsplit[3] + "|" +
                              hmonameforothersxsplit[4] + "|" +
                              hmonameforothersxsplit[5] + "|" +
                              hmonameforothersxsplit[6] + "|" +
                              hmonameforothersxsplit[7] + "|" +
                              hmonameforothersxsplit[8] + "|" +
                              hmonameforothersxsplit[9];
        }
        else if(hmonameforothersxsplit[3] === "NON-HMO")
        {
            hmoparamstrings = hmonameforothersxsplit[0] + "|" + 
                              hmonameforothersxsplit[1] + "|" +
                              hmonameforothersxsplit[2] + "|" +
                              "" + "|" +
                              hmonameforothersxsplit[4] + "|" +
                              hmonameforothersxsplit[5] + "|" +
                              hmonameforothersxsplit[6] + "|" +
                              hmonameforothersxsplit[7] + "|" +
                              hmonameforothersxsplit[8] + "|" +
                              hmonameforothersxsplit[9];
        }
        else if(hmonameforothersxsplit[4] === "NON-HMO")
        {
            hmoparamstrings = hmonameforothersxsplit[0] + "|" + 
                              hmonameforothersxsplit[1] + "|" +
                              hmonameforothersxsplit[2] + "|" +
                              hmonameforothersxsplit[3] + "|" +
                              "" + "|" +
                              hmonameforothersxsplit[5] + "|" +
                              hmonameforothersxsplit[6] + "|" +
                              hmonameforothersxsplit[7] + "|" +
                              hmonameforothersxsplit[8] + "|" +
                              hmonameforothersxsplit[9];
        }
        else if(hmonameforothersxsplit[5] === "NON-HMO")
        {
            hmoparamstrings = hmonameforothersxsplit[0] + "|" + 
                              hmonameforothersxsplit[1] + "|" +
                              hmonameforothersxsplit[2] + "|" +
                              hmonameforothersxsplit[3] + "|" +
                              hmonameforothersxsplit[4] + "|" +
                              "" + "|" +
                              hmonameforothersxsplit[6] + "|" +
                              hmonameforothersxsplit[7] + "|" +
                              hmonameforothersxsplit[8] + "|" +
                              hmonameforothersxsplit[9];
        }
        else if(hmonameforothersxsplit[6] === "NON-HMO")
        {
            hmoparamstrings = hmonameforothersxsplit[0] + "|" + 
                              hmonameforothersxsplit[1] + "|" +
                              hmonameforothersxsplit[2] + "|" +
                              hmonameforothersxsplit[3] + "|" +
                              hmonameforothersxsplit[4] + "|" +
                              hmonameforothersxsplit[5] + "|" +
                              "" + "|" +
                              hmonameforothersxsplit[7] + "|" +
                              hmonameforothersxsplit[8] + "|" +
                              hmonameforothersxsplit[9];
        }
        else if(hmonameforothersxsplit[7] === "NON-HMO")
        {
            hmoparamstrings = hmonameforothersxsplit[0] + "|" + 
                              hmonameforothersxsplit[1] + "|" +
                              hmonameforothersxsplit[2] + "|" +
                              hmonameforothersxsplit[3] + "|" +
                              hmonameforothersxsplit[4] + "|" +
                              hmonameforothersxsplit[5] + "|" +
                              hmonameforothersxsplit[6] + "|" +
                              "" + "|" +
                              hmonameforothersxsplit[8] + "|" +
                              hmonameforothersxsplit[9];
        }
        else if(hmonameforothersxsplit[8] === "NON-HMO")
        {
            hmoparamstrings = hmonameforothersxsplit[0] + "|" + 
                              hmonameforothersxsplit[1] + "|" +
                              hmonameforothersxsplit[2] + "|" +
                              hmonameforothersxsplit[3] + "|" +
                              hmonameforothersxsplit[4] + "|" +
                              hmonameforothersxsplit[5] + "|" +
                              hmonameforothersxsplit[6] + "|" +
                              hmonameforothersxsplit[7] + "|" +
                              "" + "|" +
                              hmonameforothersxsplit[9];
        }
        else
        {
            hmoparamstrings = hmonameforothersxsplit[0] + "|" + 
                              hmonameforothersxsplit[1] + "|" +
                              hmonameforothersxsplit[2] + "|" +
                              hmonameforothersxsplit[3] + "|" +
                              hmonameforothersxsplit[4] + "|" +
                              hmonameforothersxsplit[5] + "|" +
                              hmonameforothersxsplit[6] + "|" +
                              hmonameforothersxsplit[7] + "|" +
                              hmonameforothersxsplit[8] + "|" +
                              "";
        }
        var month = moment(monthyear).format("MMMM");
        var year = moment(monthyear).format("YYYY");
        var fulldate = month + " " + year;
        
        $('#titleid_pxhmocrm').html("ALL " + hmoname + " PATIENT LISTING");
        $('#daterequestinsuranceparam').val(fulldate);
        $('#insurannameinsuranceparam').val(hmoname);
        $('#patienttypeinsuranceparam').val(pxtype);
        $('#othersnamesinsuranceparam').val(hmoparamstrings);

        if(hmoname === "OTHERS")
        {
            getAllInPatientInsuranceAndAddItToTheTableOthers(hmoparamstrings, fulldate, pxtype);
        }
        else
        {
            getAllInPatientInsuranceAndAddItToTheTableTopten(hmoname, fulldate, pxtype);
        }
    }
    else if(clicktype === "TXT TYPE")
    {
        var slicehmoname = hmoname.slice(2);
        var txtprovname = slicehmoname.substr(0, slicehmoname.length-2); 
            
        var selecteddate = $('#monthid_coveredDate').val();
        var monthtxt = moment(selecteddate).format("MMMM");
        var yeartxt = moment(selecteddate).format("YYYY");
        var txtfulldate = monthtxt + " " + yeartxt;
        
        var txtpxtypexx = $('#selectid_patienttype').val();

        var txtothersstring = "";
        
        for(var i = 0; i < 10; i++)
        {   
            var slicehmostring = $('#InsuranceNamex' + i).text().slice(2);
            var substhmostring = slicehmostring.substr(0, slicehmostring.length-2);
            txtothersstring = txtothersstring + substhmostring + "|";
        }
        
        var txtotherstr = txtothersstring.substr(0, txtothersstring.length-1);
        
        var hmonametxtotherstsplit = txtotherstr.split("|");
        var hmoparamstringx = "";

        if(hmonametxtotherstsplit[0] === "NON-HMO")
        {
            hmoparamstringx = "" + "|" + 
                              hmonametxtotherstsplit[1] + "|" +
                              hmonametxtotherstsplit[2] + "|" +
                              hmonametxtotherstsplit[3] + "|" +
                              hmonametxtotherstsplit[4] + "|" +
                              hmonametxtotherstsplit[5] + "|" +
                              hmonametxtotherstsplit[6] + "|" +
                              hmonametxtotherstsplit[7] + "|" +
                              hmonametxtotherstsplit[8] + "|" +
                              hmonametxtotherstsplit[9];
        }
        else if(hmonametxtotherstsplit[1] === "NON-HMO")
        {
            hmoparamstringx = hmonametxtotherstsplit[0] + "|" + 
                              "" + "|" +
                              hmonametxtotherstsplit[2] + "|" +
                              hmonametxtotherstsplit[3] + "|" +
                              hmonametxtotherstsplit[4] + "|" +
                              hmonametxtotherstsplit[5] + "|" +
                              hmonametxtotherstsplit[6] + "|" +
                              hmonametxtotherstsplit[7] + "|" +
                              hmonametxtotherstsplit[8] + "|" +
                              hmonametxtotherstsplit[9];
        }
        else if(hmonametxtotherstsplit[2] === "NON-HMO")
        {
            hmoparamstringx = hmonametxtotherstsplit[0] + "|" + 
                              hmonametxtotherstsplit[1] + "|" +
                              "" + "|" +
                              hmonametxtotherstsplit[3] + "|" +
                              hmonametxtotherstsplit[4] + "|" +
                              hmonametxtotherstsplit[5] + "|" +
                              hmonametxtotherstsplit[6] + "|" +
                              hmonametxtotherstsplit[7] + "|" +
                              hmonametxtotherstsplit[8] + "|" +
                              hmonametxtotherstsplit[9];
        }
        else if(hmonametxtotherstsplit[3] === "NON-HMO")
        {
            hmoparamstringx = hmonametxtotherstsplit[0] + "|" + 
                              hmonametxtotherstsplit[1] + "|" +
                              hmonametxtotherstsplit[2] + "|" +
                              "" + "|" +
                              hmonametxtotherstsplit[4] + "|" +
                              hmonametxtotherstsplit[5] + "|" +
                              hmonametxtotherstsplit[6] + "|" +
                              hmonametxtotherstsplit[7] + "|" +
                              hmonametxtotherstsplit[8] + "|" +
                              hmonametxtotherstsplit[9];
        }
        else if(hmonametxtotherstsplit[4] === "NON-HMO")
        {
            hmoparamstringx = hmonametxtotherstsplit[0] + "|" + 
                              hmonametxtotherstsplit[1] + "|" +
                              hmonametxtotherstsplit[2] + "|" +
                              hmonametxtotherstsplit[3] + "|" +
                              "" + "|" +
                              hmonametxtotherstsplit[5] + "|" +
                              hmonametxtotherstsplit[6] + "|" +
                              hmonametxtotherstsplit[7] + "|" +
                              hmonametxtotherstsplit[8] + "|" +
                              hmonametxtotherstsplit[9];
        }
        else if(hmonametxtotherstsplit[5] === "NON-HMO")
        {
            hmoparamstringx = hmonametxtotherstsplit[0] + "|" + 
                              hmonametxtotherstsplit[1] + "|" +
                              hmonametxtotherstsplit[2] + "|" +
                              hmonametxtotherstsplit[3] + "|" +
                              hmonametxtotherstsplit[4] + "|" +
                              "" + "|" +
                              hmonametxtotherstsplit[6] + "|" +
                              hmonametxtotherstsplit[7] + "|" +
                              hmonametxtotherstsplit[8] + "|" +
                              hmonametxtotherstsplit[9];
        }
        else if(hmonametxtotherstsplit[6] === "NON-HMO")
        {
            hmoparamstringx = hmonametxtotherstsplit[0] + "|" + 
                              hmonametxtotherstsplit[1] + "|" +
                              hmonametxtotherstsplit[2] + "|" +
                              hmonametxtotherstsplit[3] + "|" +
                              hmonametxtotherstsplit[4] + "|" +
                              hmonametxtotherstsplit[5] + "|" +
                              "" + "|" +
                              hmonametxtotherstsplit[7] + "|" +
                              hmonametxtotherstsplit[8] + "|" +
                              hmonametxtotherstsplit[9];
        }
        else if(hmonametxtotherstsplit[7] === "NON-HMO")
        {
            hmoparamstringx = hmonametxtotherstsplit[0] + "|" + 
                              hmonametxtotherstsplit[1] + "|" +
                              hmonametxtotherstsplit[2] + "|" +
                              hmonametxtotherstsplit[3] + "|" +
                              hmonametxtotherstsplit[4] + "|" +
                              hmonametxtotherstsplit[5] + "|" +
                              hmonametxtotherstsplit[6] + "|" +
                              "" + "|" +
                              hmonametxtotherstsplit[8] + "|" +
                              hmonametxtotherstsplit[9];
        }
        else if(hmonametxtotherstsplit[8] === "NON-HMO")
        {
            hmoparamstringx = hmonametxtotherstsplit[0] + "|" + 
                              hmonametxtotherstsplit[1] + "|" +
                              hmonametxtotherstsplit[2] + "|" +
                              hmonametxtotherstsplit[3] + "|" +
                              hmonametxtotherstsplit[4] + "|" +
                              hmonametxtotherstsplit[5] + "|" +
                              hmonametxtotherstsplit[6] + "|" +
                              hmonametxtotherstsplit[7] + "|" +
                              "" + "|" +
                              hmonametxtotherstsplit[9];
        }
        else
        {
            hmoparamstringx = hmonametxtotherstsplit[0] + "|" + 
                              hmonametxtotherstsplit[1] + "|" +
                              hmonametxtotherstsplit[2] + "|" +
                              hmonametxtotherstsplit[3] + "|" +
                              hmonametxtotherstsplit[4] + "|" +
                              hmonametxtotherstsplit[5] + "|" +
                              hmonametxtotherstsplit[6] + "|" +
                              hmonametxtotherstsplit[7] + "|" +
                              hmonametxtotherstsplit[8] + "|" +
                              "";
        }
    
        $('#titleid_pxhmocrm').html("ALL " + txtprovname + " PATIENT LISTING");
        $('#daterequestinsuranceparam').val(txtfulldate);
        $('#insurannameinsuranceparam').val(txtprovname);
        $('#patienttypeinsuranceparam').val(txtpxtypexx);
        $('#othersnamesinsuranceparam').val(hmoparamstringx);

        if(txtprovname === "OTHERS")
        {
            getAllInPatientInsuranceAndAddItToTheTableOthers(hmoparamstringx, txtfulldate, txtpxtypexx);
        }
        else
        {
            getAllInPatientInsuranceAndAddItToTheTableTopten(txtprovname, txtfulldate, txtpxtypexx);
        }
    }
    else
    {
        var selecteddateall = $('#monthid_coveredDate').val();
        var monthall = moment(selecteddateall).format("MMMM");
        var yearall = moment(selecteddateall).format("YYYY");
        var txtfulldateall = monthall + " " + yearall;
        
        var txtpxtypexxall = $('#selectid_patienttype').val();
        var txtprovnameall = "ALL HMO/INSURANCE";
        
        $('#titleid_pxhmocrm').html(txtprovnameall + " PATIENT LISTING");
        $('#daterequestinsuranceparam').val(txtfulldateall);
        $('#insurannameinsuranceparam').val(txtprovnameall);
        $('#patienttypeinsuranceparam').val(txtpxtypexxall);
        $('#othersnamesinsuranceparam').val(txtotherstr);
        
        getAllInPatientInsuranceAndAddItToTheTableTopten(txtprovnameall, txtfulldateall, txtpxtypexxall);
    }
}

function showAllPatientUnderRoomrate(roomname, monthyear, pxtype, RORforothersxx, clicktype)
{
    $('#crmpxviaroomrate').modal("show");
    
    if(clicktype === "BAR TYPE")
    {
        var month = moment(monthyear).format("MMMM");
        var year = moment(monthyear).format("YYYY");
        var fulldate = month + " " + year;
        
        $('#titleid_pxroomcrm').html("ALL " + roomname + " PATIENT LISTING");
        $('#daterequestroomrateparam').val(fulldate);
        $('#roomratnameroomrateparam').val(roomname);
        $('#patienttyperoomrateparam').val(pxtype);
        $('#othersnamesroomrateparam').val(RORforothersxx);

        if(roomname === "OTHERS")
        {
            getAllInPatientRoomParamAndAddItToTheTableOthers(RORforothersxx, fulldate, pxtype);
        }
        else
        {
            getAllInPatientRoomParamAndAddItToTheTableTopten(roomname, fulldate, pxtype);
        }
    }
    else if(clicktype === "TXT TYPE")
    {
        var sliceroomname = roomname.slice(2);
        var txtroomname = sliceroomname.substr(0, sliceroomname.length-2); 
            
        var selecteddate = $('#monthid_coveredDate').val();
        var monthtxt = moment(selecteddate).format("MMMM");
        var yeartxt = moment(selecteddate).format("YYYY");
        var txtfulldate = monthtxt + " " + yeartxt;
        
        var txtpxtypexx = $('#selectid_patienttype').val();

        var txtothersstring = "";
        
        for(var i = 0; i < 10; i++)
        {   
            var sliceroomstring = $('#RoomOccRateNamex' + i).text().slice(2);
            var substroomstring = sliceroomstring.substr(0, sliceroomstring.length-2);
            txtothersstring = txtothersstring + substroomstring + "|";
        }
        
        var txtotherstr = txtothersstring.substr(0, txtothersstring.length-1);
    
        $('#titleid_pxroomcrm').html("ALL " + txtroomname + " PATIENT LISTING");
        $('#daterequestroomrateparam').val(txtfulldate);
        $('#roomratnameroomrateparam').val(txtroomname);
        $('#patienttyperoomrateparam').val(txtpxtypexx);
        $('#othersnamesroomrateparam').val(txtotherstr);

        if(txtroomname === "OTHERS")
        {
            getAllInPatientRoomParamAndAddItToTheTableOthers(txtotherstr, txtfulldate, txtpxtypexx);
        }
        else
        {
            getAllInPatientRoomParamAndAddItToTheTableTopten(txtroomname, txtfulldate, txtpxtypexx);
        }
    }
    else
    {
        var selecteddateall = $('#monthid_coveredDate').val();
        var monthall = moment(selecteddateall).format("MMMM");
        var yearall = moment(selecteddateall).format("YYYY");
        var txtfulldateall = monthall + " " + yearall;
        
        var txtpxtypexxall = $('#selectid_patienttype').val();
        var txtprovnameall = "ALL ROOMS";
        $('#titleid_pxroomcrm').html(txtprovnameall + " PATIENT LISTING");
        $('#daterequestroomrateparam').val(txtfulldateall);
        $('#roomratnameroomrateparam').val(txtprovnameall);
        $('#patienttyperoomrateparam').val(txtpxtypexxall);
        $('#othersnamesroomrateparam').val(txtotherstr);
        
        getAllInPatientRoomParamAndAddItToTheTableTopten(txtprovnameall, txtfulldateall, txtpxtypexxall);
    }
}

function showAllPatientUnderAgeCateg(category)
{
    var monthyear = $("#monthid_coveredDate").val();
    var pxtype = $("#selectid_patienttype").val();
    
    var month = moment(monthyear).format("MMMM");
    var year = moment(monthyear).format("YYYY");
    var fulldate = month + " " + year;
    
    $('#crmpxagecategory').modal("show");
    
    if(category === "ALL")
    {
        $('#titleid_pxagexcrm').html(category + " AGE(S) PATIENT LISTING");
    }
    else
    {
        $('#titleid_pxagexcrm').html("ALL " + category + " PATIENT LISTING");
    }
     
    $('#daterequestagecateparam').val(fulldate);
    $('#agecategoryagecateparam').val(category);
    $('#patienttypeagecateparam').val(pxtype);
    
    getAllInPatientAllAgesCategAndAddItToTheTable(category, fulldate, pxtype);
}

function showAllPatientUnderSexCateg(category)
{
    var monthyear = $("#monthid_coveredDate").val();
    var pxtype = $("#selectid_patienttype").val();
    
    var month = moment(monthyear).format("MMMM");
    var year = moment(monthyear).format("YYYY");
    var fulldate = month + " " + year;
    
    $('#crmpxsexcategory').modal("show");
    
    if(category === "ALL")
    {
        $('#titleid_pxsexxcrm').html(category + " GENDER PATIENT LISTING");
    }
    else
    {
        $('#titleid_pxsexxcrm').html("ALL " + category + " PATIENT LISTING");
    }
    
    $('#daterequestsexcateparam').val(fulldate);
    $('#sexcategorysexcateparam').val(category);
    $('#patienttypesexcateparam').val(pxtype);
    
    getAllInPatientAllSexxCategAndAddItToTheTable(category, fulldate, pxtype);
}

function getAllInPatientAndAddItToTheTableTopten(barcityname, fulldate, pxtype)
{
    citymunpx_table = $('#citymun-patient-table').DataTable();
    citymunpx_table.clear().destroy();
    
    citymunpx_table = $('#citymun-patient-table').DataTable
    ({
        responsive: true,
        processing: true,
        serverSide: true,
        retrieve: true,
        destroy: true,
        order: [],
        ajax: 
        {
            url: BASE_URL + "Dashboard/GetAllPatientViaCitymunParameter",
            type: "POST",
            data: 
            {
                barcityname: barcityname,
                fulldate: fulldate,
                pxtypex: pxtype
            }
        },
        createdRow: function (row, data, dataIndex)
        {
            $('td', row).eq(0).html(dataIndex+1);
        },
        initComplete: function (settings, json)
        {

        }
    });
}

function getAllInPatientAndAddItToTheTableOthers(citynameforothersx, fulldate, pxtype)
{
    citymunpx_table = $('#citymun-patient-table').DataTable();
    citymunpx_table.clear().destroy();
    
    citymunpx_table = $('#citymun-patient-table').DataTable
    ({
        responsive: true,
        processing: true,
        serverSide: true,
        retrieve: true,
        destroy: true,
        order: [],
        ajax: 
        {
            url: BASE_URL + "Dashboard/GetAllPatientViaCitymunParameterOthers",
            type: "POST",
            data: 
            {
                barcityname: citynameforothersx,
                fulldate: fulldate,
                pxtypex: pxtype
            }
        },
        createdRow: function (row, data, dataIndex)
        {
            $('td', row).eq(0).html(dataIndex+1);
        },
        initComplete: function (settings, json)
        {

        }
    });
}

function getAllInPatientProvParamAndAddItToTheTableTopten(barprovname, fulldate, pxtype)
{
    provincepx_table = $('#province-patient-table').DataTable();
    provincepx_table.clear().destroy();
    
    provincepx_table = $('#province-patient-table').DataTable
    ({
        responsive: true,
        processing: true,
        serverSide: true,
        retrieve: true,
        destroy: true,
        order: [],
        ajax: 
        {
            url: BASE_URL + "Dashboard/GetAllPatientViaProvinceParameter",
            type: "POST",
            data: 
            {
                barprovname: barprovname,
                fulldate: fulldate,
                pxtypex: pxtype
            }
        },
        createdRow: function (row, data, dataIndex)
        {
            $('td', row).eq(0).html(dataIndex+1);
        },
        initComplete: function (settings, json)
        {

        }
    });
}

function getAllInPatientInsuranceAndAddItToTheTableTopten(hmoname, fulldate, pxtype)
{
    insurancepx_table = $('#insurance-patient-table').DataTable();
    insurancepx_table.clear().destroy();
    
    insurancepx_table = $('#insurance-patient-table').DataTable
    ({
        responsive: true,
        processing: true,
        serverSide: true,
        retrieve: true,
        destroy: true,
        order: [],
        ajax: 
        {
            url: BASE_URL + "Dashboard/GetAllPatientViaInsuranceParameter",
            type: "POST",
            data: 
            {
                hmoname: hmoname,
                fulldate: fulldate,
                pxtypex: pxtype
            }
        },
        createdRow: function (row, data, dataIndex)
        {
            $('td', row).eq(0).html(dataIndex+1);
        },
        initComplete: function (settings, json)
        {

        }
    });
}

function getAllInPatientProvOtherAndAddItToTheTableOthers(provnameforothersx, fulldate, pxtype)
{
    provincepx_table = $('#province-patient-table').DataTable();
    provincepx_table.clear().destroy();
    
    provincepx_table = $('#province-patient-table').DataTable
    ({
        responsive: true,
        processing: true,
        serverSide: true,
        retrieve: true,
        destroy: true,
        order: [],
        ajax: 
        {
            url: BASE_URL + "Dashboard/GetAllPatientViaProvinceParameterOthers",
            type: "POST",
            data: 
            {
                barprovname: provnameforothersx,
                fulldate: fulldate,
                pxtypex: pxtype
            }
        },
        createdRow: function (row, data, dataIndex)
        {
            $('td', row).eq(0).html(dataIndex+1);
        },
        initComplete: function (settings, json)
        {

        }
    });
}

function getAllInPatientInsuranceAndAddItToTheTableOthers(hmonameforothersx, fulldate, pxtype)
{
    insurancepx_table = $('#insurance-patient-table').DataTable();
    insurancepx_table.clear().destroy();
    
    insurancepx_table = $('#insurance-patient-table').DataTable
    ({
        responsive: true,
        processing: true,
        serverSide: true,
        retrieve: true,
        destroy: true,
        order: [],
        ajax: 
        {
            url: BASE_URL + "Dashboard/GetAllPatientViaInsuranceParameterOthers",
            type: "POST",
            data: 
            {
                hmonames: hmonameforothersx,
                fulldate: fulldate,
                pxtypex: pxtype
            }
        },
        createdRow: function (row, data, dataIndex)
        {
            $('td', row).eq(0).html(dataIndex+1);
        },
        initComplete: function (settings, json)
        {

        }
    });
}

function getAllInPatientRoomParamAndAddItToTheTableTopten(barroomname, fulldate, pxtype)
{
    roomratepx_table = $('#roomrate-patient-table').DataTable();
    roomratepx_table.clear().destroy();
    
    roomratepx_table = $('#roomrate-patient-table').DataTable
    ({
        responsive: true,
        processing: true,
        serverSide: true,
        retrieve: true,
        destroy: true,
        order: [],
        ajax: 
        {
            url: BASE_URL + "Dashboard/GetAllPatientViaRoomrateParameter",
            type: "POST",
            data: 
            {
                barroomname: barroomname,
                fulldate: fulldate,
                pxtypex: pxtype
            }
        },
        createdRow: function (row, data, dataIndex)
        {
            $('td', row).eq(0).html(dataIndex+1);
        },
        initComplete: function (settings, json)
        {

        }
    });
}

function getAllInPatientRoomParamAndAddItToTheTableOthers(roomnamesforothers, fulldate, pxtype)
{
    roomratepx_table = $('#roomrate-patient-table').DataTable();
    roomratepx_table.clear().destroy();
    
    roomratepx_table = $('#roomrate-patient-table').DataTable
    ({
        responsive: true,
        processing: true,
        serverSide: true,
        retrieve: true,
        destroy: true,
        order: [],
        ajax: 
        {
            url: BASE_URL + "Dashboard/GetAllPatientViaRoomrateParameterOthers",
            type: "POST",
            data: 
            {
                barroomname: roomnamesforothers,
                fulldate: fulldate,
                pxtypex: pxtype
            }
        },
        createdRow: function (row, data, dataIndex)
        {
            $('td', row).eq(0).html(dataIndex+1);
        },
        initComplete: function (settings, json)
        {

        }
    });
}

function getAllInPatientAllAgesCategAndAddItToTheTable(category, fulldate, pxtype)
{
    agecateg_table = $('#agecateg-patient-table').DataTable();
    agecateg_table.clear().destroy();
    
    agecateg_table = $('#agecateg-patient-table').DataTable
    ({
        responsive: true,
        processing: true,
        serverSide: true,
        retrieve: true,
        destroy: true,
        order: [],
        ajax: 
        {
            url: BASE_URL + "Dashboard/GetAllPatientViaAgeCategoryParameter",
            type: "POST",
            data: 
            {
                agecateg: category,
                fulldate: fulldate,
                pxtypex: pxtype
            }
        },
        createdRow: function (row, data, dataIndex)
        {
            $('td', row).eq(0).html(dataIndex+1);
        },
        initComplete: function (settings, json)
        {

        }
    });
}

function getAllInPatientAllSexxCategAndAddItToTheTable(category, fulldate, pxtype)
{
    sexcateg_table = $('#sexcateg-patient-table').DataTable();
    sexcateg_table.clear().destroy();
    
    sexcateg_table = $('#sexcateg-patient-table').DataTable
    ({
        responsive: true,
        processing: true,
        serverSide: true,
        retrieve: true,
        destroy: true,
        order: [],
        ajax: 
        {
            url: BASE_URL + "Dashboard/GetAllPatientViaSexCategoryParameter",
            type: "POST",
            data: 
            {
                sexcateg: category,
                fulldate: fulldate,
                pxtypex: pxtype
            }
        },
        createdRow: function (row, data, dataIndex)
        {
            $('td', row).eq(0).html(dataIndex+1);
        },
        initComplete: function (settings, json)
        {

        }
    });
}

function generatePatientListingAgeCategoryParameter()
{
    var datereqs = $("#daterequestagecateparam").val();
    var category = $("#agecategoryagecateparam").val();
    var pxtypexx = $("#patienttypeagecateparam").val();
    
    $('#generate-patient-listing-viaagecate-data-sheet-form input[name=hiddenname_agecatename]').val(category);
    $('#generate-patient-listing-viaagecate-data-sheet-form input[name=hiddenname_patienttype]').val(pxtypexx);
    $('#generate-patient-listing-viaagecate-data-sheet-form input[name=hiddenname_daterequest]').val(datereqs);
    $("#generate-patient-listing-viaagecate-data-sheet-form").submit();
}

function generatePatientListingSexCategoryParameter()
{
    var datereqs = $("#daterequestsexcateparam").val();
    var category = $("#sexcategorysexcateparam").val();
    var pxtypexx = $("#patienttypesexcateparam").val();
    
    $('#generate-patient-listing-viasexcate-data-sheet-form input[name=hiddenname_sexcateindi]').val(category);
    $('#generate-patient-listing-viasexcate-data-sheet-form input[name=hiddenname_patienttype]').val(pxtypexx);
    $('#generate-patient-listing-viasexcate-data-sheet-form input[name=hiddenname_daterequest]').val(datereqs);
    $("#generate-patient-listing-viasexcate-data-sheet-form").submit();
}

function generatePatientListingMunicipalityParameter()
{
    var citynamesstring = $('#othersnamescitymunparam').val();
    
    var datereqs = $("#daterequestcitymunparam").val();
    var cityname = $("#citymunnamecitymunparam").val();
    var pxtypexx = $("#patienttypecitymunparam").val();
    
    if(cityname === "OTHERS")
    {
        $('#generate-patient-listing-viacitymun-data-sheet-form input[name=hiddenname_citymunname]').val(citynamesstring);
    }
    else
    {
        $('#generate-patient-listing-viacitymun-data-sheet-form input[name=hiddenname_citymunname]').val(cityname);
    }
    
    
    $('#generate-patient-listing-viacitymun-data-sheet-form input[name=hiddenname_indicaother]').val(cityname);
    $('#generate-patient-listing-viacitymun-data-sheet-form input[name=hiddenname_patienttype]').val(pxtypexx);
    $('#generate-patient-listing-viacitymun-data-sheet-form input[name=hiddenname_daterequest]').val(datereqs);
    $("#generate-patient-listing-viacitymun-data-sheet-form").submit();
}

function generatePatientListingProvinceParameter()
{
    var provnamesstring = $('#othersnamesprovinceparam').val();
    
    var datereqs = $("#daterequestprovinceparam").val();
    var provname = $("#provinznameprovinceparam").val();
    var pxtypexx = $("#patienttypeprovinceparam").val();
    
    if(provname === "OTHERS")
    {
        $('#generate-patient-listing-viaprovince-data-sheet-form input[name=hiddenname_provinceaddname]').val(provnamesstring);
    }
    else
    {
        $('#generate-patient-listing-viaprovince-data-sheet-form input[name=hiddenname_provinceaddname]').val(provname);
    }
    
    $('#generate-patient-listing-viaprovince-data-sheet-form input[name=hiddenname_daterequestprov]').val(datereqs);
    $('#generate-patient-listing-viaprovince-data-sheet-form input[name=hiddenname_patienttypeprov]').val(pxtypexx);
    $('#generate-patient-listing-viaprovince-data-sheet-form input[name=hiddenname_indicaotherprov]').val(provname);
    $("#generate-patient-listing-viaprovince-data-sheet-form").submit();
}

function generatePatientListingInsuranceParameter()
{
    var hmonamesstring = $('#othersnamesinsuranceparam').val();
    
    var datereqs = $("#daterequestinsuranceparam").val();
    var hmoxname = $("#insurannameinsuranceparam").val();
    var pxtypexx = $("#patienttypeinsuranceparam").val();
    
    if(hmoxname === "OTHERS")
    {
        $('#generate-patient-listing-viainsurance-data-sheet-form input[name=hiddenname_insurancaddname]').val(hmonamesstring);
    }
    else
    {
        $('#generate-patient-listing-viainsurance-data-sheet-form input[name=hiddenname_insurancaddname]').val(hmoxname);
    }
    
    $('#generate-patient-listing-viainsurance-data-sheet-form input[name=hiddenname_daterequesthmox]').val(datereqs);
    $('#generate-patient-listing-viainsurance-data-sheet-form input[name=hiddenname_patienttypehmox]').val(pxtypexx);
    $('#generate-patient-listing-viainsurance-data-sheet-form input[name=hiddenname_indicaotherhmox]').val(hmoxname);
    $("#generate-patient-listing-viainsurance-data-sheet-form").submit();
}

function generatePatientListingRoomrateParameter()
{
    var roomnamesstring = $('#othersnamesroomrateparam').val();
    
    var datereqs = $("#daterequestroomrateparam").val();
    var roomname = $("#roomratnameroomrateparam").val();
    var pxtypexx = $("#patienttyperoomrateparam").val();
    
    if(roomname === "OTHERS")
    {
        $('#generate-patient-listing-viaroomrate-data-sheet-form input[name=hiddenname_roomrateaddname]').val(roomnamesstring);
    }
    else
    {
        $('#generate-patient-listing-viaroomrate-data-sheet-form input[name=hiddenname_roomrateaddname]').val(roomname);
    }
    
    $('#generate-patient-listing-viaroomrate-data-sheet-form input[name=hiddenname_daterequestroom]').val(datereqs);
    $('#generate-patient-listing-viaroomrate-data-sheet-form input[name=hiddenname_patienttyperoom]').val(pxtypexx);
    $('#generate-patient-listing-viaroomrate-data-sheet-form input[name=hiddenname_indicaotherroom]').val(roomname);
    $("#generate-patient-listing-viaroomrate-data-sheet-form").submit();
}

function generateAllCRMResultsIntoPDF()
{
    var month = moment(SelectedMonthYear).format("MMMM");
    var year = moment(SelectedMonthYear).format("YYYY");
    var selmonstring = month + " " + year;
    var selectpxtype = SelectedPxtypexxx;
    var genderstring = InpatientGenderCategory;
    var agexxxstring = InpatientAgexxxCategory;
    var citymustring = InpatientCityMuCategory;
    var provinstring = InpatientProvinCategory;
    var insurastring = InpatientInsuraCategory;
    var roomrtstring = InpatientRoomocCategory;
    var volreqstring = InpatientVolumeCategory;

    $('#generate-crm-data-sheet-form input[name=hiddenname_genderxparameter]').val(genderstring);
    $('#generate-crm-data-sheet-form input[name=hiddenname_agexxxxparameter]').val(agexxxstring);
    $('#generate-crm-data-sheet-form input[name=hiddenname_cityaddparameter]').val(citymustring);
    $('#generate-crm-data-sheet-form input[name=hiddenname_provaddparameter]').val(provinstring);
    $('#generate-crm-data-sheet-form input[name=hiddenname_insuranparameter]').val(insurastring);
    $('#generate-crm-data-sheet-form input[name=hiddenname_roomoccparameter]').val(roomrtstring);
    $('#generate-crm-data-sheet-form input[name=hiddenname_volreqxparameter]').val(volreqstring);
    $('#generate-crm-data-sheet-form input[name=hiddenname_selectedmonthxxx]').val(selmonstring);
    $('#generate-crm-data-sheet-form input[name=hiddenname_selectedpxtypexx]').val(selectpxtype);
    $("#generate-crm-data-sheet-form").submit();
}

function removeIndex(arr)
{
    var what, a= arguments, L= a.length, ax;
    while(L> 1 && arr.length)
    {
        what= a[--L];
        while((ax= arr.indexOf(what))!== -1)
        {
            arr.splice(ax, 1);
        }
    }
    return arr;
}
