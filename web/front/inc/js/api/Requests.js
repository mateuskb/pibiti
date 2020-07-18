// var constants = require('./consts');

// const axios = require('axios');

// GET w/ HEADERS
async function Login() {
  // alert("Cheguei");
  const config = {
      method: 'get',
      url: URL_PATH + '/login',
      headers: { 'Authorization': 'Basic dGVzdGU6dGVzdGU=' }
  }

  let resp = await axios(config)

  console.log(res.data);
  alert(resp.data);
  return resp;
}

async function Permission() {
    const config = {
        method: 'get',
        url: URL_PATH + '/permission',
    }
    try {
        var resp = await axios(config);
        
        return resp;

    }catch(error){
        // Error 😨
        if (error.response) {
            /*
            * The request was made and the server responded with a
            * status code that falls out of the range of 2xx
            */
            return error.response;
        } else if (error.request) {
            /*
            * The request was made but no response was received, `error.request`
            * is an instance of XMLHttpRequest in the browser and an instance
            * of http.ClientRequest in Node.js
            */
            return error.request;
        } else {
            // Something happened in setting up the request and triggered an Error
            return 'Error'+ error.message;
        }

    }
}

async function Login(username, password) {

    let auth = btoa(username+":"+password);
    // alert(auth);
    
    const config = {
        method: 'get',
        url: URL_PATH + '/login',
        headers: { 'Authorization': 'Basic ' + auth }
    }
    
    try {
        var resp = await axios(config);
        
        return resp;

    }catch(error){
        // Error 😨
        if (error.response) {
            /*
            * The request was made and the server responded with a
            * status code that falls out of the range of 2xx
            */
            return error.response;
        } else if (error.request) {
            /*
            * The request was made but no response was received, `error.request`
            * is an instance of XMLHttpRequest in the browser and an instance
            * of http.ClientRequest in Node.js
            */
            return error.request;
        } else {
            // Something happened in setting up the request and triggered an Error
            return 'Error'+ error.message;
        }

    }
}

async function Verify(token) {

    // alert(auth);
    const config = {
        method: 'get',
        url: URL_PATH + '/verify',
        headers: { 'Authorization': 'Bearer ' + token }
    }
    
    try {
        var resp = await axios(config);
        
        return resp;

    }catch(error){
        // Error 😨
        if (error.response) {
            /*
            * The request was made and the server responded with a
            * status code that falls out of the range of 2xx
            */
            return error.response;
        } else if (error.request) {
            /*
            * The request was made but no response was received, `error.request`
            * is an instance of XMLHttpRequest in the browser and an instance
            * of http.ClientRequest in Node.js
            */
            return error.request;
        } else {
            // Something happened in setting up the request and triggered an Error
            return 'Error'+ error.message;
        }

    }
}

async function Logout(token) {

    // alert(auth);
    const config = {
        method: 'get',
        url: URL_PATH + '/logout',
        headers: { 'Authorization': 'Bearer ' + token }
    }
    
    try {
        var resp = await axios(config);
        
        return resp;

    }catch(error){
        // Error 😨
        if (error.response) {
            /*
            * The request was made and the server responded with a
            * status code that falls out of the range of 2xx
            */
            return error.response;
        } else if (error.request) {
            /*
            * The request was made but no response was received, `error.request`
            * is an instance of XMLHttpRequest in the browser and an instance
            * of http.ClientRequest in Node.js
            */
            return error.request;
        } else {
            // Something happened in setting up the request and triggered an Error
            return 'Error'+ error.message;
        }

    }
}

async function Getinputs(token) {

    // alert(auth);
    const config = {
        method: 'get',
        url: URL_PATH + '/getInputs',
        headers: { 'Authorization': 'Bearer ' + token }
    }
    
    try {
        var resp = await axios(config);
        
        return resp;

    }catch(error){
        // Error 😨
        if (error.response) {
            /*
            * The request was made and the server responded with a
            * status code that falls out of the range of 2xx
            */
            return error.response;
        } else if (error.request) {
            /*
            * The request was made but no response was received, `error.request`
            * is an instance of XMLHttpRequest in the browser and an instance
            * of http.ClientRequest in Node.js
            */
            return error.request;
        } else {
            // Something happened in setting up the request and triggered an Error
            return 'Error'+ error.message;
        }

    }
}

async function C_inputs(token, inputs) {
    console.log(inputs);
    // alert(auth);
    const config = {
        method: 'post',
        url: URL_PATH + '/c_inputs',
        headers: { 'Authorization': 'Bearer ' + token },
        data: {
            "inputs": {
                "inp_b_rele1": inputs["inp_b_rele1"],
                "inp_b_rele2": inputs["inp_b_rele2"],
                "inp_b_rele3": inputs["inp_b_rele3"],
                "inp_b_rele4": inputs["inp_b_rele4"],
                "inp_b_rele5": inputs["inp_b_rele5"],
                "inp_b_rele6": inputs["inp_b_rele6"],
                "inp_b_rele7": inputs["inp_b_rele7"],
                "inp_b_rele8": inputs["inp_b_rele8"],
                "inp_b_rele9": inputs["inp_b_rele9"],
                "inp_b_rele10": inputs["inp_b_rele10"],
                "inp_b_rele11": inputs["inp_b_rele11"],
                "inp_b_rele12": inputs["inp_b_rele12"],
                "inp_b_rele13": inputs["inp_b_rele13"],
                "inp_i_fonte": inputs["inp_i_fonte"]
            }
        }

    }
    
    try {
        var resp = await axios(config);
        
        return resp;

    }catch(error){
        // Error 😨
        if (error.response) {
            /*
            * The request was made and the server responded with a
            * status code that falls out of the range of 2xx
            */
            return error.response;
        } else if (error.request) {
            /*
            * The request was made but no response was received, `error.request`
            * is an instance of XMLHttpRequest in the browser and an instance
            * of http.ClientRequest in Node.js
            */
            return error.request;
        } else {
            // Something happened in setting up the request and triggered an Error
            return 'Error'+ error.message;
        }

    }
}

// makeRequest();

// GET
/*
async function makeGetRequest() {
  
  let res = await axios.get(constants.URL_PATH + '/');
 
  let data = res.data;
  console.log(data);
}

makeGetRequest();


// POST
async function makePostRequest() {

    params = {
        id: 6,
        first_name: 'Fred',
        last_name: 'Blair',
        email: 'freddyb34@gmail.com'
      }

    let res = await axios.post('http://localhost:3000/users/', params);

    console.log(res.data);
}

makePostRequest();
*/