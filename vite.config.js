import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import path from 'path';
import dotenv from 'dotenv';

export default defineConfig(() => {
    const isDevCommantRunOnClient = process.env.INIT_CWD.includes('client');

    const env = dotenv.config({
        path: path.join(
            process.env.INIT_CWD,
            `${isDevCommantRunOnClient ? '../' : ''}.env`,
        ),
    });

    const frontendEnvs = ['APP_URL'];

    const clientEnv = Object.entries(env.parsed)
        .filter(([key, _]) => frontendEnvs.includes(key))
        .reduce(
            (clientEnv, [key, value]) => ({ ...clientEnv, [key]: value }),
            {},
        );

    return {
        plugins: [
            laravel({
                input: ['resources/js/app.js'],
                refresh: true,
            }),
            vue({
                template: {
                    transformAssetUrls: {
                        // The Vue plugin will re-write asset URLs, when referenced
                        // in Single File Components, to point to the Laravel web
                        // server. Setting this to `null` allows the Laravel plugin
                        // to instead re-write asset URLs to point to the Vite
                        // server instead.
                        base: null,

                        // The Vue plugin will parse absolute URLs and treat them
                        // as absolute paths to files on disk. Setting this to
                        // `false` will leave absolute URLs un-touched so they can
                        // reference assets in the public directory as expected.
                        includeAbsolute: false,
                    },
                },
            }),
        ],
        define: {
            'process.env': clientEnv,
        },
    };
});
