<?php
class PromotionModel extends CI_Model {
	   
	   function __construct() {
                parent::__construct(); 
        }

        public function get() {
            $date =  date('Y-m-d');
            $query = $this->db->query("SELECT p.promotion_ID, p.proName, p.proDateStart, p.proDateStop, 
                                        p.proDiscount, b.book_ID, b.bookName, b.bookPrice, b.bookImageCover, 
                                        pub.publisherName 
                                        FROM (promotion p NATURAL JOIN book b) NATURAL JOIN publisher pub
                                        WHERE p.proDateStop >= '$date'"); 
            return $query->result_array(); 
        }
        public function get_score($book_id){
            $query = $this->db->query("SELECT (SUM(reviewScore)*5) / (COUNT(user_ID)*5) AS sum_score
                                            FROM review
                                            WHERE book_ID = '$book_id'");
            return  $query->result_array();
        }
}?>