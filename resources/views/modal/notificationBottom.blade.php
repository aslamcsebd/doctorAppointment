{{-- Notification type --}}
<div class="modal fade" id="notification" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title text-center" id="exampleModalLabel">Notification type</h6>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">×</span></button>
            </div>

            <div class="modal-body">
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade active show" id="addRoomTab">
                        <form action="{{ route('saveNotification') }}" method="post" enctype="multipart/form-data"
                            class="needs-validation">
                            @csrf
                            <fieldset class="form-group mb-1 pb-1">
                                <legend class="mb-0">Select notification type</legend>
                                
                                <div class="radio-toolbar form-check form-check-inline">
                                    <input type="hidden" name="id" value="{{ $hospitalInfo->id ?? '' }}">
                                    @php
                                        $types = array('email', 'sms', 'both');
                                    @endphp
                                    @foreach($types as $type)
                                        <div class="radio ml-4">
                                            <input type="radio" id="{{$type}}" name="notification" value="{{$type}}" {{ isset($hospitalInfo) && $hospitalInfo->notification == $type ? 'checked' : '' }} >
                                            <label for="{{$type}}" class="capitalize">{{$type}}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </fieldset>

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
    </div>
</div>
