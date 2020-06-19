<template>
    <div class="container">
        <div class="card">
            <div class="card-header">
                Filter
            </div>
            <div class="card-body">
                <el-upload
                        ref="upload"
                        :auto-upload="false"
                        accept="image/png, image/jpeg"
                        :before-upload=beforeUpload
                        :on-change="addPhoto"
                        :limit="1"
                        action="#"
                        :file-list="fileList"
                        list-type="picture-card"
                        :on-preview="handlePhotoPreview"
                        :on-remove="handleRemove">
                    <i class="el-icon-plus"></i>
                </el-upload>
                <el-dialog :visible.sync="dialogVisible">
                    <img width="100%" :src="dialogImageUrl" alt="">
                </el-dialog>
                <div class="form">
                    <label for="contentOps">Content</label>
                    <select id="contentOps" class="custom-select custom-select-md mb-2" v-model="selectedTheme">
                        <option value="default">Select Content</option>
                        <option v-for="content in this.content_ops" :key="content">
                            {{content}}
                        </option>
                    </select>
                    <label for="countryOps">County</label>
                    <select id="countryOps" class="custom-select custom-select-md mb-2"
                            v-model="selectedCountry" v-on:change="getCitiesByCountry">
                        <option value="default">Select Country</option>
                        <option v-for="country in this.country_ops" :key="country.CountryCode"
                                :value="country.CountryCode">
                            {{country.CountryName}}
                        </option>
                    </select>
                    <label for="cityOps">City</label>
                    <select id="cityOps" class="custom-select custom-select-md mb-2" v-model="selectedCity">
                        <option value="default">Select City</option>
                        <option v-for="city in this.city_ops" :key="city.cityID" :value="city.cityID">
                            {{city.cityName}}
                        </option>
                    </select>
                    <div class="input-group mt-4 mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Title</span>
                        </div>
                        <input type="text" id="upload_title" class="form-control" v-model="title">

                    </div>
                    <div class="input-group mb-5">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Description</span>
                        </div>
                        <textarea id="upload_description" v-model="description" class="form-control" aria-label="Description" rows="5"/>
                    </div>

                </div>
                <button class="btn btn-danger btn-lg float-sm-left" @click="reset">
                    Reset
                </button>
                <button class="btn btn-success btn-lg float-sm-right" @click="submitUpload">
                    Upload Photo
                </button>
            </div>
        </div>
    </div>
</template>

<script>
    import {getCitiesByISO, getCountries, getThemes} from "@/api/category";
    import {upload} from "@/api/photo";
    import {Message} from "element-ui";

    export default {
        name: "index2",
        data() {
            return {
                dialogImageUrl: '',
                dialogVisible: false,
                uploadUrl: "",
                fileList: [],
                content_ops: [],
                country_ops: [],
                city_ops: [],
                selectedCountry: 'default',
                selectedCity: 'default',
                selectedTheme: 'default',
                title: '',
                description: ''
            }
        },
        methods: {
            formData() {
                return {
                    title: this.title,
                    description: this.description,
                    country: this.selectedCountry,
                    city: this.selectedCity,
                    file: this.fileList[0]
                };
            },
            addPhoto(file, fileList) {
                const isLt2M = file.size / 1024 / 1024 < 2;
                if (!isLt2M) {
                    Message({
                        message: '上传图片大小不能超过 2MB!',
                        type: "error",
                        duration: 5 * 1000
                    });
                    return false;
                } else {
                    this.fileList = fileList;
                }
            },
            handlePhotoPreview(file) {
                this.dialogImageUrl = file.url;
                this.dialogVisible = true;
            },
            reset() {
                this.title = '';
                this.description = '';
                this.selectedTheme = 'default';
                this.selectedCity = 'default';
                this.selectedCountry = 'default';
            },
            submitUpload() {
                console.log(this.fileList[0].raw);
                if (this.selectedCountry === 'default' || this.selectedCity === 'default' || this.selectedTheme === 'default') {
                    Message({
                        message: '请填写图片相关信息后上传',
                        type: "error",
                        duration: 5 * 1000
                    });
                    return;
                }
                if (this.fileList.length === 0) {
                    Message({
                        message: '请选择图片',
                        type: "error",
                        duration: 5 * 1000
                    });
                    return;
                }

                let formData = new FormData();
                formData.append("file", this.fileList[0].raw);
                formData.append("title", this.title);
                formData.append("description", this.description);
                formData.append("country", this.selectedCountry);
                formData.append("city", this.selectedCity);
                formData.append("theme", this.selectedTheme);
                upload(formData).then(response => {
                    if (response.code === 200) {
                        Message({
                            message: '上传成功!',
                            type: "success",
                            duration: 5 * 1000
                        });
                    }
                });
            },
            // handleSuccess(res, file) {
            //     this.imageUrl = URL.createObjectURL(file.raw);
            // },
            handleRemove(file, fileList) {
                this.fileList = [];
                console.log(file);
                console.log(fileList);
            },

            beforeUpload(file) {
                const isImg = file.type === 'image/jpeg' || file.type === 'image/png';
                const isLt2M = file.size / 1024 / 1024 < 2;
                if (!isImg) {
                    Message({
                        message: '上传图片只能是 JPG / PNG 格式!',
                        type: "error",
                        duration: 5 * 1000
                    });

                }
                if (!isLt2M) {
                    Message({
                        message: '上传图片大小不能超过 2MB!',
                        type: "error",
                        duration: 5 * 1000
                    });

                }
                return isImg && isLt2M;
            },
            getCitiesByCountry() {
                getCitiesByISO({CountryCode: this.selectedCountry}).then(response => {
                    const {data} = response;
                    this.city_ops = data;
                })
            },
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
        }
    }
</script>

<style scoped>

</style>