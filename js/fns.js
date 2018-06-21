//检查登录信息
function land() {
    code();
    check();
    $('#button').click(function (){
        //检查是否输入所有信息
        let allFilled = true;
        if($('#username').val() == "") {
            $('#name-error').html('<p>请输入用户名</p>');
            allFilled = false;
        }
        if ($('#password').val() == "") {
            $('#password-error').html('<p>请输入密码</p>');
            allFilled = false;
        }
        if($('#code').val() == "") {
            $('#code-error').html('<p>请输入验证码</p>');
            allFilled = false;
        }
        //检查每个输入框的输入内容是否有问题
        let noError = $('#name-error').html() == "" && $('#password-error').html() == "" && $('#code-error').html() == "";
        //登录
        if (allFilled && noError) {
            //检查用户是否存在或密码是否正确
            $.post('../php/login_check.php', {
                'username': $('#username').val(),
                'password': $('#password').val()
            }, function(result) {
                if(!result) {
                    $('#name-error').html('<p>用户不存在或密码错误</p>');
                } else {
                    $('.modal-title').html('登录成功!');
                    $('.modal-title').addClass("login-succeed");
                    setTimeout(function(){ location.reload();$("#land").modal('hide');},400);
                }
            });
        }
    });
    $('#close').click(function(){
        $("#username").val('');
        $('#password').val('');
        $('#code').val('');
        $("#name-error").html("");
        $("#password-error").html("");
        $("#code-error").html("");
    });
}
//生成验证码
function code(){
    //随机生成验证码
    function createCode() {
        let code = ''; //首先默认code为空字符串
        let codeLength = 4; //设置长度
        let codeV = $(".code");
        //设置随机字符
        let random = new Array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');
        for (var i = 0; i < codeLength; i++) { //循环codeLength
            let index = Math.floor(Math.random() * 36); //设置随机数范围,这设置为0 ~ 36
            code += random[index]; //字符串拼接 将每次随机的字符 进行拼接
        }
        codeV.text(code); //将拼接好的字符串赋值给展示的Value
    }
    //页面开始加载验证码
    createCode();
    //验证码Div加载点击事件
    $(".code").bind('click', function() {
        createCode();
    });
}
//实时检查填写情况
function check(){
    $('#username').focusout(function () {
        if ($('#username').val() == "") {
            $('#name-error').html('<p>请输入用户名</p>');
        }
    });
    $('#username').focusin(function () {
        $('#name-error').html('');
    });
    $('#password').focusout(function () {
        let password = $('#password').val();
        let reg = /^\w{6,12}$/;
        if (password == "") {
            $('#password-error').html('<p>请输入密码</p>');
        } else if (!reg.test(password)) {
            $('#password-error').html('<p>密码必须为6-12位的数字、字母或下划线</p>');
        }
    });
    $('#password').focusin(function () {
        $('#password-error').html('');
    });
    $('#code').focusout(function () {
        if ($('#code').val() == "") {
            $('#code-error').html('<p>请输入验证码</p>');
        } else if ($('#code').val().toUpperCase() != $('.code').text()) {
            $('#code-error').html('<p>验证码不正确</p>');
        }
    });
    $('#code').focusin(function () {
        $('#code-error').html('');
    });
}
//判断是否登录
function haveLogin() {
    $.post('../php/haveLogin.php', {
       'action': "check"
    }, function (msg) {
        return msg;
    });
}
//登出
function logout() {
    $('#logout').click(function() {
        $.post('logout.php', {
           'action': "logout"
        }, function (msg) {
            if(msg) {
                window.location.href='entrance.php';
            }
        });
    });
}
//搜索框的跳转
function search() {
    $('.searchButton').click(function() {
        let searchInfor = $('.searchImage').val();
        window.location.href= "../php/search.php?information=" + searchInfor;
    });
}
//发布艺术品
function publishArtworks() {
    $('.publish').click(function(event) {
        event.preventDefault();
        $.post('haveLogin.php', {
            'action': "check"
        }, function(msg) {
            if(msg) {
                window.location.href = "publish_artwork.php";
            }else {
                $("#land").modal('show');
                land();
            }
        });
    });
}