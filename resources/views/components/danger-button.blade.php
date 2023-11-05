<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-bg-btn-danger border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-bg-btn-danger/75 active:bg-bg-btn-danger/90 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2  transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
