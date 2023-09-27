@extends('layouts.app')
@section('title')
    Appointment list
@endsection
@section('content')
    @include('includes.alertMessage')
    @php
        $route = 'appointment.request';
        $appointmentRequest = App\Models\PatientForm::orderBy('appointment_date')->get();
		$count  = $appointmentRequest->where('status', 'pending')->where('appointment_date', '>=', date('Y-m-d'))->count();
    @endphp
    <div class="content-wrapper p-3">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <h6 class="card-header bg-success text-center py-1 mx-1">Appointment list</h6>
                <div class="card-header p-1">
                    <ul class="nav nav-pills" id="tabMenu">
                        <li class="nav-item">
                            <a class="nav-link active btn-sm py-1 m-1" data-toggle="pill" href="#pending">Pending ({{ $count }})</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link btn-sm py-1 m-1" data-toggle="pill" href="#accept">Accept</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link btn-sm py-1 m-1" data-toggle="pill" href="#reject" title="When admin reject it or appointment request expire">Reject</a>
                        </li>
                    </ul>
                </div>

                <div class="card-body p-1">
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade active show " id="pending">
                            <div class="card">
                                <div class="card-body p-1">
                                    <table class="table table-bordered">
                                        <thead class="bg-info">
                                            <th>Sl</th>
                                            <th>Doctor</th>
                                            <th>Patient</th>
                                            <th>Mobile</th>
                                            <th>Age</th>
                                            <th>Appointment date</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </thead>
                                        <tbody>
                                            @foreach ($appointmentRequest->where('status', 'pending')->where('appointment_date', '>=', date('Y-m-d')) as $appointment)
                                                <tr>
                                                    <td width="30">{{ $loop->iteration }}</td>
                                                    <td>
                                                        <img src="{{ $picture = asset($appointment->doctor->photo ?? 'images/default.jpg') }}"
                                                            class="img-thumbnail" alt="No Image found" width="80"
                                                            height="80">
                                                        <br>
                                                        <span>{!! $name = $appointment->user->name !!}</span>
                                                    </td>
                                                    <td>{!! $appointment->name !!}</td>
                                                    <td>{!! $appointment->phone !!}</td>
                                                    <td>{!! $appointment->age !!} (years)</td>
                                                    <td>
                                                        {!! $date = $appointment->appointment_date !!} ({!! date('l', strtotime($date)) !!})
                                                    </td>
                                                    <td>
                                                        <span
                                                            class="bg-primary userType px-2">{{ $appointment->status }}</span>
                                                    </td>
                                                    <td width="auto">
                                                        <a class="btn btn-sm btn-outline-primary viewModal"
                                                            data-toggle="modal" data-target="#viewModal"
                                                            data-id="{{ $appointment->id }}"
                                                            data-picture="{{ $picture }}"
                                                            data-doctor_name="{{ $name }}" 
															<?php
																$fields = array("id", "name", "email", "phone", "age", "appointment_date", "diseases_info", "address", "status");
																foreach ($fields as $field) { ?>
                                                            		data-<?= $field ?>="<?= $appointment[$field] ?>"
                                                            <?php } ?>
														>View</a>
                                                        <a href="{{ url('admin/appointment/accept', [$appointment->id]) }}" class="btn btn-sm btn-success">Accept</a>
                                                        <a href="{{ url('admin/appointment/reject', [$appointment->id]) }}" class="btn btn-sm btn-danger">Reject</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade show" id="accept">
                            <div class="card">
                                <div class="card-body p-1">
                                    <table class="table table-bordered">
                                        <thead class="bg-info">
                                            <th>Sl</th>
                                            <th>Doctor</th>
                                            <th>Patient</th>
                                            <th>Mobile</th>
                                            <th>Age</th>
                                            <th>Appointment date</th>
                                            <th>Status</th>
                                        </thead>
                                        <tbody>
                                            @foreach ($appointmentRequest->where('status', 'accept') as $appointment)
                                                <tr>
                                                    <td width="30">{{ $loop->iteration }}</td>
                                                    <td>
                                                        <img src="{{ $picture = asset($appointment->doctor->photo ?? 'images/default.jpg') }}"
                                                            class="img-thumbnail" alt="No Image found" width="80"
                                                            height="80">
                                                        <br>
                                                        <span>{!! $name = $appointment->user->name !!}</span>
                                                    </td>
                                                    <td>{!! $appointment->name !!}</td>
                                                    <td>{!! $appointment->phone !!}</td>
                                                    <td>{!! $appointment->age !!} (years)</td>
                                                    <td>
                                                        {!! $date = $appointment->appointment_date !!} ({!! date('l', strtotime($date)) !!})
                                                    </td>
                                                    <td>
                                                        <span class="bg-success userType px-2">{{ $appointment->status }}</span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade show" id="reject">
                            <div class="card">
                                <div class="card-body p-1">
                                    <table class="table table-bordered">
                                        <thead class="bg-info">
                                            <th>Sl</th>
                                            <th>Doctor</th>
                                            <th>Patient</th>
                                            <th>Mobile</th>
                                            <th>Age</th>
                                            <th>Appointment date</th>
                                            <th>Status</th>
                                        </thead>
                                        <tbody>
                                            @foreach ($appointmentRequest->where('status', 'reject') as $appointment)
                                                <tr>
                                                    <td width="30">{{ $loop->iteration }}</td>
                                                    <td>
                                                        <img src="{{ $picture = asset($appointment->doctor->photo ?? 'images/default.jpg') }}"
                                                            class="img-thumbnail" alt="No Image found" width="80"
                                                            height="80">
                                                        <br>
                                                        <span>{!! $name = $appointment->user->name !!}</span>
                                                    </td>
                                                    <td>{!! $appointment->name !!}</td>
                                                    <td>{!! $appointment->phone !!}</td>
                                                    <td>{!! $appointment->age !!} (years)</td>
                                                    <td>
                                                        {!! $date = $appointment->appointment_date !!} ({!! date('l', strtotime($date)) !!})
                                                    </td>
                                                    <td>
                                                        <span class="bg-danger userType px-2">{{ $appointment->status }}</span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('admin.viewModal')
@endsection

@section('js')
    <script type="text/javascript">
        $('.viewModal').click(function() {
            var id = $(this).data(id);
            var doctor_name = $(this).data('doctor_name');
            var picture = $(this).data('picture');

            $('#doctor_name').html(doctor_name);
            $("#picture").attr('src', picture);

            <?php 
				$fields = array("id", "name", "email", "phone", "age", "appointment_date", "diseases_info", "address", "status");
				foreach ($fields as $field) { ?>
					var <?= $field ?> = $(this).data('<?= $field ?>');
					$('#<?= $field ?>').html(<?= $field ?>);
            <?php } ?>
        });
    </script>
@endsection
