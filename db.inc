<?php

# db.inc

require_once("adodb/adodb.inc.php");

class FwDB ()
{
	var $db = "";

	function FwDB ()
	{
		$this->db = new NewADOConnection($sqltype);
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
				$this->dblink->qmagic($arr[$i]);
			}
		}
		return $arr;
	}


	function Connect()
	{
		$res = $this->db->Connect($sqlhost, $sqluser, $sqlpass, $sqldb);
		$this->db->SetFetchMode(ADODB_FETCH_MODE);
		return $res;
	}

	function doQuery($query, $inputarr=false, $numrows=-1, $offset=-1)
	{
		$inputarr = $this->dbUndefToEmpty($inputarr);
		$ADODB_FETCH_MODE = ADODB_FETCH_ASSOC;
		if (($numrows>=0) or ($offset>=0))
		{
			$result =  $this->dblink->SelectLimit($sql, $numrows, $offset, $inputarr);
		}
		else
		{
			$result =  $this->dblink->Execute($sql, $inputarr);
		}
		if (!$result)
		{
			die("Query ".$sql." failed with the following error: ".$this->dblink->ErrorMsg());
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