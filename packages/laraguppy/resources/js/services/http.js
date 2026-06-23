import axios from 'axios'

let auth_token = window.guppy_auth_token;

const apiClient = axios.create({
    baseURL: "/api",
    headers: {
        'Authorization' : `Bearer ${auth_token}`,
        "Content-type": "application/json"
    }
});

apiClient.interceptors.response.use(
  response => {
    return Promise.resolve(response.data)
  },
  error => {
    return Promise.reject(error.response.data);
  }
);

export default apiClient;