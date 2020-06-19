<template>
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                Details
            </div>
            <div class="card-body">
                <h1 style="text-align: center; margin-bottom: 5rem">{{this.photo.title}}</h1>
                <div class="row">
                    <div class="col-sm-5">
                        <img class="card-img-top" :src=this.photo.path alt="Card image cap">
                    </div>
                    <div class="col-sm-7">
                        <div class="card">
                            <div class="card-header">Like Number</div>
                            <div class="card-body"><h2 style="text-align: center; color: red;">
                                {{this.photo.favCount}}</h2></div>
                        </div>
                        <div class="card mt-sm-5">
                            <div class="card-header">Image Details</div>
                            <div class="card-text">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">Theme: {{this.photo.theme}}</li>
                                    <li class="list-group-item">Country: {{this.photo.countryCode}}</li>
                                    <li class="list-group-item">City: {{this.photo.cityCode}}</li>
                                </ul>
                            </div>
                        </div>
                        <button class="btn btn-danger" style="margin:20px 0" @click="addToFav">
                            Add to favourite
                            <svg t="1590757832543" class="icon" viewBox="0 0 1188 1024" version="1.1"
                                 xmlns="http://www.w3.org/2000/svg" p-id="2380" width="16" height="16">
                                <path d="M864.01024 0c-79.23712 0-155.40224 29.47072-214.528 83.0464-22.46656 20.31616-41.69728 43.4176-57.46688 68.93568-15.7696-25.4976-35.00032-48.59904-57.46688-68.95616-59.14624-53.53472-135.29088-83.00544-214.528-83.00544-176.45568 0-320 143.54432-320 320 0 119.11168 37.04832 213.11488 123.86304 314.40896 126.13632 147.18976 445.39904 371.83488 458.93632 381.3376 2.74432 1.9456 5.98016 2.90816 9.17504 2.90816s6.43072-0.96256 9.17504-2.90816c13.53728-9.50272 332.8-234.14784 458.97728-381.3376 86.79424-101.2736 123.84256-195.29728 123.84256-314.40896 0-176.45568-143.54432-320-320-320zM1035.8784 613.60128c-111.84128 130.43712-389.75488 330.91584-443.86304 369.43872-54.10816-38.52288-332.02176-239.0016-443.84256-369.43872-81.44896-95.00672-116.16256-182.82496-116.16256-293.60128 0-158.8224 129.20832-288.01024 287.98976-288.01024 71.2704 0 139.83744 26.5216 193.024 74.71104 26.80832 24.30976 48.57856 52.98176 64.63488 85.25824 5.44768 10.87488 23.22432 10.87488 28.672 0 16.05632-32.256 37.82656-60.928 64.63488-85.21728 53.18656-48.2304 121.7536-74.752 193.024-74.752 158.78144 0 288.01024 129.18784 288.01024 287.98976 0 110.77632-34.7136 198.59456-116.1216 293.60128z"
                                      p-id="2381"></path>
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="card-text font-weight-bold pt-sm-5" style="font-size: 20px">
                    {{this.photo.description}}
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import {getPhotoById, addToFav} from "@/api/photo";
    import {Message} from "element-ui";

    export default {
        name: "detail",
        data: function () {
            return {
                photo: {}
            }
        },
        methods: {
            addToFav() {
                addToFav({photoId: this.photo.photoId}).then(response => {
                    if (response.code === 200) {
                        Message({
                            message: "Operation succeeded!",
                            type: "success",
                            duration: 5 * 1000
                        });
                        location.reload();
                    }
                })
            }
        },
        mounted: function () {
            console.log(this.$route.params.id);
            const id = this.$route.params.id;
            getPhotoById({photoId: id}).then(response => {
                const {data} = response;
                this.photo = data;
                console.log(this.photo);
            })
        }
    }
</script>

<style scoped>

</style>