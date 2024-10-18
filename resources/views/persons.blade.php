<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Persons</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.0.3/dist/tailwind.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #1F2937; /* Warna latar belakang gelap */
            color: #FFFFFF; /* Warna teks terang */
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            border-radius: 8px;
            background-color: #374151; /* Warna latar belakang kontainer */
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #4B5563; /* Garis batas antar baris */
        }
        th {
            background-color: #3B3F42; /* Warna latar belakang header */
        }
        tr:hover {
            background-color: #4B5563; /* Warna saat hover */
        }
    </style>
</head>
<body>
    <div class="container mt-10">
        <h1 class="text-3xl font-bold mb-4">Data Persons</h1>

        <!-- Form untuk menambah data baru -->
        <form id="create-person-form" class="mb-6">
            <input type="text" id="name" placeholder="Nama" class="p-2 rounded mb-2 w-full" required>
            <input type="email" id="email" placeholder="Email" class="p-2 rounded mb-2 w-full" required>
            <button type="submit" class="bg-blue-500 text-white p-2 rounded">Tambah Data</button>
        </form>

        <!-- Tabel untuk menampilkan data -->
        <table class="table-auto text-left">
            <thead>
                <tr>
                    <th class="text-white">Nama</th>
                    <th class="text-white">Email</th>
                </tr>
            </thead>
            <tbody id="person-list">
                <!-- Data akan ditampilkan di sini -->
            </tbody>
        </table>
    </div>

    <script>
        // Fungsi untuk mengambil data dari API
        function fetchPersons() {
            fetch('http://localhost:8000/api/person')
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok ' + response.statusText);
                    }
                    return response.json();
                })
                .then(data => {
                    const personList = document.getElementById('person-list');
                    personList.innerHTML = ''; // Kosongkan daftar sebelum menambahkan data baru
                    if (data.status) {
                        data.data.forEach(person => {
                            const row = document.createElement('tr');
                            row.innerHTML = `
                                <td class="text-white">${person.name}</td>
                                <td class="text-white">${person.email}</td>
                            `;
                            personList.appendChild(row);
                        });
                    } else {
                        personList.innerHTML = '<tr><td colspan="2">Tidak ada data ditemukan.</td></tr>';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    document.getElementById('person-list').innerHTML = '<tr><td colspan="2">Terjadi kesalahan saat memuat data.</td></tr>';
                });
        }

        // Mengambil data saat halaman dimuat
        window.onload = fetchPersons;

        // Menangani pengiriman form untuk menambah data
        document.getElementById('create-person-form').addEventListener('submit', function(e) {
            e.preventDefault(); // Mencegah reload halaman

            const name = document.getElementById('name').value;
            const email = document.getElementById('email').value;

            // Mengirim data ke API untuk membuat person baru
            fetch('http://localhost:8000/api/person', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ name: name, email: email })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok ' + response.statusText);
                }
                return response.json();
            })
            .then(data => {
                if (data.status) {
                    // Reset form setelah berhasil
                    document.getElementById('create-person-form').reset();
                    // Ambil kembali data setelah penambahan
                    fetchPersons();
                } else {
                    alert('Gagal menambah data: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat menambah data.');
            });
        });
    </script>
</body>
</html>
