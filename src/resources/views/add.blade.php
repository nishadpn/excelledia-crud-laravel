<div id="addModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="add">
                <div class="modal-header">
                    <h4 class="modal-title">Add {{$beanType}}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    @foreach($fields as $field =>$attribute)
                        <div class="form-group">
                            <label>{{ucfirst($field)}}</label>
                            <input id="{{$field}}" name="{{$field}}" type="text" class="form-control"  {{$attribute['required']?'required':''}}>
                            <span class="error"></span>
                        </div>
                    @endforeach
                </div>
                <div class="modal-footer">
                    <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                    <input type="submit" class="btn btn-success" value="Add" onclick="addEntry(event)">
                </div>
            </form>
        </div>
    </div>
</div>
<script>

</script>