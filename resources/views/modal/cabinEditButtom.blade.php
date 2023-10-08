
<div class="modal fade" id="cabinEdit" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title text-center" id="exampleModalLabel">Edit cabon</h6>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('cabinEdit') }}" method="post" enctype="multipart/form-data"
                    class="needs-validation">
                    @csrf
                    <input type="hidden" name="id" id="id" readonly>
                    <div class="row">
                        <div class="form-group mb-1 col-md-12">
                            <label class="text-capitalize">Name*</label>
                            <input class="form-control" name="name" id="name2">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group mb-1 col-md-6">
                            <label class="text-capitalize">Room no*</label>
                            <input class="form-control" name="room_no" id="room_no2">
                        </div>
                        <div class="form-group mb-1 col-md-6">
                            <label class="text-capitalize">Rent*</label>
                            <input class="form-control" name="rent" id="rent2">
                        </div>
                    </div>
                    <div class="modal-footer row justify-content-md-center mt-2">
                        <button class="btn btn-success col-md-4">Edit now</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
