import request from '@/axios/request'
export function getHotPhotos() {
    return request({
        url: 'api/getHotPhotos.php',
        method: 'get',

    })
}
export function getPhotosRan() {
    return request({
        url: 'api/getPhotosRan.php',
        method: 'get',

    })
}
export function getPhotoById(data) {
    return request({
        url: 'api/getPhotoById.php',
        method: 'post',
        data: data,
        headers: {
            'Content-Type': 'application/json',
        }
    })
}
export function getPhotos(data) {
    return request({
        url: 'api/getPhotos.php',
        method: 'post',
        data: data,
        headers: {
            'Content-Type': 'application/json',
        }
    })
}
export function getPhotosByUID(data) {
    return request({
        url: 'api/photos.php',
        method: 'post',
        data: data,
        headers: {
            'Content-Type': 'application/json',
        }
    })
}
export function getFavPhotosByUID(data) {
    return request({
        url: 'api/favourites.php',
        method: 'post',
        data: data,
        headers: {
            'Content-Type': 'application/json',
        }
    })
}
export function addToFav(data) {
    return request({
        url: 'api/addToFav.php',
        method: 'post',
        data: data,
        headers: {
            'Content-Type': 'application/json',
        }
    })
}

export function removeFav(data) {
    return request({
        url: 'api/removeFav.php',
        method: 'post',
        data: data,
        headers: {
            'Content-Type': 'application/json',
        }
    })
}

export function removePhoto(data) {
    return request({
        url: 'api/removePhoto.php',
        method: 'post',
        data: data,
        headers: {
            'Content-Type': 'application/json',
        }
    })
}
export function upload(data) {
    return request({
        url: 'api/upload.php',
        method: 'post',
        data: data,
    })
}
export function edit(data) {
    return request({
        url: 'api/editPhoto.php',
        method: 'post',
        data: data,
    })
}