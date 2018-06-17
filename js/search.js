$(document).ready(function() {
    const pageSize = 9;
    let currentPage = 1;
    let totalPage;
    let sortWay = "price";
    land();
    logout();
    search();
    $('#sortWay input').on('change', function() {
        sortWay = $('input[name=sort]:checked', '#sortWay').val();
        search();
    });
    $('.firstPage').click(function() {
        currentPage = 1;
        search();
    });
    $('.prePage').click(function() {
        currentPage = (currentPage>1)? currentPage-1 : currentPage;
        search();
    });
    $('.nextPage').click(function() {
        currentPage = ((currentPage + 1) > totalPage)? totalPage : currentPage + 1;
        search();
    });
    $('.lastPage').click(function() {
        currentPage = totalPage;
        search();
    });
    $('form').keypress(function() {
        if(event.keyCode == 13) {
            // currentPage = ($('.jump').val() > 0 && $('.jump').val() < totalPage)? $('.jump').val() :
            if($('.jump').val() <= 0) {
                currentPage = 1;
            }else if($('.jump').val() > totalPage) {
                currentPage = totalPage;
            }else {
                currentPage = $('.jump').val();
            }
            search();
        }
    });
    $('.searchButton').click(function() {
        alert("fafdsf");
        // $.post('../php/search_result.php', {
        //     'searchImage': $('.searchImage').val(),
        //     'sortWay': "sortWay",
        //     'currentPage': currentPage,
        //     'pageSize': pageSize
        // }, function(result){
        //     alert(result.html);
        //     $('.search-result').html(result['html']);
        // });
        $.ajax({
            url: '../php/search_result.php',
            type: 'POST',
            dataType: 'json',
            data: {
                'searchImage': $('.searchImage').val(),
                'sortWay': sortWay,
                'currentPage': currentPage,
                'pageSize': pageSize
            },
        })
        .done(function(data) {
            $('.search-result').html(data.html);
            $('.totalPage').html("总"+data.totalPage+"页");
        });
    });
    function search() {
        $.ajax({
            url: '../php/search_result.php',
            type: 'POST',
            dataType: 'json',
            data: {
                'searchImage': $('.searchImage').val(),
                'sortWay': sortWay,
                'currentPage': currentPage,
                'pageSize': pageSize
            },
        })
        .done(function(data) {
            $('.search-result').html(data.html);
            $('.totalPage').html("总"+data.totalPage+"页");
            totalPage = data.totalPage;
        });
    }
});
