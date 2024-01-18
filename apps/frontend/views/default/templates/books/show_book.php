<?php if ($book && is_object($book) && @$book->hasData()) { ?>

    <?php //prnt($book->getRelatedPartsLink()); 
    ?>

    <?php $meta = $book->metadata; ?>

    <div id="single_book_page">

        <div class="card card-default single_book mt-4">

            <div class="card-body">

                <div class="media media-responsive">

                    <div class="align-self-start image-container">

                        <img class=" img-thumbnail img-fluid cover" style="padding: 0px;" src="<?php echo $book->getFileCover() ?>" alt="<?php echo word("cover") . " " . word_limiter($book->getTitle(), 4, ""); ?>">

                        <div class="d-block text-center mt-4 mb-2">
                            <?php $this->load->view(style . '/templates/books/parts/social_icons', array("book" => $book)); ?>
                        </div>

                        <?php if ($book->hasCitation()) { ?>
                            <p class="mt-0 mb-1">

                                <div class="text-center">
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#citation_modal">
                                        <i class="fa fa-quote-right"></i> <?php echo word("citation") ?>
                                    </button>
                                </div>

                                <div class="modal fade" id="citation_modal" tabindex="-1" role="dialog" aria-labelledby="citation_modal_label" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-body">

                                                <?php if (is_array($book->getCitation())) { ?>

                                                    <?php foreach ($book->getCitation() as $ref => $citation) { ?>

                                                        <div class="form-group">
                                                            <div class="ltr text-left">
                                                                <code><?php echo $ref; ?></code>
                                                            </div>
                                                            <blockquote><?php echo $citation; ?></blockquote>
                                                        </div>

                                                    <?php } ?>

                                                <?php } ?>

                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </p>
                        <?php } ?>



                        <?php if ($book->hasBrowseFT()) { ?>
                            <p class="mt-0 mb-1">
                                <div class="text-center">
                                    <a target="blank" href="http://159.89.167.125/ddladmin/z3950/BrowseFulltext/<?php echo $book->getId() ?>/" class="btn btn-warning">
                                        <i class="fa fa-search"></i><?php echo word("browseft") ?>
                                    </a>
                                </div>
                            </p>
                        <?php } ?>







                    </div>

                    <div class="media-body ">

                        <div class="row">

                            <div class="col-12 col-md-7">

                                <div class="mb-2 mt-md-0 mt-3 text-center text-md-<?php echo MyAlign; ?>">
                                    <h1 class="title"><?php echo $book->getTitle(); ?></h1>
                                </div>

                                <div class="mt-md-0 mt-3 text-center text-md-<?php echo MyAlign; ?>">
                                    <?php $this->load->view(style . '/templates/books/parts/cart_widget', array("book" => $book, "cart_btn" => "inline")); ?>
                                    <?php $this->load->view(style . '/templates/books/parts/addons_widget', array("journal_btns" => "inline", "chapters_btns" => "inline")); ?>
                                </div>

                            </div>

                            <div class="col-12 col-md-5">
                                <div class="text-center text-md-<?php echo OppAlign; ?>">
                                    <div class="d-inline-block">
                                        <div class="mb-2">
                                            <?php $this->load->view(style . '/templates/books/parts/fav_widget', array("book" => $book)); ?>
                                        </div>
                                        <?php $this->load->view(style . '/templates/books/parts/rating_widget', array("book" => $book)); ?>
                                    </div>
                                </div>
                            </div>

                        </div>


                        <hr />

                        <h6 class="text-muted "><i class="fa fa-caret-<?php echo OppAlign; ?> text-info"></i> <?php echo word("basic_information") ?></h6>

                        <?php if ($book->hasAuthor()) { ?>
                            <p class="mt-2"> <?php echo word("author") ?>: <?php echo $book->getAuthorLink(); ?></p>
                        <?php } ?>

                        <?php if ($book->hasPublisher()) { ?>
                            <p class="mt-0"><?php echo word("publisher") ?>: <?php echo $book->getPublisherLink(); ?> </p>
                        <?php } ?>

                        <?php if ($book->hasSeries()) { ?>
                            <p class="mt-0 mb-1"><?php echo word("series") ?>: <?php echo $book->getSeriesLink(); ?></p>
                        <?php } ?>

                        <?php if ($book->hasSource()) { ?>
                            <p class="mt-0 mb-0"> <?php echo word("sources") ?>: <?php echo $book->getSourceLink(); ?></p>
                        <?php } ?>

                        <?php if ($book->hasPublicationCity()) { ?>
                            <p class="mt-0"><?php echo word("publicationcity") ?>: <?php echo $book->getPublicationCityLink(); ?></p>
                        <?php } ?>

                        <?php if ($book->hasPublicationYear()) { ?>
                            <p class="mt-0"><?php echo word("publicationdate") ?>: <?php echo $book->getPublicationYearLink(); ?></p>
                        <?php } ?>

                        <?php if ($book->hasLanguage()) { ?>
                            <p class="mt-0 mb-0"><?php echo word("language") ?>: <?php echo $book->getLanguageLink(); ?></p>
                        <?php } ?>

                        <?php if ($book->getbibloType()) { ?>
                            <p class="mt-0 mb-0"><?php echo word("biblotype") ?>: <?php echo $book->getbibloTypeLink(); ?> </p>
                        <?php } ?>

                        <?php if ($book->getEdition()) { ?>
                            <p class="mt-0 mb-1"><?php echo word("edition") ?>: <?php echo $book->getEdition(); ?></p>
                        <?php } ?>

                        <?php if ($book->getNumberOfPages()) { ?>
                            <p class="mt-0 mb-0"><?php echo word("number_pages") ?>: <?php echo $book->getNumberOfPages(); ?> </p>
                        <?php } ?>

                        <?php /* if( $book->getNumberOfWords() ){ ?>                
                            <p class="mt-0 mb-0"><?php echo word("number_words") ?>: <?php echo $book->getNumberOfWords(); ?>   </p>
                        <?php } */ ?>

                        <?php if ($book->getReadingTime()) { ?>
                            <p class="mt-0 mb-0"><?php echo word("reading_time") ?>: <?php echo $book->getReadingTime(); ?> </p>
                        <?php } ?>

                        <?php if ($book->getIsbn()) { ?>
                            <p class="mt-0 mb-0"><?php echo word("isbn") ?>: <?php echo $book->getIsbn(); ?> </p>
                        <?php } ?>

                        <?php if ($book->getIssn()) { ?>
                            <p class="mt-0 mb-0"><?php echo word("issn") ?><?php echo $book->getIssn(); ?> </p>
                        <?php } ?>

                        <?php if ($book->hasSummary()) { ?>
                            <p class="mt-0 mb-1"><?php echo word("summary") ?>: <br><?php echo $book->getSummary(); ?></p>
                        <?php } ?>

                        <?php if ($book->hasCoAuthors()) { ?>
                            <hr />
                            <h6 class="text-muted "><i class="fa fa-caret-<?php echo OppAlign; ?> text-info"></i> <?php echo word("coauthors") ?></h6>
                            <?php echo $book->getCoAuthors(); ?>
                        <?php } ?>

                        <?php if ($book->hasClassifications()) { ?>
                            <hr />
                            <h6 class="text-muted "><i class="fa fa-caret-<?php echo OppAlign; ?> text-info"></i> <?php echo word("classification") ?></h6>
                            <?php echo $book->getClassificationsLinks(); ?>
                        <?php } ?>

                        <?php if ($book->hasSubjects()) { ?>
                            <hr />
                            <h6 class="text-muted "><i class="fa fa-caret-<?php echo OppAlign; ?> text-info"></i> <?php echo word("subjects") ?> </h6>
                            <?php foreach ($book->getSubjectsLinks() as $links) { ?>
                                <p><?php echo join(", ", $links); ?></p>
                            <?php } ?>
                        <?php } ?>

                        <?php if ($book->isFree() && $book->hasRelatedParts()) { ?>
                            <hr />
                            <ul class="list-group mb-4">
                                <?php foreach ($book->getRelatedPartsLink() as $file) { ?>
                                    <li class="list-group-item"><?php echo $file ?></li>
                                <?php } ?>
                            </ul>
                        <?php } ?>

                    </div>

                </div>

            </div>
                        
            <div class="card bg-light" id="ads" style="display: none;">
                <div class="card-body">
                    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item active"> 
                                <a target="_blank" href="https://qindeel.ae/ar/product/%D8%AA%D8%A7%D8%B1%D9%8A%D8%AE-%D8%A7%D9%84%D8%B9%D8%A7%D9%84%D9%85-%D9%81%D9%8A-12-%D8%AE%D8%B1%D9%8A%D8%B7%D8%A9/">
                                    <img src="//ddl.ae/assets/images/ads/Ads-02.jpg" class="d-block w-100" alt="ads">
                                </a>
                            </div>
                            <!-- <div class="carousel-item">
                                <img src="//ddl.ae/assets/images/ads/Ads-01.jpg" class="d-block w-100" alt="...">
                            </div>
                            <div class="carousel-item">
                                <img src="//ddl.ae/assets/images/ads/Ads-01.jpg" class="d-block w-100" alt="...">
                            </div> -->
                        </div>
                        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                </div>
            </div>
            <?php if ($book->hasSimilar()) { ?>
                <div class="card-footer" id="show_related_books">
                    <div>
                        <i class="fa fa-caret-<?php echo OppAlign; ?> text-info"></i> <?php echo word("interested_in") ?>
                    </div>
                    <div class="content_container text-<?php echo OppAlign; ?>">
                        <?php $this->load->view(style . '/templates/books/parts/related_books', array("books" => $book->getSimilar()));   ?>
                    </div>

                    <div class="text-center mt-4 mb-4">
                        <a href="<?php echo base_url(front_base . "book/similar/" . $book->getId()) ?>" class="btn btn-success"><?php echo word("discover_more") ?></a>
                    </div>
                </div>
            <?php } ?>


        </div>


    </div>


    <?php if (u_id == 2) { ?>
        <div class="text-<?php echo OppAlign; ?> mt-4">
            <?php //if(u_id == 2) prnt($book,FALSE);
            ?>
        </div>
    <?php } ?>

<?php } ?>






<script src="//cdnjs.cloudflare.com/ajax/libs/socket.io/2.2.0/socket.io.js" type="text/javascript"></script>
<script type="text/javascript">
    var socket = io.connect('//socket.ddl.ae:8080', {
        secure: true
    });
    var u_id = '<?php echo username ? username : "guest"; ?>';
    var room_id = "reading_book";

    socket.emit('set_u_id', u_id);
    socket.emit('set_room_id', room_id);
    socket.emit('set_book_data', {
        id: '<?php echo $book->getId() ?>',
        url: '<?php echo current_url() ?>',
        cover: '<?php echo $book->getFileCover("thumb") ?>',
        title: '<?php echo $book->getTitle(); ?>',
        author: '<?php echo $book->getAuthorLink(TRUE); ?>',
        reader: '<?php echo logged_in ? "user" : "guest"; ?>',
        reader_data: {
            fullname: '<?php echo fullname  ? fullname  : ""; ?>',
            u_photo: '<?php echo u_photo   ? u_photo   : ""; ?>',
            u_country: '<?php echo u_country ? u_country : ""; ?>',
        }
    });
</script>