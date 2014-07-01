<?php

require_once 'Encryption.php';
require_once 'dbconfig.php';

class Database
{
	private $mysqli;
	private $config;

	function __construct()
	{
		global $config;

		$this->mysqli = new mysqli("127.0.0.1", $config['DB_USER'], $config['DB_PASS'], $config['DB_DBNM']);
		if ($this->mysqli->connect_errno) {
			echo "Failed to connect to MySQL: (" . $this->mysqli->connect_errno . ") " . $this->mysqli->connect_error;
		}
	}

	function __destruct()
	{
		$this->mysqli->close();
	}

	public function listBins($count = 30, $skip = 0)
	{
		$bins = array();
		$res = $this->mysqli->query("SELECT * FROM bins LIMIT $count OFFSET $skip;");
		for ($row_no = 0; $row_no < $res->num_rows; $row_no++) {
			$res->data_seek($row_no);
			array_push($bins, $res->fetch_assoc());
		}

		return $bins;
	}

	public function getBin($id)
	{
		$res = $this->mysqli->query("SELECT * FROM bins WHERE id='$id';");
		for ($row_no = 0; $row_no < $res->num_rows; $row_no++) {
			$res->data_seek($row_no);
			return $res->fetch_assoc();
		}

		return null;
	}

	public function getBinByLongID($longID)
	{
		$longID = preg_replace("/[`'\\@=! \\*]/", "", $longID);
		$res = $this->mysqli->query("SELECT * FROM bins WHERE long_id='$longID';");
		for ($row_no = 0; $row_no < $res->num_rows; $row_no++) {
			$res->data_seek($row_no);
			return $res->fetch_assoc();
		}

		return null;
	}

	public function addBin($content, $salt, $longID, $expiration)
	{
		$time = time();
		if ($expiration > 0)
		{
			$expiration = $time+$expiration;
		}
		$stmt = $this->mysqli->prepare("INSERT INTO `bins` (`id`, `content`, `time_creation`, `time_expiration`, `salt`, `long_id`) VALUES (NULL,?,$time,$expiration,'$salt','$longID')");
		$null = NULL;
		$stmt->bind_param("b", $null);
		$stmt->send_long_data(0, $content);
		return $stmt->execute();
	}

	public function deleteBin($id)
	{
		if (is_numeric($id) && $id > 0)
			$this->mysqli->query("DELETE FROM bins WHERE id='$id';");
	}

	public function getBinsCount()
	{
		$res = $this->mysqli->query("SHOW TABLE STATUS LIKE 'bins';");
		for ($row_no = 0; $row_no < $res->num_rows; $row_no++) {
			$res->data_seek($row_no);
			$array = $res->fetch_assoc();
			return $array['Auto_increment'];
		}

		return -1;
	}

	public function deleteExpiredBins()
	{
		$this->mysqli->query("DELETE FROM `bins` WHERE (`time_expiration` > 0) && (`time_expiration` < UNIX_TIMESTAMP());");
	}
}

function runDatabaseCron()
{
	$db = new Database();
	$db->deleteExpiredBins();
}