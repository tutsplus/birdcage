$(window).load(function(){  
  var number = Math.floor(Math.random() * 3);
  var arr = ["lake", "coffee","clouds"];
  $('body').css('background-image','url(http://cloud.geogram.com/covers/desktop/home-'+arr[number]+'.jpg)');
});