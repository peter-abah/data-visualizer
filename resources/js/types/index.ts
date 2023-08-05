export enum ChartType {
    Line = "line_chart",
}

export type Chart = {
    name: string;
    data: Record<string, string>[];
    type: ChartType;
    config: any;
};
