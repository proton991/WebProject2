<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-2 left-side">
                <div class="card">
                    <div class="card-header">
                        Search By Title
                    </div>
                    <div class="card-body">
                        <form class="form-row">
                            <div class="col">
                                <input
                                        v-model="searchTitle"
                                        class="form-control" type="search" placeholder="Search By Title..."
                                        aria-label="Search">
                            </div>
                            <div class="col-auto">
                                <button class="btn-sm btn-primary" @click="filterByTitle">Search</button>
                            </div>
                        </form>
                    </div>
                </div>
                <Category @change="filterByCtg" ref="childIndex"/>
            </div>
            <div class="col-sm-9 photo-area">
                <div class="card">
                    <div class="card-header">
                        Filter
                    </div>
                    <div class="card-body">
                        <div class="form-row">
                            <div class="col">
                                <label for="contentOps">Filter By Content</label>
                                <select id="contentOps" class="custom-select custom-select-md mb-2" v-model="selectedTheme">
                                    <option value="default">Select Content</option>
                                    <option v-for="content in this.content_ops" :key="content">
                                        {{content}}
                                    </option>
                                </select>
                            </div>
                            <div class="col">
                                <label for="countryOps">Filter By County</label>
                                <select id="countryOps" class="custom-select custom-select-md mb-2"
                                        v-model="selectedCountry" v-on:change="getCitiesByCountry">
                                    <option value="default">Select Country</option>
                                    <option v-for="country in this.country_ops" :key="country.CountryCode"
                                            :value="country.CountryCode">
                                        {{country.CountryName}}
                                    </option>
                                </select>
                            </div>
                            <div class="col">
                                <label for="cityOps">Filter By City</label>
                                <select id="cityOps" class="custom-select custom-select-md mb-2" v-model="selectedCity">
                                    <option value="default">Select City</option>
                                    <option v-for="city in this.city_ops" :key="city.cityID" :value="city.cityID">
                                        {{city.cityName}}
                                    </option>
                                </select>
                            </div>
                            <button class="btn btn-success float-sm-right col-auto"
                                    style="height: 50%; margin-top: 30px" @click="filterBy3">
                                Filter
                            </button>
                        </div>
                    </div>
                    <div class="photoList">
                        <div class="photo" v-for="photo in this.photoList" :key="photo.photoId">
                            <router-link :to="{name: 'photo_detail', params: {id: photo.photoId}}">
                                <img class="card-img-top" :src=photo.path alt="Card image cap">
                            </router-link>
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
        </div>
    </div>

</template>

<script>
    import Category from "@/components/Category/index";
    import {getPhotos} from "@/api/photo";
    import {getCountries, getCitiesByISO, getThemes} from "@/api/category";
    import {Message} from "element-ui";

    export default {
        name: "index",
        components: {
            Category
        },
        data() {
            return {
                totalPages: 0,
                pageNum: 1,
                pageSize: 12,
                filter: {
                    type: 'None',
                    val: ''
                },
                photoList: [],
                searchTitle: '',
                content_ops: [],
                country_ops: [],
                city_ops: [],
                selectedCountry: 'default',
                selectedCity: 'default',
                selectedTheme: 'default'
            }
        },
        methods: {
            getCitiesByCountry() {
                getCitiesByISO({CountryCode: this.selectedCountry}).then(response => {
                    const {data} = response;
                    this.city_ops = data;
                })
            },
            nextPage() {
                this.pageNum++;
                getPhotos({pageNum: this.pageNum, pageSize: this.pageSize, filter: this.filter}).then(response => {
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
                getPhotos({pageNum: this.pageNum, pageSize: this.pageSize, filter: this.filter}).then(response => {
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
                getPhotos({pageNum: this.pageNum, pageSize: this.pageSize, filter: this.filter}).then(response => {
                    const {data} = response;
                    this.photoList = data.photos;
                    this.totalPages = data.totalPages;
                    for (let p of this.photoList) {
                        p.path += '?x-oss-process=image/resize,m_fill,h_250,w_250';
                    }
                });
            },
            filterByCtg(filter) {
                this.filter = {
                    type: filter.type,
                    val: filter.val
                };
                this.pageNum = 1;
                getPhotos({pageNum: this.pageNum, pageSize: this.pageSize, filter: this.filter}).then(response => {
                    const {data} = response;
                    this.photoList = data.photos;
                    this.totalPages = data.totalPages;
                    for (let p of this.photoList) {
                        p.path += '?x-oss-process=image/resize,m_fill,h_250,w_250';
                    }
                });
            },
            filterByTitle() {
                if(this.searchTitle.length === 0) {
                    Message({
                        message: "Please input search keyword!",
                        type: "warning",
                        duration: 5 * 1000
                    });
                    return;
                }
                this.filter = {
                    type: "Title",
                    val: this.searchTitle
                };
                this.pageNum = 1;
                this.$refs.childIndex.currentId = -1;
                getPhotos({pageNum: this.pageNum, pageSize: this.pageSize, filter: this.filter}).then(response => {
                    const {data} = response;
                    this.photoList = data.photos;
                    this.totalPages = data.totalPages;
                    for (let p of this.photoList) {
                        p.path += '?x-oss-process=image/resize,m_fill,h_250,w_250';
                    }
                });

            },
            filterBy3() {

                if (this.selectedCountry === 'default' && this.selectedCity === 'default' && this.selectedTheme === 'default') {
                    this.filter = {
                        type: "None",
                    };
                    this.$refs.childIndex.currentId = -1;
                }
                else if (this.selectedCountry === 'default' || this.selectedCity === 'default' || this.selectedTheme === 'default') {
                    Message({
                        message: "All 3 selectors must be set before filtering!",
                        type: "warning",
                        duration: 5 * 1000
                    });
                    return;
                }
                else {
                    this.$refs.childIndex.currentId = -1;
                    this.filter = {
                        type: "All",
                        countryCode: this.selectedCountry,
                        cityCode: this.selectedCity,
                        theme: this.selectedTheme
                    };
                }
                this.pageNum = 1;
                getPhotos({pageNum: this.pageNum, pageSize: this.pageSize, filter: this.filter}).then(response => {
                    const {data} = response;
                    this.photoList = data.photos;
                    this.totalPages = data.totalPages;
                    for (let p of this.photoList) {
                        p.path += '?x-oss-process=image/resize,m_fill,h_250,w_250';
                    }
                });
            }
        },
        mounted: function () {
            getCountries().then(response => {
                const {data} = response;
                this.country_ops = data;
            });
            getThemes().then(response => {
                const {data} = response;
                this.content_ops = data;
            });
            getPhotos({pageNum: this.pageNum, pageSize: this.pageSize, filter: this.filter}).then(response => {
                const {data} = response;
                this.photoList = data.photos;
                this.totalPages = data.totalPages;
                for (let p of this.photoList) {
                    p.path += '?x-oss-process=image/resize,m_fill,h_250,w_250';
                }
            });

        }
    }
</script>

<style scoped>
    .left-side {
    }

    .photo-area {
    }

    .hot-content {
        margin-top: 20px;
    }

    .hot-country {
        margin-top: 20px;
    }

    .hot-city {
        margin-top: 20px;
    }

    .photoList {
        display: flex;
        justify-content: space-around;
        flex-wrap: wrap;
    }

    .photo {
        margin: 50px auto;
        width: 22%;
    }
</style>