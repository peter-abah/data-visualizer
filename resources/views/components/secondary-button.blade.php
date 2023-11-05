<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center px-4 py-2 bg-bg border border-border rounded-md font-semibold text-xs text-text  uppercase tracking-widest shadow-sm hover:bg-bg-hover focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2  disabled:opacity-25 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
