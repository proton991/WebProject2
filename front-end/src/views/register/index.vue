<template>
    <div class="container">
        <div class="row">
            <div class="col-sm-6 col-md-4 offset-md-4">
                <h1 class="text-center login-title">Create An Account for free!</h1>
                <div class="account-wall">
                    <img class="profile-img" src="https://lh5.googleusercontent.com/-b0-k99FZlyE/AAAAAAAAAAI/AAAAAAAAAAA/eu7opA4byxI/photo.jpg?sz=120"
                         alt="">
                    <form class="form-signup">
                        <label for="username">Username:</label>
                        <input type="text" v-model="form.username" class="form-control" id="username" placeholder="Username" required autofocus>
                        <label for="pwd">Password:</label>
                        <input v-model="form.password" type="password" class="form-control" id="pwd" placeholder="Password" required>
                        <label for="re-pwd">Password Again:</label>
                        <input v-model="repassword" type="password" class="form-control" id="re-pwd" placeholder="Password" required>
                        <button class="btn btn-md btn-primary" @click="handleRegister">
                            Sign up</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import {register} from "@/api/user";
    import {Message} from "element-ui";

    export default {
        name: "index",
        data() {
            return {
                form: {
                    username: "",
                    password: "",

                },
                repassword: "",
            }
        },

        methods: {
            handleRegister() {
                if (this.form.password === this.repassword) {
                    register(this.form).then(response => {
                        if (response.code === 200) {
                            Message({
                                message: "register success!",
                                type: "success",
                                duration: 5 * 1000
                            });
                        }
                    })

                } else {
                    Message({
                        message: "两次输入密码不相同,请重新输入",
                        type: "error",
                        duration: 5 * 1000
                    });

                }

            },
        }
    }
</script>

<style scoped>

    .form-signup
    {
        padding: 15px;
        margin: 0 auto;
    }
    .form-signup button{
        margin: 20px auto;
    }
    .form-signup label {
        padding: 10px;
    }
    .form-signup .form-control
    {
        position: relative;
        font-size: 16px;
        height: auto;
        padding: 10px;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
    }
    .form-signup .form-control:focus
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
</style>
