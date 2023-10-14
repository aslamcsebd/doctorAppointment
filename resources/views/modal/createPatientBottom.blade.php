<div class="modal fade" id="createPatient" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title text-center" id="exampleModalLabel">Add new patient</h6>
                <button class="close border border-primary rounded-circle m-0 px-2 py-1" type="button"
                    data-dismiss="modal" aria-label="Close"><span aria-hidden="true">x</span></button>
            </div>

            <div class="modal-body">
                <form action="{{ route('create.patient') }}" method="post" enctype="multipart/form-data"
                    class="needs-validation">
                    @csrf
                    <div class="row">
                        <div class="form-group col-6">
                            <label for="name">Name*</label>
                            <input type="text" name="name" class="form-control" id="name"
                                placeholder="Patient name" required />
                        </div>
                        <div class="form-group col-6">
                            <label for="email">Email*</label>
                            <input type="email" name="email" class="form-control" id="email"
                                placeholder="New email" required />
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-6">
                            <label for="phone">Phone number*</label>
                            <input type="number" name="phone" class="form-control" id="phone"
                                placeholder="Patient phone number" required />
                        </div>
                        <div class="form-group col-6">
                            <label for="password">password*</label>
                            <input type="text" name="password" class="form-control" id="password"
                                placeholder="New password" value="123456" required />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="btn-group">
                            <button class="btn btn-sm btn-success">Save</button>
                            <button class="btn btn-sm btn-secondary" type="button" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
