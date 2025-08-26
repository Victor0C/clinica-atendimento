import axios from 'axios';

const api = axios.create({
    baseURL: window.location.origin,
    withCredentials: true,
});

export default api;
