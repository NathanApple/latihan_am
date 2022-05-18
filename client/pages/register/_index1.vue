<template>
    <div>
        <div class="container">

          <div id="multi-step-form">
            <form class="p-10">
              <div :for="(fieldKeys, step) in steps">
                <div>{{step}}</div>
              </div>
            </form>
          </div>


            <h1>Title</h1>

            <form @submit="store">
                <div class="form-group mb-2">
                    <label for="username">username</label>
                    <input v-model="user.username" type="text" class="form-control" id="username" placeholder="username" name="username">
                </div>
                <div class="form-group mb-2">
                    <label for="email">Email</label>
                    <input v-model="user.email" type="email" class="form-control" id="email" placeholder="email" name="email">
                </div>
                <div class="form-group mb-2">
                    <label for="phonenumber">Phone Number</label>
                    <input v-model="user.phone" type="text" class="form-control" id="phonenumber" placeholder="phonenumber" name="phone">
                </div>
                <div class="form-group mb-2">
                    <label for="university">University</label>
                    <select v-model="user.university_id" class="form-select" aria-label="Default select example">
                      <option disabled value="">Select University</option>
                      <option v-for="universities of universities.universities" :key="universities.id" :value="universities.id" >{{universities.name}}</option>
                    </select>
                </div>
                <div class="form-group mb-2">
                    <label for="password">Password</label>
                    <input v-model="user.password" type="password" class="form-control" id="password" placeholder="password" name="password">
                </div>
                <div class="form-group mb-2">
                    <label for="confirmation">Password Confirmation</label>
                    <input v-model="user.password_confirmation" type="password" class="form-control" id="confirmation" placeholder="confirmation" name="password_confirmation">
                </div>

                <h3 class="row">File</h3>
                <div class="form-group mb-2" v-for="file_categories of file_categories.file_categories" :key="file_categories.id">
                    <label :for="file_categories.name">{{file_categories.name}}</label>
                    <input  @change="onFileChange" type="file" class="form-control" :id="file_categories.name">
                </div>

              <input type="submit" class="btn btn-primary" value="Submit">
            </form>
        </div>
    </div>

</template>

<script>

  export default {

    data() {
      return {
        //state post
        currentStep: 0,
        user: {
          username: '',
          email: '',
          university_id: '',
        },
        universities: [],
        file_categories: [],
        file: null,
        //state validation
        validation: []
      }
    },

    async fetch() {
      var universitiesApiUrl = process.env.API_URL+'/university/view';
      this.universities = await fetch(
        universitiesApiUrl
      ).then(res => res.json())
      var filecategoryApiUrl = process.env.API_URL+'/filecategory/view';
      this.file_categories = await fetch(
        filecategoryApiUrl
      ).then(res => res.json())

    },

    methods: {
      
      onFileChange(){
        console.log("File changed");
      },

      //method "store"
      async store(e) {
        e.preventDefault()
        var apiUrl = process.env.API_URL+'/auth/register';
        // console.log(apiUrl);
        //send data ke Rest API

        await this.$axios.post(apiUrl, {

            //data yang dikirim ke server
            username:   this.user.username,
            email:   this.user.email,
            university_id:   this.user.university_id,
            phone:   this.user.phone,
            password:   this.user.password,
            password_confirmation:   this.user.password_confirmation,            
          })
          .then(response => {
            console.log(response.data);
            // await this.$auth.loginWith('laravelJWT', {
            //   data: {
            //     email: 'Nathan8@gmail.com',
            //     password: '123456'
            //   }
            // }).then(() => {
            //   this.$toast.success('Logged In!');
            //   this.$router.push('/');
            //   });

            //redirect ke route "post"
            // this.$router.push({
            //   name: 'post'
            // })

          })
          .catch(error => {
            //assign validation  
            this.validation = error.response.data
          })
      }
    }

  }
</script>

<style>

</style>
