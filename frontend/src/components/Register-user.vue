<template>
  <div class="register">
    <p>Register</p>
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
          type="number"
          class="form-control"
          v-model="phone_number"
          placeholder="Phone number"
        />
      </div>
      <div class="mb-3">
        <input
          type="password"
          class="form-control"
          id="password"
          v-model="password"
          placeholder="password"
        />
      </div>
      <div class="mb-3">
        <input
          type="password"
          class="form-control"
          id="confirm_password"
          v-model="confirm_password"
          placeholder="confirm password"
        />
      </div>
      <button type="submit" class="btn btn-warning">Register</button>
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
      phone_number: "",
      password: "",
      confirm_password: "",
    };
  },
  methods: {
    async handleSubmit() {
      const data = {
        first_name: this.first_name,
        last_name: this.last_name,
        phone_number: this.phone_number,
        password: this.password,
        confirm_password: this.confirm_password,
      };

      if (data.password === data.confirm_password) {
        await axios.post("http://localhost:8080/users/add", data);
      } else {
        alert("passwords did not match");
      }

      console.log(data);
    },
  },
};
</script>

<style>
.register {
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
  .register {
    width: 40vw;
  }
}

@media screen and (max-width: 720px) {
  .register {
    width: 60vw;
  }
}

@media screen and (max-width: 1080px) {
  .register {
    width: 60vw;
  }
}
</style>
