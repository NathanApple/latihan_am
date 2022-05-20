<template>
    <div class="">
        <!-- {{fields.file}} -->
        <!-- {{fields.file.fileData}} -->
        <div class="container bg-light card my-3 py-4 px-5">
          <!-- <img :src="require(`@/assets/img/default.png`)" /> -->
          <!-- {{this.steps.length}} -->
          <!-- <div v-scope="{ count: 0 }">
            {{ count }}
            <button @click="count++">inc</button> -->
          <!-- </div> -->
          <div id="" class="card-body px-4 ">
            <div class="card-title text-center mb-2">
              <h3 class="fw-bold">Registration</h3>
              <p>Silahkan mengisi formulir berikut dengan sebenar-benarnya. Bantu kami mengenali anda dengan mudah</p>
            </div>
            <form class="" @submit.prevent="">
              <!-- <div class="d-flex flex-row  align-items-stretch">

                <div
                  v-for="step in totalSteps" :key="step.id"
                  class="flex-fill rounded border border-2 border-primary bg mx-2"
                  :class="{'bg-purple-500 ': step - 1 <= currentStep}" 
                ></div>
              </div> -->
              <div class="mb-4">
                <div class="progress">
                  <div class="progress-bar bg-success" role="progressbar" 
                  :style="{'width': progressWidth}"></div>
                </div>
              </div>
              <!-- :class="{'active':index === formPosition}"  -->
                <div
                  v-for="(fieldKeys, step) in steps" :key="step.name" >
                  
                  <!-- v-for="file_categories of file_categories.file_categcories" :key="file_categories.id" -->
                  <!-- <div>{{fieldKeys}}</div> -->
                  <div v-if="currentStep === step">
                    <div class="row">
                      <template v-for="field in fieldKeys" class="">

                        <div class="col-md-6 mb-2" v-if="fields[field].type === 'select'" :key="'1div-'+field.label">
                          <label for="" class="col-form-label">{{fields[field].label}}</label>
                          <select v-model="fields[field].value" 
                            class="form-select" 
                            :class="{'is-invalid': fields[field].validation.hasError}">
                            <option disabled value="">Select {{fields[field].label}}</option>
                            <option v-for="data of fields[field].data" :key="data.id" :value="data.id" >{{data.name}}</option>
                          </select>
                          <div id="" class="invalid-feedback" v-if="fields[field].validation.hasError">
                            {{fields[field].validation.message}}
                          </div>
                        </div>

                        <div class="col-md-6 mb-2" v-else-if="fields[field].type === 'email'" :key="'2div-'+field.label">
                          <label for="" class="col-form-label">{{fields[field].label}}</label>
                          <input
                            class="input form-control"
                            :class="{'is-invalid': fields[field].validation.hasError}"
                            :type="fields[field].type"
                            v-model="fields[field].value"
                            @change="checkEmailAvailability()"
                          />
                          <div id="" class="invalid-feedback" v-if="fields[field].validation.hasError">
                              {{fields[field].validation.message}}
                          </div>
                        </div>    
                        
                        <template class="" v-else-if="fields[field].type === 'file'">
                          <div class="col-md-6 mb-2" v-for="data of fields[field].data" :key="data.id" :value="data.id">
                              <label for="" class="col-form-label">{{data.name}}</label>
                              <div class="input-group">
                                <input type="file" class="form-control" 
                                :id="data.name" 
                                @change="handleFileUpload($event, data.id);">
                                <span class="input-group-text">
                                  <img :src="(imageServerUrl+data.image_url)" 
                                  class="img-fluid"
                                  style="height: 25px"
                                  />
                                </span>
                              </div>
                          </div>
                        </template>  
                        
                        <div class="col-md-6 mb-2" v-else :key="'4div-'+field.label">
                          <label for="" class="col-form-label">{{fields[field].label}}</label>
                          <input
                            class="input form-control"
                            :type="fields[field].type"
                            :class="{'is-invalid': fields[field].validation.hasError}"
                            v-model="fields[field].value"
                          />
                          <div id="" class="invalid-feedback" v-if="fields[field].validation.hasError">
                            {{fields[field].validation.message}}
                          </div>
                        </div>

                      </template>                  
                    </div>
                  </div>
                </div>
                <div v-if="currentStep === steps.length">
                  <div class="text-center py-3 px-5">
                    <h2 class="fw-bold">Permintaan Akun Berhasil Dikirim</h2>
                    <p class="fs-6 mx-5 mb-3">Permintaan Anda akan kami verifikasi dalam waktu maksimal 2 x 24 jam. 
                      Hasil verifikasi akan kami informasikan melalui email yang anda daftarkan.</p>
                      <button class="btn btn-primary"  @click="goToLogin">
                        Balik Ke Halaman Login
                      </button>
                  </div>
                </div>


                <div class="footer" v-else>
                  <!-- {{isFirstStep}} -->
                  <div class="d-flex flex-row-reverse">
                    <button class="btn btn-primary  mx-2"  @click="nextStep" v-if="currentStep != (steps.length - 1)">
                      Next
                    </button>
                    <button class="btn btn-primary  mx-2"  @click="store" v-if="currentStep == (steps.length - 1)" >
                      Submit
                    </button>
                    <button class="btn btn-secondary mx-2" @click.prevent="previousStep" v-if="currentStep !== 0">
                      Back
                    </button>
                  </div>

                </div>


            </form>
          </div>
        </div>
    </div>

</template>

<script src="https://unpkg.com/petite-vue" defer init></script>
<script>

  export default {

    data() {
      return {
        //state post
        progressWidth: '0%',
        count: 0,
        currentStep: 0,
        imageServerUrl: "",
        steps: [
          ["name", "email","phoneNumber", "university", "password", "passwordConfirmation"],
          ["file"],
          // ["donationAmount"],
        ],
        totalSteps: 0,
        fields: {
          name: {
            label: "Name",
            value: "",
            type: "text",
            validation: {
              hasError: false,
              message: "",
            }
          },
          email: {
            label: "Email",
            value: "",
            type: "email",
            validation: {
              hasError: false,
              message: "",
            }
          },
          phoneNumber: {
            label: "Phone Number",
            value: "",
            type: "text",
            validation: {
              hasError: false,
              message: "",
            }
          },
          university: {
            label: "University",
            value: "",
            type: "select",
            data: {},
            validation: {
              hasError: false,
              message: "",
            }
          },
          password: {
            label: "Password",
            value: "",
            type: "password",
            validation: {
              hasError: false,
              message: "",
            }
          },
          passwordConfirmation: {
            label: "Password Confirmation",
            value: "",
            type: "password",
            validation: {
              hasError: false,
              message: "",
            }
          },
          file: {
            label: "File",
            type: "file",
            value: "",
            data: [],
            fileData: [],
          }
        }
      }
    },

    async fetch() {
      this.totalSteps = this.steps.length;
      this.imageServerUrl = process.env.IMAGE_URL;
      // console.log(this.imageServerUrl);
      this.progressWidth = (((1 / (this.steps.length+1))*100)+5) + "%";

      var universitiesApiUrl = process.env.API_URL+'/university/view';
      this.fields.university.data = await fetch(
        universitiesApiUrl
      ).then(res => res.json());
      this.fields.university.data = this.fields.university.data.universities;

      var filecategoryApiUrl = process.env.API_URL+'/filecategory/view';
      this.fields.file.data = await fetch(
        filecategoryApiUrl
      ).then(res => res.json());
      this.fields.file.data = this.fields.file.data.file_categories;

    },

    methods: {

      previousStep() {
        this.currentStep--;
        this.updateProgressBar();
      },
      nextStep() {
        
        if (!this.checkForm()) {
          this.currentStep++;
          this.updateProgressBar();
        } else {
          // console.log("AAA");
          // this.$toast.error('Please fix highlighted field!');
        }
      },

      goToLogin() {
        this.$router.push('login')   
      },

      validationWriter(validationObject, message){
        
        if (message) {
          validationObject.validation.hasError = true;
          validationObject.validation.message = message;
        } else {
          validationObject.validation.hasError = false;
        }

      },

      checkForm() {
        let hasError = false;
        if (this.currentStep == 0){
          // ["name", "email","phoneNumber", "university", "password", "passwordConfirmation"],
          if (this.fields.name.value == ""){
            this.validationWriter(this.fields.name, "Name is required");
            hasError = true;
          } else {
            this.validationWriter(this.fields.name);
          }

          if (this.fields.email.value == ""){
            this.validationWriter(this.fields.email, "Email is required");
            hasError = true;
          } else if (!this.checkEmailAvailability()) {
            hasError = true;
          } else {
            this.validationWriter(this.fields.name);
          }

          if (this.fields.phoneNumber.value == ""){
            this.validationWriter(this.fields.phoneNumber, "Phone Number is required");
            hasError = true;
          } else {
            this.validationWriter(this.fields.phoneNumber);
          }

          if (this.fields.university.value == ""){
            this.validationWriter(this.fields.university, "University is required");
            hasError = true;
          } else if (!this.checkUniversityAvailability()) {
            hasError = true;
          } else {
            this.validationWriter(this.fields.university);
          }

          if (this.fields.password.value == ""){
            this.validationWriter(this.fields.password, "Password is required");
            hasError = true;
          } else if (this.fields.password.value.length < 6) {
            this.validationWriter(this.fields.password, "Password need at least 6 character");
            hasError = true;
          } else  {
            this.validationWriter(this.fields.password);
          }

          if (this.fields.passwordConfirmation.value == ""){
            this.validationWriter(this.fields.passwordConfirmation, "Password Confirmation is required");
            hasError = true;
          } else if (this.fields.password.value != this.fields.passwordConfirmation.value) {
            this.validationWriter(this.fields.passwordConfirmation, "Password Confirmation is must be the same as Password");
            hasError = true;
          } else  {
            this.validationWriter(this.fields.passwordConfirmation);
          }

          if (hasError){
            this.$toasted.show("Please fix highlighted field", { 
              theme: "toasted-primary", 
              type: "error",
              position: "bottom-right", 
              duration : 2000
            });
          }

        } else if (this.currentStep == 1){
          if (this.fields.file.fileData.length < 1) {
            console.log("Err");
            this.$toasted.show("At least one file is required", { 
              theme: "toasted-primary", 
              type: "error",
              position: "bottom-right", 
              duration : 2000
            });
            hasError = true;
          }
        }

        return hasError;
      },

      async checkUniversityAvailability(){
        return true;
      },

      async checkEmailAvailability(){
        var checkEmailAvailabilityApiUrl = process.env.API_URL+'/user/emailavailability';
        console.log(this.fields.email.value);
        await this.$axios.get(checkEmailAvailabilityApiUrl, {
            params: {
              email:   this.fields.email.value,         
            }
          })
          .then(response => {
            console.log("Data");
            console.log(response.data);
            this.fields.email.validation.hasError = (response.data["status"] === 'false');
            if (this.fields.email.validation.hasError) {
              this.fields.email.validation.message = response.data["message"]["email"][0];
              return false;
            } else {
              console.log("True");
              return true;
            }
          })
      },
      updateProgressBar(){
        this.progressWidth = ((((this.currentStep+1)/ (this.steps.length+1))*100)+5) + "%";
      },

      onFileChange(){
        console.log("File changed");
      },

      handleFileUpload(e, fileCategoryId) {
        console.log(fileCategoryId);
        this.fields.file.fileData[fileCategoryId] = e.target.files[0];
        console.log(this.fields.file.fileData)

      },



      //method "store"
      async store(e) {
        if (this.checkForm()){
          return;
        };
        e.preventDefault()
        var apiUrl = process.env.API_URL+'/auth/register_with_file';
        // console.log(apiUrl);
        //send data ke Rest API
        let userFile = this.fields.file.fileData;

        let bodyFormData = new FormData();
        bodyFormData.append("username", this.fields.name.value);
        bodyFormData.append("email", this.fields.email.value);
        bodyFormData.append("university_id", this.fields.university.value);
        bodyFormData.append("phone", this.fields.phoneNumber.value);
        bodyFormData.append("password", this.fields.password.value);
        bodyFormData.append("password_confirmation", this.fields.passwordConfirmation.value);
        userFile.forEach(function (value, key) {
          bodyFormData.append("user_file["+key+"]", value);
          
        });
        for (var key of bodyFormData.entries()) {
            console.log(key[0] + ', ' + key[1]);
        }

        await this.$axios.post(apiUrl, 
            //data yang dikirim ke server
            bodyFormData
          )
          .then(response => {
            console.log(response.data);
            this.$toasted.show("Success", { 
              theme: "toasted-primary", 
              type: "success",
              position: "bottom-right", 
              duration : 3000
            });
            this.currentStep++;
            this.updateProgressBar();
          })
          .catch(error => {
            console.log(error.response);
            this.$toasted.show("Error: "+error.response.data, { 
              theme: "toasted-primary", 
              type: "error",
              position: "bottom-right", 
              duration : 3000
            });
            // this.validation = error.response.data
          })
      }
    }

  }
</script>

<style>

</style>
