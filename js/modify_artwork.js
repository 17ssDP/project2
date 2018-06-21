$('document').ready(function() {
    search();
    logout();
    $('#title').focusin(function () {
        $('#title_error').html("");
    }).focusout(function () {
        if($('#title').val() == ""){
            $('#title_error').html('请输入作品的名称');
        }
    });
    $('#artist').focusin(function(){
        $('#artist_error').html("");
    }).focusout(function() {
        if($('#artist').val() == "") {
            $('#artist_error').html('请输入作品的作者');
        }
    });
    $('#description').focusin(function(){
        $('#description_error').html("");
    }).focusout(function() {
        if($('#description').val() == "") {
            $('#description_error').html('请输入作品的简介');
        }
    });
    $('#yearOfWork').focusin(function(){
        $('#yearOfWork_error').html("");
    }).focusout(function() {
        if($('#yearOfWork').val() == "") {
            $('#yearOfWork_error').html('请输入作品的年份');
        }else if(!(Number($('#yearOfWork').val()) > 0) || (Number($('#yearOfWork').val()) % 1 != 0)) {
            $('#yearOfWork_error').html('请输入正确的年份');
        }
    });
    $('#genre').focusin(function(){
        $('#genre_error').html("");
    }).focusout(function() {
        if($('#genre').val() == "") {
            $('#genre_error').html('请输入作品的流派');
        }
    });
    $('#width').focusin(function(){
        $('#width_error').html("");
    }).focusout(function() {
        if($('#width').val() == "") {
            $('#width_error').html('请输入作品的宽度');
        }else if(!(Number($('#width').val()) > 0)) {
            $('#width_error').html('宽度须为正数');
        }
    });
    $('#height').focusin(function(){
        $('#height_error').html("");
    }).focusout(function() {
        if($('#height').val() == "") {
            $('#height_error').html('请输入作品的长度');
        }else if(!(Number($('#height').val()) > 0)) {
            $('#height_error').html('长度须为正数');
        }
    });
    $('#price').focusin(function(){
        $('#price_error').html("");
    }).focusout(function() {
        if($('#price').val() == "") {
            $('#price_error').html('请输入作品的价格');
        }else if(!(Number($('#price').val()) > 0) || (Number($('#price').val()) % 1 != 0)) {
            $('#price_error').html('价格须为正整数');
        }
    });
    $('#image').change(function() {
        $('#image_error').html('');
        let file = this.files[0];
        $('img').attr('src', window.URL.createObjectURL(file));
    });
    $('#release').click(function() {
        //检查是否输入所有信息
        let allFilled = true;
        if($('#title').val() == ""){
            $('#title_error').html('请输入作品的名称');
            allFilled = false;
        }
        if($('#artist').val() == "") {
            $('#artist_error').html('请输入作品的作者');
            allFilled = false;
        }
        if($('#description').val() == "") {
            $('#description_error').html('请输入作品的简介');
            allFilled = false;
        }
        if($('#yearOfWork').val() == "") {
            $('#yearOfWork_error').html('请输入作品的年份');
            allFilled = false;
        }
        if($('#genre').val() == "") {
            $('#genre_error').html('请输入作品的流派');
            allFilled = false;
        }
        if($('#height').val() == "") {
            $('#height_error').html('请输入作品的长度');
            allFilled = false;
        }
        if($('#width').val() == "") {
            $('#width_error').html('请输入作品的宽度');
            allFilled = false;
        }
        if($('#price').val() == "") {
            $('#price_error').html('请输入作品的价格');
            allFilled = false;
        }
        // if($('#image').val() == "") {
        //     $('#image_error').html('请选择上传的文件');
        //     allFilled = false;
        // }
        //检查每个输入框的输入内容是否有问题
        let noError = $('#title_error').html() == "" && $('#artist_error').html() == ""
            && $('#yearOfWork').html() == "" && $('#genre_error').html() == ""
            && $('#height_error').html() == "" && $('#width_error').html() == "" &&
            $('#price_error').html() == "";
        if(allFilled && noError) {
            let file = $('#image')[0].files[0];
            let formData = new FormData();
            formData.append('title', $('#title').val());
            formData.append('artist', $('#artist').val());
            formData.append('description', $('#description').val());
            formData.append('yearOfWork', $('#yearOfWork').val());
            formData.append('genre', $('#genre').val());
            formData.append('height', $('#height').val());
            formData.append('width', $('#width').val());
            formData.append('price', $('#price').val());
            formData.append('action', this.getAttribute('data-action'));
            formData.append('artworkID', $('#title').attr('data-artworkID'));
            if($('#image').val() != "") {
                formData.append('file', file);
                alert($('#image').val());
                //检查文件类型
                if(!(file.type == "image/jpg" || file.type == "image/jpeg" || file.type == "image/png")) {
                    alert("请上传正确的图片类型");
                }else if((file.size % 1024) > 200) {
                    alert("图片体积过大");
                }
            }
                $.ajax({
                    type: "POST",
                    url: "../php/check_publish.php",
                    data: formData,
                    dataType: "json",
                    cache: false,
                    processData: false,
                    contentType: false,
                    success: function (msg) {
                        if(msg['success']) {
                            $('.modal-body').html('<h4>发布成功</h4>');
                            $('.modal-button').html('关闭');
                            $("#information").modal('show');
                        }
                    }
                });
            }
    });
});