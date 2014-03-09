<?php

Class Db
{
	private $con;

	/*
	 * initlize database connection
	 */
	public function __construct(Array $dbConfig)
	{
		try 
		{
			$this->con = new PDO('mysql:host=' . $dbConfig['host'] . ';dbname=' . $dbConfig['db'] . ';charset=utf8', $dbConfig['user'], $dbConfig['pass'],array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
			//$this->con->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES utf8');
		} 
		catch (PDOException $e)
		{
			echo $e->getMessage();
			exit;
		}
	}

	/*
	 * Executes the passed query
	 *
	 * @q string query with the placeholders for params (:param1)
	 * @params array optionl parameters for the passed query 
	 */
	public function query($q, Array $params = array())
	{
		$stmt = $this->prepare($q);
		return $this->fetch($stmt,$params);
	}

	/*
	 * @return prepared pdo statement object
	 */
	public function prepare($q)
	{
		$stmt = $this->con->prepare($q);
		return $stmt;
	}

	/*
	 * fetch the result as an object
	 */
	public function fetch($stmt,$params =  array())
	{
		try
		{
			$stmt->execute($params);
			$result = $stmt->fetchAll(PDO::FETCH_OBJ);
		}
		catch (PDOException $e)
		{
			echo $e->getMessage();
			exit;
		}

		if (count($result) < 1) return false;

		return $result;
	}

	/*
	 * Executes the passed query
	 *
	 * @q string query with the placeholders for params (:param1)
	 * @params array optionl parameters for the passed query 
	 */
	public function insert($q, Array $params = array())
	{
		$stmt = $this->con->prepare($q);
		try
		{
			$stmt->execute($params);
		}
		catch (PDOException $e)
		{
			echo $e->getMessage();
			exit;
		}

		return true;
	}
}