<template>
  <div class="container">
    <div class="card">
      <div class="card-title h2">About Programming</div>
      <div class="card-text">
        <h4>Technology Stack</h4>
        <ul>
          <li>
            Programming skills: J2SE, Vuejs, html5+css+javascript, JavaSpark
          </li>
          <li>
            Database: MySQL, Redis
          </li>
        </ul>
        <h4>Projects Experience</h4>
        <ul>
          <li>
            Course System(springboot + vuejs)
          </li>
          <li>
            Blog Website(springboot + vuejs)
          </li>
        </ul>
        <h4>English</h4>
        <ul>
          <li>CET-4</li>
          <li>CET-6</li>
        </ul>
      </div>
      <a href="https://github.com/proton991" class="card-link">Github Link</a>
    </div>
    <div class="card">
      <div class="card-title h2">Education</div>
      <div class="card-subtitle">Majoring in Software Engineering at Fudan University</div>
      <div class="card-text">
        I am a junior now, a nobody doing trivial things, hoping that I could make a difference someday.
      </div>
    </div>
  </div>
</template>

<script>
    export default {
        name: "developerInfo",
        data() {
            return {
                items: [
                    { Skill: 40,  },
                ]
            }
        }
    }
</script>

<style scoped>
  .container {
    /*padding-top: 195px;*/
    /*height: 100%;*/
    /*margin-top: 40px;*/
    padding-top: 5%;
    bottom: 0;
    right: 0;
    left: 0;
    min-width: 50%;
    box-sizing: border-box;
    min-height: 100%;
    width: 100%;
    position: absolute;
    background: whitesmoke;
  }

</style>
