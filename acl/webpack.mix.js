let mix = require("laravel-mix");

const path = require("path");
let directory = path.basename(path.resolve(__dirname));

const source = "core/" + directory;
const dist = "public/vendor/core/core/" + directory;

mix.js(source + "/resources/assets/js/profile.js", dist + "/js")
    .js(source + "/resources/assets/js/login.js", dist + "/js")
    .js(source + "/resources/assets/js/role.js", dist + "/js")

    .sass(source + "/resources/assets/sass/login.scss", dist + "/css")

    .copyDirectory(
        source + "/resources/assets/css/animate.min.css",
        dist + "/css/animate.min.css"
    )
    .copyDirectory(dist + "/js", source + "/public/js")
    .copyDirectory(dist + "/css", source + "/public/css");
