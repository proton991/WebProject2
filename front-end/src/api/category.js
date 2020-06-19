import request from '@/axios/request'
export function getHotCountries() {
    return request({
        url: 'api/getHotCountry.php',
        method: 'get'
    })
}
export function getHotCities() {
    return request({
        url: 'api/getHotCity.php',
        method: 'get'
    })
}
export function getHotThemes() {
    return request({
        url: 'api/getHotTheme.php',
        method: 'get'
    })
}
export function getCountries() {
    return request({
        url: 'api/getCountries.php',
        method: 'get'
    })
}
export function getCitiesByISO(data) {
    return request({
        url: 'api/getCitiesByISO.php',
        method: 'post',
        data: data
    })
}
export function getThemes() {
    return request({
        url: 'api/getThemes.php',
        method: 'get'
    })
}