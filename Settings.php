<?php
/**
 * Created by PhpStorm.
 * User: Benji
 * Date: 2016-08-19
 * Time: 01:15
 */
class Settings {


    /**
     * The app session name allows different apps on the same webhotel to share a virtual session
     */
    const APP_SESSION_NAME = "StickGame";

    /**
     * Username of default user
     */
    const USERNAME = "admin";

    /**
     * Password of default user
     */
    const PASSWORD = "password";

    /**
     * Path to folder writable by www-data but not accessable by webserver
     */
    const DATAPATH = "./";

    /**
     * Salt for creating temporary passwords
     * Should be a random string like "feje3-#GS"
     */
    const SALT = "";

    /**
     * Show errors
     * boolean true | false
     */
    const DISPLAY_ERRORS = true;
}