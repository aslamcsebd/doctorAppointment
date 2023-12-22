@extends('layouts.app')
   @section('title') Sub admin-list @endsection
@section('content')
@include('includes.alertMessage')

<div class="content-wrapper p-3">
   <div class="row justify-content-center">
      <div class="col-md-12">        
         <div class="card border border-danger">
            
            {{-- Create new SubAdmin --}}
            @include('modal.createSubAdminTop')

            <h6 class="card-header bg-success text-center py-1 mx-1">Sub admin list</h6>
            <div class="card-body p-1">
               <table class="table table-bordered">
                  <thead class="bg-info">
                     <th>Sl</th>
                     <th>Name</th>
                     <th>Email</th>
                     <th>Mobile</th>
                     <th>Action</th>
                  </thead>
                  <tbody>
                     @foreach($subAdmins as $sub)
                        <tr>
                           <td width="30">{{$loop->iteration}}</td>
                           <td>{!!$sub->name!!}</td>
                           <td>{!!$sub->email!!}</td>
                           <td>{!!$sub->phone!!}</td>                           
                           <td width="auto">
                              <a href="{{ url('itemDelete', ['users', $sub->id, 'tabName'])}}" class="btn btn-danger py-1" onclick="return confirm('Are you want to delete this?')">Delete</a>
                           </td>
                        </tr>
                     @endforeach
                  </tbody>
               </table>
            </div>   
            
            {{-- Create new SubAdmin --}}
            @include('modal.createSubAdminBottom')

         </div>
      </div>
   </div>
</div>

@endsection

@section('js')
@endsection
