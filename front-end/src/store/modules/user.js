import {login, logout} from "@/api/user";
import {getToken, getName, getState, setLoginState, setLogoutState} from "@/utils/sessionUtil";

const getDefaultState = () => {
    return {
        token: getToken(),
        name: getName(),
        loginState: getState()
    }
};

const state = getDefaultState();

const mutations = {
    RESET_STATE: (state) => {
        state.token = '';
        state.name = '';
        state.loginState = null;
    },
    USER_LOGIN: (state, data) => {
        state.token = data.token;
        state.name = data.username;
        state.loginState = true;
    },
};

const actions = {
    login({commit}, userInfo) {
        const {username, password} = userInfo;
        return new Promise((resolve, reject) => {
            login({username: username.trim(), password: password}).then(response => {
                const {data} = response;
                console.log(response);
                data.loginState = true;
                commit('USER_LOGIN', data);
                setLoginState(data);
                resolve()
            }).catch(error => {
                reject(error)
            })
        })
    },
    logout({commit, state}) {
        return new Promise((resolve, reject) => {

            logout({cookie: state.token}).then(() => {
                setLogoutState();
                commit('RESET_STATE');
                resolve();
            }).catch(error => {
                reject(error)
            })
        })
    }
};

export default {
    namespaced: true,
    state,
    mutations,
    actions
}
