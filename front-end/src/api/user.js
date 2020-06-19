import request from '@/axios/request'

export function login(data) {
    return request({
        url: '/api/login.php',
        method: 'post',
        data: data,
        headers: {
            'Content-Type': 'application/json',
        }
    })
}

export function logout(data) {
    return request({
        url: '/api/logout.php',
        method: 'post',
        data: data,
        headers: {
            'Content-Type': 'application/json',
        }
    })
}

export function register(data) {
    return request({
        url: '/api/register.php',
        method: 'post',
        data: data,
        headers: {
            'Content-Type': 'application/json',
        }
    })
}
