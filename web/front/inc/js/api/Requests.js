// var constants = require('./consts');

// const axios = require('axios');

// GET w/ HEADERS
async function makeRequest() {
  // alert("Cheguei");
  const config = {
      method: 'get',
      url: URL_PATH + '/login',
      headers: { 'Authorization': 'Basic dGVzdGU6dGVzdGU=' }
  }

  let resp = await axios(config)

  console.log(res.data);
  alert(resp.data);
  return resp.data;
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