const axios = require('axios');

axios
  .get('http://localhost:8080/api/resumes', {
    headers: {
      Authorization: 'Bearer 4|8JnPn0lPSFzHBKaQUb6pIm7P0ROBxAuPen90Gspa',
    },
  })
  .then((res) => {
    console.log(res.data);
  })
  .catch((e) => {
    console.log(e.response.status);
    console.log(e.response.data);
  });
