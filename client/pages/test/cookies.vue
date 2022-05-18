<template>
  <div>
    <div class="form-group mb-2">
        <label for="name">Name</label>
        <input type="text" class="form-control" id="name" placeholder="name" name="username">
    </div>
    <button @click="$fetch">Set Cookies</button>


  </div>
</template>

<script>
    export default {
        // middleware: 'auth',
        async fetch() {
            console.log("Cookies Set");
            this.$auth.$storage.setCookie("Key", "Val");
            console.log(this.$auth.$storage.getCookie("Key"));
        }
    }
</script>
