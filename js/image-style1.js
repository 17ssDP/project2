$(document).ready(function() {
  $('#gallery a').click(function(evt) {
    var imgPath, newImage;
    //get path to new image
    imgPath = $(this).attr('href');
    //create HTML for new image, set opacity
    // also callback for when image loads
    $img = $('<img src="' + imgPath + '">').css('opacity', 0).load(displayImage);


    //don't follow link
    evt.preventDefault();
    //don't let event go up page
    evt.stopPropagation();
  }); // end click

  function displayImage() {
    // add overlay
    $('<div id="overlay"><div id="photo"></div></div>').prependTo('body');
    // select photo div
    $photoDiv = $('#photo');
    //add to the #photo div
    $photoDiv.append($img);

    // position image
    $photoDiv.css({
      marginLeft: ($img.outerWidth() / 2) * -1,
      marginTop: ($img.outerHeight() / 2) * -1
    });
    //fade in new image
    $img.animate({
      opacity: 1
    }, 1000);
  }

  $('html').on('click', function(evt) {
    var $overlay = $('#overlay');
    if (evt.target == $overlay.get(0)) {
      $overlay.remove();
    }
  });
}); // end ready