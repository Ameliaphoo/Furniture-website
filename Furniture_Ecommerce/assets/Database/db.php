<?php 
class Connection
{
    private $host;
    private $dbname;
    private $user;
    private $password;

    function __construct($host,$dbname,$user,$password)
{
    $this->host=$host;
    $this->dbname=$dbname;
    $this->user=$user;
    $this->password=$password;
    
}

function getConnection() 
    {
        try {
        $pdo = new PDO(
             "mysql:host=$this->host;
             dbname=$this->dbname;",
            $this->user, $this->password);

             $pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
            return $pdo;

        } catch( Exception $e ) {
        echo $e->getMessage();
        return null;
        }
    }

}
?>