<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-bg-btn border border-transparent rounded-md font-semibold text-xs text-text-inverse tracking-widest hover:bg-bg-btn/75 focus:bg-bg-btn/75 active:bg--bg-btn/90  focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2  transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
