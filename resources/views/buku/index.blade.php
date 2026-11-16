@extends('layouts.app')

@section('title', 'Daftar Buku')

@section('content')

<div class="crud-container"
    id="halamanBuku"
    data-boleh-kelola="{{ auth()->user()->can('kelola data buku') ? '1' : '0' }}">

    <div class="crud-card">

        <h2>Manajemen Data Buku</h2>

        <div id="pesan" class="crud-message"></div>

        @can('kelola data buku')
        <h3 id="judulForm">Tambah Buku</h3>

        <form id="formBuku" class="crud-form">

            <div class="crud-field">
                <label for="kategori_id">ID Kategori</label>
                <input type="number" id="kategori_id" name="kategori_id" required>
            </div>

            <div class="crud-field">
                <label for="judul">Judul Buku</label>
                <input type="text" id="judul" name="judul" required>
            </div>

            <div class="crud-field">
                <label for="penulis">Penulis</label>
                <input type="text" id="penulis" name="penulis" required>
            </div>

            <div class="crud-field">
                <label for="tahun_terbit">Tahun Terbit</label>
                <input type="number" id="tahun_terbit" name="tahun_terbit" required>
            </div>

            <div class="crud-actions">
                <button type="submit" class="crud-btn crud-btn-primary" id="tombolSimpan">
                    Simpan
                </button>

                <button type="button" class="crud-btn crud-btn-secondary"
                    id="tombolBatal" onclick="resetForm()">
                    Batal
                </button>
            </div>

        </form>
        @endcan

    </div>

    <div class="crud-card">

        <h2>Daftar Buku</h2>

        <div class="crud-table">

            <table>
                <thead>
                    <tr>
                        <th>Kategori</th>
                        <th>Judul</th>
                        <th>Penulis</th>
                        <th>Tahun Terbit</th>

                        @can('kelola data buku')
                        <th>Aksi</th>
                        @endcan
                    </tr>
                </thead>

                <tbody id="tabelBuku">
                    @foreach ($buku as $item)
                    <tr>
                        <td>{{ $item->kategori->nama_kategori ?? '-' }}</td>
                        <td>{{ $item->judul }}</td>
                        <td>{{ $item->penulis }}</td>
                        <td>{{ $item->tahun_terbit }}</td>

                        @can('kelola data buku')
                        <td>
                            <button type="button"
                                class="crud-btn crud-btn-primary">
                                ubah
                            </button>

                            <form action="{{ route('buku.hapus', $item->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                    class="crud-btn crud-btn-danger"
                                    onclick="return confirm('Yakin ingin menghapus buku ini?')">
                                    hapus
                                </button>
                            </form>
                        </td>
                        @endcan
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>

</div>

<script>
    const api = '/api/buku';

    const halamanBuku = document.getElementById('halamanBuku');
    const bolehKelolaBuku = halamanBuku.dataset.bolehKelola === '1';

    const tabelBuku = document.getElementById('tabelBuku');
    const pesan = document.getElementById('pesan');
    const form = document.getElementById('formBuku');

    let idUbah = null;

    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

    function tampilkanPesan(teks, jenis = 'success') {
        pesan.textContent = teks;
        pesan.className = 'crud-message ' + jenis;
    }

    function resetForm() {
        if (!form) return;

        form.reset();
        idUbah = null;

        document.getElementById('judulForm').textContent = 'Tambah Buku';
        document.getElementById('tombolSimpan').textContent = 'Simpan';
        pesan.textContent = '';
    }

    async function tampilkanBuku() {
        try {
            const response = await fetch(api, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json'
                }
            });

            const hasil = await response.json();

            if (!response.ok) {
                throw new Error(hasil.message || 'Gagal mengambil data buku.');
            }

            const daftarBuku = Array.isArray(hasil.data) ?
                hasil.data : [];

            tabelBuku.innerHTML = '';

            if (daftarBuku.length === 0) {
                tabelBuku.innerHTML = `
                    <tr>
                        <td colspan="${bolehKelolaBuku ? 5 : 4}">
                            Belum ada data buku.
                        </td>
                    </tr>
                `;
                return;
            }

            daftarBuku.forEach(buku => {
                const baris = document.createElement('tr');

                const kategori = buku.kategori?.nama_kategori ??
                    buku.kategori?.nama ??
                    buku.kategori_id ??
                    '-';

                baris.innerHTML = `
                    <td>${kategori}</td>
                    <td>${buku.judul ?? '-'}</td>
                    <td>${buku.penulis ?? '-'}</td>
                    <td>${buku.tahun_terbit ?? '-'}</td>
                    ${bolehKelolaBuku ? `
                        <td>
                            <button type="button"
                                class="crud-btn crud-btn-primary"
                                onclick="editBuku(${buku.id})">
                                Ubah
                            </button>

                            <button type="button"
                                class="crud-btn crud-btn-danger"
                                onclick="hapusBuku(${buku.id})">
                                Hapus
                            </button>
                        </td>
                    ` : ''}
                `;

                tabelBuku.appendChild(baris);
            });

        } catch (error) {
            tabelBuku.innerHTML = `
                <tr>
                    <td colspan="${bolehKelolaBuku ? 5 : 4}">
                        ${error.message}
                    </td>
                </tr>
            `;
        }
    }

    async function editBuku(id) {
        try {
            const response = await fetch(`${api}/${id}`, {
                headers: {
                    'Accept': 'application/json'
                }
            });

            const hasil = await response.json();

            if (!response.ok) {
                throw new Error(hasil.message || 'Gagal mengambil detail buku.');
            }

            const buku = hasil.data;

            document.getElementById('kategori_id').value = buku.kategori_id ?? '';
            document.getElementById('judul').value = buku.judul ?? '';
            document.getElementById('penulis').value = buku.penulis ?? '';
            document.getElementById('tahun_terbit').value = buku.tahun_terbit ?? '';

            idUbah = id;

            document.getElementById('judulForm').textContent = 'Ubah Buku';
            document.getElementById('tombolSimpan').textContent = 'Perbarui';

        } catch (error) {
            tampilkanPesan(error.message, 'error');
        }
    }

    async function hapusBuku(id) {
        if (!confirm('Apakah kamu yakin ingin menghapus buku ini?')) {
            return;
        }

        try {
            const response = await fetch(`${api}/${id}`, {
                method: 'DELETE',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                }
            });

            const hasil = await response.json();

            if (!response.ok) {
                throw new Error(hasil.message || 'Gagal menghapus buku.');
            }

            tampilkanPesan('Data buku berhasil dihapus.');


        } catch (error) {
            tampilkanPesan(error.message, 'error');
        }
    }

    if (bolehKelolaBuku && form) {
        form.addEventListener('submit', async function(event) {
            event.preventDefault();

            const dataBuku = {
                kategori_id: document.getElementById('kategori_id').value,
                judul: document.getElementById('judul').value,
                penulis: document.getElementById('penulis').value,
                tahun_terbit: document.getElementById('tahun_terbit').value
            };

            const url = idUbah ? `${api}/${idUbah}` : api;
            const method = idUbah ? 'PUT' : 'POST';

            try {
                const response = await fetch(url, {
                    method: method,
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify(dataBuku)
                });

                const hasil = await response.json();

                if (!response.ok) {
                    if (hasil.errors) {
                        const daftarError = Object.values(hasil.errors).flat().join(' ');
                        throw new Error(daftarError);
                    }

                    throw new Error(hasil.message || 'Gagal menyimpan data buku.');
                }

                tampilkanPesan(
                    idUbah ?
                    'Data buku berhasil diperbarui.' :
                    'Data buku berhasil ditambahkan.'
                );

                resetForm();


            } catch (error) {
                tampilkanPesan(error.message, 'error');
            }
        });
    }
</script>

@endsection