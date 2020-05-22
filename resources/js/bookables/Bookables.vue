<template>
    <div>
        <div v-if="loading">
            Loading ...
        </div>

        <div class="row mb-4" v-for="row in rows" :key="'row'+row">
            <div class="col" v-for="(bookable, column) in bookableInRow(row)"
                 :key="'row' + row + column">
                <bookable-list-item
                    :title="bookable.title"
                    :content="bookable.content"
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
            setTimeout(() => {
                this.bookables = [
                    {
                        title: "Expensive villa 1",
                        content: "This is pretty expensive villa 1",
                        price: 2000
                    },
                    {
                        title: "Expensive villa 2",
                        content: "This is very expensive villa 2",
                        price: 5000
                    },
                    {
                        title: "Expensive villa 3",
                        content: "This is pretty expensive villa 3",
                        price: 2000
                    },
                    {
                        title: "Expensive villa 4",
                        content: "This is very expensive villa 4",
                        price: 5000
                    },
                    {
                        title: "Expensive villa 5",
                        content: "This is pretty expensive villa 5",
                        price: 2000
                    },
                    {
                        title: "Expensive villa 6",
                        content: "This is very expensive villa 6",
                        price: 5000
                    },
                    {
                        title: "Expensive villa 7",
                        content: "This is very expensive villa 7",
                        price: 5000
                    },
                ];
                this.loading = false;
            }, 3000);
        },
        computed: {
            rows() {
                return Math.ceil(this.bookables.length / this.columns);
            }
        },
        methods:  {
            bookableInRow : function(row) {
                return this.bookables.slice((row - 1) * this.columns, row * this.columns)
            },
            placeholdersInRow: function (row) {
                return  this.columns - this.bookableInRow(row).length
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
