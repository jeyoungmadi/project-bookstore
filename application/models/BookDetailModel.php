<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BookDetailModel extends CI_Model {

	public function index()
	{
		$books = array();
		$this->db->select('book_ID, bookName');
	

		$query = $this->db->get('book');

		if ($query->num_rows() > 0)
		{
			foreach($query->result() as $row) 
			{
				$books[$row->id] = $row->name;
			}
		}
		return $books;
	}

	public function get_book($book_id)
	{
		$query = $this->db->query("SELECT b.book_ID, b.bookName, b.bookPrice, b.bookDetail, b.bookImageCover, b.bookDateImp, p.publisherName
									FROM book b NATURAL JOIN publisher p
									WHERE book_ID = '$book_id'");
			
		return  $query->result_array();	
	}

	public function check_book($user_id, $book_id)
	{
		$query = $this->db->query("SELECT book_ID, user_ID
									FROM purchased
									WHERE user_ID = '$user_id' AND book_ID = '$book_id'");
		return  $query->result_array();
	}
	
	public function get_score($book_id){
		$query = $this->db->query("SELECT r.reviewScore, r.reviewComment, r.reviewDateTime, r.user_ID, u.ReaderFname, u.ReaderLname
									FROM review r INNER JOIN reader u ON r.user_ID = u.user_ID
									WHERE r.book_ID = '$book_id' ORDER BY r.reviewDateTime DESC");
		return  $query->result_array();
	}

	public function buy_book($user_id, $book_id, $book_price, $user_cash){

		$date = date("Y-m-d H:i:s");
		$data = array(
			'book_ID' => $book_id,			
			'user_ID' => $user_id,
			'purchasedDateTime' => $date,
			'purchasedPrice' => $book_price
		);
		$this->db->insert('purchased',$data);

		$tempCash = $user_cash - $book_price;
		$data = array(
			'ReaderCash' => $tempCash,
		);
		$this->db->where('user_ID', $user_id);
		$this->db->update('reader', $data);

		return $tempCash;
	}

	public function update_session($cash){
		$session_data = $this->session->userdata('loged_in');
		$sess_array = array(
			'userid' => $session_data['userid'],
			'fName' => $session_data['fName'],
			'lName' => $session_data['lName'],
			'cash' => $cash
		);
		$this->session->set_userdata('loged_in',$sess_array);
	}
}

