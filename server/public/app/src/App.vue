<template>
    <div id="nav">
        <ul>
            <li>
                <router-link to="/dashboard">Dashboard</router-link>
            </li>
            <li>
                <router-link to="/questionnaire">Questionnaire</router-link>
            </li>
            <li>
                <router-link to="/response">Response</router-link>
            </li>
        </ul>
        <router-view></router-view>
    </div>
</template>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
}

#nav {
  padding: 30px;
}

#nav a {
  font-weight: bold;
  color: #2c3e50;
}

#nav a.router-link-exact-active {
  color: #42b983;
}
</style>
