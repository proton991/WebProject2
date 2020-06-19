<template>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">OutofBounds</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ">
                <li class="nav-item">
                    <router-link
                            class="nav-link" tag="a"
                            to="/"
                            :class="{active : $route.name === 'home'}"
                    >
                        Home
                    </router-link>
                </li>
                <li class="nav-item">
                    <router-link class="nav-link" tag="a" to="/browse" :class="{active : $route.name === 'browse'}">
                        Browse
                    </router-link>
                </li>
                <li class="nav-item">
                    <router-link class="nav-link" tag="a" to="/search" :class="{active : $route.name === 'search'}">
                        Search
                    </router-link>
                </li>
            </ul>
            <ul class="navbar-nav" style="margin-left: auto">
                <li class="nav-item">
                    <router-link :to="{ path: '/login'}">
                        <button class="btn btn-primary" type="button" v-if="!loginState">Login</button>
                    </router-link>
                </li>
                <li class="nav-item dropdown" v-if="loginState" style="margin-right: 5rem">
                    <button class="nav-link dropdown-toggle btn btn-primary" id="navbarDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        User
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">
                        <router-link class="dropdown-item" tag="button" to="/upload">Upload</router-link>
                        <router-link class="dropdown-item" tag="button" to="/photos">My Photos</router-link>
                        <router-link class="dropdown-item" tag="button" to="/favourites">My favourites</router-link>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#" @click="handleLogout">Logout</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>

</template>

<script>
    import {mapGetters} from 'vuex'

    export default {
        name: "Header",
        computed: {
            ...mapGetters([
                'name',
                'loginState'
            ])
        },
        methods: {
            handleLogout() {
                this.$store.dispatch('user/logout');
                this.$router.push('/')
            },
        },
    }
</script>

<style scoped>

    ul li {
        padding-left: 1rem;
    }

    @media only screen and (min-width: 850px) {
        .form-control {
            width: 30rem;
        }
    }

    @media only screen and (max-width: 600px) {
        .form-control {
            width: 15rem;
        }
    }


</style>