<template>
    <div class="card" style="width: 18rem;">
        <div class="card-header">
            Country
        </div>
        <ul class="list-group list-group-flush">
            <li class="list-group-item" v-for="country in this.hotCountries" :key="country">{{country}}</li>
        </ul>
    </div>
</template>

<script>
    import {getHotCountries} from "@/api/category";

    export default {
        name: "Country",
        data() {
            return {
                hotCountries: []
            }
        },
        mounted: function () {
            getHotCountries().then(response => {
                const {data} = response;
                this.hotCountries = data;
            })
        }
    }
</script>

<style scoped>

</style>