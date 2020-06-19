<template>
    <div class="card" style="width: 18rem;">
        <div class="card-header">
            Content
        </div>
        <ul class="list-group list-group-flush">
            <li class="list-group-item" v-for="theme in this.themes" :key="theme">{{theme}}</li>
        </ul>
    </div>
</template>

<script>
    import {getHotThemes} from "@/api/category";

    export default {
        name: "ContentTag",
        data() {
            return {
                themes: []
            }
        },
        mounted: function () {
            getHotThemes().then(response => {
                const {data} = response;
                this.themes = data;
            })
        }
    }
</script>

<style scoped>

</style>