export const getters = {
    // isAuthenticated(state) {
    //     return state.auth.loggedIn
    // },
    isAuthenticated(state) {
        return state.auth.loggedIn
    },
    loggedInUser(state) {
        return state.auth.user
    }
}