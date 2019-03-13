require('../css/app.scss');
require('../css/bootstrap.min.css');

const $ = require('jquery');
// this "modifies" the jquery module: adding behavior to it
// the bootstrap module doesn't export/return anything
// or you can include specific pieces
require('bootstrap');
// require('bootstrap/js/dist/popover');

$(document).ready(function() {
    $('[data-toggle="tooltip"]').tooltip();
});
