/*
// First login showcase script.
//
// Dependencies: jQuery.
//
*/

$(document).ready(function () {
  $('.tap-target').tapTarget('open');
  setTimeout(function () {
    $('.tap-target').tapTarget('close');
  }, mAtime_long);
});
