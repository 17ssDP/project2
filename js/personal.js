$(document).ready(function() {
    search();
    let balance = $('#balance').html();
    $('#money').focus(function() {
        $('#error').html("");
    });
    $('#recharge').click(function() {
        let money = $('#money').val();
        if (money == "") {
            $('#error').html("请输入您要充值的金额")
        }else if(money <= 0) {
            $('#error').html("充值的金额不能为负数或0");
        }else if(money % 1 != 0) {
            $('#error').html("充值的金额必须为正整数");
        } else {
            $.post('../php/recharge.php', {
                'money': $('#money').val()
            }, function(msg) {
                if(msg) {
                    $('.modal-body').html("<p>充值成功！</p>");
                    balance = Number(balance) + Number(money);
                    $('#balance').html(balance);
                }else {
                    $('.modal-body').html("<p>充值失败，请稍后再试</p>");
                }
            });
            $("#information").modal('show');
        }
    });
    $('.delete').click(function() {
        let artworkID = this.getAttribute('data-artworkID');
        let that = $(this);
        if(that.parents('tr').find('.state').html() == "已售出") {
            $('#confirm_delete .modal-body').html("<h3>该商品已售出</h3>")
            $('#confirm_delete button').html("关闭")
            $('#confirm_delete').modal('show');
        }else {
            $('#confirm_delete .modal-body').html("<h3>确认删除？</h3>")
            $('#confirm_delete button').html("确认")
            $('#confirm_delete').modal('show');
            $('#confirm').click(function() {
                $.post('delete_artwork.php', {
                    'artworkID': artworkID,
                }, function(msg){
                    if(msg) {
                        alert("删除成功！");
                        that.parents('tr').slideUp();
                    }else {
                        alert("删除失败！");
                    }
                });
            });
        };
    });
    $('.change').click(function() {
        let artworkID = this.getAttribute('data-artworkID');
        let that = $(this);
        if (that.parents('tr').find('.state').html() == "已售出") {
            $('#confirm_delete .modal-body').html("<h3>该商品已售出</h3>")
            $('#confirm_delete button').html("关闭")
            $('#confirm_delete').modal('show');
        } else {
            window.location.href= "../php/modify_artwork.php?id=" + artworkID;
        }
    });
    logout();
});