import {definePreset} from "@primeuix/styled";
import Nora from "@primevue/themes/nora";
import Aura from "@primevue/themes/aura";

export const MainPreset = definePreset(Nora, {
  semantic: {
    accent: {
      50: '{amber.50}',
      100: '{amber.100}',
      200: '{amber.200}',
      300: '{amber.300}',
      400: '{amber.400}',
      500: '{amber.500}',
      600: '{amber.600}',
      700: '{amber.700}',
      800: '{amber.800}',
      900: '{amber.900}',
      950: '{amber.950}'
    },
    colorScheme: {
      accent: {
        color: '{accent.500}',
        contrastColor: '#ffffff',
        hoverColor: '{accent.600}',
        activeColor: '{accent.700}'
      },
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