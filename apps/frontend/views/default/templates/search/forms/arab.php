<style>
    .form-check {
        margin: 2%;
    }

    .results-meta {
        color: red;
    }

    .cont_result {
        background-color: #f8f8f8;
        border: 1px solid #eee;
        padding: 1%;
    }

    .list-group-item {
        position: relative;
        display: block;
        padding: .0rem 0rem;
        /* margin-bottom: -1px; */
        background-color: #fff;
        border: 0px solid rgba(0, 0, 0, .125);
    }

    .search_group {
        margin: 1px;
    }

    .arab {
        background-color: #efecd9;
    }

    .poetry {
        margin: auto;
        text-align: center;
        font-weight: bold;
        display: block;
        padding: 10px;
        font-size: 14px;
    }
</style>
<?php
$authors = $views['authors'];
$categories = $views['categories'];

?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twbs-pagination/1.4.2/jquery.twbsPagination.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twbs-pagination/1.4.2/jquery.twbsPagination.js"></script>

<section class="arab">
    <div class="container">
        <div class="row ">
            <div class="col-xl-3">
                <div class="my-3 p-3 bg-white rounded box-shadow">
                    <h6 class="border-bottom border-gray pb-2 mb-0">المؤلفين</h6>
                    <div id="emp_body">
                    </div>
                    <div id="pager">
                        <ul id="pagination" class="pagination-sm"></ul>
                    </div>
                </div>


            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-8 mx-auto form p-4">
                <div class="px-2">

                    <?php
                    $submit_url  = front_base . "arab-library/search";
                    $hide_others = true;
                    $title = 'نتائج البحث عن : ';
                    if (isset($term) && !empty($term)) {
                        $title .= $term;
                    }
                    if (isset($book_id) && !empty($book_id)) {
                        // $submit_url  = front_base . "arab-library/search/" . $book_id . "/" . $term;
                        $hide_others = false;
                        $title .= ' في كتاب : ' . $book_title;
                    }

                    ?>
                    <?php echo form_open(base_url($submit_url), array("method" => "POST",  "class" => "inline check_submit", "release" => "true",  "id" => "arab_form")); ?>
                    <div class="form-group row">
                        <div class="col-sm-10">
                            <input type="text" required name='term' value="<?php if (isset($term) && !empty($term)) {
                                                                                echo $term;
                                                                            } ?>" class="form-control form-control-lg" id="colFormLabelLg" placeholder="البحث ......">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" value="content" name='searchcheck' <?php if (!isset($searchcheck)) { ?>checked<?php } ?> <?php if (isset($searchcheck) && $searchcheck == 'content') { ?> checked <?php } ?>>
                            <label class="form-check-label" for="contentChk">
                                النص
                            </label>
                        </div>
                        <?php //if ($hide_others) { 
                        ?>
                        <?php if (false) { ?>

                            <div class="form-check">
                                <input class="form-check-input" type="radio" value="books" name='searchcheck' <?php if (isset($searchcheck) && $searchcheck == 'books') { ?> checked <?php } ?>>
                                <label class="form-check-label" for="booksChk">
                                    العنوان
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" value="authors" name='searchcheck' <?php if (isset($searchcheck) && $searchcheck == 'authors') { ?> checked <?php } ?>>
                                <label class="form-check-label" for="authorsChk">
                                    المؤلف
                                </label>
                            </div>
                        <?php } ?>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-10">
                            <button type="submit" class="btn btn-primary">البحث</button>
                        </div>
                    </div>
                    <?php echo form_close(); ?>

                </div>
            </div>
            <div class="col-xl-3">
                <div class="my-3 p-3 bg-white rounded box-shadow">
                    <h6 class="border-bottom border-gray pb-2 mb-0">التصنيفات</h6>
                    
                    <?php foreach($categories as $cat){?>
                        <div class="media text-muted pt-3">
                        <div class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
                            <div class="d-flex justify-content-between align-items-center w-100">
                                <strong class="text-gray-dark"><?php echo $cat->category;?></strong>
                                <a href="#">(<?php echo $cat->count;?>)</a>
                            </div>
                        </div>
                        </div>
                    <?php } ?>
                        
                    
                   
                </div>
            </div>
        </div>

        <script>
            var $pagination = '';
            $(document).ready(function() {
                $pagination = $('#pagination'),
                totalRecords = 0,
                records = [],
                displayRecords = [],
                recPerPage = 15,
                page = 1,
                totalPages = 0;
                data = <?php echo json_encode($authors) ?>;
                records = data;
                totalRecords = records.length;
                totalPages = Math.ceil(totalRecords / recPerPage);
                apply_pagination();


            });

            function generate_table() {
                var tr;
                $('#emp_body').html('');
                for (var i = 0; i < displayRecords.length; i++) {
                    var item_auth = '<div class="media text-muted pt-3"><div class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray"><div class="d-flex justify-content-between align-items-center w-100"><strong class="text-gray-dark">' + displayRecords[i].book_author + '</strong><a href="#">(' + displayRecords[i].count + ')</a></div></div></div>';
                    var tr = item_auth;
                    $('#emp_body').append(tr);
                }
            }

            function apply_pagination() {
                $pagination.twbsPagination({
                totalPages: totalPages,
                visiblePages: 6,
                first: '',
                prev: '<<',
                next: '>>',
                last: '',
                onPageClick: function(event, page) {
                    displayRecordsIndex = Math.max(page - 1, 0) * recPerPage;
                    endRec = (displayRecordsIndex) + recPerPage;
                    displayRecords = records.slice(displayRecordsIndex, endRec);
                    generate_table();
                }
                });
            }
        </script>

    </div>
</section>
<section class="arab">
    <div class="container">
        <?php if (!empty($title)) { ?>
            <div class="small" style="padding: 1%;padding-right: 2%;">
                <div class="row">
                    <div class="col-12">
                        <div class="card-header">
                            <div class="card-title m-0"><i class="fa fa-caret-left text-info"></i>
                                <?php echo $title; ?>
                            </div>
                            <span>
                                <?php
                                $total = 0;
                                foreach ($results_summary as $index => $element) {
                                    $total = $total + $element->count;
                                } ?>
                                <?php if (!empty($results_summary)) {
                                    echo "نتيجة البحث هي " . count($results_summary) . ' كتاب' . ' أجمالي التكرار ' . $total;
                                } ?>

                            </span>

                        </div>

                    </div>
                </div>
            </div>
        <?php } ?>

        <!-- listing table of the results summary  -->


        <?php
        if (isset($results_summary) && $results_summary != null) { ?>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">الكتاب</th>
                        <th scope="col">المؤلف</th>
                        <th scope="col">التكرار</th>
                    </tr>
                </thead>
                <tbody>


                    <?php foreach ($results_summary as $index => $element) {

                    ?>
                        <tr>
                            <th scope="row"><?php echo $index + 1; ?></th>
                            <td> <a class="btn search_group" role="button" href="<?php echo front_base . "arab-library/search/" . $element->book_id . "/" . urlencode($term);  ?>">

                                    <?php echo $element->book_title; ?> </a></td>
                            <td><?php echo $element->book_author; ?></td>
                            <td><?php echo $element->count; ?> </td>
                        </tr>

                    <?php } ?>
                </tbody>
            </table>
        <?php
        }
        ?>
        <!-- End of listing table of the results summary  -->


        <?php if (isset($results) && $results != null) { ?>
            <ul class="list-group">
                <?php
                foreach ($results as $item) { ?>

                    <?php if ($searchcheck == 'content') { ?>


                        <?php $term_pos = strpos($item->content, $term);
                        //$result = mb_substr($item->content, $term_pos - 100, strlen($term) + 1000);
                        if ($term_pos <= 100) {
                            $result = $item->content;
                        } else {
                            $result = substr($item->content, $term_pos - 100, strlen($term) + 1000);
                        }

                        ?>
                        <li class="list-group-item" style="display: none;">
                            <div class="small bg-gray" style="padding: 1%;padding-right: 2%;">
                                <div class="row">
                                    <div class="col-12">
                                        <span><?php echo $item->sec_title; ?></span> |
                                        <span><?php echo $item->book_author; ?></span> |
                                        <span><?php echo $item->sub_category; ?></span>
                                    </div>

                                </div>
                                <p class="cont_result"><?php echo  str_replace($term, "<span style='background-color:yellow'>" . $term . '</span>', $result); ?></p>
                        </li>
                        <div class="card">
                            <h5 class="card-header"><?php echo $item->sec_title; ?></h5>

                            <div class="card-body">

                                <p class="card-text"><?php echo  str_replace($term, "<span style='background-color:yellow'>" . $term . '</span>', $result); ?></p>
                                <a href="https://ddl.ae/uploads/books/<?php echo $item->id; ?>.html" class="btn btn-primary">تصفح الكتاب</a>

                            </div>
                        </div>



                    <?php } else if ($searchcheck == 'books') { ?>
                        <li class="list-group-item ">
                            <p>
                                <span><?php echo $item->book_title; ?></span> |
                                <span><?php echo $item->sub_category; ?></span> |
                                <span><?php echo $item->book_author; ?></span>
                            </p>
                            <p><span style="color:red;">مقدمة الكتاب : </span><?php echo $item->abstract; ?></p>

                        </li>
                    <?php } else if ($searchcheck == 'authors') { ?>
                        <li class="list-group-item">
                            <p>
                                <span><?php echo $item->book_title; ?></span> |
                                <span><?php echo $item->book_author; ?></span> |
                                <span><?php echo $item->sub_category; ?></span>
                            </p>
                            <p><span style="color:red;">مقدمة الكتاب : </span><?php echo $item->abstract; ?></p>
                        </li>
                    <?php } ?>


                <?php } ?>

            </ul>
        <?php  } ?>
        <?php if (isset($results) && empty($results)) {
        ?>
            <div class="row">
                <div class="col-12">
                    <div class="card card-default mt-4">
                        <div class="card-body text-center">
                            <h1 class="no-items mb-3"><i class="fa fa-exclamation-circle fa-4x"></i></h1>
                            <h3 class="no-items">لا توجد نتائج بحث</h3>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</section>

<script>
    function loadsection(book_it, term) {

    }
</script>