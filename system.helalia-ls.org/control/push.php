<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#pushmyModal" style="margin-top: -80px; z-index:1000; position:absolute"> Send Message </button>
   <h4 id="sent" style="display: none ; color:green"><i class="fa fa-check-square-o" aria-hidden="true"></i> Message Sent Successfuly to <span id="data"></span></h4>
   <h4 id="error" style="display: none ; color:red"><i class="fa fa-times-circle-o" aria-hidden="true"></i> Message cannot be empty</h4>
<!-- The Modal --> 
<div class="modal" id="pushmyModal">
  <div class="modal-dialog modal-md">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Push Notification</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
      <h3> Title </h3>
        <div>
           <input id="title" type="text" style="width: 300px" required >
        </div>
     

        <h3> Message </h3>
        <div >
            <textarea id="msg"  rows="5" style="width: 97%;" required></textarea>
        </div>

        <h3> Target </h3>
        <div style="width: 100%;" >
            <select  id="target" style="padding: 10px;" required >
                <option selected   >...</option>  
                      <option value="0" > بريسكول</option> 
                      <option value="1" > اولى حضانة</option> 
                      <option value="2" > ثانية حضانة</option> 
                      <option value="3" >  الصف الاول الابتدائى</option> 
                      <option value="4" >  الصف الثانى الابتدائى</option> 
                      <option value="5" >  الصف الثالث الابتدائى</option> 
                      <option value="6" >  الصف الرابع الابتدائى</option> 
                      <option value="7" >  الصف الخامس الابتدائى</option> 
                      <option value="8" >  الصف السادس الابتدائى</option> 
                      <option value="9" >  الصف الاول الاعدادى</option> 
                      <option value="10" >  الصف الثاني الاعدادى</option> 
                      <option value="11" >  الصف الثالث الاعدادى</option> 
                      <option value="12" >  الصف الاول الثانوى</option> 
                      <option value="13" >  الصف الثاني الثانوى</option> 
                      <option value="14" >  الصف الثالث الثانوى</option>  
            </select>
        </div>
    
        <h3> class </h3>
        <div style="width: 100%;" id="class_box">
            <select id="class" style="padding: 10px;" required > 
            </select>
        </div>


        
      </div>

      <!-- Modal footer -->
      <div class="modal-footer" style="width: 100%;">
        <button type="button" data-dismiss="modal" id="send" style="float: left !important"><i class="fa fa-paper-plane-o" aria-hidden="true"></i> SEND</button>   
        <button type="button" data-dismiss="modal" class="btn btn-danger"  >Close</button> 
      </div>

    </div>
  </div>
</div>

 
	 <script> 
	  $(document).ready(function(){ 

 
        $('#pushmyModal').on('change', '#target', function (event) {    
            var year = $(this).val();   
            $.post("push_getclass.php",
                {
                 year:year
                },
                function(Date,status){ 
                    $("#class_box").html(Date); 
                });
             
       });


       $('#pushmyModal').on('click', '#send', function (event) { 

            var title = $("#title").val();   
            var msg = $("#msg").val();   
            var target = $("#target").val();
            var classes = $("#class").val(); 
            
            if(title.length > 0 && msg.length > 0 && target.length > 0 && classes.length > 0 ){ 

            $.post("push_send.php",
                {
                    title:title,
                    msg:msg,
                    target:target,
                    classes:classes 
                },
                function(Date,status){ 
                     $("#title").val('');   
                     $("#msg").val('');   
                     $("#target").prop("selectedIndex", 0);
                     $("#class").prop("selectedIndex", 0); 
                     $("#data").html(Date);
                     $("#error").fadeOut();
                     $("#sent").fadeIn();

                });
            }else{
                $("#error").fadeIn();
            }
             
       });
  


	  });
    </script> 
 