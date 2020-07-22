<template>
    <div>
        <h6 class="text-uppercase text-secondary font-weight-bold">Check Availability
            <transition name="fade">
                <span v-if="noAvailability" class="text-danger text-uppercase">(Not available)</span>
                <span v-if="hasAvailability" class="text-success text-uppercase">(Available)</span>
            </transition>

        </h6>

        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="from">From</label>
                <input type="date" id="from" name="from"
                       class="form-control form-control-sm"
                       placeholder="Start date" v-model="from"
                       @keyup.enter="check"
                       :class="[{'is-invalid': this.errorFor('from')}]"
                >
                <v-errors :errors="errorFor('from')"></v-errors>
            </div>

            <div class="form-group col-md-6">
                <label for="to">To</label>
                <input type="date" id="to" name="to"
                       class="form-control form-control-sm"
                       placeholder="End date" v-model="to"
                       @keyup.enter="check"
                       :class="[{'is-invalid': this.errorFor('to')}]"
                >
                <v-errors :errors="errorFor('to')"></v-errors>
            </div>

            <button class="btn btn-secondary btn-block" @click.prevent="check" :disabled="loading">
                <span v-if="!loading">Check!</span>
                <span v-else>
                    <i class="fa fa-circle-notch fa-spin"></i> Checking ...
                </span>
            </button>
        </div>

    </div>
</template>

<script>
    import {is422} from "../shared/utils/response";
    import validationErrors from "../shared/mixins/validationErrors";

    export default {
        name: "Availability",
        mixins: [validationErrors],
        data() {
            return {
                from: this.$store.state.lastSearch.from,
                to: this.$store.state.lastSearch.to,
                loading: false,
                status: null,
            }
        },
        props: {
            bookableId: Number
        },
        computed: {
            hasErrors: function () {
                return this.errors !== null && this.errors !== null;
            },
            hasAvailability: function () {
                return this.status === 200;
            },
            noAvailability: function () {
                return this.status === 404;
            },
        },
        methods: {
            async check() {
                this.loading = true;
                this.errors = null;

                await this.$store.dispatch('setLastSearch', {
                    from: this.from,
                    to: this.to,
                });

                try {
                    this.status = (
                        await axios.get(
                            `/api/bookables/${this.bookableId}/availability?from=${this.from}&to=${this.to}`)
                    ).status;

                    this.$emit('availability', this.hasAvailability)

                } catch (err) {
                    if (is422(err)) {
                        this.errors = err.response.data.errors;
                    }
                    this.status = err.response.status;
                    this.$emit('availability', this.hasAvailability)
                }

                this.loading = false;
            },
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

    .is-invalid {
        border-color: #b22222;
        background-image: none;
    }

    .invalid-feedback {
        border-color: #b22222;

    }
</style>
