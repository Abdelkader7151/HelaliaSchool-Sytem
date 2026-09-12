 <script src="../tinymce/tinymce.min.js?apiKey=fxbzsitekdpkx9yo4ubi22npgudz98xam5yif6nyw75520kv"></script> 

  <script>
	  tinymce.init({
    selector: ".text_editor",
    theme: "modern",
    skin: "custom", 
    height: 500, 
    browser_spellcheck: true,
    gecko_spellcheck: true,
    plugins: [
         "advlist autolink link image lists charmap print preview hr anchor pagebreak",
         "searchreplace wordcount visualblocks visualchars insertdatetime media nonbreaking",
         "table contextmenu directionality emoticons paste textcolor responsivefilemanager code"
   ],
   toolbar1: "undo redo | bold italic underline | size    | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | styleselect | table",
   toolbar2: "| responsivefilemanager | link unlink anchor | image media | forecolor backcolor  | print preview code ",
   image_advtab: true ,     
   
   external_filemanager_path:"../filemanager/",
   filemanager_title:"Filemanager" ,
   external_plugins: { "filemanager" : "../filemanager/plugin.min.js"},
   
   style_formats: [
       {title: 'h1', block: 'h1'},
	   {title: 'h2', block: 'h2'},
	   {title: 'h3', block: 'h3'},
	   {title: 'h4', block: 'h4'},
	   {title: 'h5', block: 'h4'},
	   {title: 'h6', block: 'h4'},
	   {title: 'paragraph', block: 'p'},
	    {title: 'Capitalize', inline: 'span', styles: {'text-transform': 'capitalize'}},
   {title: 'Capital Letters', inline: 'span', styles: {'text-transform': 'uppercase'}},
   {title: 'Image Right', inline: 'span', styles: {'float': 'right','margin': '0px 0px 10px 10px'}},
   {title: 'Image Left', inline: 'span', styles: {'float': 'left','margin': '0px 10px 10px 0px'}},
   {title: 'Remove Underline', selector: 'a', styles: {'text-decoration': 'none'}},
	   
	   
	    //{title: 'Bold text', inline: 'b'},
        //{title: 'Red text', inline: 'span', styles: {color: '#ff0000'}},
        //{title: 'Red header', block: 'h1', styles: {color: '#ff0000'}},
        //{title: 'Example 1', inline: 'h2', classes: 'example1'},
        //{title: 'Example 2', inline: 'span', classes: 'example2'},
        //{title: 'Table styles'},
        //{title: 'Table row 1', selector: 'tr', classes: 'tablerow1'}
    ]
 });
 
   tinymce.init({
    selector: ".text_editor2",
    theme: "modern",
    skin: "custom", 
    height: 300,
	max_height: 500, 
    browser_spellcheck: true,
    gecko_spellcheck: true,
    plugins: [
         "advlist autolink link image lists charmap print preview hr anchor pagebreak",
         "searchreplace wordcount visualblocks visualchars insertdatetime media nonbreaking",
         "table contextmenu directionality emoticons paste textcolor responsivefilemanager code"
   ],
   toolbar1: "undo redo | bold italic underline | size    | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | styleselect | table",
   toolbar2: "| responsivefilemanager | link unlink anchor | image media | forecolor backcolor  | print preview code ",
   image_advtab: true ,     
   
   external_filemanager_path:"../filemanager/",
   filemanager_title:"Filemanager" ,
   external_plugins: { "filemanager" : "../filemanager/plugin.min.js"}
 });
</script>