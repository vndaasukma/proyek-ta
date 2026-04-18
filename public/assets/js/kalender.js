const calendar = document.getElementById("calendar");

const tahun = 2026;
const daysInMonth = 29;

let html = "";

for (let day = 1; day <= daysInMonth; day++) {

    const tanggal = `${tahun}-02-${String(day).padStart(2, '0')}`;

    const jadwalHariIni = JADWAL.find(j => {

        const tglDB = String(j.tanggal).trim(); // 🔥 NORMALIZE
        return tglDB === tanggal;

    });

    if (jadwalHariIni) {

        const kuota = Number(jadwalHariIni.kuota ?? 0);
        const terisi = Number(jadwalHariIni.terisi ?? 0);
        const sisa = kuota - terisi;

        if (sisa > 0) {
            html += `<div class="day available" onclick="pilihTanggal('${tanggal}')">${day}</div>`;
        } else {
            html += `<div class="day full">${day}</div>`;
        }

    } else {
        html += `<div class="day">${day}</div>`;
    }
}

calendar.innerHTML = html;

function pilihTanggal(tanggal) {
    window.location.href = FORM_URL + "?tanggal=" + tanggal;
}
