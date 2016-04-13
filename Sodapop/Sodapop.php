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
     * @var An array model of the database file.
     */
    private $model;
    
    /**
     * @var Path to the database file.
     */
    private $path;

    /**
     * Initialize database object.
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
    
    /**
     * Set path.
     */
    public function setPath($path)
    {   
        $this->path = $path;
    }
    
    /**
     * Get path.
     */
    public function getPath()
    {
        return $this->path;
    }
    
    /**
     * Load the database from a file. If the database file doesn't exist, create one.
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
            return $db;
        }
    }
    
    /**
     * Save the database model to the file specified in load
     *
     * @return bool TRUE is returned if the model was successfully dumped. FALSE is returned if the model could not be dumped.
     */
    public function dump()
    {
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
    }
    
    /**
     * Delete everything from the database.
     */
    public function drop()
    {
        $path = $this->getPath();
        $model = self::EMPTY_OBJECT;
        $json = json_encode($model, JSON_FORCE_OBJECT);
        if ($json === null) {
            return false;
        }
        else {
            file_put_contents($path, $json);
            return true;
        }
    }
    
    /**
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
    
    /**
     * Append a value to a key.
     */
    public function append($key, $value)
    {
        $model = $this->getModel();
        $model[$key] .= $value;
        $this->setModel($model);
        $this->dump();
    }
    
    /**
     * Get the value of a key.
     */
    public function get($key)
    {
        $model = $this->getModel();
        return $model[$key];
    }
    
    /**
     * Get all the keys and values in the database.
     */
    public function getall()
    {
        $model = $this->getModel();
        return $model;
    }
    
    /**
     * Get all the keys in the database.
     */
    public function keys()
    {
        $model = $this->getModel();
        $keys = array();
        foreach ($model as $key=>$value) {
            $keys[] = $key;
        }
        return $keys;
    }
    
    /**
     * Delete a key.
     */
    public function rem($key)
    {
    }
    
    /**
     * Increment the integer value of a key by one.
     *
     * @return bool Returns TRUE if integer value was successfully incremented. FALSE is returned otherwise.
     */
    public function incr($key)
    {
        return $this->incrby($key, 1);
    }
    
    /**
     * Increment the integer value of a key by the given amount.
     *
     * @return bool Returns TRUE if integer value was successfully incremented. FALSE is returned otherwise.
     */
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
    
    /**
     * Decrement the integer value of a key by one.
     */
    public function decr($key)
    {
        return $this->incrby($key, -1);
    }
    
    /**
     * Decrement the integer value of a key by the given amount.
     */
    public function decrby($key, $decrement)
    {
        return $this->incrby($key, ($decrement * -1));
    }
    
    /**
     * Determine if key exists.
     *
     * @return bool TRUE if exists, otherwise false.
     */
    public function exists($key)
    {
        $model = $this->getModel();
        foreach ($model as $currentKey=>$value) {
            if ($currentKey === $key) {
                return true;
            }
        }
        return false;
    }
    
    /**
     * Add multiple valuess to multiple fields in a dictionary.
     */
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
    
    /**
     * Return the value for a field in a dictionary.
     */
    public function dget($key, $field)
    {
        $model = $this->getModel();
        return $model[$key][$field];
    }
    
    /**
     * Get all the fields and values in a dictionary.
     */
    public function dgetall($key)
    {
        $model = $this->getModel();
        return $model[$name];
    }
    
    /**
     * Delete a field and value in a dictionary.
     */
    public function drem()
    {
    }
    
    /**
     * Get all the fields in a dictionary.
     */
    public function dkeys($key)
    {
        $model = $this->getModel();
        $fields = array();
        foreach ($model[$key] as $field=>$value) {
            $fields[] = $field;
        }
        return $fields;
    }
    
    /**
     * Get all the values in a dictionary.
     */
    public function dvals($key)
    {
        $model = $this->getModel();
        $values = array();
        foreach ($model[$key] as $field=>$value) {
            $values[] = $value;
        }
        return $values;
    }
    
    /**
     * Determine if field exists in a dictionary.
     */
    public function dexists($key, $field)
    {
        $model = $this->getModel();
        foreach ($model[$key] as $currentField=>$value) {
            if ($currentField === $field) {
                return true;
            }
        }
        return false;
    }
    
    /**
     * Get the number of fields in a dictionary.
     */
    public function dlen($key)
    {
        $model = $this->getModel();
        $len = count($model[$key]);
        return $len;
    }
}