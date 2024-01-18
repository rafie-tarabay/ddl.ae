


<nav class="navbar navbar-expand-lg navbar-dark bg-dark" id="toolbar">
    <a class="navbar-brand" href="#"><?php echo word("site_title") ?></a>
    
    <?php if(isset($back_url)){ ?>    
        <ul class="navbar-nav <?php echo MyAlign; ?>">
            <li class="nav-item">
                <a class="nav-link" href="<?php echo $back_url; ?>"><?php echo word("back") ?></a>
            </li>
        </ul>
    <?php } ?>

</nav>

<iframe id="iframePdfViewer" width="100%" height="auto" src="<?php echo $file; ?>" frameborder="0" allowfullscreen></iframe>

<style type="text/css">
    body{
        overflow: hidden !important;
    }
</style>

<script type="text/javascript">
    var $doc = null;    
    $(document).ready(function(){
        var toolbarHeight = $("#toolbar").height() + 10;
        $doc = $(this);
        $(window).resize(function () {
            updatePdfViewerHeight($(this).height()-5-toolbarHeight);
        });
        updatePdfViewerHeight( $doc.height() - 5-toolbarHeight);
    });
    function updatePdfViewerHeight(height){
        $doc.find('div#pdfViewer').css('height',height);
        $doc.find('#iframePdfViewer').css('height',height);
    }
    function loadPdf(url){
        $doc.find('#iframePdfViewer').attr('src',url);
    }
</script>
