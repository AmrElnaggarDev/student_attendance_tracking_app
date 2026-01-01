<div>
    <!-- Comment Form -->
    <div class="max-w-[85rem] px-4 py-2 sm:px-6 lg:px-8 lg:py-2 mx-auto">
        <div class="mx-auto max-w-2xl">
            <!-- Card -->
            <div
                class="mt-5 p-4 relative z-10 bg-white border border-gray-200 rounded-xl sm:mt-10 md:p-10 dark:bg-neutral-900 dark:border-neutral-700">
                <!-- Header -->
                <div
                    class="px-6 py-4 grid gap-3 md:flex md:justify-between md:items-center border-b border-gray-200 dark:border-neutral-700">
                    <div>
                        <h2 class="text-xl font-semibold text-gray-800 dark:text-neutral-200">
                            Add Student
                        </h2>
                        <p class="text-sm text-gray-600 dark:text-neutral-400">
                            Add student information's here
                        </p>
                    </div>

                    <div>
                        <div class="inline-flex gap-x-2">
                            <a class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-hidden focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none"
                               href="/student-list" wire:navigate>
                                View all
                            </a>
                        </div>
                    </div>
                </div>
                <!-- End Header -->
                <form wire:submit="save">
                    <div class="mb-4 sm:mb-8">
                        <label for="hs-feedback-post-comment-name-1"
                               class="block mb-2 text-sm font-medium dark:text-white">First name</label>
                        <input type="text" wire:model="first_name"
                               class="py-2.5 sm:py-3 px-4 block w-full border-gray-200 bg-gray-50 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                               placeholder="First name">
                        @error('first_name')
                        <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4 sm:mb-8">
                        <label for="hs-feedback-post-comment-name-1"
                               class="block mb-2 text-sm font-medium dark:text-white">Last name</label>
                        <input type="text" wire:model="last_name"
                               class="py-2.5 sm:py-3 px-4 block w-full border-gray-200 bg-gray-50 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                               placeholder="Last name">
                        @error('last_name')
                        <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4 sm:mb-8">
                        <label for="hs-feedback-post-comment-email-1"
                               class="block mb-2 text-sm font-medium dark:text-white">Age</label>
                        <input type="number" wire:model="age" id="hs-feedback-post-comment-email-1"
                               class="py-2.5 sm:py-3 px-4 block w-full border-gray-200 bg-gray-50 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                               placeholder="Enter Age">
                        @error('age')
                        <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4 sm:mb-8">
                        <label class="block mb-2 text-sm font-medium dark:text-white">Gender</label>
                        <select wire:model="gender"
                                class="py-2.5 sm:py-3 px-4 block w-full border-gray-200 bg-gray-50 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-400 dark:focus:ring-neutral-600">
                            <option value="">Select Gender</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>

                        @error('gender')
                        <p class="text-red-500 text-xs mt-1">
                            {{$message}}
                        </p>
                        @enderror
                    </div>

                    <div class="mb-4 sm:mb-8">
                        <label class="block mb-2 text-sm font-medium dark:text-white">Grade</label>
                        <select wire:model="grade"
                                class="py-2.5 sm:py-3 px-4 block w-full border-gray-200 bg-gray-50 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-400">
                            <option value="">Select Grade</option>
                            @foreach ($grades as $grade)
                                <option wire:key="{{ $grade->id }}" value="{{ $grade->id }}">{{ $grade->name }}</option>
                            @endforeach
                        </select>
                        @error('grade')
                        <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4 sm:mb-8 flex items-center justify-between p-4 border border-gray-200 bg-gray-50 rounded-lg dark:bg-neutral-800 dark:border-neutral-700">
                        <label for="is_active_toggle" class="text-sm font-medium text-gray-800 dark:text-white">Account Status (Active)</label>

                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" wire:model="is_active" id="is_active_toggle" class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                        </label>
                    </div>

                    <div class="mt-6 grid">
                        <button type="submit"
                                class="w-full py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-hidden focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
                            <div wire:loading
                                 class="animate-spin inline-block size-6 border-3 border-current border-t-transparent text-white rounded-full dark:text-white"
                                 role="status" aria-label="loading">
                                <span class="sr-only">Loading...</span>
                            </div>
                            Submit
                        </button>
                    </div>
                </form>
            </div>
            <!-- End Card -->
        </div>
    </div>
    <!-- End Comment Form -->
</div>
