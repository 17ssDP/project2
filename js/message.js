$(document).ready(function() {
    $('#message').focusin(function() {
        $('.message_error').html("");
        $('.sendSuccess').html('');
    });
    $('#letterReceiver').focusin(function() {
        $('.receiver_error').html("");
        $('.sendSuccess').html('');
    });
    $('.unread').click(function() {
        let messageID = this.getAttribute("data-messageID");
        let that = $(this);
        that.find('i').attr('class','fa fa-envelope-open-o');
        $.post('deal_message.php', {
            "action": "changeState",
            "messageID": messageID
        }, function (data) {

        });
    });
    $('.delete-receive').click(function() {
        let messageID = this.getAttribute('data-messageID');
        $.post('deal_message.php', {
            "action": "delete-receive",
            "messageID": messageID
        }, function(msg) {
            if(msg) {
                location.reload();
    }
        });
    });
    $('.delete-send').click(function() {
        let messageID = this.getAttribute('data-messageID');
        $.post('deal_message.php', {
            "action": "delete-send",
            "messageID": messageID
        }, function(msg) {
            if(msg) {
                location.reload();
            }
        });
    });
    $('#sendLetter').click(function() {
        //检查是否填写完整
        let allFilled = true;
        if($('#message').val() == "") {
            $('.message_error').html("请输入信息内容");
            allFilled = false;
        }
        if($('#letterReceiver').val() == "") {
            $('.receiver_error').html("请输入收件人");
            allFilled = false;
        }
        if(allFilled) {
            let message = $('#message').val();
            let receiver = $('#letterReceiver').val();
            $.post('deal_message.php', {
                "action": "send-message",
                "message": message,
                "receiver": receiver,
            }, function(msg) {
                if(msg) {
                    $('.sendSuccess').html('发送成功！');
                    location.reload();
                }else{
                    $('.sendSuccess').html('发送失败！');
                }
            });
        }
    });
    logout();
    search();
});