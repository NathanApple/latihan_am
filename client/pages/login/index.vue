<template>
    <div>
        <div class="container">

            <h1>Login</h1>

            <form @submit="login">
                <div class="form-group mb-2">
                    <label for="email">Email</label>
                    <input v-model="user.email" type="email" class="form-control" id="email" placeholder="email" name="email">
                </div>
                <div class="form-group mb-2">
                    <label for="password">Password</label>
                    <input v-model="user.password" type="password" class="form-control" id="password" placeholder="password" name="password">
                </div>
                <div class="alert alert-danger mb-2" 
                  :class="{ 'd-none' : error === ''}"
                role="alert">
                  {{ error }}
                </div>
                <div class="d-flex flex-row-reverse">
                  <input type="submit" class="btn btn-primary" value="Login">
                  <button class="btn btn-secondary mx-2" @click="goToRegister" >
                    Register
                  </button>
                </div>
              
            </form>
        </div>
    </div>

</template>

<script>

  export default {
    middleware: 'auth',
    data() {
      return {
        //state post
        user: {
          email: '',
          password: '',
        },
        error: '',
        //state validation
        validation: []
      }
    },

    async fetch() {


    },

    methods: {
      goToRegister(e){
        e.preventDefault();
        this.$router.push('/register');
      },

      onFileChange(){
        console.log("File changed");
      },

      //method "login"
      async login(e) {
        e.preventDefault()
        var apiUrl = process.env.API_URL+'/auth/login';
        console.log("Start");

        await this.$auth.loginWith('laravelJWT', {
          data: {
            email: this.user.email,
            password: this.user.password
          }
        }).then(() => {
            this.$toasted.show("Logged In!", { 
              theme: "toasted-primary", 
              type: "success",
              position: "bottom-right", 
              duration : 3000
            });
          this.$router.push('/');
          })
          .catch(error => {
            console.log(error.response);
            this.$toasted.show("Error: "+error.response.data.error, { 
              theme: "toasted-primary", 
              type: "error",
              position: "bottom-right", 
              duration : 3000
            });
          })
          ;
        

        return;
      }
    }

  }
</script>

<style>

</style>
