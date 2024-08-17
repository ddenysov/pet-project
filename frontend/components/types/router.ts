import type { ButtonProps } from '../types/button'
import type { ColorProps } from '../types/color'

export interface RouterProps {
  to: string,
}

export interface NavButtonProps extends ButtonProps, RouterProps, ColorProps {}