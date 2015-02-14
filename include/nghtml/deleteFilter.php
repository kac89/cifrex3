    <script type="text/ng-template" id="deleteUniversal.html">


        <div class="modal-header">
            <h3 class="modal-title">{{items.nameOfPage}}</h3>
        </div>
        <div class="modal-body">
        Do you want really delete <B><U>{{ items.name }}</U> ?</B>
        <BR>
        
        <div class="modal-footer">
			<button class="btn btn-primary" ng-click="ok()">Yes</button>
            <button class="btn btn-warning" ng-click="cancel()">No</button>
        </div>
        
</script>