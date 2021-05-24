jQuery(document).ready(function ($) {
    'use strict';
    var $kbControl = $('#kb-nav-control'),
        $kbNavWrapper = $kbControl.parent();

    $kbControl.on('click', function(e){
        $kbNavWrapper.toggleClass('kb-mobile-hide');
    });
});
