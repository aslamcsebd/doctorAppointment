@extends('layouts.app')
   @section('title') Booking view @endsection
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
                              <img src="{{asset('')}}/{{$booking->patient->photo ?? 'images/default.jpg'}}" class="img-thumbnail" alt="No Image found" width="100">
                              <br>
                              <span>{{$booking->user->name}}</span>                         
                           </div>
                        </td>
                     </tr>

                     <form action="{{ route('bookingComplete') }}" method="post" enctype="multipart/form-data">
                        @csrf               
                        <input type="hidden" name="id" value="{{ $booking->id }}">
                        <input type="hidden" name="tran_id" value="{{ $booking->tran_id }}">
                        <input type="hidden" name="type" value="{{ $type }}">
                        <input type="hidden" name="route" value="{{ $route }}">
                        <input type="hidden" name="check_in" value="{{ $booking->check_in }}">

                        <tr>
                           <td>
                              <label class="capitalize">Booking type :</label>
                           </td>
                           <td class="capitalize">{{ $type }}</td>
                        </tr>
                        <tr>
                           <td>
                              <label class="capitalize">{{$type}} number :</label>
                           </td>
                           <td>{{ $booking->room_no ?? $booking->wardNo->ward_no }}</td>
                        </tr>
                        <tr>
                           <td>
                              <label class="capitalize">Check in :</label>
                           </td>
                           <td>{{ date('d-m-Y', strtotime($booking->check_in)) }}</td>
                        </tr>
                        <tr>
                           <td>
                              <label class="capitalize">Check out : </label>
                           </td>
                           <td>
                              <input type="text" class="{{($tab=='active') ? 'datepicker' : ''}}" {{($tab=='active') ? '' : 'disabled'}} name="check_out" value="{{ date('d-m-Y', strtotime($booking->check_out)) }}" placeholder="Day-Month-Year">
                           </td>
                        </tr>
                        <tr>
                           <td>
                              <label class="capitalize">Per night rent :</label>
                           </td>
                           <td>{{ $booking->rent }}</td>
                        </tr>                       
                        <tr>
                           <td>
                              <label class="capitalize">Advance pay :</label>
                           </td>
                           <td>{{$advance}}</td>
                        </tr>
                        @if($tab=='active')
                           <tr>
                              <td>
                                 <label class="capitalize">Cash pay : </label>
                              </td>
                              <td>
                                 <input type="number" class="col-auto" name="due" value="0" placeholder="You can pay '0' also">
                              </td>
                           </tr>
                        @endif
                        <tr>
                           <td colspan="2" class="pr-0">
                              <div class="card-footer row justify-content-center">
                                 <a href="{{ route($route) }}" class="btn btn-primary col-2">
                                    <i class="fas fa-arrow-circle-left nav-icon"></i>   &nbsp; Back
                                 </a>
                                 @if($tab=='active')
                                    <button type="submit" class="btn btn-success col-2 ml-2">
                                       Submit    &nbsp;
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
