$(".default_option").click(function () {
  $(this).parent().toggleClass("active");
});

$(".select_ul li").click(function () {
  var currentele = $(this).html();
  $(".default_option li").html(currentele);
  $(".select_ul li").removeClass("active");
  $(this).addClass("active");
  $(this).parents(".select_wrap").removeClass("active");
});