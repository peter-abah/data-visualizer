import { Chart as ChartType } from "@/types";
import { useToJpeg } from "@hugocxl/react-to-image";
import { chartTypeToComponent } from "@/features/charts/components";
import ChartToExport from "@/features/charts/components/chart_to_export";

type Props = {
    chart: ChartType;
    linkToProject: string;
    linkToSettings: string;
};

export default function Chart({ chart, linkToProject, linkToSettings }: Props) {
    const ChartComponent = chartTypeToComponent[chart.type];
    const [_, convertToImage, ref] = useToJpeg<HTMLDivElement>({
        onSuccess: (data) => {
            const link = document.createElement("a");
            link.download = "chart.jpeg";
            link.href = data;
            link.click();
        },
    });

    return (
        <div className="overflow-x-hidden">
            <header className="mb-8 flex flex-wrap justify-between gap-4 items-start">
                <div>
                    <h1 className="font-bold tracking-tight text-3xl text-gray-800">
                        {chart.name}
                    </h1>
                    <p>
                        Project:{" "}
                        <a
                            className="underline hover:no-underline"
                            href={linkToProject}
                        >
                            {chart.project?.name}
                        </a>
                    </p>
                </div>

                <div className="flex gap-2">
                    <button
                        className="ml-auto px-4 py-2 rounded-md text-sm font-medium border whitespace-nowrap hover:bg-slate-50"
                        onClick={convertToImage}
                    >
                        Export chart
                    </button>
                    <a
                        href={linkToSettings}
                        className="px-4 py-2 rounded-md text-sm font-medium border hover:bg-slate-50"
                    >
                        Settings
                    </a>
                </div>
            </header>

            <div className="relative sm:mx-6 lg:mx-auto max-w-5xl min-h-[25rem] max-h-screen [&>*]:mx-auto">
                <ChartComponent chart={chart} />
            </div>

            <ChartToExport chart={chart} ref={ref} />
        </div>
    );
}
