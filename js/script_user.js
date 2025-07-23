// js/script_user.js

document.addEventListener('DOMContentLoaded', function() {
    
    // Temukan elemen slider dan elemen untuk menampilkan nilai harga
    const priceRange = document.getElementById('priceRange');
    const priceValue = document.getElementById('priceValue');

    // Pastikan kedua elemen ada sebelum menambahkan event listener
    if (priceRange && priceValue) {
        
        // Fungsi untuk memformat angka menjadi format Rupiah
        const formatRupiah = (number) => {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            }).format(number);
        };

        // Atur nilai awal saat halaman dimuat
        priceValue.textContent = formatRupiah(priceRange.value);

        // Tambahkan event listener saat slider digerakkan
        priceRange.addEventListener('input', function() {
            // Perbarui teks pada elemen priceValue sesuai nilai slider
            priceValue.textContent = formatRupiah(this.value);
        });
    }

});