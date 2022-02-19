<div class="table-responsive">
    <div class="table-wrapper">
        <div class="table-title">
            <div class="row">
                <div class="col-sm-6">
                    <h2>Manage <b>{{$beanType}}</b></h2>
                </div>
                <div class="col-sm-6">
                    <a href="#addModal" class="btn btn-success" data-toggle="modal"><i class="material-icons">&#xE147;</i> <span>Add New {{$beanType}}</span></a>
                    <a href="#deleteModal" class="btn btn-danger" data-toggle="modal"><i class="material-icons">&#xE15C;</i> <span>Delete</span></a>
                </div>
            </div>
        </div>
        <table class="table table-striped table-hover">
            <thead>
            <tr>
                <th>
							<span class="custom-checkbox">
								<input type="checkbox" id="selectAll">
								<label for="selectAll"></label>
							</span>
                </th>
                @foreach($fieldList as $field)
                    <th>{{ucfirst($field)}}</th>
                @endforeach
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($collection as $entry)
            <tr>
                <td>
							<span class="custom-checkbox">
								<input class="deleting-ids" type="checkbox" id="checkbox{{$entry->$primary}}" name="options[]" value="{{$entry->$primary}}">
								<label for="checkbox{{$entry->$primary}}"></label>
							</span>
                </td>

                    @foreach($fieldList as $field)
                        <td>{{$entry->$field}}</td>
                    @endforeach
                <td>
                    <a  class="edit" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" data-pri="{{$entry->$primary}}" title="Edit" onclick="showEditWindow(this,event)">&#xE254;</i></a>
                    <a class="delete" ><i class="material-icons" data-toggle="tooltip" title="Delete" data-pri="{{$entry->$primary}}" onclick="showDeleteModal(this,event)">&#xE872;</i></a>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
        <div class="clearfix">
            <div class="hint-text">Showing <b>{{$collection->perPage()>$collection->total()?$collection->total():$collection->perPage()}}</b> out of <b>{{$collection->total()}}</b> entries</div>
            {{$collection->links()}}
        </div>
    </div>
</div>