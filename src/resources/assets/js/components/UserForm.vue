<script>
    function createInputEl(name, value) {
      const input = document.createElement("input")
      input.type = "hidden"
      input.name = name
      input.value = value
      return input
    }

    export default {
      name   : "user-form",
      props  : ['user'],
      data() {
        return {
          "role_ids"     : [],
          "supervisor_id": null
        }
      },
      mounted() {
        this.initUserRoleIds()
        this.initUserSupervisorId()
      },
      methods: {
        updateSupervisorId(user) {
          document.getElementById('supervisor_id').value = user ? user.id : null
        },
        submit(e) {
          this.createRoleIdInputs(e.target)
          this.createSupervisorIdInput(e.target)
          e.target.submit()
        },
        initUserRoleIds() {
          if (this.user && this.user.roles) {
            this.role_ids = _.map(this.user.roles, role => Object.assign({}, {
              id   : role.id,
              label: role.label,
            }))
          }
        },
        initUserSupervisorId() {
          this.supervisor_id = (this.user && this.user.supervisor) ? {
            id  : this.user.supervisor.id,
            name: this.user.supervisor.name
          } : null
        },
        createRoleIdInputs(form) {
          const name = "role_ids[]"
          _.chain(this.role_ids)
           .map(role => createInputEl(name, role.id))
           .forEach(input => form.append(input))
           .value()
        },
        createSupervisorIdInput(form) {
          if (this.supervisor_id)
            form.append(createInputEl("supervisor_id", this.supervisor_id.id))
        }
      }
    }
</script>
