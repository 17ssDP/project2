$(document).ready(function () {
    $('#name').on('focusout', function () {
        let userName = $(event.target);
        if(userName.val() == "") {
            $('#name-error').html('<p>请输入用户名</p>');
        }
    });
    $('#name').on('focusin', function () {
        $('#name-error').html('');
    });
    $('#email').on('focusout', function () {
        let reg = /^(\w)+(\.\w+)*@(\w)+((\.\w{2,3}){1,3})$/;
        if($('#email').val() == "") {
            $('#email-error').html('<p>请输入邮箱</p>');
        } else if (!reg.test($('#email').val())) {
            $('#email-error').html('<p>请输入有效的邮箱地址</p>');
        }
    });
    $('#email').on('focusin', function () {
        $('#email-error').html('');
    });
    $('#password').on('focusout', function () {
        let password = $('#password').val();
        let reg = /^\w{6,12}$/;
        if (password == "") {
            $('#password-error').html('<p>请输入密码</p>');
        } else if (!reg.test(password)) {
            $('#password-error').html('<p>密码必须为6-12位的数字、字母或下划线</p>');
        }
    });
    $('#password').on('focusin', function () {
        $('#password-error').html('');
    });
    $('#confirm_password').on('focusout', function () {
        let confirm_password = $('#confirm_password').val();
        let password = $('#password').val();
        if (confirm_password !== password) {
            $('#confirm_password-error').html('<p>密码不匹配</p>');
        }
    });
    $('#confirm_password').on('focusin', function () {
        $('#confirm_password-error').html('');
    });
    $('#phone').on('focusout', function () {
        let phone = $('#phone').val();
        let rag = /^1[3|4|5|8]\d{9}$/;
        if(phone.length == 0) {
            $('#phone-error').html('<p>请输入电话</p>')
        } else if (!rag.test(phone)) {
            $('#phone-error').html('<p>请输入正确的手机号</p>')
        }
    });
    $('#phone').on('focusin', function () {
        $('#phone-error').html('');
    })
    $('#address').on('focusout', function () {
        if($('#address').val() == "") {
            $('#address-error').html('<p>请输入地址</p>');
        }
    });
    $('#address').on('focusin', function () {
        $('#address-error').html('');
    });
    $('input[type="button"]').on('click', function () {
        //检查是否输入所有信息
        let allFilled = true;
        if($('#name').val() == "") {
            $('#name-error').html('<p>请输入用户名</p>');
            allFilled = false;
        }
        if($('#email').val() == "") {
            $('#email-error').html('<p>请输入邮箱</p>');
            allFilled = false;
        }
        if ($('#password').val() == "") {
            $('#password-error').html('<p>请输入密码</p>');
            allFilled = false;
        }
        if($('#phone').val() == "") {
            $('#phone-error').html('<p>请输入电话</p>');
            allFilled = false;
        }
        if($('#address').val() == "") {
            $('#address-error').html('<p>请输入地址</p>');
            allFilled = false;
        }
        //检查每个输入框的输入内容是否有问题
        let noError = $('#name-error').html() == "" && $('#email-error').html() == ""
                      && $('#password-error').html() == "" && $('#confirm_password-error').html() == ""
                      && $('#phone-error').html() == "" && $('#address-error').html() == "";
        //登录
        if (allFilled && noError) {
            //将表单的内容提交
            let checkName = $('#name').serialize();
            $.get('../php/user_exist.php', checkName, function (exist) {
                if(exist) {
                    $('#name-error').html('<p>用户名已经存在</p>');
                } else {
                    $('form').submit();
                }
            });
        }
    });
});