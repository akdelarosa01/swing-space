<template>
    <form method="post" id="frm_module" action="api/module">
        <div class="form-group row">
            <label for="module_code" class="col-sm-2 col-form-label">Code</label>
            <div class="col-sm-10">
                <input type="text" class="form-control form-control-sm" id="module_code" name="module_code">
            </div>
        </div>
        <div class="form-group row">
            <label for="module_name" class="col-sm-2 col-form-label">Name</label>
            <div class="col-sm-10">
                <input type="text" class="form-control form-control-sm" id="module_name" name="module_name">
            </div>
        </div>
        <div class="form-group row">
            <label for="module_category" class="col-sm-2 col-form-label">Category</label>
            <div class="col-sm-10">
                <input type="text" class="form-control form-control-sm" id="module_category" name="module_category">
            </div>
        </div>
        <div class="form-group row">
            <label for="icon" class="col-sm-2 col-form-label">Icon</label>
            <div class="col-sm-10">
                <input type="text" class="form-control form-control-sm" id="icon" name="icon">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-sm-12">
                <button type="submit" class="btn btn-info btn-sm pull-right" @click.prevent="save_module()">Save</button>
            </div>
        </div>
    </form>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>