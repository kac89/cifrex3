//  
//    cIFrex Tool for Static Code Analysis
//    Copyright (C) 2015 cIFrex Team
//
//    This program is free software: you can redistribute it and/or modify
//    it under the terms of the GNU General Public License as published by
//    the Free Software Foundation, either version 3 of the License, or
//    (at your option) any later version.
//
//    This program is distributed in the hope that it will be useful,
//    but WITHOUT ANY WARRANTY; without even the implied warranty of
//    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
//    GNU General Public License for more details.
//
//    You should have received a copy of the GNU General Public License
//    along with this program.  If not, see http://www.gnu.org/licenses/.
//

$(document).ready(function () {
        
				var offset = 300;
				var duration = 700;
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
                                    maxHeight: 500,
                                    filterPlaceholder: 'Search for regexp...',
                                    enableFiltering: true,
                                    enableClickableOptGroups: true
                }); 
        
                $('select').on('change', function (e) {
                        var optionSelected = $("option:selected", this);
                        var valueSelected = this.value;
                        var count = $("option:selected").length;

                        if(count < 2){
                            $("#patterns").show(700); 
                            $("#runConsoleW").show(700); 
 
                            if (count == 0){
                                    $('#filtrName').val('').change();
                                    $('#filtrDescription').val('').change();
                                    $('#filtrId').val('').change();
                            } else
                            if (count == 1){
                            $("#multisearch").empty();

                            var data = "valueselected=" + encodeURIComponent(valueSelected) + "&show_filter=1";

                            $.post('filters.php', data, function(data) {
                                    $('#v1').val(data.v1).change();
                                    $('#t1').val(data.t1).change();
                                    $('#f1').val(data.f1).change();
                                    $('#v2').val(data.v2).change();
                                    $('#t2').val(data.t2).change();
                                    $('#f2').val(data.f2).change();
                                    $('#v3').val(data.v3).change();
                                    $('#t3').val(data.t3).change();
                                    $('#f3').val(data.f3).change();
                                    $('#filtrName').val(data.title).change();
                                    $('#filtrDescription').val(data.description).change();
                                    $('#filtrId').val(data.id).change();
                            }, 'json'); 

                        }

                    }else{
                        $("#patterns").hide();
                        $("#runConsoleW").hide();
                        $("#multisearch").empty();
                        $("#wyniki").empty();    
                    }
                });


            function escapeHtml(unsafe) {
                return unsafe
                     .replace(/&/g, "&amp;")
                     .replace(/</g, "&lt;")
                     .replace(/>/g, "&gt;")
                     .replace(/"/g, "&quot;")
                     .replace(/'/g, "&#039;");
             }

            $("#show_selected").click(function(e){
                var optionSelected = $("option:selected");
                var valueSelected = this.value;
                var count = $("option:selected").length;

                if(count<2){ 
                        alert("Select more that one filter"); 
                        return 0;
                }

                    $("#patterns" ).hide();
                    $("#runConsoleW" ).hide();
                    $("#multisearch").empty();
                    $("#wyniki").empty();        

                    optionSelected.each(function (index, val) {
                        var data3 = "valueselected=" + encodeURIComponent($(this).val()) + "&show_filter=1";
                        $.post('filters.php', data3, function(data) {
                           $("#multisearch").append('<CENTER><h3><B><U>ID:</B> '+data.id+' <B>Name:</B> '+escapeHtml(data.title)+' <B>Lang:</B> '+escapeHtml(data.env)+' </U></h3></CENTER>');
                            
                           $("#multisearch").append('<CENTER><B>V1:</B> '+escapeHtml(data.v1)+'</CENTER>');
                           if(data.v2!='')
                           $("#multisearch").append('<CENTER><B>V2:</B> '+escapeHtml(data.v2)+'</CENTER>');
                           if(data.v3!='')             
                           $("#multisearch").append('<CENTER><B>V3:</B> '+escapeHtml(data.v3)+'</CENTER>');
                           if(data.t1!='')
                           $("#multisearch").append('<CENTER><B>T1:</B> '+escapeHtml(data.t1)+'</CENTER>');
                           if(data.t2!='')
                           $("#multisearch").append('<CENTER><B>T2:</B> '+escapeHtml(data.t2)+'</CENTER>');
                           if(data.t3!='')
                           $("#multisearch").append('<CENTER><B>T3:</B> '+escapeHtml(data.t3)+'</CENTER>');
                           if(data.f1!='')
                           $("#multisearch").append('<CENTER><B>V1:</B> '+escapeHtml(data.f1)+'</CENTER>');
                           if(data.f2!='')
                           $("#multisearch").append('<CENTER><B>V2:</B> '+escapeHtml(data.f2)+'</CENTER>');
                           if(data.f3!='')
                           $("#multisearch").append('<CENTER><B>V3:</B> '+escapeHtml(data.f3)+'</CENTER>');

                           $("#multisearch").append('<P>&nbsp;');

                        }, 'json').fail(function() {
                                alert( "Error! Check Response!" );
                            });   ;
                    });
                    $("#multisearch").append('<P></CENTER><P>&nbsp;<P>');
            }); 

            $("#save_langs").click(function(e){
                var lang = $('#langId').val();
                var sendData = "action=lang&lang_id="+lang+"&filters=";
                $("select option:selected").each(function (index, val) {
                    sendData += ""+encodeURIComponent($(this).val())+"|";
                });
                $.post('others/filter-controler.php', sendData, function(data2) {
                            }, 'json').fail(function() {
                            });   

                alert("Updated!");

                $("#save_langs").button('reset');
            });

            $("#save_groups").click(function(e){
                var group = $('#groupId').val();
                var lang = $('#langId').val();

                var sendData = "action=group&lang_id="+group+"&filters=";
                $("select option:selected").each(function (index, val) {
                    sendData += ""+encodeURIComponent($(this).val())+"|";
                });

                $.post('others/filter-controler.php', sendData, function(data2) {
                            }, 'json').fail(function() {
                            });   
                alert('Updated!');

                $("#save_langs").button('reset');
            });

            $("#start_cifrex,#start_cifrex2").each(function(){
                $(this).dblclick(function() {
                    alert( "Slow down baby... request in progress" );
                });
            });

            $("#start_cifrex,#start_cifrex2").each(function(){
                $(this).click(function(e){
                            var katalog = $('#katalog').val();
                            var files = $('#katalog').val();
                            var v1 = $('#v1').val();
                            var t1 = $('#t1').val();
                            var f1 = $('#f1').val();
                            var v2 = $('#v2').val();
                            var t2 = $('#t2').val();
                            var f2 = $('#f2').val();
                            var v3 = $('#v3').val();
                            var t3 = $('#t3').val();
                            var f3 = $('#f3').val();  
                            var email = $('#email').val();  
                            var credit = $('#credit').val();  
                            var nameOfScan = $('#nameOfScan').val();  
                            var toDbSave = $('#debugLogVal').val();    
                            var langId = $('#langId').val();    
                            var execLog = $('#execLog').val(); 
                            var filesVal = $('#filesVal').val();  
                            var filtrName = $('#filtrName').val();  
                            var filtrDescription = $('#filtrDescription').val();  
                            var filtrId = $('#filtrId').val();  

                        if(v1 == "" && $("#select option:checked").length <= 1){
                            alert("Field V1 is required!@#");
                        }else{

                            e.preventDefault();
                            $("#wyniki").html("");

                            $(this).button('loading').delay(1000).queue(function() {

                            });  

                if($("#select option:checked").length <= 1){
                           var sendData = "toDb=" + toDbSave + "&execLog=" + execLog + "&katalog=" + encodeURIComponent(katalog) + "&files="+filesVal+"&value1=" + encodeURIComponent(btoa(v1)) + "&true1=" + encodeURIComponent(btoa(t1)) + "&false1=" + encodeURIComponent(btoa(f1)) + "&value2=" + encodeURIComponent(btoa(v2)) + "&true2=" + encodeURIComponent(btoa(t2)) + "&false2=" + encodeURIComponent(btoa(f2)) + "&value3=" + encodeURIComponent(btoa(v3)) + "&true3=" + encodeURIComponent(btoa(t3)) + "&false3=" + encodeURIComponent(btoa(f3)) + "&resultName=" + encodeURIComponent(nameOfScan) + "&email=" + encodeURIComponent(email) + "&credit=" + encodeURIComponent(credit) + "&langId=" + encodeURIComponent(langId) + "&filtrName=" + encodeURIComponent(filtrName) + "&filtrDescription=" + encodeURIComponent(filtrDescription) + "&filtrId=" + encodeURIComponent(filtrId) + "&setCookie=True&trythispatterns=Start";

                    $.post('run-core-php/search.php', sendData, function(data2) {
                            if(data2.length==0){
                                $("#wyniki").append('<P><CENTER><FONT color="red"><h1>Nothing found...</h1></FONT></CENTER><P>&nbsp;<P>');
                                scrollto("#wyniki");
                                $("#start_cifrex").button('reset');
                                $("#start_cifrex2").button('reset');
                            }else{
                                $("#wyniki").append('<h1>Results ('+data2.length+'):</h1>');
                                      $.each(data2,function(i,wynik){

                                                    if(wynik.file_line==null){
                                                    $("#wyniki").append('<div class="well well-sm">' + escapeHtml(wynik.file) + '</div>');
                                                    }else{
                                                    $("#wyniki").append('<div class="panel panel-success"><div class="panel-heading"><h3 class="panel-title"><a target="_blank" href="show.php?show=' + escapeHtml(wynik.file) + '&l=' + escapeHtml(wynik.file_line) + '">' + escapeHtml(wynik.file) + '</a></h3></div><div class="panel-body"><pre>' + escapeHtml(atob(wynik.array)) + '</pre></div></div>');
                                                    }


                                        });  
                                scrollto("#wyniki");

                                $("#start_cifrex").button('reset');
                                $("#start_cifrex2").button('reset');
                            }
                        }, 'json').fail(function() {
                            alert( "Error! Check Response!" );
                            $("#start_cifrex").button('reset');
                            $("#start_cifrex2").button('reset');
              });
                }else{
                        var countScan = 1;
                        var razem = $("#select option:checked").length;

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

                            var sendData3 = "toDb=" + toDbSave + "&execLog=" + execLog + "&katalog=" + encodeURIComponent(katalog) + "&files="+filesVal+"&value1=" + encodeURIComponent(btoa(data.v1)) + "&true1=" + encodeURIComponent(btoa(data.t1)) + "&false1=" + encodeURIComponent(btoa(data.f1)) + "&value2=" + encodeURIComponent(btoa(data.v2)) + "&true2=" + encodeURIComponent(btoa(data.t2)) + "&false2=" + encodeURIComponent(btoa(data.f2)) + "&value3=" + encodeURIComponent(btoa(data.v3)) + "&true3=" + encodeURIComponent(btoa(data.t3)) + "&false3=" + encodeURIComponent(btoa(data.f3)) + "&resultName=" + encodeURIComponent(nameOfScan) + " ("+countScan+"/" + razem + ")&langId=" + encodeURIComponent(langId) + "&email=" + encodeURIComponent(email) + "&filtrName=" + encodeURIComponent(data.title) + "&filtrDescription=" + encodeURIComponent(data.description) + "&filtrId=" + encodeURIComponent(data.id) + "&credit=" + encodeURIComponent(credit) + "&setCookie=True&trythispatterns=Start";
                        countScan = countScan + 1;

                        $.post('run-core-php/search.php?'+(countScan-1)+'of'+razem, sendData3, function(data3) {
                            if(data3.length==0){
                                $("#wyniki").append('<h1>Filter('+escapeHtml(data.id)+'): '+escapeHtml(data.title)+'</h1>');
                                $("#wyniki").append('<h2>Nothing found...</h2>');
                                $("#start_cifrex").button('reset'); 
                                $("#start_cifrex2").button('reset');        
                            }else{
                                $("#wyniki").append('<h1>Filter('+escapeHtml(data.id)+'): '+escapeHtml(data.title)+'</h1>');

                                $("#wyniki").append('<h2>Results ('+data3.length+'):</h2>');
                                      $.each(data3,function(i,wynik){

                                                    if(wynik.file_line==null){
                                                    $("#wyniki").append('<div class="well well-sm">' + escapeHtml(wynik.file) + '</div>');
                                                    }else{
                                                    $("#wyniki").append('<div class="panel panel-success"><div class="panel-heading"><h3 class="panel-title"><a target="_blank" href="show.php?show=' + escapeHtml(wynik.file) + '&l=' + escapeHtml(wynik.file_line) + '">' + escapeHtml(wynik.file) + '</a></h3></div><div class="panel-body"><pre>' + escapeHtml(atob(wynik.array)) + '</pre></div></div>');
                                                    }
                                        });  
                                 $("#start_cifrex").button('reset'); 
                                 $("#start_cifrex2").button('reset');

                            }
                        }, 'json').fail(function() {
                            alert( "Error! Turn JS debuger for more details" );
                            $("#start_cifrex").button('reset');
                            $("#start_cifrex2").button('reset');
                        });
                        }, 'json');
                        });
                    }
               }
    });
});
});
