$(document).ready(function() {
  $('#new-todo').dialog({
    modal: true,
    autoOpen: false,
    buttons: {
      "确定": function() {
        $(this).dialog('close');
        $('.add-wish i').removeClass('fa fa-heart-o');
        $('.add-wish i').addClass('fa fa-heart');
      }
    }
  });
  $('#recharge').click(function() {
    $('#new-todo').dialog('open');
  });
});