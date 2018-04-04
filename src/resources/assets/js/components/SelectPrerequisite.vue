<template>
     <div>
        <label>Prerequisites</label>
        <vue-select name="prerequisites[]"
                    label="title"
                    multiple
                    v-model="items"
                    :options="options">
         </vue-select>
    </div>
</template>

<script>
    import VueSelect from "vue-select"

    export default {
      name      : "select-prerequisites",
      props     : {
        options : {
          type    : Array,
          required: true
        },
        selected: {
          type    : Array,
          required: true
        },
        errors  : {
          type: Array,
          default() {return []}
        }
      },
      data() {
        return {
          items: Object.assign([], this.selected)
        }
      },
      components: {
        VueSelect
      }
    }
</script>

<style scoped>

</style>