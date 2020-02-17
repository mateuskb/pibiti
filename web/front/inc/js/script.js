var online = '';
var path = '../../../back/login.php';

function sleep(ms) {
    return new Promise(resolve => setTimeout(resolve, ms));
}

$(document).ready(function () {

    $("#submit").click(function () {

        var login = $("#login").val();
        var password = $("#password").val();
        var resp;
        // Checking for blank fields.

        if (login == '' || password == '') {

            $('input[type="text"],input[type="password"]').css("border", "2px solid red");
            $('input[type="text"],input[type="password"]').css("box-shadow", "0 0 3px red");
            alert("Preencha os campos!!!");

        } else {
            $.getScript('/api/Requests.js', function () {          
                makeRequest();  
            });
            // resp = makeRequest();  
            // alert(resp);         
            // console.log(resp);         
        }
    });
});