// import Cookies from 'js-cookie'

// const TokenKey = 'vue_token';

export function getToken() {
    return sessionStorage.getItem("token");
    // return Cookies.get(TokenKey);
}

export function getName() {
    return sessionStorage.getItem("name");
}

export function getState() {
    return sessionStorage.getItem("loginState");
}

export function setLoginState(data) {
    sessionStorage.setItem("token", data.token);
    sessionStorage.setItem("name", data.username);
    sessionStorage.setItem("loginState", data.loginState);
}

export function setLogoutState() {
    sessionStorage.removeItem("token");
    sessionStorage.removeItem("name");
    sessionStorage.removeItem("loginState");
}
