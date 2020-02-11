var constants = require('./consts');

const axios = require('axios');

// GET
async function makeGetRequest() {
  
  let res = await axios.get(constants.URL_PATH + '/');

  let data = res.data;
  console.log(data);
}

makeGetRequest();
/*
// GET w/ HEADERS
async function makeRequest() {

    const config = {
        method: 'get',
        url: 'http://localhost:8080/hello/teste',
        headers: { 'User-Agent': 'Console app' }
    }

    let res = await axios(config)

    console.log(res.request._header);
}

makeRequest();

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