<?php

/**
 * Sodapop, a simple key-value database in PHP
 *
 * @author eurekasfray
 * @copyright Copyright (c) 2016 eurekasfray
 */

namespace Sodapop;

class Sodapop
{
    /**
     * @const EMPTY_OBJECT An empty json object.
     */
    const EMPTY_OBJECT = "{}";
     
    /**
     * @var An model of the database file.
     */
    private $model;
    
    /**
     * @var Path to the database file.
     */
    private $path;
    
    /**
     * @var Password to the database file.
     */
    //private $password;
    
    /**
     * @var Indicates that database file is secure.
     */
    //private $secure;

    /**
     * ...
     */
    public function __construct($model, $path)
    {
        $this->setModel($model);
        $this->setPath($path);
    }
    
    /**
     * Set model.
     */
    public function setModel($model)
    {   
        $this->model = $model;
    }
    
    /**
     * Get model.
     *
     * @return The model.
     */
    public function getModel()
    {
        return $this->model;
    }
    
    /*
     * Set path.
     */
    public function setPath($path)
    {   
        $this->path = $path;
    }
    
    /*
     * Get path.
     */
    public function getPath()
    {
        return $this->path;
    }
    
    /*
     * Set password.
     */
    /*
    public function setPassword($password)
    {   
        $this->password = $password;
    }
    */
    
    /*
     * Set password.
     */
    /*
    public function getPassword()
    {
        return $this->password;
    }
    */
    
    /*
     * Set secure.
     */
    /*
    public function setSecure($secure)
    {   
        $this->secure = $secure;
    }
    */
    
    /*
     * Get secure.
     *
     * @return bool True if secured, false if unsecured.
     */
    /*
    public function secure()
    {
        return $this->secure;
    }
    */
    
    /*
     * Load unsecure database from a file. If database file doesn't exist, create one.
     *
     * @param string $path Path of the database file.
     *
     * @return mixed Returns a database object. FALSE is returned if the json couldn't be decoded.
     */
    public static function load($path)
    {
        if (!file_exists($path)) {
            file_put_contents($path, self::EMPTY_OBJECT);
        }
        $json = file_get_contents($path);
        $model = json_decode($json, true);
        if ($model === null) {
            return false;
        }
        else {
            $db = new \Sodapop\Sodapop($model, $path);
            //$db->setSecure(false);
            return $db;
        }
    }
    
    /*
     * Load secure database from a file.
     *
     * @param string $path Path of the database file.
     * @return mixed A database object, else false if file doesn't exist.
     */
    /*
    public static function loads($path, $password)
    {
        if (!file_exists($path)) {
            return false;
        }
        $encryptedContent = file_get_contents($path);
        $json = self::_decrypt($encryptedContent, $password);
        $model = json_decode($json, true);
        $db = new \Sodapop\Sodapop($model, $path);
        $db->setSecure(true);
        return $db;
    }
    */
    
    /*
     * Create new unsecure database file.
     *
     * @param string Path of the new database file.
     * @param string Password.
     * @return mixed Successfully created database file.
     */
    /*
    public static function create($path)
    {
        if (file_exists($path)) {
            return false;
        }
        $content = self::EMPTY_OBJECT; // an empty object
        file_put_contents($path, $content);
        return true;
    }
    */
    
    /*
     * Create new secure database file.
     *
     * @param string Path of the new database file.
     * @param string Password.
     * @return mixed Successfully created database file.
     */
    /*
    public static function creates($path, $password)
    {
        if (file_exists($path)) {
            return false;
        }
        $content = self::EMPTY_OBJECT; // an empty object
        $encryptedContent = self::_encrypt($content, $password);
        file_put_contents($path, $encryptedContent);
        return true;
    }
    */    
    
    /*
     * Save unsecure the database model to the file specified in load
     *
     * @return bool TRUE is returned if the model was successfully dumped. FALSE is returned if the model could not be dumped.
     */
    public function dump()
    {
        /*
        if ($this->secured()) {
            return false;
        }
        else { */
            $path = $this->getPath();
            $model = $this->getModel();
            $json = json_encode($model, JSON_FORCE_OBJECT);
            if ($json === null) {
                return false;
            }
            else {
                file_put_contents($path, $json);
                return true;
            }
        /*
        }
        */
    }
    
    /*
    // Save secure database to file specified in load
    public function dumps()
    {
        $path = $this->getPath();
        $model = $this->getModel();
        $password = $this->getPassword();
        $json = json_encode($model, JSON_FORCE_OBJECT);
        $encryptedContent = self::_encrypt($json, $password);
        file_put_contents($path, $encryptedContent);
        return true;
    }
    */
    
    /*
     * Delete everything from the database.
     */
    public function drop()
    {
        $path = $this->getPath();
        $model = self::EMPTY_OBJECT;
        $json = json_encode($model, JSON_FORCE_OBJECT);
        file_put_contents($path, $json);
        return true;
    }
    
    /*
    private static function _encrypt($text, $pass)
    {
        //return openssl_encrypt($string, "aes128", $password);
        $result = self::_xorph($text, md5($pass));
        $result = base64_encode($result);
        return $result;
    }
    */
    
    /*
    private static function _decrypt($text, $pass)
    {
        //return openssl_decrypt($string, "aes128", $password);
        $text = base64_decode($text);
        $result = self::_xorph($text, md5($pass));
        return $result;
    }
    */
    
    /*
     * Xorph - XOR ciPHer.
     */    
    /*
    private static function _xorph($text, $pass)
    {
        $result = "";
        for ($i = 0; $i < strlen($text); ) {
            for ($j = 0; $j < strlen($pass) && $i < strlen($text); $j++, $i++) {
                $result .= $text{$i} ^ $pass{$j};
            }
        }
        return $result;
    }
    */
    
    /*
     * Set the value of a key.
     *
     * @param key ...
     * @param value ...
     *
     * @return bool true if successful, false on error
     */
    public function set($key, $value)
    {
        $model = $this->getModel();
        $model[$key] = $value;
        $this->setModel($model);
        $this->dump();
    }
    
    /*
     * Append a value to a key.
     */
    public function append($key, $value)
    {
        $model = $this->getModel();
        $model[$key] .= $value;
        $this->setModel($model);
        $this->dump();
    }
    
    // Get the value of a key
    public function get($key)
    {
        $model = $this->getModel();
        return $model[$key];
    }
    
    /*
     * Get all the keys in the database.
     */
    public function keys()
    {
        $model = $this->getModel();
        $keys = array();
        foreach ($model as $index=>$value) {
            $keys[] = $index;
        }
        return $keys;
    }
    
    /*
     * Delete a key.
     */
    public function rem($key)
    {
    }
    
    // Increment the integer value of a key by one.
    // @return bool True on success, False on failure
    public function incr($key)
    {
        return $this->incrby($key, 1);
    }
    
    // Increment the integer value of a key by the given amount.
    public function incrby($key, $increment)
    {
        $model = $this->getModel();
        if (is_int(intval($model[$key]))) {
            $model[$key] = intval($model[$key]) + $increment;
            $this->setModel($model);
            $this->dump();
            return true;
        }
        return false;
    }
    
    // Decrement the integer value of a key by one.
    public function decr($key)
    {
        return $this->incrby($key, -1);
    }
    
    // Decrement the integer value of a key by the given amount.
    public function decrby($key, $decrement)
    {
        return $this->incrby($key, ($decrement*-1));
    }
    
    /*
     * Determine if key exists.
     *
     * @return bool TRUE if exists, otherwise false.
     */
    public function exists($key)
    {
        $model = $this->getModel();
        foreach ($model as $index=>$value) {
            if ($key == $index) {
                return true;
            }
        }
        return false;
    }
    
    // Add one or more key-value pairs to a dictionary.
    public function dset($key, $pairs)
    {
        $model = $this->getModel();
        foreach ($pairs as $field=>$value) {
            $model[$key][$field] = $value;
        }
        $this->setModel($model);
        $this->dump();
        return true;
    }
    
    // Return the value for a field in a dictionary.
    public function dget($key, $field)
    {
        $model = $this->getModel();
        return $model[$key][$field];
    }
    
    // Get all the fields and values in a dictionary.
    public function dgetall($key)
    {
        $model = $this->getModel();
        return $model[$name];
    }
    
    /*
     * Delete a field and value in a dictionary.
     */
    public function drem()
    {
    }
    
    // Get all the fields in a dictionary.
    public function dkeys($key)
    {
        $model = $this->getModel();
        $fields = array();
        foreach ($model[$key] as $field=>$value) {
            $fields[] = $field;
        }
        return $fields;
    }
    
    // Get all the values in a dictionary.
    public function dvals($key)
    {
        $model = $this->getModel();
        $values = array();
        foreach ($model[$key] as $field=>$value) {
            $values[] = $value;
        }
        return $values;
    }
    
    /*
     * Determine if field exists in a dictionary.
     */
    public function dexists($key, $queriedfield)
    {
        $model = $this->getModel();
        foreach ($model[$key] as $currentField=>$value) {
            if ($currentField === $queriedfield) {
                return true;
            }
        }
        return false;
    }
    
    /*
     * Get the number of fields in a dictionary.
     */
    public function dlen($key)
    {
        $model = $this->getModel();
        $len = count($model[$key]);
        return $len;
    }
}