<?php
/**
 * Class ReadRolYmlFile for read the YML file to format PHP
 *
 * @author Carlos Belisario 
 */
class ReadRolYmlFile extends SplFileObject
{
    /**
     *
     * @var file 
     */
    private $file;
    
    /**
     *
     * @param string $file 
     * @override
     */
    public function __construct($file)
    {
        parent::__construct($file);
    }
    
    public function readFile()
    {
        if($this->isFile()) {
            $this->file = $this->openFile();            
            //$arrayFile = array()            
            while(!$this->eof()) {
                if($this->key() == 0) {
                    $f = $this->fgets();
                } else {
                    $f .= $this->fgets();
                }
                $this->next();
            }
            $arrayFile = explode('typeUser:', $f);
            foreach($arrayFile as $value) {
                if(!empty($value)) {
                    $typeUser[] = explode('rol:', $value);
                }
            }           
            foreach ($typeUser as $k => $v) {
                $roles[trim($v[0])] = explode('-', $v[1]);
            }
           return $roles;
        } else {
            die('the file not found');
        }
    }    
}
$y  = new ReadRolYmlFile('roles.yml');
echo "<pre>"; 
print_r($y->readFile());
echo "</pre>";