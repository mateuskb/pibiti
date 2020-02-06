var online = '';
var path = '../../../back/login.php';
$(document).ready(function(){
    $("#submit").click(function(){
        var login = $("#login").val();
        var password = $("#password").val();
        // Checking for blank fields.
        if( login =='' || password ==''){
            $('input[type="text"],input[type="password"]').css("border","2px solid red");
            $('input[type="text"],input[type="password"]').css("box-shadow","0 0 3px red");
            alert("Preencha os campos!!!");
        }else {
            $.post(online+path,{ login1: login, password1:password},
            function(data) {
                if(data=='Invalid login.......') {
                    $('input[type="text"]').css({"border":"2px solid red","box-shadow":"0 0 3px red"});
                    $('input[type="password"]').css({"border":"2px solid #00F5FF","box-shadow":"0 0 5px #00F5FF"});
                    alert(data);
                }else if(data=='Login or Password is wrong...!!!!'){
                    $('input[type="text"],input[type="password"]').css({"border":"2px solid red","box-shadow":"0 0 3px red"});
                    alert(data);
                } else if(data=='Successfully Logged in...'){
                    $('input[type="text"],input[type="password"]').css({"border":"2px solid #00F5FF","box-shadow":"0 0 5px #00F5FF"});
                    alert(data);
                } else{
                    alert(data);
                }
            });
        }
    });
});