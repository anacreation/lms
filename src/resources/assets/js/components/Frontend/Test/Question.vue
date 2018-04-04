<template>
    <div class="question">
        <section class="content" v-html="question.content"></section>
        <section class="choices">
            <choice v-for="choice in question.choices" :key="choice.id"
                    :editable="answers===null"
                    :question-id="question.id"
                    :is-corrected="isCorrected(choice)"
                    :checked="isChecked(choice)"
                    :choice="choice"></choice>
        </section>
    </div>

</template>

<script>
    import Choice from "./Choice"

    export default {
      name      : "test-question",
      props     : ['question', 'answers'],
      components: {
        Choice
      },
      methods   : {
        getAnswer(choice) {

        },
        isCorrected(choice) {
          if (!this.answers) return false
          return this.answers.correct_answer.map(id => parseInt(id)).indexOf(choice.id) > -1
        },
        isChecked(choice) {
          if (!this.answers) return false
          return this.answers.input.map(id => parseInt(id)).indexOf(choice.id) > -1
        }
      }
    }
</script>

<style scoped>
    .question {
        margin-bottom: 15px;
        padding-bottom: 15px;
        border-bottom: solid #d3d3d3 1px;
    }
</style>