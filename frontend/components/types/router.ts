import type { ButtonProps } from '@/shared/ui-kit/types/button'
import type { ColorProps } from '@/shared/ui-kit/types/color'

export interface RouterProps {
  to: string,
}

export interface NavButtonProps extends ButtonProps, RouterProps, ColorProps {}