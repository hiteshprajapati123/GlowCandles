@props(['status'])

@if ($status)
    <div class="mb-4 text-sm font-medium text-emerald-600">
        {{ $status }}
    </div>
@endif
