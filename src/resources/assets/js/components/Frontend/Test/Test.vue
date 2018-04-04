<template>
    <div>
        <h2 v-text="test.title"></h2>
        <form ref="answer-form" :action="url" method="POST"
              @submit.prevent="submit">
            <input type="hidden" name="_token" :value="token">
            <component :is="getComponent(question)"
                       v-for="question in test.questions"
                       :question="question"
                       :answers="submitted_answers(question)"
                       :key="question.id"></component>

            <button class="btn btn-success" type="submit"
                    v-if="!attempt">Submit</button>
            <a class="btn btn-primary text-light" v-else @click.prevent="back">Back</a>
        </form>
    </div>
</template>

<script>
    import McQuestion from "./McQuestion"
    import FillInTheBlank from "./FillInTheBlankQuestion"
    import alert from "../../../mixins/alert"

    export default {
      name      : "test",
      props     : ['test', 'url', 'successRedirectUrl', 'failRedirectUrl', 'attempt'],
      mixins    : [alert],
      components: {
        McQuestion,
        FillInTheBlank
      },
      computed  : {
        token() {
          return document.head.querySelector('meta[name="csrf-token"]').content;
        },
      },
      methods   : {
        getComponent(question) {
          switch (question.question_type_id) {
            case 1:
              return "McQuestion"
            case 2:
              return "FillInTheBlank"
            default:
              return null
          }
        },
        back() {
          window.location.href = this.successRedirectUrl
        },
        submit() {
          axios.post(this.url, new FormData(this.$refs["answer-form"]))
               .then(({data}) => {
                 if (data.passed) {
                   this.successAlert(data.message)
                   window.location.href = this.successRedirectUrl
                 } else {
                   this.failureAlert(data.message)
                   window.location.href = this.failRedirectUrl
                 }
               })
        },
        submitted_answers(question) {
          if (!this.attempt) return null
          return _.find(this.attempt.attempt, {id: question.id})
        }
      }
    }
</script>