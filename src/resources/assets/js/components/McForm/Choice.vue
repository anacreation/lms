<template>
    <div class="input-group mb-3">
		<div class="input-group-prepend">
			<button class="btn btn-danger"
                    type="button" @click="removeChoice">X</button>
		  </div>
		<input type="hidden" :name="name_prefix+'[id]'" :value="choice.id">
		<input type="hidden" :name="name_prefix+'[type]'" :value="choice.type">
		<input type="hidden" :name="name_prefix+'[active]'"
               :value="choice.active">
	  <input type="text" class="form-control"
             :name="name_prefix+'[content]'"
             :value="choice.content"
             aria-label="Text input with checkbox" />
		<div class="input-group-append">
		  <div class="btn-group btn-group-toggle"
               data-toggle="buttons">
			  <label class="btn btn-outline-success"
                     :class="{'active':choice.is_corrected}">
				<input type="radio"
                       :name="name_prefix+'[is_corrected]'"
                       value="1"
                       autocomplete="off"
                       :checked="choice.is_corrected"
                > True
			  </label>
			  <label class="btn btn-outline-warning"
                     :class="{'active':!choice.is_corrected}">
				<input type="radio"
                       :name="name_prefix+'[is_corrected]'"
                       value="0"
                       autocomplete="off"
                       :checked="!choice.is_corrected"
                > False
			  </label>
		  </div>
	  </div>
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