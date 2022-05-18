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
              <input type="submit" class="btn btn-primary" value="Submit">
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
          this.$toast.success('Logged In!');
          this.$router.push('/');
          });
        

        return;
        // console.log(apiUrl);
        //send data ke Rest API
        await this.$axios.post(apiUrl, {
            email:   this.user.email,
            password:   this.user.password,
          })
          .then(response => {
            // console.log(response.data);
            // this.$auth.loggedIn = true;
            this.$auth.setUserToken(response.data.token)
              .then(() => this.$toast.success('User set!'))
            this.$auth.$storage.setCookie("BEARER_TOKEN", response.data.token);
            console.log(this.$auth.$storage.getCookie("BEARER_TOKEN"));
            // redirect('/dashboard')
            //redirect ke route "post"
            // this.$router.push({
            //   name: 'dashboard'
            // })

          })
          .catch(error => {
            //assign validation  
            this.validation = error.response.data;
            this.error = error.response.data.error;
          })
      }
    }

  }
</script>

<style>

</style>
