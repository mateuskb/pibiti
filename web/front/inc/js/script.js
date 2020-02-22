async function success_login(data) {
    localStorage.setItem('pibiti_token', data.data);
};

$(document).ready(function () {
    var resp;
    try {
        var token = localStorage.getItem('pibiti_token');

        $.getScript( "./inc/js/api/Requests.js" )
        .done(function( script, textStatus ) {
            
            Verify(token).then(function(response){
                resp = response;
                data = resp.data;
                if(data.ok){
                    if(data.data){
                        window.location.href = "./modulo/";                        
                    }
                }
            }).catch((error)=>{
                //console.log(error);
                alert("Erro em comunicação com o servidor!");

            });
            
            // alert( textStatus );
        })
        .fail(function( jqxhr, settings, exception ) {
            alert( "Error: " +exception );
        });
    }
    catch (e) {
        console.log(e);
    }
    $.getScript( "./inc/js/api/Requests.js" )
        .done(function( script, textStatus ) {
            
            Permission().then(function(response){
                resp = response;
                data = resp.data;
                console.log(data);
                if(data.ok){
                    if(data.data){
                        $(".not_allowed").css("display", "none");
                    }else{
                        $(".allowed").css("display", "none");
                    };
                }else{
                    $(".allowed").css("display", "none");
                    alert("Erro em comunicação com o servidor!");
                };
                //console.log(resp);
                //alert(resp);

            }).catch((error)=>{
                //console.log(error);
                $(".allowed").css("display", "none");   
                alert("Erro em comunicação com o servidor!");

            });
            
            // alert( textStatus );
        })
        .fail(function( jqxhr, settings, exception ) {
            $(".allowed").css("display", "none")
            alert( "Error: " +exception );
        });
    

    $("#submit").click(function (e) {
        e.preventDefault();
        var login = $("#login").val();
        var password = $("#password").val();
        var resp;
        // Checking for blank fields.

        if (login == '' || password == '') {
            $('.input').css("border", "2px solid red");
            alert("Preencha os campos!!!");

        } else {
            $.getScript( "./inc/js/api/Requests.js" )
            .done(function( script, textStatus ) {
                
                Login(login, password).then(function(response){
                    resp = response;
                    data = resp.data
                    if(data.ok){
                        if(data.data){
                            success_login(data).then(function(response){
                                //window.location.reload();
                                window.location.href = "./modulo/";
                            });
                        }else{
                            console.log(data.data);
                            alert(data.data);
                        };
                    }else{
                        $('.second ,.third').css("border", "2px solid red");
                    };
                    //console.log(resp);
                    //alert(resp);
    
                }).catch((error)=>{
                    console.log(error);
                    alert("Erro em comunicação com o servidor!");
    
                });
                
                // alert( textStatus );
            })
            .fail(function( jqxhr, settings, exception ) {
                alert( "Error: " +exception );
            });
            // resp = makeRequest();  
            // alert(resp);         
            // console.log(resp);         
        }
    });
});