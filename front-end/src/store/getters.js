const getters = {
    token: state => state.user.token,
    name: state => state.user.name,
    loginState: state => state.user.loginState
};
export default getters
