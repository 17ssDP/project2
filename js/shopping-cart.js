$(document).ready(function() {
    getShoppingCart();
    logout();
});
function getShoppingCart() {
    $.ajax({
        url: '../php/shopping_cart.php',
        type: 'POST',
        dataType: 'json',
        data: {
            'action': 'getShoppingCart',
        },
    })
        .done(function(data) {
            $('section').html(data['html']);
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
                }else if(checkArtworks()){
                    $('.modal-body').html("<p>您的购物车中有已售出的商品！</p>");
                    $("#information").modal('show');
                } else {
                    $.post('../php/shopping_cart.php', {
                        'action': "payment",
                    }, function(msg) {
                        if(msg) {
                            $('.modal-body').html("<p>支付成功！</p>");
                            $('.good-one').slideUp();
                            $('#pay-bt span').html(0);
                        }else {
                            $('.modal-body').html("<p>您的余额不足啦！</p>");
                        }
                        $("#information").modal('show');
                    })
                }
            });
            search();
        });
}
function checkArtworks() {
    let haveSoldArtworks = false;
    for(let i = 0; i < $('.state').length; i++ ){
        if($('.state').eq(i).html() != "未售出") {
            haveSoldArtworks = true;
        };
    }
    return haveSoldArtworks;
}