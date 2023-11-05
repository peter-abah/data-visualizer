import { CartesianScale, Chart, ChartTypeEnum } from "@/types";
import { ChartOptions, Chart as ChartJS } from "chart.js";
import { CARTESAIN_CHART_TYPES } from "./constants";

// Change default colors on theme change
window.addEventListener("theme-change", () => {
    ChartJS.defaults.color = `rgb(${getCSSVariable("--color-text")})`;
    ChartJS.defaults.backgroundColor = `rgb(${getCSSVariable("--color-bg")})`;
    ChartJS.defaults.borderColor = `rgb(${getCSSVariable("--color-border")})`;
});

console.log(`rgba(${getCSSVariable("--color-text").split(" ").join(", ")}, 1)`);

function getCSSVariable(variableName: string) {
    return window
        .getComputedStyle(document.body)
        .getPropertyValue(variableName);
}
export function getGeneralChartOptions(chart: Chart): ChartOptions {
    return { maintainAspectRatio: false };
}

export function getCartesianChartOptions(chart: Chart): ChartOptions {
    const xScale = (chart.config.scaleType as CartesianScale) || "category";

    return {
        scales: {
            x: {
                type: xScale,
                title: {
                    // color: "black",
                    display: true,
                    text: chart.config.categoryColumn,
                    font: {
                        size: 16,
                        weight: "bold",
                    },
                },
            },
        },
    };
}

export function isChartCartesian(chart: Chart) {
    return CARTESAIN_CHART_TYPES.includes(chart.type);
}
