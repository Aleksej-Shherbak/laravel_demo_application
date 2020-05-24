<template>
    <div>
        <h6 class="text-uppercase text-secondary font-weight-bold">Check Availability
            <span v-if="noAvailability" class="text-danger text-uppercase">(Not available)</span>
            <span v-if="hasAvailability" class="text-success text-uppercase">(Available)</span>
        </h6>

        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="from">From</label>
                <input type="text" id="from" name="from"
                       class="form-control form-control-sm"
                       placeholder="Start date" v-model="from"
                        @keyup.enter="check"
                        :class="[{'is-invalid': this.errorFor('from')}]"
                >
                <div class="invalid-feedback"
                     v-for="(error, index) in this.errorFor('from')" :key="index">
                    {{ error }}
                </div>
            </div>

            <div class="form-group col-md-6">
                <label for="to">To</label>
                <input type="text" id="to" name="to"
                       class="form-control form-control-sm"
                       placeholder="End date" v-model="to"
                       @keyup.enter="check"
                       :class="[{'is-invalid': this.errorFor('to')}]"
                >
                <div class="invalid-feedback"
                     v-for="(error, index) in this.errorFor('to')" :key="index">
                    {{ error }}
                </div>
            </div>

            <button class="btn btn-secondary btn-block" @click.prevent="check" :disabled="loading">Check!</button>
        </div>

    </div>
</template>

<script>
    export default {
        name: "Availability",
        data() {
            return {
                from: null,
                to: null,
                loading: false,
                status: null,
                errors: null,
            }
        },
        computed: {
            hasErrors: function () {
                return this.errors !== null && this.errors !== null;
            },
            hasAvailability: function() {
                return this.status === 200;
            },
            noAvailability: function() {
                return this.status === 404;
            },
        },
        methods: {
            check() {
                this.loading = true;
                this.errors = null;

                axios.get(`/api/bookables/${this.$route.params.id}/availability?from=${this.from}&to=${this.to}`)
                .then(resp => {
                    this.status = resp.status;
                })
                    .catch(err => {
                        if (422 === err.response.status) {
                            this.errors = err.response.data.errors;
                        }

                        this.status = err.response.status;
                    })
                .finally(() => this.loading = false);
            },
            errorFor(field) {
                return this.hasErrors && this.errors[field] ? this.errors[field] : null;
            }
        }

    }
</script>

<style scoped>
    label {
        font-size: 0.7rem;
        text-transform: uppercase;
        color: gray;
        font-weight: bolder;
    }

    .is-invalid{
        border-color: #b22222;
        background-image: none;
    }

    .invalid-feedback {
        border-color: #b22222;

    }
</style>
