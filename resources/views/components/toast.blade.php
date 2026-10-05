@php
    $messages = [
        'success' => session('success'),
        'error' => session('error'),
        'warning' => session('warning'),
        'info' => session('info'),
    ];
@endphp

<div class="toast-container" aria-live="polite" aria-relevant="additions">
    @foreach ($messages as $type => $message)
        @if (filled($message))
            <div class="toast toast--{{ $type }}" role="{{ $type === 'error' ? 'alert' : 'status' }}" data-toast>
                <span class="toast-icon" aria-hidden="true">
                    @if ($type === 'success')
                        <svg viewBox="0 0 24 24"><path d="m5 12 4 4L19 6"></path></svg>
                    @elseif ($type === 'error')
                        <svg viewBox="0 0 24 24"><path d="M12 8v5"></path><path d="M12 17h.01"></path><circle cx="12" cy="12" r="9"></circle></svg>
                    @elseif ($type === 'warning')
                        <svg viewBox="0 0 24 24"><path d="M12 9v4"></path><path d="M12 17h.01"></path><path d="m10.3 4.8-7 12.1A2 2 0 0 0 5 20h14a2 2 0 0 0 1.7-3.1l-7-12.1a2 2 0 0 0-3.4 0Z"></path></svg>
                    @else
                        <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"></circle><path d="M12 11v5"></path><path d="M12 8h.01"></path></svg>
                    @endif
                </span>
                <p class="toast-message">{{ $message }}</p>
                <button class="toast-close" type="button" aria-label="Tutup notifikasi" data-toast-close>&times;</button>
            </div>
        @endif
    @endforeach
</div>
