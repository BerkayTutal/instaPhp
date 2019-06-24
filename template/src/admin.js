/**
 * Created by berka on 6.03.2017.
 */
$(function () {
    $('.navbar-toggle-sidebar').click(function () {
        $('.navbar-nav').toggleClass('slide-in');
        $('.side-body').toggleClass('body-slide-in');
        $('#search').removeClass('in').addClass('collapse').slideUp(200);
    });

    $('#search-trigger').click(function () {
        $('.navbar-nav').removeClass('slide-in');
        $('.side-body').removeClass('body-slide-in');
        $('.search-input').focus();
    });
});

function validatePwdChgForm() {
    var newpw = document.forms["form-pwdchg"]["newPassword"].value;
    var newpw2 = document.forms["form-pwdchg"]["newPasswordAgain"].value;
    if (newpw==newpw2) {


        return true;
    }
    else
    {
        alert("Girdiğiniz iki şifre aynı değil!");
        return false;
    }
}

function toggleLoading(){
    $("#loading").toggle();

}


function getTableRows(tableID, onlySelected = false){
    var data = Array();
    $("#"+tableID+" tbody tr").each(function(i, v){
        data[i] = Array();
        $(this).children('td').each(function(ii, vv){
            if( $(this).children().length > 0 ){
                if($(this).children('input').attr('type') == "text" ){
                    data[i][ii] = $(this).children('input').val();
                }
                else if($(this).children('input').attr('type') == "checkbox" ){

                    data[i][ii] = $(this).children('input').prop( "checked" );

                }
            }
            else{
                data[i][ii] = $(this).text();
            }

        });
    });

    // alert(data);
    return data;
}

function sendData(where,data,action){
    var newData = [];

    var json = JSON.stringify(data);

    newData["data"] = json;
    newData["action"]=action;

    console.log(json);
    console.log(newData);
    //php kısmında $array=json_decode($_POST['jsondata']); yaparak kullanablirsin
    $.redirect(where,newData,"POST");
}
function sendDataThisPage(data,action){
    sendData(window.location.href,data,action);
}