<?php
class SubCategoryManager {
    private $con;

    public function __construct($con) {
        $this->con = $con;
    }

    public function createSubCategory($categoryId, $subCategoryName) {
        $sql = $this->con->prepare("INSERT INTO subcategory (categoryid, subcategory) VALUES (?, ?)");
        $sql->bind_param('is', $categoryId, $subCategoryName);
        $result = $sql->execute();
        $sql->close();
        return $result;
    }

    public function updateSubCategory($subCategoryId, $categoryId, $subCategoryName) {
        $currentTime = date('Y-m-d H:i:s');
        $sql = $this->con->prepare("UPDATE subcategory SET categoryid = ?, subcategory = ?, updationDate = ? WHERE id = ?");
        $sql->bind_param('issi', $categoryId, $subCategoryName, $currentTime, $subCategoryId);
        $result = $sql->execute();
        $sql->close();
        return $result;
    }

    public function getSubCategoryById($id) {
        $sql = $this->con->prepare("SELECT * FROM subcategory WHERE id = ?");
        $sql->bind_param('i', $id);
        $sql->execute();
        $result = $sql->get_result();
        return $result->fetch_assoc();
    }
}
