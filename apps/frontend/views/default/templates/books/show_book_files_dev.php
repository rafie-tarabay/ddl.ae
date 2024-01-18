<style>
a:hover{
    text-decoration: none;
}
</style>
<div class="mt-4">                    

    <div class="card card-default mb-4">
        <div class="card-header">
            <a href="<?php echo  base_url(front_base.'book/'.$book->getId()) ?>">
                <i class="fa fa-caret-<?php echo OppAlign; ?>"></i> <?php echo $book->getTitle(); ?>
            </a>
        </div>
    </div>                  
                 
    <?php if($book->getbibloTypeId() == 13 ){ ?>

        <div class="list-group mb-4 text-<?php echo OppAlign; ?>">
            <div class="list-group-item text-center">
                <img class="img-fluid" src="<?php echo $book->getFileCover(); ?>" alt="<?php echo word("cover")." ".word_limiter($book->getTitle(),4,""); ?>" />
            </div>                        
        </div>        

    <?php }else{ ?>


        <?php  if($book->isFree() && $book->hasRelatedParts()){ ?>
            <ul class="list-group mb-4 ">
                <?php foreach($book->getRelatedPartsLink() as $file){ ?>
                    <li class="list-group-item"><?php echo $file ?></li>                        
                <?php } ?>
            </ul>        
        <?php } ?>

        
        <?php if(@$files["related"] && $book->hasRelatedFiles() ){ ?>
            <ul class="list-group mb-4 text">
                <?php foreach($book->getRelatedFilesLink() as $file){ ?>
                    <li class="list-group-item"><?php echo $file ?></li>                        
                <?php } ?>
            </ul>    
        <?php } ?>        
        


        <script>

            $( document ).ready(function() {
                var time_limit = parseInt('<?php echo ( (url_timeout - 2) * 1000 ) ?>');
                
                setInterval(function() { 
                    setTimeout(function(){ 
                        window.location.reload();
                        }, 2000);        
                    nice_alert("loading","جاري تحديث الروابط");
                    }, time_limit ); 
            })
        </script>
        
    <?php } ?>
    
</div>
    