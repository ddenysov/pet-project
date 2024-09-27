import type {LabelProps} from "~/app/ui/types/text";

export interface MenuItem
{
    label: string,
    icon: string,
    items: MenuItem[],
}

export interface MenuProps
{
    items: MenuItem[],
}

