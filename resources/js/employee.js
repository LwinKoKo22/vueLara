import axios from "axios";
import Swal from "sweetalert2";
const app = new Vue({
    el : "#employee",    
    data(){
        return {
            title : "Employee",
            showEmployeeModal : false,
            editEmployeeModal : false,
            companies : [],
            fname : "",
            lname : "",
            company : "",
            email : "",
            phone : "",
            employee_id : "",
        }
    },
    methods : {
        getAllEmployee(){
            $('#datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '/employeeData',
                columns : [
                    { data : 'fname' , name : 'fname' },
                    { data : 'lname' , name : 'lname' },
                    { data : 'company_id' , name : 'company_id' },
                    { data : 'email' , name : 'email' },
                    { data : 'phone' , name : 'phone' },
                    { data : 'created_at' , name : 'created_at' },
                    { data : 'action' , name : 'action'}
                ],
                columnDefs: [
                    { 
                        targets: "no-sort", 
                        sortable : false
                    },
                    {
                        targets : "no-search",
                        searchable : false
                    }
                ],
            });

            $('#datatable').on('click', '.edit', (event) => {
                const id = event.target.value;
                this.Edit(id);
            });

            $('#datatable').on('click', '.delete', (event) => {
                const id = event.target.value;
                this.Delete(id);
            });
        },
        async createForm(){
            await axios.get('/employee/create')
            .then(response=>{
                this.companies = response.data;
                this.showEmployeeModal = true;
            })
            .catch(console.error());
        },
        resetData(){
            this.fname = null;
            this.lname = null;
            this.company = null;
            this.email = null;
            this.phone = null;
            this.employee_id = null;
            this.showEmployeeModal = false;
            this.editEmployeeModal = false;
        },
        storeEmployee(){
            let data = new FormData();
            data.append('fname',this.fname);
            data.append('lname',this.lname);
            data.append('company',this.company);
            data.append('email',this.email);
            data.append('phone',this.phone);
            axios.post('/employee',data)
            .then(response=>{
                    this.resetData();
                    $('#datatable').DataTable().draw();
                    Swal.fire({
                        position: 'center-center',
                        icon: 'success',
                        title: response.data,
                        showConfirmButton: false,
                        timer: 1500
                    })
            })
            .catch(console.error());
        },
        async Edit(id){
            this.editEmployeeModal = true;
            await axios.get('/employee/'+id+'/edit')
            .then(response=>{
                this.employee_id = response.data.employee.id;
                this.fname = response.data.employee.fname;
                this.company = response.data.employee.company_id;
                this.lname = response.data.employee.lname;
                this.email = response.data.employee.email;
                this.phone = response.data.employee.phone;
                this.companies = response.data.companies;
            })
            .catch(console.error());
        },
        updateEmployee(id){
            let data = new FormData();
            data.append('fname',this.fname);
            data.append('lname',this.lname);
            data.append('company',this.company);
            data.append('email',this.email);
            data.append('phone',this.phone);
            axios.patch('/employee/'+id,{
                fname : this.fname,
                lname : this.lname,
                company : this.company,
                email : this.email,
                phone : this.phone
            })
            .then(response=>{
                console.log(response.data);
                this.resetData();
                $('#datatable').DataTable().draw();
                Swal.fire({
                    position: 'center-center',
                    icon: 'success',
                    title: response.data,
                    showConfirmButton: false,
                    timer: 1500
                })
            })
            .catch(console.error());
        },
        Delete(id){
             Swal.fire({
                title: 'Are you sure you want to delete?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!',
                reverseButtons : true,
              }).then((result) => {
                if (result.isConfirmed) {
                    axios.delete('/employee/'+id)
                    .then(response=>{
                        $('#datatable').DataTable().draw();
                        Swal.fire(
                            'Deleted!',
                            response.data,
                            'success'
                        )
                    })
                    .catch(console.error());
                }
              })
        },
        Search(){
            var search = $('#search').val();
            var date = $('.date').val();
            var company = $('#company').val();
            $('#datatable').DataTable().ajax.url(`/employeeData?name=${search}&date=${date}&company=${company}`).load();
        }
    },
    mounted(){
        this.getAllEmployee();
    }      
});