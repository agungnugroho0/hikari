<div class="flex md:grid md:grid-cols-4 p-1 md:mt-4 md:mx-2 gap-2 relative">
    <form class="bg-white md:rounded-full px-3 py-1 flex items-center space-x-2 relative mb-4 grow">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M11 4a7 7 0 100 14 7 7 0 000-14zM21 21l-4.35-4.35" />
            </svg>
            <input type="text" name="search" placeholder="cari siswa" class="text-slate-700 border-0 focus:border-0 focus:ring-0 outline-none bg-transparent w-full" oninput="cari()">
    </form>
    <div id="searchResults" class="hidden ml-2 absolute top-10 md:top-10 w-full md:w-64 bg-white shadow-sm rounded-lg z-10"></div>
    <a href="../../app/config/logout.php" class="m-1 p-2 bg-white rounded-lg flex hover:bg-black  active:scale-90 transition duration-300 col-end-6 group">
                <img src="../image/asset/power.png" alt="Logo" class="w-5 h-5 md:translate-y-0.5 ">
                <div class="hidden ml-2 font-semibold group-hover:text-white md:block transition group-hover:-translate-x-2.5">LOGOUT</div>
    </a>
</div>