
<?PHP
/******************************************************************************
To be able to run this sample code, you need to have the mysql database 
and insert a dummy record:

    CREATE DATABASE autosave;
    
    CREATE TABLE asave(
      user_id INT,
      saved_text TEXT
    );
    
    INSERT INTO asave(user_id, saved_text) VALUES (1, '');

******************************************************************************/

//replace with your user/pass to get a connection to your database
$db = mysql_connect("localhost:3306", "****" , "****");
mysql_select_db("autosave",$db) or die(mysql_error());

//your user_id is probably stored in your session...just replace
$user_id = 1;                                             

if($_SERVER["REQUEST_METHOD"]=="POST"){
    
    // Make sure you escape your saved data as you need it 
    // It is not done here, in the interest of brevity     
    
    $saved_text = mysql_real_escape_string($_POST["saved_text"]); 

    // Assume an entry in the DB table exists for this user.                        
    
    $sql = "UPDATE asave SET saved_text = '".$saved_text."' ";    
    $sql.= "WHERE user_id = $user_id";                            
    
    mysql_query($sql) or die(mysql_error().$sql);           

    echo "Your data has been saved ".date("h:m:s A");   
    exit;                                                   
}
//else implied by exit

// Get saved_text from the DB to display in the textarea

$sql = "SELECT saved_text FROM asave WHERE user_id = $user_id";
$rs = mysql_query($sql) or die(mysql_error().$sql);       
$arr = mysql_fetch_array($rs);
$saved_text = $arr["saved_text"];
?>
<html>
    <head>
    <script type="text/javascript">
        function init(){
            window.setInterval(autoSave,10000);                  // 10 seconds
        }
        function autoSave(){
            
            var saved_text = document.getElementById("saved_text").value;
            
            var params = "saved_text="+saved_text;
            var http = getHTTPObject();
            http.onreadystatechange = function(){
                if(http.readyState==4 && http.status==200){
                    msg = document.getElementById("msg");
                    msg.innerHTML = "<span onclick='this.style.display=\"none\";'>"+http.responseText+" (<u>close</u>)</span>";
                }
            };
            http.open("POST", window.location.href, true);
            http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            http.setRequestHeader("Content-length", params.length);
            http.setRequestHeader("Connection", "close");
            http.send(params);
        }
        
        //cross-browser xmlHTTP getter
        function getHTTPObject() { 
            var xmlhttp; 
            /*@cc_on 
            @if (@_jscript_version >= 5) 
                try { 
                    xmlhttp = new ActiveXObject("Msxml2.XMLHTTP"); 
                } 
                catch (e) { 
                    try { 
                        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP"); 
                    } 
                    catch (E) { 
                        xmlhttp = false; 
                    } 
                } 
            @else 
                xmlhttp = false; 
            @end @*/  
            
            if (!xmlhttp && typeof XMLHttpRequest != 'undefined') { 
                try {   
                    xmlhttp = new XMLHttpRequest(); 
                } catch (e) { 
                    xmlhttp = false; 
                } 
            } 
            
            return xmlhttp;
        }
    </script>
    </head>
    <body onload="init();">
        <span id="msg" style="cursor:pointer;"></span>
        <form method="POST">
            <textarea id="saved_text" name="saved_text" rows="10" cols="100"><?PHP echo $saved_text;?></textarea>
            <br/>
            <input type="submit" value="save now" />
        </form>
    </body>
</html>