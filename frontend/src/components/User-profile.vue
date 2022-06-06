<template>
  <div class="profile">
    <h4>Welcome to your profile, friend</h4>
    <div class="profile-data">
      <div class="left">
        <img
          src="https://img.favpng.com/8/0/5/computer-icons-user-profile-avatar-png-favpng-6jJk1WU2YkTBLjFs4ZwueE8Ub.jpg"
          alt="prof"
          class="img-thumbnail"
        />
        <button
          type="button"
          @click="logout"
          class="btn btn-warning logout-button"
        >
          Logout
        </button>
      </div>
      <div class="right">
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

          <span class="action-buttons">
            <button type="button" class="btn btn-warning">Edit</button>
          </span>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      first_name: localStorage.getItem("first_name"),
      last_name: localStorage.getItem("last_name"),
      phone_number: localStorage.getItem("phone_number"),
    };
  },
  // this.first_name = ;
  // this.last_name = ;
  // this.phone_number = ;

  methods: {
    logout() {
      localStorage.removeItem("token");
      localStorage.removeItem("expiry");
      this.$router.go("login");
    },
  },
};
</script>

<style>
.profile {
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

.profile-data {
  display: flex;
  flex-direction: row;
  justify-content: space-evenly;
  width: 100%;
}

.left,
.right {
  margin: 1em;
}

.left {
  max-width: 30%;
}

.left img {
  width: auto;
  background: none;
}

.right {
  width: 70;
}

.logout-button {
  margin-top: 1.5em;
}

/* media querries */
@media screen and (max-width: 480px) {
  .profile {
    font-size: 0.2rem;
    width: 40vw;
  }

  .btn {
    /* font-weight: normal; */
    font-size: small;
    padding: 0;
  }

  input {
    font-size: small;
  }
}

@media screen and (max-width: 720px) {
  .profile {
    font-size: smaller;
    width: 60vw;
  }
}

@media screen and (max-width: 1080px) {
  .profile {
    font-size: smaller;
    width: 60vw;
  }
}
</style>
