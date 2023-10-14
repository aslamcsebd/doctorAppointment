<div class="modal fade" id="password" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title text-center" id="exampleModalLabel">Change password</h6>
                <button class="close border border-primary rounded-circle m-0 px-2 py-1" type="button"
                    data-dismiss="modal" aria-label="Close"><span aria-hidden="true">x</span></button>
            </div>

            <div class="modal-body">
                <form action="{{ route('setPasswordNow') }}" method="post" enctype="multipart/form-data"
                    class="needs-validation">
                    @csrf
                    <input type="hidden" name="id" value="{{ Auth::user()->id ? Auth::user()->id : 'No password' }}">
                    <div class="row">
                        <div class="form-group col-12">
                            <label for="email">Your email*</label>
                            <input type="email" class="form-control" value="{{ Auth::user() ? Auth::user()->email : 'No email found' }}" readonly/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-12">
                            <label for="password">New password*</label>
                            <input type="text" name="password" class="form-control" id="password" placeholder="Enter new password" required />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="btn-group">
                            <button class="btn btn-sm btn-success px-4">Save now</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
