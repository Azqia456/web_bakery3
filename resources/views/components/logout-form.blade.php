@props(['class' => '', 'buttonClass' => 'logout-btn'])

<form action="{{ route('logout') }}" method="POST" {{ $attributes->merge(['class' => $class]) }}>
    @csrf
    <button type="submit" class="{{ $buttonClass }}">
        <i class="fas fa-right-from-bracket"></i>
        {{ $slot ?? 'Logout' }}
    </button>
</form>
