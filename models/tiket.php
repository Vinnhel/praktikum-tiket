<?php
class Tiket {
    private $conn;
    private $table_name = "tiket";

    public $id;
    public $nama_pemesan;
    public $kode_tiket;
    public $tujuan;
    public $tanggal;
    public $harga;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function read() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " (nama_pemesan, kode_tiket, tujuan, tanggal, harga) VALUES (:nama, :kode, :tujuan, :tanggal, :harga)";
        $stmt = $this->conn->prepare($query);

        $this->nama_pemesan = htmlspecialchars(strip_tags($this->nama_pemesan));
        $this->kode_tiket = htmlspecialchars(strip_tags($this->kode_tiket));
        $this->tujuan = htmlspecialchars(strip_tags($this->tujuan));
        $this->tanggal = htmlspecialchars(strip_tags($this->tanggal));
        $this->harga = htmlspecialchars(strip_tags($this->harga));

        $stmt->bindParam(":nama", $this->nama_pemesan);
        $stmt->bindParam(":kode", $this->kode_tiket);
        $stmt->bindParam(":tujuan", $this->tujuan);
        $stmt->bindParam(":tanggal", $this->tanggal);
        $stmt->bindParam(":harga", $this->harga);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function update() {
        $query = "UPDATE " . $this->table_name . " SET nama_pemesan=:nama, kode_tiket=:kode, tujuan=:tujuan, tanggal=:tanggal, harga=:harga WHERE id=:id";
        $stmt = $this->conn->prepare($query);

        $this->nama_pemesan = htmlspecialchars(strip_tags($this->nama_pemesan));
        $this->kode_tiket = htmlspecialchars(strip_tags($this->kode_tiket));
        $this->tujuan = htmlspecialchars(strip_tags($this->tujuan));
        $this->tanggal = htmlspecialchars(strip_tags($this->tanggal));
        $this->harga = htmlspecialchars(strip_tags($this->harga));
        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(":nama", $this->nama_pemesan);
        $stmt->bindParam(":kode", $this->kode_tiket);
        $stmt->bindParam(":tujuan", $this->tujuan);
        $stmt->bindParam(":tanggal", $this->tanggal);
        $stmt->bindParam(":harga", $this->harga);
        $stmt->bindParam(":id", $this->id);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $this->id = htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(1, $this->id);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>