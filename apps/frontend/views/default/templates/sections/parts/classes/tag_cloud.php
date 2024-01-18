<?php 

$words = explode("\n",$fields["keywords"]);
$cloud = array();
foreach($words as $word){
    $w = explode("-",$word);
    if($w){
        $text = $w[0];
        if(!isset($w[1])){
            $size = "btn btn-link btn-sm";
        }elseif(@$w[1] == "1"){
            $size = "btn btn-link";
        }elseif(@$w[1] == "2"){
            $size = "btn btn-link btn-lg";
        }
        
        $cloud[] = array(
            "text" => $text,
            "size" => $size,
        );
    }
}

shuffle( $cloud );
?>

<div class="list-group-item">

    <?php foreach($cloud as $item){ ?>
                                                                                          
        <a target="_blank" href="<?php echo base_url(front_base."search/results/?queries=or|title|".$item["text"].";or|subjects|".$item["text"]) ?>" class="<?php echo $item["size"] ?>"><?php echo $item["text"] ?></a>

    <?php } ?>
    
</div>
