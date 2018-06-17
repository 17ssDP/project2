$(document).ready(function() {
    $('#addCart').click(function() {
        let that = this;
        $.post('haveLogin.php', {
            'action': "check"
        }, function(msg) {
            if(msg) {
                let artworkID = that.getAttribute('data-artworkID');
                $.post('../php/shopping_cart.php', {
                    'artworkID': artworkID,
                    'action': "add"
                }, function(msg) {
                    if(msg === "artwork already exist") {
                        $('.modal-body').html("<p>购物车中已存在该商品</p>")
                    } else if(msg === "good sold") {
                        $('.modal-body').html("<p>商品已售出</p>")
                    } else if(msg === "successfully add") {
                        $('.modal-body').html("<p>添加成功</p>")
                    } else if(msg === "fail to add") {
                        $('.modal-body').html("<p>添加失败，您可以稍后再试</p>")
                    }
                    $("#information").modal('show');
                });
            }else {
                $("#land").modal('show');
                land();
            }
        })
    });
    logout();
});