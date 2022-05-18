<template>
  <div>
    <h1>{{ post.title }}</h1>
    <p>{{ post.description }}</p>
    <div class="form-group mb-2">
        <label for="name">Name</label>
        <input type="text" class="form-control" id="name" placeholder="name" name="username">
    </div>
    <button @click="$fetch">Refresh</button>

  </div>
</template>

<script>
  export default {
    async fetch({ params, $http }) {
      const post = await $http.$get(`https://api.nuxtjs.dev/posts/${params.id}`)
      return { post }
    }
  }
</script>
