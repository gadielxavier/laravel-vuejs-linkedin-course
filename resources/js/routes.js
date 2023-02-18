import CategoryManager from "./components/CategoryManager.vue";
import { createRouter, createWebHistory } from "vue-router";
import MenuItem from "./components/MenuItem.vue";
import MenuItemList from "./components/MenuItemList.vue";

const routes = [
    {
        path: "/",
        redirect: { name: "categories" },
    },
    {
        path: "/categories",
        name: "categories",
        component: CategoryManager,
    },
    {
        path: "/add-item",
        name: "add-item",
        component: MenuItem,
    },
    {
        path: '/edit-item/:id',
        name: 'edit-item',
        component: MenuItem,
        props: true
    },
    {
        path: '/items',
        name: 'items',
        component: MenuItemList
    },
    {
      // path: "*",
      path: "/:catchAll(.*)",
      name: "NotFound",
      redirect: '/',
      meta: {
        requiresAuth: false
      }
    },
];

const router = new createRouter({
    history: createWebHistory("/menu-editor"),
    routes,
});

export default router;
