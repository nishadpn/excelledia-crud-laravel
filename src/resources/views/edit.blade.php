<div id="editModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="edit-form">
                <div class="modal-header">
                    <h4 class="modal-title">Edit {{$beanType}}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="update-id" name="id">
                    @foreach($fields as $field =>$attribute)
                        <div class="form-group">
                            <label>{{ucfirst($field)}}</label>
                            <input id="edit-{{$field}}" name="{{$field}}" type="text" class="form-control"  {{$attribute['required']?'required':''}}>
                            <span class="error"></span>
                        </div>
                    @endforeach
                </div>
                <div class="modal-footer">
                    <button class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button  class="btn btn-info" onclick="editEntry(event)">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>