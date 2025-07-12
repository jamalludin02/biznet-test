<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generator Barcode & QR Code</title>
    <!-- Menggunakan Tailwind CSS untuk styling yang modern dan responsif -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        /* Animasi spinner sederhana */
        .loader {
            border: 4px solid #f3f3f3;
            border-radius: 50%;
            border-top: 4px solid #3498db;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <div class="w-full max-w-md bg-white rounded-xl shadow-lg p-8">
        <h1 class="text-2xl font-bold text-gray-800 mb-2 text-center">Generator Barcode</h1>
        <p class="text-gray-500 mb-6 text-center">Buat Barcode atau QR Code dengan mudah.</p>

        <form id="generator-form" class="space-y-4">
            <div>
                <label for="data" class="block text-sm font-medium text-gray-700 mb-1">Teks atau Data</label>
                <input type="text" id="data" name="data" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" placeholder="Lorem Ipsum" required>
            </div>

            <div>
                <label for="type" class="block text-sm font-medium text-gray-700 mb-1">Tipe Barcode</label>
                <select id="type" name="type" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                    <option value="barcode">Barcode Biasa</option>
                    <option value="qrcode">QR Code</option>
                </select>
            </div>

            <button type="submit" class="w-full bg-blue-600 text-white font-bold py-2 px-4 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-200 flex items-center justify-center">
                Generate
            </button>
        </form>

        <!-- Area untuk menampilkan hasil gambar -->
        <div id="barcode-result" class="mt-6 border-t pt-6">
            <h2 class="text-lg font-semibold text-gray-700 text-center mb-4">Hasil</h2>
            <!-- Kontainer untuk gambar yang akan digenerate -->
            <div id="image-container" class="bg-gray-50 p-4 rounded-lg min-h-[200px] flex items-center justify-center transition-all duration-300">
                <p class="text-gray-400">Hasil barcode akan muncul di sini</p>
            </div>
        </div>
    </div>

    <script>
        const form = document.getElementById('generator-form');
        const imageContainer = document.getElementById('image-container');
        const submitButton = form.querySelector('button[type="submit"]');

        form.addEventListener('submit', async (event) => {
            event.preventDefault();

            imageContainer.innerHTML = '<div class="loader"></div>';
            submitButton.disabled = true;
            submitButton.classList.add('bg-gray-400', 'cursor-not-allowed');
            submitButton.classList.remove('bg-blue-600', 'hover:bg-blue-700');


            const formData = new FormData(form);

            try {
                const response = await fetch('generate.php', {
                    method: 'POST',
                    body: formData
                });

                if (!response.ok) {
                    throw new Error(`Server error: ${response.statusText}`);
                }

                const imageBlob = await response.blob();
                
                const imageUrl = URL.createObjectURL(imageBlob);

                imageContainer.innerHTML = `<img src="${imageUrl}" alt="Generated Barcode" class="max-w-full h-auto rounded-md shadow-sm">`;

            } catch (error) {
                console.error('Error generating barcode:', error);
                imageContainer.innerHTML = '<p class="text-red-500 text-center">Gagal membuat barcode.<br>Silakan periksa input dan coba lagi.</p>';
            } finally {
                submitButton.disabled = false;
                submitButton.classList.remove('bg-gray-400', 'cursor-not-allowed');
                submitButton.classList.add('bg-blue-600', 'hover:bg-blue-700');
            }
        });
    </script>

</body>
</html>
