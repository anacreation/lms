<script>
    import deleteTableItem from "../mixins/deleteTableItem"

    export default {
      name   : "table-actions",
      mixins : [deleteTableItem],
      methods: {
        removeDom(res) {
          this.$refs.table.querySelector(`tr[data-id="${ res.data.id}"]`).remove()
        }
      }
    }
</script>