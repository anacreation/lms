<template>
    <div class="question">
        <section class="content">
            <span v-text="index"></span><span v-html="question.content"></span>
        </section>
        <section class="choices">
            <input-field
                    :editable="answers===null"
                    :question-id="question.id"
                    :answer="answers"
                    :is-corrected="isCorrected"></input-field>
        </section>
    </div>

</template>

<script>
    import InputField from "./inputField"

    export default {
      name      : "fill-in-the-blank-question",
      props     : ['question', 'answers'],
      components: {
        InputField
      },
      computed  : {
        isCorrected() {
          if (!this.answers) return false
          return this.answers.is_correct
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