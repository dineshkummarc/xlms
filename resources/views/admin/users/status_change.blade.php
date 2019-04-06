<div class="tab-pane" id="change_status">
        <form action="{{ route('users.field.update', ['id'=> $user->id])}}" class="form-horizontal" method="POST">
            {{ csrf_field() }}
            <input type="hidden" name="_method" value="PUT">
            <input type="hidden" name="field" value="status"/>
            <div class="form-group row">
                <label for="status" class="col-sm-3 col-form-label form-label">Status</label>
                <div class="col-sm-6 col-md-4">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <i class="material-icons md-18 text-muted">check_box</i>
                            </div>
                        </div>
                        <select class="form-control" id="status" name="status">
                            <option disabled>Select a status</option>
                            @foreach(USER_STATUS as $key => $status)
                                <option value="{{ $key}}" {{ $key == $user->status ? 'SELECTED' : ''}} > {{ $status }} </option>
                            @endforeach

                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-6 col-md-4 offset-sm-3">
                    <button type="submit" class="btn btn-success"> Save Changes</button>
                </div>
            </div>
        </form>
    </div>
