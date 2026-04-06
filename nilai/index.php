<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konversi Nilai</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        .result,
        .error {
            margin-top: 20px;
            padding: 15px;
            border-radius: 5px;
        }

        .result {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        form {
            margin-bottom: 20px;
        }

        label {
            display: inline-block;
            width: 100px;
        }

        input[type="text"] {
            margin-bottom: 10px;
            padding: 5px;
        }
    </style>
</head>

<body>

    <h2>Aplikasi Konversi Nilai ke Huruf</h2>

    <form method="POST">
        <div>
            <label for="nama">Nama:</label>
            <input type="text" id="nama" name="nama" value="<?php echo isset($_POST['nama']) ? htmlspecialchars($_POST['nama']) : ''; ?>" required>
        </div>
        <div>
            <label for="nilai">Nilai Angka:</label>
            <input type="text" id="nilai" name="nilai" value="<?php echo isset($_POST['nilai']) ? htmlspecialchars($_POST['nilai']) : ''; ?>" required>
        </div>
        <button type="submit" name="submit">Konversi</button>
    </form>

    <?php
    // Fungsi manual untuk memvalidasi nama (hanya huruf dan spasi)
    function isNamaValid($nama)
    {
        if (empty($nama)) return false;

        $len = strlen($nama);
        for ($i = 0; $i < $len; $i++) {
            $char = $nama[$i];
            // Validasi: harus huruf (A-Z, a-z) atau spasi
            if (!($char >= 'a' && $char <= 'z') && !($char >= 'A' && $char <= 'Z') && $char !== ' ') {
                return false;
            }
        }
        return true;
    }

    // Fungsi manual untuk memvalidasi nilai
    function isNilaiValid($nilai)
    {
        if ($nilai === '') return false;

        $len = strlen($nilai);
        $titikDitemukan = false;

        for ($i = 0; $i < $len; $i++) {
            $char = $nilai[$i];
            if ($char === '.') {
                if ($titikDitemukan) return false;
                $titikDitemukan = true;
            } elseif (!($char >= '0' && $char <= '9')) {
                return false;
            }
        }
        return true;
    }

    // Fungsi konversi nilai angka ke huruf
    function konversiNilaiKeHuruf($nilai)
    {
        $nilai = (float)$nilai;
        if ($nilai >= 81 && $nilai <= 100) return "A";
        if ($nilai >= 71 && $nilai < 81) return "AB";
        if ($nilai >= 66 && $nilai < 71) return "B";
        if ($nilai >= 60 && $nilai < 66) return "BC";
        if ($nilai >= 56 && $nilai < 60) return "C";
        if ($nilai >= 41 && $nilai < 56) return "D";
        if ($nilai >= 0 && $nilai < 41) return "E";
        return "Tidak Valid (Gunakan rentang 0-100)";
    }

    // Fungsi untuk mendapatkan predikat
    function getPredikat($huruf)
    {
        switch ($huruf) {
            case "A":
                return "Sangat Baik";
            case "AB":
                return "Baik Sekali";
            case "B":
                return "Baik";
            case "BC":
                return "Cukup Baik";
            case "C":
                return "Cukup";
            case "D":
                return "Kurang";
            case "E":
                return "Sangat Kurang / Gagal";
            default:
                return "Tidak Diketahui";
        }
    }

    // Proses Form Submit
    if (isset($_POST['submit'])) {
        $nama = $_POST['nama'];
        $nilai = $_POST['nilai'];
        $errors = [];

        // 1. Validasi Nama
        if (!isNamaValid($nama)) {
            $errors[] = "Format Nama salah! Nama hanya boleh mengandung HURUF (A-Z) dan spasi.";
        }

        // 2. Validasi Nilai
        if (!isNilaiValid($nilai)) {
            $errors[] = "Format Nilai salah! Nilai hanya boleh mengandung ANGKA (Numeric).";
        }

        if (count($errors) > 0) {
            echo "<div class='error'>";
            foreach ($errors as $error) {
                echo "<p><strong>Error:</strong> $error</p>";
            }
            echo "</div>";
        } else {
            // Validasi berhasil, jalankan konversi
            $nilaiFloat = (float)$nilai;
            if ($nilaiFloat < 0 || $nilaiFloat > 100) {
                echo "<div class='error'><p><strong>Error:</strong> Nilai harus berada dalam rentang 0 hingga 100.</p></div>";
            } else {
                $nilaiHuruf = konversiNilaiKeHuruf($nilaiFloat);
                $predikat = getPredikat($nilaiHuruf);

                echo "<div class='result'>";
                echo "<h3>Hasil Konversi:</h3>";
                echo "<p><strong>Nama Siswa / Mahasiswa:</strong> " . htmlspecialchars($nama) . "</p>";
                echo "<p><strong>Nilai Angka:</strong> " . $nilaiFloat . "</p>";
                echo "<p><strong>Nilai Huruf:</strong> " . $nilaiHuruf . "</p>";
                echo "<p><strong>Predikat:</strong> " . $predikat . "</p>";
                echo "</div>";
            }
        }
    }
    ?>
</body>

</html>