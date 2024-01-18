$(document).ready(function() {
    
    $('#advanced_form .multiselect').multiselect({
        buttonText: function(options, select) {
            if (options.length === 0) {
                return word["all"];
            }else if (options.length > 0) {
                return word["no_of_choices"]+': ['+options.length +']';
            }            
        },

        enableFiltering: false,
        maxHeight: 250,        
        
    });
    
    
    var fields_max = 6;
    var fields_count = 2;
    
    $(document).on("click", '#advanced_form #add_field' , function(event){    
       
       if(fields_max > fields_count){
        
           var clone = $(".search_box").last().clone();
           var clone_html = clone.wrap("<div />").parent().html();
           
           var old_id = clone.data("id");
           
           var randLetter = String.fromCharCode(65 + Math.floor(Math.random() * 26));
           var uniqid = randLetter + Date.now();              
           var new_id = uniqid;
                                    
           var regex = new RegExp(old_id, 'g');       
           clone_html = clone_html.replace(regex,new_id)
           
           clone = $(clone_html).removeClass("removable-0").addClass("secondry removable-1");
           
           $("#advanced_inputs").append(clone);
           
           console.log(old_id);
           console.log(new_id);
            
           fields_count++;
       
       }

       if(fields_count >= fields_max ){
           $("#advanced_form #add_field").hide();
       }       
       
    });  
    
      
    $(document).on("click", '#advanced_form .remove_field' , function(event){    
                            
       var box_id = $(this).data("id");
       
       $("#box_"+box_id).remove();

       $("#advanced_form #add_field").show();
       
       fields_count--;

    });
    
    
});