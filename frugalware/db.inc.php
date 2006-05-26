<?php

# db.inc

// This is a frontend for adodb, i used it to make the database usage more easly

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

	function doConnect()
	{
		// Global variables come from config.inc
		// We use persistent connections - probably fewer connections will be
		global $sqlhost, $sqluser, $sqlpass, $sqldb;
		$res = $this->db->PConnect($sqlhost, $sqluser, $sqlpass, $sqldb);
		$this->db->SetFetchMode(ADODB_FETCH_MODE);
		return $res;
	}

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
			die("Query ".$query." failed with the following error: ".$this->db->ErrorMsg());
		}
		return $result;
	}

	function doClose()
	{
		$this->db->Close();
	}

	function doFetchAssoc($res)
	{
		return $res->GetRows($this->doFetchRow(&$res));
	}

	function doFetchRow($res)
	{
		return $res->FetchRow();
	}

	function doCountRows($res)
	{
		return $res->RecordCount();
	}
}

?>
