<template>
  <div class="wrapper mt-5 pt-5">
    <div class="card" id="main">
      <div class="card-title">Contact Me</div>
      <div class="card-text">
        <span class="h4"><em>Email: </em> <strong>xinyucui99@gmail.com</strong></span><br>
        <span class="h4"><em>QQ: </em> <strong>99615819</strong></span>
      </div>
    </div>
  </div>
</template>

<script>
    export default {
        name: "ContactMe"
    }
</script>

<style scoped>
  .wrapper {
    text-align: center;
    width: 50%;
    /*top: 50%;*/

    /*border-width: 1px;*/
    /*border-radius: 10px;*/
    /*border-style: solid;*/
    /*position: relative;*/
    /*background: whitesmoke;*/
  }
  #main {
    left: 50%;
    right: 50%;
    background: whitesmoke;
    /*position: absolute;*/
    /*top: 20%;*/
    /*left: 20%;*/
    /*right: 20%;*/
    /*bottom: 20%;*/
  }
</style>
