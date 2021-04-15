<template>
    <div class="col-md-12">

    <div class="col-md-12">
        <div v-for="value in data" class=" col-md-3" style=" float: left; padding-bottom:15px">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"><b>{{ value.clients.name }}</b></h5>
                    <p class="card-text">Email: {{ value.clients.email }}</p>
                    <p class="card-text">Company Name: {{ value.companies.company_name }}</p>
                </div>
            </div>

        </div>
        </div>


    <div class="col-md-12">
        <h1 class="col-md-12">All Matches</h1>
        <div v-for="match in matches" class=" col-md-2" style=" float: left; padding-bottom:15px">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"><b>{{ match.name }}</b></h5>
                    <p class="card-text">Email: {{ match.email }}</p>
                </div>
            </div>

        </div>
        </div>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal"
                data-whatever="@mdo" @click="addNewClientPopup">Add New Client
        </button>
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add New Client</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name" class="col-form-label">Client Name:</label>
                            <input type="text" v-model="new_data.client_name" class="form-control" id="name">
                        </div>
                        <div class="form-group">
                            <label for="delivery" class="col-form-label">Company Name:</label>
                            <input type="email" v-model="new_data.company_name" class="form-control" id="delivery">
                        </div>
                        <div class="form-group">
                            <label for="email_address" class="col-form-label">Email Address:</label>
                            <input type="email" v-model="new_data.email" class="form-control"
                                   id="email_address">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" @click="saveClient">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Vue from 'vue'
import axios from 'axios'
import VueAxios from 'vue-axios'

Vue.use(VueAxios, axios)
export default {
    data() {
        return {
            new_data: {
                client_name: null,
                company_name: null,
                email: null
            },
            matches:[],
            data: [],
        }
    },
    mounted() {
        Vue.axios.get('http://127.0.0.1:8000/api/client').then((response) => {
            this.data = response.data;
        })
        Vue.axios.get('http://127.0.0.1:8000/api/macthes').then((response) => {
            this.matches = response.data;
        })
        
    },
    methods: {
        saveClient() {
            let form = new FormData();
            form.append('client_name', this.new_data.client_name);
            form.append('company_name', this.new_data.company_name);
            form.append('email', this.new_data.email);
            let that = this;
            Vue.axios.post('/api/client', form)
                .then(function (response) {
                    $('#exampleModal').modal('hide');
                    that.new_data = {};
                    let result={clients:{name:response.data.client_name,email:response.data.email},companies:{company_name:response.data.company_name}}
                    that.data.push(result);
                    that.$forceUpdate();
                })
                .catch(function (error) {
                    console.log(error);
                });
        },
        addNewClientPopup() {
            this.new_data = {
                client_name: null,
                company_name: null,
                email: null
            };
            this.$forceUpdate();
        }
    }
}
</script>
