import {definePreset} from "@primeuix/styled";
import Nora from "@primevue/themes/nora";
import Aura from "@primevue/themes/aura";

export const MainPreset = definePreset(Nora, {
  semantic: {

  },
  components: {
    toolbar: {
      colorScheme: {
        light: {
          root: {
            background: '{primary.color}',
            color: '{surface.50}'
          },
        },
      }
    },
    menubar: {
      colorScheme: {
        light: {
          root: {
            background: '{primary.color}',
            color: '{surface.50}'
          },
          item: {
            color: '{surface.50}',
            focus: {
              background: '{primary.hover.color}',
            }
          },
        },
      }
    }
  }
});