const { default: axios } = require("axios");
import Swal from 'sweetalert2'
import Vue from 'vue';
import vmodal from 'vue-js-modal';
import Datepicker from 'vuejs-datepicker';
Vue.use(vmodal);
const app = new Vue({
    el: '#company',
    components :{
        Datepicker,
    },
    data(){
        return {
            companies : [],
            showCompanyModal : false,
            editCompanyModal : false,
            name : "",
            email : "",
            logo : "",
            video : "",
            website : "",
            url : "",
            company_id : "",
            feature_image : "",
            feature_video : "",
            search : ""
        }
    },
    methods:{
        clickHandler(){
            console.log("EditGrooup");
        },
        getAllCompany(){   
                $('#datatable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: '/companyData',
                    columns : [
                        { data : 'name' , name : 'name' },
                        { data : 'email' , name : 'email' },
                        { data : 'logo' , name : 'logo' },
                        { data : 'video' , name : 'video' },
                        { data : 'website' , name : 'website' },
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
        resetData(){
            this.name = "";
            this.email = "";
            this.logo = "";
            this.video = "";
            this.website = "";
            this.company_id = "";
            this.url = "";
            if (this.showCompanyModal) {
                this.showCompanyModal = false;
            }
            if (this.editCompanyModal) {           
                this.editCompanyModal = false;
            }
        },
        uploadLogo(event){
            this.logo = event.target.files[0];
        },
        uploadVideo(event){
            this.video = event.target.files[0];
        },
        async addCompany(){
           let data = new FormData();
           data.append("name",this.name);
           data.append("email",this.email);
           data.append("logo",this.logo);
           data.append("video",this.video);
           data.append("website",this.website);
           const config = {
            headers: {
                'content-type': 'multipart/form-data'
            }
        };
           await axios.post('/company',data,config)
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
        async Edit(company)
        {
            this.editCompanyModal = true;
            await axios.get('/company/'+company+'/edit')
                        .then(response=>{
                            this.company_id = response.data.id;
                            this.name = response.data.name;
                            this.email = response.data.email;
                            this.website = response.data.website;
                            this.feature_image = response.data.logo;
                            this.feature_video = response.data.video;
                            this.url = response.data.url;
                        })
                        .catch(console.error());
        },
        updateLogo(event){
            this.logo =  event.target.files[0];
        },
        updateVideo(event){
           this.video =  event.target.files[0];
        },
        updateCompany(id){
            let update_data = new FormData();
            update_data.append('_method', 'patch');
            update_data.append('name',this.name);
            update_data.append('email',this.email);
            update_data.append('website',this.website);
            update_data.append('logo',this.logo);
            update_data.append('video',this.video);
            axios.post('/company/'+id,update_data,{
                headers : {
                    'Content-type':'multipart/form-data'
                }
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
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
                reverseButtons : true,
              }).then((result) => {
                if (result.isConfirmed) {
                    axios.delete('/company/'+id)
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
            $('#datatable').DataTable().ajax.url(`/companyData?name=${search}&date=${date}`).load();
        }
    },
    mounted(){  
       this.getAllCompany();
    },
});

