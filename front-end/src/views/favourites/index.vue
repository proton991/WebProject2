<template>
    <div class="container">
        <div class="card">
            <div class="card-header">
                My Favourites
                <span><router-link :to="{path: '/photos'}" class="float-sm-right">My Photos</router-link></span>
            </div>
            <div class="card-body">
                <div class="media" v-for="photo in this.photoList" :key="photo.photoId" style="margin-bottom: 20px">
                    <router-link :to="{name: 'photo_detail', params: {id: photo.photoId}}">
                        <img class="mr-3" :src=photo.path alt="Card image cap">
                    </router-link>
                    <div class="media-body">
                        <h5 class="mt-0">{{photo.title}}</h5>
                        <p style="word-break:break-all;">
                            {{photo.description === null ? "":photo.description.substr(0,500)}}...
                        </p>
                    </div>
                    <button class="btn btn-danger" @click="removeFav(photo.photoId)">Delete</button>
                </div>
                <el-pagination
                        background
                        layout="prev, pager, next"
                        :page-count="totalPages"
                        :page-size="pageSize"
                        :current-page="pageNum"
                        @prev-click="prevPage"
                        @next-click="nextPage"
                        @current-change="changePage"
                >
                </el-pagination>
            </div>
        </div>
    </div>


</template>

<script>
    import {getFavPhotosByUID, removeFav} from "@/api/photo";
    import {Message, MessageBox} from "element-ui";

    export default {
        name: "index",
        data() {
            return {
                totalPages: 0,
                pageNum: 1,
                pageSize: 3,
                photoList: []
            }
        },
        methods: {
            removeFav(id) {
                MessageBox.confirm('remove from favourites?', 'Confirm', {
                    confirmButtonText: 'Yes',
                    cancelButtonText: 'No',
                    type: 'warning'
                }).then(() => {
                    removeFav({photoId: id}).then(response => {
                        if (response.code === 200) {
                            Message({
                                message: "Deleted!",
                                type: "success",
                                duration: 5 * 1000
                            });
                            location.reload();
                        }

                    });
                }).catch(() => {
                    Message({
                        type: "info",
                        message: 'Canceled',
                        duration: 500
                    })
                });



            },
            nextPage() {
                this.pageNum++;
                getFavPhotosByUID({pageNum: this.pageNum, pageSize: this.pageSize}).then(response => {
                    const {data} = response;
                    this.photoList = data.photos;
                    this.totalPages = data.totalPages;
                    for (let p of this.photoList) {
                        p.path += '?x-oss-process=image/resize,m_fill,h_250,w_250';
                    }
                });
            },
            prevPage() {
                this.pageNum--;
                getFavPhotosByUID({pageNum: this.pageNum, pageSize: this.pageSize}).then(response => {
                    const {data} = response;
                    this.photoList = data.photos;
                    this.totalPages = data.totalPages;
                    for (let p of this.photoList) {
                        p.path += '?x-oss-process=image/resize,m_fill,h_250,w_250';
                    }
                });
            },
            changePage(val) {

                this.pageNum = val;
                getFavPhotosByUID({pageNum: this.pageNum, pageSize: this.pageSize}).then(response => {
                    const {data} = response;
                    this.photoList = data.photos;
                    this.totalPages = data.totalPages;
                    for (let p of this.photoList) {
                        p.path += '?x-oss-process=image/resize,m_fill,h_250,w_250';
                    }
                });
            },
        },
        mounted: function () {

            getFavPhotosByUID({pageNum: this.pageNum, pageSize: this.pageSize}).then(response => {
                const {data} = response;
                if (data.length !== 0 && data.photos !== null && data.totalPages !== null) {
                    this.photoList = data.photos;
                    this.totalPages = data.totalPages;
                    if (this.photoList !== null) {
                        for (let p of this.photoList) {
                            p.path += '?x-oss-process=image/resize,m_fill,h_250,w_250';
                        }
                    }
                }
            });
        }
    }
</script>

<style scoped>

</style>