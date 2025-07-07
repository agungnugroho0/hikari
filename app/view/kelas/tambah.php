<body>
    <form id="form-tambah-kelas" method="POST" >
        <div class="grid mb-6 md:grid-cols-2 gap-3">
            <div>
                <label for="kelas" class="text-sm font-medium text-gray-900 dark:text-white">Nama Kelas</label>
                <input type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg  w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-200 mt-1 font-[Lato]" id="kelas" name="kelas" required>
            </div>
            <div>
                <label for="tingkat" class="text-sm font-medium text-gray-900 dark:text-white">Tingkat Kelas</label>
                <input type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg  w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-200 mt-1 font-[Lato]" id="tingkat" name="tingkat" >
            </div>
            <div class="flex gap-2">
                <div>
                    <label class="block text-sm font-medium text-gray-900 dark:text-white" for="file_input">&nbsp;</label>
                    <button class=" bg-green-700 dark:bg-blue-600 dark:hover:bg-blue-950 hover:bg-green-950 text-white font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center transition">Tambah</button>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-900 dark:text-white" for="file_input">&nbsp;</label>
                    <a href="#" class=" bg-red-600 block font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center text-white hover:bg-red-900 transition" onclick="loadPageFromMenu('router.php?page=kelas', '6')">Cancel</a>
                </div>
            </div>
        </div>  

    </form>
    <script>
  if (typeof initkelas === "function") {
      initkelas();
  }
</script>
</body>