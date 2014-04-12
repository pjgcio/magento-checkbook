var checkbookResponseHandler = function(status, response) {
 if (response.error) {
  // Show the errors on the form
  alert(response.error);
 } else {
  var token = response.token;
  jQuery('#checkbook_token').val(token);
  jQuery('#throbberIdSendCheck').hide();
 }
};