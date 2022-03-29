# laravel-vite (WIP)
A tiny package that adds @vite_assets blade directive and loads Vite assets.

Note to use this package, you need to manually convert your application to be ready to run vite. If running a Laravel-application, kindly follow the steps below:

1. `npm remove laravel-mix postcss-import vue-loader`
2. `npm i -D vite @vitejs/plugin-vue`
3. (optional) `npm install -D tailwindcss@latest postcss@latest autoprefixer@latest`
4. Add .vue extension to all imports. e.g `import BreezeAuthenticatedLayout from '@/Layouts/Authenticated'` changes to `import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue'`
5. In resources/js/(app.js & bootstrap.js) replace all require with import
6. Update resolveComponent in app.js accordingly


# Acknowledgements
Kindly see [Sebastian's blog](https://sebastiandedeyne.com/vite-with-laravel/) for a professionally writen step-by-step process
