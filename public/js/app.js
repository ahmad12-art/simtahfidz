document.addEventListener('DOMContentLoaded', function () {
    // Sidebar toggle (mobile)
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebar = document.getElementById('sidebar');
    if (sidebarToggle && sidebar) {
        sidebarToggle.addEventListener('click', () => sidebar.classList.toggle('show'));
        document.addEventListener('click', (e) => {
            if (window.innerWidth < 992 && sidebar.classList.contains('show')
                && !sidebar.contains(e.target) && !sidebarToggle.contains(e.target)) {
                sidebar.classList.remove('show');
            }
        });
    }

    // Dark mode toggle (client-side only preference, persisted per-tab)
    const darkToggle = document.getElementById('darkModeToggle');
    if (darkToggle) {
        if (localStorage.getItem('simtahfidz-dark') === '1') {
            document.body.classList.add('dark-mode');
        }
        darkToggle.addEventListener('click', () => {
            document.body.classList.toggle('dark-mode');
            localStorage.setItem('simtahfidz-dark', document.body.classList.contains('dark-mode') ? '1' : '0');
        });
    }

    // Auto-dismiss alerts
    document.querySelectorAll('.alert').forEach((alert) => {
        setTimeout(() => {
            const closeBtn = alert.querySelector('.btn-close');
            if (closeBtn) closeBtn.click();
        }, 6000);
    });

    // Live preview nilai akhir setoran/murajaah (UX only — dihitung ulang di server)
    const nilaiInputs = document.querySelectorAll('[data-nilai-component]');
    const nilaiOutput = document.getElementById('nilai-akhir-preview');
    const predikatOutput = document.getElementById('predikat-preview');

    function hitungPreview() {
        if (!nilaiOutput) return;
        const kelancaran = parseFloat(document.querySelector('[name=nilai_kelancaran]')?.value || 0);
        const tajwid = parseFloat(document.querySelector('[name=nilai_tajwid]')?.value || 0);
        const makhraj = parseFloat(document.querySelector('[name=nilai_makhraj]')?.value || 0);
        const adabEl = document.querySelector('[name=nilai_adab]');
        const adab = adabEl ? parseFloat(adabEl.value || 0) : null;

        let nilai;
        if (adab !== null) {
            nilai = (kelancaran * 0.4) + (tajwid * 0.3) + (makhraj * 0.2) + (adab * 0.1);
        } else {
            nilai = (kelancaran * 0.5) + (tajwid * 0.3) + (makhraj * 0.2);
        }
        nilai = Math.round(nilai * 100) / 100;

        let predikat = 'D';
        if (nilai >= 90) predikat = 'A';
        else if (nilai >= 80) predikat = 'B';
        else if (nilai >= 70) predikat = 'C';

        nilaiOutput.textContent = nilai.toFixed(2);
        if (predikatOutput) predikatOutput.textContent = predikat;
    }

    nilaiInputs.forEach((el) => el.addEventListener('input', hitungPreview));
    hitungPreview();
});
