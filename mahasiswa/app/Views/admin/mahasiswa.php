<h2>Data Mahasiswa</h2>
<table>
    <tr>
        <th>No</th>
        <th>NRP</th>
        <th>Nama</th>
        <th>Aksi</th>
    </tr>
    <?php if (empty($rows)): ?>
        <tr>
            <td colspan="4">Belum ada data.</td>
        </tr>
    <?php else: ?>
        <?php $no = 1; ?>
        <?php foreach ($rows as $row): ?>
            <tr>
                <td><?php echo $no++; ?></td>
                <td><?php echo htmlspecialchars($row['nrp'] ?? ''); ?></td>
                <td><?php echo htmlspecialchars($row['nama'] ?? ''); ?></td>
                <td><a href="index.php?route=profile&id=<?php echo (int) $row['id']; ?>">Detail</a></td>
            </tr>
        <?php endforeach; ?>
    <?php endif; ?>
</table>
