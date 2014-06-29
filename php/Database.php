<?php

require_once 'Encryption.php';

class Database
{
	private $mysqli;
	private $config;

	function __construct()
	{
		$this->config['DB_USER'] = "cypher_link";
		$this->config['DB_PASS'] = "jh8phYD86e5m9TZ2";
		$this->config['DB_DBNM'] = "cypher_link";

		$this->mysqli = new mysqli("127.0.0.1", "cypher_link", "jh8phYD86e5m9TZ2", "cypher_link");
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
}