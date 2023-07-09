@extends('layouts.app')
   @section('title') Admin setting @endsection
@section('content')
@include('includes.alertMessage')

<div class="content-wrapper p-3">
   <div class="row justify-content-center">
      <div class="col-md-12">
         <div class="card-header p-1">
         </div>

         <div class="card-body p-1">
             <div class="card border border-danger">
                 <div class="card-body p-4">
                 <form action="{{ route('addHospitalInfo') }}" method="post" enctype="multipart/form-data" class="needs-validation" >
                     @csrf
                     <input type="hidden" name="id" value="{{ $hospitalInfo->id ?? '' }}">
                     <div class="form-group">
                         <label for="name" class="control-label">Hospital Name:</label>
                         <input type="text" id="name" name="name" value="{{ $hospitalInfo->name ?? 'Add hospital name' }}" autocomplete="off" class="form-control">
                     </div>
                     <div class="form-group">
                         <label for="address" class="control-label">Hospital Address:</label>
                         <input type="text" id="address" name="address" value="{{ $hospitalInfo->address ?? 'Add hospital address' }}" autocomplete="off" class="form-control">
                     </div>
                     <div class="form-group">
                         <img id="preview" src="{{ asset('')}}/{{$hospitalInfo->photo ?? 'images/default.jpg'}}" alt="Company photo" class="avatar">
                     </div>
                     <div class="form-group">
                         <div class="custom-file">
                             <input type="hidden" name="photo" value="{{ $hospitalInfo->photo ?? '' }}">
                             <input type="file" id="photo" name="photo" class="custom-file-input">
                             <label for="photo" class="custom-file-label">Choose file</label>
                         </div>
                     </div>
                     <hr>
                     <button type="submit" class="btn btn-primary px-5">Save</button>
                 </form>
                 </div>
             </div>
         </div>
      </div>
   </div>
</div>

@endsection

@section('js')
@endsection
