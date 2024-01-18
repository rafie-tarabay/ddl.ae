tinymce.init({
    selector: "textarea.editor",
    theme: "modern",
    skin : "lightgray",

    plugins: [
        "advlist autolink link image lists charmap print preview hr anchor pagebreak autosave",
        "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
        "save table contextmenu directionality template paste textcolor"
    ],
    
    toolbar: "fontsizeselect | rtl ltr | alignright  aligncenter alignleft | image link unlink | forecolor backcolor |  removeformat bold italic bullist | restoredraft ",

    language : "ar",
    directionality : "rtl",
    //skin : 'charcoal',

    autoresize_on_init: true,
    autoresize_max_height: 300,
    autoresize_min_height: 100,

    //paste_as_text: true,

    statusbar : true,
    resize: true,

    menubar:true,   

    entity_encoding: "raw",
    relative_urls : false,
    urlconverter_callback : 'myCustomURLConverter',

    body_class :"topic-body",

    inline: false,


}); 


function myCustomURLConverter(url, node, on_save, name) {
  return url;
}
