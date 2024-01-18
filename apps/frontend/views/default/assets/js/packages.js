$(document).ready(function() {

    recalculate_price();

    $(document).on("change","input.packs",function(){
        var pack_id = $(this).val();
        if($(this).prop("checked") == true){
            $("#package_"+pack_id).addClass("selected");
        }else if($(this).prop("checked") == false){
            $("#package_"+pack_id).removeClass("selected");
        }
 
        recalculate_price();
    });
    
    
    $(document).on("change",".subscribe_plan [name='subscribe_plan']",function(){
        var plan = $(this).val();
        $(".subscribe_plan").removeClass("selected");
        $("#subscribe_plan_"+plan).addClass("selected");
        
        $(".packages-list").find(".package_price").addClass("d-none");
        $(".packages-list").find(".package_price."+plan).removeClass("d-none");
 
        recalculate_price();
    });
    
    
    
    function recalculate_price(){

        var plan = $(".subscribe_plan input[name='subscribe_plan']:checked").val();
        var total_price = 0;
        $( ".single-package .packs" ).each( function( index, element ){            
            if($(this).prop("checked") == true){
                total_price += $(this).data("price-"+plan);
            }                        
        });        
        $("#total_price").text(total_price);        
        if(total_price){
            $("button#create_order").attr("disabled",false);   
        }else{
            $("button#create_order").attr("disabled",true);   
        }
    }
    

    $(document).on("submit","form#packages",function(){
        var packs = [];
        $( ".single-package .packs" ).each( function( index, element ){            
            if($(this).prop("checked") == true){
                packs.push($(this).val());
            }
        });        
        
        if(packs.length > 0){
            return true;    
        }else{
            event.preventDefault();
            return false;
        }
        
    });
    
    
  
    


});