<script setup>
import { ref, defineAsyncComponent } from 'vue'

const showingForm = ref(false)

const showForm = (evt) => {
  if (showingForm.value == evt.target.dataset.shortname) {
    showingForm.value = null
  } else {
    showingForm.value = evt.target.dataset.shortname
  }
}

// Load components dynamically
const componentFiles = require.context('../../', true, /^.*\.vue$/)
const components = {}
for (const file of componentFiles.keys()) {
  const name = file.replace(/^\.\//, '').replace(/\.\w+$/, '').replace(/^.+\//, '')
  components[name] = () => defineAsyncComponent(() => import(`../../${file.replace(/^\.\//, '')}`))
}

// return {
//   showingForm,
//   showForm,
//   ...components
// }
// },

const options = {
  compilerOptions: {
    delimiters: ["${", "}$"]
  }
}

</script>

<template>
  <widget-preference-menu />
</template>