/**
 * Created by Xavier on 23/3/2018.
 */

import alert from "./alert"

export default {
  mixins : [alert],
  methods: {
    deleteItem(url, successCallback = null, failCallback = null) {
      if (this.askConfirmation("Are you sure you want to delete this item?")) {
        axios.delete(url)
             .then(res => {
               this.successAlert("item deleted!")
               if (successCallback)
                 successCallback(res)
             })
             .catch(error => {
               this.failureAlert("something wrong! Cannot delete!")
               if (!failCallback)
                 failCallback(error)
             })
      }
    }
  }
}