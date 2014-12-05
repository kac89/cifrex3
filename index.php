
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>cIFrex 3.0 Regular Expression SwA</title>
        
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.0/js/bootstrap.min.js"></script>
        <script type='text/javascript' src='js/bootstrap-multiselect.js'></script>
        
        <link href='css/bootstrap.css' rel='stylesheet' type='text/css'/>
        <link rel='stylesheet' href='css/bootstrap-multiselect.css' type='text/css'/>
        
      	<style>
		.back-to-top {
			position: fixed;
			bottom: 2em;
			right: 0px;
			text-decoration: none;
			color: #000000;
			background-color: rgba(235, 235, 235, 0.80);
			font-size: 12px;
			padding: 1em;
			display: none;
		}

		.back-to-top:hover {	
			background-color: rgba(135, 135, 135, 0.50);
		}	
	</style>
</head>

<BODY>
    <div class="container">
<!-- HEADER/ LOGO -->
        <div class="row">
            <div class="col-xs-6" align="right"><br><A HREF="http://cifrex.org/" Title="cIFrex manual"><IMG src="http://cxsecurity.com/images/cifrex/logo.jpg" class="img-responsive" ALT="man cIFrex" width="300" height="180"></A></div>
            <br>
            <div class="col-xs-6">
                <blockquote>
                    <p><FONT color="RED">cif</FONT><FONT color="#ECC900">rex</FONT><FONT color="GREEN">.org</FONT> 3.0</b><br>Free Regular Expression Research (SwA)<BR><A href="http://cifrex.org/"><FONT color="GREEN">http://cifrex.org/</FONT></A></p>
                </blockquote>
            </div>

        </div>
<!-- HEADER/ LOGO -->        
        
        

            
            
    <div class="row">
        <div class="col-lg-1" align="right"><label for="directory" class="col-lg-1">Directory:</label></div>
        <div class="col-lg-8"><INPUT type="text" id="katalog" class="form-control input-sm" id="directory" placeholder="Directory" value="/"></div>
        <div class="col-lg-2"><label>Silent Mode: <INPUT type="checkbox" id="silent" value="silent" checked="checked"></label></div>
      </div>
            
            
    <div class="row">
        <div class="col-lg-1"><label class="col-lg-1">What:</label></div>
        <div class="col-lg-10" align="left">
        <label>C/C++: <input type="checkbox" class="ext" name="cin" value="1"></label>
        <label>PHP: <INPUT type="checkbox" class="ext" name="phpin" value="1"></label>
        <label>Perl: <INPUT type="checkbox" class="ext" name="perlin" value="1"></label>
        <label>JAVA/JSP: <INPUT type="checkbox" class="ext" name="jin" value="1"></label>
        <label>*: <INPUT type="checkbox" class="ext" name="allin" value="1"></label>
        <label>Other: <INPUT type="checkbox" class="ext" name="writeotherin" value="1"></label>
        <INPUT type="text" name="otherexin" value="" size="5">
      </div>
      </div>   
 
     <div class="row">
        <div class="col-lg-1"><label class="col-lg-1">Filters:</label></div>
        <div class="col-lg-10">
<div class="input-group"><select id="select" multiple="multiple">
<?php

    $stack1 = array();
    $stack2 = array();
    
    $json = file_get_contents("http://127.0.0.1/cifrex3/filters/filters.json");
    $obj = json_decode($json,TRUE);
        foreach($obj as $key => $item){
            array_push($stack1, $obj[$key]['env']);
            array_push($stack2, array($obj[$key]['id'], $obj[$key]['title'], $obj[$key]['env'], $obj[$key]['cwe']));
        }
				$stack1 = array_unique($stack1);

				foreach ($stack1 as $value) {
                    
                    echo "<optgroup label='".(!empty($value) ? $value : 'else')."'>";
                            foreach ($stack2 as $valuek) {
                            if($value == $valuek[2]){
                            echo '<option value="'.$valuek[0].'">'.$valuek[3].' '.$valuek[1].'</option>';
                            }
                            }
                }

                unset($stack1);
				unset($stack2);
                      
?>
    </select><button class="btn btn-warning" type="button">Update</button></div>
  

      </div>
      </div>              
            
<!-- TABLE --> 
    <div id="tabeladiv">
          <div class="table-responsive">
            <TABLE class="table table-striped">
                <thead>
                    <tr>
                        <th>V:</th>
                        <th>T:</th>
                        <th>F:</th>
                    </tr>
                </thead>

            <tbody>
                <tr>
                    <td>1 (Required)<BR><INPUT type="text" class="form-control input-sm" name="value1" id="v1" size="50" value=""></td>
                    <td>1<BR><INPUT type="text" name="true1" class="form-control input-sm" id="t1" size="50" value=""></td>
                    <td>1<BR><INPUT type="text" name="false1" class="form-control input-sm" id="f1" size="50" value=""></td>
                </tr>
                <tr>
                    <td>2<BR><INPUT type="text" name="value2" class="form-control input-sm" id="v2" size="50" value=""></td>
                    <td>2<BR><INPUT type="text" name="true2" class="form-control input-sm" id="t2" size="50" value=""></td>
                    <td>2<BR><INPUT type="text" name="false2" class="form-control input-sm" id="f2" size="50" value=""></td>
                </tr>
                <tr>
                    <td>3<BR><INPUT type="text" name="value3" class="form-control input-sm" id="v3" size="50" value=""></td>
                    <td>3<BR><INPUT type="text" name="true3" class="form-control input-sm" id="t3" size="50" value=""></td>
                    <td>3<BR><INPUT type="text" name="false3" class="form-control input-sm" id="f3" size="50" value=""></td>
                </tr>

            </tbody>

            </TABLE>

        </div>          
    
<!-- TABLE -->         
			<div class="row">

				<div class="col-md-6"><a href="#" class="btn btn-default btn-sm" id="savefilter">Save Filter</a><INPUT type="submit" class="btn btn-default btn-sm" name="sendtocx" value="Send to Regexp-db"></div>
            
            </div>
                
</div>    
    <center>
        <button id="start_cifrex" class="btn btn-primary" name="trythispatterns" data-loading-text="Loading..." type="button"> Start! </button>         </center><br>
        
        <div id="wyniki"></div>
        <a href="#" class="back-to-top">Back to Top</a>
    </div>
        
        
        
        
<script type="text/javascript">
    $(document).ready(function() {
        
				var offset = 220;
				var duration = 500;
				jQuery(window).scroll(function() {
					if (jQuery(this).scrollTop() > offset) {
						jQuery('.back-to-top').fadeIn(duration);
					} else {
						jQuery('.back-to-top').fadeOut(duration);
					}
				});
				
				jQuery('.back-to-top').click(function(event) {
					event.preventDefault();
					jQuery('html, body').animate({scrollTop: 0}, duration);
					return false;
				})
        
function scrollto(element){
     $('html, body').animate({ scrollTop: ($(element).offset().top)}, 'slow');
};  
        
        
                        $('#select').multiselect({
                                    maxHeight: 300,
                                    //includeSelectAllOption: true,
                                    filterPlaceholder: 'Search for regexp...',
                                    enableFiltering: true,
                                    enableClickableOptGroups: true
                        });        
        
        
        
        
$('select').on('change', function (e) {
    var optionSelected = $("option:selected", this);
    var valueSelected = this.value;
    var count = $("option:selected").length;

        if(count < 2){
        $("#tabeladiv").show(700); 
            
        if(count == 1){
            
            var data = "valueselected=" + encodeURIComponent(valueSelected) + "&show_filter=1";

            $.post('filters.php', data, function(data) {

                    $('#v1').val(data.v1);
                    $('#t1').val(data.t1);
                    $('#f1').val(data.f1);
                    $('#v2').val(data.v2);
                    $('#t2').val(data.t2);
                    $('#f2').val(data.f2);
                    $('#v3').val(data.v3);
                    $('#t3').val(data.t3);
                    $('#f3').val(data.f3);     
                
            }, 'json');

        }
      
    }else{
        $("#tabeladiv").slideUp();
    }
});
        
        
        
        
        
        
        
$("#start_cifrex").click(function(e){
            
            
                var katalog = $('#katalog').val();
                var v1 = $('#v1').val();
                var t1 = $('#t1').val();
                var f1 = $('#f1').val();
                var v2 = $('#v2').val();
                var t2 = $('#t2').val();
                var f2 = $('#f2').val();
                var v3 = $('#v3').val();
                var t3 = $('#t3').val();
                var f3 = $('#f3').val();          
            
            if(v1 == ""){
                alert("Field V1 is required!@#");
            }else{
                
            
                e.preventDefault();
                $("#wyniki").html("");
                
                $(this).button('loading').delay(1000).queue(function() {

                });  
 

                
                
            var slvals = [];
            $('input:checkbox[class=ext]:checked').each(function() {
            slvals.push($(this).attr('name'));
            });
                
            if($("#silent").is(':checked')){
                var silen = "&silent=silent";
                }else{
                var silen = "";
                }   
                
    if($("#select option:checked").length <= 1){
                
               var sendData = "katalog=" + encodeURIComponent(katalog) + "&" + slvals + "=1&otherexin=" + silen + "&value1=" + encodeURIComponent(v1) + "&true1=" + encodeURIComponent(t1) + "&false1=" + encodeURIComponent(f1) + "&value2=" + encodeURIComponent(v2) + "&true2=" + encodeURIComponent(t2) + "&false2=" + encodeURIComponent(f2) + "&value3=" + encodeURIComponent(v3) + "&true3=" + encodeURIComponent(t3) + "&false3=" + encodeURIComponent(f3) + "&trythispatterns=Start%21";

        $.post('core.php', sendData, function(data2) {
                if(data2.length==0){
                    $("#wyniki").append('<h1>Nothing found...</h1>');
                    scrollto("#wyniki");
                    $("#start_cifrex").button('reset');
                }else{
                    $("#wyniki").append('<h1>Results ('+data2.length+'):</h1>');
                          $.each(data2,function(i,wynik){

                                        if(wynik.file_line==null){
                                        $("#wyniki").append('<div class="well well-sm">' + wynik.file + '</div>');
                                        }else{
                                        $("#wyniki").append('<div class="panel panel-success"><div class="panel-heading"><h3 class="panel-title"><a target="_blank" href="show.php?show=' + wynik.file + '&l=' + wynik.file_line + '">' + wynik.file + '</a></h3></div><div class="panel-body"><pre>' + atob(wynik.array) + '</pre></div></div>');
                                        }


                            });  
                    scrollto("#wyniki");
                    $("#start_cifrex").button('reset');
                }
            }, 'json');
                

     
                
        
                
                
    }else{
        
            $("select option:selected").each(function() {
            var data3 = "valueselected=" + encodeURIComponent($(this).val()) + "&show_filter=1";
            $.post('filters.php', data3, function(data) {
                    $('#v1').val(data.v1);
                    $('#t1').val(data.t1);
                    $('#f1').val(data.f1);
                    $('#v2').val(data.v2);
                    $('#t2').val(data.t2);
                    $('#f2').val(data.f2);
                    $('#v3').val(data.v3);
                    $('#t3').val(data.t3);
                    $('#f3').val(data.f3);     
                
                var sendData3 = "katalog=" + encodeURIComponent(katalog) + "&" + slvals + "=1&otherexin=" + silen + "&value1=" + encodeURIComponent(data.v1) + "&true1=" + encodeURIComponent(data.t1) + "&false1=" + encodeURIComponent(data.f1) + "&value2=" + encodeURIComponent(data.v2) + "&true2=" + encodeURIComponent(data.t2) + "&false2=" + encodeURIComponent(data.f2) + "&value3=" + encodeURIComponent(data.v3) + "&true3=" + encodeURIComponent(data.t3) + "&false3=" + encodeURIComponent(data.f3) + "&trythispatterns=Start%21";

            $.post('core.php', sendData3, function(data3) {
                if(data3.length==0){
                    $("#wyniki").append('<h1>Nothing found...</h1>');
                     $("#start_cifrex").button('reset'); 
                
                }else{
                    $("#wyniki").append('<h1>Results ('+data3.length+'):</h1>');
                          $.each(data3,function(i,wynik){

                                        if(wynik.file_line==null){
                                        $("#wyniki").append('<div class="well well-sm">' + wynik.file + '</div>');
                                        }else{
                                        $("#wyniki").append('<div class="panel panel-success"><div class="panel-heading"><h3 class="panel-title"><a target="_blank" href="show.php?show=' + wynik.file + '&l=' + wynik.file_line + '">' + wynik.file + '</a></h3></div><div class="panel-body"><pre>' + atob(wynik.array) + '</pre></div></div>');
                                        }


                            });  
                     $("#start_cifrex").button('reset'); 
                }
            }, 'json');
                
                
                
                
                
            }, 'json');
                
                
                
                
                
            });
            
            
  }
                
   }
});
        

    $('input.ext').on('change', function() {
        $('input.ext').not(this).prop('checked', false);  
    });

        
    });
</script>
        
        
        
        
        
        
</BODY>
</html>