<template>
    <div class="container">
        <header style="border-bottom: 2px solid black; background: green">
            <h2 style="text-align: center">Upload</h2>
        </header>
        <div class="file-upload">
            <button class="file-upload-btn" type="button" onclick="$('.file-upload-input').trigger( 'click' )">Add Image
            </button>
            <div class="image-upload-wrap">
                <input class="file-upload-input" type='file' @change="getFile($event)" accept="image/*"/>
                <div class="drag-text">
                    <h3>Drag and drop a file or select add Image</h3>
                </div>
            </div>
            <div class="file-upload-content" v-show="file!==''">
                <img class="file-upload-image" src="#" alt="your image" ref="uploadImg"/>
                <div class="image-title-wrap">
                    <button type="button" @click="removeUpload()" class="remove-image">Remove <span class="image-title">Uploaded Image</span>
                    </button>
                </div>
            </div>
        </div>
        <form>
            <div class="upload__form">
                <label for="upload_title"><b>Title</b></label>
                <input type="text" id="upload_title">
                <label for="upload_description"><b>Description</b></label>
                <textarea id="upload_description" rows="5"/>
                <label for="upload_country"><b>Country</b></label>
                <input type="text" id="upload_country">
                <label for="upload_city"><b>City</b></label>
                <input type="text" id="upload_city">
            </div>
            <button class="btn-success btn-lg" @click="submit($event)">提交</button>
        </form>
    </div>
</template>
<script>
    import {uploadPhoto} from "@/api/upload";

    export default {
        name: 'HelloWorld',
        data() {
            return {
                imgUrl: '',
                file: '',
            }
        },
        methods: {
            removeUpload() {
                this.file = '';
                console.log(this.file);
                let preview = this.$refs.uploadImg;
                preview.src = "#";
            },
            getFile: function (event) {
                let preview = this.$refs.uploadImg;
                let fr = new FileReader();
                fr.onload = function () {
                    preview.src = fr.result;
                };
                fr.readAsDataURL(event.target.files[0]);
                this.file = event.target.files[0];
                this.$refs.uploadImg = preview;
                console.log(this.$refs.uploadImg.src);
            },
            submit: function (event) {
                //阻止元素发生默认的行为
                event.preventDefault();
                let formData = new FormData();
                formData.append("file", this.file);
                uploadPhoto(formData).then(response => {
                    alert(response.message);
                    this.removeUpload();
                });
            }
        }
    }
</script>
<style scoped>

    .btn-success {
        width: 100%;
    }

    .file-upload {
        background-color: #ffffff;
        width: 800px;
        margin: 20px auto;
    }

    .file-upload-btn {
        width: 100%;
        margin: 0;
        color: #fff;
        background: #1FB264;
        border: none;
        padding: 10px;
        border-radius: 4px;
        border-bottom: 4px solid #15824B;
        transition: all .2s ease;
        outline: none;
        text-transform: uppercase;
        font-weight: 700;
    }

    .file-upload-btn:hover {
        background: #1AA059;
        color: #ffffff;
        transition: all .2s ease;
        cursor: pointer;
    }

    .file-upload-btn:active {
        border: 0;
        transition: all .2s ease;
    }

    .file-upload-content {
        text-align: center;
    }

    .file-upload-input {
        position: absolute;
        margin: 0;
        padding: 0;
        width: 100%;
        height: 100%;
        outline: none;
        opacity: 0;
        cursor: pointer;
    }

    .image-upload-wrap {
        margin-top: 20px;
        border: 4px dashed #1FB264;
        position: relative;
    }

    .image-dropping,
    .image-upload-wrap:hover {
        background-color: #1FB264;
        border: 4px dashed #ffffff;
    }

    .image-title-wrap {
        padding: 0 15px 15px 15px;
        color: #222;
    }

    .drag-text {
        text-align: center;
    }

    .drag-text h3 {
        font-weight: 100;
        text-transform: uppercase;
        color: #15824B;
        padding: 60px 0;
    }

    .file-upload-image {
        max-height: 200px;
        max-width: 200px;
        margin: auto;
        padding: 20px;
    }

    .remove-image {
        width: 200px;
        margin: 0;
        color: #fff;
        background: #cd4535;
        border: none;
        padding: 10px;
        border-radius: 4px;
        border-bottom: 4px solid #b02818;
        transition: all .2s ease;
        outline: none;
        text-transform: uppercase;
        font-weight: 700;
    }

    .remove-image:hover {
        background: #c13b2a;
        color: #ffffff;
        transition: all .2s ease;
        cursor: pointer;
    }

    .remove-image:active {
        border: 0;
        transition: all .2s ease;
    }

    .container {
        margin: 50px auto;
        width: 820px;
        background-color: wheat;
    }

    .upload__form {
        padding: 20px;
        font-size: 20px;
    }

    input {
        font-size: 20px;
        width: 100%;
        padding: 12px 20px;
        margin: 8px 0;
        display: inline-block;
        border: 1px solid #ccc;
        box-sizing: border-box;
    }

    textarea {
        font-size: 20px;
        width: 100%;
        margin: 8px 0;
        padding: 12px 20px;
        display: inline-block;
        box-sizing: border-box;
    }
</style>