<template>
    <div>
        <h1>Menu Editor</h1>
        <RouterLink class="link" :to="{ name: 'categories' }">Categories</RouterLink>
        <RouterLink class="link" :to="{ name: 'items' }">Items</RouterLink>
        <RouterLink class="link" :to="{ name: 'add-item' }">Add Item</RouterLink>
        <RouterView />
    </div>
</template>

<script>

import store from '../store';

export default {
    store,
    props: ["categories"],
    created() {
        this.$store.commit('SET_CATEGORIES', _.cloneDeep(this.categories));
    }
};
</script>

<style scoped>
.a {
    border: solid 1px;
    padding: 10 px;
    margin: 0;
}
.router-link-active {
    font-weight: bold;
    border-bottom: none;
}

.link {
    margin: 10px;
}
.link.active {
    background-color: red;
    color: white;
}
</style>
