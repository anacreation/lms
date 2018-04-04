<script>
const ckeditorFileBrowserConfig = {
  filebrowserBrowseUrl     : "/laravel-filemanager?type=Files",
  filebrowserUploadUrl     : "/laravel-filemanager/upload?type=Files&_token=",
  filebrowserImageUploadUrl: "/laravel-filemanager/upload?type=Images&_token=",
  filebrowserImageBrowseUrl: "/laravel-filemanager?type=Images",
  filebrowserVideoUploadUrl: "/laravel-filemanager/upload?type=Videos&_token=",
  filebrowserVideoBrowseUrl: "/laravel-filemanager?type=Videos",
  filebrowserFlashBrowseUrl: "/laravel-filemanager?type=Flash",
  filebrowserFlashUploadUrl: "/laravel-filemanager/upload?type=Flash&_token=",
  filebrowserWindowWidth   : 1000,
  filebrowserWindowHeight  : 700
};

const removeCkeditorUploadTab = () => {
  CKEDITOR.on("dialogDefinition", function (ev) {
    // Take the dialog name and its definition from the event
    // data.
    const dialogName       = ev.data.name,
          dialogDefinition = ev.data.definition;
    console.log("dialog name", dialogName);
    // Check if the definition is from the dialog we're
    // interested on (the Link and Image dialog).
    const pluginsRemoveUploadTab = ["image2", "link"];
    if (pluginsRemoveUploadTab.indexOf(dialogName) > -1)
      dialogDefinition.removeContents("Upload");
  });
};

const createHiddenInput = (name, value) => {
  let input = document.createElement("input");
  input.name = name;
  input.value = value;
  input.setAttribute("style", "display:none");
  return input
}

import createTest from "../mixins/createTest"

export default {
  name    : "lesson-edit-form",
  mixins  : [createTest],
  props   : ["lesson", "tests", "oldInputs"],
  data() {
    return {
      tags                   : [],
      seconds                : 1,
      selectedTest           : null,
      completionType         : null,
      ckeditor_summary_config: {
        name          : "new_summary",
        toolbar       : [
          ["Bold", "Italic", "Underline", "Strike", "Subscript", "Superscript"]
        ],
        removePlugins : "elementspath",
        resize_enabled: false,
        height        : 100
      },
      ckeditor_content_config: Object.assign(
        {
          height       : 400,
          removePlugins: "easyimage",
          extraPlugins : "image2,html5video"
        },
        ckeditorFileBrowserConfig
      )
    };
  },
  computed: {
    showSelectTest() {
      return this.completionType == "0"
    },
    showTimer() {
      return this.completionType == "1"
    },
  },

  created() {
    this.initTags()
    this.initCompletionType()
    this.initSelectedTest()
    this.initDuration()
  },
  mounted() {
    Vue.nextTick(() => {
      removeCkeditorUploadTab();
    });
  },
  methods: {
    submit(e) {
      if (this.$refs.hasOwnProperty('prerequisite_form')) {
        const selected_lessons = this.$refs.prerequisite_form.$data.items;
        _.forEach(selected_lessons, lesson => e.target.append(createHiddenInput("prerequisites[]", lesson.id)))
      }
      _.forEach(this.tags, tag => e.target.append(createHiddenInput("tags[]", tag)))
      if (this.completionType == "0") e.target.append(createHiddenInput("test_id", this.selectedTest.id))
      e.target.submit();
    },
    initCompletionType() {
      if (!this.lesson && !this.oldInputs) {
        this.completionType = "2"
      } else if (_.isObject(this.oldInputs) && this.oldInputs.hasOwnProperty('completion_criteria')) {
        this.completionType = this.oldInputs.completion_criteria
      } else if (this.lesson) {
        switch (this.lesson.completion_criteria_type) {
          case "Anacreation\\Lms\\Models\\LessonCompletion\\ClickCompletionCriteria":
            this.completionType = "2"
            break
          case "Anacreation\\Lms\\Models\\LessonCompletion\\TestCompletionCriteria":
            this.completionType = "0"
            break
          case "Anacreation\\Lms\\Models\\LessonCompletion\\TimeCompletionCriteria":
            this.completionType = "1"
            break
          default:
            this.completionType = '2'
        }
      } else {
        this.completionType = "2"
      }
    },
    initSelectedTest() {
      if (this.lesson && this.completionType == "0") {
        this.selectedTest = _.find(this.tests, {id: this.lesson.completion_criteria.test_id})
      }
    },
    initDuration() {
      if (this.lesson && this.completionType == "1") {
        this.seconds = this.lesson.completion_criteria.seconds
      }
    },
    initTags() {
      if (this.lesson) {
        this.tags = _.map(this.lesson.tags, 'name')
      }
    },
    updateCompletionType(value) {
      this.completionType = value
    }
  }
};
</script>