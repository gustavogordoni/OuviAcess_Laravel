{{-- Info: Welcome --}}
@if (@session()->has('info'))
<div class="alert alert-primary alert-dismissible fade show position-fixed bottom-0 end-0 py-auto"
    style="z-index: 1050;" role="alert">
    {{ session('info') }} &#128075;
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

{{--------------------------------------------------------------------------------------}}

{{-- Success --}}
@if (@session()->has('success'))
<div class="alert alert-success alert-dismissible fade show position-fixed bottom-0 end-0 py-auto"
    style="z-index: 1050;" role="alert">
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
        class="bi bi-check-circle-fill me-1" viewBox="0 0 16 16">
        <path
            d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
    </svg>  
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

{{--------------------------------------------------------------------------------------}}

{{-- Error --}}
@if ($errors->any())
    @foreach ($errors->all() as $error)
        <div class="alert alert-danger alert-dismissib  le fade show position-fixed bottom-0 end-0 py-auto" role="alert">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                class="bi bi-exclamation-triangle-fill" viewBox="0 0 16 16">
                <path
                    d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
            </svg>
            <strong>{{ $error }}</strong>
            <button type="button" class="btn-close my-auto" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endforeach
@endif