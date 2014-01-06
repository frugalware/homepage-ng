<?php
/**
 This program is free software; you can redistribute it and/or modify
 it under the terms of the GNU General Public License v2 as published by
 the Free Software Foundation

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.See the
 GNU General Public License for more details.
 */

/**
 * Frontent for adodb, to make the database usage more easy
 *
 * @author Krisztian VASAS <iron@frugalware.org>
 * @copyright Copyright (c) 2006, Krisztian VASAS
 */

if (defined("db.inc"))
	return;
define("db.inc", 1);

require_once($adodb_path."/adodb/adodb.inc.php");

class FwDB
{
	var $db;

	function FwDB ()
	{
		// the $sqltype comes from config.inc.php
		global $sqltype;
		$this->db = &ADONewConnection($sqltype);
	}

	/**
	 * Transfers undefined array element to an empty element
	 *
	 * @param array $arr
	 * @return array
	 */
	function dbUndefToEmpty($arr)
	{
		if (is_array($arr))
		{
			$c = count($arr);

			for($i=0; $i<$c; $i++)
			{
				if (!isset($arr[$i]))
				{
					$arr[$i] = '';
				}
				// This line safely escapes sql before it goes to the db
				$this->db->qmagic($arr[$i]);
			}
		}
		return $arr;
	}

	/**
	 * Database connection
	 */
	function doConnect($sqlhost, $sqluser, $sqlpass, $sqldb)
	{
		// Global variables come from config.inc.php
		// We use persistent connections - probably fewer connections will be
		$res = $this->db->PConnect($sqlhost, $sqluser, $sqlpass, $sqldb);
		$this->db->SetFetchMode(ADODB_FETCH_MODE);
		return $res;
	}

	/**
	 * SQL query
	 *
	 * @param string $query
	 * @param array $inputarr
	 * @param integer $numrows
	 * @param integer $offset
	 * @return integer?
	 */
	function doQuery($query, $inputarr=false, $numrows=-1, $offset=-1)
	{
		$inputarr = $this->dbUndefToEmpty($inputarr);
		$ADODB_FETCH_MODE = ADODB_FETCH_ASSOC;
		if (($numrows>=0) or ($offset>=0))
		{
			$result =  $this->db->SelectLimit($query, $numrows, $offset, $inputarr);
		}
		else
		{
			$result =  $this->db->Execute($query, $inputarr);
		}
		if (!$result)
		{
			$result = -1;
		}
		return $result;
	}

	/**
	 * Database connection close
	 */
	function doClose()
	{
		$this->db->Close();
	}

	/**
	 * Fetch the result of the query into an associative array
	 *
	 * @param integer? $res
	 * @return array
	 */
	function doFetchAssoc($res)
	{
		return $res->GetRows($this->doFetchRow(&$res));
	}

	/**
	 * Fetch the result of the query into a normal array
	 *
	 * @param integer? $res
	 * @return array
	 */
	function doFetchRow($res)
	{
		return $res->FetchRow();
	}

	/**
	 * The number of the lines of the query's result
	 *
	 * @param integer? $res
	 * @return integer
	 */
	function doCountRows($res)
	{
		return $res->RecordCount();
	}
}

?>
