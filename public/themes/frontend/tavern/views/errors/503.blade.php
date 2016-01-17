<!DOCTYPE html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title>
		503 Service Unavailable
	</title>

	<style>

		article,aside,details,figcaption,figure,footer,header,hgroup,main,nav,section,summary{display:block;}
		audio,canvas,progress,video{display:inline-block;}
		html{font-size:100%;}
		body{font-family: ‘Lucida Console’, Monaco, monospace;line-height:1.5;margin:0;}
		address,blockquote,dd,dl,fieldset,form,hr,menu,ol,p,pre,q,table,ul{margin:0 0 1.25em;}
		h1,h2,h3,h4,h5,h6{line-height:1.25;}
		h1{font-size:64px;margin:0 0 .375em;}
		h2{font-size:1.5em;margin:0 0 .5em;}

		header,section {
			text-align: center;
		}

		header {
			position: absolute;
			top:60px;
			width:100%;
			z-index: 2;
		}

		@-webkit-keyframes bot_float { 50% { bottom: -40px; } 100% { bottom: 0px; } }
		@-moz-keyframes bot_float { 50% { bottom: -40px; } 100% { bottom: 0px; } }
		@-ms-keyframes bot_float { 50% { bottom: -40px; } 100% { bottom: 0px; } }
		@keyframes bot_float { 50% { bottom: -40px; } 100% { bottom: 0px; } }

		section {
			background: url("{{ Asset::getUrl('platform/img/waves.svg') }}") no-repeat center top;
			background-size: cover;
			width: 100%;
			position:absolute;
			z-index: 4;
			top:260px;
			bottom:0;
			padding-top:100px;
			overflow: auto;
		}

		.brand {
			max-width: 480px;
			margin:0 auto;
		}

		.brand__image{
			position:relative;
			bottom: 0px;

			-webkit-animation: bot_float ease 3s 4;
			-moz-animation: bot_float ease 3s 4;
			-ms-animation: bot_float ease 3s 4;
			animation: bot_float ease 3s 4;
		}

		.brand__image img {
			max-width: 480px;
		}

		.error {
			padding:20px 0;
		}

	</style>

</head>

<body>
@include('extensions/google/tagmanager')

	<header>
		<div class="brand">
			<div class="brand__image"><img src="{{ Asset::getUrl('platform/img/ornery-octopus.svg') }}" alt="Ornery Octopus"></div>
		</div>
	</header>

	<section>

		<div class="error">
			<div class="error__message">

				<h1>503</h1>
				<h2>The system is down!</h2>
				<p>The server is currently unavailable (because it is overloaded or down for maintenance). Generally, this is a temporary state.</p>

			</div>
		</div>

	</section>

</body>
</html>
