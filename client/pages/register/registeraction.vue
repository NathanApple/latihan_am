<script>
export default {
    async asyncData(context) {
    // some way how to get the value of POST param "id"
    const id = context.req.body.name;
    return { id }
}
}
</script>