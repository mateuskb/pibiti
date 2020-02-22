function logout(){
    try{
        var token = localStorage.getItem('pibiti_token');

        $.getScript( "../inc/js/api/Requests.js" )
        .done(function( script, textStatus ) {
            
            Logout(token).then(function(response){
                resp = response;
                data = resp.data;
                if(data.ok & data.data){
                    localStorage.removeItem('pibiti_token');
                    window.location.href = "./../";
                }
            }).catch((error)=>{
                //console.log(error);
                alert("Erro em comunicação com o servidor!");
                
            });
            
            // alert( textStatus );
        })
        .fail(function( jqxhr, settings, exception ) {
            console.log( "Error: " + exception );
        });
    } catch (e) {
        console.log(e);
    }
}

$(document).ready(function () {
    var resp;
    try {
        var token = localStorage.getItem('pibiti_token');

        $.getScript( "../inc/js/api/Requests.js" )
        .done(function( script, textStatus ) {
            
            Verify(token).then(function(response){
                resp = response;
                data = resp.data;
                if(!data.ok){
                    localStorage.removeItem('pibiti_token');
                    window.location.href = "./../";
                }
            }).catch((error)=>{
                //console.log(error);
                alert("Erro em comunicação com o servidor!");

            });
            
            // alert( textStatus );
        })
        .fail(function( jqxhr, settings, exception ) {
            console.log( "Error: " + exception );
        });
    }
    catch (e) {
        console.log(e);
    }
});