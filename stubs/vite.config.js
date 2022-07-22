import vue from '@vitejs/plugin-vue';
import path from 'path'

export default ({ command }) => ({
    base: command === 'serve' ? '' : '/build/',
    publicDir: false,
    build: {
        manifest: true,
        outDir: 'public/build',
        rollupOptions: {
            input: 'resources/js/app.js',
        },
    },
    resolve:{
        alias:{
            '@' : path.resolve(__dirname, 'resources/js')
        },
    },
    server: {
        host: '127.0.0.1'
    },
    plugins: [vue()],
});
