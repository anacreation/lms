<template>
    <div class="timer">
        <h3 v-text="showTime"></h3>
    </div>
</template>

<script>
export default {
  name    : "timer",
  props   : ["seconds", "completedUrl"],
  data() {
    return {
      time   : null,
      counter: null
    }
  },
  computed: {
    showTime() {
      if (this.time > 0) {
        const _sec        = this.time % (60),
              _total_mins = parseInt(this.time / (60)),
              _show_mins  = _total_mins % (60),
              _show_hour  = parseInt(_total_mins / (60))

        return _show_hour + ":" + _show_mins + ":" + _sec
      }
      return "Completed!"
    }
  },
  created() {
    this.time = parseInt(this.seconds)
  },
  mounted() {
    this.startCountDown()
  },
  methods : {
    startCountDown() {
      this.counter = setInterval(() => {
        if (this.time > 0) {
          this.time--
        } else {
          this.triggerLessonCompleted()
          clearInterval(this.counter)
        }
      }, 1000)
    },
    triggerLessonCompleted() {
      axios.get(this.completedUrl)
           .then(({data}) => alert(data.message))
      console.log('Lesson Completed')
    }
  }

}
</script>

<style scoped>
    .timer {
        position: fixed;
        right: 15px;
        bottom: 15px
    }
</style>Test