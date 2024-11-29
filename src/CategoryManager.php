<?php

class CategoryManager {
    private $con;

    public function __construct($con) {
        $this->con = $con;
    }

    public function createCategory($category, $description) {
        $sql = mysqli_prepare($this->con, "INSERT INTO category (categoryName, categoryDescription) VALUES (?, ?)");
        mysqli_stmt_bind_param($sql, 'ss', $category, $description);
        $result = mysqli_stmt_execute($sql);
        mysqli_stmt_close($sql);
        return $result;
    }

    public function deleteCategory($id) {
        $sql = mysqli_prepare($this->con, "DELETE FROM category WHERE id = ?");
        mysqli_stmt_bind_param($sql, 'i', $id);
        $result = mysqli_stmt_execute($sql);
        mysqli_stmt_close($sql);
        return $result;
    }
}

