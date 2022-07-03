let mix = require("laravel-mix");

const path = require("path");
let directory = path.basename(path.resolve(__dirname));

const source = "core/" + directory;
const dist = "public/vendor/core/core/" + directory;

mix.js(source + "/resources/assets/js/setting.js", dist + "/js").vue({
    version: 2,
});

mix.sass(source + "/resources/assets/sass/setting.scss", dist + "/css")

    .copy(dist + "/js/setting.js", source + "/public/js")
    .copy(dist + "/css/setting.css", source + "/public/css");
