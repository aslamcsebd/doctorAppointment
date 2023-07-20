@extends('layouts.app')
   @section('title') Booking view @endsection
@section('content')
@include('includes.alertMessage')

<style>
   input[type="number"] {
      padding-left: 1.6rem!important;
      height: calc(1.8rem);
   }
</style>

<div class="content-wrapper p-3 bookingView">
   <div class="row justify-content-center">
      <div class="col-md-6">
         <div class="card">            
            <h6 class="card-header bg-warning text-center py-1">Booking information</h6>
            <form action="{{ route('bookingNow') }}" method="post" enctype="multipart/form-data">
               @csrf
               <div class="card-body">
                  <table class="table table-bordered">
                     <input type="hidden" name="id" value="{{ $ward->id ?? '' }}">
                       <tr>
                          <td>
                             <label class="capitalize">Booking type :</label>
                          </td>
                          <input type="hidden" name="bookingType" value="{{ $ward->roomNo->room_type ?? '' }}">
                          <td>{{ $ward->roomNo->room_type ?? '' }}</td>
                       </tr>
                       <tr>
                           <td>
                              <label class="capitalize">Ward number :</label>
                           </td>
                           <td>{{ $ward->ward_no ?? '' }}</td>
                       </tr>
                       <tr>
                           <td>
                              <label class="capitalize">Check in :</label>
                           </td>
                              <input type="hidden" name="check_in" value="{{ $check_in ?? '' }}">
                           <td>{{ $check_in ?? '' }}</td>
                       </tr>
                       <tr>
                           <td>
                              <label class="capitalize">Check out : <br>
                                    <small class="font-italic text-primary">Before 10:00 am</small>
                                 </label>
                           </td>
                              <input type="hidden" name="check_out" value="{{ $check_out ?? '' }}">
                           <td>{{ $check_out ?? '' }}</td>
                       </tr>
                       <tr>
                          <td>
                             <label class="capitalize">Total night :</label>
                          </td>
                          <td>{{ $totalNight ?? '' }}</td>
                       </tr>
                       <tr>
                          <td>
                             <label class="capitalize">Per night rent :</label>
                          </td>
                          <input type="hidden" name="rent" value="{{ $ward->roomNo->rent ?? '' }}">
                          <td>{{ $rent = $ward->roomNo->rent ?? '' }}</td>
                       </tr>
                       <tr>
                          <td>
                             <label class="capitalize">Total rent :</label>
                          </td>
                          <td class="font-weight-bold">
                              {{$total = $totalNight * $rent}}
                          </td>
                          <input type="hidden" name="totalRent" value="{{ $total ?? '' }}">                          
                       </tr>
                       <tr class="bg-warning">
                           <td>
                               <label class="capitalize">Advance pay :</label>
                           </td>
                           <td>                           
                               <input type="number" class="form-control btn-block font-weight-bold text-center" name="advance" min="{{ $rent ?? '' }}" max="{{ $total }}" value="{{ $total }}" required>
                           </td>
                       </tr>
                       <tr>
                           <td colspan="2" class="pr-0">
                               <button type="submit" class="btn btn-success btn-block px-0 py-1 mt-1">Payment now</button>
                           </td>
                       </tr>           
                    </table>  
               </div>
            </form>
         </div>
      </div>
   </div>
</div>
@endsection

