import { Chart as ChartType } from "@/types";
import { chartTypeToComponent } from "@/features/charts/components";
import { ForwardedRef, forwardRef } from "react";

type Props = {
    chart: ChartType;
};

type TChartToExport = ReturnType<typeof forwardRef<HTMLDivElement, Props>> & {
    selector?: string;
};

const ChartToExport: TChartToExport = forwardRef(
    ({ chart }: Props, ref: ForwardedRef<HTMLDivElement>) => {
        const ChartComponent = chartTypeToComponent[chart.type];

        return (
            <div className="fixed left-[9999px]">
                <div
                    className="bg-white p-8 w-[1024px] mx-auto print:py-16"
                    id="chart-to-export"
                    ref={ref}
                >
                    <header className="mb-4">
                        <h1 className="text-center text-xl font-bold">
                            {chart.name}
                        </h1>
                    </header>

                    <div className="relative sm:px-6 lg:mx-auto max-w-5xl min-h-[25rem] max-h-screen [&>*]:mx-auto">
                        <ChartComponent chart={chart} />
                    </div>
                </div>
            </div>
        );
    }
);

ChartToExport.selector = "#chart-to-export";

export default ChartToExport;
