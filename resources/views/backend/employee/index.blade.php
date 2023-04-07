@extends('backend.layouts.app')
@section('employee-active','active')
@section('title','Employee')
@section('content')
<div id="employee">
   <template>
        <div class="row">
            <div class="col-12">
                <div class="row align-items-center mb-3">
                    <div class="col-3">
                        <select id="company" class="form-control">
                            <option value="">All</option>
                            @foreach ($companies as $company)
                                <option value="{{ $company->id }}">{{ $company->name }}</option>
                            @endforeach
                        </select>
                </div>
                    <div class="col-3 text-center"> 
                        <input type="text" class="form-control" placeholder="Search here...." id="search">
                    </div>
                    <div class="col-3 text-center"> 
                          <input type="text" class="form-control date" placeholder="All"/>
                    </div>
                    <div class="col-3 text-center">
                        <button  class="btn btn-primary btn-block" v-on:click="Search">Search</button>
                    </div>
                </div>
                <div name="modal" v-if="editEmployeeModal">
                    <div class="modal-mask">
                      <div class="modal-wrapper">
                        <div class="modal-container">
                            <div class="modal-header">
                                <h5 class="mb-0">New Company</h5>
                                <button  v-on:click="resetData" class="btn btn-default">&#10006;</button>
                            </div>
                           <div class="modal-body">
                            <form @submit.prevent = "updateEmployee(employee_id)">
                                <input type="hidden" v-model="employee_id">
                                <div class="form-group">
                                  <label for="name">First Name</label>
                                  <input type="text" class="form-control" id="name" v-model="fname">
                                </div>
                                <div class="form-group">
                                    <label for="name">Last Name</label>
                                    <input type="text" class="form-control" id="name" v-model="lname">
                                </div>
                                <div class="form-group">
                                    <label for="company">Company</label>
                                    <select  id="company" class="form-control" v-model="company">
                                        <option v-for="company in companies"  :key="company.id" v-bind:value="company.id" :selected="company.id == company">
                                            @{{ company.name }}
                                        </option>
                                    </select>
                                </div>
                                <div class="form-group">
                                  <label for="email">Email Address</label>
                                  <input type="email" class="form-control" id="email" v-model="email">
                                </div>       
                                <div class="form-group">
                                    <label for="phone">Phone</label>
                                    <input type="number" class="form-control" id="phone" v-model="phone">
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
                            <h5 class="mb-0">Employee List</h5>
                            <div>
                                <button v-on:click="createForm" class="btn btn-primary"><i class="fas fa-circle-plus"></i> Add New Company</button>
                                <div name="modal" v-if="showEmployeeModal">
                                    <div class="modal-mask">
                                      <div class="modal-wrapper">
                                        <div class="modal-container">
                                            <div class="modal-header">
                                                <h5 class="mb-0">New Employee</h5>
                                                <button  v-on:click="resetData" class="btn btn-default">&#10006;</button>
                                            </div>
                                           <div class="modal-body">
                                            <form @submit.prevent = "storeEmployee">
                                                <div class="form-group">
                                                  <label for="name">First Name</label>
                                                  <input type="text" class="form-control" id="name" v-model="fname">
                                                </div>
                                                <div class="form-group">
                                                    <label for="name">Last Name</label>
                                                    <input type="text" class="form-control" id="name" v-model="lname">
                                                </div>
                                                <div class="form-group">
                                                    <label for="company">Company</label>
                                                    <select  id="company" v-model="company" class="form-control">
                                                        <option v-for="company in companies"  :key="company.id" v-bind:value="company.id">
                                                            @{{ company.name }}
                                                        </option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                  <label for="email">Email Address</label>
                                                  <input type="email" class="form-control" id="email" v-model="email">
                                                </div>       
                                                <div class="form-group">
                                                    <label for="phone">Phone</label>
                                                    <input type="number" class="form-control" id="phone" v-model="phone">
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
                        <table id="datatable" class="table  table-striped table-bordered" width="100%">
                            <thead>
                                <tr>
                                    <th class="no-sort">First Name</th>
                                    <th class="no-sort">Last Name</th>
                                    <th class="no-sort">Company</th>
                                    <th class="no-sort">Email</th>  
                                    <th class="no-sort ">Phone</th>
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
<script src="{{ asset('/js/employee.js') }}"></script>
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