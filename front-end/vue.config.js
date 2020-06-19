const path = require('path');

function resolve(dir) {
    return path.join(__dirname, dir);
}

module.exports = {
    productionSourceMap: false,
    chainWebpack: config => {
        config.resolve.alias
            .set('@', resolve('src'))
    },

    devServer: {
        port: 8088,
        proxy: {
            '/api': {
                ws: true,
                target: 'http://travels.996icu.today/',
                // target: 'http://photosite.test',
                changeOrigin: true,
                pathRewrite: {
                    '^/api': '/api'
                }
            }
        }
    }
};
