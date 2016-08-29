@if(isset($video))
    <form id="webmedit" method="POST" action="/songindex/{{$video->id}}">
        {!! csrf_field() !!}
        <div class="modal fade" id="webmeditmodal" tabindex="-1" role="dialog" aria-labelledby="Edit webm">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="filterModalTitle">Edit webm</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="interpretedit">Artist</label>
                            <input class="form-control" type="text" name="interpret" id="interpretedit" value="{{ $video->interpret or ''}}" placeholder="Artist">
                        </div>
                        <div class="form-group">
                            <label for="songtitleedit">Songtitle</label>
                            <input class="form-control" type="text" name="songtitle" id="songtitleedit" value="{{ $video->songtitle or ''}}" placeholder="Songtitle">
                        </div>
                        <div class="form-group">
                            <label for="imgsourceedit">Image source</label>
                            <input class="form-control" type="text" name="imgsource" id="imgsourceedit" value="{{ $video->imgsource or ''}}" placeholder="Image source">
    
                        </div>
                        <div class="form-group">
                            <label for="categoryselect">Category</label>
                            <select class="form-control" name="category" id="categoryselect">
                                @foreach(\App\Models\Category::all() as $category)
                                <option value="{{$category->id}}" @if($video->category->id == $category->id) selected @endif>{{$category->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <input type="submit" class="btn btn-primary" value="Save">
                    </div>
                </div>
            </div>
        </div>
    </form>
@endif
