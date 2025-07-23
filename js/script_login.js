document.addEventListener('DOMContentLoaded', function() {
    // Memilih semua tombol peran dan input tersembunyi
    const roleButtons = document.querySelectorAll('.role-btn');
    const selectedRoleInput = document.getElementById('selected-role');

    // Pastikan elemen-elemen tersebut ada di halaman
    if (roleButtons.length > 0 && selectedRoleInput) {
        
        // Tambahkan event listener untuk setiap tombol peran
        roleButtons.forEach(button => {
            button.addEventListener('click', () => {
                // 1. Hapus kelas 'active' dari semua tombol
                roleButtons.forEach(btn => btn.classList.remove('active'));
                
                // 2. Tambahkan kelas 'active' ke tombol yang baru diklik
                button.classList.add('active');
                
                // 3. Update nilai pada input tersembunyi sesuai peran yang diklik
                selectedRoleInput.value = button.dataset.role;
            });
        });
    }
});