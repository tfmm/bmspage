<?php
class SelectList
{
    protected $conn;
 
        public function __construct()
        {
            $this->DbConnect();
        }
 
        protected function DbConnect()
        {
            include "/home/srv/html/bms/includes/db_config.php";
            $this->conn = mysql_connect($servername,$username,$password) OR die("Unable to connect to the database");
            mysql_select_db($db,$this->conn) OR die("can not select the database $db");
            return TRUE;
        }
 
        public function ShowDCs()
        {
            $sql = "SELECT * FROM datacenters ORDER BY dc_name";
            $res = mysql_query($sql,$this->conn);
            $datacenter = '<option value="0">choose...</option>';
            while($row = mysql_fetch_array($res))
            {
                $datacenter .= '<option value="' . $row['dc_id'] . '">' . $row['dc_name'] . '</option>';
            }
            return $datacenter;
        }
 
        public function ShowUnitType()
        {
            $sql = "SELECT * FROM unittypes order by utype_name";
            $res = mysql_query($sql,$this->conn);
            $unittype = '<option value="0">choose...</option>';
            while($row = mysql_fetch_array($res))
            {
                $unittype .= '<option value="' . $row['utype_id'] . '">' . $row['utype_name'] . '</option>';
            }
            return $unittype;
        }

	public function ShowUnits()
	{
	    $sql = "SELECT * FROM units ORDER BY unit_name";
            $res = mysql_query($sql,$this->conn);
            $unit = '<option value="0">choose...</option>';
            while($row = mysql_fetch_array($res))
            {
                $unit .= '<option value="' . $row['unit_id'] . '">' . $row['unit_name'] . '</option>';
            }
            return $unit;
        }

        public function ShowAlerts()
        {
            $sql = "SELECT * FROM alerts ORDER BY alert_name";
            $res = mysql_query($sql,$this->conn);
            $alert = '<option value="0">choose...</option>';
            while($row = mysql_fetch_array($res))
            {
                $alert .= '<option value="' . $row['alert_id'] . '">' . $row['alert_name'] . '</option>';
            }
            return $alert;
        }
}
 
$opt = new SelectList();
?>
