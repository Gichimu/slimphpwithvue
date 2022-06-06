<template>
  <!-- <nav>
    
  </nav> -->
  <nav class="navbar navbar-light bg-light">
    <div class="container-fluid nav-inner">
      <div><a class="navbar-brand">Easy Auth</a></div>
      <div class="nav-links">
        <router-link to="/">Sign in</router-link> |
        <router-link to="/Register">Register</router-link>
      </div>
    </div>
  </nav>
  <router-view />
</template>

<style>
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
}

nav {
  padding: 30px;
}

.nav-inner {
  margin: 0 20%;
}

nav a {
  font-weight: bold;
  color: black;
  text-decoration: none;
}

nav a.router-link-exact-active {
  color: #42b983;
}

@media screen and (max-width: 480px) {
  nav {
    font-size: smaller;
  }
  .nav-inner {
    display: flex;
    flex-direction: row;
    justify-content: space-evenly;
    margin: 0 5%;
  }
}

@media screen and (max-width: 720px) {
  nav {
    font-size: smaller;
  }
  .nav-inner {
    display: flex;
    flex-direction: row;
    justify-content: space-evenly;
    /* margin: 0 5%; */
  }
}
</style>
