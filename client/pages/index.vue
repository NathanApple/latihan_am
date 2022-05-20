<template>
  <div>

    <div class="container">
      <div v-if="this.$auth.loggedIn">
        Hi {{ this.$auth.user.user.username }}
        <button class="btn btn-secondary" @click="logout">Logout</button>
      </div>
      <div v-else>
        <div class="div">
          Please Wait...
        </div>
        <div class="">
          <button class="btn btn-primary" @click="goToLogin">Login</button>
        </div> 
      </div>
    </div>

  </div>
</template>

<script>
  export default {
    name: 'IndexPage',
    data() {
        return {
          validation: []
        }
      },
    fetch(){
      if(!this.$auth.loggedIn){
        this.$router.push('/login');
      }
      
    },
    methods:{
      logout (e){
        console.log("Hi")
        this.$auth.logout('laravelJWT')
            .then(() => {
            this.$toasted.show("Logout Successfull", { 
              theme: "toasted-primary", 
              type: "success",
              position: "bottom-right", 
              duration : 3000
            });
            this.$router.push('/login');

          })
          .catch(error => {
            console.log(error);
            this.$toasted.show("Error", { 
              theme: "toasted-primary", 
              type: "error",
              position: "bottom-right", 
              duration : 3000
            });
            // this.validation = error.response.data
          });
      },
      async goToLogin (e){
        this.$router.push('/login');
        e.preventDefault();
      },
      goToRegister(e){
        e.preventDefault();
        this.$router.push('/register');
      },
    },
  }
</script>

<style>

</style>
