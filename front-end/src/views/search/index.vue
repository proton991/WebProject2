<template>
    <div class="container">
        <div class="card">
            <div class="card-header">
                Search
            </div>
            <div class="card-body">
                <div class="form-group">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" id="titleRadio" value="title" v-model="checkedVal">
                        <label class="form-check-label" for="titleRadio">
                            Filter By Title
                        </label>
                        <label for="title_input"/>
                        <input class="form-control" id="title_input" v-model="title">
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" id="descriptionRadio" value="description" v-model="checkedVal">
                        <label class="form-check-label" for="descriptionRadio">
                            Filter By Description
                        </label>
                        <label for="description_input"/>
                        <textarea class="form-control" id="description_input" rows="3" v-model="description"/>
                    </div>
                </div>
                <button class="btn btn-success float-sm-left" @click="filterFunc">
                    Filter
                </button>
                <button class="btn btn-danger float-sm-right" @click="resetFunc">
                    Reset
                </button>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                Result
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
                </div>
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
</template>

<script>
    import {getPhotos} from "@/api/photo";
    import {Message} from "element-ui";
    export default {
        name: "index",
        data() {
            return {
                resizeParam: '?x-oss-process=image/resize,m_fill,h_150,w_150',
                photoList: [],
                totalPages: 0,
                pageNum: 1,
                pageSize: 12,
                checkedVal: '',
                title: '',
                description: '',
                filter: {
                    type: 'None',
                    val: ''
                },
            }
        },
        methods: {
            nextPage() {
                this.pageNum++;
                getPhotos({pageNum: this.pageNum, pageSize: this.pageSize, filter: this.filter}).then(response => {
                    const {data} = response;
                    this.photoList = data.photos;
                    this.totalPages = data.totalPages;
                    for (let p of this.photoList) {
                        p.path += this.resizeParam;
                        // p.path += '?x-oss-process=image/resize,m_fill,h_250,w_250';
                    }
                });
            },
            prevPage() {
                this.pageNum--;
                getPhotos({pageNum: this.pageNum, pageSize: this.pageSize, filter: this.filter}).then(response => {
                    const {data} = response;
                    this.photoList = data.photos;
                    this.totalPages = data.totalPages;
                    for (let p of this.photoList) {
                        p.path += this.resizeParam;
                        // p.path += '?x-oss-process=image/resize,m_fill,h_150,w_150';
                    }
                });
            },
            changePage(val) {

                this.pageNum = val;
                getPhotos({pageNum: this.pageNum, pageSize: this.pageSize, filter: this.filter}).then(response => {
                    const {data} = response;
                    this.photoList = data.photos;
                    this.totalPages = data.totalPages;
                    for (let p of this.photoList) {
                        p.path += this.resizeParam;
                        // p.path += '?x-oss-process=image/resize,m_fill,h_150,w_150';
                    }
                });
            },
            resetFunc(){
                this.checkedVal = '';
                this.title = '';
                this.description = '';
                this.photoList = [];
                this.pageNum = 1;
                this.totalPages = 0;
            },
            filterFunc() {
                if (this.checkedVal === 'title') {
                    console.log(this.title);
                    this.filter = {
                        type: 'Title',
                        val: this.title
                    }
                }
                if (this.checkedVal === 'description') {
                    console.log(this.description);
                    this.filter = {
                        type: 'Description',
                        val: this.description
                    }
                }
                if (this.filter.type === 'None' || this.title === null || this.description === null) {
                    Message({
                        message: "Please fill in before filtering!",
                        type: "warning",
                        duration: 5 * 1000
                    });
                } else {
                    this.pageNum = 1;
                    getPhotos({pageNum: this.pageNum, pageSize: this.pageSize, filter: this.filter}).then(response => {
                        const {data} = response;
                        this.photoList = data.photos;
                        this.totalPages = data.totalPages;
                        for (let p of this.photoList) {
                            p.path += this.resizeParam;
                            // p.path += '?x-oss-process=image/resize,m_fill,h_150,w_150';
                        }
                    });
                }
            }
        }
    }
</script>

<style scoped>
    .form-group .form-check{
        padding: 15px;
    }

</style>