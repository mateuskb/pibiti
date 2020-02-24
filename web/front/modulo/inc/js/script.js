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

    /*------RANGE------*/
    var slider = document.getElementById("myRange");
    var output = document.getElementById("demo");

    slider.oninput = function() {
        output.innerHTML = this.value;
    }


    try {
        var token = localStorage.getItem('pibiti_token');

        /* ------ VERIFY TOKEN ------ */
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

