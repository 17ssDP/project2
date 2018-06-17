$(document).ready(function() {
    $('.delete').click(function() {
        let artworkID = this.getAttribute('data-artworkID');
        let that = $(this);
        let totalMoney = $('#pay-bt span').html() - that.parents('.good-one').find('span').html();
        $.post('../php/shopping_cart.php', {
            'artworkID': artworkID,
            'action': "delete"
        }, function(msg) {
            if(msg) {
                that.parents('.good-one').slideUp();
                $('#pay-bt span').html(totalMoney);
            }
        });
    });
    $('#pay-bt').click(function() {
        if($('#pay-bt span').html() == 0) {
            $('.modal-body').html("<p>您的购物车还是空的</p>");
            $("#information").modal('show');
        }else {
            $.post('../php/shopping_cart.php', {
                'action': "payment",
            }, function(msg) {
                if(msg) {
                    $('.modal-body').html("<p>支付成功！</p>");
                    $('.good-one').slideUp();
                    }else {
                    $('.modal-body').html("<p>您的余额不足啦！</p>");
                    }
                    $("#information").modal('show');
                })
        }
    });
    logout();
});