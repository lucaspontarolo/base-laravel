/**
 *
 * You can write your JS code here, DO NOT touch the default style file
 * because it will make it harder for you to update.
 *
 */

"use strict";

/** Global */
$(function () {
    bsCustomFileInput.init();

    $(".alert.alert-dismissible").fadeTo(1, 1).removeClass('hidden');
    window.setTimeout(function () {
        $(".alert.alert-dismissible").fadeTo(500, 0).slideUp(500, function () {
            $(".alert.alert-dismissible").addClass('hidden');
        });
    }, 3000);
})

