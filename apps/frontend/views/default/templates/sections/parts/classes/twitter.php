<div class="list-group-item p-0">
    <?php 
    $data = file_get_contents("https://publish.twitter.com/oembed?url=https://twitter.com/Interior/status/".$fields["post_id"]);
    $data = json_decode($data);
    $html = $data->html;

    echo $html;
    ?>
</div>