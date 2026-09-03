<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="/css/fonts.css" type="text/css" />
<link rel="stylesheet" href="/css/base4.css" type="text/css" />
<link rel="stylesheet" href="/css/header.css?v=1.13" type="text/css" />
<link rel="stylesheet" href="/css/nav.css?v=1.01" type="text/css" />
<link rel="stylesheet" href="/css/sidemenu.css?v=1.01" type="text/css">
<link rel="stylesheet" href="/css/design3.css" type="text/css" />
<link rel="stylesheet" href="/css/footer.css?v=1.02" type="text/css" />
<link rel="stylesheet" href="/css/colorbox.css" type="text/css" />
<link rel="shortcut icon" href="//hotmobily.jp/favicon.ico" type="image/x-icon" />
<script type="text/javascript" src="/js/jquery.min.js"></script>
<script type="text/javascript" charset="utf-8" src="/js/sidemenu.js"></script>
<link rel="stylesheet" href="/css/banner_style.css?v=1.19" type="text/css" />
<link rel="stylesheet" href="/css/mbmenu_customs.css?v=1.03" type="text/css" />
<script>
 $(function(){var o=$("#tab_menu").offset().top,t=parseInt(o),s=$(".page_top");s.hide(),$(window).scroll(function(){$(this).scrollTop()>400?s.fadeIn():s.fadeOut(),$(document).scrollTop()>70?($("#tab_menu").css({position:"fixed",top:"0px"}),$("#click_to_call").css({position:"fixed",top:"0px"}),$("#contact").css({position:"fixed",top:"0px"}),$("#toggle_b").css({position:"fixed",top:"0px"}),$("#home").css({position:"fixed",top:"0px"}),$(".menumb").css({position:"fixed",top:"42px",height:"80%",overflow:"hidden scroll"}),$(".mb_lang").css({position:"fixed",top:"45px",height:"auto",overflow:"hidden scroll"}),$("div.menu").attr("id","scroll-active")):$(document).scrollTop()<70&&($("#tab_menu").css({position:"absolute",top:o}),$("#click_to_call").css({position:"absolute",top:o}),$("#contact").css({position:"absolute",top:o}),$("#toggle_b").css({position:"absolute",top:o}),$("#home").css({position:"absolute",top:o}),$(".menumb").css({position:"absolute",top:t,height:"100%",overflow:"hidden scroll"}),$(".mb_lang").css({position:"absolute",top:o+45,height:"auto",overflow:"hidden scroll"}),$("div.menu").attr("id",""))}),s.click(function(){return $("body, html").animate({scrollTop:0},500,"swing"),!1})
  $("#product_menu").click(function(){
    $(".menumb").toggle("slide");
    $(".mb_lang").slideUp();
    $("body").css({overflow:"hidden"});
    $("div.close-subnav").fadeIn( 400);
    return false;
  });
  $("#lang").click(function(){
    $(".mb_lang").slideToggle();
    $(".menumb").slideUp();
    return false;
  });
  $(".close-subnav").click(function(){
    $(".menumb").toggle("slide");
    $("body").css({overflow:"auto"});
    $("div.close-subnav").fadeOut(200);
    return false;
  });
});
</script>
<!--[if (gte IE 9)|!(IE)]><!-->
  <link rel="stylesheet" type="text/css" media="all" href="/css/jquery.mmenu.all.css">
  <script type="text/javascript" src="/js/jquery.mmenu.min.all.js"></script> 
  <script type="text/javascript">
   $(function() {
    $('nav#menu').mmenu({
     dragOpen: true,
     counters	: true,
     zposition: "front",
     slidingSubmenus: false,
     header		: {
      add			: true,
      update		: true,
      title		: '商品紹介'
    }
  });
  });
</script>
<!--<![endif]-->

  <script src="/js/jquery-ui.min.js"></script>
  <style type="text/css">
   body{font-family:IwaUDGoDspPro-Th,sans-serif!important;font-size:13.6px;font-feature-settings:palt;-webkit-text-size-adjust:100%;letter-spacing:-.06em;color:#281600}@media screen and (max-width: 768px){body#top{font-size:3.47vw;line-height:1.53;letter-spacing:-.06em}}#content_wrapper>h2{text-align:center;border-bottom:3px solid #f47722;margin-bottom:10px;font-family:IwaUDGoDspPro-Eb,sans-serif!important;background-color:#f2f2f2;line-height:1.93;padding:13px 0 8.5px;color:#281600}#content_wrapper>h2:first-child{margin-top:0}.faq>a{color:#000;display:block;padding:10px 0;font-size:15px;text-decoration:none;cursor:pointer}.read-more1{text-align:center;margin:15px}span.faq-q{color:red;padding-right:10px}a,h1,h2,h3,h4,h5,h6{font-family:IwaUDGoDspPro-Th,sans-serif!important}.side_link{font-size:13px}img:not([src]){visibility:hidden}.playbtn{background:rgba(0,0,0,0.55);width:50px;height:24px;border-radius:5px;padding-top:10px;position:absolute;margin:0 auto;top:45%;right:45%}.videoWrapper:hover .playbtn{background:#cd201f;cursor:pointer}.tri{width:0;height:0;border-style:solid;border-width:7px 0 7px 14px;border-color:transparent transparent transparent #fff;margin:0 auto}.sns-footer h3{width:100%}
 </style>

