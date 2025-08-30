<?php
class UsuarioModel {
    private $pdo;
    private $table = "tb_usuarios"; 

    // Constructor recibe la conexión PDO
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Crear usuario
    public function create($data) {
        $sql = "INSERT INTO {$this->table} 
                (nombres, email, password_user, id_rol, fyh_creacion)
                VALUES (:nombres, :email, :password_user, :id_rol, NOW())";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ":nombres"       => $data["nombres"],
            ":email"         => $data["email"],
            ":password_user" => password_hash($data["password_user"], PASSWORD_DEFAULT),
            ":id_rol"        => $data["id_rol"]
        ]);
    }

    //  Leer todos los usuarios (con su rol)
    public function readAll() {
        $sql = "SELECT u.id_usuario, u.nombres, u.email, r.rol
                FROM tb_usuarios u
                INNER JOIN tb_roles r ON u.id_rol = r.id_rol
                ORDER BY u.id_usuario DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener usuario por ID
    public function readOne($id) {
        $sql = "SELECT u.id_usuario, u.nombres, u.email, r.rol
                FROM usuarios u
                INNER JOIN roles r ON u.id_rol = r.id_rol
                WHERE u.id_usuario = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Actualizar usuario
    public function update($id, $data) {
        $sql = "UPDATE {$this->table} 
                SET nombres = :nombres, 
                    email = :email, 
                    id_rol = :id_rol, 
                    fyh_actualizacion = NOW()";

        // Si se envía una nueva contraseña, la actualizamos
        if (!empty($data["password_user"])) {
            $sql .= ", password_user = :password_user";
        }

        $sql .= " WHERE id_usuario = :id";

        $stmt = $this->pdo->prepare($sql);

        $params = [
            ":nombres" => $data["nombres"],
            ":email"   => $data["email"],
            ":id_rol"  => $data["id_rol"],
            ":id"      => $id
        ];

        if (!empty($data["password_user"])) {
            $params[":password_user"] = password_hash($data["password_user"], PASSWORD_DEFAULT);
        }

        return $stmt->execute($params);
    }

    // Eliminar usuario (físico)
    public function delete($id) {
        $sql = "DELETE FROM {$this->table} WHERE id_usuario = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([":id" => $id]);
    }
}
