require('../css/app.scss');

const $ = require('jquery');
const Dropzone = require("dropzone");

// Disable auto discover for all elements:
Dropzone.autoDiscover = false;

$(function() {
    var myDropzone = new Dropzone(".dropzone");
    myDropzone.on("success", function(file, response) {
        $("#upload-path").html("You upload directory is: <a href=\"" + response.dir + "\" target=\"_blank\" class=\"alert-link\">" + response.url +"</a>").slideDown();
    });
})
