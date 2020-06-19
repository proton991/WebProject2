<template>
    <div>
        <div class="card" style="width: 18rem;">
            <div class="card-header">
                Content
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item" v-for="theme in this.themes" :key="theme">{{theme}}</li>
            </ul>
        </div>
        <div class="card" style="width: 18rem;">
            <div class="card-header">
                Country
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item" v-for="country in this.hotCountries" :key="country">{{country}}</li>
            </ul>
        </div>
        <div class="card" style="width: 18rem;">
            <div class="card-header">
                City
            </div>

            <a class="list-group-item list-group-item-action"
               v-for="city in this.hotCities"
               :key="city.cityID"
               href="javascript:void(0)"
               :class="{active : city.cityID === currentId}"
               @click="filterByCity(city.cityID)"
            >
                {{city.cityName}}
            </a>
        </div>
    </div>

</template>

<script>
    import {getHotCities, getHotCountries, getHotThemes} from "@/api/category";

    export default {
        name: "Category",
        data() {
            return {
                hotCities: [],
                currentId: '',
                themes: [],
                hotCountries: []
            }
        },
        mounted: function () {
            getHotCities().then(response => {
                const {data} = response;
                this.hotCities = data;
            });
            getHotThemes().then(response => {
                const {data} = response;
                this.themes = data;
            });
            getHotCountries().then(response => {
                const {data} = response;
                this.hotCountries = data;
            })
        },
        methods: {
            filterByCity(id) {
                this.currentId = id;
                this.$emit('change', id);
            }
        }
    }
</script>

<style scoped>

</style>