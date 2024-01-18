<div class="search_box">

    <div class="row">
        <div class="col">

            <?php echo form_open(base_url(front_base . "search/search_submit"), array("role" => "form",  "class" => "inline check_submit", "release" => "true")); ?>

            <?php $box_id = gen_hash(10); ?>

            <div class="input-group input-group-lg" id="box_<?php echo $box_id; ?>">

                <div class="input-group-prepend">

                    <button type="button" class="btn btn_show_options rounded-0 dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="d-none d-sm-inline search_for_label"></span>
                    </button>

                    <div class="dropdown-menu box_options rounded-0 dropdown-menu-<?php echo MyAlign; ?>">

                        <?php
                        $searchable_fields = $this->search_gate->get_searchable_fields();
                        array_unshift($searchable_fields, "all"); // adding All to the fields
                        ?>

                        <?php foreach ($searchable_fields as $opt_var) { ?>
                            <?php
                            $selected = "";
                            if (@$opt_var == "all") {
                                $selected =  'checked="checked"';
                            }
                            ?>
                            <div class="dropdown-item">
                                <div class="form-check">
                                    <input data-box="<?php echo $box_id; ?>" data-title="<?php echo word($opt_var) ?>" id="<?php echo $box_id . "-" . $opt_var ?>" value="<?php echo $opt_var ?>" <?php echo @$selected ?> class="form-check-input search_for_selector" type="radio" name="<?php echo $box_id; ?>_field">
                                    <label class="form-check-label" for="<?php echo $box_id . "-" . $opt_var ?>"><?php echo word($opt_var) ?></label>
                                </div>
                            </div>
                        <?php } ?>
                    </div>

                </div>

                <input type="text" class="form-control rounded-0 req_field" id="keywords" name="<?php echo $box_id; ?>_keywords" aria-label="<?php echo word("looking_for") ?>" autofocus="true" spellcheck="true">

                <div class="input-group-append">
                    <button type="submit" class="btn btn-info rounded-0"><i class="fas fa-search"></i></button>
                </div>

                <input type="hidden" name="boxes[]" value="<?php echo $box_id; ?>" />

            </div>

            <?php echo form_close(); ?>


        </div>
        <div class="col-md-auto text-center mt-3 mt-md-0 d-none d-md-block">
            <a class="btn btn-adv_search btn-warning btn-lg rounded-0" href="<?php echo base_url(front_base . "search"); ?>"><?php echo word("advanced_search") ?></a>
        </div>
    </div>


</div>