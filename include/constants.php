<?php
define("DB_SERVER", "localhost");
define("DB_USER", "root");
define("DB_PASS", "");
define("DB_NAME", "isppoliklinika");

define("TBL_USERS", "naudotojas");
define("TBL_PATIENTS", "pacientas");
define("TBL_DOCTORS", "gydytojas");

define('TBL_REPORTS', 'ataskaita');
define('TBL_FEEDBACK', 'atsiliepimas');
define('TBL_INVENTORY', 'inventorius');
define('TBL_MEDICINE', 'vaistas');
define('TBL_CONSULTATION', 'konsultacija');
define('TBL_APPOINTMENT', 'siuntimas');
define('TBL_EXAMINATION', 'tyrimas');
define('TBL_ORDER', 'uzsakymas');

define("ADMIN_NAME", "Administratorius");
define("DOCTOR_NAME", "Daktaras");
define("PATIENT_NAME", "Pacientas");
define("USER_NAME", "Naudotojas");
define("GUEST_NAME", "Svečias");

define("USER_TIMEOUT", 10);
define("GUEST_TIMEOUT", 5);

define("COOKIE_EXPIRE", 60 * 60 * 24 * 100);  //100 days by default
define("COOKIE_PATH", "/");  //Avaible in whole domain

define("EMAIL_FROM_NAME", "Demo");
define("EMAIL_FROM_ADDR", "demo@ktu.lt");
define("EMAIL_WELCOME", false);

define("ALL_LOWERCASE", false);
?>