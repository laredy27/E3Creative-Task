/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(function(){
    
    //Retrieve the Birthday list from storage
    if( localStorage.birthdays ){
        var birthdays = JSON.parse(localStorage.birthdays);
        loadBirthdays( birthdays );
    }
    
    // Months
    var months = [ 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec' ];
    var monthSelect = $("select[data-select='months']");
    $.each(months, (key, month) => {
        var option = $("<option>"+ month +"</option>").attr("value", key+1);
        monthSelect.append(option);
    });
    
    // Year
    var now = new Date();
    var yearSelect = $("select[data-select='year']");
    var validYears = [now.getFullYear() -1, now.getFullYear()] ;
    $.each(validYears, (key, year) => {
        var option = $("<option>"+ year +"</option>").attr("value", year);
        yearSelect.append(option);
    });
    
    // Currency
    var currencies = ["EUR", "GBP", "USD", "NGN"];
    var currencySelect = $("select[data-select='currency']");
     $.each(currencies, (key, currency) => {
        var option = $("<option>"+ currency +"</option>").attr("value", currency);
        currencySelect.append(option);
    });
    
    //Get rates from the Fixer JS Api
    function getRates( date, callback ){
        var url = "http://data.fixer.io/api/" + date;
        var key = "e7653bf55ca8eaf257d57861f747dc44";
        var base_currency = $("#base_currency").val();
        $.getJSON(url, {access_key: key, base: base_currency, symbols: currencies.join(",")}, (res) => {
            console.log(res);
            callback(res);
        }).fail(function(){
            $("#rates-error").text('Fixer io API is down.');
        });
    }
    
    // Submit Birthday Form
    $("#birthday-form").submit(function(e){
        e.preventDefault();
        //JS Validation]
        var day = $("input#day").val();
        var month = monthSelect.val(); 
        var year = yearSelect.val();
        var birthday = new Date(year, month - 1, day); //Javascript counts month from 0-11
        if( birthday > now ){
            $("#form-info.alert").addClass("alert-danger").text("You cannot add a birthday you have not had yet");
            return;
        }
        else{
            $("#form-info.alert").removeClass("alert-danger").text("");
        }
        var data = $(this).serialize();
        
        $.post( "./ajax.php", data,(response) => {
            var res = JSON.parse( response );
            console.log( res );
            if( res.success == true ){
                loadBirthdays(res.data);
                //Cache the result in localstorage
                localStorage.birthdays = JSON.stringify(res.data);
                $(this)[0].reset();
                $("#form-info.alert").addClass("alert-success").text("Birthday entry successfully added.");
                return;
            }else{
                var error = "";
                switch( res.error.code ){
                    case 401:
                        error = "You have not provided your database credentials.";
                        break;
                    default:
                        error = "An error occured while adding your birthday entry into the database.";
                        break;     
                }
                $("#form-info.alert").addClass("alert-danger").text(error);
            }  
        });
        
    });
    
    $("#birthdayTable").on("click", "tr", function(){
        $(this).siblings().removeClass("table-active");
        $(this).addClass("table-active");
        
        var birthday = $(this).data("birthday");
        
        getRates( birthday, function( res ){
            $("#rates-info").text('');
            $("#rates-error").text('');
            var rateTemplate = $("#ratesTable > tbody").empty();
            if( res.success == true ){
                $("#ratesTable > caption").empty();
                 // Clear the rates table
                $.each( res.rates, (key, value) => {
                    var rateRow = $("<tr></tr>");
                    rateRow.append("<td>"+ key +"</td>"); // Currency code
                    rateRow.append("<td>"+ value +"</td>"); // Currency value

                    rateTemplate.append( rateRow ); //Insert the row into the table
                } );
            }
            else{
                var error;
                switch( res.error.code ){
                    case 105:
                        error = "Only EUR can be used as a base currency in this free version of Fixer.";
                        break;
                    default:
                        error = res.error.info;
                        break;
                }
                $("#rates-error").text(error);
            }
        } ); 
    });
    
    
    function loadBirthdays( data ){
        var birthdayTemplate = $("#birthdayTable > tbody").empty();
        $.each( data, (key, value) => {
            var row = $("<tr></tr>").attr('data-birthday', value['birthday_date']);
            row.append("<td>"+ ++key +"</td>");
            row.append("<td>"+ value['formatted_date'] +"</td>");
            row.append("<td>"+ value['count'] +"</td>");

            birthdayTemplate.append(row);
        } );
    }
    
    function alertify( container, type, content ){
        
    }
    
});
