<style>
	a.svg {
		position: relative;
		display: inline-block
	}

	a.svg:after {
		content: "";
		position: absolute;
		top: 0;
		right: 0;
		bottom: 0;
		left: 0
	}

	a.svg:hover {
		cursor: pointer
	}

	.w-100 {
		width: 100%
	}

	.email_support {
		font-size: 14px;
		color: #f58904
	}

	.contact_img {
		height: calc(100% - 17px)
	}

	#header {
		position: relative
	}

	#header table {
		position: absolute
	}

	.ct-position {
		vertical-align: top;
	}

	@media(max-width: 876px) {
		.ct-position {
			vertical-align: middle;
		}
	}

	@media (max-width: 576px) {
		.w-100 {
			width: 100%;
			height: auto
		}
	}

	.contact-container {
		position: relative;
		display: block
	}

	a.tel-link {
		position: absolute;
		display: block;
		width: 100%;
		height: 97%;
		top: 0;
		left: 0
	}

	.lang-link {
		position: absolute;
		width: 100%;
		display: inline-flex;
		height: 20px;
		left: 0;
		border: 1px solid
	}

	.lang-link a {
		display: inline-block;
		width: 20%;
		height: 20px;
		font-size: 11px;
		color: #ee7f22;
		line-height: 21px;
		text-decoration: none
	}

	.lang-link a:hover,
	.lang_active {
		background: #ffe587;
		transition-duration: .5s
	}

	.lang-link img {
		padding-right: 4px
	}

	@media only screen and (min-device-width: 320px) and (max-width: 841px) {
		#header object {
			max-width: 100%;
			height: auto
		}

		body {
			margin-top: 8px
		}

		.contact_img {
			height: 50px
		}

		.email_support {
			display: none
		}

		#header {
			width: 100%;
			padding-top: 0;
			height: auto;
			margin-left: -1px
		}

		#header table {
			position: unset
		}
	}

</style>
<div id="header">
	<table width="100%" border="0" cellpadding="0" style="border-collapse:collapse; margin-bottom:5px;top: -5px;">
		<tbody>
			<tr>
				<td><a href="//hotmobily.jp/" class="svg"><img src="/img/banner_hm_20250211.webp" class="w-100"
							style="position: unset;display: block;"></a></td>
				<td class="ct-position" style="text-align: center;">
					<a href="tel:05068655591"><img src="/img/contact-2025.webp" class="w-100 contact_img"
							style="height: auto;"></a><br>
					<!-- <div class="email_support">
						<div class="contact-container">
							<div class="lang-link">
								<a href="?lang=jp" class="lang-jp" style="border-right: 1px solid;"><img src="/img/jp.webp" width="20"
										height="14">日本語</a>
								<a href="javascript:void(0)" class="lang-en" style="border-right: 1px solid;"><img src="/img/us.webp"
										width="20" height="14">ENG</a>
								<a href="?lang=cn" class="lang-cn" style="border-right: 1px solid;"><img src="/img/cn.webp" width="20"
										height="14">中文</a>
								<a href="?lang=kr" class="lang-kr" style="border-right: 1px solid;"><img src="/img/kr.webp" width="20"
										height="14">한국</a>
								<a href="?lang=th" class="lang-th"><img src="/img/th.webp" width="20" height="14">TH</a>
							</div>
						</div>
					</div> -->
				</td>
			</tr>
		</tbody>
	</table>
</div>
<script type="text/javascript">
	$.get("/getLang", function (data, status) { $('.lang-link').find('.lang-' + data).addClass('lang_active'); });
</script>

