<div class="modal fade" id="filterselectmodal" tabindex="-1" role="dialog" aria-labelledby="Select filter">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="filterModalTitle">Add Tags to filter for</h4>
            </div>
            <div class="modal-body">
                <input id="filter" type="text" class="form-control" placeholder="Input tags…" name="filter" data-role="tagsinput" value="{{ implode(',', auth()->user()->categories) }}">
                {{--<input type="text" id="filter" data-role="tagsinput" value="{{ implode(',', auth()->user()->categories) }}">--}}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                <button href="/filter" type="submit" id="submitfilter" class="btn btn-primary" value="Save">Save</button>
            </div>
        </div>
    </div>
</div>
