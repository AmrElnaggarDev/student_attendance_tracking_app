<x-layouts.app :title="'403 - Forbidden'">
    <div class="min-h-[60vh] flex items-center justify-center px-4">
        <div class="max-w-xl w-full rounded-3xl border border-slate-200 bg-white p-8 text-center">
            <h1 class="text-2xl font-bold text-slate-900">403 - Forbidden</h1>
            <p class="mt-2 text-slate-600">You don’t have permission to access this page.</p>

            <div class="mt-6 flex items-center justify-center gap-2">
                <a href="{{ url()->previous() }}" class="rounded-xl border px-4 py-2">Go Back</a>

                @auth
                    <a href="{{ route(auth()->user()->role === 'admin' ? 'admin.dashboard' : 'teacher.dashboard') }}"
                       class="rounded-xl bg-slate-900 px-4 py-2 text-white">
                        Dashboard
                    </a>
                @endauth
            </div>
        </div>
    </div>
</x-layouts.app>
