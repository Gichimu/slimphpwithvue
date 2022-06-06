import { createRouter, createWebHistory } from "vue-router";
import Login from "../components/Login-user.vue";
import Register from "../components/Register-user.vue";
import Profile from "../components/User-profile.vue";

const routes = [
  {
    path: "/",
    name: "login",
    component: Login,
  },
  {
    path: "/register",
    name: "register",
    component: Register,
  },
  {
    path: "/profile",
    name: "profile",
    component: Profile,
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

router.beforeEach(async (to) => {
  if (
    // make sure the user is authenticated
    localStorage.getItem("token") == null &&
    // ❗️ Avoid an infinite redirect
    to.name == "profile"
  ) {
    // redirect the user to the login page
    return { name: "login" };
  }
});

export default router;
