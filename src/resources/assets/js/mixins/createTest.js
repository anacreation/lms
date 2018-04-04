/**
 * Created by Xavier on 23/3/2018.
 */

export default {
  data() {
    return {
      testForm      : {
        'title'       : "",
        'passing_rate': null,
        'is_active'   : true,
      },
      testFormErrors: {}
    }
  },
  methods: {
    submitToCreateTest() {
      if (this.validateTestForm()) {
        axios.post("/admin/tests", this.testForm)
             .then(this.successCallback)
      }
    },
    validateTestForm() {
      const msg = "This is a required filed"

      _.forEach(Object.keys(this.testForm), fieldName => {
        if (this.testForm[fieldName].length === 0) {
          if (this.testFormErrors.hasOwnProperty(fieldName)) {
            this.testFormErrors[fieldName].push(msg)
          } else {
            this.testFormErrors[fieldName] = [msg]
          }
        } else {
          if (this.testFormErrors.hasOwnProperty(fieldName)) {
            delete this.testFormErrors[fieldName]
          }
        }
      })

      return Object.keys(this.testFormErrors).length === 0

    },
    successCallback(res) {
      console.log(res)
    }
  }
}