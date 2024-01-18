

        <?php if($hide_layout == FALSE){ ?>

            <div id="side_slider" style="display: none;">
                <div class="slider_content">                            
                    <a rel="tooltip" title="" href="https://zonka.co/3Wq0wD" target="_blank"> 
                        <img class="img-fluid" src="<?php echo base_url("assets/images/qrcode.png") ?>"> 
                    </a>                    
                </div>            
                <div class="slider_btn">
                    <div class="toggler rounded" data-status="closed"><i class="fa fa-poll-h fa-3x"></i></div>
                </div>
            </div>

            <?php if($mobile_view == FALSE){ ?>

                <div id="site_footer" class="bg-gray-light">

                    <div class="container">
                            
                        <div class="row">
                        
                            <div class="col-md">
                            
                                <ul class="footer_links">
                                    <?php foreach($site_contents["footer"]["footer_links_1"] as $flink){ ?>
                                        <li>
                                            <a href="<?php echo base_url($flink->content_rel_url1); ?>"><i class="fa fa-caret-<?php echo OppAlign; ?> text-info"></i> <?php echo word($flink->content_rel_title1); ?></a>
                                        </li>
                                    <?php } ?>                                                        
                                </ul>
                            
                            </div>
                            
                            <div class="col-md">
                            
                                <ul class="footer_links">
                                    <?php foreach($site_contents["footer"]["footer_links_2"] as $flink){ ?>
                                        <li>
                                            <a href="<?php echo base_url($flink->content_rel_url1); ?>"><i class="fa fa-caret-<?php echo OppAlign; ?> text-info"></i> <?php echo word($flink->content_rel_title1); ?></a>
                                        </li>
                                    <?php } ?>                                                        
                                </ul>                 

                            </div>
                            
                            <div class="col-md text-<?php echo OppAlign; ?>"> 
                                <div class="logo_box">
                                    <a href="<?php echo base_url(); ?>"><img class="logo" src="<?php echo base_url("assets/images/logos/logo_transparent.png") ?>" /></a>                    
                                </div>                
                            </div>
                            <div class="col-md text-<?php echo OppAlign; ?>">
                                 <div class="logo_box">
                                    <a href="<?php echo base_url(); ?>"><img class="logo" src="<?php echo base_url("assets/images/logos/right.jpeg") ?>" /></a>                    
                                </div>                        
                            </div>
                        </div>
                        
                    </div>


                </div>

                <div id="sub_footer" class="bg-black">

                    <div class="container">
                        
                        <div class="row">
                            <div class="col-4">
                            
                            </div>
                            <div class="col-4">
                            
                            </div>                    
                            <div class="col-4 text-<?php echo OppAlign; ?>">                        
                                <?php foreach($site_contents["nav"]["social_links"] as $social){ ?>
                                    <a href="<?php echo $social->content_rel_url1 ?>" class="social_icon"><i class="<?php echo $social->content_rel_title2 ?>"></i></a>                
                                <?php } ?>
                            </div>                
                        </div>
                        
                    </div>

                </div>
            
            <?php } ?>
            
        <?php } ?>
          
          
          
        <!--<style>.async-hide { opacity: 0 !important} </style>
        <script>(function(a,s,y,n,c,h,i,d,e){s.className+=' '+y;h.start=1*new Date;
        h.end=i=function(){s.className=s.className.replace(RegExp(' ?'+y),'')};
        (a[n]=a[n]||[]).hide=h;setTimeout(function(){i();h.end=null},c);h.timeout=c;
        })(window,document.documentElement,'async-hide','dataLayer',4000,
        {'GTM-PGLM57X':true});</script>          -->

        <?php if ( $_SERVER["HTTP_HOST"] == "ddl.mbrf.ae"){ ?>        

		<!-- Global site tag (gtag.js) - Google Analytics -->
		<script async src="https://www.googletagmanager.com/gtag/js?id=UA-155953193-1"></script>
		<script>
		  window.dataLayer = window.dataLayer || [];
		  function gtag(){dataLayer.push(arguments);}
		  gtag('js', new Date());

		  gtag('config', 'UA-155953193-1');
		</script>

<?php } elseif( settings("localhost") == FALSE ){ ?>
            <script async src="//www.googletagmanager.com/gtag/js?id=UA-119249380-1"></script>
            <script>
              window.dataLayer = window.dataLayer || [];
              function gtag(){dataLayer.push(arguments);}
              gtag('js', new Date());
              //ga('require', 'GTM-PGLM57X');
              gtag('config', 'UA-119249380-1');
            </script>
        <?php } ?>

        
        <script src="<?php echo no_protocol(base_url("assets/libs/masonry/masonry.pkgd.min.js?v=".settings("refresh"))); ?>"></script>        
        <script src="<?php echo no_protocol(base_url("assets/libs/masonry/config.js?v=".settings("refresh"))); ?>"></script>            
        
        
        <!-- Start of  Zendesk Widget script -->
        <?php if( settings("localhost") == FALSE ){ ?>
            <script id="ze-snippet" src="//static.zdassets.com/ekr/snippet.js?key=a185f571-cd52-4b05-8756-d90f95068fbe"> </script>
            <script>
                zE('webWidget', 'setLocale', '<?php echo locale == "ar" ? "ar" : "en"; ?>');
            </script>
        <?php } ?>
        <!-- End of  Zendesk Widget script -->        
            

            
    <!-- The core Firebase JS SDK is always required and must be listed first -->
    <script src="https://www.gstatic.com/firebasejs/8.2.1/firebase-app.js"></script>

    <!-- TODO: Add SDKs for Firebase products that you want to use
        https://firebase.google.com/docs/web/setup#available-libraries -->

    <script>
        // Your web app's Firebase configuration
        var firebaseConfig = {
            apiKey: "AIzaSyDrTqRac_c4Mt-3lBnuzMGtH1WBpKqywbU",
            authDomain: "ddl-en.firebaseapp.com",
            databaseURL: "https://ddl-en.firebaseio.com",
            projectId: "ddl-en",
            storageBucket: "ddl-en.appspot.com",
            messagingSenderId: "197981693812",
            appId: "1:197981693812:web:ec9e5c53089e933dc86e21"
        };
        // Initialize Firebase
        firebase.initializeApp(firebaseConfig);
    </script>


<!-- Modal -->
<div id="knowledgesummit" class="modal fade" role="document">
        <div class="modal-dialog modal-dialog-centered"  >

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                     <span class="modal-title float-right"><?php echo word('ks_title'); ?></span>
                </div>
                <div class="modal-body">
                    
                    <?php if(OppAlign == 'left'){ ?>
                        <a href='https://mbrf.ae/ykf/ar/join'>
                            <img src="https://mbrf.ae/storage/ar_inv.jpeg"  class="img-fluid" alt="<?php echo word('ks_title'); ?>">
                        </a>
                    <?php } else{ ?> 
                        <a href='https://mbrf.ae/ykf/en/join'>
                            <img src="https://mbrf.ae/storage/en_inv.jpeg"  class="img-fluid" alt="<?php echo word('ks_title'); ?>">
                        </a>
                    <?php } ?>
                   
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo word('close'); ?></button>
                    <?php if(OppAlign == 'left'){ ?>
                        <a target="_blank" class="btn btn-primary" href='https://mbrf.ae/ykf/ar/join'>
                        <?php echo word('ks_register'); ?></a> 
                    <?php } else{ ?> 
                        <a target="_blank" class="btn btn-primary" href='https://mbrf.ae/ykf/en/join'>
                        <?php echo word('ks_register'); ?></a> 
                    <?php } ?>
                          
                </div>
            </div>
        </div>
    </div> 
    <!-- <script type="text/javascript">
        <?php //if ($mobile_view == FALSE) {  ?>    
            $(document).ready(function(){
                 $('#knowledgesummit').modal('show');
            });
        <?php //} ?>
    </script> -->
    </body>
   </html>
