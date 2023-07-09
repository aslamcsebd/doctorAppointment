@extends('layouts.app')
   @section('title') Doctor-list @endsection
@section('content')
@include('includes.alertMessage')

<div class="content-wrapper p-3">
   <div class="row justify-content-center">
      <div class="col-md-12">
        
         <div class="card">
            <div class="card-body p-1">
               <table class="table table-bordered">
                  <thead class="bg-info">
                     <th>Sl</th>
                     <th>Name</th>
                     <th>Mobile</th>
                     <th>Email</th>
                     <th>Age</th>
                     <th>Action</th>
                  </thead>
                  <tbody>
                     @foreach($doctors as $doctor)
                        <tr>
                           <td width="30">{{$loop->iteration}}</td>
                           <td>
                              <img src="{{asset('')}}/{{$doctor->photo ?? 'images/default.jpg'}}" class="img-thumbnail" alt="No Image found" width="60">
                              <br>
                              <span class="singerName">{!!$doctor->user->name!!}</span>
                           </td>                        
                           <td>{!!$doctor->user->phone!!}</td>
                           <td>{!!$doctor->user->email!!}</td>
                           <td>
                              {{\Carbon\Carbon::parse($doctor->dob)->diff(\Carbon\Carbon::now())->format(' %y years ')}}
                           </td>

                           <td width="auto">
                              <div class="btn-group">
                                    <a href="{{ url('single-doctor', [$doctor->user_id, Route::currentRouteName()]) }}" class="btn btn-sm btn-info py-1">View</a>
                                    <a href="{{ url('addFavourite', [$doctor->user_id])}}" class="btn btn-sm btn-danger ml-1 py-1 px-3" title="Add to favorite">
                                        <i class="fas fa-bookmark"></i>
                                    </a>
                              </div>
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

@endsection

@section('js')
@endsection
