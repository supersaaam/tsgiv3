<?php
class TSGI{
    public $name;
    public $tel;
    public $address;
    public $bday;
    public $nature;
    
    public function set_data(){
        include 'connection.php';
        
        $stmt = $con->prepare('SELECT `InfoID`, `Name`, `TelNumber`, `Address`, `Birthdate`, `Nature` FROM `tbl_tsgi_info` WHERE 1');
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($id, $name, $tel, $address, $bday, $nature);
        $stmt->fetch();
        $stmt->close();
        $con->close();
        
        $this->name = $name;
        $this->tel = $tel;
        $this->address = $address;
        $this->bday = date_format(date_create($bday), "F j, y");
        $this->nature = $nature;
        
    }   
}
?>