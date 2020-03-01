<script type="text/ecmascript">

    export default {
        /**
         * The component's data.
         */
        data() {
            return {};
        },


        /**
         * Prepare the component.
         */
        mounted() {
            document.title = "404 — Holonews.";
        },


        methods: {}
    }
</script>

<template>
    <div>
        <page-header></page-header>

        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="card">
                        <h2 class="mb-5 text-center">404 — Nope !</h2>

                        <p class="text-center">This is not the page you're looking for </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
