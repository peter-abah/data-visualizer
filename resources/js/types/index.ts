export enum ChartTypeEnum {
    Line = "line_chart",
    Bar = "bar_chart",
    Pie = "pie_chart",
}

export type Chart = {
    name: string;
    data: Record<string, string>[];
    type: ChartTypeEnum;
    config: {
        dataColumns: string[];
        categoryColumn: string;
    };
};
