@extends('layouts.app')
@section('title')
    Booking view
@endsection
@section('content')
    @include('includes.alertMessage')

    <div class="content-wrapper p-3 view">
        <div class="row justify-content-center">

            <!-- Result -->
            <div class="col-md-12">
                <div class="card">
                    <h6 class="card-header bg-success text-center py-1 mx-1">Booking view</h6>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <tr>
                                <td colspan="2">
                                    <div class="text-center">
                                        <img src="{{ asset('') }}/{{ $booking->patient->photo ?? 'images/default.jpg' }}"
                                            class="img-thumbnail" alt="No Image found" width="100">
                                        <br>
                                        <span>{{ $booking->user->name }}</span>
                                    </div>
                                </td>
                            </tr>

                            <form action="{{ route('bookingComplete') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="id" value="{{ $booking->id }}">
                                <input type="hidden" name="type" value="{{ $type }}">
                                <input type="hidden" name="route" value="{{ $route }}">
                                <tr>
                                    <td>
                                        <label class="capitalize">Booking type :</label>
                                    </td>
                                    <td class="capitalize">{{ $type }}</td>
                                </tr>
                                <tr>
                                    <td>
                                        <label class="capitalize">{{ $type }} number :</label>
                                    </td>
                                    <td>{{ $booking->room_no ?? $booking->wardNo->ward_no }}</td>
                                </tr>
                                <tr>
                                    <td>
                                        <label class="capitalize">Check in :</label>
                                    </td>
									@if($type== 'cabin')
                                    	<td>{{ date('d-m-Y (h:s a)', strtotime($booking->check_in)) }}</td>
									@else
                                    	<td>{{ date('d-m-Y', strtotime($booking->check_in)) }}</td>
									@endif
                                </tr>
                                <tr>
                                    <td>
                                        <label class="capitalize">Check out : </label>
                                    </td>
                                    <td class="row mx-0 border-0">
                                        <input type="text" class="form-control datepicker col-3" name="check_out" value="{{ date('d-m-Y', strtotime($booking->check_out)) ?? '' }}" placeholder="Day-Month-Year" required onfocus="clearInput(this)" />
                                        @if($type== 'cabin')
											<select class="form-control ml-2 col-3" name="check_out_time" required>
												<option value="">Select time</option>
												<?php $hour = 0; ?>
												@while ($hour++ < 24)
													<?php $time = date('h:i a', mktime($hour, 0, 0, 1, 1, date('Y'))); ?>
													<option class="pr-2" value="{{ $time }}"
														@if (isset($booking->check_in)) {{ date('h:i a', strtotime($booking->check_out)) == $time ? 'selected' : '' }} @endif>
														{{ $time }}</option>
												@endwhile
											</select>											
										@endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label class="capitalize">Per day rent :</label>
                                    </td>
                                    <td>{{ $booking->rent }}/=</td>
                                </tr>
                                <tr>
                                    <td>
                                        <label class="capitalize">Advance pay :</label>
                                    </td>
                                    <td>{{ $advance }}/=</td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="pr-0">
                                        <div class="card-footer row justify-content-center">
                                            <a href="{{ route($route) }}" class="btn btn-primary col-2">
                                                <i class="fas fa-arrow-circle-left nav-icon"></i> &nbsp; Back
                                            </a>
                                            @if ($tab == 'active')
                                                <button type="submit" class="btn btn-success col-2 ml-2">
                                                    Submit &nbsp;
                                                    <i class="fas fa-arrow-circle-right nav-icon"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            </form>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
@endsection
