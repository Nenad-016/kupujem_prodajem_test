@if (session('success'))
    <div id="flash-message"
         class="flash-alert mb-4 rounded-md bg-emerald-50 border border-emerald-200 text-emerald-800
                px-4 py-3 text-sm text-center mx-auto max-w-3xl shadow-sm">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div id="flash-message"
         class="flash-alert mb-4 rounded-md bg-red-50 border border-red-200 text-red-800
                px-4 py-3 text-sm text-center mx-auto max-w-3xl shadow-sm">
        {{ session('error') }}
    </div>
@endif

@if (session('warning'))
    <div id="flash-message"
         class="flash-alert mb-4 rounded-md bg-amber-50 border border-amber-200 text-amber-800
                px-4 py-3 text-sm text-center mx-auto max-w-3xl shadow-sm">
        {{ session('warning') }}
    </div>
@endif

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const alerts = document.querySelectorAll('.flash-alert');
        alerts.forEach(alert => {
            setTimeout(() => {
                alert.style.transition = 'opacity 0.5s ease';
                alert.style.opacity = '0';

                setTimeout(() => alert.remove(), 500);
            }, 3000); 
        });
    });
</script>
