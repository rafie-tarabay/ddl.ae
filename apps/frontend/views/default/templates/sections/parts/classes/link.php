<div class="list-group-item">
    <?php $target = $fields["target"] == "new_tab" ? "_blank" : ""; ?>
    <a target="<?php echo $target; ?>" href="<?php echo @$fields["url"] ?>" class="<?php echo @$fields["css_class"]; ?>"><?php echo @$fields["title"] ? $fields["title"] : $fields["url"]; ?></a>
</div>