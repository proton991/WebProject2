<template>

    <div id="app">
        <div id="container">
            <Navbar>
            </Navbar>
            <div id="main">
                <keep-alive>
                    <router-view v-if="$route.name === 'browse' || $route.name === 'search'">
                    </router-view>

                </keep-alive>
                <router-view v-if="$route.name !== 'browse' && $route.name !== 'search'">
                </router-view>

<!--                <router-view>-->
<!--                </router-view>-->
            </div>
        </div>
        <Footer v-if="$route.name === 'home'">
        </Footer>
    </div>

</template>

<script>
    import Footer from "@/components/Footer/Footer";
    import Navbar from "@/components/Navbar/Navbar";
    export default {
        name: 'App',
        components: {
            Footer,
            Navbar
        }
    }
</script>

<style>
    #app {
        font-family: Avenir, Helvetica, Arial, sans-serif;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
        /*text-align: center;*/
        color: #2c3e50;
        height: 100%;
    }


    /*.footer {*/
    /*    position: relative;*/
    /*    color: white;*/
    /*    height: 180px;*/
    /*    background: black;*/
    /*    margin-top: -180px;*/
    /*    clear: both;*/
    /*}*/

    #container {
        min-height: 100%;
    }

    #main {
        overflow: auto;
        /*width: 70%;*/
        /*background: red;*/
        padding-top: 40px;
        /*margin: 0 auto;*/
        padding-bottom: 180px;
    }

    /*.footer-top {*/
    /*    display: flex;*/
    /*    color: white;*/
    /*    justify-content: space-around;*/
    /*}*/
    /*.footer div ul {*/
    /*    list-style: none;*/
    /*}*/
    /*.footer div ul li {*/

    /*    padding: 10px 0;*/
    /*}*/
    /*.footer-btm {*/
    /*    color: whitesmoke;*/
    /*    text-align: center;*/
    /*}*/

</style>
