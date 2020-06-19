<template>
    <div>
        <div class="card" style="width: 18rem; margin-bottom: 20px;">
            <div class="card-header">
                Content
            </div>
            <a class="list-group-item list-group-item-action"
               v-for="theme in this.themes"
               :key="theme"
               href="javascript:void(0)"
               :class="{active : theme === currentId}"
               @click="filterByTheme(theme)"
            >
                {{theme}}
            </a>
        </div>
        <div class="card" style="width: 18rem; margin-bottom: 20px;">
            <div class="card-header">
                Country
            </div>
            <a class="list-group-item list-group-item-action"
               v-for="country in this.hotCountries"
               :key="country.countryID"
               href="javascript:void(0)"
               :class="{active : country.countryID === currentId}"
               @click="filterByCountry(country.countryID)"
            >
                {{country.countryName}}
            </a>

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
            });

        },
        methods: {
            filterByCity(id) {
                if (this.currentId === id) {
                    this.currentId = -1;
                    const filter = {
                        type: "None",
                        val: '',
                    };
                    this.$emit('change', filter);
                    return;
                }
                this.currentId = id;
                const filter = {
                    type: "City",
                    val: id
                };
                this.$emit('change', filter);
            },
            filterByCountry(id) {
                if (this.currentId === id) {
                    this.currentId = -1;
                    const filter = {
                        type: "None",
                        val: '',
                    };
                    this.$emit('change', filter);
                    return;
                }
                this.currentId = id;
                const filter = {
                    type: "Country",
                    val: id
                };
                this.$emit('change', filter);
            },
            filterByTheme(id) {
                if (this.currentId === id) {
                    this.currentId = -1;
                    const filter = {
                        type: "None",
                        val: '',
                    };
                    this.$emit('change', filter);
                    return;
                }
                this.currentId = id;
                const filter = {
                    type: "Theme",
                    val: id
                };
                this.$emit('change', filter);
            },
        }
    }
</script>

<style scoped>

</style>