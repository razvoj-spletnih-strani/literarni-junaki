<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<script src="https://kit.fontawesome.com/b521da4f42.js" crossorigin="anonymous"></script>
	<link rel="stylesheet" type="text/css" href="junaki.css">
	<title>Slovenski literarni junaki</title>
</head>
<body>

<?php
class Junak{
	private $ime;
	private $vsebina;
	private $uredi;

	function __construct() {
        $this->uredi = false;
    }

	public function set_ime($ime){
		$this->ime = $ime;
	}

	public function set_vsebina($vsebina){
		$this->vsebina = $vsebina;
	}

	public function set_uredi($uredi){
		$this->uredi = $uredi;
	}

	public function get_uredi(){
		return $this->uredi;
	}

	public function open_database_connection(){
		$link=new mysqli("localhost","nrsa","nrsa","nrsa");
		$link->query("SET NAMES 'utf8'");
		return $link;
	}

	public function close_database_connection($link){
		mysqli_close($link);
	}

	public function create(){
		$sporocilo = "Vnos je uspel.";
		
		$ime = strip_tags(trim($this->ime));
    	$vsebina = strip_tags(trim($this->vsebina));

    	if (empty($ime) || empty($vsebina)){
    		$sporocilo = "Niste vnesli vseh polj.";
    	} else {
    		$link=$this->open_database_connection();
    		$sql="INSERT INTO junak (ime, vsebina) VALUES ('$ime','$vsebina')";
    		$rezultat = mysqli_query($link,$sql);
    		$this->close_database_connection($link);
    	}
		return $sporocilo;
	}

	public function read(){
		$junaki = NULL;
		$link=$this->open_database_connection();
		$sql="SELECT id, ime, vsebina FROM junak ORDER BY datum DESC";
		$rezultat = mysqli_query($link,$sql);
		$junaki = mysqli_fetch_all($rezultat,MYSQLI_ASSOC);
		mysqli_free_result($rezultat);
    	
		$this->close_database_connection($link);
		return $junaki;
	}

	public function delete($id){
		$link=$this->open_database_connection();
		$sql="SELECT ime, vsebina FROM junak WHERE id='$id'";
		$rezultat = mysqli_query($link,$sql);
		$st_vrstic=mysqli_num_rows($rezultat);

		try {
			if ($st_vrstic != 1){
			   	throw new Exception("Zapis ne obstaja.");
			} else {
				$sql = "DELETE FROM junak WHERE id='$id'";
				$rezultat = mysqli_query($link,$sql);
			}
		} catch (Exception $e) {
		    echo 'Prišlo je do napake: ' . $e->getMessage();
		} finally{
			$this->close_database_connection($link);
		}
	}

	public function getJunak($id){
		$link=$this->open_database_connection();
		$sql="SELECT id, ime, vsebina FROM junak WHERE id='$id'";
		$rezultat = mysqli_query($link,$sql);

		try {
			$st_vrstic=mysqli_num_rows($rezultat);
			if ($st_vrstic != 1){
			   	throw new Exception("Zapis ne obstaja.");
			} else {
				$vrstica=mysqli_fetch_assoc($rezultat);
				return $vrstica;
			}
		} catch (Exception $e) {
		    echo 'Prišlo je do napake: ' . $e->getMessage();
		} finally {
			$this->close_database_connection($link);
		}
	}

	public function update($id){
		$sporocilo = "Spremembe so shranjene.";
		$ime = strip_tags(trim($this->ime));
    	$vsebina = strip_tags(trim($this->vsebina));

    	if (empty($ime) || empty($vsebina)){
    		$sporocilo = "Niste vnesli vseh polj.";
    	} else {
    		$link=$this->open_database_connection();
    		$sql = "UPDATE junak SET ime='$ime', vsebina='$vsebina' WHERE id='$id'";
    		$rezultat = mysqli_query($link,$sql);

    		$this->close_database_connection($link);
    	}
		
		return $sporocilo;
	}
}

$literarni_junak = new Junak();


if (isset($_GET['opravilo']) && isset($_GET['id'])){
	if ($_GET['opravilo'] == "izbrisi"){
		$literarni_junak->delete($_GET['id']);
		//header('Location: index.php');
	} else if ($_GET['opravilo'] == "uredi"){
		$literarni_junak->set_uredi(true);
		$prispevek = $literarni_junak->getJunak($_GET['id']);
	}
}

if (isset($_POST['potrdi'])){
	$literarni_junak->set_ime($_POST['ime']);
	$literarni_junak->set_vsebina($_POST['vsebina']);

	if(!$literarni_junak->get_uredi()){
		echo $literarni_junak->create();
	} else {
		echo $literarni_junak->update($_GET['id']);
		$literarni_junak->set_uredi(false);
	}
}

?>
<h1>Slovenski literarni junaki</h1>
<form method="POST">
	<label for="ime">Ime</label><br>
	<input type="text" id="ime" name="ime" value="<?php if($literarni_junak->get_uredi()){echo $prispevek['ime'];}?>"><br>
	<label for="vsebina">Vsebina</label><br>
	<textarea id="vsebina" name="vsebina"><?php if($literarni_junak->get_uredi()){echo $prispevek['vsebina'];}?></textarea><br>
	<input type="submit" value="Potrdi" name="potrdi">
</form>

<?php
	foreach($literarni_junak->read() as $zapis){
		echo "<div class='junak'>";
		echo "<p>
				<a href='index.php?opravilo=izbrisi&id=" . $zapis['id'] ."'><i class='far fa-trash-alt'></i></a>
				<a href='index.php?opravilo=uredi&id=" . $zapis['id'] ."'><i class='far fa-edit'></i></a>
			 </p>";
		echo "<h2>" . $zapis['ime'] . "</h2>";
		echo "<p>" . $zapis['vsebina'] . "</p>";
		echo "</div>";
	}
?>
</body>
</html> 