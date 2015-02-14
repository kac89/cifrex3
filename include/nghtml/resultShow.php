<script type="text/ng-template" id="resultShow.html">
        <div class="modal-header">
                   <div class="well well-sm">

        <B>Name: </B>{{ resId.name }} <B>created by: </B> {{ resId.credit }} ( {{ resId.date }} ) 

        <BR><B>Path: </B>{{ resId.path }}
        <BR><B>Files: </B>{{ resId.files }} 
        <BR><B>Pattern.v1: </B>{{ resId.filtr.v1 }} 
        <BR><B>Pattern.v2: </B>{{ resId.filtr.v2 }} 
        <BR><B>Pattern.v3: </B>{{ resId.filtr.v3 }} 
        <BR><B>Pattern.t1: </B>{{ resId.filtr.t1 }} 
        <BR><B>Pattern.t2: </B>{{ resId.filtr.t2 }} 
        <BR><B>Pattern.t3: </B>{{ resId.filtr.t3 }} 
        <BR><B>Pattern.f1: </B>{{ resId.filtr.f1 }} 
        <BR><B>Pattern.f2: </B>{{ resId.filtr.f2 }} 
        <BR><B>Pattern.f3: </B>{{ resId.filtr.f3 }} 
            <h3 class="modal-title">{{item_lang.nameOfPage}}</h3>
            </div>
        </div>

        <div class="modal-body">
            <DIV ng-repeat='wynik in resId.result'>
           <div class="panel panel-success"><div class="panel-heading"><h3 class="panel-title"><a target="_blank" href="show.php?show={{ wynik.file }}&l={{ wynik.file_line }}">{{ wynik.file }}</a></h3></div><div class="panel-body"><pre =>{{ wynik.array }}</pre>
    </div></div>
           </DIV>
        </div>

        <div class="modal-footer">
            <button class="btn btn-warning" ng-click="cancel()">Close</button>
        </div>
</script>