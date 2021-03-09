module.exports = {
    pages: {
        index: {
            entry: 'vue/app.js',
            template: 'public/index.html',
            filename: 'index.html',
            title: 'Index Page',
            chunks: ['chunk-vendors', 'chunk-common', 'index']
        },
        subpage: 'vue/app.js'
    }
}