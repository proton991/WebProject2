<template>
    <div>
        <div class="d-flex justify-content-around flex-wrap" style="padding: 5rem;">
            <div class="card" style="width: 26%; margin-bottom: 2rem" v-for="photo in this.photos" :key="photo.photoId">
                <router-link :to="{name: 'photo_detail', params: {id: photo.photoId}}">
                    <img class="card-img-top" :src=photo.path alt="Card image cap">
                </router-link>
                <div class="card-body">
                    <p class="card-text">{{photo.description}}</p>
                </div>
            </div>
            <div class="aux__button">

                <!--                <a href="#topAnchor" style="background: #b02818; font-size: 5rem">-->
                <!--                    <i class="fa fa-arrow-up"></i>-->
                <!--                </a>-->
                <div class="rocket-con"
                    ref="topAnimation"
                    @click="toTop()"
                    @mouseover="fly()"
                    @mouseleave="shutdown()"/>
                <br>
                <button class="btn btn-success refresh-button" style="font-size: 3rem;" @click="refreshPhotos"><i class="fa fa-refresh"></i>
                </button>

            </div>
        </div>
    </div>

</template>

<script>
    import {getHotPhotos, getPhotosRan} from "@/api/photo";

    export default {
        name: "home",
        mounted: function () {
            // window.addEventListener("scroll", this.handleScroll, true);
            getHotPhotos().then(response => {
                const {data} = response;
                this.photos = data;
                if (this.photos !== null) {
                    for (let p of this.photos) {
                        p.path += '?x-oss-process=image/resize,m_fill,h_350,w_350';
                    }
                }
            })

        },
        data() {
            return {
                hover: false,
                photos: []
                // photos: [
                //     {id: 1, url: "1"},
                //     {id: 2, url: "2"},
                //     {id: 3, url: "3"},
                //     {id: 4, url: "4"},
                //     {id: 5, url: "5"},
                //     {id: 6, url: "6"},
                //
                // ]
            }
        },
        methods: {
            refreshPhotos() {
                getPhotosRan().then(response => {
                    const {data} = response;
                    this.photos = data;
                    if (this.photos !== null) {
                        for (let p of this.photos) {
                            p.path += '?x-oss-process=image/resize,m_fill,h_350,w_350';
                        }
                    }
                })
            },
            fly(){
                this.$refs["topAnimation"].setAttribute("class", "rocket-con fly");
            },
            shutdown() {
                this.$refs["topAnimation"].setAttribute("class", "rocket-con");
            },
            handleScroll() {
                //注意不同浏览器之间的兼容性
                let scrolltop = document.documentElement.scrollTop || document.body.scrollTop;
                scrolltop > 30 ? (this.gotop = true) : (this.gotop = false);
            },
            toTop() {
                let top = document.documentElement.scrollTop || document.body.scrollTop;
                // 实现滚动效果
                const timeTop = setInterval(() => {
                    document.body.scrollTop = document.documentElement.scrollTop = top -= 50;
                    if (top <= 0) {
                        clearInterval(timeTop);
                    }
                }, 10);
            }
        }
    }
</script>

<style scoped>

    .aux__button {
        /*right: 0;*/
        bottom: 0;
        position: fixed;
        z-index: 99;
    }
    .refresh-button {
        position: fixed;
        right: 2%;
        bottom: 0;
    }
    .rocket-con {

        position: fixed;
        background: url(../../assets/frames/rocket_top.png);
        width: 150px;
        height: 175px;
        cursor: pointer;
        right: 0;
        bottom: 10%;
    }

    .fly {
        animation: fly .4s steps(1) infinite;
        animation-duration: 0.4s;
        animation-timing-function: steps(1);
        animation-delay: 0s;
        animation-iteration-count: infinite;
        animation-direction: normal;
        animation-fill-mode: none;
        animation-play-state: running;
        animation-name: fly;
        background-image: url(../../assets/frames/rocket_frame.png);
    }

    @keyframes fly {
        0% {
            background-position-x: 0
        }
        25% {
            background-position-x: -150px
        }
        50% {
            background-position-x: -300px
        }
        75% {
            background-position-x: -450px
        }
        to {
            background-position-x: -600px
        }
    }
</style>