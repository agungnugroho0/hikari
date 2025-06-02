<?php
include '../../../autoloader.php';
admin();
$id = $_GET['id_job'];
$so = tampil("SELECT * FROM so");
$job = tampil("SELECT * FROM job join so ON job.id_so = so.id_so WHERE id_job ='$id'");  
foreach ($job as $jobs){
    $job = $jobs['job'];
    $id_so = $jobs['id_so'];
    $so_nya = $jobs['so'];
    $pt = $jobs['perusahaan'];
    $tgl = $jobs['tgl_job'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JOBDESK</title>
    <script src="https://cdn.tailwindcss.com"></script>

</head>
<body>
    <div class="container mx-auto md:max-w-lg mt-5 shadow-md p-3">
        <p class="text-center font-medium text-xl">JOBDESK</p>
        <hr class="my-2">
        <form action="/app/database/edit_jobs.php" method="post" class="flex flex-col">
            <input type="text" value="<?=$id?>" name="id_job" hidden/>
            <label for="so" class="text-sm font-semibold text-gray-500">Pilih SO</label>
            <select name="so" id="so" class="p-2 border-b-2 border-blue-400 w-full focus:border-blue-800 focus:outline-none">
                <option value="<?= $id_so ?>"><?= $so_nya ?></option>
                <?php
                foreach($so as $key => $value){?>
                <option value="<?=$value['id_so']?>"><?= $value['so']?></option>
                <?php } ?>
            </select>
            <label for="job" class="text-sm font-semibold text-gray-500 my-2">Nama Job</label>
            <input type="text" class="p-2 border-b-2 border-blue-400 w-full focus:border-blue-800 focus:outline-none" name="job" value="<?= $job ?>">
            <label for="perusahaan" class="text-sm font-semibold text-gray-500 my-2">Nama Perusahaan</label>
            <input type="text" class="p-2 border-b-2 border-blue-400 w-full focus:border-blue-800 focus:outline-none" name="perusahaan" value="<?= $pt ?>">
            <label for="perusahaan" class="text-sm font-semibold text-gray-500 my-2">Tanggal</label>
            <input type="date" class="p-2 border-b-2 border-blue-400 w-full focus:border-blue-800 focus:outline-none" name="tgl" value="<?= $tgl ?>">
            <button type="submit" class="bg-red-800 w-full mt-3 py-2 rounded-md text-white font-semibold">EDIT JOB</button>
        </form>
    </div>
</body>
</html>