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

function copyArray(array){
    var newArray = [];
    for (var key in array){
        newArray[key] = array[key].slice();
    }
    return newArray;
}

async function c_inputs(inputs){
    r = false;
    loadInputs(inputs);

    try {

        var token = localStorage.getItem('pibiti_token');

        /* ------ VERIFY TOKEN ------ */
        $.getScript( "../inc/js/api/Requests.js" )
        .done(function( script, textStatus ) {
            
            // console.log(inputs);

            C_inputs(token, inputs).then(function(resp){
                data = resp.data;
                // console.log(data);

                if(data.ok){
                    r = true;
                } else {
                    console.log(data.errors);
                    for (let key in data.errors){
                        if(key == 'inputs'){
                            for (let key2 in data.errors[key]){
                                error = data.errors[key][key2];
                            }
                        } else {
                            error = data.errors[key];
                        }
                        alert(error)
                    }
                    r = false;
                }
                getinputs();


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
        return r ;


    }
    catch (e) {
        return false
    }
}

async function verify(){
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
                    inputs = copyArray(data);
                    loadInputs(inputs);
                } else {
                    for (let key in data.errors){
                        error = data.errors[key];
                        // alert(error);
                        // console.log(error);
                    }
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

async function verifyInputs(inputs){
    resp = true;

    if(inputs['inp_b_rele1'] == "1"){
        resp = false
    } 

    if(!resp) {
        alert("Configuração poderia causar danos ao módulo!");
    }
    return resp;

}

async function loadInputs(inputs){
    for (let key in inputs) {

        // console.log('Key: ', key);
        // console.log('Value: ', inputs[key]);

        if ( key == 'inp_i_fonte'){
            $("#inp_i_fonte").val(inputs[key]);
            var output = document.getElementById("fonte_out");
            output.innerHTML = inputs[key];
        }else{
            (inputs[key]==1) ? $("#"+key).prop("checked", true ): $("#"+key).prop("checked", false );
        }
    } 
}

// *****************************************************************


$(document).ready(function () {
    var resp;
    
    /*------RANGE------*/

    
    verify();
    
    getinputs();
    
    
    /* UPDATE INPUTS */
    $('#inp_i_fonte').change(function() {
        var output = document.getElementById("fonte_out");
        output.innerHTML = this.value;
        verify().then((resp)=>{
            if (resp) {
                last_inputs = copyArray(inputs);
                inputs['inp_i_fonte'] = this.value;
                verifyInputs(inputs).then((resp)=>{
                    if(resp){
                        c_inputs(inputs).then((resp)=>{
                            if (!resp) {
                                inputs = copyArray(last_inputs);
                            }
                            
                        })
                    } else {
                        inputs = copyArray(last_inputs);
                        loadInputs(inputs);
                    }
                })
            }
        })
    });

    $('#inp_b_rele1[type=checkbox]').change(
        function(){
            verify().then((resp)=>{
                if (resp) {
                    last_inputs = copyArray(inputs);
                    if (this.checked) {
                        inputs['inp_b_rele1'] = "1";
                    } else {
                        inputs['inp_b_rele1'] = "0";
                    }
                    verifyInputs(inputs).then((resp)=>{
                        if(resp){
                            c_inputs(inputs).then((resp)=>{
                                if (!resp) {
                                    inputs = copyArray(last_inputs);
                                }
                            })
                        } else {
                            inputs = copyArray(last_inputs);
                            loadInputs(inputs);
                        }
                    })
                }
            });
        }
    );
    $('#inp_b_rele2[type=checkbox]').change(
        function(){
            verify().then((resp)=>{
                if (resp) {
                    last_inputs = copyArray(inputs);
                    if (this.checked) {
                        inputs['inp_b_rele2'] = "1";
                    } else {
                        inputs['inp_b_rele2'] = "0";
                    }
                    verifyInputs(inputs).then((resp)=>{
                        if(resp){
                            c_inputs(inputs).then((resp)=>{
                                if (!resp) {
                                    inputs = copyArray(last_inputs);
                                }
                            })
                        } else {
                            inputs = copyArray(last_inputs);
                            loadInputs(inputs);
                        }
                    })
                }
            })
        }
    );
    $('#inp_b_rele3[type=checkbox]').change(
        function(){
            verify().then((resp)=>{
                if (resp) {
                    last_inputs = copyArray(inputs);
                    if (this.checked) {
                        inputs['inp_b_rele3'] = "1";
                    } else {
                        inputs['inp_b_rele3'] = "0";
                    }
                    verifyInputs(inputs).then((resp)=>{
                        if(resp){
                            c_inputs(inputs).then((resp)=>{
                                if (!resp) {
                                    inputs = copyArray(last_inputs);
                                }
                            })
                        } else {
                            inputs = copyArray(last_inputs);
                            loadInputs(inputs);
                        }
                    })
                }
            })
        }
    );
    $('#inp_b_rele4[type=checkbox]').change(
        function(){
            verify().then((resp)=>{
                if (resp) {
                    last_inputs = copyArray(inputs);
                    if (this.checked) {
                        inputs['inp_b_rele4'] = "1";
                    } else {
                        inputs['inp_b_rele4'] = "0";
                    }
                    verifyInputs(inputs).then((resp)=>{
                        if(resp){
                            c_inputs(inputs).then((resp)=>{
                                if (!resp) {
                                    inputs = copyArray(last_inputs);
                                }
                            })
                        } else {
                            inputs = copyArray(last_inputs);
                            loadInputs(inputs);
                        }
                    })
                }
            })
        }
    );
    $('#inp_b_rele5[type=checkbox]').change(
        function(){
            verify().then((resp)=>{
                if (resp) {
                    last_inputs = copyArray(inputs);
                    if (this.checked) {
                        inputs['inp_b_rele5'] = "1";
                    } else {
                        inputs['inp_b_rele5'] = "0";
                    }
                    verifyInputs(inputs).then((resp)=>{
                        if(resp){
                            c_inputs(inputs).then((resp)=>{
                                if (!resp) {
                                    inputs = copyArray(last_inputs);
                                }
                            })
                        } else {
                            inputs = copyArray(last_inputs);
                            loadInputs(inputs);
                        }
                    })
                }
            })
        }
    );
    $('#inp_b_rele6[type=checkbox]').change(
        function(){
            verify().then((resp)=>{
                if (resp) {
                    last_inputs = copyArray(inputs);
                    if (this.checked) {
                        inputs['inp_b_rele6'] = "1";
                    } else {
                        inputs['inp_b_rele6'] = "0";
                    }
                    verifyInputs(inputs).then((resp)=>{
                        if(resp){
                            c_inputs(inputs).then((resp)=>{
                                if (!resp) {
                                    inputs = copyArray(last_inputs);
                                }
                            })
                        } else {
                            inputs = copyArray(last_inputs);
                            loadInputs(inputs);
                        }
                    })
                }
            })
        }
    );
    $('#inp_b_rele7[type=checkbox]').change(
        function(){
            verify().then((resp)=>{
                if (resp) {
                    last_inputs = copyArray(inputs);
                    if (this.checked) {
                        inputs['inp_b_rele7'] = "1";
                    } else {
                        inputs['inp_b_rele7'] = "0";
                    }
                    verifyInputs(inputs).then((resp)=>{
                        if(resp){
                            c_inputs(inputs).then((resp)=>{
                                if (!resp) {
                                    inputs = copyArray(last_inputs);
                                }
                            })
                        } else {
                            inputs = copyArray(last_inputs);
                            loadInputs(inputs);
                        }
                    })
                }
            })
        }
    );
    $('#inp_b_rele8[type=checkbox]').change(
        function(){
            verify().then((resp)=>{
                if (resp) {
                    last_inputs = copyArray(inputs);
                    if (this.checked) {
                        inputs['inp_b_rele8'] = "1";
                    } else {
                        inputs['inp_b_rele8'] = "0";
                    }
                    verifyInputs(inputs).then((resp)=>{
                        if(resp){
                            c_inputs(inputs).then((resp)=>{
                                if (!resp) {
                                    inputs = copyArray(last_inputs);
                                }
                            })
                        } else {
                            inputs = copyArray(last_inputs);
                            loadInputs(inputs);
                        }
                    })
                }
            })
        }
    );
    $('#inp_b_rele9[type=checkbox]').change(
        function(){
            verify().then((resp)=>{
                if (resp) {
                    last_inputs = copyArray(inputs);
                    if (this.checked) {
                        inputs['inp_b_rele9'] = "1";
                    } else {
                        inputs['inp_b_rele9'] = "0";
                    }
                    verifyInputs(inputs).then((resp)=>{
                        if(resp){
                            c_inputs(inputs).then((resp)=>{
                                if (!resp) {
                                    inputs = copyArray(last_inputs);
                                }
                            })
                        } else {
                            inputs = copyArray(last_inputs);
                            loadInputs(inputs);
                        }
                    })
                }
            })
        }
    );
    $('#inp_b_rele10[type=checkbox]').change(
        function(){
            verify().then((resp)=>{
                if (resp) {
                    last_inputs = copyArray(inputs);
                    if (this.checked) {
                        inputs['inp_b_rele10'] = "1";
                    } else {
                        inputs['inp_b_rele10'] = "0";
                    }
                    verifyInputs(inputs).then((resp)=>{
                        if(resp){
                            c_inputs(inputs).then((resp)=>{
                                if (!resp) {
                                    inputs = copyArray(last_inputs);
                                }
                            })
                        } else {
                            inputs = copyArray(last_inputs);
                            loadInputs(inputs);
                        }
                    })
                }
            })
        }
    );
    $('#inp_b_rele11[type=checkbox]').change(
        function(){
            verify().then((resp)=>{
                if (resp) {
                    last_inputs = copyArray(inputs);
                    if (this.checked) {
                        inputs['inp_b_rele11'] = "1";
                    } else {
                        inputs['inp_b_rele11'] = "0";
                    }
                    verifyInputs(inputs).then((resp)=>{
                        if(resp){
                            c_inputs(inputs).then((resp)=>{
                                if (!resp) {
                                    inputs = copyArray(last_inputs);
                                }
                            })
                        } else {
                            inputs = copyArray(last_inputs);
                            loadInputs(inputs);
                        }
                    })
                }
            })
        }
    );
    $('#inp_b_rele12[type=checkbox]').change(
        function(){
            verify().then((resp)=>{
                if (resp) {
                    last_inputs = copyArray(inputs);
                    if (this.checked) {
                        inputs['inp_b_rele12'] = "1";
                    } else {
                        inputs['inp_b_rele12'] = "0";
                    }
                    verifyInputs(inputs).then((resp)=>{
                        if(resp){
                            c_inputs(inputs).then((resp)=>{
                                if (!resp) {
                                    inputs = copyArray(last_inputs);
                                }
                            })
                        } else {
                            inputs = copyArray(last_inputs);
                            loadInputs(inputs);
                        }
                    })
                }
            })
        }
    );
    $('#inp_b_rele13[type=checkbox]').change(
        function(){
            verify().then((resp)=>{
                if (resp) {
                    last_inputs = copyArray(inputs);
                    if (this.checked) {
                        inputs['inp_b_rele13'] = "1";
                    } else {
                        inputs['inp_b_rele13'] = "0";
                    }
                    verifyInputs(inputs).then((resp)=>{
                        if(resp){
                            c_inputs(inputs).then((resp)=>{
                                if (!resp) {
                                    inputs = copyArray(last_inputs);
                                }
                            })
                        } else {
                            inputs = copyArray(last_inputs);
                            loadInputs(inputs);
                        }
                    })
                }
            })
        }
    );
});

