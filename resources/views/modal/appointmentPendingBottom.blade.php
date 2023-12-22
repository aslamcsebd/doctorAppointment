<div class="modal fade" id="appointmentPending" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title text-center" id="exampleModalLabel">Appointment information</h6>
                <button class="close" type="button"
                    data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('appointment_accept') }}" method="post" enctype="multipart/form-data" class="needs-validation">
                    @csrf
                    <input type="hidden" name="id" id="id">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="appointment_id">Appointment id</label>
                            <input type="text" class="form-control" id="appointment_id" readonly/>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" readonly/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-12">
                            <label for="password">Appointment date</label>
                            <input type="datetime-local" name="date" class="form-control" id="date" required/>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="btn-group">
                            <button class="btn btn-sm btn-success px-4">Accept now</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>