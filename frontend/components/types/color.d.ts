export type Color = 'primary' | 'secondary' | 'success' | 'info' | 'warning' | 'help' ;
export type Tint = 50 | 100 | 200 | 300 | 400 | 500 | 600 | 700 | 800 | 900;
export interface ColorProps {
  color?: Color,
  tint?: Tint,
}
