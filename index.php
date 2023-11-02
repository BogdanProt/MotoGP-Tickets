<!DOCTYPE html>
<html>
<head>
    <title>Descriere Aplicație - Rezervare Bilete la Cursele MotoGP</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <header>
        <h1>Rezervare Bilete la Cursele MotoGP</h1>
    </header>

    <section class="description">
        <h2>Proiectarea Arhitecturii</h2>
        <p>
            Pentru a proiecta arhitectura aplicației noastre de rezervare de bilete la cursele MotoGP, 
            am identificat rolurile, entitățile și procesele specifice aplicației, precum și relațiile dintre acestea. 
            Avem următoarele entități principale: Utilizatori, Curse și Rezervări. Utilizatorii se pot înregistra și autentifica, 
            pot vizualiza cursele disponibile și pot face rezervări. Administratorii au acces la un panou de administrare pentru gestionarea informațiilor.
        </p>
        <p>
            <h4>Roluri</h4>
            <ul>
                <li>Utilizatori: cei ce doresc sa rezerve bilete la cursele MotoGP</li>
                <li>Administratori: cei care administreaza informatiile despre curse, bilete si utilizatori</li>
            </ul>
        </p>
        <p>
            <h4>Entitati</h4>
            <ul>
                <li>Utilizatori: pentru a gestiona informatii despre utilizatori</li>
                <li>Curse: pentru a stoca informatii despre curse</li>
                <li>Rezervari: pentru a tine evidenta rezervarilor facute de utilizatori</li>
            </ul>
        </p>
        <p>
        <h4>Procese specifice</h4>
            <ul>
                <li>Inregistrarea utilizatorilor</li>
                <li>Autentificarea utilizatorilor</li>
                <li>Vizualizarea curselor disponibile</li>
                <li>Rezervarea biletelor</li>
            </ul>
        </p>
        <p>
            <h4>Relatii</h4>
            <ul>
                <li>Un utilizator poate avea mai multe rezervari</li>
                <li>Fiecare rezervare este legata de o anumita cursa</li>
            </ul>
        </p>
    </section>

    <section class="description">
        <h2>Baza de Date</h2>
        <p>
            Pentru a stoca si gestiona datele, voi folosi o baza de date MySQL. Aceasta
            ar putea include urmatoarele tabele:
            <ul>
                <li>Tabela "Utilizator" - pentru a stoca informatii despre utilizatori</li>
                <li>Tabela "Cursa" - pentru a stoca informatii despre cursele disponibile</li>
                <li>Tabela "Rezervare" - pentru a stoca informatii despre rezervare, cum ar fi id-ul
                    utilizatorului, id-ul cursei si numarul de bilete rezervate
                </li>
            </ul>
        </p>
    </section>

    <section class="description">
        <h2>Soluția de Implementare</h2>
        <p>
            Pentru implementarea aplicatiei, ma voi folosi de mai multe elemente.
            <ul>
                <li>Inregistrare</li>
                <p>
                    Utilizatorii vor completa un formular de inregistrare cu datele personale, care vor fi validate si stocate 
                    in tabela "Utilizator"
                </p>
                <li>Autentificare</li>
                <p>
                    Dupa inregistrare, utilizatorii se pot autentifica cu numele de utilizator si parola pentru a accesa
                    functionalitatile aplicatiei
                </p>
                <li>Afisaj curse</li>
                <p>
                    Utilizatorii autentificati vor putea vedea informatii despre cursele din tabela "Cursa"
                </p>
                <li>Rezervarea biletelor</li>
                <p>
                    Utilizatorii vor putea alege o cursa si numarul de bilete pe care doresc sa le rezerve. Informatiile rezervarii vor fi stocate 
                    in tabela "Rezervare"
                </p>
                <li>Formular de contact</li>
                <p>
                    Punerea la dispozitie a unui formular de contact in cazul aparitiei anumitor probleme legate de aplicatie
                </p>
            </ul>
        </p>
    </section>
</body>
</html>
