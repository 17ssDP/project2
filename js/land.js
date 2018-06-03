$(document).ready(function() {
  BoxInit.init();
  code();
  check();
});
let clear = function() {
    $("#username").val('');
    $('#password').val('');
    $('#code').val('');
    $("#name-error").html("");
    $("#password-error").html("");
    $("#code-error").html("");
};
function check() {
    $('#username').focusout( function () {
        if($('#username').val() == "") {
            $('#name-error').html('<p>请输入用户名</p>');
        }
    });
    $('#username').focusin( function () {
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
        if ($('#code').val() == ""){
            $('#code-error').html('<p>请输入验证码</p>');
        } else if($('#code').val().toUpperCase() != $('.code').text()) {
            $('#code-error').html('<p>验证码不正确</p>');
        }
    });
    $('#code').focusin(function () {
        $('#code-error').html('');
    })
}
let code = function() {
  //随机生成验证码
  function createCode() {
    code = ''; //首先默认code为空字符串
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
};
let BoxInit = {
  wWidth: undefined, //浏览器宽度
  wHeight: undefined, //浏览器高度
  show: undefined, //显示按钮
  box: undefined, //弹窗遮盖属性
  boxContent: undefined, //弹窗属性
  closeBox: undefined, //关闭按钮属性
  loginBtn: undefined, //登录按钮属性
  init: function() {
    var self = this;
    //获取控件对象
    self.show = $("#show");
    self.box = $(".box");
    self.boxContent = $(".box_content");
    self.closeBox = $("#close");
    self.loginBtn = $("#button");
    //获取浏览器可视化的宽高
    self.wWidth = $(window).width();
    self.wHeight = $(window).height();
    //绑定显示按钮点击事件
    self.show.click(function() {
      self.showBtn()
    });
    //绑定关闭按钮事件
    self.closeBox.click(function() {
      self.closes()
    });
    //绑定登录按钮
    self.loginBtn.click(function() {
      self.login()
    });
    //DIV拖拽
    self.dragDrop();
    // //调用控制提示信息
    // self.controlPromptInfo();
  },
  /**
   *显示按钮
   */
  showBtn: function() {
    clear();
    var self = this;
    self.box.animate({
      "width": self.wWidth,
      "height": self.wHeight
    }, function() {
      //设置弹窗的位置
      self.boxContent.animate({
        "left": (self.wWidth - self.boxContent.width()) / 2
      }, function() {
        $(this).animate({
          "top": (self.wHeight - self.boxContent.height()) / 2
        });
      });
    });
  },
  /**
   *关闭按钮
   */
  closes: function() {
    let self = this;
    self.boxContent.animate({
      "top": 0
    }, function() {
      $(this).animate({
        "left": -(self.wWidth - self.boxContent.width()) / 2
      }, function() {
        self.box.animate({
          "width": -self.wWidth,
          "height": -self.wHeight
        });
      });
    });
  },
  /**
   *登录按钮
   */
  login: function() {
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
                  this.closes();
                  $('form').submit();
              }
          });
      }
  },
  /**
   *拖拽弹窗
   */
  dragDrop: function() {
    var self = this;
    var move = false; //标识是否移动元素
    var offsetX = 0; //弹窗到浏览器left的宽度
    var offsetY = 0; //弹出到浏览器top的宽度
    var title = $(".title");
    //鼠标按下事件
    title.mousedown(function() {
      move = true; //当鼠标按在该div上的时间将move属性设置为true
      offsetX = event.offsetX; //获取鼠标在当前窗口的相对偏移位置的Left值并赋值给offsetX
      offsetY = event.offsetY; //获取鼠标在当前窗口的相对偏移位置的Top值并赋值给offsetY
      title.css({
        "cursor": "move"
      });
    }).mouseup(function() {
      //当鼠标松开的时候将move属性摄hi为false
      move = false;
    });
    $(document).mousemove(function() {
      if (!move) { //如果move属性不为true，就不执行下面的代码
        return;
      }
      //move为true的时候执行下面代码
      var x = event.clientX - offsetX; //event.clientX得到鼠标相对于客户端正文区域的偏移，然后减去offsetX即得到当前推拽元素相对于当前窗口的X值（减去鼠标刚开始拖动的时候在当前窗口的偏移X）
      var y = event.clientY - offsetY; //event.clientY得到鼠标相对于客户端正文区域的偏移，然后减去offsetX即得到当前推拽元素相对于当前窗口的Y值（减去鼠标刚开始拖动的时候在当前窗口的偏移Y）
      if (!(x < 0 || y < 0 || x > (self.wWidth - self.boxContent.width()) || y > (self.wHeight - self.boxContent.height()))) {
        self.boxContent.css({
          "left": x,
          "top": y,
          "cursor": "move"
        });
      }
    });
  },
  // /**
  //  *控制提示信息
  //  */
  // controlPromptInfo: function() {
  //   //遍历提示信息，并点击
  //   $("p[class*=prompt]").each(function() {
  //     var pro = $(this);
  //     pro.click(function() {
  //       //点击提示信息自身隐藏，文本框获取焦点
  //       pro.hide().siblings("input").focus();
  //     });
  //   });
  //   //遍历文本框
  //   $("input[class*=ins]").each(function() {
  //     var input = $(this);
  //     //文本框失去焦点
  //     input.blur(function() {
  //       //如果文本框值为空
  //       if (input.val() == "") {
  //         //显示提示信息
  //         input.siblings(".prompt").show();
  //       }
  //     }).keyup(function() { //按键抬起的时候
  //       if (input.val() == "") { //如果文本框值为空
  //         //文本框失去焦点显示提示信息
  //         input.blur().siblings(".prompt").show();
  //       } else {
  //         //提示信息隐藏
  //         input.siblings(".prompt").hide();
  //       }
  //     });
  //   });
  // }
};