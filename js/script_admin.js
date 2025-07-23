document.addEventListener('DOMContentLoaded', function() {
    // Memilih elemen tombol dan kartu dari halaman
    const prevBtn = document.getElementById('prev-btn');
    const nextBtn = document.getElementById('next-btn');
    const cards = document.querySelectorAll('.card');
    
    // Pastikan ada elemen yang bisa di-carousel
    if (cards.length > 0 && prevBtn && nextBtn) {
        
        // Cari tahu kartu mana yang aktif saat ini
        let currentIndex = Array.from(cards).findIndex(card => card.classList.contains('active'));
        // Jika tidak ada yang aktif, set default ke kartu pertama
        if (currentIndex === -1) {
            currentIndex = 0;
            cards[currentIndex].classList.add('active');
        }

        // Fungsi untuk update kartu yang aktif
        function updateActiveCard(newIndex) {
            // Hapus kelas 'active' dari kartu yang lama
            cards[currentIndex].classList.remove('active');
            // Tambahkan kelas 'active' ke kartu yang baru
            cards[newIndex].classList.add('active');
            // Update index saat ini
            currentIndex = newIndex;
        }

        // Event listener untuk tombol berikutnya (next)
        nextBtn.addEventListener('click', () => {
            // Hitung index berikutnya, jika sudah di akhir, kembali ke 0 (awal)
            let nextIndex = (currentIndex + 1) % cards.length;
            updateActiveCard(nextIndex);
        });

        // Event listener untuk tombol sebelumnya (prev)
        prevBtn.addEventListener('click', () => {
            // Hitung index sebelumnya, jika sudah di awal, kembali ke index terakhir
            let prevIndex = (currentIndex - 1 + cards.length) % cards.length;
            updateActiveCard(prevIndex);
        });
    }
});