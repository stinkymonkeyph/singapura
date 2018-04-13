<!DOCTYPE html>

<html>
<head>
	<title>Meoow !</title>
	<link href="https://fonts.googleapis.com/css?family=Anton|Work+Sans" rel="stylesheet">
</head>
<body>
	<p class="head-title">Meoow! There's an Error</p>
	<div class="error-div">
		<br>
		<p class="error-par"><?php echo $errors ?></p>
		<?php foreach($traces as $trace): ?>
			<p class="error-par"><?php echo $trace ?></p>
		<?php endforeach ?>
	</div>
</body>
</html>

<style>	
	.error-par
	{
		margin-left: 10px !important;
		margin-top: 10px !important;
	}
	.error-div
	{
		min-height: 300px;
		width: 90%;
		margin:	0 auto;
		background-color: whitesmoke;
		border-radius: 10px;
		margin-top: -30px;
	}
	.head-title
	{	
		font-family: 'Anton', sans-serif;
		font-size: 60px;
		text-align: center;
		color: white;
	}
	.nav
	{
		height:	60px;
		width: 100%;
		border-radius: 5px;
	}
	.white-nav
	{
		background-color:whitesmoke;
	}
	body
	{
		background-color: #960322;
	}
</style>