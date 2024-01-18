
$(document).ready(function(){   

    $("[rel=tooltip]").tooltip({html:true});


    $(document).on("submit",'.edit_lang_word',function(event){ 

        event.preventDefault();   

        var trans = new Object();

        var form = $(this);
        $(langs).each(function( index ){                
            trans[langs[index]] = form.find("#word_"+langs[index]).val();
        });      

        var word_alias = form.find("#word_alias").val();

        form.find(".loading-icon").addClass("fa-spin fa-refresh");

        $.post(admin_base+"language/update_word", { 
            trans : trans ,
            word_alias : word_alias,
            ajax : 1,
            csrf_token : csrf_token  
            }, function(data) {  

                form.find(".loading-icon").removeClass("fa-spin fa-refresh").addClass("fa-check");

        });                


    });   


    $('.navbar .dropdown-menu').click(function(event){
        event.stopPropagation();
    });



    $( ".toggle_password" ).change(function() {
            
        var toggler = $(this);
        var target = $(this).data("target");
        if(toggler.is(':checked')){
            $("#"+target).attr("type","text");
            
        }else{                        
            $("#"+target).attr("type","password");
        }

    }).change();        


    $(".sure").click(function(event){

        var x=window.confirm("هل أنت متأكد ؟")

        if (x){                            

            return true;

        }else{

            event.preventDefault();
            return false;
        }           

    });


      


});