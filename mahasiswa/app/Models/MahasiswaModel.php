<?php
declare(strict_types=1);

namespace App\Models;

class MahasiswaModel
{
    private \PDO $db;
    private string $schema;
    private bool $avatarTableEnsured = false;

    public function __construct(\PDO $db, string $schema = 'mahasiswa')
    {
        $this->db = $db;
        $this->schema = $schema;
    }

    public function login(string $user, string $pass): ?array
    {
        $sql = "SELECT id, username, password FROM {$this->schema}.mahasiswa WHERE username = :username LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':username' => $user]);
        $row = $stmt->fetch();

        if (!$row) {
            return null;
        }

        if (!password_verify($pass, $row['password'])) {
            return null;
        }

        return $row;
    }

    public function getProfile(int $id): ?array
    {
        $this->ensureAvatarTable();

        $sql = "SELECT id, nrp, nama, alamat, ttl, email, nohp, username,
                       avatar.avatar_nama_asli, avatar.avatar_nama_file, avatar.avatar_tipe_file, avatar.avatar_ukuran_file
                FROM {$this->schema}.mahasiswa mahasiswa
                LEFT JOIN {$this->schema}.avatar_user avatar
                    ON avatar.mahasiswa_id = mahasiswa.id
                WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch();

        return $row ?: null;
    }

    public function getAllMahasiswa(): array
    {
        $sql = "SELECT id, nrp, nama FROM {$this->schema}.mahasiswa ORDER BY id ASC";
        $stmt = $this->db->query($sql);

        return $stmt->fetchAll();
    }

    public function isUsernameTaken(string $username): bool
    {
        $sql = "SELECT 1 FROM {$this->schema}.mahasiswa WHERE username = :username LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':username' => $username]);

        return (bool) $stmt->fetchColumn();
    }

    public function register(array $data): bool
    {
        $sql = "INSERT INTO {$this->schema}.mahasiswa (nama, nrp, alamat, ttl, email, nohp, username, password)
                VALUES (:nama, :nrp, :alamat, :ttl, :email, :nohp, :username, :password)";
        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':nama' => $data['nama'],
            ':nrp' => $data['nrp'],
            ':alamat' => $data['alamat'],
            ':ttl' => $data['ttl'],
            ':email' => $data['email'],
            ':nohp' => $data['nohp'],
            ':username' => $data['username'],
            ':password' => $data['password'],
        ]);
    }

    public function saveAvatar(array $data): bool
    {
        $this->ensureAvatarTable();

        $sql = "INSERT INTO {$this->schema}.avatar_user
                    (mahasiswa_id, avatar_nama_asli, avatar_nama_file, avatar_tipe_file, avatar_ukuran_file)
                VALUES
                    (:id, :avatar_nama_asli, :avatar_nama_file, :avatar_tipe_file, :avatar_ukuran_file)
                ON CONFLICT (mahasiswa_id)
                DO UPDATE SET
                    avatar_nama_asli = EXCLUDED.avatar_nama_asli,
                    avatar_nama_file = EXCLUDED.avatar_nama_file,
                    avatar_tipe_file = EXCLUDED.avatar_tipe_file,
                    avatar_ukuran_file = EXCLUDED.avatar_ukuran_file";
        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':id' => $data['id'],
            ':avatar_nama_asli' => $data['avatar_nama_asli'],
            ':avatar_nama_file' => $data['avatar_nama_file'],
            ':avatar_tipe_file' => $data['avatar_tipe_file'],
            ':avatar_ukuran_file' => $data['avatar_ukuran_file'],
        ]);
    }

    public function getAvatarByUser(int $userId): ?array
    {
        $this->ensureAvatarTable();

        $sql = "SELECT mahasiswa.id, mahasiswa.username, mahasiswa.nama,
                       avatar.avatar_nama_asli, avatar.avatar_nama_file, avatar.avatar_tipe_file, avatar.avatar_ukuran_file
                FROM {$this->schema}.mahasiswa mahasiswa
                LEFT JOIN {$this->schema}.avatar_user avatar
                    ON avatar.mahasiswa_id = mahasiswa.id
                WHERE mahasiswa.id = :id
                LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $userId]);
        $row = $stmt->fetch();

        return $row ?: null;
    }

    private function ensureAvatarTable(): void
    {
        if ($this->avatarTableEnsured) {
            return;
        }

        $sql = "CREATE TABLE IF NOT EXISTS {$this->schema}.avatar_user (
                    mahasiswa_id INTEGER PRIMARY KEY REFERENCES {$this->schema}.mahasiswa(id) ON DELETE CASCADE,
                    avatar_nama_asli VARCHAR(255),
                    avatar_nama_file VARCHAR(255),
                    avatar_tipe_file VARCHAR(100),
                    avatar_ukuran_file BIGINT
                )";
        $this->db->exec($sql);
        $this->avatarTableEnsured = true;
    }
}
