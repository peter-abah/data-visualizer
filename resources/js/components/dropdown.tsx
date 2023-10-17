import clsx from "clsx";
import { ReactNode, useRef } from "react";
import { useBoolean, useOnClickOutside } from "usehooks-ts";

type Props = {
    trigger: ReactNode;
    children: ReactNode;
    contentClasses?: string;
};

export default function Dropdown({ trigger, children, contentClasses }: Props) {
    const ref = useRef<HTMLDivElement>(null);
    const {
        value: open,
        toggle: toggleOpen,
        setValue: setOpen,
    } = useBoolean(false);
    useOnClickOutside(ref, () => {
        setOpen(false);
    });

    return (
        <div className="relative" ref={ref}>
            <div onClick={toggleOpen}>{trigger}</div>

            <div
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-75"
                x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
                className={clsx(
                    "absolute z-50 mt-2 w-48 rounded-md shadow-lg origin-top-right right-0",
                    { hidden: !open }
                )}
                onClick={() => setOpen(false)}
            >
                <div
                    className={`rounded-md ring-1 ring-black ring-opacity-5 bg-white z-50 ${contentClasses}`}
                >
                    {children}
                </div>
            </div>
        </div>
    );
}

export const DropdownButton = ({
    className,
    ...restProps
}: React.ComponentPropsWithoutRef<"button">) => {
    return (
        <button
            {...restProps}
            className={clsx(
                "block w-full text-left px-4 py-2 text-sm hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out",
                className
            )}
        />
    );
};
