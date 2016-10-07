<form id="filterselectform" method="POST" action="/filter">
    {!! csrf_field() !!}
    <div class="modal fade" id="filterselectmodal" tabindex="-1" role="dialog" aria-labelledby="Select filter">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="filterModalTitle">Select Categories</h4>
                </div>
                <div class="modal-body">

                    @foreach(\App\Models\Category::all() as $category)
                    <div class="checkbox">
                        <label>
                            <input @if(in_array($category->id, auth()->user()->categories)) checked @endif type="checkbox" name="categories[]" value="{{$category->id}}"> {{$category->name}}
                        </label>
                    </div>
                    @endforeach

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <input type="submit" class="btn btn-primary" value="Save">
                </div>
            </div>
        </div>
    </div>

</form>