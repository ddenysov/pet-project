export interface Loading {
    [data: string]: boolean;
}

export interface Input {
    [data: string]: {
        start: number,
        length: number,
        sortColumn: string,
        sortOrder: string,
    }
}

export interface Rows {
    [data: string]: any
}

export type DataSetState = {
    rows: Rows,
    loading: Loading,
    input: Input,
}