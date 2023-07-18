@extends('layouts.app')
   @section('title') Payment view @endsection
@section('content')
@include('includes.alertMessage')
<div class="content-wrapper p-3 view">
   <div class="row justify-content-center">
      <div class="col-md-8">
         <div class="card">
            <h6 class="card-header bg-success text-center py-1">Patient full payment view</h6>
            <div class="card-body row justify-content-center">
                <div class="col-md-7">    
                    <table class="table table-bordered">
                        <tr>
                            <td colspan="2">
                                <div class="text-center">
                                    <img src="{{asset('')}}/{{$payment->photo ?? 'images/default.jpg'}}" class="img-thumbnail" alt="No Image found" width="100">
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
                <div class="col-md-5 view2">
                    <table class="table table-bordered">
                       <tr>
                          <td>
                             <label class="capitalize">Doctor fee:</label>
                          </td>
                          <td>{!!$payment->doctor_fee!!}</td>
                       </tr>
                       <tr>
                          <td>
                             <label class="capitalize">Bed rent:</label>
                          </td>
                          <td>{!!$payment->bed_fee!!}</td>
                       </tr>
                       <tr>
                          <td>
                             <label class="capitalize">Total:</label>
                          </td>
                          <td>{!! $total = $payment->doctor_fee + $payment->bed_fee!!}</td>
                       </tr>
                       <tr>
                          <td>
                             <label class="capitalize">Advance:</label>
                          </td>
                          <td>{!!$adv = $payment->advance!!}</td>
                       </tr>
                       <tr>
                          <td>
                             <label class="capitalize">Sub-total:</label>
                          </td>
                          <td>{!! $total - $adv !!}</td>
                       </tr>
                        <form action="{{ route('payment.add') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="payment_id" value="{{$payment->id}}">
                            <tr class="bg-warning">
                                <td>
                                    <label class="capitalize">Need to pay:</label>
                                </td>
                                <td style="width:35%">
                                    <input type="number" class="form-control font-weight-bold text-right" name="sub_total" value="{!!$total - $adv !!}" required>
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
                  <i class="fas fa-arrow-circle-left nav-icon"></i>   &nbsp;
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