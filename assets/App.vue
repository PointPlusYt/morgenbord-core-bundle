<script>
import { defineAsyncComponent } from 'vue';

export default {
  data() {
    return {
      showingForm: null,
    }
  },
  methods: {
    showForm(evt) {
      if (this.showingForm == evt.target.dataset.shortname) {
        this.showingForm = null;
      } else {
        this.showingForm = evt.target.dataset.shortname;
      }
    },
    toggleMenu(evt) {
      let selectedMenu = evt.target.nextElementSibling == undefined ? evt.target.parentElement.nextElementSibling : evt.target.nextElementSibling;
      document.querySelectorAll('.widget-menu').forEach(menuElmt => {
        if (menuElmt != selectedMenu) {
          menuElmt.classList.add('hidden');
        }
      });
      selectedMenu.classList.toggle('hidden');
    }
  },
  computed: (() => {
    const componentFiles = require.context('../public/bundles', true, /\.vue$/);
    const components = {};
    for (const file of componentFiles.keys()) {
        const name = file.replace(/^\.\//, '').replace(/\.\w+$/, '').replace(/^.+\//, '');
        components[name] = () => defineAsyncComponent(() => import(`../public/bundles/${file.replace(/^\.\//, '')}`));
    }
    return components;
  })(),
  compilerOptions: {
    delimiters: ["${", "}$"]
  },
}
</script>
