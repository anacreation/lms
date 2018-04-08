<script>
    import Sortable from "sortablejs"
    import deleteTableItem from "../mixins/deleteTableItem"

    export default {
      name   : "order-list",
      mixins : [deleteTableItem],
      data() {
        return {
          list: null
        }
      },
      mounted() {
        const el = this.$refs.sotableList
        this.list = new Sortable(el)
      },
      methods: {
        updateOrder(url) {
          const data = _.map(this.list.el.querySelectorAll('li'), (li, index) => {
            return {
              order: index,
              id   : li.dataset.id
            }
          })
          axios.post(url, data)
               .then(res => window.location.reload())
        },
        removeDom({data}) {
          const id = data.id
          const list = this.$refs.sotableList

          if (list && id) {
            const el = list.querySelector('li[data-id="' + id + '"]')
            if (el) el.remove()
          }
        }
      }

    }
</script>