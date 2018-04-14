<!DOCTYPE html>
<html>
<head>
	<title>Test Form</title>
</head>
<body>
	<form action="/test/form" method="POST">
		<input type="tex" name="first name"/>
		<input type="text" name="second name"/>
		<input type="hidden" name="csrf_token" value="<?php Helper::csrf_token() ?>"/>
		<input type="submit"/>
	</form>
</body>
</html>