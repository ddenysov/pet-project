import {definePreset} from "@primeuix/styled";
import Nora from "@primevue/themes/nora";
import Aura from "@primevue/themes/aura";
import Lara from "@primevue/themes/lara";

export const MainPreset = definePreset(Aura, {
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
    primary: {
      50: '{surface.50}',
      100: '{surface.100}',
      200: '{surface.200}',
      300: '{surface.300}',
      400: '{surface.400}',
      500: '{surface.500}',
      600: '{surface.600}',
      700: '{surface.700}',
      800: '{surface.800}',
      900: '{surface.900}',
      950: '{surface.950}'
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
    menubar: {
      colorScheme: {
        light: {
          border: {
            color: '#ffffff'
          },
          item: {
            color: '{surface.500}',
            fontWeight: 500,
          },
        },
      }
    }
  }
});