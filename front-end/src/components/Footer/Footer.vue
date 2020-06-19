<template>
    <footer class="footer">
        <div class="footer-top">
            <div class="f1">
                <ul>
                    <li>使用条款</li>
                    <li>隐私保护</li>
                    <li>Cookie</li>
                </ul>
            </div>
            <div class="f2">
                <ul>
                    <router-link
                            style="cursor: pointer"
                            tag="li"
                            :to="{path: '/contactMe'}"
                    >
                        联系我
                    </router-link>
                    <router-link
                            style="cursor: pointer"
                            tag="li"
                            :to="{path: '/aboutMe'}"
                    >
                        关于
                    </router-link>
                </ul>
            </div>
            <div class="f3">
                <ul>
                    <li>二</li>
                    <li>维</li>
                    <li>码</li>
                </ul>

            </div>
        </div>
        <div class="footer-btm">
            <a href="http://www.beian.miit.gov.cn" target="_blank">
                Copyright&copy;2020-2021 With All Rights Reserved 冀ICP备20003779号-1
            </a>
        </div>
    </footer>
</template>

<script>
    export default {
        name: "Footer"
    }
</script>

<style scoped>
    .footer {
        padding: 10px;
        position: relative;
        color: white;
        height: 180px;
        background: black;
        margin-top: -180px;
        clear: both;
    }

    .footer-top {
        display: flex;
        color: white;
        justify-content: space-around;
    }
    .footer div ul {
        list-style: none;
    }
    .footer div ul li {

        padding: 10px 0;
    }
    .footer-btm {
        color: whitesmoke;
        text-align: center;
    }
</style>