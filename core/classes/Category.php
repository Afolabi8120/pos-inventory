<?php

	class Category {

		protected $pdo;

		function __construct($pdo){
			$this->pdo = $pdo;
		}

        // check if category name already exist
		public function checkCategoryName($name){
        	$stmt = $this->pdo->prepare("SELECT name FROM tblcategory WHERE name = :name");
        	$stmt->bindParam(":name", $name, PDO::PARAM_STR);
        	$stmt->execute();

        	$count = $stmt->rowCount();

        	if($count > 0){
				return true;
			}else{
				return false;
			}
        }

        // create category
        public function addCategory($name){
			$stmt = $this->pdo->prepare("INSERT INTO tblcategory (name) VALUES(:name)");
			$stmt->bindParam(":name", $name, PDO::PARAM_STR);
			$stmt->execute();

			return true;
		}

		// update category
        public function updateCategory($cat_id,$name){
			$stmt = $this->pdo->prepare("UPDATE tblcategory SET name = :name WHERE cat_id = :cat_id ");
			$stmt->bindParam(":cat_id", $cat_id, PDO::PARAM_INT);
			$stmt->bindParam(":name", $name, PDO::PARAM_STR);
			$stmt->execute();

			return true;
		}

		// count and group all categories
		public function groupCategory($category_id){
        	$stmt = $this->pdo->prepare("SELECT COUNT(category_id) FROM tblproduct WHERE category_id=:category_id GROUP BY category_id");
        	$stmt->bindParam(":category_id", $category_id, PDO::PARAM_STR);
        	$stmt->execute();

        	$count = $stmt->fetchColumn();

        	if($count > 0){
				return $count;
			}else{
				return "0";
			}
        }
		
	}

?>