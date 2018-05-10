jQuery(function($) {
// configure
var comment_input = $( '#commentform textarea' );
var submit_button = $( '#commentform .form-submit' );
var comment_limit_chars = 1000;
// stop editing here
// display how many characters are left
$( '<div class="comment_limit_info">Осталось <span>' + comment_limit_chars + '</span> символов</div>' ).insertAfter( comment_input );
comment_input.bind( 'keyup', function() {
// calculate characters left
var comment_length = $(this).val().length;
var chars_left = comment_limit_chars - comment_length;
// display characters left
$( '.comment_limit_info span' ).html( chars_left );
// hide submit button if too many chars were used
if (submit_button)
( chars_left < 0 ) ? submit_button.hide() : submit_button.show();
});
});
