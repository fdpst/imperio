import axios from 'axios'
import store from '../store/store'

export default function setup() {
    axios.interceptors.request.use(function(config) {
        store.dispatch('isLoading', true);
        return config;
    }, function(err) {
        return Promise.reject(err);
    });

    axios.interceptors.response.use(function(config) {
        store.dispatch('isLoading', false);
        return config;
    }, function(err) {
        store.dispatch('isLoading', false);
        return Promise.reject(err);
    });
}
