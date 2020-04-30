// Vars
var inputs = {
    "inp_b_rele1": "0",
    "inp_b_rele2": "0",
    "inp_b_rele3": "0",
    "inp_b_rele4": "0",
    "inp_b_rele5": "0",
    "inp_b_rele6": "0",
    "inp_b_rele7": "0",
    "inp_b_rele8": "0",
    "inp_b_rele9": "0",
    "inp_b_rele10": "0",
    "inp_b_rele11": "0",
    "inp_b_rele12": "0",
    "inp_b_rele13": "0",
    "inp_i_fonte": "0"
}


//**************************FUNCTIONS****************************

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

function c_inputs(inputs){
    r = false;
    try {

        var token = localStorage.getItem('pibiti_token');

        /* ------ VERIFY TOKEN ------ */
        $.getScript( "../inc/js/api/Requests.js" )
        .done(function( script, textStatus ) {
            C_inputs(token, inputs).then(function(response){
                resp = response;
                data = resp.data;
                console.log(data);
                if(data.ok){
                    r = true;
                }
            }).catch((error)=>{
                //console.log(error);
                alert("Erro em comunicação com o servidor!");
                r = false;
            });
            
            // alert( textStatus );
        })
        .fail(function( jqxhr, settings, exception ) {
            console.log( "Error: " + exception );
            r = false;
        });
        return true ;


    }
    catch (e) {
        console.log(e);
    }
}

function verify(){
    r = true;
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
                    r = false;
                }
            }).catch((error)=>{
                //console.log(error);
                alert("Erro em comunicação com o servidor!");
                localStorage.removeItem('pibiti_token');
                window.location.href = "./../";
                r = false;
            });
            
            // alert( textStatus );
        })
        .fail(function( jqxhr, settings, exception ) {
            console.log( "Error: " + exception );
            localStorage.removeItem('pibiti_token');
            window.location.href = "./../";
            r = false;
        });

    }
    catch (e) {
        console.log(e);
        r = false;
    }

    return r
}

function getinputs(){
    try{
        var token = localStorage.getItem('pibiti_token');

        $.getScript( "../inc/js/api/Requests.js" )
        .done(function( script, textStatus ) {
            
            Getinputs(token).then(function(response){
                resp = response;
                data = resp.data;

                if(data.ok){
                    data = data.data;
                    inputs['inp_b_rele1'] = data['inp_b_rele1'];
                    inputs['inp_b_rele2'] = data['inp_b_rele2'];
                    (inputs['inp_b_rele1']==1) ? $("#rele1").attr("checked", true ): $("#rele1").attr("checked", false );
                    (inputs['inp_b_rele2']==1) ? $("#rele2").attr("checked", true ): $("#rele2").attr("checked", false );
                
                }
            }).catch((error)=>{
                console.log(error);
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


// *****************************************************************


$(document).ready(function () {
    var resp;
    
    /*------RANGE------*/

    
    verify();
    
    
    getinputs();
    
    
    /* UPDATE INPUTS */
    $('#fonte').change(function() {
        var output = document.getElementById("fonte_out");
        output.innerHTML = this.value;
        resp = verify();
        if (resp) {
            last_inputs = inputs;
            inputs['inp_i_fonte'] = this.value;
            resp = c_inputs(inputs);
            
            if (!resp) {
                inputs = last_inputs;
            }
            
        }
    });

    $('#rele1[type=checkbox]').change(
        function(){
            resp = verify();
            if (resp) {
                last_inputs = inputs;
                if (this.checked) {
                    inputs['inp_b_rele1'] = "1";
                } else {
                    inputs['inp_b_rele1'] = "0";
                }
                resp = c_inputs(inputs);
                
                if (!resp) {
                    inputs = last_inputs;
                }
                
            }
            
        }
    );
    $('#rele2[type=checkbox]').change(
        function(){
            resp = verify();
            if (resp) {
                last_inputs = inputs;
                if (this.checked) {
                    inputs['inp_b_rele2'] = "1";
                } else {
                    inputs['inp_b_rele2'] = "0";
                }
                resp = c_inputs(inputs);
                
                if (!resp) {
                    inputs = last_inputs;
                }
                
            }
            
        }
    );
    $('#rele3[type=checkbox]').change(
        function(){
            resp = verify();
            if (resp) {
                last_inputs = inputs;
                if (this.checked) {
                    inputs['inp_b_rele3'] = "1";
                } else {
                    inputs['inp_b_rele3'] = "0";
                }
                resp = c_inputs(inputs);
                
                if (!resp) {
                    inputs = last_inputs;
                }
                
            }
            
        }
    );
    $('#rele4[type=checkbox]').change(
        function(){
            resp = verify();
            if (resp) {
                last_inputs = inputs;
                if (this.checked) {
                    inputs['inp_b_rele4'] = "1";
                } else {
                    inputs['inp_b_rele4'] = "0";
                }
                resp = c_inputs(inputs);
                
                if (!resp) {
                    inputs = last_inputs;
                }
                
            }
            
        }
    );
    $('#rele5[type=checkbox]').change(
        function(){
            resp = verify();
            if (resp) {
                last_inputs = inputs;
                if (this.checked) {
                    inputs['inp_b_rele5'] = "1";
                } else {
                    inputs['inp_b_rele5'] = "0";
                }
                resp = c_inputs(inputs);
                
                if (!resp) {
                    inputs = last_inputs;
                }
                
            }
            
        }
    );
    $('#rele6[type=checkbox]').change(
        function(){
            resp = verify();
            if (resp) {
                last_inputs = inputs;
                if (this.checked) {
                    inputs['inp_b_rele6'] = "1";
                } else {
                    inputs['inp_b_rele6'] = "0";
                }
                resp = c_inputs(inputs);
                
                if (!resp) {
                    inputs = last_inputs;
                }
                
            }
            
        }
    );
    $('#rele7[type=checkbox]').change(
        function(){
            resp = verify();
            if (resp) {
                last_inputs = inputs;
                if (this.checked) {
                    inputs['inp_b_rele7'] = "1";
                } else {
                    inputs['inp_b_rele7'] = "0";
                }
                resp = c_inputs(inputs);
                
                if (!resp) {
                    inputs = last_inputs;
                }
                
            }
            
        }
    );
    $('#rele8[type=checkbox]').change(
        function(){
            resp = verify();
            if (resp) {
                last_inputs = inputs;
                if (this.checked) {
                    inputs['inp_b_rele8'] = "1";
                } else {
                    inputs['inp_b_rele8'] = "0";
                }
                resp = c_inputs(inputs);
                
                if (!resp) {
                    inputs = last_inputs;
                }
                
            }
            
        }
    );
    $('#rele9[type=checkbox]').change(
        function(){
            resp = verify();
            if (resp) {
                last_inputs = inputs;
                if (this.checked) {
                    inputs['inp_b_rele9'] = "1";
                } else {
                    inputs['inp_b_rele9'] = "0";
                }
                resp = c_inputs(inputs);
                
                if (!resp) {
                    inputs = last_inputs;
                }
                
            }
            
        }
    );
    $('#rele10[type=checkbox]').change(
        function(){
            resp = verify();
            if (resp) {
                last_inputs = inputs;
                if (this.checked) {
                    inputs['inp_b_rele10'] = "1";
                } else {
                    inputs['inp_b_rele10'] = "0";
                }
                resp = c_inputs(inputs);
                
                if (!resp) {
                    inputs = last_inputs;
                }
                
            }
            
        }
    );
    $('#rele11[type=checkbox]').change(
        function(){
            resp = verify();
            if (resp) {
                last_inputs = inputs;
                if (this.checked) {
                    inputs['inp_b_rele11'] = "1";
                } else {
                    inputs['inp_b_rele11'] = "0";
                }
                resp = c_inputs(inputs);
                
                if (!resp) {
                    inputs = last_inputs;
                }
                
            }
            
        }
    );
    $('#rele12[type=checkbox]').change(
        function(){
            resp = verify();
            if (resp) {
                last_inputs = inputs;
                if (this.checked) {
                    inputs['inp_b_rele12'] = "1";
                } else {
                    inputs['inp_b_rele12'] = "0";
                }
                resp = c_inputs(inputs);
                
                if (!resp) {
                    inputs = last_inputs;
                }
                
            }
            
        }
    );
    $('#rele13[type=checkbox]').change(
        function(){
            resp = verify();
            if (resp) {
                last_inputs = inputs;
                if (this.checked) {
                    inputs['inp_b_rele13'] = "1";
                } else {
                    inputs['inp_b_rele13'] = "0";
                }
                resp = c_inputs(inputs);
                
                if (!resp) {
                    inputs = last_inputs;
                }
                
            }
            
        }
    );
});

