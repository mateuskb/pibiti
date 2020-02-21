$(document).ready(function () {
    var resp;
    
    $.getScript( "./inc/js/api/Requests.js" )
        .done(function( script, textStatus ) {
            
            Permission().then(function(response){
                resp = response;
                data = resp.data
                if(data.ok){
                    if(data.data){
                        $(".not_allowed").css("display", "none")
                    }else{
                        $(".allowed").css("display", "none")
                    };
                }else{
                    alert("Erro em comunicação com o servidor!");
                    $(".allowed").css("display", "none")
                };
                //console.log(resp);
                //alert(resp);

            }).catch((error)=>{
                //console.log(error);
                alert("Erro em comunicação com o servidor!");
                $(".allowed").css("display", "none");   

            });
            
            // alert( textStatus );
        })
        .fail(function( jqxhr, settings, exception ) {
            alert( "Error: " +exception );
            $(".allowed").css("display", "none")
        });
    

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
            $.getScript( "./inc/js/api/Requests.js" )
            .done(function( script, textStatus ) {
                
                Login().then(function(response){
                    resp = response;
                    data = resp.data
                    if(data.ok){
                        if(data.data){
                            console.log(data.data);
                            alert(data.data);
                        }else{
                            console.log(data.data);
                            alert(data.data);
                        };
                    }else{
                        alert("Erro em comunicação com o servidor!");
                    };
                    //console.log(resp);
                    //alert(resp);
    
                }).catch((error)=>{
                    //console.log(error);
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