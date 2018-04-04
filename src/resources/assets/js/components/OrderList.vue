<script>
    import Sortable from "sortablejs"

    export default {
      name   : "order-list",
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
        deleteItem(url) {
          console.log(url)
        },
        updateOrder(url) {
          console.log(url)
          console.log(this.list)
          //console.log(this.list.el)
          const data = _.map(this.list.el.querySelectorAll('li'), (li, index) => {
            return {
              order: index,
              id   : li.dataset.id
            }
          })

          axios.post(url, data)
               .then(res => window.location.reload())

          console.log(data)
        },
      }

    }
</script>