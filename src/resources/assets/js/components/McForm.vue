<script>

    import McChoice from "./McForm/Choice"
    import alert from "../mixins/alert"

    class Choice {
      constructor(data = null) {
        this.id = data === null ? 0 : data.hasOwnProperty('id') ? parseInt(data.id) : null
        this.content = data === null ? null : data.hasOwnProperty('content') ? data.content : null
        this.is_corrected = false
        this.type = data ? "_db" : "new"
        this.active = 1
      }

      setAnswer(answer) {
        this.is_corrected = !answer ? false : answer.content.map(ans => parseInt(ans)).indexOf(this.id) > -1
      }

      setInActive() {
        this.active = 0
      }
    }

    export default {
      name      : "mc-form",
      props     : ['question', 'redirectUrl'],
      mixins    : [alert],
      components: {McChoice},
      data() {
        return {
          refresh               : false,
          defaultNumberOfChoices: 3,
          choices               : []
        }
      },
      created() {
        if (!this.question) {
          for (let i = 0; i < this.defaultNumberOfChoices; i++) {
            this.addChoice()
          }
        }
      },
      mounted() {
        if (this.question) this.setChoices()
      },
      methods   : {
        submit(e) {
          const formData = new FormData(e.target),
                content  = CKEDITOR.instances.content.getData()
          if (content.length) {
            formData.append('content', content)
          }
          formData.append('prefix', null)
          formData.append('page_number', 1)
          axios.post(e.target.action, formData).then(() => {
            this.successAlert("Question updated!")
            if (this.refresh === true) {
              window.location.reload()
            } else {
              window.location.href = this.redirectUrl
            }
          })
        },
        addChoice(choice = null) {
          this.choices.push(new Choice(choice))
        },
        removeChoice(choice) {
          if (this.choices.length > 1) {
            if (choice.type === 'new') {
              this.choices = _.filter(this.choices, c => c !== choice)
            } else {
              choice.setInActive()
            }
          }
        },
        setChoices() {
          _.forEach(this.question.choices, choice => this.addChoice(choice));
          _.forEach(this.choices, choice => choice.setAnswer(this.question.answer))
        }
      }
    }
</script>
