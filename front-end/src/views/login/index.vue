<template>
    <div class="container">
        <div class="row">
            <div class="col-sm-6 col-md-4 offset-md-4">
                <h1 class="text-center login-title">Log in to continue to Travels</h1>
                <div class="account-wall">
                    <img class="profile-img" src="https://lh5.googleusercontent.com/-b0-k99FZlyE/AAAAAAAAAAI/AAAAAAAAAAA/eu7opA4byxI/photo.jpg?sz=120"
                         alt="">
                    <form class="form-signin">
                        <label for="username">Username:</label>
                        <input type="text" v-model="form.username" class="form-control" id="username" placeholder="Username" required autofocus>
                        <label for="pwd">Password:</label>
                        <input v-model="form.password" type="password" class="form-control" id="pwd" placeholder="Password" required>
                        <button class="btn btn-md btn-primary" @click="handleLogin">
                            Log in</button>
                    </form>
                </div>
                 <router-link :to="{path: '/register'}" class="text-center new-account" tag="a">Create an account </router-link>
            </div>
        </div>
    </div>
<!--    <div class="login_form">-->
<!--        <div class="card-header bg-info">-->
<!--            <h2>Login here</h2>-->
<!--        </div>-->
<!--        <form style="padding: 20px">-->
<!--            <div class="form-group" >-->
<!--                <label for="username">Username:</label>-->
<!--                <input type="text" class="form-control" placeholder="Enter username" id="username" v-model="form.username">-->
<!--            </div>-->
<!--            <div class="form-group">-->
<!--                <label for="pwd">Password:</label>-->
<!--                <input type="password" class="form-control" placeholder="Enter password" id="pwd" v-model="form.password">-->
<!--            </div>-->
<!--            <button type="button" class="btn btn-primary" @click="handleLogin">Login</button>-->
<!--            <button type="reset" class="btn btn-danger">Reset</button>-->
<!--        </form>-->
<!--    </div>-->

</template>

<script>
    export default {
        name: "index",
        data() {
            return {
                form: {
                    username: "",
                    password: "",
                },
            }
        },

        methods: {
            handleLogin() {
                this.$store.dispatch('user/login', this.form).then(()=> {
                    this.$router.push('/');
                }).catch(error => {
                    console.log(error)
                    // alert(error)
                })
            },
        }
    }
</script>

<style scoped>
    .login_form {
        background: lightgoldenrodyellow;
        width: 30%;
        margin: 8rem auto;
    }

    .form-signin
    {
        padding: 15px;
        margin: 0 auto;
    }
    .form-signin button{
        margin: 20px auto;
    }
    .form-signin label {
        padding: 10px;
    }
    .form-signin .form-control
    {
        position: relative;
        font-size: 16px;
        height: auto;
        padding: 10px;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
    }
    .form-signin .form-control:focus
    {
        z-index: 2;
    }
    .account-wall
    {
        margin-top: 20px;
        padding: 40px 0 20px 0;
        background-color: #f7f7f7;
        -moz-box-shadow: 0 2px 2px rgba(0, 0, 0, 0.3);
        -webkit-box-shadow: 0 2px 2px rgba(0, 0, 0, 0.3);
        box-shadow: 0 2px 2px rgba(0, 0, 0, 0.3);
    }
    .login-title
    {
        color: #555;
        font-size: 18px;
        font-weight: 400;
        display: block;
    }
    .profile-img
    {
        width: 96px;
        height: 96px;
        margin: 0 auto 10px;
        display: block;
        -moz-border-radius: 50%;
        -webkit-border-radius: 50%;
        border-radius: 50%;
    }
    .new-account
    {
        display: block;
        margin-top: 10px;
    }
</style>