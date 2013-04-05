<?php

if ($_POST['link']) {
	include $_SERVER['DOCUMENT_ROOT'] . '/transmitor/function/transmitor.class.php';

	$sources = array($_POST['link']);

	$transmitor = new Transmitor($_POST['folder']);
	$transmitor->setSourceUrls($sources);
	$result = $transmitor->execute();
}

?>

<html>
<head>
	<title>Transmitor</title>
</head>
<body>
	<?php 
	if ($result) { ?>
		<h3>Results:</h3>
		<p>Total of <?php echo count($result); ?> images crawled</p>
		<ul>
		<?php

		foreach ($result as $single) { ?>
			<li><?php echo $single['url']; ?> : <?php echo ($single['success']) ? 'Saved' : 'Failed'; ?></li>
		<?php } ?>
		</ul>

	<?php } ?>

	<form action="index.php" method="POST">
		<p>
			<label for="name">Url:</label>
			<input type="text" name="link" size="100" />
		</p>
		<p>
			<label for="name">Folder:</label>
			<input type="text" name="folder" />
		</p>
		<p>
			<input type="submit" />
		</p>
	</form>
</body>
</html>