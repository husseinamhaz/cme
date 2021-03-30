<template>
    <div class="col-md-12">
        <div v-for="pharmacy in pharmacies" class=" col-md-2" style=" float: left; padding-bottom:15px">
            <div class="card">
                <img class="card-img-top" src="" alt="Card image cap">
                <div class="card-body">
                    <h5 class="card-title"><b>{{ pharmacy.name }}</b></h5>
                    <p class="card-text">Phone Number: {{ pharmacy.phone_number }}</p>
                    <p class="card-text">Email Address: {{ pharmacy.email_address }}</p>
                    <p class="card-text">Delivery: {{ pharmacy.delivery }}</p>
                </div>
                <button type="button" class="btn btn-outline-danger" @click="deletePharmacy(pharmacy)">Delete</button>
            </div>

        </div>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal"
                data-whatever="@mdo">Add New Pharmacy
        </button>
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add New Pharmacy</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name" class="col-form-label">Name:</label>
                            <input type="text" v-model="new_pharmacy.name" class="form-control" id="name">
                        </div>
                        <div class="form-group">
                            <label for="phone_number" class="col-form-label">Phone Number:</label>
                            <input type="text" v-model="new_pharmacy.phone_number" class="form-control"
                                   id="phone_number">
                        </div>
                        <div class="form-group">
                            <label for="email_address" class="col-form-label">Email Address:</label>
                            <input type="email" v-model="new_pharmacy.email_address" class="form-control"
                                   id="email_address">
                        </div>
                        <div class="form-group">
                            <label for="delivery" class="col-form-label">Delivery:</label>
                            <input type="email" v-model="new_pharmacy.delivery" class="form-control" id="delivery">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" @click="savePharmacy">Save</button>
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
            new_pharmacy: {
                name: null,
                phone_number: null,
                email_address: null,
                delivery: null,
            },
            pharmacies: []
        }
    },
    mounted() {
        console.log('Component mounted.')
        Vue.axios.get('http://127.0.0.1:8000/pharmacy').then((response) => {
            this.pharmacies = response.data;
        })
    },
    methods: {
        savePharmacy() {
            Vue.axios.post('/pharmacy', this.new_pharmacy)
                .then(function (response) {
                    this.new_pharmacy = {};
                })
                .catch(function (error) {
                    console.log(error);
                });
        },
        deletePharmacy(data){
            let that=this;
            Vue.axios.delete('/pharmacy/'+data.id).then(function (response) {
                if(response)
                    that.pharmacies.splice(that.pharmacies.indexOf(data),1);
            });
        }
    }
}
</script>
