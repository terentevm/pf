<div class="page-header">
    <h2>Import data from 1C:Money</h2>
</div>
<form method="post" enctype="multipart/form-data" action="/tools/import1c">

    <div class="form-group">
        <label for="file">Choose files for upload</label>
        <input type="file" name="userfile[]" id="file" multiple="multiple" accept="application/json">
        
    </div>
    <div class="form-group">
        <div class="alert alert-warning alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Warning!</strong> Better check yourself, you're not looking too good.
        </div>    
    </div>
</form>

