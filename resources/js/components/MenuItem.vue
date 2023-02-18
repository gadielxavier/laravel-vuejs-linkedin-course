<template>
    <form class="item-form" @submit.prevent="save">
        <div>
            <input
                type="text"
                placeholder="Item name"
                v-model="item.name"
                required
            />
            $<input type="number" min="0" step=".01" v-model="item.price" />
        </div>
        <div>
            <textarea
                v-model="item.description"
                placeholder="Item description"
                required
            ></textarea>
        </div>
        <div>
            <select v-model="item.category_id" required>
                <option value="">Select a category</option>
                <option
                    v-for="cat in categories"
                    :value="cat.id"
                    :key="cat.id"
                >
                    {{ cat.name }}
                </option>
            </select>
        </div>
        <img
            v-if="id && item.image"
            :src="`/storage/images/${item.image}`"
            width="200"
        />
        <dropZone ref="dropZone"></dropZone>
        <button type="submit">Save</button>
        <ul>
            <li v-for="(error, index) in errors" :key="index">{{ error }}</li>
        </ul>
    </form>
</template>

<script>
import DropZone from "./DropZone.vue";
import { mapState } from "vuex";

function newItem() {
    return {
        name: "",
        price: 0.0,
        image: "",
        category_id: "",
        description: "",
    };
}

export default {
    components: {
        dropZone: DropZone,
    },
    props: ['id'],
    data() {
        return {
            item: newItem(),
            errors: [],
        };
    },
    computed: mapState({
        categories: 'categories'
    }),
    created() {
        if (this.id) {
            axios
                .get(`/api/menu-items/` + this.id)
                .then((res) => (this.item = res.data));
        }
    },
    beforeRouteLeave(to, from, next) {
        this.item = newItem();
        next();
    },
    methods: {
        save() {
            let files = this.$refs.dropZone.acceptedFiles;

            if (files.length > 0 && files[0].name) {
                this.item.image = files[0].name;
            }

            let url = "/api/menu-items/add";

            if (this.id) {
                url = "/api/menu-items/" + this.id;
            }

            axios
                .post(url, this.item)
                .then((res) => {
                    this.$router.push("/");
                })
                .catch((error) => {
                    let messages = Object.values(error.response.data.errors);
                    this.errors = [].concat.apply([], messages);
                });
        },
    },
};
</script>
