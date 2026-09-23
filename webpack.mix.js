// Filter semua pesan yang mengandung "Deprecation Warning"
const origWrite = process.stderr.write;
process.stderr.write = (chunk, encoding, callback) => {
    if (chunk.toString().includes("Deprecation Warning")) return;
    return origWrite.call(process.stderr, chunk, encoding, callback);
};

const mix = require("laravel-mix");
const webpack = require("webpack"); // <--- Tambahkan baris ini

const CopyWebpackPlugin = require("copy-webpack-plugin");
const path = require("path");

const { BundleAnalyzerPlugin } = require("webpack-bundle-analyzer");

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 */

mix.js(
    "resources/views/backend/assets/js/backend-wrapper.js",
    "public/backend/js/app.js",
);
mix.sass(
    "resources/views/backend/assets/sass/backend-wrapper.scss",
    "public/backend/css/app.css",
).sourceMaps();

mix.js(
    "resources/views/frontend/assets/js/frontend-wrapper.js",
    "public/frontend/js/app.js",
);
mix.sass(
    "resources/views/frontend/assets/scss/frontend-wrapper.scss",
    "public/frontend/css/app.css",
).sourceMaps();

mix.webpackConfig({
    output: {
        publicPath: "/", // 🔥 tambahkan ini
    },
    plugins: [
        // new BundleAnalyzerPlugin({
        //     analyzerMode: "static",
        //     openAnalyzer: true,
        //     reportFilename: "bundle-report.html",
        // }),

        new webpack.ContextReplacementPlugin(/moment[/\\]locale$/, /en|id/),
        new CopyWebpackPlugin({
            patterns: [
                {
                    from: "node_modules/tinymce/skins",
                    to: "lib/tinymce/skins",
                },
                {
                    from: "node_modules/tinymce/icons",
                    to: "lib/tinymce/icons",
                },
                {
                    from: "node_modules/tinymce/themes",
                    to: "lib/tinymce/themes",
                },
                {
                    from: "node_modules/tinymce/plugins",
                    to: "lib/tinymce/plugins",
                },
                {
                    from: "node_modules/@fortawesome/fontawesome-free/webfonts",
                    to: "lib/fontawesome/webfonts",
                },
            ],
        }),
    ],
    resolve: {
        alias: {
            tinymce: path.resolve(__dirname, "node_modules/tinymce"),
        },
    },
});

if (mix.inProduction()) {
    mix.version();
}
