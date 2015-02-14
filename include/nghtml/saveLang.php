    <script type="text/ng-template" id="saveLang.html">
        <div class="modal-header">
            <h3 class="modal-title">{{item_lang.nameOfPage}}</h3>
        </div>

        <div class="modal-body">
           <TABLE class="table">
           <TR><TD><U><B>Name:</B> </U></TD>
           <TD><input name="name" type='text' size='50' ng-model="item_lang.name" placeholder="Requied"><BR></TD></TR>
           <TR><TD><U><B>Description: </B></U></TD>
           <TD><input name="author" type='text' size='50' ng-model="item_lang.description" placeholder="Requied"><BR></TD></TR>
           <TR><TD><U><B>Files: </B></U></TD>
           <TD><input name="files" type='text' size='50' ng-model="item_lang.files" placeholder="Requied"><BR></TD></TR>
           </TABLE>
        </div>

        <div class="modal-footer">
			<button class="btn btn-primary" ng-click="ok()">Save</button>
            <button class="btn btn-warning" ng-click="cancel()">Cancel</button>
        </div>
</script>