<template>
   <div class="row my-4 justify-content-center">
       <div class="col-12 col-md-3">
           <div class="d-flex justify-content-around">
                <a @click="rejectClient" class="btn btn-danger">
                    {{reject}}
                </a>
                <button type="submit" class="btn btn-primary">
                    {{approve}}
                </button>
            </div>
       </div>
   </div>
</template>


<script>
export default {
    name: "approve-buttons",
    props: {
        reject: {
            type: String,
            required:false,
        },
        approve: {
            type: String,
            required:false,
        }
    },
    methods: {
        rejectClient() {
            history.back();
        },
    },
}
</script>