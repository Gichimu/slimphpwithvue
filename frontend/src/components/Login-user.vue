<template>
  <div class="login">
    <p>Sign in</p>
    <form @submit.prevent="handleSubmit">
      <div class="mb-3">
        <input
          type="text"
          class="form-control"
          v-model="first_name"
          placeholder="First name"
        />
      </div>
      <div class="mb-3">
        <input
          type="text"
          class="form-control"
          v-model="last_name"
          placeholder="Last name"
        />
      </div>
      <div class="mb-3">
        <input
          type="password"
          class="form-control"
          v-model="password"
          placeholder="password"
        />
      </div>
      <button type="submit" class="btn btn-warning">Login</button>
    </form>
  </div>
</template>

<script>
import axios from "axios";
export default {
  data() {
    return {
      first_name: "",
      last_name: "",
      password: "",
    };
  },
  methods: {
    async handleSubmit() {
      const pw = this.password;
      const data = {
        first_name: this.first_name,
        last_name: this.last_name,
      };

      // get user
      const user_data = await axios.post("http://localhost:8080/user", data);

      if (pw != user_data.data.password) {
        console.log("password not correct");
      } else {
        // get auth token
        const response = await axios.post("http://localhost:8080/token", data);
        const token = response.data.token;
        const expiry = response.data.expires;
        const first_name = user_data.data.first_name;
        const last_name = user_data.data.last_name;
        const phone_number = user_data.data.phone_number;
        localStorage.setItem("token", token);
        localStorage.setItem("expiry", expiry);
        localStorage.setItem("first_name", first_name);
        localStorage.setItem("last_name", last_name);
        localStorage.setItem("phone_number", phone_number);
        this.$router.push("profile");
      }
    },
  },
};
</script>

<style>
.login {
  position: absolute;
  top: 50%;
  left: 50%;
  width: 30vw;
  transform: translate(-50%, -50%);
  border: 1px solid grey;
  box-shadow: 0 1em 2em 0 grey;
  border-radius: 10px;
  padding: 3vw;
  display: flex;
  flex-direction: column;
  justify-content: space-evenly;
}
.btn {
  font-weight: bold;
  width: 100%;
}
p {
  font-weight: bold;
  font-size: 1.5em;
}

@media screen and (max-width: 480px) {
  .login {
    width: 40vw;
  }
}

@media screen and (max-width: 720px) {
  .login {
    width: 60vw;
  }
}

@media screen and (max-width: 1080px) {
  .login {
    width: 60vw;
  }
}
</style>
