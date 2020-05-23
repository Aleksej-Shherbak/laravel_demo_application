<template>
    <div>
        <div v-if="loading">
            Loading ...
        </div>

        <div class="row mb-4" v-for="row in rows" :key="'row'+row">
            <div class="col d-flex align-items-stretch" v-for="(bookable, column) in bookableInRow(row)"
                 :key="'row' + row + column">
                <bookable-list-item
                    :title="bookable.title"
                    :description="bookable.description"
                    :price="bookable.price">
                </bookable-list-item>
            </div>
            <div class="col" v-for="p in placeholdersInRow(row)" :key="'placeholder' + row + p"></div>
        </div>

    </div>
</template>

<script>
    import BookableListItem from "./BookableListItem";

    export default {
        name: "Bookables",
        components: {
            BookableListItem
        },
        created() {
            this.loading = true;
            const request = axios.get('/api/bookables')
                .then(resp => {
                    this.bookables = resp.data;
                    this.loading = false
                })
            .catch(error => {
                console.error(error);
            });
        },
        computed: {
            rows() {
                return Math.ceil(this.bookables.length / this.columns);
            }
        },
        methods: {
            bookableInRow: function (row) {
                return this.bookables.slice((row - 1) * this.columns, row * this.columns)
            },
            placeholdersInRow: function (row) {
                return this.columns - this.bookableInRow(row).length
            }
        },
        data: function () {
            return {
                bookables: [],
                loading: false,
                columns: 3
            }
        }
    }
</script>

<style scoped>

</style>
