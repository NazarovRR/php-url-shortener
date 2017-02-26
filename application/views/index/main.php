<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>URL Shortener</title>
	<link href="https://fonts.googleapis.com/css?family=Droid+Serif" rel="stylesheet">
	<link href="<?php echo base_url(); ?>static/css/style.css" rel="stylesheet">
</head>
<body>
	<div class="container">
		<h1>URL Shortener</h1>
		<?php echo form_open(''); ?>
			<div class="input-group">
				<input id="url-field" type="text" class="txtfield input" name="url" value="<?php echo set_value('url'); ?>" placeholder="Url to be shorten">
				<button class="btn btn-submit" type="submit">SHORTEN</button>
			</div>
			<h2>Want to choose short url by yourself?</h2>
			<div class="input-group">
				<input id="encoded-field" type="text" class="txtfield-short input" name="encoded" value="<?php echo set_value('encoded'); ?>" placeholder="Short url (optional)">
			</div>
			<div id="link">
				<?php if($message) : ?>
				    <a href=<?php echo base_url().$message ?>><?php echo base_url().$message?></a>
				<?php endif; ?>
				<?php echo validation_errors(); ?>
			</div>
		</form>
	</div>
</body>
</html>