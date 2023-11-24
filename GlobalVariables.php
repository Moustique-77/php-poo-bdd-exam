<?php

class GlobalVariables
{
    public static $armeDAO;
    public static $inventaireDAO;
    public static $monstreDAO;
    public static $personnageDAO;
    public static $salleDAO;
    public static $marchandDAO;
    public static $objetDAO;

    public static function init($bdd)
    {
        self::$armeDAO = new ArmeDAO($bdd);
        self::$inventaireDAO = new InventaireDAO($bdd);
        self::$monstreDAO = new MonstreDAO($bdd);
        self::$personnageDAO = new PersonnageDAO($bdd);
        self::$salleDAO = new SalleDAO($bdd);
        self::$marchandDAO = new MarchandDAO($bdd);
        self::$objetDAO = new ObjetDAO($bdd);
    }
}
