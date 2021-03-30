<template>
    <div class="col-md-12">
        <div class="col-md-12" style="margin-top: 25px">
            <div class="form-group col-md-4" style="float:left">
                <label style="float:left" for="filter_delivery" class="col-form-label col-md-4">Filter by Delivery:</label>
                <input style="float:left" type="text" v-model="filter.delivery" class="form-control col-md-8" id="filter_delivery">
            </div>
            <div style="float:left" class="form-group col-md-4">
                <label style="float:left" for="filter_name" class="col-form-label col-md-4">Filter by Name:</label>
                <input style="float:left" type="text" v-model="filter.name" class="form-control col-md-8" id="filter_name">
            </div>
            <div style="float:left" class="form-group col-md-4">
                <button type="button" @click="search" class="btn btn-primary">Search</button>
            </div>
        </div>
        <div v-for="pharmacy in pharmacies" class=" col-md-2" style=" float: left; padding-bottom:15px">
            <div class="card">
                <img class="card-img-top" v-if="pharmacy.logo" :src="'images/logos/'+pharmacy.logo"
                     alt="Card image cap">
                <div class="card-body">
                    <h5 class="card-title"><b>{{ pharmacy.name }}</b></h5>
                    <p class="card-text">Phone Number: {{ pharmacy.phone_number }}</p>
                    <p class="card-text">Email Address: {{ pharmacy.email_address }}</p>
                    <p class="card-text">Delivery: {{ pharmacy.delivery }}</p>
                </div>
                <button type="button" class="btn btn-outline-info" data-toggle="modal" data-target="#exampleModal"
                        data-whatever="@mdo" @click="editPharmacy(pharmacy)">Edit
                </button>
                <button type="button" class="btn btn-outline-danger" @click="deletePharmacy(pharmacy)">Delete</button>
            </div>

        </div>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal"
                data-whatever="@mdo" @click="addNewPharmacyPopup">Add New Pharmacy
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
                        <div class="form-group">
                            <label for="exampleFormControlFile2">Logo</label>
                            <input type="file" @change="onLogoChanged" class="form-control-file"
                                   id="exampleFormControlFile2">
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlFile1">Images</label>
                            <input multiple type="file" @change="onFileChange" class="form-control-file"
                                   id="exampleFormControlFile1">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" v-if="modal_type==='update'" class="btn btn-primary"
                                @click="updatePharmacy">Update
                        </button>
                        <button type="button" class="btn btn-primary" v-else @click="savePharmacy">Save</button>
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
                images: [],
                logo: null,
            },
            filter:{
                delivery:null,
                name:null
            },
            pharmacies: [],
            modal_type: 'create'
        }
    },
    mounted() {
        Vue.axios.get('http://127.0.0.1:8000/api/pharmacy').then((response) => {
            this.pharmacies = response.data;
        })
    },
    methods: {
        savePharmacy() {
            let form = new FormData();
            form.append('name', this.new_pharmacy.name);
            form.append('phone_number', this.new_pharmacy.phone_number);
            if (this.new_pharmacy.images && this.new_pharmacy.images.length) {
                for (let i = 0; i < this.new_pharmacy.images.length; i++) {
                    form.append('images[]', this.new_pharmacy.images[i]);
                }
            }
            if (this.new_pharmacy.delivery)
                form.append('delivery', this.new_pharmacy.delivery);
            if (this.new_pharmacy.logo)
                form.append('logo[]', this.new_pharmacy.logo);
            if (this.new_pharmacy.email_address)
                form.append('email_address', this.new_pharmacy.email_address);
            let that = this;
            Vue.axios.post('/api/pharmacy', form)
                .then(function (response) {
                    $('#exampleModal').modal('hide');
                    that.new_pharmacy = {};
                    that.pharmacies.push(response.data);
                    that.$forceUpdate();
                })
                .catch(function (error) {
                    console.log(error);
                });
        },
        updatePharmacy() {
            let form = new FormData();
            form.append('name', this.new_pharmacy.name);
            form.append('phone_number', this.new_pharmacy.phone_number);
            if (this.new_pharmacy.images && this.new_pharmacy.images.length) {
                for (let i = 0; i < this.new_pharmacy.images.length; i++) {
                    form.append('images[]', this.new_pharmacy.images[i]);
                }
            }
            if (this.new_pharmacy.delivery)
                form.append('delivery', this.new_pharmacy.delivery);
            if (this.new_pharmacy.logo)
                form.append('logo[]', this.new_pharmacy.logo);
            if (this.new_pharmacy.email_address)
                form.append('email_address', this.new_pharmacy.email_address);
            let that = this;
            Vue.axios.put('/api/pharmacy/' + this.new_pharmacy.id, form)
                .then(function (response) {
                    $('#exampleModal').modal('hide');
                    that.new_pharmacy = {};
                    // that.pharmacies.push(response.data);
                    that.modal_type = 'create';
                    that.$forceUpdate();
                })
                .catch(function (error) {
                    console.log(error);
                });
        },
        deletePharmacy(data) {
            let that = this;
            Vue.axios.delete('/api/pharmacy/' + data.id).then(function (response) {
                if (response)
                    that.pharmacies.splice(that.pharmacies.indexOf(data), 1);
            });
        },
        onFileChange(e) {
            let files = e.target.files || e.target.files;
            if (!files.length)
                return;
            this.new_pharmacy.images = files;
        },
        editPharmacy(pharmacy) {
            let pharma = JSON.parse(JSON.stringify(pharmacy));
            delete pharma.logo;
            delete pharma.images;
            this.new_pharmacy = pharma;
            this.modal_type = 'update';
            this.$forceUpdate();
        },
        onLogoChanged(e) {
            let files = e.target.files || e.target.files;
            if (!files.length)
                return;
            this.new_pharmacy.logo = files[0];
        },
        search(){
            let filters={};
            if(this.filter.delivery){
                filters.delivery=this.filter.delivery;
            }
            if(this.filter.name){
                filters.name=this.filter.name;
            }
            Vue.axios.post('http://127.0.0.1:8000/api/pharmacy/search',filters).then((response) => {
                this.pharmacies = response.data;
            })
        },
        addNewPharmacyPopup() {
            this.new_pharmacy = {
                name: null,
                phone_number: null,
                email_address: null,
                delivery: null,
                images: [],
                logo: null,
            };
            this.modal_type = 'create';
            this.$forceUpdate();
        }
    }
}
</script>
