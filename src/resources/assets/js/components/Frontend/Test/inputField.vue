<template>
    <div>
        <div class="input-group mb-3"
             :class="{'corrected':isCorrected, 'wrong':input_false}">
            <input type="hidden" :value="questionId"
                   :name="name_prefix+'[id]'" />
            <input class="form-control" :disabled="!editable"
                   :value="inputValue"
                   :name="name_prefix+'[answer]'" />
        </div>
        <div class="answer" v-if="input_false">
           <span>Correct Answer: {{ correct_answer }}</span>
        </div>
    </div>

</template>

<script>
export default {
  name    : "input-field",
  props   : ['questionId', 'editable', 'isCorrected', 'answer'],
  computed: {
    inputValue() {
      if (this.answer) {
        return this.answer.input[0]
      }
      return null
    },
    name_prefix() {
      return `answers[${this.questionId}]`;
    },
    input_false() {
      return !!this.answer && this.isCorrected === false
    },
    correct_answer() {
      if (this.answer) {
        return this.answer.correct_answer[0]
      }
      return null
    }
  }
}
</script>

<style scoped>
  .form-control:disabled {
      background-color: white
  }

  .input-group.corrected {
      box-shadow: 0 0 15px #18b800;;
  }

  .input-group.wrong {
      box-shadow: 0 0 15px #c50011;;
  }

</style>