<template>
    <div>
        <div class="container">
            <h1>Title</h1>

            <form @submit="store">
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
