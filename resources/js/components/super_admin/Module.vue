<template>
    <div class="card">
        <h5 class="card-header">Modules</h5>
        <div class="card-body">

            <div class="row">
                <div class="col-md-6">
                    <form method="post" id="frm_module" @submit.prevent="createModule">
                        <div class="form-group row">
                            <label for="module_code" class="col-sm-2 col-form-label">Code</label>
                            <div class="col-sm-10">
                                <input v-model="form.module_code" type="text" id="module_code" name="module_code" class="form-control form-control-sm" :class="{ 'is-invalid': form.errors.has('module_code') }">
                                <has-error :form="form" field="module_code"></has-error>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="module_name" class="col-sm-2 col-form-label">Name</label>
                            <div class="col-sm-10">
                                <input v-model="form.module_name" type="text" id="module_name" name="module_name" class="form-control form-control-sm" :class="{ 'is-invalid': form.errors.has('module_name') }">
                                <has-error :form="form" field="module_name"></has-error>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="module_category" class="col-sm-2 col-form-label">Category</label>
                            <div class="col-sm-10">
                                <input v-model="form.module_category" type="text" id="module_category" name="module_category" class="form-control form-control-sm" :class="{ 'is-invalid': form.errors.has('module_category') }">
                                <has-error :form="form" field="module_category"></has-error>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="icon" class="col-sm-2 col-form-label">Icon</label>
                            <div class="col-sm-10">
                                <input v-model="form.icon" type="text" id="icon" name="icon" class="form-control form-control-sm" :class="{ 'is-invalid': form.errors.has('icon') }">
                                <has-error :form="form" field="icon"></has-error>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-12">
                                <button type="submit" class="btn btn-info btn-sm pull-right" >Save</button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="col-md-6">
                    <table class="table table-sm table-striped" id="tbl_modules">
                        <thead>
                            <th>Code</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Icon</th>
                            <th></th>
                        </thead>
                        <tbody id="tbl_modules_body"></tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
    
</template>

<script>
    export default {
        data() {
            return {
                form : new Form({
                    module_code: '',
                    module_name: '',
                    module_category: '',
                    icon: '',
                })
            }
        },
        methods: {
            getModule(return_data) {
                let table = '';

                if (return_data.length > 0) {
                    modules.forEach( function(x,i) {
                        table += '<tr>'+
                                    '<td>'+x.module_code+'</td>'+
                                    '<td>'+x.module_name+'</td>'+
                                    '<td>'+x.module_category+'</td>'+
                                    '<td><i class="'+x.icon+'"></i></td>'+
                                    '<td></td>'+
                                '</td>';
                    });

                    document.getElementById('tbl_modules_body').innerHTML = table;
                } else {
                    axios.get('/api/module').then(function(response) {
                        let modules = response.data;

                        modules.forEach( function(x,i) {
                            table += '<tr>'+
                                        '<td>'+x.module_code+'</td>'+
                                        '<td>'+x.module_name+'</td>'+
                                        '<td>'+x.module_category+'</td>'+
                                        '<td><i class="'+x.icon+'"></i></td>'+
                                        '<td></td>'+
                                    '</td>';
                        });

                        document.getElementById('tbl_modules_body').innerHTML = table;
                    });
                }
            },
            createModule() {
                this.form.post('/api/module').then(function(response) {
                    if (response.statusText == 'OK') {
                        this.getModule(respose.data);
                        alert('Successfully saved.');
                    }
                });
            }
        },
        mounted() {
            this.getModule('');
        }
    }
</script>