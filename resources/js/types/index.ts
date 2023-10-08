export enum ChartTypeEnum {
    Line = "line_chart",
    Bar = "bar_chart",
    Pie = "pie_chart",
}

export type ChartScale = "time" | "linear" | "category" | "logarithmic";

export type ChartConfig = {
    dataColumns: string[];
    categoryColumn: string;
    scaleType: ChartScale | null;
    dateFormat: string | null;
};

export type Chart = {
    name: string;
    data: Record<string, string>[];
    type: ChartTypeEnum;
    config: ChartConfig;
};
