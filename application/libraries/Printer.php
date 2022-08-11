<?php
defined('BASEPATH') or exit('No direct script access allowed');


/**
 * Printer encapsulation, for use with CodeIgniter\Model
 */
class Printer
{

    /**
     * Holds the current values of all class vars.
     *
     * @var array
     */
    protected $attributes = [];

    /**
     * Allows filling in Printer parameters during construction.
     */
    public function __construct(?array $data = null, bool $defineInitialDates = false)
    {
        $this->fill($data);

        if($defineInitialDates){

            $this->defineInitialDates();
        }
    }


    /**
     * Takes an array of key/value pairs and sets them as class
     * properties, using any `setCamelCasedProperty()` methods
     * that may or may not exist.
     *
     * @param array $data
     *
     * @return $this
     */
    public function fill(?array $data = null)
    {
        if (!is_array($data)) {
            return $this;
        }

        foreach ($data as $key => $value) {
            $this->__set($key, $value);
        }

        return $this;
    }

    /**
     * General method that will return all public and protected values
     * of this entity as an array.
     *
     * @return array
     */
    public function toArray(): array
    {

        $keys = array_filter(array_keys($this->attributes), static function ($key) {
            return strpos($key, '_') !== 0;
        });

        $return = [];

        // Loop over the properties, to allow magic methods to do their thing.
        foreach ($keys as $key) {

            $return[$key] = $this->__get($key);
        }

        return $return;
    }

    /**
     * Magic method to all protected/private class properties to be
     * easily set, either through a direct access or a
     * `setCamelCasedProperty()` method.
     *
     * Examples:
     *  $this->my_property = $p;
     *  $this->setMyProperty() = $p;
     *
     * @param mixed|null $value
     *
     * @throws Exception
     *
     * @return $this
     */
    public function __set(string $key, $value)
    {
        // if a set* method exists for this key, use that method to
        // insert this value. should be outside $isNullable check,
        // so maybe wants to do sth with null value automatically
        $method = 'set' . str_replace(' ', '', ucwords(str_replace(['-', '_'], ' ', $key)));

        if (method_exists($this, $method)) {
            $this->{$method}($value);

            return $this;
        }

        // Otherwise, just the value. This allows for creation of new
        // class properties that are undefined, though they cannot be
        // saved. Useful for grabbing values through joins, assigning
        // relationships, etc.
        $this->attributes[$key] = $value;

        return $this;
    }

    /**
     * Magic method to allow retrieval of protected and private class properties
     * either by their name, or through a `getCamelCasedProperty()` method.
     *
     * Examples:
     *  $p = $this->my_property
     *  $p = $this->getMyProperty()
     *
     * @throws Exception
     *
     * @return mixed
     */
    public function __get(string $key)
    {
        $result = null;

        // Convert to CamelCase for the method
        $method = 'get' . str_replace(' ', '', ucwords(str_replace(['-', '_'], ' ', $key)));

        // if a set* method exists for this key,
        // use that method to insert this value.
        if (method_exists($this, $method)) {
            $result = $this->{$method}();
        }

        // return the protected property if it exists.
        if (array_key_exists($key, $this->attributes)) {
            $result = $this->attributes[$key];
        }

        return $result;
    }

    /**
     * Returns true if a property exists names $key, or a getter method
     * exists named like for __get().
     */
    public function __isset(string $key): bool
    {
        $method = 'get' . str_replace(' ', '', ucwords(str_replace(['-', '_'], ' ', $key)));

        if (method_exists($this, $method)) {
            return true;
        }

        return isset($this->attributes[$key]);
    }

    /**
     * Unsets an attribute property.
     */
    public function __unset(string $key): void
    {
        unset($this->attributes[$key]);
    }

    /**
     * Sets datetime values. Typically used when creating the printer.
     *
     * @return void
     */
    public function defineInitialDates(){

        $this->attributes['created_at'] = date('Y-m-d H:i:s');
        $this->setUpdatedAt();
    }

    /**
     * Sets the value of the datetime field 'updated_at'
     *
     * @return void
     */
    public function setUpdatedAt(){

        $this->attributes['updated_at'] = date('Y-m-d H:i:s');
    }
}
