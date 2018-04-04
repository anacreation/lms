<template>
    <div class="input-group mb-3">
		<input type="hidden" :name="name_prefix+'[id]'" :value="choice.id">
		<input type="hidden" :name="name_prefix+'[type]'" :value="choice.type">
		<input type="hidden" :name="name_prefix+'[active]'"
               :value="choice.active">
	  <input type="text" class="form-control"
             :name="name_prefix+'[content]'"
             :value="choice.content"
             aria-label="Text input with checkbox" />
	</div>
</template>

<script>
export default {
  name    : "mc-choice",
  props   : ['choice', 'id', 'editable'],
  computed: {
    name_prefix() {
      return `choices[${this.id}]`
    }
  },
  methods : {
    removeChoice() {
      this.$emit("remove-choice", this.choice)
    }
  }

}
</script>

<style scoped>

</style>