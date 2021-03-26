<?php
include('config.php');
?>
<!doctype html>
<html lang="en">
<head>
	<?php include('meta.php');?>
<style>
	@font-face {
	   font-family: Roboto-Regular;
	   src: url('css/Roboto-Regular.ttf');
	}
	body, html {
	  height: 100%;
	  margin: 0;
	  font-family: 'Roboto-Regular';
	}

	.bg {
	  /* The image used */
	  background-image: url("/img/404-page.jpg");

	  /* Full height */
	  height: 100%; 

	  /* Center and scale the image nicely */
	  background-position: center;
	  background-repeat: no-repeat;
	  background-size: cover;
		position: relative
	}
	.errormsg{
		position: absolute;
		color: #33316f;
		text-align: center;
		top: 35%;
		left: 50%;
		transform: translate(-50%, -50%);
	}
	.errormsg div{
		font-size: 18px;
	}
	.errormsg h1{
		margin-bottom: 10px;
	}
	.errormsg button{
		background: #33316f;
		color: #fff;
		border-radius: 4px;
		margin-top: 1em;
		border: none;
		font-size: 18px;
		width: 120px;
		height: 40px;
		line-height: 40px;
	}
	.errormsg button a{
		color: #fff;
		text-decoration: none;
	}
	@media (min-width:768px) and (max-width:1440px) {
		.errormsg h1{
			font-size: 20px;
		}
		.errormsg div {
			font-size: 14px;
		}
		.errormsg button {
			font-size: 16px;
			width: 110px;
			height: 32px;
			line-height: 32px;
		}
	}
	@media (max-width:767px) {
		.errormsg h1{
			font-size: 20px;
		}
		.errormsg div {
			font-size: 14px;
		}
		.errormsg button {
			font-size: 16px;
			width: 110px;
			height: 32px;
			line-height: 32px;
		}
		.errormsg{
			width: 80%;
			top: 38%;
		}
	}
</style>
</head>
<body>
	<div class="bg"></div>
	<div class="errormsg">
		<h1>PAGE NOT FOUND</h1>
		<div>The page you are looking for was moved, renamed, or may have never existed.</div>
                <a href="<?php echo URL_ROOT;?>" style="cursor:pointer;"><button>GO HOME</button></a>
	</div>
</body>
</html>