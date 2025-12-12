<!DOCTYPE html>
<html lang="id">
<head>
    <title>Hasil Perhitungan TOPSIS</title>
    <style>
        body { font-family: sans-serif; padding: 20px; }
        table { border-collapse: collapse; width: 100%; margin-bottom: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: center; }
        th { background-color: #e0f7fa; }
        h3 { margin-top: 30px; border-bottom: 2px solid #333; display: inline-block; }
    </style>
</head>
<body>
    <h2>Hasil Perhitungan TOPSIS</h2>
    <a href="index.php">Kembali ke Data Awal</a>

<?php
include 'koneksi.php';

// --- KONFIGURASI BOBOT DAN KRITERIA ---
// Bobot: C1=5, C2=4, C3=3
$bobot = [5, 4, 3]; 
// Status: C1=Benefit, C2=Benefit, C3=Cost
$atribut = ['benefit', 'benefit', 'cost']; 

// --- AMBIL DATA DARI DATABASE ---
$data = [];
$nama = [];
$sql = mysqli_query($koneksi, "SELECT * FROM website");
while($row = mysqli_fetch_assoc($sql)){
    $nama[] = $row['nama_mahasiswa'];
    // Masukkan nilai kriteria ke array matriks
    $data[] = [$row['c1'], $row['c2'], $row['c3']];
}

// JIKA DATA KOSONG
if(count($data) == 0) { echo "<p>Data kosong.</p>"; exit; }

// --- LANGKAH 1: NORMALISASI ---
// Menghitung pembagi (akar dari jumlah kuadrat setiap kolom)
$pembagi = [0, 0, 0];
foreach($data as $row){
    for($i=0; $i<3; $i++){
        $pembagi[$i] += pow($row[$i], 2);
    }
}
for($i=0; $i<3; $i++){
    $pembagi[$i] = sqrt($pembagi[$i]);
}

// Matriks Ternormalisasi (R)
$R = [];
foreach($data as $row){
    $temp = [];
    for($i=0; $i<3; $i++){
        $temp[] = $row[$i] / $pembagi[$i];
    }
    $R[] = $temp;
}

// --- LANGKAH 2: NORMALISASI TERBOBOT (Y) ---
$Y = [];
foreach($R as $row){
    $temp = [];
    for($i=0; $i<3; $i++){
        $temp[] = $row[$i] * $bobot[$i];
    }
    $Y[] = $temp;
}

// --- LANGKAH 3: SOLUSI IDEAL POSITIF (A+) DAN NEGATIF (A-) ---
$A_plus = [];
$A_min = [];

for($i=0; $i<3; $i++){
    $col = array_column($Y, $i); // Ambil satu kolom
    if($atribut[$i] == 'benefit'){
        $A_plus[$i] = max($col);
        $A_min[$i] = min($col);
    } else { // Jika Cost
        $A_plus[$i] = min($col); // Cost terendah adalah ideal positif
        $A_min[$i] = max($col);  // Cost tertinggi adalah ideal negatif
    }
}

// --- LANGKAH 4: JARAK SOLUSI IDEAL (D+ dan D-) ---
$D_plus = [];
$D_min = [];
$V = []; // Nilai Preferensi

foreach($Y as $key => $row){
    $sum_plus = 0;
    $sum_min = 0;
    for($i=0; $i<3; $i++){
        $sum_plus += pow($row[$i] - $A_plus[$i], 2);
        $sum_min += pow($row[$i] - $A_min[$i], 2);
    }
    $D_plus[] = sqrt($sum_plus);
    $D_min[] = sqrt($sum_min);
    
    // --- LANGKAH 5: NILAI PREFERENSI (V) ---
    // Rumus: V = D- / (D- + D+)
    // Mencegah pembagian dengan nol
    $div = ($D_min[$key] + $D_plus[$key]); 
    $V[$key] = $div == 0 ? 0 : $D_min[$key] / $div;
}

// Gabungkan Nama dengan Nilai V untuk Perankingan
$hasil_akhir = [];
foreach($nama as $key => $val){
    $hasil_akhir[] = ['nama' => $val, 'nilai' => $V[$key]];
}

// Urutkan dari nilai tertinggi ke terendah (Ranking)
usort($hasil_akhir, function($a, $b) {
    return $b['nilai'] <=> $a['nilai'];
});

?>

    <h3>Perankingan Website Terbaik</h3>
    <table>
        <thead>
            <tr>
                <th>Ranking</th>
                <th>Nama Mahasiswa</th>
                <th>Nilai Preferensi (V)</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $rank = 1;
            foreach($hasil_akhir as $h): ?>
            <tr style="<?php echo ($rank==1)?'background-color:#d4edda; font-weight:bold;':''; ?>">
                <td><?php echo $rank++; ?></td>
                <td><?php echo $h['nama']; ?></td>
                <td><?php echo number_format($h['nilai'], 4); ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</body>
</html>