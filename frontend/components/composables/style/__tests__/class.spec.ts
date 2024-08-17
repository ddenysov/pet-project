import { describe, it, expect } from 'vitest'
import { useBooleanClass, useClass } from '../class'

describe('useClass', () => {
  console.log(useClass('flex', '1'));
  it('flex', () => {
    expect(useClass('flex', '1')).toEqual({ 'flex-1': true });
    expect(useClass('flex-grow', '1')).toEqual({ 'flex-grow-1': true });
    expect(useClass('flex', 'none')).toEqual({ 'flex-none': true });
    expect(useClass('flex', '')).toEqual({ 'flex': true });
    expect(useClass('flex', undefined)).toEqual({});
  });

  it('flex:xs', () => {
    expect(useClass('flex', { sm: '1' })).toEqual([{ 'sm:flex-1': true }]);
    expect(useClass('flex-grow', { lg: '1' })).toEqual([{ 'lg:flex-grow-1': true }]);
    expect(useClass('flex', { sm: '1', lg: 'none', xl: 'auto' })).toEqual([
      { 'sm:flex-1': true },
      { 'lg:flex-none': true },
      { 'xl:flex-auto': true },
    ]);
  });
});

describe('useBooleanClass', () => {
  it('flex', () => {
    expect(useBooleanClass('grid', true)).toEqual({ grid: true });
    expect(useBooleanClass('grid', false)).toEqual({ grid: false });
  });

});