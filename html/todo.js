$(document).ready(function(e) {
  $('a[class*="add"]').click(function() {
    $('#new-todo').dialog('open');
  });
  $('#new-todo').dialog({
    modal: true,
    autoOpen: false,
    buttons: {
      "确定": function() {
        $(this).dialog('close');
      }
    }
  });
}); // end ready