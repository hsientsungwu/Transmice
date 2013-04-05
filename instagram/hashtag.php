<?php
include $_SERVER['DOCUMENT_ROOT'] . '/transmitor/function/instagram.func.php';
include $_SERVER['DOCUMENT_ROOT'] . '/transmitor/function/transmitor.class.php';

// Supply a user id and an access token
$userid = "27175354";
$accessToken = "27175354.ab103e5.6b4d954979d041d39747688af11d37f6";
$url = "https://api.instagram.com/v1/tags/ivwedding/media/recent/?access_token=" . $accessToken;

$result = fetchData($url);
$result = json_decode($result);
$photos = array();

if (count($result->data)) {
     $photos = $result->data;
}

while ($result->pagination->next_url) {
     $result = fetchData($result->pagination->next_url);

     $result = json_decode($result);

     if (count($result->data)) {
          $photos = array_merge($photos, $result->data);
     }
}

$sources = array();

foreach ($photos as $photo) {
	$sources[] = $photo->images->standard_resolution->url;
}

$temp = array($sources[0]);

$transmitor = new Transmitor();
$transmitor->setSourceUrls($sources);
$resultArray = $transmitor->execute();
?>

<h3>Results:</h3>
<p>Total of <?php echo count($resultArray); ?> images crawled</p>
<ul>
<?php

foreach ($resultArray as $single) { ?>
	<li><?php echo $single['url']; ?> : <?php echo ($single['success']) ? 'Saved' : 'Failed'; ?></li>
<?php } ?>
</ul>