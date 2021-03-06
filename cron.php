<?php
date_default_timezone_set('UTC');
include dirname(__FILE__)."/config.php";
include dirname(__FILE__)."/FullFeed.php";

FileSystemCache::$cacheDir = dirname(__FILE__).'/cache';
$new = 0;
$force = false;

$fhn = new FullFeed(feedUrl);
$new = $fhn->update();
if ($force || ($new > 0)) {
	echo "$new new article(s)\n";
	if ($fhn->generateOutput()) {
		echo "Output OK\n";
	} else {
		echo "Error saving output\n";
	}
    if ($fhn->upload(awsAccessKey, awsSecretKey, awsS3BucketName)) {
        echo "Uploaded to S3 OK\n";
    } else {
    	echo "Error uploading to S3\n";
    }
}
