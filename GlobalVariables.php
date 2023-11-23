<?php

class GlobalVariables
{
    public static $inventaireDAO;
    public static $monstreDAO;
    public static $personnageDAO;
    public static $salleDAO;

    public static function init($bdd)
    {
        self::$inventaireDAO = new InventaireDAO($bdd);
        self::$monstreDAO = new MonstreDAO($bdd);
        self::$personnageDAO = new PersonnageDAO($bdd);
        self::$salleDAO = new SalleDAO($bdd);
    }
}
