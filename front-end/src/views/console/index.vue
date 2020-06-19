<template>
    <div id="console_container">
    </div>
</template>

<script>
    export default {
        name: "index",
        data() {
            return {
                Category: '',
            }
        },
    }
</script>

<style scoped>
    @media only screen and (min-width: 900px)  {
        #console_container {
            margin: 5rem auto;
            width: 60%;
            background-color: whitesmoke;
        }
    }

</style>
