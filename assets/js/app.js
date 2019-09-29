/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you require will output into a single css file (app.css in this case)
require('../css/app.css');

// Need jQuery? Install it with "yarn add jquery", then uncomment to require it.
// const $ = require('jquery');

console.log('Hello Alexander, you are now using Webpack Encore!' +
'Edit me in assets/js/app.js and with a \"npm run watch\" I will take care of the rest');
// app.js

var $ = require('jquery');
// this "modifies" the jquery module: adding behavior to it
// the bootstrap module doesn't export/return anything
require('bootstrap');

var greet = require('./greet');
// or you can include specific pieces
// require('bootstrap/js/dist/tooltip');
// require('bootstrap/js/dist/popover');

var switch_category =  (function() {   
    let parent_category_id = $("#parent_category option:selected").val();
    $.ajax({
        url: "api/getcategoryid",
        data: {parent_id: parent_category_id},
        method: "POST",
        success: function(data){
            obj = JSON.parse(data);
            var options;
    
            for(var k in obj.data){
                if(obj.data.hasOwnProperty(k)){
                    options += '<option value="' + k + '">' + obj.data[k] + '</options>';
                }
            }
            $('#category_id').empty().append(options);
        }
    });
});    

$(document).ready(function() {

    $('#parent_category_id').change(function () {
       switch_category();
    });
    
    switch_category();

});