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
                 <form action="{{ route('updateHospitalInfo') }}" method="post" enctype="multipart/form-data" class="needs-validation" >
                     @csrf
                     <input type="hidden" name="id" value="{{ $hospitalInfo->id ?? '' }}">
                     <div class="form-group">
                         <label for="name" class="control-label">Hospital Name:</label>
                         <input type="text" id="name" name="name" value="{{ $hospitalInfo->name ?? 'Add hospital name' }}" autocomplete="off" class="form-control">
                     </div>

                    <div class="form-group">
                        <label for="address" class="control-label">Hospital Address*</label>
                        <textarea type="text" id="address" name="address" class="form-control summernote required">
                            {{ $hospitalInfo->address ?? 'Add hospital address' }}
                        </textarea>
                    </div>

                    <div class="row p-0 m-0 border">
                        <div class="form-group col-2">
                            <div class="px-4 pt-2">
                                <img id="preview" src="{{ asset('')}}/{{$hospitalInfo->photo ?? 'images/default.jpg'}}" alt="Company photo" class="avatar">
                            </div>
                        </div>  
                        <div class="form-group col-10 mt-3">
                            <input type="hidden" name="oldPhoto" value="{{ $hospitalInfo->photo ?? '' }}">
                            <input type="file" id="photo" name="photo" class="custom-file-input">
                            <label for="photo" class="custom-file-label" style="width:99%;">Choose file</label>
                            <small class="form-text bg-secondary px-1 rounded font-italic">
                                <i>Image format: jpeg, png, jpg, gif, svg. Maximum size : 2 MB.</i>
                            </small>
                        </div>
                    </div>   
                    
                    <div class="row justify-content-md-center mt-2">
                        <button type="submit" class="btn btn-success col-md-4">Save now</button>
                    </div>
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
