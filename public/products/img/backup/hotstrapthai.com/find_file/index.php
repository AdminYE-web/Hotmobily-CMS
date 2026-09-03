<?php
session_start();
?>
<!DOCTYPE HTML>
<!--
	Hyperspace by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
	<head>
		<title>Hotstrap File list</title>
		<meta charset="utf-8" />
		<meta name="robots" content="noindex">
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<!--[if lte IE 8]><script src="assets/js/ie/html5shiv.js"></script><![endif]-->
		<link rel="stylesheet" href="assets/css/main.css?v=1.01" />
		<!--[if lte IE 9]><link rel="stylesheet" href="assets/css/ie9.css" /><![endif]-->
		<!--[if lte IE 8]><link rel="stylesheet" href="assets/css/ie8.css" /><![endif]-->
		<style type="text/css">
			#preview{
				position:absolute;
				border:1px solid #ccc;
				background:#333;
				padding:5px;
				display:none;
				color:#fff;
			}
		</style>
	</head>
	<body>
	<?php 
	if(!isset($_SESSION['true'])){?>
		<!-- Sidebar -->
			<section id="sidebar">
				<div class="inner">
					<nav>
						<ul>
							<li><a href="#intro">Welcome</a></li>
							<li id="order" style="display:none"><a href="#one">List File Order</a></li>
							<li id="contact" style="display:none"><a href="#two">List File Contact</a></li>
						</ul>
					</nav>
				</div>
			</section>

		<!-- Wrapper -->
			<div id="wrapper">
			<div id="result"></div>
				<!-- Intro -->
					<section id="intro" class="wrapper style1 fullscreen fade-up">
						<div class="inner">
							<h1>Wellcome</h1>
							<p>Admin menu show list file hotmobily</p>
							Enter password: <input type="password" id="pass" style="" /><br>
							<input type="button" id="btn_sub" onclick="validate();" value="submit">
						</div>
					</section>

				<!-- One -->
					<section id="one" class="wrapper style2 spotlights">
						<section>
							<div class="content">
								<div class="inner">
								<div id="list1">
								</div>
								</div>
							</div>
						</section>
					</section>
					
					<!-- two -->
					<section id="two" class="wrapper style3">
						<section>
							<div class="content" style="padding: 4em 4em 2em 4em">
								<div class="inner">
								<div id="list2">
									
								</div>
								</div>
							</div>
						</section>
					</section>

					<!-- three -->
					<section id="three" class="wrapper style2">
						<section>
							<div class="content" style="padding: 4em 4em 2em 4em">
								<div class="inner">
								<div id="list3">
									
								</div>
								</div>
							</div>
						</section>
					</section>
					</div>
		<?php }else{?>
		<!-- Sidebar -->
			<section id="sidebar">
				<div class="inner">
					<nav>
						<ul>
							<li><a href="#intro">Welcome</a></li>
							<li id="order" style=""><a href="#one">List File Order</a></li>
							<li id="contact" style=""><a href="#two">List File Contact</a></li>
						</ul>
					</nav>
				</div>
			</section>

		<!-- Wrapper -->
			<div id="wrapper">
			<div id="result"></div>
				<!-- Intro -->
					<section id="intro" class="wrapper style1 fullscreen fade-up">
						<div class="inner">
							<h1>Wellcome</h1>
							<p>Admin menu show list file hotmobily</p>
						</div>
					</section>

				<!-- One -->
					<section id="one" class="wrapper style2 spotlights">
						<section>
							<div class="content">
								<div class="inner">
								<div id="list1">
									<?php 
										echo '<h2>List File Order</h2>';
												$dir    = "../orders/upload/";
												$files1 = scandir($dir,1);
												$iMax = count($files1)-2;
												for($i=0;$i<$iMax;$i++){
													$allowed =  array('jpg','jpeg','JPG');
													$ext = pathinfo($files1[$i], PATHINFO_EXTENSION);
													if(in_array($ext,$allowed)){
														echo '<p>download: <a href="download.php?fname='.$files1[$i].'&path=../orders/upload" target="_blank" class="preview">'.$files1[$i].'</a><br> date upload: '.date ("F d Y H:i:s.", filemtime('../orders/upload/'.$files1[$i])).'</p>';
													}else{
														echo '<p>download: <a href="download.php?fname='.$files1[$i].'&path=../orders/upload" target="_blank">'.$files1[$i].'</a><br> date upload: '.date ("F d Y H:i:s.", filemtime('../orders/upload/'.$files1[$i])).'</p>';
													}
													
												}
									?>
								</div>
								</div>
							</div>
						</section>
					</section>
					
					<!-- two -->
					<section id="two" class="wrapper style3">
						<section>
							<div class="content" style="padding: 4em 4em 2em 4em">
								<div class="inner">
								<div id="list2">
									<?php 
										echo '<h2>List File Contact</h2>';
												$dir2    = '../contact/upload/';
												$files2 = scandir($dir2,1);
												$iMax2 = count($files2)-2;
												for($i2=0;$i2<$iMax2;$i2++){
													$allowed =  array('jpg','jpeg','JPG');
													$ext = pathinfo($files2[$i2], PATHINFO_EXTENSION);
													if(in_array($ext,$allowed)){
														echo '<p>download: <a href="download.php?fname='.$files2[$i2].'&path=../contact/upload" target="_blank" class="preview">'.$files2[$i2].'</a><br> date upload: '.date ("F d Y H:i:s.", filemtime('../contact/upload/'.$files2[$i2])).'</p>';
													}else{
														echo '<p>download: <a href="download.php?fname='.$files2[$i2].'&path=../contact/upload" target="_blank">'.$files2[$i2].'</a><br> date upload: '.date ("F d Y H:i:s.", filemtime('../contact/upload/'.$files2[$i2])).'</p>';
													}
													
												}
									?>
								</div>
								</div>
							</div>
						</section>
					</section>
					</div>
		<?php }?>
		<!-- Footer -->
			<footer id="footer" class="wrapper style1-alt">
				<div class="inner">
					
				</div>
			</footer>

		<!-- Scripts -->
			<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/jquery.scrollex.min.js"></script>
			<script src="assets/js/jquery.scrolly.min.js"></script>
			<script src="assets/js/skel.min.js"></script>
			<script src="assets/js/util.js"></script>
			<!--[if lte IE 8]><script src="assets/js/ie/respond.min.js"></script><![endif]-->
			<script src="assets/js/main.js"></script>
			<script type="text/javascript">
				$(function(){
					if(localStorage.time){
						var d1 = new Date()
						var timeEnd = new Date(d1).getTime();
						var timeStart = new Date(localStorage.time).getTime();
						var hourDiff = timeEnd - timeStart; //in ms
						var secDiff = hourDiff / 1000; //in s
						var minDiff = hourDiff / 60 / 1000; //in minutes
						var hDiff = hourDiff / 3600 / 1000; //in hours
						var humanReadable = {};
						humanReadable.hours = Math.floor(hDiff);
						humanReadable.minutes = minDiff - 60 * humanReadable.hours;
						if(humanReadable['minutes']>=15){
							document.getElementById("pass").readOnly = false;
							document.getElementById("btn_sub").disabled = false;
							localStorage.removeItem("time");
							localStorage.removeItem("fail");
						}else{
							document.getElementById("pass").readOnly = true;
							document.getElementById("btn_sub").disabled = true;
							alert('You enter wrong password many time, Please try again after 15 minute');
						}
					}
					
				})
				var tmp = 1;
				function validate(){
					if($('#pass').val()){
						$.ajax({
							type: "POST",
							url: "check.php",
							data: {
								"password": $('#pass').val()
							},
							success: function(data){
								if(data){
									// write(data);
									$('#result').html("<script>"+data+"<\/script>");
									localStorage.removeItem("time");
									localStorage.removeItem("fail");
									$('#intro').replaceWith('<section id="intro" class="wrapper style1 fullscreen fade-up"><div class="inner"><h1>Wellcome</h1><p>Admin menu show list file hotstrap</p></div></section>');
									imagePreview();
								}else{
									if(!localStorage.fail){
										localStorage.fail = tmp;
										alert('password are wrong. Please make sure that you are an admin.');
									}else{
										tmp = ++localStorage.fail;
										localStorage.fail = tmp;
										
										if(localStorage.fail>=3){
											var d2 = new Date ();
											d2.setMinutes(d2.getMinutes()+1);
											document.getElementById("pass").readOnly = true;
											document.getElementById("btn_sub").disabled = true;
											alert('You enter wrong password many time, Please try again after 15 minute');
											localStorage.time = d2;
										}else{
											alert('password are wrong. Please make sure that you are an admin.');
										}
									}
								 									
								}
							}
						});
					}else{
						alert('Please enter correct password');
					}
				}
				$("#pass").keypress(function(event) {
				    if(event.keyCode == 13){
				          $("#btn_sub").click();
				          return false; 
				    }
				});
				/*
				 * Image preview script 
				 * powered by jQuery (http://www.jquery.com)
				 * 
				 * written by Alen Grakalic (http://cssglobe.com)
				 * 
				 * for more info visit http://cssglobe.com/post/1695/easiest-tooltip-and-image-preview-using-jquery
				 *
				*/ 
				this.imagePreview = function(){	
					/* CONFIG */
						
						xOffset = 15;
						yOffset = 30;
						
						// these 2 variable determine popup's distance from the cursor
						// you might want to adjust to get the right result
						var Mx = $(document).width();
						var My = $(document).height();
						
					/* END CONFIG */
					var callback = function(event) {
						var $img = $("#preview");
						
						// top-right corner coords' offset
						var trc_x = xOffset + $img.width();
						var trc_y = yOffset + $img.height();
						
						trc_x = Math.min(trc_x + event.pageX, Mx);
						trc_y = Math.min(trc_y + event.pageY, My);
						
						$img
							.css("top", (trc_y - $img.height()) + "px")
							.css("left", (trc_x - $img.width())+ "px");
					};
					
					$("a.preview").hover(function(e){
							Mx = $(document).width();
							My = $(document).height();
							
							this.t = this.title;
							this.title = "";	
							var c = (this.t != "") ? "<br/>" + this.t : "";
							$("body").append("<p id='preview'><img src='"+ this.href +"' alt='Image preview' width='400px' height='auto'/>"+ c +"</p>");
							callback(e);
							$("#preview").fadeIn("fast");
						},
						function(){
							this.title = this.t;	
							$("#preview").remove();
						}
					)
					.mousemove(callback);			
				};
				// starting the script on page load
				$(document).ready(function(){
					imagePreview();
				});
			</script>
	</body>
</html>