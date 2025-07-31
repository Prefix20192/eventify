<template>
    <div>
        <h1 class="text-3xl font-bold underline">asdasdasd</h1>
<!--        <ul>-->
<!--            <li v-for="product in products" :key="product.id">-->
<!--                <strong>{{ product.name }}</strong> - {{ product.price }}₽-->
<!--                <index-link :to="`/products/${product.id}/edit`">Edit</index-link>-->
<!--                <button @click="deleteProduct(product.id)" class="delete-btn">Delete</button>-->
<!--            </li>-->
<!--        </ul>-->
<!--        <index-link to="/products/create" class="create-btn">Create New Product</index-link>-->
    </div>
</template>

<script>

export default {
// import axios from 'axios';
//
// export default {
//     data() {
//         return {
//             products: [],
//         };
//     },
//     async created() {
//         const response = await axios.get('/api/products');
//         this.products = response.data;
//     },
//     methods: {
//         async deleteProduct(id) {
//             if (confirm('Are you sure you want to delete this product?')) {
//                 await axios.delete(`/api/products/${id}`);
//                 this.products = this.products.filter(product => product.id !== id);
//             }
//         },
//     },
};
</script>

<style scoped>

</style>
