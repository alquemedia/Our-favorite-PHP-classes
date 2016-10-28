<?php namespace Alquemedia_Favorites\Arrays;

/**
 * Class Array_Representable_Object
 * @package Alquemedia_Favorites\Arrays
 *
 * Extend this class to represent any set of data as an array.
 */
class Array_Representable_Object {

    /**
     * @var array values that can represent the object
     */
    protected $array_values = array();

    /**
     * @var string pre-hook for as array, which you can use to modify members
     * just before they are returned
     */
    private $as_array_pre_hook = '';

    /**
     * @param array $exclusions to remove from array
     * @return array of resulting values
     */
    public function as_array( array $exclusions = array() ){

        $hook = $this->as_array_pre_hook;

        // Hook allows modification of members just before being returned
        if ( method_exists($this, $hook)) $this->$hook($exclusions);

        $values = $this->array_values;

        foreach ( $exclusions as $exclude ) unset( $values[$exclude]);

        return $values;

    }

    /**
     * @param string $hook to set
     */
    protected function set_pre_hook( $hook ){

        $this->as_array_pre_hook = $hook;

    }

    /**
     * Allows me to set members directly, without referencing the array
     * @param string $member
     * @param mixed $value
     */
    public function __set( $member, $value ){

        $this->array_values[ $member ] = $value;

    }

    /**
     * @param array $values
     * @return $this
     */
    public function set_values( array $values ){

        foreach ( $values as $name => $value )

            $this->$name = $value;

        return $this;

    }

    /**
     * Convenience method to fetch a member
     * @param $what
     * @return null
     */
    public function __get( $what ){

        return isset( $this->array_values[$what])? $this->array_values[$what]: null;

    }

    /**
     * @return string representation of Object
     */
    public function __toString(){

        $interior_part = '';

        foreach ( $this->array_values as $name => $value )

            $interior_part .= $interior_part ? ", $name = $value":"$name = $value";

        return "array($interior_part)";

    }


}