import axios from 'axios'
import { Message } from 'element-ui'

const service = axios.create({
    timeout: 60000,
    // withCredentials: true,
    // headers: {
    //     'Content-Type': "application/json; charset=utf-8"
    // }
});

service.interceptors.request.use(
    config => {
        // config.headers['Content-Type'] = 'application/json';
        // config.data = qs.stringify(config.data);
        return config
    },
    error => {
        return Promise.reject(error)
    }
);
service.interceptors.response.use(response => {
        const res = response.data;
        if (res.code !== 200) {
            Message({
                message: res.message,
                type: "error",
                duration: 5 * 1000
            });
            // location.reload();
            return Promise.reject(new Error(res.message || 'Error'))
        } else {
            return res;
        }
        // console.log(response);
        // return res;
    }, error => {
        alert("Something bad happened...");
        return Promise.reject(error);
    }
);

export default service
