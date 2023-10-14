@extends('layouts.app')
@section('title')
    Payment view
@endsection
@section('content')
    @include('includes.alertMessage')
    <div class="content-wrapper p-3 view">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <h6 class="card-header bg-success text-center py-1">Patient payment view</h6>
                    <div class="card-body row justify-content-center">
                        <div class="col-md-7">
                            <table class="table table-bordered">
                                <tr>
                                    <td colspan="2">
                                        <div class="text-center">
                                            <img src="{{ asset('') }}/{{ $payment->photo ?? 'images/default.jpg' }}"
                                                class="img-thumbnail" alt="No Image found" width="100">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-right">Name:</td>
                                    <td>{{ $payment->getPatient->name ?? '' }}</td>
                                </tr>
                                <tr>
                                    <td>Gender:</td>
                                    <td>{{ $payment->patientInfo->gender ?? '' }}</td>
                                </tr>
                                <tr>
                                    <td>Blood group:</td>
                                    <td>{{ $payment->patientInfo->blood ?? '' }}</td>
                                </tr>
                                <tr>
                                    <td>Mobile:</td>
                                    <td>{{ $payment->getPatient->phone ?? '' }}</td>
                                </tr>
                                <tr class="font-weight-bold bg-cyan">
                                    <td>Patient ID:</td>
                                    <td>{{ $payment->patientInfo->patient_id ?? '' }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-5">
                            <table class="table table-bordered">
                                <tr>
                                    <td>Payment Id:</td>
                                    <td>{!! $payment->tran_id !!}</td>
                                </tr>
                                <tr>
                                    <td>Payment entry:</td>
                                    <td>{!!  date('d-M-Y (h:i a)', strtotime($payment->created_at)) !!}</td>
                                </tr>
                                <tr>
                                    <td>Total cost:</td>
                                    <td>{!! $payment->bed_fee !!}</td>
                                </tr>
                                <tr>
                                    <td>Advance:</td>
                                    <td>{!! $adv = $payment->advance !!}</td>
                                </tr>
                                <form action="{{ route('payment.add') }}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="payment_id" value="{{ $payment->id }}">
                                    <tr class="bg-info">
                                        <td style="width:50%">Need to pay:</td>
                                        <td>
                                            <input type="number" class="font-weight-bold text-center" name="due" value="{!! $payment->bed_fee - $payment->advance !!}" required>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <button type="submit" class="btn btn-success btn-block py-1 mt-1">Payment now</button>
                                        </td>
                                    </tr>
                                </form>
                            </table>
                        </div>
                    </div>

                    <div class="card-footer row justify-content-center">
                        <a href="{{ route('payment') }}" class="btn btn-primary col-2">
                            <i class="fas fa-arrow-circle-left nav-icon"></i> &nbsp;
                            Back
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
@endsection
