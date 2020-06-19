import request from '@/axios/request'

export function uploadPhoto(formData) {
    return request({
        url: '/api/upload.php',
        method: 'post',
        data: formData
    });
}