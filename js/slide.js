//思路：1、先处理好左右两个按钮，来回切换，能够保证图片正常切换
//2、能正常来还切换之后，在来处理右下角的小圆点，跟随者图片切换来变化
//3、在切换中加上动画
//4、开启一个定时器，两秒调用一次右边按钮的onclick
//5、解决定时器和点击右边按钮以及图片切换动画定时器的冲突， 在点击按钮的时候，先停止轮播定时器和动画定时器，
//（当前有可能上一张图片动画还未完成，然后又清除了动画，所以要把图片的left值设置是当前图片距离左边距）
//6、处理远点的onmouse事件，和点击左右两个按钮一致

window.onload = function() {
  var imgs_div = document.getElementById("imgs");
  var nav_div = document.getElementById("nav");
  //获取到图片轮播的ul对象数组
  var imgsUl = imgs_div.getElementsByTagName("ul")[0];
  //获取到远点的ul对象数组
  var nav = nav_div.getElementsByTagName("ul")[0];
  //上一个
  var prious = document.getElementById("preous");
  //下一个
  var next = document.getElementById("next");
  var timer;
  var animTimer;
  var index = 1;
  play();
  // alert(document.body.clientWidth);
  prious.onclick = function() {
    initImgs(index);
    index -= 1;
    if (index < 1) {
      index = 4;
    }
    animate(1525);
    btnShow(index);
  }
  next.onclick = function() {
    initImgs(index);
    index += 1;
    if (index > 4) {
      index = 1;
    }
    animate(-1525);
    btnShow(index);
  }

  function animate(offset) {
    var newLeft = parseInt(imgsUl.offsetLeft) + offset;
    // imgsUl.style.left=newLeft;
    // console.log("定时器外面:此时offsetLeft"+imgsUl.offsetLeft+">>newLeft:"+newLeft);
    if (newLeft > -1525) {
      // imgsUl.style.left=-5120+"px";
      donghua(-6100);
    } else if (newLeft < -6100) {
      // imgsUl.style.left=-1280+"px";
      donghua(-1525);
    } else {
      donghua(newLeft);
    }

  }

  function donghua(offset) {
    clearInterval(animTimer);
    animTimer = setInterval(function() {
      imgsUl.style.left = imgsUl.offsetLeft + (offset - imgsUl.offsetLeft) / 10 + "px";
      if (imgsUl.offsetLeft - offset < 10 && imgsUl.offsetLeft - offset > -10) { //如果偏移量已经等于指定好的偏移量，则秦楚定时器
        imgsUl.style.left = offset + "px";
        clearInterval(animTimer);
        //开启定时轮播
        play();
      }
    }, 20);
  }

  function initImgs(cur_index) {
    clearInterval(timer);
    clearInterval(animTimer);
    var off = cur_index * 1525;
    imgsUl.style.left = -off + "px";
  }

  function play() {
    timer = setInterval(function() {
      next.onclick();
    }, 3000)
  }

  function btnShow(cur_index) {
    var list = nav.children;
    for (var i = 0; i < nav.children.length; i++) {
      nav.children[i].children[0].className = "hidden";
    }
    nav.children[cur_index - 1].children[0].className = "current";
  }
  for (var i = 0; i < nav.children.length; i++) {
    nav.children[i].index = i;
    var sd = nav.children[i].index;
    nav.children[i].onmouseover = function() {
      index = this.index + 1;
      initImgs(this.index + 1);
      btnShow(this.index + 1);
    }
    nav.children[i].onmouseout = function() {
      play();
    }
  }
}