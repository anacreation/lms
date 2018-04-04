/**
 * Created by Xavier on 23/3/2018.
 */

export default {
  methods: {
    successAlert(msg) {
      this.__alert('success', msg)
    },
    failureAlert(msg) {
      this.__alert('failure', msg)
    },
    __alert(type, msg) {
      alert(msg)
    },
    askConfirmation(msg) {
      return confirm(msg)
    }
  }
}