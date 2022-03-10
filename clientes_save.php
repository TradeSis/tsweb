<?php


  // parametros de conexao
  $hostname="sql486.main-hosting.eu";
  $username="u384787522_helio";
  $password="2Et*MNY1oJul";
  $dbname="u384787522_tswebdev";


  
  $dbmy=mysqli_connect($hostname,$username, $password,$dbname);

  $fp = fopen('..\works\save.txt', 'w'); //********** */      //# 1- Modificação!

  fwrite($fp, "conectando mysql=".$dbname."\n");

  if (mysqli_connect_errno())
  {
    fwrite($fp, "Failed to connect to MySQL: " . mysqli_connect_error()."\n");
      echo "Failed to connect to MySQL: " . mysqli_connect_error();
      die ("html>script language='JavaScript'>alert('Unable to connect to database! Please try again later.'),history.go(-1)/script>/html>");
  }


function pegaparam($varname) {
    $v=(isset($_GET[$varname]))?$_GET[$varname]:((isset($_POST[$varname]))?$_POST[$varname]:'');
    //if(!$v) $v = $_SESSION[$varname];
    //else $_SESSION[$varname] = $v;
    return($v);
}

fwrite($fp, "ESTOU AQUI"."\n");
    echo "ESTOU AQUI V2";

  

foreach($_POST as $key => $value)
{
    fwrite($fp, $key . " = " . $value ."\n");
  
 
}



$webix_operation = pegaparam("webix_operation");
fwrite($fp, $webix_operation."\n");

	if($webix_operation=="update"){
      
		$ano=$_POST['ano'];                                                    //# 2- Modificação!
		$mes=$_POST['mes'];                                          //MODIFICAR METODO POST PARA GET!
		$vlrVendas=$_POST['vlrVendas'];
		$qtdVendas=$_POST['qtdVendas'];
		

        $sql = "UPDATE DashServicos SET ano='$ano', mes='$mes', vlrVendas='$vlrVendas', qtdVendas=$qtdVendas";
      /*   if ($tempoPrevisto=='0000-00-00'||$tempoPrevisto=='')
            { $sql .= " NULL ";} 
        else {
            { $sql .= " '$tempoPrevisto' ";} 
        } */
        
      
        
        //$sql .=" WHERE ID=$ID"; //CHAVE PRIMARIA - NUNCA VAI SER ALTERADO!!!! 

        //fwrite($fp,  " tempoPrevisto =  " . $tempoPrevisto ."\n");

		//fwrite($fp,  " SQL " . $sql ."\n");

        if (mysqli_query($dbmy, $sql)) {
			echo json_encode(array("statusCode"=>200));
		} 
		else {
            fwrite($fp,  "Error: " . $sql . "<br>" . mysqli_error($dbmy) ."\n");
			echo "Error: " . $sql . "<br>" . mysqli_error($dbmy);
		}
		
	}

    if($webix_operation=="insert"){                                          //# 3- Modificação!
      
		
		$ano=$_POST['ano'];                                                  
		$mes=$_POST['mes'];                                          
		$vlrVendas=$_POST['vlrVendas'];
		$qtdVendas=$_POST['qtdVendas'];       

        $sql  = "INSERT INTO `DashServico` (`ano`, `mes`, `vlrVendas`, `qtdVendas`)" ;
        $sql .= " VALUES ('$ano', '$mes', '$vlrVendas', '$qtdVendas' )";
        

       
   
        
      
        
		fwrite($fp,  " SQL " . $sql ."\n");

        if (mysqli_query($dbmy, $sql)) {
			echo json_encode(array("statusCode"=>200));
		} 
		else {
            fwrite($fp,  "Error: " . $sql . "<br>" . mysqli_error($dbmy) ."\n");
			echo "Error: " . $sql . "<br>" . mysqli_error($dbmy);
		}
	
	}
	mysqli_close($dbmy);
    fclose($fp);

?>