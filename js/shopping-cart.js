$(document).ready(function() {
  $('#new-todo, #pay').dialog({
    modal: true,
    autoOpen: false,
    buttons: {
      "确定": function() {
        $(this).dialog('close');
      }
    }
  });
  $('.delete').click(function() {
    $('#new-todo').dialog('open');
    $(this).parents('.good-one').css("display", "none");
  });
  $('#pay-bt').click(function() {
    $('#pay').dialog('open');
  });
});