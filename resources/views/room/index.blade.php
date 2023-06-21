@extends('layouts.app')
   @section('title') Room-seat @endsection
@section('content')
@include('includes.alertMessage')

<div class="content-wrapper p-3">
   <div class="row justify-content-center">
      <div class="col-md-12">
         <div class="card-header p-1">
            <ul class="nav nav-pills" id="tabMenu">              
               <li class="nav-item">
                  <a class="nav-link active btn-sm py-1 m-1" data-toggle="pill" href="#floorRoom">Floor & room</a>
               </li>
            </ul>
         </div>

         <div class="card-body p-1">
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="floorRoom">
                  <div class="card border border-danger">
                     <div class="card-header p-1">
                        <ul class="nav nav-pills" id="tabMenu">
                           <li class="nav-item">
                              <button class="btn btn-sm btn-success text-light" data-toggle="modal" data-original-title="test" data-target="#addfloorRoom">Add floor or room</button>
                           </li>
                        </ul>
                     </div>
                     <div class="card-body p-1">
                        <table class="table table-bordered">
                           <thead class="bg-info">
                                <th>Floor</th>
                                <th>Room no</th>
                           </thead>
                           <tbody>
                              @foreach($floors as $floor)
                                 @php $child = $floor->rooms->count()  @endphp
                                 <tr>
                                    <td rowspan="{{$child+1}}">{{$floor->floor}} ({{$child}})</td>
                                 </tr>
                                 @if($child > 1)
                                    @foreach($floor->rooms->sortBy('room') as $room)
                                       <tr>
                                          <td>{{$room->room}}</td>
                                       </tr>
                                    @endforeach
                                @endif
                              @endforeach
                           </tbody>
                        </table>
                     </div>

                     {{-- Add floor & room --}}
                     <div class="modal fade" id="addfloorRoom" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                           <div class="modal-content">
                              <div class="modal-header">
                                 <h6 class="modal-title text-center" id="exampleModalLabel">Add floor or room</h6>
                                 <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                              </div>
                              <div class="card-header p-1">
                                 <ul class="nav nav-pills">
                                    <li class="nav-item">
                                        <a class="nav-link active btn-sm py-1 m-1" data-toggle="pill" href="#addRoomTab">Add room</a>
                                    </li>                                 
                                    <li class="nav-item">
                                       <a class="nav-link btn-sm py-1 m-1" data-toggle="pill" href="#addFloor">Add floor</a>
                                    </li>
                                 </ul>
                              </div>

                              <div class="modal-body">
                                 <div class="tab-content" id="pills-tabContent">
                                    <div class="tab-pane fade active show" id="addRoomTab">
                                       <form action="{{ route('addRoom') }}" method="post" enctype="multipart/form-data" class="needs-validation" >
                                          @csrf
                                          <div class="form-group">
                                                <label for="floor">Floor no*</label>
                                                <select class="form-control" name="floor" id="floor" required>
                                                    <option value="">Select floor</option>
                                                    @foreach($floors as $floor)
                                                        <option value="{{$floor->id}}">{{$floor->floor}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                          <fieldset>
                                             <legend>Value options</legend>
                                                <div id="roomRow">
                                                   <div class="row justify-content-center">
                                                      <i class="fa fa-chevron-down pt-3"></i>
                                                      <div class="col-8 form-group">
                                                         <input type="text" name="room[]" class="form-control" placeholder="Ex: 101, 102..." required/>
                                                      </div>
                                                      <button type="button" class="btn">
                                                         <i class="fa fa-trash "></i>
                                                      </button>
                                                   </div>                  
                                                </div>
                                                <div class="row justify-content-center"> 
                                                   <div class="col-8">
                                                      <button type="button" id="addRoom" class="btn btn-primary">
                                                         <i class="fa fa-plus">&nbsp; Add more room</i>
                                                      </button>
                                                   </div>
                                                </div>
                                          </fieldset>

                                          <div class="modal-footer">
                                             <div class="btn-group">
                                                <button class="btn btn-sm btn-success">Save</button>
                                                <button class="btn btn-sm btn-secondary" type="button" data-dismiss="modal">Close</button>
                                             </div>
                                          </div>
                                       </form>
                                    </div>

                                    <div class="tab-pane fade show" id="addFloor">
                                       <form action="{{ route('addFloor') }}" method="post" enctype="multipart/form-data" class="needs-validation" >
                                          @csrf
                                          <div class="form-group">
                                             <label for="floor">Floor no*</label>
                                             <input type="text" name="floor" class="form-control" id="floor" placeholder="Ex: 1st, 2nd, 3rd..." required/>
                                             <small class="form-text bg-info px-1 rounded font-italic">
                                                Please follow this instruction. Example: 1st, 2nd, 3rd.
                                            </small>
                                          </div>
                                          <div class="modal-footer">
                                             <div class="btn-group">
                                                <button class="btn btn-sm btn-success">Save</button>
                                                <button class="btn btn-sm btn-secondary" type="button" data-dismiss="modal">Close</button>
                                             </div>
                                          </div>
                                       </form>                                      
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>                  
                  </div>
               </div>               
            </div>
         </div>
      </div>
   </div>
</div>

@endsection

@section('js')
@endsection
