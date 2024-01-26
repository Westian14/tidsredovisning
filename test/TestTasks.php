<?php

declare (strict_types=1);
require_once __DIR__ . '/../src/tasks.php';

/**
 * Funktion för att testa alla aktiviteter
 * @return string html-sträng med resultatet av alla tester
 */
function allaTaskTester(): string {
// Kom ihåg att lägga till alla testfunktioner
    $retur = "<h1>Testar alla uppgiftsfunktioner</h1>";
    $retur .= test_HamtaEnUppgift();
    $retur .= test_HamtaUppgifterSida();
    $retur .= test_RaderaUppgift();
    $retur .= test_SparaUppgift();
    $retur .= test_UppdateraUppgifter();
    return $retur;
}

/**
 * Tester för funktionen hämta uppgifter för ett angivet sidnummer
 * @return string html-sträng med alla resultat för testerna 
 */
function test_HamtaUppgifterSida(): string {
    $retur="<h2>test_HamtaUppgfiterSida</h2>";
    try {
    //Misslyckas med att hämta sida -1
    $svar=hamtaSida("-1");
    if($svar->getStatus()===400) {
        $retur .="<p class='ok'>Misslyckades med att hämta sida -1, som förväntat</p>";
    }
    else {
        $retur .="<p class='error'>Misslyckades med att hämta sida -1<br>"
        . $svar->getStatus() . " returnerades istället</p>";
    }

    //Misslyckas med att hämta sida 0
    $svar=hamtaSida("0");
    if($svar->getStatus()===400) {
        $retur .="<p class='ok'>Misslyckades med att hämta sida 0, som förväntat</p>";
    }
    else {
        $retur .="<p class='error'>Misslyckades med att hämta sida 0<br>"
        . $svar->getStatus() . " returnerades istället</p>";
    }

    //Misslyckas med att hämta sida sju
    $svar=hamtaSida("sju");
    if($svar->getStatus()===400) {
        $retur .="<p class='ok'>Misslyckades med att hämta sida sju, som förväntat</p>";
    }
    else {
        $retur .="<p class='error'>Misslyckades med att hämta sida <i>sju<i><br>"
        . $svar->getStatus() . " returnerades istället</p>";
    }

    //Lyckas med att hämta sida 1
    $svar=hamtaSida("1",2);
    if($svar->getStatus()===200) {
        $retur .="<p class='ok'>Lyckades med att hämta sida 1</p>";
        $sista=$svar->getContent()->pages;
    }
    else {
        $retur .="<p class='error'>Misslyckades med att hämta sida 1<br>"
        . $svar->getStatus() . " returnerades istället för förväntat 200</p>";
    }

    //Misslyckas med att hämta sida > antal sidor
    if(isset($sista)) {
        $sista++;
        $svar=hamtaSida("$sista",2);
        if($svar->getStatus()===400) {
            $retur .="<p class='ok'>Misslyckades med att hämta sida > antal sidor</p>";
        }
        else {
            $retur .="<p class='error'>Misslyckat test att hämta sida > antal sidor<br>"
            . $svar->getStatus() . " returnerades istället för förväntat 200</p>";
        }
    }

    } 
    catch (Exception $ex) {
        $retur .= "<p class='error'>Något gick fel, meddelandet säger:<br> {$ex->getMessage()}</p>";
    }

    return $retur;
}

/**
 * Test för funktionen hämta uppgifter mellan angivna datum
 * @return string html-sträng med alla resultat för testerna
 */
function test_HamtaAllaUppgifterDatum(): string {
    $retur = "<h2>test_HamtaAllaUppgifterDatum</h2>";
    try {
        //Misslyckas med från=igår till=2024-01-01
        $svar=hamtaDatum("igår", "2024-01-01");
        if($svar->getStatus()===400) {
            $retur .="<p class='ok'>Misslyckades med att hämta poster mellan <i>igår</i> och 2024-01-01</p>";
        }
        else {
            $retur .="<p class='error'>Misslyckat test med att hämta poster mellan <i>igår</i> och 2024-01-01<br>"
            . $svar->getStatus() . " returnerades istället för förväntat 400</p>";
        }

        //Misslyckas med från 2024-01-01 till=imorgon
        $svar=hamtaDatum("2024-01-01", "imorgon");
        if($svar->getStatus()===400) {
            $retur .="<p class='ok'>Misslyckades med att hämta poster mellan 2024-01-01 och <i>imorgon</i></p>";
        }
        else {
            $retur .="<p class='error'>Misslyckat test med att hämta poster mellan 2024-01-01 och <i>imorgon</i><br>"
            . $svar->getStatus() . " returnerades istället för förväntat 400</p>";
        }

        //Misslyckas med från=2024-12-37 till=2024-01-01
        $svar=hamtaDatum("2024-12-37", "2024-01-01");
        if($svar->getStatus()===400) {
            $retur .="<p class='ok'>Misslyckades med att hämta poster mellan 2024-12-37 och 2024-01-01</p>";
        }
        else {
            $retur .="<p class='error'>Misslyckat test med att hämta poster mellan 2024-12-37 och 2024-01-01<br>"
            . $svar->getStatus() . " returnerades istället för förväntat 400</p>";
        }

        //Misslyckas med från=2024-01-01 till=2024-12-37
        $svar=hamtaDatum("2024-01-01", "2024-12-37");
        if($svar->getStatus()===400) {
            $retur .="<p class='ok'>Misslyckades med att hämta poster mellan 2024-01-01 och 2024-12-37</p>";
        }
        else {
            $retur .="<p class='error'>Misslyckat test med att hämta poster mellan 2024-01-01 och 2024-12-37<br>"
            . $svar->getStatus() . " returnerades istället för förväntat 400</p>";
        }

        //Misslyckas med från=2024-01-01 till=2023-01-01
        $svar=hamtaDatum("2024-01-01", "2023-01-01");
        if($svar->getStatus()===400) {
            $retur .="<p class='ok'>Misslyckades med att hämta poster mellan 2024-01-01 och 2023-01-01</p>";
        }
        else {
            $retur .="<p class='error'>Misslyckat test med att hämta poster mellan 2024-01-01 och 2023-01-01<br>"
            . $svar->getStatus() . " returnerades istället för förväntat 400</p>";
        }

        //Lyckas med korrekta datum

        //Leta upp en månad med poster
        $db=connectDb();
        $stmt=$db->query("SELECT YEAR(Datum), MONTH(Datum), COUNT(*) AS antal "
            . "FROM uppgifter "
            . "GROUP BY YEAR(Datum), MONTH(Datum) "
            . "ORDER BY antal DESC "
            . "LIMIT 0,1");
        $row=$stmt->fetch();
        $ar=$row[0];
        $manad=substr("0$row[1]",-2);
        $antal=$row[2];

        //Hämta alla poster från den månaden
        $svar=hamtaDatum("$ar-$manad-01", date("Y-m-d", strtotime("Last day of $ar-$manad")));
        if($svar->getStatus()===200 && count($svar->getContent()->tasks)===$antal) {
            $retur .="<p class='ok'>Lyckades med att hämta $antal poster för månad $ar-$manad</p>";
        }
        else {
            $retur .="<p class='error'>Misslyckades med att hämta poster för $ar-$manad<br>"
            . $svar->getStatus() . " returnerades istället för förväntat 200<br>"
            . print_r($svar->getContent(), true) . "</p>";
        }

    } catch (Exception $ex) {
        $retur .= "<p class='error'>Något gick fel, meddelandet säger:<br> {$ex->getMessage()}</p>";
    }

    return $retur;
}

/**
 * Test av funktionen hämta enskild uppgift
 * @return string html-sträng med alla resultat för testerna
 */
function test_HamtaEnUppgift(): string {
    $retur = "<h2>test_HamtaEnUppgift</h2>";

    try {
        //Misslyckas med att hämta id=0
        $svar=hamtaEnskildUppgift("0");
        if($svar->getStatus()===400) {
            $retur .="<p class='ok'>Misslyckades hämta uppgift med id=0 misslyckades, som förväntat</p>";
        }
        else {
            $retur .="<p class'error'>Misslyckades med att hämta uppgift med id=0<br>" 
            . $svar->getStatus() . " returnerades istället för förväntat 400"
            . print_r($svar->getContent(), true) . "</p>";
        }

        //Misslyckas med att hämta id=sju
        $svar=hamtaEnskildUppgift("sju");
        if($svar->getStatus()===400) {
            $retur .="<p class='ok'>Misslyckades hämta uppgift med id=sju misslyckades, som förväntat</p>";
        }
        else {
            $retur .="<p class'error'>Misslyckades med att hämta uppgift med id=sju<br>" 
            . $svar->getStatus() . " returnerades istället för förväntat 400"
            . print_r($svar->getContent(), true) . "</p>";
        }

        //Misslyckas med att hämta id=3.14
        $svar=hamtaEnskildUppgift("3.14");
        if($svar->getStatus()===400) {
            $retur .="<p class='ok'>Misslyckades hämta uppgift med id=3.14 misslyckades, som förväntat</p>";
        }
        else {
            $retur .="<p class'error'>Misslyckades med att hämta uppgift med id=3.14<br>" 
            . $svar->getStatus() . " returnerades istället för förväntat 400"
            . print_r($svar->getContent(), true) . "</p>";
        }

        //Koppla databas, starta transaktion
        $db=connectDb();
        $db->beginTransaction();

        //Skapa post
        $content=hamtaAllaAktiviteter()->getContent();
        $aktiviteter=$content["activities"];
        $aktivitetId=$aktiviteter[0]->id;
        $postData=["date"=>date("Y-m-d"), 
            "time"=>"01:00",
            "description"=>"Testpost",
            "activityId"=>"$aktivitetId"];
        $svar=sparaNyUppgift($postData);
        $taskId=$svar->getContent()->id;

        //Lyckas med att hämta nyss skapad post
        $svar=hamtaEnskildUppgift("$taskId");
        if($svar->getStatus()===200) {
            $retur .="<p class='ok'>Lyckades med att hämta en uppgift</p>";
        }
        else {
            $retur .="<p class'error'>Misslyckades med att hämta nyskapad uppgift<br>" 
            . $svar->getStatus() . " returnerades istället för förväntat 200"
            . print_r($svar->getContent(), true) . "</p>";
        }

        //Misslyckas med att hämta id som inte finns
        $taskId++;
        $svar=hamtaEnskildUppgift("$taskId");
        if($svar->getStatus()===400) {
            $retur .="<p class='ok'>Misslyckades med att hämta uppgift med id som inte finns, som förväntat</p>";
        }
        else {
            $retur .="<p class='error'>Misslyckades med att hämta uppgift med id som inte finns<br>" 
            . $svar->getStatus() . " returnerades istället för förväntat 400"
            . print_r($svar->getContent(), true) . "</p>";
        }

    } catch (Exception $ex) {
        $retur .= "<p class='error'>Något gick fel, meddelandet säger:<br> {$ex->getMessage()}</p>";
    }
    finally {
        if($db) {
            $db->rollBack();
        }
    }

    return $retur;
}

/**
 * Test för funktionen spara uppgift
 * @return string html-sträng med alla resultat för testerna
 */
function test_SparaUppgift(): string {
    $retur = "<h2>test_SparaUppgift</h2>";

    try {
        //Koppla till databas och starta transaction
        $db=connectDb();
        $db->beginTransaction();

        //Misslyckas med att spara pga saknad AktivitetID
        $postData=["time"=>"01:00"
            , "date"=>"2023-12-31"
            , "description"=>"Detta är en uppgift"];
        
        $svar=sparaNyUppgift($postData);
        if($svar->getStatus()===400) {
            $retur .="<p class='ok'>Misslyckades med att spara post utan AktivitetID, som förväntat</p>";
        }
        else {
            $retur .="<p class='error'>Misslyckades med att spara post utan AktivitetID<br>"
            . $svar->getStatus() . " returnerades istället för förväntat 400<br>"
            . print_r($svar->getContent(), true) . "</p>";
        }

        //Lyckas med att spara post utan beskrivning

        //Förbered data
        $content=hamtaAllaAktiviteter()->getContent();
        $aktiviteter=$content["activities"];
        $aktivitetId=$aktiviteter[0]->id;
        $postData=["time"=>"01:00"
            , "date"=>"2023-12-31"
            , "activityId"=>"$aktivitetId"];

        //Testa
        $svar=sparaNyUppgift($postData);
        if($svar->getStatus()===200) {
            $retur .="<p class='ok'>Lyckades med att spara post utan beskrivning, som förväntat</p>";
        }
        else {
            $retur .="<p class='error'>Misslyckades med att spara post utan beskrivning<br>"
            . $svar->getStatus() . " returnerades istället för förväntat 200<br>"
            . print_r($svar->getContent(), true) . "</p>";
        }

        //Lyckas med att spara post med alla uppgifter
        $postData=["time"=>"01:00"
            , "date"=>"2023-12-31"
            , "description"=>"Detta är en uppgift"
            , "activityId"=>"$aktivitetId"];
        
        $svar=sparaNyUppgift($postData);
        if($svar->getStatus()===200) {
            $retur .="<p class='ok'>Lyckades med att spara post med alla uppgifter</p>";
        }
        else {
            $retur .="<p class='error'>Misslyckades med att spara post med alla uppgifter<br>"
            . $svar->getStatus() . " returnerades istället för förväntat 200<br>"
            . print_r($svar->getContent(), true) . "</p>";
        }

    } catch (Exception $ex) {
        $retur .= "<p class='error'>Något gick fel, meddelandet säger:<br> {$ex->getMessage()}</p>";
    }   
    finally {
        if($db) {
            $db->rollBack();
        }
    }

    return $retur;
}

/**
 * Test för funktionen uppdatera befintlig uppgift
 * @return string html-sträng med alla resultat för testerna
 */
function test_UppdateraUppgifter(): string {
    $retur = "<h2>test_UppdateraUppgifter</h2>";

    try {
        $retur .= "<p class='error'>Inga tester implementerade</p>";
    } catch (Exception $ex) {
        $retur .= "<p class='error'>Något gick fel, meddelandet säger:<br> {$ex->getMessage()}</p>";
    }

    return $retur;
}

function test_KontrolleraIndata(): string {
    $retur = "<h2>test_KontrolleraIndata</h2>";

    try {
        //Kontrollera datum
        $content=hamtaAllaAktiviteter()->getContent();
        $aktiviteter=$content["activities"];
        $aktivitetId=$aktiviteter[0]->id;

        $postData=["time"=>"01:00"
            , "date"=>"imorgon"
            , "activityId"=>"$aktivitetId"];
        $svar=kontrolleraIndata($postData);
        $numFel=count($svar);
        if($numFel===1) {
            $retur .="<p class='ok'>Kontroll av ogiltigt angivet datum lyckades</p>";
        }
        else {
            $retur .="<p class='error'>Kontroll av ogiltigt angivet datum misslyckades<br>"
            . $numFel . " stycken fel returnerades istället för förväntat 1</p>";
        }

        $content=hamtaAllaAktiviteter()->getContent();
        $aktiviteter=$content["activities"];
        $aktivitetId=$aktiviteter[0]->id;

        $postData=["time"=>"01:00"
            , "date"=>"2024/1/1"
            , "activityId"=>"$aktivitetId"];
        $svar=kontrolleraIndata($postData);
        $numFel=count($svar);
        if($numFel===1) {
            $retur .="<p class='ok'>Kontroll av felaktigt formaterat datum lyckades</p>";
        }
        else {
            $retur .="<p class='error'>Kontroll av felaktigt formaterat datum misslyckades<br>"
            . $numFel . " stycken fel returnerades istället för förväntat 1</p>";
        }

        $content=hamtaAllaAktiviteter()->getContent();
        $aktiviteter=$content["activities"];
        $aktivitetId=$aktiviteter[0]->id;

        $nextDay=date('Y-m-d', strtotime(date("Y-m-d"). ' +1 day'));

        $postData=["time"=>"01:00"
            , "date"=>"$nextDay"
            , "activityId"=>"$aktivitetId"];
        $svar=kontrolleraIndata($postData);
        $numFel=count($svar);
        if($numFel===1) {
            $retur .="<p class='ok'>Kontroll av datum framåt i tiden lyckades</p>";
        }
        else {
            $retur .="<p class='error'>Kontroll av datum framåt i tiden misslyckades<br>"
            . $numFel . " stycken fel returnerades istället för förväntat 1</p>";
        }

        //Kontrollera tid
        $postData=["time"=>"entimme"
            , "date"=>"2024-01-01"
            , "activityId"=>"$aktivitetId"];
        $svar=kontrolleraIndata($postData);
        $numFel=count($svar);
        if($numFel===1) {
            $retur .="<p class='ok'>Kontroll av ogiltigt angiven tid lyckades</p>";
        }
        else {
            $retur .="<p class='error'>Kontroll av ogiltigt angiven tid misslyckades<br>"
            . $numFel . " stycken fel returnerades istället för förväntat 1</p>";
        }

        $postData=["time"=>"01:00:00"
            , "date"=>"2024-01-01"
            , "activityId"=>"$aktivitetId"];
        $svar=kontrolleraIndata($postData);
        $numFel=count($svar);
        if($numFel===1) {
            $retur .="<p class='ok'>Kontroll av felaktigt angiven tid lyckades</p>";
        }
        else {
            $retur .="<p class='error'>Kontroll av felaktigt angiven tid misslyckades<br>"
            . $numFel . " stycken fel returnerades istället för förväntat 1</p>";
        }

        $postData=["time"=>"09:00"
            , "date"=>"2024-01-01"
            , "activityId"=>"$aktivitetId"];
        $svar=kontrolleraIndata($postData);
        $numFel=count($svar);
        if($numFel===1) {
            $retur .="<p class='ok'>Kontroll av tid längre än 8 timmar lyckades</p>";
        }
        else {
            $retur .="<p class='error'>Kontroll av tid längre än 8 timmar misslyckades<br>"
            . $numFel . " stycken fel returnerades istället för förväntat 1</p>";
        }

        //Kontrollera att rätt indata fungerar
        $postData=["time"=>"01:00"
            , "date"=>"2024-01-01"
            , "activityId"=>"$aktivitetId"];
        $svar=kontrolleraIndata($postData);
        $numFel=count($svar);
        if($numFel===0) {
            $retur .="<p class='ok'>Kontroll av rätt indata lyckades</p>";
        }
        else {
            $retur .="<p class='error'>Kontroll av rätt indata misslyckades<br>"
            . $numFel . " stycken fel returnerades istället för förväntat 1</p>";
        }

        //Kontrollera aktivitetId
        rsort($aktiviteter);
        $aktivitetId=$aktiviteter[0]->id+1;
        $postData=["time"=>"01:00"
            , "date"=>"2024-01-01"
            , "activityId"=>"$aktivitetId"];
        $svar=kontrolleraIndata($postData);
        $numFel=count($svar);
        if($numFel===1) {
            $retur .="<p class='ok'>Kontroll av id som inte finns lyckades</p>";
        }
        else {
            $retur .="<p class='error'>Kontroll av id som inte finns misslyckades<br>"
            . $numFel . " stycken fel returnerades istället för förväntat 1</p>";
        }

    } catch (Exception $ex) {
        $retur .= "<p class='error'>Något gick fel, meddelandet säger:<br> {$ex->getMessage()}</p>";
    }

    return $retur;
}

/**
 * Test för funktionen radera uppgift
 * @return string html-sträng med alla resultat för testerna
 */
function test_RaderaUppgift(): string {
    $retur = "<h2>test_RaderaUppgift</h2>";

    try {
        $retur .= "<p class='error'>Inga tester implementerade</p>";
    } catch (Exception $ex) {
        $retur .= "<p class='error'>Något gick fel, meddelandet säger:<br> {$ex->getMessage()}</p>";
    }

    return $retur;
}
