<?php 
$data = file_get_contents("https://publish.twitter.com/oembed?url=https://twitter.com/Interior/status/".$post->content_rel_url1);
$data = json_decode($data);
$html = $data->html;

echo $html;