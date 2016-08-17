<form id="banmenu" method="POST" action="/api/user/{{$user->username}}/ban">
    {!! csrf_field() !!}
    <div class="modal fade" id="banmenumodal" tabindex="-1" role="dialog" aria-labelledby="Ban user">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="filterModalTitle">Ban user</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="reason">Reason</label>
                        <input class="form-control" type="text" name="reason" id="reason" placeholder="Reason">
                    </div>
                    <div class="form-group">
                        <label for="duration">Duration</label>
                        <input class="form-control" type="text" name="duration" id="duration" placeholder="Duration (-1 = permanent)">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <input type="submit" class="btn btn-danger" value="BAN!">
                </div>
            </div>
        </div>
    </div>
</form>