<template>
    <div>
        <div v-if="loading">
            Loading ...
        </div>

        <bookable-list-item v-for="(bookable, index) in bookables"
            :title="bookable.title"
            :content="bookable.content"
            :price="bookable.price"
            :key="index">
        </bookable-list-item>
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
                        content: "This is pretty expensive vile 1",
                        price: "2000$"
                    },
                    {
                        title: "Expensive villa 2",
                        content: "This is very expensive vile 2",
                        price: "5000$"
                    },
                ];
                this.loading = false;
            }, 3000);
        },
        data: function () {
            return {
                bookables: [],
                loading: false,
            }
        }
    }
</script>

<style scoped>

</style>
