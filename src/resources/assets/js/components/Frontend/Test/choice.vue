<template>
    <div class="input-group mb-3"
         :class="{'corrected':isCorrected, 'wrong':input_false}">
  <div class="input-group-prepend">
    <div class="input-group-text">
      <input type="checkbox" :name="name_prefix+'[answer][]'"
             :value="choice.id"
             :disabled="editable === false"
             :checked="checked"
      >
      <input type="hidden" :name="name_prefix+'[id]'"
             :value="questionId"
             :disabled="editable === false"
      >
    </div>
  </div>
  <input class="form-control" disabled :value="choice.content">
</div>
</template>

<script>
export default {
  name    : "mc-choice",
  props   : ['choice', 'questionId', 'editable', 'isCorrected', 'checked'],
  computed: {
    name_prefix() {
      return `answers[${this.questionId}]`;
    },
    input_false() {
      return this.checked && this.isCorrected === false
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