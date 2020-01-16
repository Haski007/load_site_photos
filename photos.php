#!/usr/bin/php
<?php

function get_photo_name($url)
{
	preg_match("/^.*?([^\/]+)$/", $url, $matches);
	return $matches[1];
}

function create_folder($folder)
{
	$folder = strchr(str_replace("/", '_', $folder), "_");
	if (file_exists($folder))
		return ;
	mkdir($folder);
	return ($folder);
}

if ($argc != 2)
	exit ("Wrong number of arguments!\n");

$site = $argv[1];
$folder = create_folder($site);

$html = file_get_contents($site);

$urls_arr = array();										// Array with urls

preg_match_all("~<\s?img.*?src=\"(.*?)\"~", $html, $urls_arr);

foreach ($urls_arr[1] as $img)
{
	$photo_name = get_photo_name($img);
	$photo_name = $folder . '/' . $photo_name;
	file_put_contents($photo_name, file_get_contents($img));
}

// file_put_contents()

?>