document.addEventListener('DOMContentLoaded', function () {
    console.log("JavaScript Loaded!");
    const jenisSurat = document.getElementById('jenis_surat');
    const formSemester = document.getElementById('form_semester');
    const formMK = document.getElementById('form_mk');
    const formDetailSurat = document.getElementById('form_detail_surat');
    const formNRPNama = document.getElementById('form_nrp_nama');

    function hideAllForms() {
        formSemester.style.display = "none";
        formMK.style.display = "none";
        formDetailSurat.style.display = "none";
        formNRPNama.style.display = "none";
    }

    jenisSurat.addEventListener('change', function () {
        hideAllForms();
        console.log("Jenis surat dipilih:", jenisSurat.value);

        if (jenisSurat.value === "Keterangan Mahasiswa Aktif") {
            formSemester.style.display = "block";
            formDetailSurat.style.display = "block";
        } else if (jenisSurat.value === "Pengantar Tugas") {
            formMK.style.display = "block";
            formDetailSurat.style.display = "block";
        } else if (jenisSurat.value === "Keterangan Lulus") {
            formNRPNama.style.display = "block";
        } else if (jenisSurat.value === "Laporan Hasil Studi") {
            formNRPNama.style.display = "block";
            formDetailSurat.style.display = "block";
        }
    });
});
