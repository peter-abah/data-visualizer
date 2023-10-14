export enum ChartTypeEnum {
    Line = "line_chart",
    Bar = "bar_chart",
    Pie = "pie_chart",
    Radar = "radar_chart",
}

export type ChartType = `${ChartTypeEnum}`;

export type CartesianScale = "time" | "linear" | "category" | "logarithmic";
export type ChartScale = CartesianScale | "radialLinear";

export type ChartConfig = {
    dataColumns: string[];
    categoryColumn: string;
    scaleType: ChartScale | null;
    dateFormat: string | null;
    sectorLimit: string;
};

export type Project = {
    name: string;
    id: string;
}

export type Chart = {
    name: string;
    data: Record<string, string>[];
    type: ChartTypeEnum;
    config: ChartConfig;
    project: Project;
};
