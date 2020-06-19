<template>
  <div class="pageContainer offset-0">
    <ul class="pagination">
      <li><a style="text-align: center;cursor: pointer" @click="prevOrNext(-1)">«</a></li>
      <li v-for="(item, index) in pages" :key="index">
        <a
            :class="{active : item === pageConfig.currentPage}"
            @click="selectPage(item)"
            style="cursor: pointer"
            v-if="item !== '...'"
        >
          {{item}}
        </a>
        <a
                style="cursor: not-allowed"
                v-if="item === '...'"
        >
          {{item}}
        </a>
      </li>
      <li><a @click="prevOrNext(1)" style="text-align: center;cursor: pointer">»</a></li>
    </ul>
  </div>
</template>

<script>
    export default {
        name: "VuePagination",
        // data() {
        //     return {
        //         currentPage: 1,
        //         totalPages: 0
        //     }
        // },
        props: {
            pageConfig: {
                type: Object,
                require: true,
                default() {
                    return {
                        pageSize: 5,
                        currentPage: 1,
                        totalPages: 0,
                        totalItems: 0
                    }
                }
            }
        },
        computed: {
            pages() {
                const config = this.pageConfig;
                if (!config.totalPages) {
                    if (config.pageSize && config.totalItems) {
                        config.totalPages = Math.ceil(config.totalItems/config.pageSize);
                    }
                    else
                        return ['...']
                }
                const c = config.currentPage;
                const t = config.totalPages;
                // total pages < 8, show them all
                if (t < 9) {
                    let list = [];
                    for (let i = 1; i < t + 1; i++) {
                        list.push(i);
                    }
                    return list;
                }
                //current Page begin
                if (c <= 4 && t >=9) {
                    return [1, 2, 3, 4, 5, 6, 7, '...', t]
                }
                // current Page last
                if (c >= t - 5 && t >= 9) {
                    let list = [1, '...'];
                    for (let i = t-6; i <= t; i++) {
                        list.push(i);
                    }
                    return list;
                }
                //current Page middle
                else {
                    let list = [1, '...'];
                    for (let i = c - 3; i <= c + 2; i++) {
                        list.push(i);
                    }
                    list.push('...');
                    list.push(t);
                    return list;
                }
                // if (c <= 5) {
                //     return [1, 2, 3, 4, 5, 6, 7, 8, 9, '...', t]
                // } else if (c >= t - 4) {
                //     return [1, '...', t - 8, t - 7, t - 6, t - 5, t - 4, t - 3, t - 3, t - 1, t]
                // } else {
                //     return [1, '...', c - 3, c - 2, c - 1, c, c + 1, c + 2, c + 3, '...', t]
                // }
            }
        },
        methods: {
            selectPage(item) {
                console.log("selectPage"+item);
                if (typeof item === 'string') {
                    return;
                }
                if (item === this.pageConfig.currentPage) return;
                // this.pageConfig.currentPage = item;
                this.$emit('change', item);
            },
            prevOrNext(n) {
                if ((this.pageConfig.currentPage === 1 && n === -1)|| (this.pageConfig.currentPage === this.pageConfig.totalPages && n === 1) )
                    return;

                // this.pageConfig.currentPage += n;
                this.$emit('change', this.pageConfig.currentPage + n);
            }
        }


    }
</script>

<style scoped>
  .pageContainer {
    /*bottom: 0;*/
    /*position: relative;*/
    font-size: 20px;
    margin-top: 20px;
    /*font-weight: bold;*/
  }

  ul.pagination {
    display: inline-block;
    /*padding: 0;*/
    /*margin: 0;*/
  }

  ul.pagination li {
    display: inline;
  }

  ul.pagination li a {
    color: black;
    float: left;
    padding: 8px 16px;
    text-decoration: none;
    transition: background-color .3s;
    border: 1px solid #ddd;
    margin: 0 4px;
  }

  ul.pagination li a.active {
    background-color: #4CAF50;
    color: white;
    border: 1px solid #4CAF50;
  }

  ul.pagination li a:hover:not(.active) {
    background-color: #ddd;
  }
</style>
