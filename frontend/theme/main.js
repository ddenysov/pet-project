import {definePreset} from "@primeuix/styled";
import Nora from "@primevue/themes/nora";

export const MainPreset = definePreset(Nora, {
  semantic: {
    primary: {
      50: '{emerald.50}',
      100: '{emerald.100}',
      200: '{emerald.200}',
      300: '{emerald.300}',
      400: '{emerald.400}',
      500: '{emerald.500}',
      600: '{emerald.600}',
      700: '{emerald.700}',
      800: '{emerald.800}',
      900: '{emerald.900}',
      950: '{emerald.950}'
    },
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