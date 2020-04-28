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

    // alert(auth);
    const config = {
        method: 'post',
        url: URL_PATH + '/c_inputs',
        headers: { 'Authorization': 'Bearer ' + token },
        data: {
            "inputs": inputs
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