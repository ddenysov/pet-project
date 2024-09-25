export type Value<T> = {
    [value: string]: T;
}

export interface Values<T> {
    [form: string]: Value<T>;
}

export interface Loading {
    [form: string]: boolean;
}

export interface Errors extends Values<string> {
}

export interface Validation extends Values<{}> {
}

export type FormState = {
    values: Values<string>,
    validation: Validation,
    errors: Errors,
    loading: Loading,
}