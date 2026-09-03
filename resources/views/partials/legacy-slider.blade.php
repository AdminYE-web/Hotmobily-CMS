<!DOCTYPE html>
<html>

<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<style>
		.bannerSlides {
			display: none
		}

		.bannerSlides img {
			vertical-align: middle;
			width: 100%;
			max-width: 770px
		}

		.slideshow-container {
			max-width: 771px;
			position: relative;
			margin: auto
		}

		.prev,
		.next {
			cursor: pointer;
			position: absolute;
			top: 50%;
			width: auto;
			padding: 16px;
			margin-top: -22px;
			color: #666;
			font-weight: 700;
			font-size: 18px;
			transition: .6s ease;
			border-radius: 0 3px 3px 0;
			user-select: none
		}

		.next {
			right: 0;
			border-radius: 3px 0 0 3px
		}

		.prev:hover,
		.next:hover {
			background-color: rgba(0, 0, 0, 0.50);
			color: #fff;
			text-decoration: none
		}

		.dot-pic {
			padding: 5px 0;
			text-align: center
		}

		.dot {
			cursor: pointer;
			height: 15px;
			width: 15px;
			margin: 0 2px;
			background-color: #bbb;
			border-radius: 50%;
			display: inline-block;
			transition: background-color .6s ease
		}

		.active,
		.dot:hover {
			background-color: #717171
		}

		.fade {
			-webkit-animation-name: fade;
			-webkit-animation-duration: 1.5s;
			animation-name: fade;
			animation-duration: 1.5s
		}

		.sold-out {
			position: absolute;
			left: 25%;
			top: 23%;
			transform: rotate(350deg);
			-ms-transform: rotate(350deg);
			-moz-transform: rotate(350deg);
			-webkit-transform: rotate(350deg);
			-o-transform: rotate(350deg)
		}

		@-webkit-keyframes fade {
			from {
				opacity: .4
			}

			to {
				opacity: 1
			}
		}

		@keyframes fade {
			from {
				opacity: .4
			}

			to {
				opacity: 1
			}
		}

		@media only screen and (max-width: 300px) {

			.prev,
			.next,
			.text {
				font-size: 11px
			}
		}

		@media (max-width: 980px) {

			.prev,
			.next {
				margin-top: -25px;
				background-color: rgba(0, 0, 0, 0.30);
				color: #fff;
				text-decoration: none
			}

			.mb-content {
				display: block !important;
			}
		}

		.mb-content {
			display: none;
		}
	</style>
</head>

<body>
	<div class="slideshow-container">
		<!-- <div class="bannerSlides fade"><a href="/products/sponge/"><img src="/products/sponge/images/banner-sponge-3.webp"
					width="770" height="194"></a></div> -->
		<!-- <div class="bannerSlides fade"><a href="https://hotmobily.jp/campaign/end_and_start_year2024-25_campaign"><img
						src="/products/images/newyear2.webp" width="770" height="194"></a></div>	 -->
		<!-- <div class="bannerSlides fade"><a href="https://hotmobily.jp/products/graduation.php"><img
							src="/products/img/graduation/graduate-gift_banner.webp" width="770" height="194"></a></div> -->
		<!-- <div class="bannerSlides fade"><a href="https://hotmobily.jp/campaign/chinese_new_year2025_campaign.php"><img
						src="/products/images/cn-new-year-2.webp" width="770" height="194"></a></div> -->
		<!-- <div class="bannerSlides fade">
			<a href="/products/beach.php">
				<picture>
					<source media="(max-width: 768px)" srcset="/products/images/banner_flipflops_mobile.webp">
					<img src="/products/images/banner_flipflops_pc.webp" width="770" height="240">
				</picture>
			</a>
		</div> -->
		<!-- <div class="bannerSlides fade">
			<a href="/campaign/christmas2025">
				<picture>
					<source media="(max-width: 768px)" srcset="/img/banner_christmas_v2_forMobile.webp">
					<img src="/img/banner_christmas_v2_forPC.webp" width="770" height="240">
				</picture>
			</a>
		</div>	 -->

		

		<!-- <div class="bannerSlides fade">
			<a href="https://hotmobily.jp/campaign/202602">
				<picture>
					<source media="(max-width: 768px)" srcset="/img/HM_202602banner_mobile.webp">
					<img src="/img/HM_202602banner.webp" width="770" height="240">
				</picture>
			</a>
		</div> -->
		<!-- <div class="bannerSlides fade">
			<a href="https://hotmobily.jp/comic-market-2026summer">
				<picture>
					<source media="(max-width: 768px)" srcset="/products/images/hm_banner_comic-moblie.webp">
					<img src="/products/images/hm_banner_comic-laptop.webp" width="770" height="240">
				</picture>
			</a>
		</div> -->

		<div class="bannerSlides fade">
			<a href="https://hotmobily.jp/products/tapestry/">
				<picture>
					<source media="(max-width: 768px)" srcset="/img/banner_tapestry_up to 3_button_mobile.webp">
					<img src="/img/banner_tapestry_up to 3_button_pc.webp" width="770" height="240">
				</picture>
			</a>
		</div>


		<!-- <div class="bannerSlides fade">
			<a href="/campaign/acrylic/2026/04.php">
				<picture>
					<source media="(max-width: 768px)" srcset="/img/acrylic_campaign_April2026_top.webp">
					<img src="/img/acrylic_campaign_April2026_top.webp" width="770" height="240">
				</picture>
			</a>
		</div>	 -->

		<!-- <div class="bannerSlides fade">
			<a href="/campaign/rubberstrap/2026/01">
				<picture>
					<source media="(max-width: 768px)" srcset="/img/HM_top_mobile__rubberstrap_campaign.webp">
					<img src="/img/HM_top_pc__rubberstrap_campaign.png" width="770" height="240">
				</picture>
			</a>
		</div> -->

		<div class="bannerSlides fade">
			<a href="/products/rubberstrap/">
				<picture>
					<source media="(max-width: 768px)" srcset="/products/images/high-impact_mobile.webp">
					<img src="/products/images/high-impact_webp.webp" width="770" height="240">
				</picture>
			</a>
		</div>	
		<div class="bannerSlides fade">
			<a href="/faq/details/rubberstrap/q4">
				<picture>
					<source media="(max-width: 768px)" srcset="/img/stain-resistant-coating-banner.webp">
					<img src="/img/stain-resistant-coating-banner.webp" width="770" height="240">
				</picture>
			</a>
		</div>
	
		
		<a class="prev" onclick="plusSlides(-1)">&#10094;</a>
		<a class="next" onclick="plusSlides(1)">&#10095;</a>
	</div>
	<div class="dot-pic">
		<span class="dot" onclick="currentSlide(0)"></span>
		<span class="dot" onclick="currentSlide(1)"></span>
		<span class="dot" onclick="currentSlide(2)"></span>
		<!-- <span class="dot" onclick="currentSlide(3)"></span> -->
		<!-- <span class="dot" onclick="currentSlide(4)"></span> -->
	</div>
	<script>
		var slideIndex = 0; showSlides();
		function plusSlides(n) { (n >= 0 ? showSlides(slideIndex) : showSlides(slideIndex -= 2)); }
		function currentSlide(n) { showSlides(slideIndex = n); }
		function showSlides(n) {
			var i, slides = document.getElementsByClassName("bannerSlides"), dots = document.getElementsByClassName("dot");
			if (n > slides.length) { slideIndex = 1; }
			if (n < 0) { slideIndex = slides.length - 1; }
			for (i = 0; i < slides.length; i++) { slides[i].style.display = "none"; } slideIndex++;
			if (slideIndex > slides.length) { slideIndex = 1 }
			for (i = 0; i < dots.length; i++) { dots[i].className = dots[i].className.replace(" active", ""); }
			slides[slideIndex - 1].style.display = "block";
			dots[slideIndex - 1].className += " active";
			if (n == undefined) { setTimeout(showSlides, 10000); }
		}
	</script>
</body>

</html>

