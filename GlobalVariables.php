<?php

class GlobalVariables
{
    public static $armeDAO;
    public static $inventaireDAO;
    public static $monstreDAO;
    public static $objetMagiqueDAO;
    public static $personnageDAO;
    public static $salleDAO;

    public static function init($bdd)
    {
        self::$armeDAO = new ArmeDAO($bdd);
        self::$inventaireDAO = new InventaireDAO($bdd);
        self::$monstreDAO = new MonstreDAO($bdd);
        self::$objetMagiqueDAO = new ObjetMagiqueDAO($bdd);
        self::$personnageDAO = new PersonnageDAO($bdd);
        self::$salleDAO = new SalleDAO($bdd);
    }
}
