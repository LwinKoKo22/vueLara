@extends('backend.layouts.app')
@section('company-active','active')
@section('title','Company')
@section('content')
<div id="company">
   <template>
        <div class="row">
            <div class="col-12">
                <div class="row align-items-center mb-3">
                    <div class="col-4 text-center"> 
                        <input type="text" class="form-control" placeholder="Search here...." id="search">
                    </div>
                    <div class="col-4 text-center"> 
                          <input type="text" class="form-control date" placeholder="All"/>
                    </div>
                    <div class="col-4 text-center">
                        <button  class="btn btn-primary btn-block" v-on:click="Search">Search</button>
                    </div>
                </div>    
                <div name="modal" v-if="editCompanyModal">
                    <div class="modal-mask">
                      <div class="modal-wrapper">
                        <div class="modal-container">
                            <div class="modal-header">
                                <h5 class="mb-0">Edit Company</h5>
                                <button  v-on:click="resetData" class="btn btn-default">&#10006;</button>
                            </div>
                           <div class="modal-body">
                            <form v-on:submit.prevent="updateCompany(company_id)">
                                <input type="hidden" v-model="company_id">
                                <div class="form-group">
                                  <label for="name">Name</label>
                                  <input type="text" class="form-control" id="name" v-model="name">
                                </div>
                                <div class="form-group">
                                  <label for="email">Email Address</label>
                                  <input type="email" class="form-control" id="email" v-model="email">
                                </div>
                                <div class="form-group">
                                    <label for="website">Website</label>
                                    <input type="text" class="form-control" id="website" v-model="website">
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <img v-bind:src="url+'/'+feature_image" alt="logo" width="180px" height="100px">
                                        <div class="form-group">
                                            <label for="file">Logo</label>
                                            <input type="file" class="custom-file" id="file" v-on:change="updateLogo">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <video width="180px" height="100px" controls>
                                            <source v-bind:src="url+'/'+feature_video" type="video/mp4">
                                        </video>
                                        <div class="form-group">
                                            <label for="video">Video</label>
                                            <input type="file" class="custom-file" id="video" v-on:change="updateVideo">
                                        </div>
                                    </div>
                                </div>                         
                                <button type="submit" class="btn btn-primary btn-block">Update</button>
                            </form>
                           </div>
                        </div>
                      </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <h4 class="mb-0">Company List</h4>
                            <div>
                                <button v-on:click="showCompanyModal = true" class="btn btn-primary "><i class="fas fa-circle-plus"></i> Add New Company</button>
                                <div name="modal" v-if="showCompanyModal">
                                    <div class="modal-mask">
                                      <div class="modal-wrapper">
                                        <div class="modal-container">
                                            <div class="modal-header">
                                                <h5 class="mb-0">New Company</h5>
                                                <button  v-on:click="resetData" class="btn btn-default">&#10006;</button>
                                            </div>
                                           <div class="modal-body">
                                            <form @submit.prevent="addCompany">
                                                <div class="form-group">
                                                  <label for="name">Name</label>
                                                  <input type="text" class="form-control" id="name" v-model="name">
                                                </div>
                                                <div class="form-group">
                                                  <label for="email">Email Address</label>
                                                  <input type="email" class="form-control" id="email" v-model="email">
                                                </div>
                                                <div class="form-group">
                                                    <label for="website">Website</label>
                                                    <input type="text" class="form-control" id="website" v-model="website">
                                                </div>
                                                <div class="row">
                                                    <div class="col-6">
                                                        <div class="form-group">
                                                            <label for="file">Logo</label>
                                                            <input type="file" class="custom-file" id="file" v-on:change="uploadLogo">
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="form-group">
                                                            <label for="video">Video</label>
                                                            <input type="file" class="custom-file" id="video" v-on:change="uploadVideo">
                                                        </div>
                                                    </div>
                                                </div>                         
                                                <button type="submit" class="btn btn-primary btn-block">Submit</button>
                                            </form>
                                           </div>
                                        </div>
                                      </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="datatable" class="table table-responsive table-striped table-bordered" width="100%">
                            <thead>
                                <tr>
                                    <th class="no-sort">Name</th>
                                    <th class="no-sort">Email</th>  
                                    <th class="no-sort no-search">Logo</th>
                                    <th class="no-sort no-search">Video</th>
                                    <th class="no-sort no-search">Website</th>
                                    <th class="no-sort">Created At</th>
                                    <th class="no-sort no-search">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
   </template>
</div>
@endsection
@section('scripts')
<script src="{{ asset('/js/company.js') }}"></script>
<script>
     //DaterangePicker
     $('.date').daterangepicker({
                autoUpdateInput: false,
                locale: {
                    cancelLabel: 'Clear'
                }
            });

            $('.date').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('YYYY/MM/DD') + ' - ' + picker.endDate.format('YYYY/MM/DD'));
            });

            $('.date').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
            });
</script>
@endsection