    <footer>
        <div class="footer-bottom">
        <div class="container">
            <ul>          
                <li><a href="//hotstrapthai.com"><?php lang("home",$_SESSION["lang"]) ?></a></li>
                <li><a href="/products/"><?php lang("product",$_SESSION["lang"]) ?></a></li>
                <li><a href="/orders/"><?php lang("orders",$_SESSION["lang"]) ?></a></li>
                <li><a href="/about.php"><?php lang("aboutus",$_SESSION["lang"]) ?></a></li>
                <li><a href="/contact/"><?php lang("contact",$_SESSION["lang"]) ?></a></li>
            </ul>
            <ul>          
                <li><a href="/template/">Design template</a></li>
                <li><a href="/guide/">ขั้นตอนการสั่งซื้อ</a></li>
                <li><a href="/gallery/">แกลอรี่ลูกค้าของเรา</a></li>
            </ul>
            <div class="contact-bot">
                <p style="float: left;width: 60%;">02-637-8997 (<?php lang("work_day",$_SESSION["lang"]) ?> 8:30-17:30) Contact mail: <a href="mailto:contact_hs@hotstrapthai.com" class="link2">contact_hs@hotstrapthai.com</a> <br/>
                Copyright © 2018 YOU AND EARTH SYSTEM CO., LTD.</p>
                <div class="line_qr" style="float: right;width: 35%;margin-bottom: 5px;">
                    <a href="http://line.me/ti/p/~youandearth.th" target="_blank"><img src="/images/line_qr.jpg?v=1.00" style="" width="90"></a>
                </div>
            </div>            
        </div>
    </div>
    </footer>
    <div class="flyout-wrap"> <a class="flyout-btn" href="#" title="Toggle"><img src="/images/btn_bot01.png"></a>
    <ul class="flyout fade flyout-init">
      <li><a href="#"><img src="/images/btn_bot02.png"></a></li>
      <li><a href="#"><img src="/images/btn_bot03.png"></a></li>
      <li><a href="#"><img src="/images/btn_bot04.png"></a></li>
    </ul>
    </div>
    <script type="text/javascript" src="//code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="/lightbox2-master/src/js/lightbox.js"></script>

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-121776510-1"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-121776510-1');
    </script>
    <script type="text/javascript" src="/js/main.js?v=1.03"></script>
    <script src="/js/jquery.flex-modal.js"></script>
    <script src="/js/slider.js"></script>  
<!-- Global site tag (gtag.js) - Google Ads: 806959730 -->
<script async src="https://www.googletagmanager.com/gtag/js?id=AW-806959730"></script>
<script>
  (function() {
    $(".flyout-btn").click(function() {
        return $(".flyout-btn").toggleClass("btn-rotate"), $(".flyout").find("a").removeClass(), $(".flyout").removeClass("flyout-init").toggleClass("fade").toggleClass("expand")
    }), $(".flyout").find("a").click(function() {
        return $(".flyout-btn").toggleClass("btn-rotate"), $(".flyout").removeClass("expand").addClass("fade"), $(this).addClass("clicked")
    })
  }).call(this);
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'AW-806959730');
</script>


