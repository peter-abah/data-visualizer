import { useRef } from "react";
import { Chart as ChartType } from "@/types";
import { useToJpeg } from "@hugocxl/react-to-image";
import { useReactToPrint } from "react-to-print";
import { chartTypeToComponent } from "@/features/charts/components";
import ChartToExport from "@/features/charts/components/chart_to_export";
import Dropdown, { DropdownButton } from "@/components/dropdown";

type Props = {
    chart: ChartType;
    linkToProject: string;
    linkToSettings: string;
};

export default function Chart({ chart, linkToProject, linkToSettings }: Props) {
    const ref = useRef<HTMLDivElement>(null);
    const [_, convertToImage] = useToJpeg<HTMLDivElement>({
        selector: ChartToExport.selector,
        onSuccess: (data) => {
            const link = document.createElement("a");
            link.download = "chart.jpeg";
            link.href = data;
            link.click();
        },
    });

    const handlePrint = useReactToPrint({
        content: () => ref.current,
    });

    const ChartComponent = chartTypeToComponent[chart.type];

    return (
        <div className="overflow-x-hidden">
            <header className="mb-8 flex flex-wrap justify-between gap-4 items-start">
                <div>
                    <h1 className="font-bold tracking-tight text-3xl">
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
                    <Dropdown
                        trigger={
                            <button className="ml-auto px-4 py-2 rounded-md text-sm font-medium border whitespace-nowrap hover:bg-bg-hover">
                                Export chart
                            </button>
                        }
                    >
                        <DropdownButton onClick={handlePrint}>
                            To pdf
                        </DropdownButton>
                        <DropdownButton onClick={convertToImage}>
                            To image
                        </DropdownButton>
                    </Dropdown>

                    <a
                        href={linkToSettings}
                        className="px-4 py-2 rounded-md text-sm font-medium border hover:bg-bg-hover"
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
