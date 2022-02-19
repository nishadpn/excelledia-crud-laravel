<div id="deleteModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <form>
                <div class="modal-header">
                    <h4 class="modal-title">Delete {{$beanType}}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete these Records?</p>
                    <p class="text-warning"><small>This action cannot be undone.</small></p>
                    <input type="hidden" id="delete-id">
                </div>
                <div class="modal-footer">
                    <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                    <input type="submit" class="btn btn-danger" value="Delete" onclick="deleteEntry(event)">
                </div>
            </form>
        </div>
    </div>
</div>
<script>

    {{--const deleteEntry = (e)=>{--}}
        {{--e.preventDefault();--}}
        {{--let formData =  new FormData(document.getElementById('add'));--}}
        {{--console.log(formData)--}}
        {{--fetch(`{{route('crud.delete')}}`,{--}}
            {{--headers:{--}}
                {{--'Content-Type': 'application/x-www-form-urlencoded'--}}
            {{--},--}}
            {{--body:formData,--}}
            {{--method:'PATCH'--}}
        {{--}).then(r=>{--}}

        {{--})--}}
    {{--};--}}
</script>