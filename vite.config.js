import {defineConfig} from 'vite';
import laravel from 'laravel-vite-plugin';
import collectModuleAssetsPaths from './vite-module-loader.js';

async function getConfig() {
    const paths = [
        'public/css/fonts.css',
        'resources/css/app.css',
        'public/css/select2.min.css',
        'public/css/bootstrap.min.css',
        'public/css/mCustomScrollbar.min.css',
        'public/admin/css/themify-icons.css',
        'public/admin/css/feather-icons.css',
        'public/admin/css/main.css',
        'public/css/fontawesome.min.css',
        'public/css/main.css',
        'public/css/croppie.css',
        'public/summernote/summernote-lite.min.css',
        'public/css/venobox.min.css',
        'public/css/flags.css',
        'public/css/videojs.css',
        'public/css/icomoon/style.css',
        'public/admin/css/themify-icons.css',
        'public/admin/css/fontawesome/all.min.css',
        'public/admin/css/feather-icons.css',
        'public/admin/css/main.css',
        'public/css/splide.min.css',
        'public/css/flatpicker.css',
        'public/css/flatpicker-month-year-plugin.css',
        'public/css/aos.min.css',
        'public/css/combotree.css',
        'public/css/colors-variation/home-two.css',
        'public/css/colors-variation/home-three.css',
        'public/css/colors-variation/home-four.css',
        'public/css/colors-variation/home-five.css',
        'public/css/colors-variation/home-six.css',
        'public/css/colors-variation/home-seven.css',
        'public/css/colors-variation/home-nine.css',

        'public/js/video.min.js',
        'public/js/main.js',
        'public/js/jquery.min.js',
        'public/js/select2.min.js',
        'public/js/bootstrap.min.js',
        'public/js/chart.js',
        'public/js/sortable.js',
        'public/js/jquery.nestable.min.js',

        'public/admin/css/daterangepicker.css'
    ];
    const allPaths = await collectModuleAssetsPaths(paths, 'Modules');

    return defineConfig({
        plugins: [
            laravel({
                input: allPaths,
                refresh: true,
            })
        ]
    });
}

export default getConfig();