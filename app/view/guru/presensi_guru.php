<main class="grid mx-auto  p-3 md:grid-cols-2 grid-cols-1 gap-3">
    <!-- scanner -->
        <div class="w-full md:max-w-screen-sm">
            <div class="flex justify-center mt-4">
                <button id="startButton" class="bg-green-800 text-white px-4 py-2 rounded mr-2">Start Scanner</button>
                <button id="stopButton" class="bg-red-500 text-white px-4 py-2 rounded">Stop Scanner</button>
            </div>
            <div class="container mx-auto max-w-md mt-3 ">
            <div id="reader" class="rounded-lg overflow-hidden m-2 md:m-0 "></div>
            </div>
        </div>
    <!-- endscanner -->
     <!-- siswa -->
        <div class="w-full md:max-w-screen-sm">
            <p class="text-base font-semibold dark:text-slate-400">Siswa Yang Belum Presensi</p>
            <hr class="border-t-2 border-gray-200 mt-1 mb-2 dark:border-slate-600">
            <div id="siswa_list" class="w-full"></div>
        </div>
     <!-- endsiswa -->
    </main>