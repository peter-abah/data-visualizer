<x-layout>
    <header class="flex items-center justify-between sticky top-0 bg-white px-8 py-4">
        <h1 class="flex items-center px-4 text-3xl font-bold">
            <img src="logo.png" alt="PlotDat logo" class="w-8">
            <span>Plot</span><span class="text-red-700">Dat</span>
        </h1>

        <nav>
            <ul>
                <li><a class="rounded-md border border-gray-800 px-6 py-2 font-bold hover:bg-black hover:text-white"
                        href={{ route('register') }}>Get Started</a></li>
            </ul>
        </nav>
    </header>

    <section class="grid place-items-center p-24 text-center">
        <h2 class="max-w-3xl text-6xl font-bold">Turn your data to beautiful
            charts with ease</h2>
        <p class="mt-4 max-w-xl text-lg text-gray-600">
            Easily transform your raw data into stunning charts and graphs. Whether you're a
            business analyst, researcher, or just curious about your data, our intuitive tool makes
            visualization a breeze.
        </p>
        <a class="mt-8 block rounded-md border border-gray-800 px-6 py-2 font-bold hover:bg-black hover:text-white"
            href={{ route('register') }}>Get Started</a>
    </section>

    <section class="grid grid-cols-[2fr_3fr] gap-12 px-20 py-16">
        <div>
            <h2 class="mb-8 text-5xl font-bold">Diverse chart types</h2>
            <p class="mt-4 w-4/5 text-lg text-gray-600">
                Create a wide range of charts, including bar charts, line charts, pie charts,
                scatter plots, and more. Whatever your data visualization needs, we've got you
                covered.
            </p>
        </div>

        <div class="grid grid-cols-2 grid-rows-2 content-center gap-4">
            <img src="bar_chart.jpeg" alt="Bar chart example">
            <img src="line_chart.jpeg" alt="Line chart example"
                class="col-start-2 row-start-1 row-end-3 self-center">
            <img src="pie_chart.jpeg" alt="Pie chart example">
        </div>
    </section>

    <section class="gap-12 px-20 pt-16 pb-20">
        <div class="w-3/5">
            <h2 class="mb-8 text-5xl font-bold">Export charts and share them</h2>
            <p class="mt-4 w-4/5 text-lg text-gray-600">
                Download your charts in various formats, including images and PDF.
                This gives you the flexibility to share your insights and collaborate with
                others seamlessly.
            </p>
            <a class="mt-8 inline-block rounded-md border border-gray-800 px-6 py-2 font-bold hover:bg-black hover:text-white"
            href={{ route('register') }}>Get Started</a>
        </div>
    </section>

    <footer class="bg-black px-8 py-4 text-center text-white">
        <p>Made with ❤ by <a href="https://github.com/peter-abah"
                class="underline hover:no-underline">Peter Abah</a></p>
    </footer>
</x-layout>
